<?php

/**
*
* @package UserReminder v1.12.0
* @copyright (c) 2019 - 2025 Mike-on-Tour
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
			// set the initial values for column 'mot_last_login' from column 'user_lastvisit' in users table (for phpBB versions >= 3.3.12 'user_last_actiive' would be more preferable!)
			['custom', [[$this, 'init_ur']]],
		];
	}

	public function init_ur(int $start = 0)
	{
		// Get maximum user id from database
		$sql = "SELECT MAX(user_id) AS max_user_id
			FROM {$this->table_prefix}users";
		$result = $this->db->sql_query($sql);
		$max_id = (int) $this->db->sql_fetchfield('max_user_id');
		$this->db->sql_freeresult($result);

		if ($start > $max_id)
		{
			return;
		}

		// Keep setting user_last_active time
		$next_start = $start + 10000;

		$sql = 'UPDATE ' . $this->table_prefix . 'users
			SET mot_last_login = user_lastvisit
			WHERE user_id > ' . (int) $start . '
				AND user_id <= ' . (int) ($next_start);
		$this->db->sql_query($sql);

		return $next_start;
	}
}
