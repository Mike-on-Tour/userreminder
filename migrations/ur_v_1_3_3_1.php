<?php

/**
*
* @package User Reminder v1.4.1
* @copyright (c) 2019 - 2022 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_3_3_1 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_1_3_3_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_3_3_0'];
	}

	public function update_data()
	{
		return array(
			['if', [
				$this->check_module('acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REMINDER'),
				['module.add', [
					'acp',
					'ACP_USERREMINDER',
					[
						'module_basename'	=> '\mot\userreminder\acp\reminder_module',
						'module_langname'	=> 'ACP_USERREMINDER_REMINDER',
						'module_mode'		=> 'reminders',
						'module_auth'		=> 'ext_mot/userreminder && acl_a_board',
				]]],
			]],
			['if', [
				$this->check_module('acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REGISTERED_ONLY'),
				['module.add', [
					'acp',
					'ACP_USERREMINDER',
					[
						'module_basename'	=> '\mot\userreminder\acp\registrated_only_module',
						'module_langname'	=> 'ACP_USERREMINDER_REGISTERED_ONLY',
						'module_mode'		=> 'sleepers',
						'module_auth'		=> 'ext_mot/userreminder && acl_a_board',
				]]],
			]],
			['if', [
				$this->check_module('acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_ZEROPOSTER'),
				['module.add', [
					'acp',
					'ACP_USERREMINDER',
					[
						'module_basename'	=> '\mot\userreminder\acp\zeroposter_module',
						'module_langname'	=> 'ACP_USERREMINDER_ZEROPOSTER',
						'module_mode'		=> 'zeroposters',
						'module_auth'		=> 'ext_mot/userreminder && acl_a_board',
				]]],
			]],
		);
	}

	/*
	*	Checks whether a modul identified by it's module_langname exists under a given parent (also identified by the module_langname) and in a given module class
	*
	*	@params	string	$class	Name of the module class, e.g.' acp'
	*			string	$parent	Langname of the parent to be checked
	*			string	$module	Langname of the module to be checked
	*
	*	@return	boolean			True if the module doesn't exist, false if either the parent doesn't exist or the module already exists
	*/
	private function check_module($class, $parent, $module)
	{
		// check if parent exists
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . "
			WHERE module_class = '" . $this->db->sql_escape($class) . "'
			AND module_langname = '" . $this->db->sql_escape($parent) . "'";
		$result = $this->db->sql_query($sql);
		$parent_id = $this->db->sql_fetchfield('module_id', false, $result); // sql_fetchfield() returns either the id or false if this module doesn't exist
		$this->db->sql_freeresult($result);
		// Parent doesn't exist -> module can not be given to this parent so we return a false
		if (!$parent_id)
		{
			return false;
		}

		// Parent exists, now check if this module already exists under this parent
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . "
			WHERE module_class = '" . $this->db->sql_escape($class) . "'
			AND parent_id = " . (int) $parent_id . "
			AND module_langname = '" . $this->db->sql_escape($module) . "'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id', false, $result);
		$this->db->sql_freeresult($result);

		if (!$module_id)
		{
			return true;	// Module doesn't exist -> return true to enable adding this module
		}
		else
		{
			return false;	// Module already exists -> no need to adding it a second time
		}
	}
}
