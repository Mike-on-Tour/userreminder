<?php

/**
*
* @package UserReminder v1.8.1
* @copyright (c) 2019 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder;

use phpbb\language\language;
use phpbb\language\language_file_loader;

class common
{
	private const SECS_PER_DAY = 86400;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\log\log $log */
	protected $log;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $phpEx;

	/** @var string mot.userreminder.tables.mot_userreminder_remind_queue */
	protected $mot_userreminder_remind_queue;

	public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\db\driver\driver_interface $db,
								\phpbb\user $user, \phpbb\log\log $log, $root_path, $phpEx, $mot_userreminder_remind_queue)
	{
		$this->config = $config;
		$this->config_text = $config_text;
		$this->db = $db;
		$this->user = $user;
		$this->log = $log;
		$this->root_path = $root_path;
		$this->phpEx = $phpEx;
		$this->mot_userreminder_remind_queue = $mot_userreminder_remind_queue;

		$this->sitename = htmlspecialchars_decode($this->config['sitename'], ENT_COMPAT);
		$script_path = (strlen($this->config['script_path']) > 1) ? $this->config['script_path'] : '';
		$this->forgot_pass = $this->config['server_protocol'] . $this->config['server_name'] . $script_path . "/ucp.".$this->phpEx."?mode=sendpassword";
		$this->admin_mail = $this->config['board_contact'];
		$this->email_sig = str_replace('<br>', "\n", "-- \n" . htmlspecialchars_decode($this->config['board_email_sig'], ENT_COMPAT));
		$this->days_inactive = $this->config['mot_ur_inactive_days'];
		$this->days_til_delete = $this->config['mot_ur_days_until_deleted'];
		$this->days_del_sleepers = $this->config['mot_ur_sleeper_deletetime'];
	}

	/**
	* Delete users
	*
	* @param	array	$users_marked	Users selected for deletion identified by their user_id
	**/
	public function delete_users($users_marked)
	{
		if (count($users_marked) > 0)					// lets check for an empty array; just to be certain that none of the called functions throws an error or an exception
		{
			// first include the user functions ("user_get_id_name" and "user_delete") if they don't exist
			if (!function_exists('user_get_id_name'))
			{
				include($this->root_path . 'includes/functions_user.' . $this->phpEx);
			}

			// now we translate the given array of user_id's into an array of usernames for logging purposes
			$username_ary = [];
			user_get_id_name($users_marked, $username_ary);

			// now we have one array with the user_id's and another with the respective usernames: with the first one we delete the users and with the second we log this action in the admin log
			user_delete('retain', $users_marked);
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_USER_DELETED', false, [implode(', ', $username_ary)]);
		}
	}


	/**
	* Remind users
	*
	* @param	array		$users_marked	Users selected for reminding identified by their user_id
	*		boolean	$zeroposters	marks whether inactive users or zeroposters are to be handled, default is false to mark inactive users, set to true for handling zeroposters, necessary due to different config variables
	**/
	public function remind_users($users_marked, $zeroposters = false)
	{
		if (count($users_marked) > 0)					// lets check for an empty array; just to be certain that none of the called functions throws an error or an exception
		{
			// since we have at least one user to remind we check for messenger class, include it if necessary and construct an instance
			if (!class_exists('\messenger'))
			{
				include($this->root_path . 'includes/functions_messenger.' . $this->phpEx);
			}
			$messenger = new \messenger(false);

			// Now we get the number of available mails to be sent in the current time frame
			$mail_available = $this->config['mot_ur_mail_available'];

			/**
			*	There is only one select box to select users for reminding so we have to discern here what users are supposed to get the first and the second reminder mail.
			*	This is done by firstly getting those users where the date of the first mail is greater than Zero (which means they have already received the first mail and are due for the second one)
			*	and secondly those users who have a value of Zero (which means they have not been reminded yet) .
			*	This sequence is necessary due to the fact that we set this date in the DB while sending the first mail and thus we would be sending both mails if we did it the other way round.
			*/
			$now = time();
			// Since inactive users and zeroposters may have different time frames we have to distinguish here
			$reminder1 = $zeroposters ? $now - (self::SECS_PER_DAY * $this->config['mot_ur_zp_days_reminded']) : $now - (self::SECS_PER_DAY * $this->config['mot_ur_days_reminded']);
			// since we only have an array of user ids we need to get all the other user data from the DB and we start to select the users supposed to get the second reminder mail
			// get only users we have selected before
			// and who have been reminded once before
			$query = 'SELECT user_id, username, user_email, mot_last_login, user_lang, user_timezone, user_dateformat, user_jabber, user_notify_type, mot_reminded_one, user_regdate, mot_sleeper_remind
					FROM  ' . USERS_TABLE . '
					WHERE ' . $this->db->sql_in_set('user_id', $users_marked) . '
					AND (mot_reminded_one > 0 AND mot_reminded_one <= ' .	$reminder1 . ')
					AND mot_reminded_two = 0
					ORDER BY user_id';

			$result = $this->db->sql_query($query);
			$second_reminders = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			if (count($second_reminders) > 0)				// to prevent error messages if there are no results (in auto_reminder mode)
			{
				$second_reminders_ary = [];
				$second_username_ary = [];

				foreach ($second_reminders as $row)
				{
					$second_username_ary[] = $row['username'];
					if ($mail_available > 0)
					{
						$this->reminder_mail($row, $messenger, 'reminder_two');
						--$mail_available;
					}
					else
					{
						// Current e-mail contingent is used, save this user's data in the DB
						$this->save_user_data($row, 'reminder_two');
					}
					// Independently from the method (immediate mail or stored in the DB for a later mail we have to mark this user as reminded (in the case of storing in the DB it has to be done again when the mail is actually sent)
					$second_reminders_ary[] = $row['user_id'];
				}

				// all mails have been sent, let's set the reminder time
				$sql_ary = [
					'mot_reminded_two'	=>	$now,
				];

				$query = 'UPDATE ' . USERS_TABLE . '
						SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) .'
						WHERE ' . $this->db->sql_in_set('user_id', $second_reminders_ary);
				$this->db->sql_query($query);

				// emails are sent, time is set in the DB, so we can log this action in the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_INACTIVE_REMIND_TWO', false, [implode(', ', $second_username_ary)]);
			}

			//--------------------------------------------------------------------------------------
			// and now we start to select the users supposed to get the first reminder mail, for this we have to calculate $day_limit depending on the type of user (inactive or zerooster)
			$day_limit = $zeroposters ? $now - (self::SECS_PER_DAY * $this->config['mot_ur_zp_inactive_days']) : $now - (self::SECS_PER_DAY * $this->config['mot_ur_inactive_days']);
			$query = 'SELECT user_id, username, user_email, mot_last_login, user_lang, user_timezone, user_dateformat, user_jabber, user_notify_type, mot_reminded_one, user_regdate, mot_sleeper_remind
					FROM  ' . USERS_TABLE . '
					WHERE ' . $this->db->sql_in_set('user_id', $users_marked) . '
					AND mot_last_login <= ' . $day_limit . '
					AND mot_reminded_one = 0
					ORDER BY user_id';

			$result = $this->db->sql_query($query);
			$first_reminders = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			if (count($first_reminders) > 0)				// to prevent error messages if there are no results (in auto_reminder mode)
			{
				$first_reminders_ary = [];
				$first_username_ary = [];
				foreach ($first_reminders as $row)
				{
					$first_username_ary[] = $row['username'];
					if ($mail_available > 0)
					{
						$this->reminder_mail($row, $messenger, 'reminder_one');
						--$mail_available;
					}
					else
					{
						// Current e-mail contingent is used, save this user's data in the DB
						$this->save_user_data($row, 'reminder_one');
					}
					// Independently from the method (immediate mail or stored in the DB for a later mail we have to mark this user as reminded (in the case of storing in the DB it has to be done again when the mail is actually sent)
					$first_reminders_ary[] = $row['user_id'];
				}

				// all mails have been sent, let's set the reminder time(s)
				$query = 'UPDATE ' . USERS_TABLE . ' SET mot_reminded_one = ' . $now;
				// if the admin selected to have only one reminder by setting this time frame to Zero we have to set this column too to enable deletion depending on the type of user
				if ($zeroposters)
				{
					$query .= $this->config['mot_ur_zp_days_reminded'] == 0 ? ', mot_reminded_two = ' . $now : '';
				}
				else
				{
					$query .= $this->config['mot_ur_days_reminded'] == 0 ? ', mot_reminded_two = ' . $now : '';
				}

				$query .= ' WHERE ' . $this->db->sql_in_set('user_id', $first_reminders_ary);
				$this->db->sql_query($query);

				// emails are sent, time is set in the DB, so we can log this action in the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_INACTIVE_REMIND_ONE', false, [implode(', ', $first_username_ary)]);
			}

			// Write the current number of available e-mails back to the config variable
			$this->config->set('mot_ur_mail_available', $mail_available);
		}
	}


	/**
	* Remind sleepers
	*
	* @param	array	$sleepers_marked	Users selected for reminding identified by their user_id
	*/
	public function remind_sleepers($sleepers_marked)
	{
		if (count($sleepers_marked) > 0)			// lets check for an empty array; just to be certain that none of the called functions throws an error or an exception
		{
			// since we have at least one user to remind we check for messenger class, include it if necessary and construct an instance
			if (!class_exists('\messenger'))
			{
				include($this->root_path . 'includes/functions_messenger.' . $this->phpEx);
			}
			$messenger = new \messenger(false);

			// Now we get the number of available mails to be sent in the current time frame
			$mail_available = $this->config['mot_ur_mail_available'];

			$now = time();

			// Get the data of all sleepers due for reminding
			$sql = 'SELECT user_id, username, user_email, mot_last_login, user_lang, user_timezone, user_dateformat, user_jabber, user_notify_type, mot_reminded_one, user_regdate, mot_sleeper_remind
					FROM  ' . USERS_TABLE . '
					WHERE ' . $this->db->sql_in_set('user_id', $sleepers_marked) . '
					AND mot_last_login = 0';
			$result = $this->db->sql_query($sql);
			$sleeper_reminders = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			// If there are any sleepers due for reminding we do it now
			if (count($sleeper_reminders) > 0)
			{
				$sleeper_reminders_ary = [];
				$sleeper_username_ary = [];
				foreach ($sleeper_reminders as $row)
				{
					if ($mail_available > 0)
					{
						$sleeper_username_ary[] = $row['username'];
						$this->reminder_mail($row, $messenger, 'reminder_sleeper');
						--$mail_available;
					}
					else
					{
						// Current e-mail contingent is used, save this user's data in the DB
						$this->save_user_data($row, 'reminder_sleeper');
					}
					// Independently from the method (immediate mail or stored in the DB for a later mail we have to mark this user as reminded (in the case of storing in the DB it has to be done again when the mail is actually sent)
					$sleeper_reminders_ary[] = $row['user_id'];
				}

				// all mails have been sent, let's set the reminder time(s)
				$sql = 'UPDATE ' . USERS_TABLE . ' SET mot_sleeper_remind = ' . (int) $now . '
						WHERE ' . $this->db->sql_in_set('user_id', $sleeper_reminders_ary);
				$this->db->sql_query($sql);

				// emails are sent, time is set in the DB, so we can log this action in the admin log for all sleepers who actually got a mail
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_SLEEPER_REMIND', false, [implode(', ', $sleeper_username_ary)]);
			}

			// Write the current number of available e-mails back to the config variable
			$this->config->set('mot_ur_mail_available', $mail_available);
		}
	}


	/**
	* @param array	$row			user data
	* @param object	$messenger		messenger object to send the mails
	* @param string	$reminder_type	either 'reminder_one', 'reminder_two' or 'reminder_sleeper'
	*
	* @return		no return value
	*/
	public function reminder_mail($row, $messenger, $reminder_type)
	{
		// Get
		// Reset the messenger variables to prevent errors
		$messenger->reset();

		// Set addresses and e-mail header
		$messenger->set_addresses($row);
		if ($this->config['mot_ur_email_bcc'] != '')
		{
			$messenger->bcc($this->config['mot_ur_email_bcc']);
		}
		if ($this->config['mot_ur_email_cc'] != '')
		{
			$messenger->cc($this->config['mot_ur_email_cc']);
		}
		$messenger->anti_abuse_headers($this->config, $this->user);

		// Set FROM address if applicable
		if ($this->config['mot_ur_email_from'] != '')
		{
			$messenger->from($this->config['mot_ur_email_from']);
		}

		// check whether the user's language exists in the extension
		$lang_dir = $this->root_path . 'ext/mot/userreminder/language';
		$dirs = $this->load_dirs($lang_dir);
		if (!in_array($row['user_lang'], $dirs))
		{
			// language doesn't exist -> fall back to en
			$row['user_lang'] = 'en';
		}

		// First check whether email text has been edited and saved in the config_text table since in this case we have to take care of setting all the variables and do the correct sending ourselves
		$email_arr = json_decode($this->config_text->get('mot_ur_email_texts'), true);
		if (array_key_exists($row['user_lang'], $email_arr) && array_key_exists($reminder_type, $email_arr[$row['user_lang']]))
		{
			$ur_email_text = $email_arr[$row['user_lang']][$reminder_type];

			$username = htmlspecialchars_decode($row['username'], ENT_COMPAT);
			$last_visit = $this->format_date_time($row['user_lang'], $row['user_timezone'], $row['user_dateformat'], $row['mot_last_login']);
			$last_remind = $this->format_date_time($row['user_lang'], $row['user_timezone'], $row['user_dateformat'], $row['mot_reminded_one']);
			$reg_date = $this->format_date_time($row['user_lang'], $row['user_timezone'], $row['user_dateformat'], $row['user_regdate']);

			$search_arr = array ('{SITENAME}', '{USERNAME}', '{LAST_VISIT}', '{LAST_REMIND}', '{FORGOT_PASS}', '{ADMIN_MAIL}', '{EMAIL_SIG}', '{DAYS_INACTIVE}', '{DAYS_TIL_DELETE}', '{REG_DATE}', '{DAYS_DEL_SLEEPERS}');
			$replace_arr = array ($this->sitename, $username, $last_visit, $last_remind, $this->forgot_pass, $this->admin_mail, $this->email_sig, $this->days_inactive, $this->days_til_delete, $reg_date, $this->days_del_sleepers);
			$ur_email_text = str_replace($search_arr, $replace_arr, $ur_email_text);

			$text_arr = preg_split('/[\n]+/', $ur_email_text, 2);
			$subject = preg_split('/[\s]/', $text_arr[0], 2);		// get rid of the 'Subject: ' substring
			$messenger->subject($subject[1]);
			$messenger->msg = $text_arr[1];

			switch ($row['user_notify_type'])
			{
				case NOTIFY_EMAIL:
					$messenger->msg_email();
				break;

				case NOTIFY_IM:
					$messenger->msg_jabber();
				break;

				case NOTIFY_BOTH:
					$messenger->msg_email();
					$messenger->msg_jabber();
				break;
			}
		}
		// email is not in the config_text variable, load it from the file (which makes things easier since there are some convenient functions available for setting variables and sending)
		else
		{
			$mail_template_path = $this->root_path . 'ext/mot/userreminder/language/' . $row['user_lang'] . '/email/';
			$messenger->template($reminder_type, $row['user_lang'], $mail_template_path);

			$messenger->assign_vars([
				'USERNAME'			=> htmlspecialchars_decode($row['username'], ENT_COMPAT),
				'LAST_VISIT'		=> $this->format_date_time($row['user_lang'], $row['user_timezone'], $row['user_dateformat'], $row['mot_last_login']),
				'LAST_REMIND'		=> $this->format_date_time($row['user_lang'], $row['user_timezone'], $row['user_dateformat'], $row['mot_reminded_one']),
				'DAYS_INACTIVE'		=> $this->days_inactive,
				'FORGOT_PASS'		=> $this->forgot_pass,
				'ADMIN_MAIL'		=> $this->admin_mail,
				'DAYS_TIL_DELETE'	=> $this->days_til_delete,
				'REG_DATE'			=> $this->format_date_time($row['user_lang'], $row['user_timezone'], $row['user_dateformat'], $row['user_regdate']),
				'DAYS_DEL_SLEEPERS'	=> $this->days_del_sleepers,
			]);

			$messenger->send($row['user_notify_type']);
		}
	}

/* ------------------------------------------------------------------------------------------------------------------------------------------------ */

	/**
	* @param array	$user_row		user data
	* @param string	$reminder_type	either 'reminder_one', 'reminder_two' or 'reminder_sleeper'
	*
	* @return		no return value
	*/
	private function save_user_data($user_row, $reminder_type)
	{
		$user_row['remind_type'] = $reminder_type;
		$sql = 'INSERT INTO ' . $this->mot_userreminder_remind_queue . ' ' . $this->db->sql_build_array('INSERT', $user_row);
		$this->db->sql_query($sql);
	}


	/**
	* @param string	$user_lang			addressed user's language
	* @param string	$user_timezone		addressed user's time zone
	* @param string	$user_dateformat	addressed user's date/time format
	* @param int	$user_timestamp		addressed user's php timestamp (registration date, last login, reminder mails as UNIX timestamp from users table)
	*
	* @return string	the timestamp in user's choosen date/time format and time zone as DateTime string
	*/
	private function format_date_time($user_lang, $user_timezone, $user_dateformat, $user_timestamp)
	{
		$user_timezone = (empty($user_timezone) || $user_timezone == '0') ? 'UTC' : $user_timezone;		// fallback value, just in case

		$default_tz = date_default_timezone_get();
		$date = new \DateTime('now', new \DateTimeZone($default_tz));
		$date->setTimestamp($user_timestamp);
		$date->setTimezone(new \DateTimeZone($user_timezone));
		$time = $date->format($user_dateformat);

		// Instantiate a new language class (with its own loader), set the user's chosen language and translate the date/time string
		$lang = new language(new language_file_loader($this->root_path, $this->phpEx));
		$lang->set_user_language($user_lang);

		// Find all words in date/time string and replace them with the translations from user's language
		preg_match_all("/[a-zA-Z]+/", $time, $matches, PREG_PATTERN_ORDER);
		if (count($matches[0]) > 0)
		{
			foreach ($matches[0] as $value)
			{
				$time = preg_replace("/".$value."/", $lang->lang(['datetime', $value]), $time);
			}
		}

		// return the formatted and translated time in users timezone
		return $time;
	}


	/*
	* Loads all language directories of ext/mot/userreminder/language
	* Returns an array with all found directories
	*/
	public function load_dirs($dir)
	{
		$result = [];
		$dir_ary = scandir($dir);
		foreach ($dir_ary as $value)
		{
			if (!in_array($value,[".",".."]))
			{
				if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
				{
					$result[] = $value;
				}
			}
		}
		return $result;
	}
}
