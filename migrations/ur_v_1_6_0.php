<?php

/**
*
* @package User Reminder v1.6.0
* @copyright (c) 2019 - 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_6_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_4_2 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_4_2'];
	}

	public function update_data()
	{
		return [
			['config.add', ['mot_ur_email_from', '']],
			['config.add', ['mot_ur_suppress_replyto', 0]],
		];
	}
}
