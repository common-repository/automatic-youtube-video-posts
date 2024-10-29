<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			scripts.php
//		Description:
//			This file includes the necerssary CSS and Javascript files.
//		Copyright:
//			Copyright (c) 2021 Ternstyle LLC.
//		License:
//			This software is licensed under the terms of the End User License Agreement (EULA)
//			provided with this software. In the event the EULA is not present with this software
//			or you have not read it, please visit:
//			http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Plugin Scripts
------------------------------------------------------------------------------------------------*/

class AYVPP_script {

	public function __construct() {
		add_action('init',[$this,'register'],0);
		add_action('init',[$this,'enqueue'],0);
	}
	public function register() {
		if(is_admin()) {
			wp_register_style('jquery-ui',AYVPP_ADMIN_URL.'/assets/css/jquery-ui.min.css',[],'1.12.1');
			wp_register_style('switchery',AYVPP_ADMIN_URL.'/assets/css/switchery.min.css',[],'0.8.2');
			wp_register_style('ayvpp-admin',AYVPP_ADMIN_URL.'/assets/css/style.css',[],AYVPP_VERSION);

			wp_register_script('easing',AYVPP_ADMIN_URL.'/assets/js/jquery.easing.js',['jquery'],'1.3',true);
			wp_register_script('switchery',AYVPP_ADMIN_URL.'/assets/js/switchery.min.js',[],'0.8.2',true);
			wp_register_script('ayvpp-errors',AYVPP_ADMIN_URL.'/assets/js/errors.js',['jquery'],AYVPP_VERSION,true);
			wp_register_script('ayvpp-import',AYVPP_ADMIN_URL.'/assets/js/import.js',['jquery','easing','ayvpp-errors'],AYVPP_VERSION,true);
			wp_register_script('ayvpp-channels',AYVPP_ADMIN_URL.'/assets/js/channels.js',['jquery'],AYVPP_VERSION,true);
			wp_register_script('ayvpp-meta',AYVPP_ADMIN_URL.'/assets/js/meta.js',['jquery'],AYVPP_VERSION,true);
			wp_register_script('ayvpp-admin',AYVPP_ADMIN_URL.'/assets/js/admin.js',['jquery'],AYVPP_VERSION,true);
		}
		else {
			wp_register_style('ayvpp-style',AYVPP_PUBLIC_URL.'/assets/css/style.css',[],AYVPP_VERSION);
			wp_register_script('ayvpp-scripts',AYVPP_PUBLIC_URL.'/assets/js/scripts.js',['jquery'],'1.0',true);
		}
	}
	public function enqueue() {
		if(is_admin()) {
			wp_enqueue_style('ayvpp-admin');
		}
	}

}
new AYVPP_script();

/****************************************Terminate Script******************************************/
?>
