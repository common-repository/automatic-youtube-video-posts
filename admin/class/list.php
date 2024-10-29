<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			list.php
//		Description:
//			This file compiles and processes the plugin's video list.
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
	List Video Posts
------------------------------------------------------------------------------------------------*/

class AYVPP_list extends TERNPLUGIN_admin {

	public $page = 'ayvpp-video-posts';
	static $include = [
		'list.php',
	];

	public function __construct() {
		parent::__construct();
	}
	public function actions() {
		parent::actions();
	}
	public function save() {
		global $wpdb,$getWP;

		if(parent::save()) {

			$videos = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key='_ayvpp_video'");

			$action = empty($_REQUEST['action']) ? $_REQUEST['action2'] : $_REQUEST['action'];
			switch($action) {

				case 'delete' :
					foreach((array)$_REQUEST['videos'] as $v) {
						$p = get_post($v);
						if($p->post_status != 'trash' and !wp_delete_post($v)) {
							$getWP->addError(__('There was an error while deleting a video post','ayvpp').': '.get_the_title($v).'".');
						}
					}
					break;

				case 'publish' :
					foreach((array)$_REQUEST['videos'] as $v) {
						if(!$wpdb->query("update $wpdb->posts set post_status='publish' where ID=".$v)) {
							$getWP->addError(__('There was an error while publishing a video post','ayvpp').': '.get_the_title($v).'".');
						}
					}
					break;

				case 'draft' :
					foreach((array)$_REQUEST['videos'] as $v) {
						if(!$wpdb->query("update $wpdb->posts set post_status='draft' where ID=".$v)) {
							$getWP->addError(__('There was an error while drafting a video post','ayvpp').': '.get_the_title($v).'".');
						}
					}
					break;

				case 'refresh' :

					foreach((array)$videos as $v) {
						if(!wp_delete_post($v,true)) {
							$getWP->addError(__('There was an error while deleting a video post','ayvpp').': '.get_the_title($v).'".');
						}
					}
					break;

				default :
					break;
			}
		}
	}
	static function page() {
		global $wpdb,$post,$ayvpp_options;

		$page = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1;
		$start = (($page-1)*10);

		$videos = $wpdb->get_col("select a.ID from $wpdb->posts as a join $wpdb->postmeta as b on (a.ID = b.post_id) where b.meta_key='_ayvpp_video' and b.meta_value <> '' order by a.post_date desc limit $start,10");
		$video_count = $wpdb->get_var("select count(a.ID) from $wpdb->posts as a join $wpdb->postmeta as b on (a.ID = b.post_id) where b.meta_key='_ayvpp_video' and b.meta_value <> ''");

		include(AYVPP_ADMIN_DIR.'/view/list.php');
	}
}
new AYVPP_list();

/****************************************Terminate Script******************************************/
?>
