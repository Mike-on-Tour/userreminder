<?php

/**
*
* @package User Reminder v1.4.1
* @copyright (c) 2019 - 2022 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_0_1_0 extends \phpbb\db\migration\migration
{

	/**
	* If our config variable already exists in the db
	* skip this migration.
	*/
	public function effectively_installed()
	{
		return isset($this->config['mot_ur_inactive_days']);
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'mot_reminded_one'	=> ['UINT:11', 0],
					'mot_reminded_two'	=> ['UINT:11', 0],
				],
			],
		];
	}

	public function update_data()
	{
		return array(
			// Add the config variable we want to be able to set
			['config.add', ['mot_ur_inactive_days', 70]],
			['config.add', ['mot_ur_days_reminded', 10]],
			['config.add', ['mot_ur_autoremind', 0]],				// 0 == false, 1 == true
			['config.add', ['mot_ur_days_until_deleted', 10]],
			['config.add', ['mot_ur_autodelete', 0]],				// 0 == false, 1 == true
			['config.add', ['mot_ur_protected_members', '']],

			// Add a parent module (ACP_USERREMINDER) to the Extensions tab (ACP_CAT_DOT_MODS)
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_USERREMINDER'
			]],

			// Add our settings_module to the parent module (ACP_USERREMINDER)
			['module.add', [
				'acp',
				'ACP_USERREMINDER',
				[
					'module_langname'	=> 'ACP_USERREMINDER_SETTINGS',
					'module_basename'	=> '\mot\userreminder\acp\settings_module',
					'module_mode'		=> 'settings',
					'module_auth'       => 'ext_mot/userreminder && acl_a_board',
				],
			]],
			['module.add', [
				'acp',
				'ACP_USERREMINDER',
				[
					'module_langname'	=> 'ACP_USERREMINDER_REMINDER',
					'module_basename'	=> '\mot\userreminder\acp\reminder_module',
					'module_mode'		=> 'reminder',
					'module_auth'       => 'ext_mot/userreminder && acl_a_board',
				],
			]],
			['module.add', [
				'acp',
				'ACP_USERREMINDER',
				[
					'module_langname'	=> 'ACP_USERREMINDER_REGISTERED_ONLY',
					'module_basename'	=> '\mot\userreminder\acp\registrated_only_module',
					'module_mode'		=> 'registrated_only',
					'module_auth'       => 'ext_mot/userreminder && acl_a_board',
				],
			]],
			['module.add', [
				'acp',
				'ACP_USERREMINDER',
				[
					'module_langname'	=> 'ACP_USERREMINDER_ZEROPOSTER',
					'module_basename'	=> '\mot\userreminder\acp\zeroposter_module',
					'module_mode'		=> 'zeroposter',
					'module_auth'       => 'ext_mot/userreminder && acl_a_board',
				],
			]],
		);
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'mot_reminded_one',
					'mot_reminded_two',
				],
			],
		];
	}
}
