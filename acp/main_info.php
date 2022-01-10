<?php
/**
*
* @package User Reminder v1.4.0
* @copyright (c) 2019 - 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\acp;

class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\mot\userreminder\acp\main_module',
			'title'		=> 'ACP_USERREMINDER',
			'modes'		=> [
				'settings'			=> [
					'title'	=> 'ACP_USERREMINDER_SETTINGS',
					'auth'	=> 'ext_mot/userreminder && acl_a_board',
					'cat'	=> ['ACP_USERREMINDER'],
				],
				'reminder'			=> [
					'title'	=> 'ACP_USERREMINDER_REMINDER',
					'auth'	=> 'ext_mot/userreminder && acl_a_board',
					'cat'	=> ['ACP_USERREMINDER'],
				],
				'sleeper'	=> [
					'title'	=> 'ACP_USERREMINDER_SLEEPER',
					'auth'	=> 'ext_mot/userreminder && acl_a_board',
					'cat'	=> ['ACP_USERREMINDER'],
				],
				'zeroposter'		=> [
					'title'	=> 'ACP_USERREMINDER_ZEROPOSTER',
					'auth'	=> 'ext_mot/userreminder && acl_a_board',
					'cat'	=> ['ACP_USERREMINDER'],
				],
			],
		];
	}
}
