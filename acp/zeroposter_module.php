<?php

/**
*
* @package UserReminder v1.2.x
* @copyright (c) 2019, 2020 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\acp;

class zeroposter_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	public function main($id, $mode)
	{
		global $db, $language, $template, $request, $config, $phpbb_container, $user, $phpEx;

		$secs_per_day = 86400;
		$now = time();
		$server_config = $config['server_protocol'].$config['server_name'].$config['script_path'];
		$memberlist_config = '/memberlist.' . $phpEx . '?mode=viewprofile&u=';
		$common = $phpbb_container->get('mot.userreminder.common');

		// set parameter for pagination
		$limit = 25;	// max 25 lines per page

		// get sort variables from template (if we are in a loop of the pagination). At first call there are no variables from the (so far uncalled) template
		$sort_key = $request->variable('sort_key', '');
		$sort_dir = $request->variable('sort_dir', '');

		// First call of this script, we don't get any variables back from the template -> we have to set initial parameters for sorting
		if (empty($sort_key) && empty($sort_dir))
		{
			$sort_key = 'mot_last_login';
			$sort_dir = 'ASC';
		}

		$this->tpl_name = 'acp_ur_zeroposter';
		$this->page_title = $language->lang('ACP_USERREMINDER');

		add_form_key('acp_userreminder_zeroposter');

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
					confirm_box(false, '<p>'.$language->lang('CONFIRM_USER_DELETE', count($marked)).'</p>', build_hidden_fields(array(
						'delmarked'	=> $deletemark,
						'mark'		=> $marked,
						'sk'		=> $sort_key,
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
			// sort key and/or direction have been changed in the template, so we set them here
			$sort_key = $request->variable('sort_key', '');
			$sort_dir = $request->variable('sort_dir', '');
			// and start with the first page
			$start = 0;
		}
		else
		{
			$start = $request->variable('start', 0);
		}

		$query = 'SELECT user_id, username, user_colour, user_regdate, mot_last_login
				FROM  ' . USERS_TABLE . '
				WHERE ' . $db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER)) . ' ' .		// ignore anonymous (=== guest), bots, inactive and deactivated users
				'AND user_posts = 0 ' .							// only users with zero posts (zero posters)
				'AND mot_last_login > 0';						// ignore users who have never been online after registration
		if ($config['mot_ur_protected_members'] != '')	// prevent sql errors due to empty string
		{
			$query .= ' AND ' . $db->sql_in_set('user_id', explode(',', $config['mot_ur_protected_members']), true);
		}
		$query .= ' ORDER BY ' . $db->sql_escape($sort_key) . ' ' . $db->sql_escape($sort_dir);

		$count_query = "SELECT COUNT(user_id) AS 'user_count' FROM " . USERS_TABLE . '
						WHERE ' . $db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER)) . '
						AND user_posts = 0
						AND mot_last_login > 0';
		if ($config['mot_ur_protected_members'] != '')	// prevent sql errors due to empty string
		{
			$count_query .= ' AND ' . $db->sql_in_set('user_id', explode(',', $config['mot_ur_protected_members']), true);
		}
		$result = $db->sql_query($count_query);
		$row = $db->sql_fetchrow($result);
		$count_zeroposters = $row['user_count'];
		$db->sql_freeresult($result);

		$result = $db->sql_query_limit( $query, $limit, $start );
		$zero_posters = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		//base url for pagination, filtering and sorting
		$base_url = $this->u_action
									. "&amp;sort_key=" . $sort_key
									. "&amp;sort_dir=" . $sort_dir;

		// Load pagination
		$pagination = $phpbb_container->get('pagination');
		$start = $pagination->validate_start($start, $limit, $count_zeroposters);
		$pagination->generate_template_pagination($base_url, 'pagination', 'start', $count_zeroposters, $limit, $start);

		// write data into zeroposter array (output by template)
		foreach ($zero_posters as $row)
		{
			$no_of_days = (int) (($now - $row['mot_last_login']) / $secs_per_day);
			$template->assign_block_vars('zeroposter', array(
				'USERNAME'		=> $row['username'],
				'USER_COLOUR'	=> $row['user_colour'],
				'JOINED'		=> $user->format_date($row['user_regdate']),
				'LAST_VISIT'	=> $user->format_date($row['mot_last_login']),
				'OFFLINE_DAYS'	=> $no_of_days,
				'USER_ID'		=> $row['user_id'],
			));
		}

		$template->assign_vars(array(
			'SERVER_CONFIG'	=> $server_config,
			'MEMBERLIST'	=> $memberlist_config,
			'SORT_KEY'		=> $sort_key,
			'SORT_DIR'		=> $sort_dir,
			)
		);

	}
}
