<?php

/**
*
* @package Userreminder v1.8.0
* @copyright (c) 2019 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_8_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_7_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_7_0'];
	}

	public function update_data()
	{
		return [
			['custom', [
				[$this, 'set_cron_dynamic']
			]],
		];
	}

	public function set_cron_dynamic()
	{
		$sql = "UPDATE " . $this->table_prefix . "config
				SET is_dynamic = 1
				WHERE config_name = 'mot_ur_mail_limit_time_last_gc'";
		$this->db->sql_query($sql);
	}
}
