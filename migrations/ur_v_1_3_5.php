<?php

/**
*
* @package UserReminder v1.3.5
* @copyright (c) 2019, 2020 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_3_5 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_3_4 to be installed
	*/
	public static function depends_on()
	{
		return array('\mot\userreminder\migrations\ur_v_1_3_4');
	}

	public function update_data()
	{
		return array(
			// Update the version variable
			array('config.update', array('mot_ur_version', '1.3.5')),
		);
	}
}
