<?php
/**
*
* @package User Reminder v1.4.0
* @copyright (c) 2019 - 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\userreminder\acp;

class main2_info
{
	public function module()
	{
		return [
			'filename'	=> '\mot\userreminder\acp\main2_module',
			'title'		=> 'ACP_USERREMINDER',
			'modes'		=> [
				'reminder2'		=> [
					'title'	=> 'ACP_USERREMINDER_REMINDER',
					'auth'	=> 'ext_mot/userreminder && acl_a_board',
					'cat'	=> ['ACP_QUICK_ACCESS'],
				],
				'sleeper2'		=> [
					'title'	=> 'ACP_USERREMINDER_SLEEPER',
					'auth'	=> 'ext_mot/userreminder && acl_a_board',
					'cat'	=> ['ACP_QUICK_ACCESS'],
				],
				'zeroposter2'	=> [
					'title'	=> 'ACP_USERREMINDER_ZEROPOSTER',
					'auth'	=> 'ext_mot/userreminder && acl_a_board',
					'cat'	=> ['ACP_QUICK_ACCESS'],
				],
			],
		];
	}
}
