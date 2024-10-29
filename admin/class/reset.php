<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			reset.php
//		Description:
//			This file resets the plugin's various settings pages.
//		Copyright:
//			Copyright (c) 2021 Ternstyle LLC.
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
	Reset Plugin
------------------------------------------------------------------------------------------------*/

class AYVPP_reset extends TERNPLUGIN_admin {

	public $page = 'ayvpp-reset';
	static $include = [
		'reset.php',
	];

	public function __construct() {
		parent::__construct();
	}
	public function actions() {
		parent::actions();
	}
	public function save() {
		global $wpdb,$WP_ayvpp_options;

		if(!parent::save()) {
			return;
		}

		switch($_REQUEST['submit']) {

			case 'Completely Refresh Videos' :
				$videos = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key='_ayvpp_video' and meta_value != ''");
				foreach((array)$videos as $v) {
					if(!wp_delete_post($v,true)) {
						$getWP->addError(__('There was an error while deleting a video post','ayvpp').': '.get_the_title($v).'".');
					}
				}
				break;

			case 'Reset this Plugin' :
				$videos = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key='_ayvpp_video'");
				foreach((array)$videos as $v) {
					if(!wp_delete_post($v,true)) {
						$getWP->addError(__('There was an error while deleting a video post','ayvpp').': '.get_the_title($v).'".');
					}
				}
				$getWP->getOption('ayvpp_settings',$WP_ayvpp_options,true);
				break;

			case 'Reset this Plugin but keep posts' :
				$getWP->getOption('ayvpp_settings',$WP_ayvpp_options,true);
				break;

			case 'Reset Import Field in the Database' :
				delete_transient('ayvpp_importing');
				break;

			default :
				break;

		}
	}
}
new AYVPP_reset();

/****************************************Terminate Script******************************************/
?>
