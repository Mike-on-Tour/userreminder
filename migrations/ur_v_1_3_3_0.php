<?php

/**
*
* @package UserReminder v1.3.3
* @copyright (c) 2019, 2020 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_3_3_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_3_2 to be installed
	*/
	static public function depends_on()
	{
		return array('\mot\userreminder\migrations\ur_v_1_3_2');
	}

	public function update_data()
	{
		return array(
			// Update the version config variable
			array('config.update', array('mot_ur_version', '1.3.3')),
			// Remove the old ACP modules
			array('if', array(
				array('module.exists', array('acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_ZEROPOSTER')),
				array('module.remove', array('acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_ZEROPOSTER')),
			)),
			array('if', array(
				array('module.exists', array('acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REGISTERED_ONLY')),
				array('module.remove', array('acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REGISTERED_ONLY')),
			)),
			array('if', array(
				array('module.exists', array('acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REMINDER')),
				array('module.remove', array('acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REMINDER')),
			)),
		);
	}
}
