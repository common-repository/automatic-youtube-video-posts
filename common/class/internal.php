<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			internal.php
//		Description:
//			This file is responsible for internal functions.
//		Copyright:
//			Copyright (c) 2010 Matthew Praetzel.
//		License:
//			This software is licensed under the terms of the End User License Agreement (EULA)
//			provided with this software. In the event the EULA is not present with this software
//			or you have not read it, please visit:
//			http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

use ternstyle\tern_curl as tern_curl;
use ternpress\tern_option as tern_option;

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Internal Functions
------------------------------------------------------------------------------------------------*/

class AYVPP_internal_free {

	public function __construct() {
		add_action('init',[$this,'fix_channels']);
	}
	public function fix_channels() {
		global $getWP,$ayvpp_options;
		if(count($ayvpp_options['channels']) > 0) {
			$ayvpp_options['channels'] = array_slice($ayvpp_options['channels'],0,1);
			$ayvpp_options = $getWP->getOption('ayvpp_settings',$ayvpp_options,true);
		}
	}

}
new AYVPP_internal_free();

/****************************************Terminate Script******************************************/
?>
