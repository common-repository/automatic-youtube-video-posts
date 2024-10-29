<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			cron.php
//		Description:
//			Run any necessary plugin cronjobs.
//		Copyright:
//			Copyright (c) 2021 Ternstyle LLC.
//		License:
//			This software is licensed under the terms of the End User License Agreement (EULA)
//			provided with this software. In the event the EULA is not present with this software
//			or you have not read it, please visit:
//			http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

use ternstyle\tern_curl as tern_curl;
use ternplugin\youtube_import as youtube_import;
use ternplugin\youtube_video as youtube_video;

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Import Thumbnails
------------------------------------------------------------------------------------------------*/

class AYVPP_common_cron_free {

	public function __construct() {
		$this->actions();
	}
	public function actions() {
		add_filter('cron_schedules',[$this,'interval']);

		add_action('init',function () {
			global $ayvpp_options;

			if(!wp_next_scheduled('ayvpp_common_cron')) {
				wp_clear_scheduled_hook('ayvpp_common_cron');
				wp_schedule_event(time(),'ayvpp_minute_5','ayvpp_common_cron');
			}

			if(!wp_next_scheduled('ayvpp_cron')) {
				wp_clear_scheduled_hook('ayvpp_cron');
				wp_schedule_event(time(),'ayvpp_hourly_'.$ayvpp_options['cron'],'ayvpp_cron');
			}
		});

		add_action('ayvpp_cron',[$this,'import']);
		add_action('ayvpp_common_cron',[$this,'import_thumbnail']);
	}
	public function interval($schedules) {
		$schedules['ayvpp_minute_5'] = [
			'interval'	=>	(5*60),
			'display'		=>	'every 5 minutes',
		];
		for($i=1;$i<25;$i++) {
				$schedules['ayvpp_hourly_'.$i] = [
				'interval'	=>	(60*60)*$i,
				'display'		=>	'every '.$i.' hour'.($i>1?'s':''),
			];
		}
		return $schedules;
	}
	public function import() {
		global $getWP,$ayvpp_options;

		//import videos
		$parse = new youtube_import($ayvpp_options,array(
			'channel'		=>	false,
			'chunk'		=>	false,
			'reset'		=>	false,
		));

		//finish import
		set_transient('ayvpp_last_import',time());
		return $parse->progress();
	}
	public function import_thumbnail() {
		global $wpdb,$post,$ayvpp_options;

		if($this->should_import_thumbnails()) {

			//get all video posts without a thumbnail assigned
			$posts = $wpdb->get_results('
				select a.* from '.$wpdb->posts.' as a
				join '.$wpdb->postmeta.' as b
					on (a.ID=b.post_id)
				where
					a.id not in (
						select post_id from '.$wpdb->postmeta.' as c
						where c.meta_key="_thumbnail_id"
					)
					and b.meta_key="_ayvpp_video"
			');

			//loop through the posts to add thumbnails
			foreach((array)$posts as $post) {
				setup_postdata($post);

				$video_id = get_post_meta($post->ID,'_ayvpp_video',true);
				if(empty($video_id)) {
					continue;
				}

				if(has_post_thumbnail($post->ID)) {
					continue;
				}

				//get video thumbnail file URL
				$video = new youtube_video();
				$thumbnail_url = $video->thumb('*');
				if(!$thumbnail_url) {
					continue;
				}

				//get thumbnail content
				$file = $this->get_thumbnail_content($thumbnail_url);

				//name the file
				$name = $video_id.'.jpg';

				//upload the file
				$r = wp_upload_bits($name,NULL,$file);

				if(isset($r['file']) and (!isset($r['error']) or !$r['error'])) {

					//get upload directory
					$u = wp_upload_dir();

					//create thumbnail post
					$p = wp_insert_attachment([
						'guid'				=>	$r['url'],
						'post_mime_type'	=>	'image/jpeg',
						'post_title'		=>	$name,
						'post_content'		=>	'',
						'post_status'		=>	'inherit'
					],$r['file'],$post->ID);

					//include image processing
					require_once(ABSPATH.'wp-admin/includes/image.php');

					//generate image metadata
					$d = wp_generate_attachment_metadata($p,$r['file']);
					wp_update_attachment_metadata($p,$d);

					//set the thumbnail for the post
					set_post_thumbnail($post->ID,$p);

				}

			}

		}

	}
	private function should_import_thumbnails() {
		global $ayvpp_options,$post;
		if(!isset($ayvpp_options['import_thumbnails']) or (int)$ayvpp_options['import_thumbnails'] != 1) {
			return false;
		}
		return true;
	}
	private function get_thumbnail_content($url) {
		$c = new tern_curl;
		$r = $c->get([
			'url'		=>	$url,
			'options'		=>	[
				'RETURNTRANSFER'	=>	true,
			],
			'headers'		=>	[
				'Accept-Charset'	=>	'UTF-8'
			],
		]);

		if($r->headers['Content-Type'] != 'image/jpeg' or empty($r->body)) {
			return false;
		}
		return $r->body;
	}

}
new AYVPP_common_cron_free();

/****************************************Terminate Script******************************************/
?>
