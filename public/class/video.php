<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			video.php
//		Description:
//			This file renders videos, video images and video meta.
//		Copyright:
//			Copyright (c) 2021 Ternstyle LLC.
//		License:
//			This software is licensed under the terms of the End User License Agreement (EULA)
//			provided with this software. In the event the EULA is not present with this software
//			or you have not read it, please visit:
//			http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

use ternplugin\youtube_video as youtube_video;

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Render Video
------------------------------------------------------------------------------------------------*/

class AYVPP_video {

	private $video = null;
	private $image_size = null;

	public function __construct() {
		add_action('the_post',[$this,'init']);
		add_filter('the_content',[$this,'content']);

		add_filter('has_post_thumbnail',[$this,'filter_has_post_thumbnail'],99,3);
		add_filter('post_thumbnail_size',[$this,'filter_thumbnail_size']);
		add_filter('post_thumbnail_html',[$this,'thumbnail'],0,5);

	}
	public function init() {
		global $ayvpp_options;
		$this->video = new youtube_video($ayvpp_options);
	}
	public function content($content) {
		global $ayvpp_options;

		if(!isset($this->video->meta['_ayvpp_video']) or empty($this->video->meta['_ayvpp_video'])) {
			return $content;
		}

		wp_enqueue_style('ayvpp-style');
		wp_enqueue_script('ayvpp-scripts');

		$video = '';
		if(is_single()) {
			$video = ((isset($ayvpp_options['content_display_meta']) and $ayvpp_options['content_display_meta']) ? $this->video->video().$this->video->meta_show() : $this->video->video());
		}
		elseif(isset($ayvpp_options['video_post_list_show']) and $ayvpp_options['video_post_list_show']) {
			$video = $this->video->video();
		}

		return $ayvpp_options['content_top'] ? $content.$video : $video.$content;
	}
	public function filter_has_post_thumbnail($has,$post,$thumbnail_id) {
		global $post,$ayvpp_options;

		//this isn't a vide post
		if(!$this->video) {
			return $has;
		}

		//don't automatically display thumbnails
		if((isset($ayvpp_options['thumbs_show']) and (int)$ayvpp_options['thumbs_show'] == 0) or !isset($ayvpp_options['thumbs_show'])) {
			return $has;
		}

		//we've already imported the thumbnail and assigned it
		if(isset($ayvpp_options['import_thumbnails']) and $ayvpp_options['import_thumbnails'] == 1) {
			return $has;
		}

		//this is a video post
		//we are sjupposed to try to show a thumbnail
		//there isn't a thumbnail already assigned
		return true;

	}
	public function filter_thumbnail_size($size) {
		global $ayvpp_options;
		if(!isset($ayvpp_options['import_thumbnails']) or $ayvpp_options['import_thumbnails'] == 1) {
			return $size;
		}
		$this->image_size = $size;
		return $size;
	}
	public function thumbnail($html,$post_id,$post_thumbnail_id,$size,$attr) {
		global $ayvpp_options,$_wp_additional_image_sizes,$post;

		//don't automatically display thumbnails
		if((isset($ayvpp_options['thumbs_show']) and (int)$ayvpp_options['thumbs_show'] == 0) or !isset($ayvpp_options['thumbs_show'])) {
			return $html;
		}

		//we've already imported the thimbnails so the sizes should be correct
		//we don't need to hijack the humbnail size here
		//don't display the customized thumbnail
		if(!isset($ayvpp_options['import_thumbnails']) or $ayvpp_options['import_thumbnails'] == 1) {
			return $html;
		}

		//get the video thumbnail
		$thumb = $this->video->thumb('*');

		//there is no video or thumbnail set
		if(!isset($this->video->meta['_ayvpp_video']) or empty($this->video->meta['_ayvpp_video']) or !$thumb) {
			return $html;
		}

		//there is no image size set for some reason
		if(!$this->image_size) {
			return $html;
		}

		//return the default thumbnail as a background image
		$dims = $this->get_thumbnail_dimensions();
		return '<div style="box-sizing:border-box;width:'.$dims[0].'px;max-width:100%;height:'.$dims[1].'px;background-image:url(\''.$thumb.'\');background-size:cover;background-position:center center;"></div>';


	}
	private function get_thumbnail_dimensions() {
		global $_wp_additional_image_sizes;

		//get the image dimensions
		if(isset($_wp_additional_image_sizes[$this->image_size]['width'])) {
			$w = intval($_wp_additional_image_sizes[$this->image_size]['width']);
			$h = intval($_wp_additional_image_sizes[$this->image_size]['height']);
			$c = intval($_wp_additional_image_sizes[$this->image_size]['crop']);
		}
		else {
			$w = get_option("{$this->image_size}_size_w");
			$h = get_option("{$this->image_size}_size_h");
			$c = get_option("{$this->image_size}_crop");
		}
		$c = $c ? '1' : '0';

		return [$w,$h,$c];
	}
	private function timthumb() {
		global $post;

		//get the image dimensions
		if(isset($_wp_additional_image_sizes[$this->image_size]['width'])) {
			$w = intval($_wp_additional_image_sizes[$this->image_size]['width']);
			$h = intval($_wp_additional_image_sizes[$this->image_size]['height']);
			$c = intval($_wp_additional_image_sizes[$this->image_size]['crop']);
		}
		else {
			$w = get_option("{$this->image_size}_size_w");
			$h = get_option("{$this->image_size}_size_h");
			$c = get_option("{$this->image_size}_crop");
		}
		$c = $c ? '1' : '0';

		//compile the image
		$s = '<img src="'.AYVPP_URL.'/tools/timthumb.php?src='.$t.'&w='.$w.'&h='.$h.'&zc='.$c.'" alt="'.$post->post_title.'" title="'.$post->post_title.'"';
		$s .= isset($v['class']) ? 'class="'.$v['class'].'"' : '';
		$s .= isset($v['width']) ? 'width="'.$v['width'].'"' : '';
		$s .= isset($v['height']) ? 'height="'.$v['height'].'"' : '';
		$s .= ' />';

		return $s;
	}
}
new AYVPP_video();


/****************************************Terminate Script******************************************/
?>
