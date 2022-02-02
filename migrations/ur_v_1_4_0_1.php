<?php

/**
*
* @package User Reminder v1.4.1
* @copyright (c) 2019 - 2022 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_4_0_1 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_4_0_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_4_0_0'];
	}

	public function update_data()
	{
		return [
			// add new modules
			['module.add', [
				'acp',
				'ACP_USERREMINDER',
				[
					'module_basename'	=> '\mot\userreminder\acp\main_module',
					'modes'				=> ['settings', 'reminder', 'sleeper', 'zeroposter',],
				]
			]],
			['module.add', [
				'acp',
				'ACP_QUICK_ACCESS',
				[
					'module_langname'	=> 'ACP_USERREMINDER_REMINDER',
					'module_basename'	=> '\mot\userreminder\acp\main2_module',
					'module_mode'		=> 'reminder2',
					'module_enabled'	=> false,
					'module_auth'       => 'ext_mot/userreminder && acl_a_board',
				]
			]],
			['module.add', [
				'acp',
				'ACP_QUICK_ACCESS',
				[
					'module_langname'	=> 'ACP_USERREMINDER_SLEEPER',
					'module_basename'	=> '\mot\userreminder\acp\main2_module',
					'module_mode'		=> 'sleeper2',
					'module_enabled'	=> false,
					'module_auth'       => 'ext_mot/userreminder && acl_a_board',
				]
			]],
			['module.add', [
				'acp',
				'ACP_QUICK_ACCESS',
				[
					'module_langname'	=> 'ACP_USERREMINDER_ZEROPOSTER',
					'module_basename'	=> '\mot\userreminder\acp\main2_module',
					'module_mode'		=> 'zeroposter2',
					'module_enabled'	=> false,
					'module_auth'       => 'ext_mot/userreminder && acl_a_board',
				]
			]],
		];
	}

	public function revert_data()
	{
		return [
			// Remove quick access modules
			['if', [
				['module.exists', ['acp', 'ACP_QUICK_ACCESS', 'ACP_USERREMINDER_ZEROPOSTER']],
				['module.remove', ['acp', 'ACP_QUICK_ACCESS', 'ACP_USERREMINDER_ZEROPOSTER']],
			]],
			['if', [
				['module.exists', ['acp', 'ACP_QUICK_ACCESS', 'ACP_USERREMINDER_SLEEPER']],
				['module.remove', ['acp', 'ACP_QUICK_ACCESS', 'ACP_USERREMINDER_SLEEPER']],
			]],
			['if', [
				['module.exists', ['acp', 'ACP_QUICK_ACCESS', 'ACP_USERREMINDER_REMINDER']],
				['module.remove', ['acp', 'ACP_QUICK_ACCESS', 'ACP_USERREMINDER_REMINDER']],
			]],
			// Remove extension modules
			['if', [
				['module.exists', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_ZEROPOSTER']],
				['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_ZEROPOSTER']],
			]],
			['if', [
				['module.exists', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_SLEEPER']],
				['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_SLEEPER']],
			]],
			['if', [
				['module.exists', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REMINDER']],
				['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REMINDER']],
			]],
			['if', [
				['module.exists', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_SETTINGS']],
				['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_SETTINGS']],
			]],
		];
	}

}
