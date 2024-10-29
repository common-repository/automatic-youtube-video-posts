<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			admin.php
//		Description:
//			Genereic plugin admin class
//		Copyright:
//			Copyright (c) 2021 Ternstyle LLC.
//		License:
//			This software is licensed under the terms of the End User License Agreement (EULA)
//			provided with this software. In the event the EULA is not present with this software
//			or you have not read it, please visit:
//			http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

namespace ternplugin;

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Channels
------------------------------------------------------------------------------------------------*/

class TERNPLUGIN_admin {

	public $page = '';
	static $include = [];

	public function __construct() {
		if(!is_admin()) {
			return $this;
		}
		global $ayvpp_options;
		$this->options = $ayvpp_options;
		if($this->is_page()) {
			$this->actions();
		}
		return $this;
	}
	public function actions() {
		add_action('init',[$this,'save'],9);
		add_action('init',[$this,'enqueue'],9);
		add_action('wp_print_scripts',[$this,'js']);
	}
	public function enqueue() {
		wp_enqueue_style('ayvpp-admin');
		wp_enqueue_script('easing');
		wp_enqueue_script('ayvpp-errors');
	}
	public function js() {
		echo '<script type="text/javascript">var ayvpp_root = "'.AYVPP_ROOT.'";</script>'."\n";
	}
	static function page() {
		global $ayvpp_options;
		foreach((array)static::$include as $include) {
			include(AYVPP_ADMIN_DIR.'/view/'.$include);
		}
	}
	public function save() {

		if(!current_user_can('manage_options')) {
			return false;
		}

		if(
			(
				!isset($_REQUEST['_wpnonce'])
				or !wp_verify_nonce($_REQUEST['_wpnonce'],'WP_ayvpp_nonce')
			)
			and (
				!isset($_REQUEST['WP_ayvpp_nonce'])
				or !wp_verify_nonce($_REQUEST['WP_ayvpp_nonce'],'WP_ayvpp_nonce')
			)
		) {
			return false;
		}
		return true;
	}
	public function is_page() {
		if(
			!empty($this->page)
			and is_array($this->page)
			and isset($GLOBALS['pagenow'])
			and in_array($GLOBALS['pagenow'],$this->page)
		) {
			return true;
		}
		elseif(
			!empty($this->page)
			and isset($_GET['page'])
			and $_GET['page'] == $this->page
		) {
			return true;
		}
		elseif(
			!empty($this->page)
			and isset($_GET['page'])
			and $_GET['page'] == $this->page
			and isset($GLOBALS['pagenow'])
			and $GLOBALS['pagenow'] == 'admin-ajax.php'
		) {
			return true;
		}
		return false;
	}

}
