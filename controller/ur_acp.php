<?php
/**
*
* @package Userreminder v1.8.0
* @copyright (c) 2019 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\controller;

class ur_acp
{
	private const SECS_PER_DAY = 86400;

	/** @var \mot\userreminder\common */
	protected $common;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\group\helper */
	protected $group_helper;

	/** @var \phpbb\language\language $language Language object */
	protected $language;

	/** @var \phpbb\pagination  */
	protected $pagination;

	/** @var \phpbb\extension\manager */
	protected $phpbb_extension_manager;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string PHP extension */
	protected $php_ext;

	/** @var string phpBB phpbb root path */
	protected $root_path;

	/** @var string mot.userreminder.tables.mot_userreminder_remind_queue */
	protected $mot_userreminder_remind_queue;

	/**
	 * {@inheritdoc
	 */
	public function __construct(\mot\userreminder\common $common, \phpbb\config\config $config, \phpbb\config\db_text $config_text,
								\phpbb\db\driver\driver_interface $db, \phpbb\group\helper $group_helper, \phpbb\language\language $language,
								\phpbb\pagination $pagination, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\request\request_interface $request,
								\phpbb\template\template $template, \phpbb\user $user, $php_ext, $root_path, $mot_userreminder_remind_queue)
	{
		$this->common = $common;
		$this->config = $config;
		$this->config_text = $config_text;
		$this->db = $db;
		$this->group_helper = $group_helper;
		$this->language = $language;
		$this->pagination = $pagination;
		$this->phpbb_extension_manager = $phpbb_extension_manager;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->php_ext = $php_ext;
		$this->root_path = $root_path;
		$this->mot_userreminder_remind_queue = $mot_userreminder_remind_queue;

		$this->md_manager = $this->phpbb_extension_manager->create_extension_metadata_manager('mot/userreminder');
		$this->userreminder_version = $this->md_manager->get_metadata('version');
	}


	public function settings()
	{
		add_form_key('acp_userreminder_settings');

		// Check for this function and include it if not existent since it is needed to convert user_id into usernames and vice versa for the protected members section
		if (!function_exists('user_get_id_name'))
		{
			include($this->root_path . 'includes/functions_user.' . $this->php_ext);
		}

		$lang_dir = $this->root_path . 'ext/mot/userreminder/language';
		$ur_lang = $ur_file = $ur_email_text = $preview_text = '';
		$show_preview = $show_filecontent = false;
		$lang_arr = [
			'reminder_one'		=> $this->language->lang('ACP_USERREMINDER_MAIL_ONE'),
			'reminder_two'		=> $this->language->lang('ACP_USERREMINDER_MAIL_TWO'),
			'reminder_sleeper'	=> $this->language->lang('ACP_USERREMINDER_MAIL_SLEEPER'),
		];

		/*
		* this IF clause gets activated when the 'submit' button is pressed, writes all settings to $config
		*/
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('acp_userreminder_settings'))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// get the names of members to be protected and convert it to array of user_ids
			$protected_users_ids = [];
			$protected_users_names = $this->request->variable('mot_ur_protected_members', '', true);
			$username_arr = explode("\n", $protected_users_names);
			user_get_id_name($protected_users_ids, $username_arr);
			sort($protected_users_ids);

			// get the current values of mail limits and available mail number to check against changed values
			$current_mail_limit = $this->config['mot_ur_mail_limit_number'];
			$current_mail_available = $this->config['mot_ur_mail_available'];
			// get the new (?) value of mail limit
			$mail_limit = $this->request->variable('mot_ur_mail_limit_number', 0);

			// save the settings to the phpbb_config table
			$this->config->set('mot_ur_rows_per_page', $this->request->variable('mot_ur_rows_per_page', 0));
			$this->config->set('mot_ur_expert_mode', $this->request->variable('mot_ur_expert_mode', 0));
			$this->config->set('mot_ur_inactive_days', $this->request->variable('mot_ur_inactive_days', 0));
			$this->config->set('mot_ur_days_reminded', $this->request->variable('mot_ur_days_reminded', 0));
			$this->config->set('mot_ur_autoremind', $this->request->variable('mot_ur_autoremind', 0));
			$this->config->set('mot_ur_days_until_deleted', $this->request->variable('mot_ur_days_until_deleted', 0));
			$this->config->set('mot_ur_autodelete', $this->request->variable('mot_ur_autodelete', 0));
			$this->config->set('mot_ur_remind_sleeper', $this->request->variable('mot_ur_remind_sleeper', 0));
			$this->config->set('mot_ur_sleeper_inactive_days', $this->request->variable('mot_ur_sleeper_inactive_days', 0));
			$this->config->set('mot_ur_sleeper_autoremind', $this->request->variable('mot_ur_sleeper_autoremind', 0));
			$this->config->set('mot_ur_sleeper_autodelete', $this->request->variable('mot_ur_sleeper_autodelete', 0));
			$this->config->set('mot_ur_sleeper_deletetime', $this->request->variable('mot_ur_sleeper_deletetime', 0));
			$this->config->set('mot_ur_remind_zeroposter', $this->request->variable('mot_ur_remind_zeroposter', 0));
			$this->config->set('mot_ur_zp_inactive_days', $this->request->variable('mot_ur_zp_inactive_days', 0));
			$this->config->set('mot_ur_zp_days_reminded', $this->request->variable('mot_ur_zp_days_reminded', 0));
			$this->config->set('mot_ur_zp_autoremind', $this->request->variable('mot_ur_zp_autoremind', 0));
			$this->config->set('mot_ur_zp_days_until_deleted', $this->request->variable('mot_ur_zp_days_until_deleted', 0));
			$this->config->set('mot_ur_zp_autodelete', $this->request->variable('mot_ur_zp_autodelete', 0));
			$this->config->set('mot_ur_protected_members', json_encode($protected_users_ids));
			$this->config->set('mot_ur_protected_groups', json_encode($this->request->variable('mot_ur_protected_groups', [0])));
			$this->config->set('mot_ur_mail_limit_number', $mail_limit);
			$this->config->set('mot_ur_mail_limit_time_gc', $this->request->variable('mot_ur_mail_limit_time', 0));
			$this->config->set('mot_ur_email_bcc', substr($this->request->variable('mot_ur_email_bcc', ''), 0, 255));
			$this->config->set('mot_ur_email_cc', substr($this->request->variable('mot_ur_email_cc', ''), 0, 255));
			$this->config->set('mot_ur_email_from', substr($this->request->variable('mot_ur_email_from', ''), 0, 255));
			$this->config->set('mot_ur_suppress_replyto', $this->request->variable('mot_ur_suppress_replyto', 0));

			// check whether we have to alter the current number of available mails
			if (($current_mail_limit != $mail_limit) && (($mail_limit < $current_mail_available) || ($mail_limit > $current_mail_limit && $current_mail_available == $current_mail_limit)))
			{
				$this->config->set('mot_ur_mail_available', $mail_limit);
			}

			trigger_error($this->language->lang('ACP_USERREMINDER_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		/*
		* This IF clause gets activated when the 'load file' button is pressed and loads the respective file defined by $ur_lang and $ur_file from the drive
		*/
		if ($this->request->is_set_post('load_file'))
		{
			$show_filecontent = true;
			$ur_lang = $this->request->variable('mot_ur_mail_lang', '');
			$ur_file = $this->request->variable('mot_ur_mail_file', '');
			// check for malign changes by injecting another path
			if (preg_match('[\W]', $ur_lang) || preg_match('[\W]', $ur_file))
			{
				trigger_error($this->language->lang('ACP_USERREMINDER_FILE_NOT_FOUND', $ur_lang . '/' . $ur_file) . adm_back_link($this->u_action), E_USER_WARNING);
			}
			// look in the config_text table first
			$email_arr = json_decode($this->config_text->get('mot_ur_email_texts'), true);
			if (array_key_exists($ur_lang, $email_arr) && array_key_exists($ur_file, $email_arr[$ur_lang]))
			{
				$ur_email_text = $email_arr[$ur_lang][$ur_file];
			}
			// email is not in the config_text variable, load it from the file
			else
			{
				$ur_email_text = file_get_contents($lang_dir . '/' . $ur_lang . '/email/' . $ur_file . '.txt');
			}
		}

		/*
		* This IF clause gets activated when the 'preview' button is pressed and shows how the email will look with all the tokens replaced
		*/
		if ($this->request->is_set_post('preview'))
		{
			$show_preview = true;
			$show_filecontent = true;
			$ur_lang = $this->request->variable('mot_ur_mail_lang', '');
			$ur_file = $this->request->variable('mot_ur_mail_file', '');
			$ur_email_text = $this->request->variable('mot_ur_mail_text', '', true);
			$preview_text = $ur_email_text;

			$token = ['{SITENAME}', '{USERNAME}', '{LAST_VISIT}', '{LAST_REMIND}', '{REG_DATE}', '{DAYS_INACTIVE}', '{FORGOT_PASS}',
							'{ADMIN_MAIL}', '{DAYS_TIL_DELETE}', '{EMAIL_SIG}', '{DAYS_DEL_SLEEPERS}'];
			$real_text = [$this->config['sitename'], $this->user->data['username'], $this->user->format_date($this->user->data['user_lastvisit']),
							$this->user->format_date($this->user->data['mot_reminded_one']), $this->user->format_date($this->user->data['user_regdate']),
							$this->config['mot_ur_inactive_days'], $this->config['server_protocol'] . $this->config['server_name'] . "/ucp." . $this->php_ext . "?mode=sendpassword",
							$this->config['board_contact'], $this->config['mot_ur_days_until_deleted'], $this->config['board_email_sig'], $this->config['mot_ur_sleeper_deletetime']
			];
			$preview_text = str_replace($token, $real_text, $preview_text);

			$flags = 0;
			$uid = $bitfield = '';
			$preview_text = generate_text_for_display($preview_text, $uid, $bitfield, $flags);
		}

		/*
		* This IF clause gets activated when the 'save file' button is pressed and saves the respective text defined by $ur_lang and $ur_file to the db
		*/
		if ($this->request->is_set_post('save_file'))
		{
			$ur_lang = $this->request->variable('mot_ur_mail_lang', '');
			$ur_file = $this->request->variable('mot_ur_mail_file', '');
			$ur_email_text = $this->request->variable('mot_ur_mail_text', '', true);

			$email_arr = json_decode($this->config_text->get('mot_ur_email_texts'), true);
			$email_arr[$ur_lang][$ur_file] = $ur_email_text;
			$this->config_text->set('mot_ur_email_texts', json_encode($email_arr));
			trigger_error($this->language->lang('ACP_USERREMINDER_FILE_SAVED', $ur_lang . '/' . $lang_arr[$ur_file]) . adm_back_link($this->u_action), E_USER_NOTICE);
		}

		/*
		* This IF clause gets activated when the 'send_testmail' button is pressed
		*/
		if ($this->request->is_set_post('send_testmail'))
		{
			// since we have at least one user to remind we check for messenger class, include it if necessary and construct an instance
			if (!class_exists('\messenger'))
			{
				include($this->root_path . 'includes/functions_messenger.' . $this->php_ext);
			}
			$messenger = new \messenger(false);

			$user_data = $this->user->data;
			$user_data['user_notify_type'] = NOTIFY_EMAIL;
			$user_data['user_lang'] = $this->request->variable('mot_ur_mail_lang', '');
			$user_data['user_email'] = $this->request->variable('mot_ur_test_mail', '');

			$this->common->email_arr = json_decode($this->config_text->get('mot_ur_email_texts'), true);
			$this->common->reminder_mail($user_data, $messenger, $this->request->variable('mot_ur_mail_file', ''));
			unset($messenger);

			trigger_error($this->language->lang('ACP_USERREMINDER_TESTMAIL_SENT') . adm_back_link($this->u_action));
		}

		$dirs = $this->common->load_dirs($lang_dir);
		foreach ($dirs as $value)
		{
			$this->template->assign_block_vars('langs', [
				'VALUE'		=> $value,
			]);
		}

		// Get the user_ids of protected members and convert it to string for use in template
		$username_arr = [];
		$protected_users_ids = json_decode($this->config['mot_ur_protected_members']);
		user_get_id_name($protected_users_ids, $username_arr);
		sort($username_arr);
		$protected_users_names = implode("\n", $username_arr);

		// Get the group properties of those groups used as default
		$sql = 'SELECT g.group_id, g.group_type, g.group_name, u.group_id FROM ' .
				GROUPS_TABLE . ' AS g, ' . USERS_TABLE . ' AS u
				WHERE g.group_id = u.group_id
				AND u.user_type IN (' . USER_NORMAL . ',' . USER_FOUNDER . ')
				GROUP BY u.group_id
				ORDER BY g.group_type DESC, g.group_name ASC';
		$result = $this->db->sql_query($sql);
		$groups = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);
		$group_count = count($groups);
		$protected_groups = '';
		$protected_groups_arr = json_decode($this->config['mot_ur_protected_groups']);

		foreach ($groups as $option)
		{
			$selected = in_array($option['group_id'], $protected_groups_arr) ? ' selected' : '';
			$protected_groups .= '<option ' . (($option['group_type'] == GROUP_SPECIAL) ? ' class="sep"' : '') . ' value="' . $option['group_id'] . '"' . $selected . '>' . $this->group_helper->get_name($option['group_name']) . '</option>';
		}

		// Check total number of emails waiting in the mail queue
		$sql = 'SELECT COUNT(*) AS mail_number FROM ' . $this->mot_userreminder_remind_queue;
		$result = $this->db->sql_query($sql);
		$total_mails = $this->db->sql_fetchfield('mail_number');
		$this->db->sql_freeresult($result);

		$email_bcc = $this->config['mot_ur_email_bcc'];
		$email_cc = $this->config['mot_ur_email_cc'];
		$this->template->assign_vars([
			'ACP_USERREMINDER_ROWS_PER_PAGE'			=> $this->config['mot_ur_rows_per_page'],
			'ACP_USERREMINDER_EXPERT_MODE'				=> (bool) $this->config['mot_ur_expert_mode'],
			'ACP_USERREMINDER_INACTIVE_DAYS'			=> $this->config['mot_ur_inactive_days'],
			'ACP_USERREMINDER_DAYS_REMINDED'			=> $this->config['mot_ur_days_reminded'],
			'ACP_USERREMINDER_AUTOREMIND'				=> (bool) $this->config['mot_ur_autoremind'],
			'ACP_USERREMINDER_DAYS_UNTIL_DELETED'		=> $this->config['mot_ur_days_until_deleted'],
			'ACP_USERREMINDER_AUTODELETE'				=> (bool) $this->config['mot_ur_autodelete'],
			'ACP_USERREMINDER_REMIND_SLEEPER'			=> (bool) $this->config['mot_ur_remind_sleeper'],
			'ACP_USERREMINDER_SLEEPER_INACTIVE_DAYS'	=> $this->config['mot_ur_sleeper_inactive_days'],
			'ACP_USERREMINDER_SLEEPER_AUTOREMIND'		=> (bool) $this->config['mot_ur_sleeper_autoremind'],
			'ACP_USERREMINDER_AUTODELETE_SLEEPER'		=> (bool) $this->config['mot_ur_sleeper_autodelete'],
			'ACP_USERREMINDER_SLEEPER_DELETETIME'		=> $this->config['mot_ur_sleeper_deletetime'],
			'ACP_USERREMINDER_REMIND_ZEROPOSTER'		=> (bool) $this->config['mot_ur_remind_zeroposter'],
			'ACP_USERREMINDER_ZP_INACTIVE_DAYS'			=> $this->config['mot_ur_zp_inactive_days'],
			'ACP_USERREMINDER_ZP_DAYS_REMINDED'			=> $this->config['mot_ur_zp_days_reminded'],
			'ACP_USERREMINDER_ZP_AUTOREMIND'			=> $this->config['mot_ur_zp_autoremind'],
			'ACP_USERREMINDER_ZP_DAYS_UNTIL_DELETED'	=> $this->config['mot_ur_zp_days_until_deleted'],
			'ACP_USERREMINDER_ZP_AUTODELETE'			=> $this->config['mot_ur_zp_autodelete'],
			'ACP_USERREMINDER_PROTECTED_MEMBERS'		=> $protected_users_names,
			'ACP_USERREMINDER_GROUP_COUNT'				=> $group_count,
			'ACP_USERREMINDER_PROTECTED_GROUPS'			=> $protected_groups,
			'ACP_USERREMINDER_MAIL_LIMIT_NUMBER'		=> $this->config['mot_ur_mail_limit_number'],
			'ACP_USERREMINDER_MAIL_LIMIT_TIME'			=> $this->config['mot_ur_mail_limit_time_gc'],
			'ACP_USERREMINDER_LAST_CRON_RUN'			=> $this->config['mot_ur_mail_limit_time_last_gc'] ? $this->user->format_date($this->config['mot_ur_mail_limit_time_last_gc']) : '-',
			'ACP_USERREMINDER_AVAILABLE_MAIL_CHUNK'		=> $this->config['mot_ur_mail_available'],
			'ACP_USERREMINDER_MAILS_WAITING'			=> $total_mails,
			'ACP_USERREMINDER_EMAIL_BCC'				=> $email_bcc,
			'ACP_USERREMINDER_EMAIL_CC'					=> $email_cc,
			'ACP_USERREMINDER_EMAIL_FROM'				=> $this->config['mot_ur_email_from'],
			'ACP_USERREMINDER_SUPPRESS_REPLYTO'			=> $this->config['mot_ur_suppress_replyto'],
			'ACP_USERREMINDER_EMAIL_TEXT'				=> $ur_email_text,
			'ACP_USERREMINDER_TEST_MAIL_ADDRESS'		=> $email_bcc != '' ? $email_bcc : ($email_cc != '' ? $email_cc : $this->language->lang('ACP_USERREMINDER_ENTER_EMAIL_ADDRESS')),
			'U_ACTION'									=> $this->u_action,
			'CHOOSE_LANG'								=> $ur_lang,
			'CHOOSE_FILE'								=> $ur_file,
			'SHOW_FILECONTENT'							=> $show_filecontent,
			'PREVIEW_TEXT'								=> $preview_text,
			'SHOW_PREVIEW'								=> $show_preview,
			'USERREMINDER_VERSION'						=> $this->language->lang('ACP_USERREMINDER_VERSION', $this->userreminder_version, date('Y')),
		]);
	}


	public function reminder()
	{
		$now = time();
		$day_limit = $now - (self::SECS_PER_DAY * (int) $this->config['mot_ur_inactive_days']);

		// set parameter for pagination
		$limit = $this->config['mot_ur_rows_per_page'];	// max lines per page

		// get sort variables from template (if we are in a loop of the pagination). At first call there are no variables from the (so far uncalled) template -> we have to set initial parameters for sorting
		$sort_key = $this->request->is_set('sort_key') ? $this->request->variable('sort_key', '') : 'mot_last_login';
		$sort_dir = $this->request->is_set('sort_dir') ? $this->request->variable('sort_dir', '') : 'ASC';

		$enable_sort_one = $enable_sort_two = false;

		add_form_key('acp_userreminder_reminder');

		if ($this->request->is_set_post('sort'))
		{
			// sort key and/or direction have been changed in the template, so we set them here
			$sort_key = $this->request->variable('sort_key', '');
			$sort_dir = $this->request->variable('sort_dir', '');
			// and start with the first page
			$start = 0;
		}
		else
		{
			$start = $this->request->variable('start', 0);
		}

		if ($this->request->is_set_post('rem_marked'))
		{
			$marked = $this->request->variable('mark_remind', [0]);
			if (count($marked) > 0)
			{
				$this->common->remind_users($marked);
				trigger_error($this->language->lang('ACP_USERREMINDER_USER_REMINDED', count($marked)) . adm_back_link($this->u_action), E_USER_NOTICE);
			}
			else
			{
				trigger_error($this->language->lang('ACP_USERREMINDER_NO_USER_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		$deletemark = $this->request->is_set_post('delmarked');
		if ($deletemark)
		{
			$marked = $this->request->variable('mark_delete', [0]);
			if (count($marked) > 0)
			{
				if (confirm_box(true))
				{
					$this->common->delete_users($marked);
					trigger_error($this->language->lang('ACP_USERREMINDER_USER_DELETED', count($marked)) . adm_back_link($this->u_action), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, '<p>' . $this->language->lang('ACP_USERREMINDER_CONFIRM_USER_DELETE', count($marked)) . '</p>', build_hidden_fields([
						'delmarked'		=> $deletemark,
						'mark_delete'	=> $marked,
						'sk'			=> $sort_key,
						'sd'			=> $sort_dir,
						'action'		=> $this->u_action,
					]));
				}
			}
			else
			{
				trigger_error($this->language->lang('ACP_USERREMINDER_NO_USER_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

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

		// ignore anonymous (=== guest), bots, inactive and deactivated users
		// ignore users who have never posted anything (they are dealt with in the "zeroposter" tab)
		$sql = 'SELECT user_id, group_id, user_regdate, username, user_posts, mot_last_login, user_colour, mot_reminded_one, mot_reminded_two ' .
				'FROM  ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('user_type', [USER_NORMAL, USER_FOUNDER]) . '
				AND user_posts > 0
				AND mot_last_login > 0
				AND mot_last_login <= ' . (int) $day_limit;					// get all users who have been online at least once and inactive for at least the number of days specified in settings

		$sql .= !empty($protected_members) ? ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true) : '';	// prevent sql errors due to empty arrays
		$sql .= !empty($protected_groups) ? ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true) : '';
		$sql .= ' ORDER BY ' . $this->db->sql_escape($sort_key) . ' ' . $this->db->sql_escape($sort_dir);

		$result = $this->db->sql_query($sql);
		$reminders = $this->db->sql_fetchrowset($result);
		$count_reminders = count($reminders);
		$this->db->sql_freeresult($result);
		$reminder_ids = [];
		foreach ($reminders as $row)			// those variables need to be set here because otherwise it would depend on the values of users shown on the current pagination page
		{
			$enable_sort_one = $row['mot_reminded_one'] > 0 ? true : $enable_sort_one;
			$enable_sort_two = $row['mot_reminded_two'] > 0 ? true : $enable_sort_two;
			$reminder_ids[] = $row['user_id'];	// To get ids of all users to be reminded for the remind_all and delete_all buttons
		}

		// If remind_all or delete_all have been used we have to collect those users' id eligible for reminding or deleting (must have been offline for more than the selected number of inactive days)
		$remind_all = $this->request->is_set_post('remind_all');
		$delete_all = $this->request->is_set_post('delete_all');
		if ($remind_all || $delete_all)
		{
			if ($remind_all && (count($reminder_ids) > 0))
			{
				$this->common->remind_users($reminder_ids);
				trigger_error($this->language->lang('ACP_USERREMINDER_USER_REMINDED', count($reminder_ids)) . adm_back_link($this->u_action), E_USER_NOTICE);
			}

			if ($delete_all && (count($reminder_ids) > 0))
			{
				if (confirm_box(true))
				{
					$this->common->delete_users($reminder_ids);
					trigger_error($this->language->lang('ACP_USERREMINDER_USER_DELETED', count($reminder_ids)) . adm_back_link($this->u_action), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, '<p>' . $this->language->lang('ACP_USERREMINDER_CONFIRM_USER_DELETE', count($reminder_ids)) . '</p>', build_hidden_fields([
						'delete_all'	=> true,
						'sk'			=> $sort_key,
						'sd'			=> $sort_dir,
						'action'		=> $this->u_action,
					]));
				}
			}
		}

		$result = $this->db->sql_query_limit( $sql, $limit, $start );
		$reminders = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		//base url for pagination, filtering and sorting
		$base_url = $this->u_action
									. "&amp;sort_key=" . $sort_key
									. "&amp;sort_dir=" . $sort_dir;

		// Load pagination
		$start = $this->pagination->validate_start($start, $limit, $count_reminders);
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $count_reminders, $limit, $start);

		// write data into reminder array (output by template)
		$enable_remind = $delete_enabled = false;
		foreach ($reminders as $row)
		{
			$no_offline_days = (int) (($now - $row['mot_last_login']) / self::SECS_PER_DAY);
			$date_reminder_one = ($row['mot_reminded_one'] > 0) ? $this->user->format_date($row['mot_reminded_one']) : '-';
			$reminder_one_ago = ($row['mot_reminded_one'] > 0) ? (int) (($now - $row['mot_reminded_one']) / self::SECS_PER_DAY) : '-';
			$reminder_enabled = (($row['mot_reminded_one'] == 0) || (($row['mot_reminded_two'] == 0) && ($reminder_one_ago >= $this->config['mot_ur_days_reminded'])));
			$date_reminder_two = ($row['mot_reminded_two'] > 0) ? $this->user->format_date($row['mot_reminded_two']) : '-';
			$reminder_two_ago = ($row['mot_reminded_two'] > 0) ? (int) (($now - $row['mot_reminded_two']) / self::SECS_PER_DAY) : '-';
			$enable_delete = ($reminder_two_ago >= $this->config['mot_ur_days_until_deleted']);
			$enable_remind = $reminder_enabled ? true : $enable_remind;
			$delete_enabled = $enable_delete ? true : $delete_enabled;

			$this->template->assign_block_vars('reminders', [
				'SERVER_CONFIG'		=> append_sid("{$this->root_path}memberlist.$this->php_ext", ['mode' => 'viewprofile', 'u' => $row['user_id']]),
				'USERNAME'			=> $row['username'],
				'USER_COLOUR'		=> $row['user_colour'],
				'JOINED'			=> $this->user->format_date($row['user_regdate']),
				'USER_POSTS'		=> $row['user_posts'],
				'LAST_VISIT'		=> $this->user->format_date($row['mot_last_login']),
				'OFFLINE_DAYS'		=> $no_offline_days,
				'REMINDER_ONE'		=> $date_reminder_one,
				'ONE_AGO'			=> $reminder_one_ago,
				'REMINDER_ENABLED'	=> $reminder_enabled,
				'REMINDER_TWO'		=> $date_reminder_two,
				'TWO_AGO'			=> $reminder_two_ago,
				'DEL_ENABLED'		=> $enable_delete,
				'USER_ID'			=> $row['user_id'],
			]);
		}

		$this->template->assign_vars([
			'SORT_KEY'						=> $sort_key,
			'SORT_DIR'						=> $sort_dir,
			'SORT_ONE_ABLE'					=> $enable_sort_one,
			'SORT_TWO_ABLE'					=> $enable_sort_two,
			'ENABLE_REMIND'					=> $enable_remind,
			'ENABLE_DELETE'					=> $delete_enabled,
			'SHOW_EXPERT_MODE'				=> $this->config['mot_ur_expert_mode'],
			'USERREMINDER_VERSION'			=> $this->language->lang('ACP_USERREMINDER_VERSION', $this->userreminder_version, date('Y')),
			'ACP_MOT_UR_REMIND_COUNT'		=> $count_reminders,
		]);
	}


	public function sleeper()
	{
		add_form_key('acp_userreminder_registered_only');

		$now = time();

		// set parameter for pagination
		$limit = $this->config['mot_ur_rows_per_page'];	// max lines per page

		// get sort variables from template (if we are in a loop of the pagination). At first call there are no variables from the (so far uncalled) template -> we have to set initial parameters for sorting
		$sort_key = $this->request->is_set('sort_key') ? $this->request->variable('sort_key', '') : 'user_regdate';
		$sort_dir = $this->request->is_set('sort_dir') ? $this->request->variable('sort_dir', '') : 'ASC';

		if ($this->request->is_set_post('rem_marked'))
		{
			$marked = $this->request->variable('mark_remind', [0]);
			if (count($marked) > 0)
			{
				$this->common->remind_sleepers($marked);
				trigger_error($this->language->lang('ACP_USERREMINDER_USER_REMINDED', count($marked)) . adm_back_link($this->u_action), E_USER_NOTICE);
			}
			else
			{
				trigger_error($this->language->lang('ACP_USERREMINDER_NO_USER_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		$deletemark = $this->request->is_set_post('delmarked');
		if ($deletemark)
		{
			$marked = $this->request->variable('mark_delete', [0]);
			if (count($marked) > 0)
			{
				if (confirm_box(true))
				{
					$this->common->delete_users($marked);
					trigger_error($this->language->lang('ACP_USERREMINDER_USER_DELETED', count($marked)) . adm_back_link($this->u_action), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, $this->language->lang('ACP_USERREMINDER_CONFIRM_USER_DELETE', count($marked)), build_hidden_fields([
						'delmarked'		=> $deletemark,
						'mark_delete'	=> $marked,
						'sd'			=> $sort_dir,
						'action'		=> $this->u_action,
					]));
				}
			}
			else
			{
				trigger_error($this->language->lang('ACP_USERREMINDER_NO_USER_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		if ($this->request->is_set_post('sort'))
		{
			// sort key and/or direction have been changed in the template, so we set them here
			$sort_key = $this->request->variable('sort_key', 'user_regdate'); // in case the sort key can not be selected use this as the default
			$sort_dir = $this->request->variable('sort_dir', '');
			// and start with the first page
			$start = 0;
		}
		else
		{
			$start = $this->request->variable('start', 0);
		}

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

		// Get all unproteced sleepers
		$sql = 'SELECT user_id, group_id, username, user_colour, user_regdate, mot_sleeper_remind
				FROM  ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('user_type', [USER_NORMAL,USER_FOUNDER]) . '
				AND mot_last_login = 0';															// select users who have never been online
		$sql .= !empty($protected_members) ? ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true) : '';	// prevent sql errors due to empty arrays
		$sql .= !empty($protected_groups) ? ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true) : '';
		$sql .= ' ORDER BY ' . $this->db->sql_escape($sort_key) . ' ' . $this->db->sql_escape($sort_dir);

		$result = $this->db->sql_query($sql);
		$sleepers = $this->db->sql_fetchrowset($result);
		$count_sleepers = count($sleepers);
		$this->db->sql_freeresult($result);

		$enable_sort_remind = false;
		$sleeper_inactive_days = $this->config['mot_ur_sleeper_inactive_days'];
		$del_sleeper_ids = [];
		$rem_sleeper_ids = [];
		foreach ($sleepers as $row)
		{
			if ($row['mot_sleeper_remind'] > 0)
			{
				$enable_sort_remind = true;
			}
			$del_sleeper_ids[] = $row['user_id'];	// Get all ID's for 'delete all'
			if (($row['mot_sleeper_remind'] == 0) && (($now - $row['user_regdate']) >= $sleeper_inactive_days))
			{
				$rem_sleeper_ids[] = $row['user_id'];
			}
		}

		$remind_all = $this->request->is_set_post('remind_all');
		$delete_all = $this->request->is_set_post('delete_all');
		if ($remind_all || $delete_all)
		{
			if ($remind_all && (count($rem_sleeper_ids) > 0))
			{
				$this->common->remind_sleepers($rem_sleeper_ids);
				trigger_error($this->language->lang('ACP_USERREMINDER_USER_REMINDED', count($rem_sleeper_ids)) . adm_back_link($this->u_action), E_USER_NOTICE);
			}

			if ($delete_all && (count($del_sleeper_ids) > 0))
			{
				if (confirm_box(true))
				{
					$this->common->delete_users($del_sleeper_ids);
					trigger_error($this->language->lang('ACP_USERREMINDER_USER_DELETED', count($del_sleeper_ids)) . adm_back_link($this->u_action), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, '<p>' . $this->language->lang('ACP_USERREMINDER_CONFIRM_USER_DELETE', count($del_sleeper_ids)) . '</p>', build_hidden_fields([
						'delete_all'	=> true,
						'sk'			=> $sort_key,
						'sd'			=> $sort_dir,
						'action'		=> $this->u_action,
					]));
				}
			}
		}

		$result = $this->db->sql_query_limit( $sql, $limit, $start );
		$registered_only = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		//base url for pagination, filtering and sorting
		$base_url = $this->u_action
									. "&amp;sort_key=" . $sort_key
									. "&amp;sort_dir=" . $sort_dir;

		// Load pagination
		$start = $this->pagination->validate_start($start, $limit, $count_sleepers);
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $count_sleepers, $limit, $start);

		$enable_remind = $delete_enabled = false;

		// write data into sleeper array (output by template)
		foreach ($registered_only as $row)
		{
			// since still all sleepers are displayed we have to make certain that only those with more than the selected number of inactive days are selectable for reminding
			$reminder_enabled = (($row['mot_sleeper_remind'] == 0) && (($now - $row['user_regdate']) >= $this->config['mot_ur_sleeper_inactive_days'])) ? true : false;
			$enable_delete = (($row['mot_sleeper_remind'] > 0) && (($now - $row['mot_sleeper_remind']) >= $this->config['mot_ur_sleeper_deletetime'])) ? true : false;
			$enable_remind = $reminder_enabled ? true : $enable_remind;
			$delete_enabled = $enable_delete ? true : $delete_enabled;

			$this->template->assign_block_vars('registered_only', [
				'SERVER_CONFIG'		=> append_sid("{$this->root_path}memberlist.$this->php_ext", ['mode' => 'viewprofile', 'u' => $row['user_id']]),
				'USERNAME'			=> $row['username'],
				'USER_COLOUR'		=> $row['user_colour'],
				'JOINED'			=> $this->user->format_date($row['user_regdate']),
				'OFFLINE_DAYS'		=> (int) (( $now - $row['user_regdate']) / self::SECS_PER_DAY),
				'REMINDED_DATE'		=> ($row['mot_sleeper_remind'] > 0) ? $this->user->format_date($row['mot_sleeper_remind']) : '-',
				'REMINDED_AGO'		=> ($row['mot_sleeper_remind'] > 0) ? (int) (($now - $row['mot_sleeper_remind']) / self::SECS_PER_DAY) : '-',
				'REMINDER_ENABLED'	=> $reminder_enabled,
				'DEL_ENABLED'		=> $enable_delete,
				'USER_ID'			=> $row['user_id'],
			]);
		}

		$this->template->assign_vars([
			'REMIND_SLEEPER'			=> $this->config['mot_ur_remind_sleeper'],
			'SORT_KEY'					=> $sort_key,
			'SORT_DIR'					=> $sort_dir,
			'ENABLE_SORT_REMIND'		=> $enable_sort_remind,
			'ENABLE_REMIND'				=> $enable_remind,
			'ENABLE_DELETE'				=> $delete_enabled,
			'SHOW_EXPERT_MODE'			=> $this->config['mot_ur_expert_mode'],
			'USERREMINDER_VERSION'		=> $this->language->lang('ACP_USERREMINDER_VERSION', $this->userreminder_version, date('Y')),
			'ACP_MOT_UR_SLEEPER_COUNT'	=> $count_sleepers,
		]);
	}


	public function zeroposter()
	{
		$now = time();
		$day_limit = $now - (self::SECS_PER_DAY * (int) $this->config['mot_ur_zp_inactive_days']);

		// set parameter for pagination
		$limit = $this->config['mot_ur_rows_per_page'];	// max lines per page

		// get sort variables from template (if we are in a loop of the pagination). At first call there are no variables from the (so far uncalled) template -> we have to set initial parameters for sorting
		$sort_key = $this->request->is_set('sort_key') ? $this->request->variable('sort_key', '') : 'mot_last_login';
		$sort_dir = $this->request->is_set('sort_dir') ? $this->request->variable('sort_dir', '') : 'ASC';

		$enable_sort_one = $enable_sort_two = false;

		add_form_key('acp_userreminder_zeroposter');

		if ($this->request->is_set_post('rem_marked'))
		{
			$marked = $this->request->variable('mark_remind', [0]);
			if (count($marked) > 0)
			{
				$this->common->remind_users($marked, true);
				trigger_error($this->language->lang('ACP_USERREMINDER_USER_REMINDED', count($marked)) . adm_back_link($this->u_action), E_USER_NOTICE);
			}
			else
			{
				trigger_error($this->language->lang('ACP_USERREMINDER_NO_USER_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		$deletemark = $this->request->is_set_post('delmarked');
		if ($deletemark)
		{
			$marked = $this->request->variable('mark_delete', [0]);
			if (count($marked) > 0)
			{
				if (confirm_box(true))
				{
					$this->common->delete_users($marked);
					trigger_error($this->language->lang('ACP_USERREMINDER_USER_DELETED', count($marked)) . adm_back_link($this->u_action), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, '<p>' . $this->language->lang('ACP_USERREMINDER_CONFIRM_USER_DELETE', count($marked)) . '</p>', build_hidden_fields([
						'delmarked'		=> $deletemark,
						'mark_delete'	=> $marked,
						'sk'			=> $sort_key,
						'sd'			=> $sort_dir,
						'action'		=> $this->u_action,
					]));
				}
			}
			else
			{
				trigger_error($this->language->lang('ACP_USERREMINDER_NO_USER_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		if ($this->request->is_set_post('sort'))
		{
			// sort key and/or direction have been changed in the template, so we set them here
			$sort_key = $this->request->variable('sort_key', '');
			$sort_dir = $this->request->variable('sort_dir', '');
			// and start with the first page
			$start = 0;
		}
		else
		{
			$start = $this->request->variable('start', 0);
		}

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

		$sql = 'SELECT user_id, group_id, username, user_colour, user_regdate, mot_last_login, mot_reminded_one, mot_reminded_two
				FROM  ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('user_type', [USER_NORMAL, USER_FOUNDER]) . ' ' .		// ignore anonymous (=== guest), bots, inactive and deactivated users
				'AND user_posts = 0 ' .							// only users with zero posts (zeroposters)
				'AND mot_last_login > 0';						// ignore users who have never been online after registration
		$sql .= $this->config['mot_ur_remind_zeroposter'] ? ' AND mot_last_login < ' . $day_limit : '';	// get all zeroposters who have been inactive longer than the configured limit
		$sql .= !empty($protected_members) ? ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true) : '';	// prevent sql errors due to empty arrays
		$sql .= !empty($protected_groups) ? ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true) : '';
		$sql .= ' ORDER BY ' . $this->db->sql_escape($sort_key) . ' ' . $this->db->sql_escape($sort_dir);

		$result = $this->db->sql_query($sql);
		$zero_posters = $this->db->sql_fetchrowset($result);
		$count_zeroposters = count($zero_posters);
		$this->db->sql_freeresult($result);
		$del_zero_poster_ids = [];
		$rem_zero_poster_ids = [];
		foreach ($zero_posters as $row)			// those variables need to be set here because otherwise it would depend on the values of users shown on the current pagination page
		{
			$enable_sort_one = $row['mot_reminded_one'] > 0 ? true : $enable_sort_one;
			$enable_sort_two = $row['mot_reminded_two'] > 0 ? true : $enable_sort_two;
			// Since we haven't only users logged in earlier than the limit to be reminded we have to distinguish here between users to be reminded and to be deleted
			$del_zero_poster_ids[] = $row['user_id'];
			if ($row['mot_last_login'] <= $day_limit)
			{
				$rem_zero_poster_ids[] = $row['user_id'];
			}
		}

		$remind_all = $this->request->is_set_post('remind_all');
		$delete_all = $this->request->is_set_post('delete_all');
		if ($remind_all || $delete_all)
		{
			if ($remind_all && (count($rem_zero_poster_ids) > 0))
			{
				$this->common->remind_users($rem_zero_poster_ids, true);
				trigger_error($this->language->lang('ACP_USERREMINDER_USER_REMINDED', count($rem_zero_poster_ids)) . adm_back_link($this->u_action), E_USER_NOTICE);
			}

			if ($delete_all && (count($del_zero_poster_ids) > 0))
			{
				if (confirm_box(true))
				{
					$this->common->delete_users($del_zero_poster_ids);
					trigger_error($this->language->lang('ACP_USERREMINDER_USER_DELETED', count($del_zero_poster_ids)) . adm_back_link($this->u_action), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, '<p>' . $this->language->lang('ACP_USERREMINDER_CONFIRM_USER_DELETE', count($del_zero_poster_ids)) . '</p>', build_hidden_fields([
						'delete_all'	=> true,
						'sk'			=> $sort_key,
						'sd'			=> $sort_dir,
						'action'		=> $this->u_action,
					]));
				}
			}
		}

		$result = $this->db->sql_query_limit( $sql, $limit, $start );
		$zero_posters = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		//base url for pagination, filtering and sorting
		$base_url = $this->u_action
									. "&amp;sort_key=" . $sort_key
									. "&amp;sort_dir=" . $sort_dir;

		// Load pagination
		$start = $this->pagination->validate_start($start, $limit, $count_zeroposters);
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $count_zeroposters, $limit, $start);

		// write data into zeroposter array (output by template)
		$enable_remind = $delete_enabled = false;
		foreach ($zero_posters as $row)
		{
			$no_of_days = (int) (($now - $row['mot_last_login']) / self::SECS_PER_DAY);
			$date_reminder_one = ($row['mot_reminded_one'] > 0) ? $this->user->format_date($row['mot_reminded_one']) : '-';
			$reminder_one_ago = ($row['mot_reminded_one'] > 0) ? (int) (($now - $row['mot_reminded_one']) / self::SECS_PER_DAY) : '-';
			// since still all zeroposters are displayed we have to make certain that only those with more than the selected number of inactive days are selectable for reminding
			$reminder_enabled = ((($row['mot_reminded_one'] == 0) && ($no_of_days >= $this->config['mot_ur_zp_inactive_days'])) || (($row['mot_reminded_two'] == 0) && ($reminder_one_ago >= $this->config['mot_ur_days_reminded']))) ? true : false;
			$date_reminder_two = ($row['mot_reminded_two'] > 0) ? $this->user->format_date($row['mot_reminded_two']) : '-';
			$reminder_two_ago = ($row['mot_reminded_two'] > 0) ? (int) (($now - $row['mot_reminded_two']) / self::SECS_PER_DAY) : '-';
			$enable_delete = ($reminder_two_ago >= $this->config['mot_ur_zp_days_until_deleted']) ? true : false;
			$enable_remind = $reminder_enabled ? true : $enable_remind;
			$delete_enabled = $enable_delete ? true : $delete_enabled;

			$this->template->assign_block_vars('zeroposter', [
				'SERVER_CONFIG'		=> append_sid("{$this->root_path}memberlist.$this->php_ext", ['mode' => 'viewprofile', 'u' => $row['user_id'],]),
				'USERNAME'			=> $row['username'],
				'USER_COLOUR'		=> $row['user_colour'],
				'JOINED'			=> $this->user->format_date($row['user_regdate']),
				'LAST_VISIT'		=> $this->user->format_date($row['mot_last_login']),
				'OFFLINE_DAYS'		=> $no_of_days,
				'REMINDER_ONE'		=> $date_reminder_one,
				'ONE_AGO'			=> $reminder_one_ago,
				'REMINDER_ENABLED'	=> $reminder_enabled,
				'REMINDER_TWO'		=> $date_reminder_two,
				'TWO_AGO'			=> $reminder_two_ago,
				'DEL_ENABLED'		=> $enable_delete,
				'USER_ID'			=> $row['user_id'],
			]);
		}

		$this->template->assign_vars([
			'SORT_KEY'						=> $sort_key,
			'SORT_DIR'						=> $sort_dir,
			'REMIND_ZEROPOSTERS'			=> (bool) $this->config['mot_ur_remind_zeroposter'],
			'SORT_ONE_ABLE'					=> $enable_sort_one,
			'SORT_TWO_ABLE'					=> $enable_sort_two,
			'ENABLE_REMIND'					=> $enable_remind,
			'ENABLE_DELETE'					=> $delete_enabled,
			'SHOW_EXPERT_MODE'				=> $this->config['mot_ur_expert_mode'],
			'USERREMINDER_VERSION'			=> $this->language->lang('ACP_USERREMINDER_VERSION', $this->userreminder_version, date('Y')),
			'U_ACTION'						=> $this->u_action,
			'ACP_MOT_UR_ZP_COUNT'			=> $count_zeroposters,
		]);
	}


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Set custom form action.
	 *
	 * @param	string	$u_action	Custom form action
	 * @return acp		$this		This controller for chaining calls
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;

		return $this;
	}
}
