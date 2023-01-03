<?php

/**
*
* @package UserReminder v0.4.0
* @copyright (c) 2019, 2020 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_0_2_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_1_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_0_1_0'];
	}

	public function update_data()
	{
		return [
			// Add the config variable we want to be able to set
			['config.add', ['mot_ur_email_cc', '']],
			['config.add', ['mot_ur_email_bcc', '']],
			['config.add', ['mot_ur_consec_run', 0]],
		];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'mot_last_login'	=> ['UINT:11', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'mot_last_login',
				],
			],
		];
	}

}
