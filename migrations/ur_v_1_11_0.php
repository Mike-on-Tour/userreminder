<?php

/**
*
* @package Userreminder v1.11.0
* @copyright (c) 2019 - 2026 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_11_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_8_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_8_0'];
	}

	public function update_data()
	{
		return [
			['config.add', ['mot_ur_block_login_proc', 0, 1]],
		];
	}
}
