<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			setting.php
//		Description:
//			This class performs functions for WordPress menus.
//		Version:
//			1.0.1
//		Copyright:
//			Copyright (c) 2019 Ternstyle LLC.
//		License:
//			The license for this software is called ternstyle-license.rtf and is included within this plugin.
//
////////////////////////////////////////////////////////////////////////////////////////////////////

namespace ternpress;
use ternpress\tern_option as tern_option;

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Settings
------------------------------------------------------------------------------------------------*/

class tern_setting {

	public $field = [];

	public function __construct($namespace='',$defaults=[],$options=[],$directory='') {
		$this->namespace = $namespace;
		$this->defaults = $defaults;
		$this->options = $options;
		$this->directory = $directory;
		$this->action();
		return $this;
	}
	public function action() {
		add_action('init',[$this,'save'],99);
	}
	public function view() {
		include($this->directory.'/settings.php');
	}
	public function save() {

		//action
		$action = 'update_'.sanitize_title($this->namespace);

		//we're supposed to be saving these settings
		if(isset($_POST['action']) and $_POST['action'] == $action) {

			//security
			if(!isset($_REQUEST['_wpnonce']) or !wp_verify_nonce($_REQUEST['_wpnonce'],$this->options['nonce'])) {

				//error message

				return false;
			}

			//user permissions
			if(!current_user_can('manage_options')) {

				//error message

				return false;
			}

			switch($_REQUEST['action']) {

				case $action :

					$option = (new tern_option())->update_from_post($this->namespace,$this->field);
					if($option) {

						//success message

						$this->options = $option;
						return $option;


					}
					else {
						//error message
					}

					break;

				default :
					break;

			}

			return false;

		}
	}

}

/****************************************Terminate Script******************************************/

?>
