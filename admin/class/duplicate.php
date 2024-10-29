<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			duplicate.php
//		Description:
//			This file remove duplicate video posts.
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
	Duplicate Posts
------------------------------------------------------------------------------------------------*/

class AYVPP_dup extends TERNPLUGIN_admin {

	public $page = 'ayvpp-dups';
	static $include = [
		'dups.php',
	];

	public function __construct() {
		parent::__construct();
	}
	public function actions() {
		parent::actions();
	}
	public function save() {
		global $getWP,$WP_ayvpp_options,$wpdb;

		if(parent::save()) {

			switch($_REQUEST['submit']) {

				case 'Cleanup' :
					$videos = $wpdb->get_results("select a.post_id,b.post_id as dup from ".$wpdb->postmeta." as a inner join (select * from ".$wpdb->postmeta." where meta_key='_ayvpp_video' group by meta_value having count(meta_id) > 1) as b on (a.meta_value=b.meta_value) where a.`meta_key` = '_ayvpp_video' and a.meta_id <> b.meta_id and a.post_id in (select ID from ".$wpdb->posts.")");
					$error = false;
					foreach((array)$videos as $v) {
						if((int)$v->post_id > (int)$v->dup) {
							if(!wp_delete_post($v->post_id,true)) {
								$getWP->addError(__('There was an error while deleting a video post','ayvpp').': '.get_the_title($v));
								$error = true;
							}
						}
						else {
							if(!wp_delete_post($v->dup,true)) {
								$getWP->addError(__('There was an error while deleting a video post','ayvpp').': '.get_the_title($v));
								$error = true;
							}
						}
					}
					if(!$error) {
						$getWP->addAlert(__('You have successfully cleared all duplicates','ayvpp').': '.count($videos));
					}
					break;

				default :
					break;

			}
		}
	}

}
new AYVPP_dup();

/****************************************Terminate Script******************************************/
?>
