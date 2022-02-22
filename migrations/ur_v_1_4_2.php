<?php

/**
*
* @package User Reminder v1.4.2
* @copyright (c) 2019 - 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_4_2 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_4_0_2 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_4_0_2'];
	}

	public function update_schema()
	{
		return [
			'change_columns' => [
				$this->table_prefix . 'mot_userreminder_remind_queue' => [
					'remind_type'	=> ['VCHAR:20', ''],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'change_columns' => [
				$this->table_prefix . 'mot_userreminder_remind_queue' => [
					'remind_type'	=> ['VCHAR:16', ''],
				],
			],
		];
	}

}
