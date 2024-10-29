<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			trouble.php
//		Description:
//			This file compiles helpful information.
//		Copyright:
//			Copyright (c) 2016 Ternstyle LLC.
//		License:
//			This software is licensed under the terms of the End User License Agreement (EULA)
//			provided with this software. In the event the EULA is not present with this software
//			or you have not read it, please visit:
//			http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

use ternplugin\TERNPLUGIN_admin as TERNPLUGIN_admin;

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Troubleshooting
------------------------------------------------------------------------------------------------*/

class AYVPP_trouble extends TERNPLUGIN_admin {

	public $page = 'ayvpp-trouble';
	static $include = [
		'trouble.php',
	];

	public function __construct() {
		parent::__construct();
	}
	static function page() {
		global $ayvpp_options,$WP_ayvpp_ip,$WP_ayvpp_met;

		$WP_ayvpp_met = ini_get('max_execution_time');
		ini_set('max_execution_time',($WP_ayvpp_met+5));
		$WP_ayvpp_met_hard = false;
		if($WP_ayvpp_met == ini_get('max_execution_time')) {
			$WP_ayvpp_met_hard = true;
		}

		include(AYVPP_ADMIN_DIR.'/view/trouble.php');
	}
}
new AYVPP_trouble();


/****************************************Terminate Script******************************************/
?>
