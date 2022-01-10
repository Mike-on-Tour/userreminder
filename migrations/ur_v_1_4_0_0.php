<?php

/**
*
* @package User Reminder v1.4.0
* @copyright (c) 2019 - 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_4_0_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_3_5 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_3_5'];
	}

	public function update_data()
	{
		return [
			// remove old config values
			['config.remove', ['mot_ur_version']],

			// remove old modules
			['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_ZEROPOSTER']],
			// in case it is still there from a former version (update)
			['if', [
				['module.exists', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REGISTERED_ONLY']],
				['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REGISTERED_ONLY']],
			]],
			// in case it is there from fresh install
			['if', [
				['module.exists', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_SLEEPER']],
				['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_SLEEPER']],
			]],
			['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REMINDER']],
			['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_SETTINGS']],
		];
	}

	public function revert_data()
	{
		return [
			// add old config values
			['config.add', ['mot_ur_version', '']],

			// add old modules
			['module.add', [
				'acp',
				'ACP_USERREMINDER',
				[
					'module_basename'	=> '\mot\userreminder\acp\settings_module',
					'module_langname'	=> 'ACP_USERREMINDER_SETTINGS',
					'module_mode'		=> 'settings',
					'module_auth'		=> 'ext_mot/userreminder && acl_a_board',
				]
			]],
			['module.add', [
				'acp',
				'ACP_USERREMINDER',
				[
					'module_basename'	=> '\mot\userreminder\acp\reminder_module',
					'module_langname'	=> 'ACP_USERREMINDER_REMINDER',
					'module_mode'		=> 'reminders',
					'module_auth'		=> 'ext_mot/userreminder && acl_a_board',
				]
			]],
			['module.add', [
				'acp',
				'ACP_USERREMINDER',
				[
					'module_basename'	=> '\mot\userreminder\acp\registrated_only_module',
					'module_langname'	=> 'ACP_USERREMINDER_SLEEPER',
					'module_mode'		=> 'sleepers',
					'module_auth'		=> 'ext_mot/userreminder && acl_a_board',
				]
			]],
			['module.add', [
				'acp',
				'ACP_USERREMINDER',
				[
					'module_basename'	=> '\mot\userreminder\acp\zeroposter_module',
					'module_langname'	=> 'ACP_USERREMINDER_ZEROPOSTER',
					'module_mode'		=> 'zeroposters',
					'module_auth'		=> 'ext_mot/userreminder && acl_a_board',
				]
			]],
		];
	}
}
