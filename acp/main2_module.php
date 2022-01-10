<?php
/**
*
* @package User Reminder v1.4.0
* @copyright (c) 2019 - 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\acp;

class main2_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	/**
	 * Main ACP module
	 *
	 * @param	string	$id		The module identifier (\mot\userreminder\acp\main2_module)
	 *		string	$mode	The module mode (registrated_only2|reminder2|zeroposter2)
	 *
	 * @throws \Exception
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		// Remove digits from mode
		$mode = preg_replace('[\d]', '', $mode);

		/** @var \mot.userreminder.controller.acp $acp_controller */
		$acp_controller = $phpbb_container->get('mot.userreminder.controller.ur_acp');

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'acp_ur_' . $mode;

		// Set the page title for our ACP page
		$this->page_title = $language->lang('ACP_USERREMINDER') . ' - ' . $language->lang('ACP_USERREMINDER_' . utf8_strtoupper($mode));

		// Make the $u_action url available in our ACP controller
		$acp_controller->set_page_url($this->u_action)->{$mode}();
	}
}
