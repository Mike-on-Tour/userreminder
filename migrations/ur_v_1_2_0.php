<?php

/**
*
* @package UserReminder v1.2.0
* @copyright (c) 2019, 2020 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_2_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_2_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_0_5_0'];
	}

	public function update_data()
	{
		return [
			// Add the config text variable we want to be able to set
			['config_text.add', ['mot_ur_email_texts', json_encode([]) ]],
		];
	}

}
