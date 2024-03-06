<?php
/**
*
* @package User Reminder v1.7.1
* @copyright (c) 2019 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\cron\task;

class mot_ur_reminder_cron extends \phpbb\cron\task\base
{
	/** @var \mot\userreminder\common */
	protected $common;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\log\log $log */
	protected $log;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB phpbb root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $phpEx;

	/** @var string mot.userreminder.tables.mot_userreminder_remind_queue */
	protected $mot_userreminder_remind_queue;

	/**
	 * {@inheritdoc
	 */
	public function __construct(\mot\userreminder\common $common, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db,
								\phpbb\log\log $log, \phpbb\user $user, $root_path, $phpEx, $mot_userreminder_remind_queue)
	{
		$this->common = $common;
		$this->config = $config;
		$this->db = $db;
		$this->log = $log;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->phpEx = $phpEx;
		$this->mot_userreminder_remind_queue = $mot_userreminder_remind_queue;
	}


	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		$this->remind_queue();
		$this->config->set('mot_ur_mail_limit_time_last_gc', time());
	}

	/**
	* Returns whether this cron task can run, given current board configuration.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		return true;
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* The interval between topics tidying is specified in extension
	* configuration.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['mot_ur_mail_limit_time_last_gc'] < time() - $this->config['mot_ur_mail_limit_time_gc'];
	}

/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

	private function remind_queue()
	{
		// We start a new time frame so we can assume the number of available mails is the limit
		$mail_available = $this->config['mot_ur_mail_limit_number'];

		// Get the number of users from the queue table for which we have a mail contingent
		$sql = "SELECT * FROM " . $this->mot_userreminder_remind_queue . "
				ORDER BY 'mot_last_login' ASC";
		$result = $this->db->sql_query_limit($sql, $mail_available);
		$users_in_queue = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		if (!empty($users_in_queue))
		{
			// since we have at least one user to remind we check for messenger class, include it if necessary and construct an instance
			if (!class_exists('\messenger'))
			{
				include($this->root_path . 'includes/functions_messenger.' . $this->phpEx);
			}
			$messenger = new \messenger(false);

			$sleeper_reminders_ary = [];
			$sleeper_username_ary = [];
			$second_reminders_ary = [];
			$second_username_ary = [];
			$first_reminders_ary = [];
			$first_username_ary = [];

			$now = time();

			foreach ($users_in_queue as $row)
			{
				// Send the reminder mail
				$this->common->reminder_mail($row, $messenger, $row['remind_type']);

				// Add this user's id and name to the respective array for later logging
				switch ($row['remind_type'])
				{
					case 'reminder_sleeper':
						$sleeper_reminders_ary[] = $row['user_id'];
						$sleeper_username_ary[] = $row['username'];
					break;

					case 'reminder_two':
						$second_reminders_ary[] = $row['user_id'];
						$second_username_ary[] = $row['username'];
					break;

					case 'reminder_one':
						$first_reminders_ary[] = $row['user_id'];
						$first_username_ary[] = $row['username'];
					break;
				}

				// Decrement the number of available mails and check whether the contingent is fully used
				--$mail_available;
				if ($mail_available <= 0)
				{
					break;	// Leave the foreach loop if no more mails are available
				}
			}

			// If any sleepers have been reminded set the actual reminder time and log this action
			if (!empty($sleeper_reminders_ary))
			{
				$sql_ary = [
					'mot_sleeper_remind'	=>	$now,
				];

				$sql = 'UPDATE ' . USERS_TABLE . '
						SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE ' . $this->db->sql_in_set('user_id', $sleeper_reminders_ary);
				$this->db->sql_query($sql);

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_SLEEPER_REMIND', false, [implode(', ', $sleeper_username_ary)]);
			}

			// If any sleepers have been reminded set the actual reminder time and log this action
			if (!empty($second_reminders_ary))
			{
				$sql_ary = [
					'mot_reminded_two'	=>	$now,
				];

				$sql = 'UPDATE ' . USERS_TABLE . '
						SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE ' . $this->db->sql_in_set('user_id', $second_reminders_ary);
				$this->db->sql_query($sql);

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_INACTIVE_REMIND_TWO', false, [implode(', ', $second_username_ary)]);
			}

			// Now let's do this for the first reminders if any have been sent
			if (!empty($first_reminders_ary))
			{
				$sql = 'UPDATE ' . USERS_TABLE . ' SET mot_reminded_one = ' . (int) $now;

				if ($this->config['mot_ur_days_reminded'] == 0)		// if the admin selected to have only one reminder by setting this time frame to Zero ...
				{
					$sql .= ', mot_reminded_two = ' . $now;		// ... we have to set this column too to enable deletion
				}

				$sql .= ' WHERE ' . $this->db->sql_in_set('user_id', $first_reminders_ary);
				$this->db->sql_query($sql);

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_INACTIVE_REMIND_ONE', false, [implode(', ', $first_username_ary)]);
			}

			// All users who have been notified must be deleted from the reminder_queue table
			$reminders_arr = array_merge($second_reminders_ary, $first_reminders_ary, $sleeper_reminders_ary);
			$sql = 'DELETE FROM ' . $this->mot_userreminder_remind_queue . '
					WHERE ' . $this->db->sql_in_set('user_id', $reminders_arr);
			$this->db->sql_query($sql);
		}

		// finished with reminding (or there is nobody to be reminded), now set the config variable to the remaining number of e-mails so common.php knows how to handle users to be reminded
		$this->config->set('mot_ur_mail_available', $mail_available);
	}

}
