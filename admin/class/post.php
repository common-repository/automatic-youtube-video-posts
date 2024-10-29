<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			meta.php
//		Description:
//			This file compiles video specific meta fields for posts.
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

use ternstyle\tern_curl as tern_curl;
use ternplugin\TERNPLUGIN_admin as TERNPLUGIN_admin;

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Duplicate Posts
------------------------------------------------------------------------------------------------*/

class AYVPP_post extends TERNPLUGIN_admin {

	public $page = ['post.php','edit.php','post-new.php','page.php','page-new.php'];
	static $include = [
		'dups.php',
	];

	public function __construct() {
		parent::__construct();
	}
	public function actions() {
		parent::actions();

		add_action('admin_menu',[$this,'display_meta_box']);
		add_action('save_post',[$this,'save_post']);
		add_action('publish_post',[$this,'save_post']);
	}
	public function enqueue() {
		wp_enqueue_script('ayvpp-meta');
	}
	public function save() {

	}
	public function save_post($post_id) {
		global $ayvpp_options,$getWP;

		if(!$post_id or !parent::save()) {
			return;
		}

		if(isset($_POST['WP_ayvpp_action']) and $_POST['WP_ayvpp_action'] == 'sync') {
			$c = new tern_curl();
			$r = $c->get(array(
				'url'		=>	'https://www.googleapis.com/youtube/v3/videos/?part=id,snippet,contentDetails&id='.$_POST['_ayvpp_video'].'&key='.$ayvpp_options['key'],
				'options'	=>	(isset($ayvpp_options['cainfo']) and $ayvpp_options['cainfo']) ? [
					'RETURNTRANSFER'	=>	true,
					//'CAINFO'			=>	AYVPP_SSLCRT,
				] : [
					'RETURNTRANSFER'	=>	true,
				],
				'headers'	=>	array(
					'Accept-Charset'	=>	'UTF-8'
				)
			));
			$r = json_decode($r->body);

			if(isset($r->items[0]->id)) {
				remove_action('save_post','WP_ayvpp_save_post');
				remove_action('publish_post','WP_ayvpp_save_post');
				if(wp_update_post([
					'ID'			=>	$post_id,
					'post_date'	=>	gmdate('Y-m-d H:i:s',strtotime($r->items[0]->snippet->publishedAt)),
					'post_title'	=>	$r->items[0]->snippet->title,
					'post_content'	=>	$this->content((string)$r->items[0]->snippet->description)
				])) {
					$getWP->addAlert(__('You successfully synced this video post with YouTube.','ayvpp'));
				}
				else {
					$getWP->addError(__('There was an error syncing your video post with YouTube. Please try again.','ayvpp'));
				}

			}
			else {
				$getWP->addError(__('There was an error syncing your video post with YouTube. Please try again.','ayvpp'));
			}
		}

		if(!empty($_POST['_ayvpp_video'])) {
			update_post_meta($post_id,'_ayvpp_video',$_POST['_ayvpp_video']);
			update_post_meta($post_id,'_ayvpp_video_url',$_POST['_ayvpp_video_url']);
			update_post_meta($post_id,'_ayvpp_author',$_POST['_ayvpp_author']);
			update_post_meta($post_id,'_ayvpp_auto_play',(int)$_POST['_ayvpp_auto_play']);
			update_post_meta($post_id,'_ayvpp_show_related',(int)$_POST['_ayvpp_show_related']);
		}
	}
	public function display_meta_box() {
		global $post;
		if(isset($_GET['post']) and get_post_meta($_GET['post'],'_ayvpp_video',true)) {
			add_meta_box('ayvpp_meta_box','Automatic Video Posts',[$this,'meta_box'],get_post_type($_GET['post']),'normal');
		}
	}
	public function meta_box() {
		global $post;
		$meta = get_post_meta($post->ID);
		include(AYVPP_ADMIN_DIR.'/view/meta.php');
	}
	private function content($s='') {
		global $ayvpp_options;
		if(isset($ayvpp_options['content_truncate']) and (int)$ayvpp_options['content_truncate_after'] > 0) {
			$s = explode(' ',$s);
			if(count($s) > (int)$ayvpp_options['content_truncate_after']) {
				$s = array_merge(array_splice($s,0,(int)$ayvpp_options['content_truncate_after']),array('<!--more-->'),$s);
			}
			$s = implode(' ',$s);
		}
		return $s;
	}
}
new AYVPP_post();

/****************************************Terminate Script******************************************/
?>
