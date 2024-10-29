<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			menu.php
//		Description:
//			This file initializes menus for the plugin's administrative tasks
//		Copyright:
//			Copyright (c) 2021 Matthew Praetzel.
//		License:
//			This software is licensed under the terms of the End User License Agreement (EULA)
//			provided with this software. In the event the EULA is not present with this software
//			or you have not read it, please visit:
//			http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

use ternpress\tern_menu as tern_menu;

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Admin Menus
------------------------------------------------------------------------------------------------*/

class AYVPP_menu_free extends tern_menu {

	public function __construct ($o=[]) {
		parent::__construct($o);
		return $this;
	}
	public function action() {
		parent::action();
	}
	public function admin() {
		add_menu_page('Automatic Video Posts','Automatic Video','manage_options','ayvpp-settings',['AYVPP_setting_free','page'],'dashicons-video-alt3',99.99999999999);
		add_submenu_page('ayvpp-settings',__('Automatic Video Posts','ayvpp'),__('Settings','ayvpp'),'manage_options','ayvpp-settings',['AYVPP_setting_free','page']);
		add_submenu_page('ayvpp-settings',__('Channels/Playlists','ayvpp'),__('Channels/Playlists','ayvpp'),'manage_options','ayvpp-channels',['AYVPP_channel_free','page']);
		add_submenu_page('ayvpp-settings',__('Import Videos','ayvpp'),__('Import Videos','ayvpp'),'manage_options','ayvpp-import-videos',['AYVPP_import_free','page']);
		add_submenu_page('ayvpp-settings',__('Video Posts','ayvpp'),__('Video Posts','ayvpp'),'manage_options','ayvpp-video-posts',['AYVPP_list','page']);
		add_submenu_page('ayvpp-settings',__('Reset','Reset','ayvpp'),__('Reset','Reset','ayvpp'),'manage_options','ayvpp-reset',['AYVPP_reset','page']);
		add_submenu_page('ayvpp-settings',__('Duplicate Post Cleanup','ayvpp'),__('Duplicate Post Cleanup','ayvpp'),'manage_options','ayvpp-dups',['AYVPP_dup','page']);
		add_submenu_page('ayvpp-settings',__('Trouble Shooting','ayvpp'),__('Trouble Shooting','ayvpp'),'manage_options','ayvpp-trouble',['AYVPP_trouble','page']);
	}
	public function register() {}

}
new AYVPP_menu_free();

/****************************************Terminate Script******************************************/
?>
