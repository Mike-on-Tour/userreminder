<?php

/**
*
* @package UserReminder v1.2.x
* @copyright (c) 2019, 2020 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\acp;

class settings_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	public function main()
	{
	global $user, $language, $template, $request, $config, $phpbb_container, $phpbb_root_path, $phpEx;

		$this->tpl_name = 'acp_ur_settings';
		$this->page_title = $language->lang('ACP_USERREMINDER');
		$this->config_text = $phpbb_container->get('config_text');

		add_form_key('acp_userreminder_settings');

		$lang_dir = $phpbb_root_path . 'ext/mot/userreminder/language';
		$ur_lang = $ur_file = $ur_email_text = $preview_text = '';
		$show_preview = $show_filecontent = false;
		$lang_arr = array (
			'reminder_one'	=> $language->lang('ACP_USERREMINDER_MAIL_ONE'),
			'reminder_two'	=> $language->lang('ACP_USERREMINDER_MAIL_TWO'),
		);

		/*
		* this IF clause gets activated when the 'submit' button is pressed, writes all settings to $config
		*/
		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_userreminder_settings'))
			{
				trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// save the settings to the phpbb_config table
			$config->set('mot_ur_inactive_days', $request->variable('mot_ur_inactive_days', 0, 3));
			$config->set('mot_ur_days_reminded', $request->variable('mot_ur_days_reminded', 0, 3));
			$config->set('mot_ur_autoremind', ($request->variable('mot_ur_autoremind', 0)) ? '1' : '0');
			$config->set('mot_ur_days_until_deleted', $request->variable('mot_ur_days_until_deleted', 0, 3));
			$config->set('mot_ur_autodelete', ($request->variable('mot_ur_autodelete', 0)) ? '1' : '0');
			$protected_members = substr($request->variable('mot_ur_protected_members', ''), 0, 255);
			$protected_members = preg_replace('/[ ]/', '', $protected_members); // get rid of any spaces
			$config->set('mot_ur_protected_members', $protected_members);
			$config->set('mot_ur_email_bcc', substr($request->variable('mot_ur_email_bcc', ''), 0, 255));
			$config->set('mot_ur_email_cc', substr($request->variable('mot_ur_email_cc', ''), 0, 255));

			trigger_error($language->lang('ACP_USERREMINDER_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		/*
		* This IF clause gets activated when the 'load file' button is pressed and loads the respective file defined by $ur_lang and $ur_file from the drive
		*/
		if ($request->is_set_post('load_file'))
		{
			$show_filecontent = true;
			$ur_lang = $request->variable('mot_ur_mail_lang', '');
			$ur_file = $request->variable('mot_ur_mail_file', '');
			// check for malign changes by injecting another path
			if (preg_match('[\W]', $ur_lang) || preg_match('[\W]', $ur_file))
			{
				trigger_error($language->lang('ACP_USERREMINDER_FILE_NOT_FOUND', $ur_lang . '/' . $ur_file) . adm_back_link($this->u_action), E_USER_WARNING);
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
		if ($request->is_set_post('preview'))
		{
			$show_preview = true;
			$show_filecontent = true;
			$ur_lang = $request->variable('mot_ur_mail_lang', '');
			$ur_file = $request->variable('mot_ur_mail_file', '');
			$ur_email_text = $request->variable('mot_ur_mail_text', '', true);
			$preview_text = $ur_email_text;

			$token = array('{SITENAME}', '{USERNAME}', '{LAST_VISIT}', '{LAST_REMIND}', '{DAYS_INACTIVE}', '{FORGOT_PASS}',
							'{ADMIN_MAIL}', '{DAYS_TIL_DELETE}', '{EMAIL_SIG}');
			$real_text = array($config['sitename'], $user->data['username'], $user->format_date($user->data['user_lastvisit']),
							$user->format_date($user->data['mot_reminded_one']), $config['mot_ur_inactive_days'],
							$config['server_protocol'].$config['server_name']."/ucp.".$phpEx."?mode=sendpassword",
							$config['board_contact'], $config['mot_ur_days_until_deleted'], $config['board_email_sig']);
			$preview_text = str_replace($token, $real_text, $preview_text);

			$flags = 0;
			$uid = $bitfield = '';
			$preview_text = generate_text_for_display($preview_text, $uid, $bitfield, $flags);
		}

		/*
		* This IF clause gets activated when the 'save file' button is pressed and saves the respective text defined by $ur_lang and $ur_file to the db
		*/
		if ($request->is_set_post('save_file'))
		{
			$ur_lang = $request->variable('mot_ur_mail_lang', '');
			$ur_file = $request->variable('mot_ur_mail_file', '');
			$ur_email_text = $request->variable('mot_ur_mail_text', '', true);

			$email_arr = json_decode($this->config_text->get('mot_ur_email_texts'), true);
			$email_arr[$ur_lang][$ur_file] = $ur_email_text;
			$this->config_text->set('mot_ur_email_texts', json_encode($email_arr));
			trigger_error($language->lang('ACP_USERREMINDER_FILE_SAVED', $ur_lang . '/' . $lang_arr[$ur_file]) . adm_back_link($this->u_action), E_USER_NOTICE);
		}

		$dirs = $this->load_dirs($lang_dir);
		foreach ($dirs as $value)
		{
			$template->assign_block_vars('langs', array(
				'VALUE'		=> $value,
			));
		}
		$template->assign_vars(array(
			'ACP_USERREMINDER_INACTIVE_DAYS'		=> $config['mot_ur_inactive_days'],
			'ACP_USERREMINDER_DAYS_REMINDED'		=> $config['mot_ur_days_reminded'],
			'ACP_USERREMINDER_AUTOREMIND'			=> $config['mot_ur_autoremind'] ? true : false,
			'ACP_USERREMINDER_DAYS_UNTIL_DELETED'	=> $config['mot_ur_days_until_deleted'],
			'ACP_USERREMINDER_AUTODELETE'			=> $config['mot_ur_autodelete'] ? true : false,
			'ACP_USERREMINDER_PROTECTED_MEMBERS'	=> $config['mot_ur_protected_members'],
			'ACP_USERREMINDER_EMAIL_BCC'			=> $config['mot_ur_email_bcc'],
			'ACP_USERREMINDER_EMAIL_CC'				=> $config['mot_ur_email_cc'],
			'ACP_USERREMINDER_EMAIL_TEXT'			=> $ur_email_text,
			'U_ACTION'								=> $this->u_action,
			'CHOOSE_LANG'							=> $ur_lang,
			'CHOOSE_FILE'							=> $ur_file,
			'SHOW_FILECONTENT'						=> $show_filecontent,
			'PREVIEW_TEXT'							=> $preview_text,
			'SHOW_PREVIEW'							=> $show_preview,
		));
	}


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	/*
	* Loads all language directories of ext/mot/userreminder/language
	* Returns an array with all found directories
	*/
	protected function load_dirs($dir)
	{
		$result = array();
		$dir_ary = scandir($dir);
		foreach ($dir_ary as $value)
		{
			if (!in_array($value,array(".","..")))
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
