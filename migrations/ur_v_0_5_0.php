<?php

/**
*
* @package UserReminder v0.5.0
* @copyright (c) 2019, 2020 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_0_5_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_2_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_0_2_0'];
	}

	public function update_data()
	{
		return [
			// set the initial values for column 'mot_last_login' from column 'user_lastvisit' in users table
			['custom', [[$this, 'init_ur']]],
		];
	}

	public function init_ur()
	{
		if ($this->config['mot_ur_consec_run'] == 0)
		{
			$query = 'UPDATE ' . USERS_TABLE . '
					SET mot_last_login = user_lastvisit';
			$this->db->sql_query($query);

			$this->config->set('mot_ur_consec_run', 1);
		}
	}

}
