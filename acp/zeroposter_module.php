<?php

/**
*
* @package UserReminder v1.3.5
* @copyright (c) 2019, 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\acp;

class zeroposter_module
{
	const SECS_PER_DAY = 86400;

	protected $db;
	protected $template;
	protected $request;
	protected $config;
	protected $phpbb_container;
	protected $user;
	protected $phpEx;
	public $u_action;

	public function main($id, $mode)
	{
		global $db, $template, $request, $config, $phpbb_container, $user, $phpbb_root_path, $phpEx;

		$this->db = $db;
		$this->template = $template;
		$this->request = $request;
		$this->config = $config;
		$this->phpbb_container = $phpbb_container;
		$this->user = $user;
		$this->phpEx = $phpEx;

		$now = time();
		$language = $this->phpbb_container->get('language');
		$common = $this->phpbb_container->get('mot.userreminder.common');
		$remind_zeroposters = $this->config['mot_ur_remind_zeroposter'] ? true : false;

		// set parameter for pagination
		$limit = 25;	// max 25 lines per page

		// get sort variables from template (if we are in a loop of the pagination). At first call there are no variables from the (so far uncalled) template
		$sort_key = $this->request->variable('sort_key', '');
		$sort_dir = $this->request->variable('sort_dir', '');

		// First call of this script, we don't get any variables back from the template -> we have to set initial parameters for sorting
		if (empty($sort_key) && empty($sort_dir))
		{
			$sort_key = 'mot_last_login';
			$sort_dir = 'ASC';
		}

		$enable_sort_one = $enable_sort_two = false;

		$this->tpl_name = 'acp_ur_zeroposter';
		$this->page_title = $language->lang('ACP_USERREMINDER');

		add_form_key('acp_userreminder_zeroposter');

		if ($this->request->is_set_post('rem_marked'))
		{
			$marked = $this->request->variable('mark_remind', array(0));
			if (count($marked) > 0)
			{
				$common->remind_users($marked);
				trigger_error($language->lang('USER_REMINDED', count($marked)) . adm_back_link($this->u_action), E_USER_NOTICE);
			}
			else
			{
				trigger_error($language->lang('NO_USER_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		$deletemark = ($this->request->is_set_post('delmarked')) ? true : false;
		if ($deletemark)
		{
			$marked = $this->request->variable('mark_delete', array(0));
			if (count($marked) > 0)
			{
				if (confirm_box(true))
				{
					$common->delete_users($marked);
					trigger_error($language->lang('USER_DELETED', count($marked)) . adm_back_link($this->u_action), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, '<p>'.$language->lang('CONFIRM_USER_DELETE', count($marked)).'</p>', build_hidden_fields(array(
						'delmarked'		=> $deletemark,
						'mark_delete'	=> $marked,
						'sk'			=> $sort_key,
						'sd'			=> $sort_dir,
						'i'				=> $id,
						'mode'			=> $mode,
						'action'		=> $this->u_action,
					)));
				}
			}
			else
			{
				trigger_error($language->lang('NO_USER_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
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
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$protected_members[] = $row['ban_userid'];
		}
		$db->sql_freeresult($result);

		// this query is identical for both cases, therefore we have to define it only once
		$query = 'SELECT user_id, group_id, username, user_colour, user_regdate, mot_last_login, mot_reminded_one, mot_reminded_two
				FROM  ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER)) . ' ' .		// ignore anonymous (=== guest), bots, inactive and deactivated users
				'AND user_posts = 0 ' .							// only users with zero posts (zero posters)
				'AND mot_last_login > 0';						// ignore users who have never been online after registration
		if (!empty($protected_members))	// prevent sql errors due to empty array
		{
			$query .= ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true);
		}
		if (!empty($protected_groups))
		{
			$query .= ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true);
		}
		$query .= ' ORDER BY ' . $this->db->sql_escape($sort_key) . ' ' . $this->db->sql_escape($sort_dir);

		if ($remind_zeroposters)
		{
			// if zeroposters are to be reminded we need to get all of them at this time since we have to get the values for sorting by first and second reminder (like in the reminder module)
			$result = $this->db->sql_query($query);
			$zero_posters = $this->db->sql_fetchrowset($result);
			$count_zeroposters = count($zero_posters);
			$this->db->sql_freeresult($result);
			foreach ($zero_posters as $row)			// those variables need to be set here because otherwise it would depend on the values of users shown on the current pagination page
			{
				if ($row['mot_reminded_one'] > 0)
				{
					$enable_sort_one = true;
				}
				if ($row['mot_reminded_two'] > 0)
				{
					$enable_sort_two = true;
				}
			}
		}
		else
		{
			// if zeroposters are not to be reminded we can get their total number easier through a count query
			$count_query = "SELECT COUNT(user_id) AS 'user_count' FROM " . USERS_TABLE . '
							WHERE ' . $this->db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER)) . '
							AND user_posts = 0
							AND mot_last_login > 0';
			if (!empty($protected_members))	// prevent sql errors due to empty array
			{
				$count_query .= ' AND ' . $this->db->sql_in_set('user_id', $protected_members, true);
			}
			if (!empty($protected_groups))
			{
				$count_query .= ' AND ' . $this->db->sql_in_set('group_id', $protected_groups, true);
			}
			$result = $this->db->sql_query($count_query);
			$row = $this->db->sql_fetchrow($result);
			$count_zeroposters = $row['user_count'];
			$this->db->sql_freeresult($result);

		}

		$result = $this->db->sql_query_limit( $query, $limit, $start );
		$zero_posters = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		//base url for pagination, filtering and sorting
		$base_url = $this->u_action
									. "&amp;sort_key=" . $sort_key
									. "&amp;sort_dir=" . $sort_dir;

		// Load pagination
		$pagination = $this->phpbb_container->get('pagination');
		$start = $pagination->validate_start($start, $limit, $count_zeroposters);
		$pagination->generate_template_pagination($base_url, 'pagination', 'start', $count_zeroposters, $limit, $start);

		// write data into zeroposter array (output by template)
		$enable_remind = $delete_enabled = false;
		foreach ($zero_posters as $row)
		{
			$no_of_days = (int) (($now - $row['mot_last_login']) / self::SECS_PER_DAY);
			$date_reminder_one = ($row['mot_reminded_one'] > 0) ? $this->user->format_date($row['mot_reminded_one']) : '-';
			$reminder_one_ago = ($row['mot_reminded_one'] > 0) ? (int) (($now - $row['mot_reminded_one']) / self::SECS_PER_DAY) : '-';
			// since still all zeroposters are displayed we have to make certain that only those with more than the selected number of inactive days are selectable for reminding
			$reminder_enabled = ((($row['mot_reminded_one'] == 0) && ($no_of_days >= $this->config['mot_ur_inactive_days'])) || (($row['mot_reminded_two'] == 0) && ($reminder_one_ago >= $this->config['mot_ur_days_reminded']))) ? true : false;
			$date_reminder_two = ($row['mot_reminded_two'] > 0) ? $this->user->format_date($row['mot_reminded_two']) : '-';
			$reminder_two_ago = ($row['mot_reminded_two'] > 0) ? (int) (($now - $row['mot_reminded_two']) / self::SECS_PER_DAY) : '-';
			$enable_delete = ($reminder_two_ago >= $this->config['mot_ur_days_until_deleted']) ? true : false;
			if ($reminder_enabled)
			{
				$enable_remind = true;
			}
			if ($enable_delete)
			{
				$delete_enabled = true;
			}
//echo append_sid("{$phpbb_root_path}memberlist.$this->phpEx", ['mode' => 'viewprofile', 'u' => $row['user_id']]);
			$this->template->assign_block_vars('zeroposter', array(
				'SERVER_CONFIG'		=> append_sid("{$phpbb_root_path}memberlist.$this->phpEx", ['mode' => 'viewprofile', 'u' => $row['user_id'],]),
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
			));
		}

		$this->template->assign_vars(array(
			'SORT_KEY'						=> $sort_key,
			'SORT_DIR'						=> $sort_dir,
			'REMIND_ZEROPOSTERS'			=> $remind_zeroposters,
			'SORT_ONE_ABLE'					=> $enable_sort_one,
			'SORT_TWO_ABLE'					=> $enable_sort_two,
			'ENABLE_REMIND'					=> $enable_remind,
			'ENABLE_DELETE'					=> $delete_enabled,
			'ACP_USERREMINDER_VERSION'		=> $this->config['mot_ur_version'],
			'ACP_USERREMINDER_YEAR'			=> date('Y'),
			'U_ACTION'						=> $this->u_action,
			)
		);
	}
}
