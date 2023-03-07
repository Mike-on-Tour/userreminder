<?php
/**
*
* @package UserReminder v1.7.0
* @copyright (c) 2019 - 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface
{

	public static function getSubscribedEvents()
	{
		return [
			'core.delete_user_before'		=> 'check_for_protected_member',
			'core.session_create_after'		=> 'check_user_login',
			'core.modify_email_headers'		=> 'delete_replyto',
		];
	}

	const SECS_PER_DAY = 86400;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \mot\userreminder\common */
	protected $common;

	/** @var string mot.userreminder.tables.mot_userreminder_remind_queue */
	protected $mot_userreminder_remind_queue;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config $config   Config object
	 * @param \phpbb\db\driver\driver_interface $db	Database object
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \mot\userreminder\common $common,
								$mot_userreminder_remind_queue)
	{
		$this->config = $config;
		$this->db = $db;
		$this->common = $common;
		$this->mot_userreminder_remind_queue = $mot_userreminder_remind_queue;
	}


	/**
	* Check whether a user to be deleted (no matter from where and by whomsoever) is part of the protected members array. If he is, delete this user from the array as well
	*
	* @param array	$event	containing:
	*	@var string		mode				Mode of posts deletion (retain|delete)
	*	@var array		user_ids			ID(s) of the user(s) bound to be deleted
	*	@var bool		retain_username		True if username should be retained, false otherwise
	*	@var array		user_rows			Array containing data of the user(s) bound to be deleted (since 3.2.4-RC1)
	*
	*/
	public function check_for_protected_member($event)
	{
		foreach ($event['user_ids'] as $element)
		{
			$protected_users = json_decode($this->config['mot_ur_protected_members']);
			$key = array_search($element, $protected_users);
			if ($key !== false)
			{
				array_splice($protected_users, $key, 1);
				$this->config->set('mot_ur_protected_members', json_encode($protected_users));
			}
		}
	}


	/**
	* Set the reminding times to Zero every time a user logs into the forum in order to delete any reminders in case this user has been reminded and logs on again.
	* In addition we set the value of "mot_last_login" to the timestamp the user logged in to make sure that there is no gap in which this "newborn" user gets reminded again.
	* Check if this user is part of the reminder queue and if he is delete him from the queue since he logged in is no linger to be reminded
	* If in automatic mode check for users in need of being reminded or deleted
	*
	* @param session_data
	* 	Array[session_user_id, session_start, session_last_visit, session_time, session_browser, session_forwarded_for, session_ip, session_autologin, session_admin, session_viewonline,
	*		session_page, session_forum_id, session_id]
	*
	*/
	public function check_user_login($event)
	{
		/*
		* First we set the times of first, second and sleeper reminder to Zero to flag this user as active again in order to delete any reminders this user might have got
		*/

		$session_data = $event['session_data'];
		if ($session_data['session_user_id'] > 1)		// avoid updating the guest account (user_id == 1 when logging off)
		{
			// we set the current time variable first
			$now = time();

			$sql_ary = [
				'mot_reminded_one'		=> 0,
				'mot_reminded_two'		=> 0,
				'mot_last_login'		=> $now,
				'mot_sleeper_remind'	=> 0,
			];

			$sql = 'UPDATE ' . USERS_TABLE . '
					SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE user_id = ' . (int) $session_data['session_user_id'];
			$this->db->sql_query($sql);

			// Delete this user from the reminder queue in case he is listed there to prevent sending a reminder mail after this login
			$sql = 'DELETE FROM ' . $this->mot_userreminder_remind_queue . '
					WHERE user_id = ' . (int) $session_data['session_user_id'];
			$this->db->sql_query($sql);

			// Get the protected members and groups arrays
			$protected_members = json_decode($this->config['mot_ur_protected_members']);
			$protected_groups = json_decode($this->config['mot_ur_protected_groups']);

			// Get user_ids of banned members since we don't want to remind them (they wouldn't be able to log in anyway), they will be handled as protected members to prevent reminding (and deletion)
			$sql = 'SELECT ban_userid FROM ' . BANLIST_TABLE . '
					WHERE ban_userid <> 0';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$protected_members[] = $row['ban_userid'];
			}
			$this->db->sql_freeresult($result);

			/*
			* Now we check whether reminder mails should be sent automatically to inactive users and if yes we check what inactive users are supposed to get a reminding email
			*/
			if ($this->config['mot_ur_autoremind'] == 1)
			{
				$day_limit = $now - (self::SECS_PER_DAY * $this->config['mot_ur_inactive_days']);
				// ignore inactive users, anonymous (=== guest) and bots
				$sql = 'SELECT user_id FROM ' . USERS_TABLE . '
						WHERE ' . $this->db->sql_in_set('user_type', [USER_NORMAL,USER_FOUNDER]) . '
						AND mot_last_login > 0
						AND user_posts > 0
						AND ((mot_last_login <= ' . (int) $day_limit . ' AND mot_reminded_one = 0) ' .	// get all inactive users who have not been reminded yet
						'OR (mot_reminded_one > 0 AND mot_reminded_two = 0))';							// get all inactive users due for the second reminder
				$sql .= !empty($protected_members) ? ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true) : '';	// prevent sql errors due to empty arrays
				$sql .= !empty($protected_groups) ? ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true) : '';
				$sql .= ' ORDER BY user_id';

				$result = $this->db->sql_query($sql);
				$reminders = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				$marked = [];
				foreach ($reminders as $value)
				{
					$marked[] = $value['user_id'];
				}
				$this->common->remind_users($marked);
			}

			/*
			* Now we check whether inactive users should be deleted automatically and if yes we check what users are supposed to get deleted and do it
			*/
			if ($this->config['mot_ur_autodelete'] == 1)
			{
				$day_limit = $now - (self::SECS_PER_DAY * $this->config['mot_ur_days_until_deleted']);
				$marked_users = [];

				// get only users who have been reminded twice
				$sql = 'SELECT user_id FROM ' . USERS_TABLE . '
						WHERE ' . $this->db->sql_in_set('user_type', [USER_NORMAL, USER_FOUNDER]) . '
						AND user_posts > 0
						AND mot_reminded_two > 0
						AND mot_reminded_two <= ' . (int) $day_limit;			// get all users who have been inactive since the 2nd reminder for at least the number of days specified in settings
				$sql .= !empty($protected_members) ? ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true) : '';	// prevent sql errors due to empty arrays
				$sql .= !empty($protected_groups) ? ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true) : '';
				$sql .= ' ORDER BY user_id';

				$result = $this->db->sql_query($sql);
				$user_result = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);
				foreach ($user_result as $value)
				{
					$marked_users[] = $value['user_id'];
				}
				$this->common->delete_users($marked_users);
			}

			// And now check whether zeroposters have to be reminded and deleted as well
			if ($this->config['mot_ur_remind_zeroposter'] == 1)
			{
				/*
				* Now we check whether reminder mails should be sent automatically to zeroposters and if yes we check what zeroposters are supposed to get a reminding email
				*/
				if ($this->config['mot_ur_zp_autoremind'] == 1)
				{
					$day_limit = $now - (self::SECS_PER_DAY * $this->config['mot_ur_zp_inactive_days']);
					// ignore inactive users, anonymous (=== guest) and bots
					$sql = 'SELECT user_id FROM ' . USERS_TABLE . '
							WHERE ' . $this->db->sql_in_set('user_type', [USER_NORMAL,USER_FOUNDER]) . '
							AND mot_last_login > 0
							AND user_posts = 0
							AND ((mot_last_login <= ' . (int) $day_limit . ' AND mot_reminded_one = 0) ' .	// get all inactive users who have not been reminded yet
							'OR (mot_reminded_one > 0 AND mot_reminded_two = 0))';							// get all inactive users due for the second reminder
					$sql .= !empty($protected_members) ? ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true) : '';	// prevent sql errors due to empty arrays
					$sql .= !empty($protected_groups) ? ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true) : '';
					$sql .= ' ORDER BY user_id';

					$result = $this->db->sql_query($sql);
					$reminders = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					$marked = [];
					foreach ($reminders as $value)
					{
						$marked[] = $value['user_id'];
					}
					$this->common->remind_users($marked, true);
				}

				/*
				* Now we check whether zeroposters should be deleted automatically and if yes we check what users are supposed to get deleted and do it
				*/
				if ($this->config['mot_ur_zp_autodelete'] == 1)
				{
					$day_limit = $now - (self::SECS_PER_DAY * $this->config['mot_ur_zp_days_until_deleted']);
					$marked_users = [];

					// get only users who have been reminded twice
					$sql = 'SELECT user_id FROM ' . USERS_TABLE . '
							WHERE ' . $this->db->sql_in_set('user_type', [USER_NORMAL, USER_FOUNDER]) . '
							AND user_posts = 0
							AND mot_reminded_two > 0
							AND mot_reminded_two <= ' . (int) $day_limit;			// get all users who have been inactive since the 2nd reminder for at least the number of days specified in settings
					$sql .= !empty($protected_members) ? ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true) : '';	// prevent sql errors due to empty arrays
					$sql .= !empty($protected_groups) ? ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true) : '';
					$sql .= ' ORDER BY user_id';

					$result = $this->db->sql_query($sql);
					$user_result = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);
					foreach ($user_result as $value)
					{
						$marked_users[] = $value['user_id'];
					}
					$this->common->delete_users($marked_users);
				}
			}

			// Now we check whether sleepers are to be reminded and done so automatically and do it with all sleepers due for reminding
			$remind_sleepers = $this->config['mot_ur_remind_sleeper'];
			$autoremind_sleepers = $this->config['mot_ur_sleeper_autoremind'];
			$sleeper_remind_time = $now - ($this->config['mot_ur_sleeper_inactive_days'] * self::SECS_PER_DAY);
			if ($remind_sleepers && $autoremind_sleepers)
			{
				$sql = 'SELECT user_id
						FROM  ' . USERS_TABLE . '
						WHERE ' . $this->db->sql_in_set('user_type', [USER_NORMAL,USER_FOUNDER]) . '
						AND mot_last_login = 0
						AND user_regdate <= ' . $sleeper_remind_time . '
						AND mot_sleeper_remind = 0';
				if (!empty($protected_members))				// prevent sql errors due to empty array
				{
					$sql .= ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true);
				}
				if (!empty($protected_groups))
				{
					$sql .= ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true);
				}

				$result = $this->db->sql_query($sql);
				$sleepers = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				$marked_sleepers = [];
				foreach ($sleepers as $row)
				{
					$marked_sleepers[] = $row['user_id'];
				}
				$this->common->remind_sleepers($marked_sleepers);
			}

			// Now we check whether sleepers are to be deleted automatically
			$autodel_sleepers = $this->config['mot_ur_sleeper_autodelete'];
			$sleeper_del_time = $now - ($this->config['mot_ur_sleeper_deletetime'] * self::SECS_PER_DAY);
			if ($autodel_sleepers)
			{
				$sql = 'SELECT user_id
						FROM  ' . USERS_TABLE . '
						WHERE ' . $this->db->sql_in_set('user_type', [USER_NORMAL,USER_FOUNDER]) . '
						AND mot_last_login = 0';
				// if sleepers are to be reminded first we have to check whether the delete time since the reminder has elapsed
				if ($remind_sleepers)
				{
					$sql .= ' AND mot_sleeper_remind > 0
							AND mot_sleeper_remind <= ' . $sleeper_del_time;
				}
				// if they are not to be reminded we have to check whether their registration date is prior to the time to deletion
				else
				{
					$sql .= ' AND user_regdate <= ' . $sleeper_del_time;
				}
				if (!empty($protected_members))				// prevent sql errors due to empty array
				{
					$sql .= ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true);
				}
				if (!empty($protected_groups))
				{
					$sql .= ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true);
				}

				$result = $this->db->sql_query($sql);
				$sleepers = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				$delmarked_sleepers = [];
				foreach ($sleepers as $row)
				{
					$delmarked_sleepers[] = $row['user_id'];
				}
				$this->common->delete_users($delmarked_sleepers);
			}
		}
	}

	public function delete_replyto($event)
	{
		if ($this->config['mot_ur_suppress_replyto'])
		{
			$header = $event['headers'];
			foreach ($header as $key => $value)
			{
				if (strpos($value, 'Reply-To: ') !== false)
				{
					array_splice($header, $key, 1);
				}
			}
			$event['headers'] = $header;
		}
	}
}
