<?php

/**
*
* @package UserReminder v1.3.0
* @copyright (c) 2019, 2020 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_3_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_1_2_0 to be installed
	*/
	public static function depends_on()
	{
		return array('\mot\userreminder\migrations\ur_v_1_2_0');
	}

	public function update_data()
	{
		return array(
			// Add the config variable we want to be able to set
			array('config.add', array('mot_ur_remind_zeroposter', 0)),
			array('config.add', array('mot_ur_protected_groups', json_encode(array()))),
			// convert the protected_members string into a json_encoded array
			array('custom', array(array($this, 'convert_members_array'))),
		);
	}

	public function convert_members_array()
	{
		$protected_members = explode(',', $this->config['mot_ur_protected_members']);
		$this->config->set('mot_ur_protected_members', json_encode($protected_members));
	}

}
