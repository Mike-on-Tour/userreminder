<?php

/**
*
* @package User Reminder v1.7.0
* @copyright (c) 2019 - 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_7_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_6_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_6_0'];
	}

	public function update_data()
	{
		return [
			['config.add', ['mot_ur_zp_inactive_days', 70]],
			['config.add', ['mot_ur_zp_days_reminded', 10]],
			['config.add', ['mot_ur_zp_autoremind', 0]],				// 0 == false, 1 == true
			['config.add', ['mot_ur_zp_days_until_deleted', 10]],
			['config.add', ['mot_ur_zp_autodelete', 0]],				// 0 == false, 1 == true
		];
	}
}
