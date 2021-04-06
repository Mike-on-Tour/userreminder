<?php

/**
*
* @package UserReminder v1.3.5
* @copyright (c) 2019, 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\acp;

class registrated_only_module
{
	const SECS_PER_DAY = 86400;

	public $u_action;

	public function main($id, $mode)
	{
		global $db, $template, $request, $config, $phpbb_container, $user, $phpbb_root_path, $phpEx;

		$language = $phpbb_container->get('language');
		$this->tpl_name = 'acp_ur_registratedonly';
		$this->page_title = $language->lang('ACP_USERREMINDER');

		add_form_key('acp_userreminder_registered_only');

		$now = time();
		$common = $phpbb_container->get('mot.userreminder.common');

		// set parameter for pagination
		$limit = 25;	// max 25 lines per page

		// get sort variables from template (if we are in a loop of the pagination). At first call there are no variables from the (so far uncalled) template
		$sort_dir = $request->variable('sort_dir', '');

		// First call of this script, we don't get any variables back from the template -> we have to set initial parameters for sorting
		if (empty($sort_dir))
		{
			$sort_dir = 'ASC';
		}

		$deletemark = ($request->is_set_post('delmarked')) ? true : false;
		if ($deletemark)
		{
			$marked = $request->variable('mark', array(0));
			if (count($marked) > 0)
			{
				if (confirm_box(true))
				{
					$common->delete_users($marked);
					trigger_error($language->lang('USER_DELETED', count($marked)) . adm_back_link($this->u_action), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, $language->lang('CONFIRM_USER_DELETE', count($marked)), build_hidden_fields(array(
						'delmarked'	=> $deletemark,
						'mark'		=> $marked,
						'sd'		=> $sort_dir,
						'i'			=> $id,
						'mode'		=> $mode,
						'action'	=> $this->u_action,
					)));
				}
			}
			else
			{
				trigger_error($language->lang('NO_USER_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		if ($request->is_set_post('sort'))
		{
			// sort direction has been changed in the template, so we set it here
			$sort_dir = $request->variable('sort_dir', '');
			// and start with the first page
			$start = 0;
		}
		else
		{
			$start = $request->variable('start', 0);
		}

		// Get the protected members and groups arrays
		$protected_members = json_decode($config['mot_ur_protected_members']);
		$protected_groups = json_decode($config['mot_ur_protected_groups']);

		// Get user_ids of banned members since we don't want to remind them (they wouldn't be able to log in anyway), they will be handled as protected members to prevent reminding (and deletion)
		$sql = 'SELECT ban_userid FROM ' . BANLIST_TABLE . '
				WHERE ban_userid <> 0';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$protected_members[] = $row['ban_userid'];
		}
		$db->sql_freeresult($result);

		$query = 'SELECT user_id, group_id, username, user_colour, user_regdate
				FROM  ' . USERS_TABLE . '
				WHERE ' . $db->sql_in_set('user_type', array(USER_NORMAL,USER_FOUNDER)) . ' ' .		// ignore anonymous (=== guest), bots, inactive and deactivated users
				'AND mot_last_login = 0';															// select users who have never been online
		if (!empty($protected_members))				// prevent sql errors due to empty array
		{
			$query .= ' AND ' . $db->sql_in_set('user_id', $protected_members, true);
		}
		if (!empty($protected_groups))
		{
			$query .= ' AND ' . $db->sql_in_set('group_id', $protected_groups, true);
		}
		$query .= ' ORDER BY user_regdate ' . $db->sql_escape($sort_dir);

		$count_query = "SELECT COUNT(user_id) AS 'user_count' FROM " . USERS_TABLE . '
						WHERE ' . $db->sql_in_set('user_type', array(USER_NORMAL,USER_FOUNDER)) . '
						AND mot_last_login = 0 ';
		if (!empty($protected_members))				// prevent sql errors due to empty array
		{
			$count_query .= ' AND ' . $db->sql_in_set('user_id', $protected_members, true);
		}
		if (!empty($protected_groups))
		{
			$count_query .= ' AND ' . $db->sql_in_set('group_id', $protected_groups, true);
		}

		$result = $db->sql_query($count_query);
		$row = $db->sql_fetchrow($result);
		$count_registered_only = $row['user_count'];
		$db->sql_freeresult($result);

		$result = $db->sql_query_limit( $query, $limit, $start );
		$registered_only = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		//base url for pagination, filtering and sorting
		$base_url = $this->u_action
									. "&amp;sort_dir=" . $sort_dir;

		// Load pagination
		$pagination = $phpbb_container->get('pagination');
		$start = $pagination->validate_start($start, $limit, $count_registered_only);
		$pagination->generate_template_pagination($base_url, 'pagination', 'start', $count_registered_only, $limit, $start);

		// write data into zeroposter array (output by template)
		foreach ($registered_only as $row)
		{
			$no_of_days = (int) (( $now - $row['user_regdate']) / self::SECS_PER_DAY);
			$template->assign_block_vars('registered_only', array(
				'SERVER_CONFIG'	=> append_sid("{$phpbb_root_path}memberlist.$phpEx", ['mode' => 'viewprofile', 'u' => $row['user_id']]),
				'USERNAME'		=> $row['username'],
				'USER_COLOUR'	=> $row['user_colour'],
				'JOINED'		=> $user->format_date($row['user_regdate']),
				'OFFLINE_DAYS'	=> $no_of_days,
				'USER_ID'		=> $row['user_id'],
			));
		}

		$template->assign_vars(array(
			'SORT_DIR'						=> $sort_dir,
			'ACP_USERREMINDER_VERSION'		=> $config['mot_ur_version'],
			'ACP_USERREMINDER_YEAR'			=> date('Y'),
			)
		);

	}
}
