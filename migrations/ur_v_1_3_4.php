<?php

/**
*
* @package UserReminder v1.3.4
* @copyright (c) 2019, 2020 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_3_4 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_3_3_1 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_3_3_1'];
	}

	public function update_data()
	{
		return [
			// Update the version variable
			['config.update', ['mot_ur_version', '1.3.4']],
		];
	}
}
