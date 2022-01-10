<?php

/**
*
* @package User Reminder v1.4.0
* @copyright (c) 2019 - 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_4_0_2 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_4_0_1 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_4_0_1'];
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'mot_userreminder_remind_queue'	=> [
					'COLUMNS'	=> [
						'mot_last_login'		=> ['UINT:11', 0],
						'user_id'				=> ['UINT:10', 0],
						'username'				=> ['VCHAR:255', ''],
						'user_email'			=> ['VCHAR:100', ''],
						'user_lang'				=> ['VCHAR:30', ''],
						'user_timezone'			=> ['VCHAR:100', ''],
						'user_dateformat'		=> ['VCHAR:64', ''],
						'user_jabber'			=> ['VCHAR:255', ''],
						'user_notify_type'		=> ['UINT:4', 0],
						'mot_reminded_one'		=> ['UINT:11', 0],
						'user_regdate'			=> ['UINT:11', 0],
						'mot_sleeper_remind'	=> ['UINT:11', 0],
						'remind_type'			=> ['VCHAR:15', ''],
					],
				],
			],
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'mot_sleeper_remind'	=> ['UINT:11', 0],
				],
			],
		];
	}

	public function update_data()
	{
		return [
			// New config variables
			['config.add', ['mot_ur_rows_per_page', 25]],
			['config.add', ['mot_ur_expert_mode', 0]],
			['config.add', ['mot_ur_remind_sleeper', 0]],
			['config.add', ['mot_ur_sleeper_inactive_days', 21]],
			['config.add', ['mot_ur_sleeper_autoremind', 0]],
			['config.add', ['mot_ur_sleeper_autodelete', 0]],
			['config.add', ['mot_ur_sleeper_deletetime', 21]],
			['config.add', ['mot_ur_mail_limit_number', 150]],
			['config.add', ['mot_ur_mail_available', 150]],
			// Cron variables
			['config.add', ['mot_ur_mail_limit_time_last_gc', 0]], // last run
			['config.add', ['mot_ur_mail_limit_time_gc', (60 * 60)]], // seconds between runs; 1 hour
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'mot_userreminder_remind_queue',
			],
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'mot_sleeper_remind',
				],
			],
		];
	}

	public function revert_data()
	{
		return [
			['config.remove', ['mot_ur_rows_per_page']],
			['config.remove', ['mot_ur_expert_mode']],
			['config.remove', ['mot_ur_remind_sleeper']],
			['config.remove', ['mot_ur_sleeper_inactive_days']],
			['config.remove', ['mot_ur_sleeper_autoremind']],
			['config.remove', ['mot_ur_sleeper_autodelete']],
			['config.remove', ['mot_ur_sleeper_deletetime']],
			['config.remove', ['mot_ur_mail_limit_number']],
			['config.remove', ['mot_ur_mail_available']],
			['config.remove', ['mot_ur_mail_limit_time_last_gc']],
			['config.remove', ['mot_ur_mail_limit_time_gc']],
		];
	}

}
