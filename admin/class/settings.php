<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			settings.php
//		Description:
//			This file compiles and processes the plugin's various settings pages.
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

use ternpress\tern_setting as tern_setting;

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Theme Settings
------------------------------------------------------------------------------------------------*/

class AYVPP_setting_free extends tern_setting {

	private $preserve = [
		'verified',
		'channels',
		'serial',
	];

	public function __construct($o=[]) {
		global $ayvpp_options,$WP_ayvpp_options;
		$this->field = array_keys($WP_ayvpp_options);

		return parent::__construct(
			'ayvpp_settings',
			$WP_ayvpp_options,
			array_merge($ayvpp_options,[
				'nonce'	=>	'WP_ayvpp_nonce',
			]),
			AYVPP_ADMIN_DIR.'/view'
		);
	}
	public function save() {
		global $ayvpp_options;

		//if the schedule has changed need to clear the cron
		if(
			!isset($ayvpp_options['cron'])
			or (
				isset($ayvpp_options['cron'])
				and isset($_POST['cron'])
				and (int) $_POST['cron'] != (int)$ayvpp_options['cron']
			)
		) {
			wp_clear_scheduled_hook('ayvpp_cron');
		}

		$_POST = array_merge($_POST,array_intersect_key((array)$ayvpp_options,array_flip($this->preserve)));
		$option = parent::save();
		if($option) {
			$ayvpp_options = $option;
		}
	}
	static function page() {
		wp_enqueue_style('jquery-ui');
		wp_enqueue_style('switchery');
		wp_enqueue_style('ayvpp-admin');

		wp_enqueue_script('jquery-ui');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('switchery');
		wp_enqueue_script('ayvpp-admin');

		include(AYVPP_ADMIN_DIR.'/view/settings_free.php');
	}
}
new AYVPP_setting_free();

/****************************************Terminate Script******************************************/
?>
