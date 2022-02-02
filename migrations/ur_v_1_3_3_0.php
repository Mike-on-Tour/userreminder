<?php

/**
*
* @package User Reminder v1.4.1
* @copyright (c) 2019 - 2022 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\migrations;

class ur_v_1_3_3_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration ur_v_1_3_2 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\userreminder\migrations\ur_v_1_3_2'];
	}

	public function update_data()
	{
		return [
			// Update the version config variable
			['config.update', ['mot_ur_version', '1.3.3']],
			// Remove the old ACP modules
			['if', [
				['module.exists', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_ZEROPOSTER']],
				['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_ZEROPOSTER']],
			]],
			['if', [
				['module.exists', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REGISTERED_ONLY']],
				['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REGISTERED_ONLY']],
			]],
			['if', [
				['module.exists', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REMINDER']],
				['module.remove', ['acp', 'ACP_USERREMINDER', 'ACP_USERREMINDER_REMINDER']],
			]],
		];
	}
}
