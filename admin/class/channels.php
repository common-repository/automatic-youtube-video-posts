<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			channels.php
//		Description:
//			This file creates and saves configurable YouTube channels.
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
use ternplugin\TERNPLUGIN_admin as TERNPLUGIN_admin;

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Channels
------------------------------------------------------------------------------------------------*/

class AYVPP_channel_free extends TERNPLUGIN_admin {

	public $page = 'ayvpp-channels';
	static $include = [
		'channels_free.php',
		'channel_add_free.php',
	];
	private $error = [];

	public function __construct() {
		parent::__construct();
	}
	public function actions() {
		parent::actions();
	}
	public function enqueue() {
		parent::enqueue();
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('ayvpp-channels');
	}
	private function get_key() {
		global $ayvpp_options;
		if(isset($ayvpp_options['key']) and !empty($ayvpp_options['key'])) {
			return $ayvpp_options['key'];
		}
		return false;
	}
	public function save() {
		global $ayvpp_options,$getWP;

		if(parent::save()) {

			//find action
			$action = false;
			if(isset($_REQUEST['action']) or isset($_REQUEST['action2'])) {
				$action = empty($_REQUEST['action']) ? $_REQUEST['action2'] : $_REQUEST['action'];
			}

			//perform action
			switch($action) {

				case 'activate' :
					foreach((array)$_REQUEST['items'] as $v) {
						$ayvpp_options['channels'][$v]['activated'] = true;
					}
					$ayvpp_options = $getWP->getOption('ayvpp_settings',$ayvpp_options,true);
					$getWP->addAlert(__('You have successfully activated your channel.','ayvpp'));
					break;
				case 'deactivate' :
					foreach((array)$_REQUEST['items'] as $v) {
						$ayvpp_options['channels'][$v]['activated'] = false;
					}
					$ayvpp_options = $getWP->getOption('ayvpp_settings',$ayvpp_options,true);
					$getWP->addAlert(__('You have successfully deactivated your channel.','ayvpp'));
					break;

				case 'delete' :
					foreach((array)$_REQUEST['items'] as $v) {
						unset($ayvpp_options['channels'][$v]);
					}
					$ayvpp_options = $getWP->getOption('ayvpp_settings',$ayvpp_options,true);
					$getWP->addAlert(__('You have successfully deleted your channel/playlist.','ayvpp'));
					break;

				case 'add' :

					$channel_id = $this->generate_id(7);

					//edit channel
					if(
						isset($_REQUEST['item'])
						and (
							!empty($_REQUEST['item'])
							or $_REQUEST['item'] === 0
							or $_REQUEST['item'] === '0'
						)
						and isset($ayvpp_options['channels'][$_REQUEST['item']])
					) {
						$channel_id = $_REQUEST['item'];
					}

					//we already have too many channels
					elseif(count($ayvpp_options['channels']) >= 1) {
						$getWP->addError(__("We're sorry you can only add one channel with our FREE version. Please upgrade to the PRO version",'ayvpp').': <a href="https://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/purchase" target="_blank">'.__('click here','ayvpp').'</a>');
						return;
					}

					//this channel already exists or we don't have enough information to create a channel
					if($this->channel_exists($_POST['channel']) or !$this->validate()) {
						return;
					}

					//add by search
					if($_POST['type'] == 'search') {
						$playlist_id = false;
					}

					//add by channel
					elseif($_POST['type'] == 'channel') {

						//get channel by either ID or by name
						$channel = $this->get_channel_by_id($_POST['channel']);
						if(!$channel) {
							$channel = $this->get_channel_by_name($_POST['channel']);
						}

						//add the channel to the channel array
						if($channel) {
							$playlist_id = $channel->items[0]->contentDetails->relatedPlaylists->uploads;
						}

						//the channel could not be found
						else {
							$getWP->addError(__('This channel cannot be found.','ayvpp').(isset($this->error[$_POST['channel']]->errors[0]->message) ? 'Google API error: '.$this->error[$_POST['channel']]->errors[0]->message : ''));
							return;
						}

					}
					elseif($_POST['type'] == 'playlist') {
						$playlist = $this->get_playlist_by_id($_POST['channel']);

						//add the playlist to the channel array
						if($playlist) {
							$playlist_id = $channel_id;
						}
						else {
							$getWP->addError(__('This playlist cannot be found.','ayvpp').(isset($this->error[$_POST['channel']]->errors[0]->message) ? 'Google API error: '.$this->error[$_POST['channel']]->errors[0]->message : ''));
							return;
						}
					}

					//compile channel array
					$ayvpp_options['channels'][$channel_id] = [
						'playlist'			=>	$playlist_id,
						'id'					=>	$channel_id,
						'name'				=>	$_POST['name'],
						'channel'				=>	$_POST['channel'],
						'limit'				=>	(isset($_POST['limit']) and !empty($_POST['limit'])) ? (int)$_POST['limit'] : false,
						'post_type'			=>	isset($_POST['publish_type']) ? $_POST['publish_type'] : 'post',
						'type'				=>	isset($_POST['type']) ? $_POST['type'] : 'channel',
						'auto_play'			=>	isset($_POST['auto_play']) ? $_POST['auto_play'] : 0,
						'related_show'			=>	isset($_POST['related_show']) ? $_POST['related_show'] : 0,
						'import_description'	=>	isset($_POST['import_description']) ? $_POST['import_description'] : 1,
						'import_private'		=>	isset($_POST['import_private']) ? $_POST['import_private'] : 1,
						'categories'			=>	$this->get_categories(),
						'terms'				=>	$this->get_terms(),
						'author'				=>	isset($_POST['author']) ? $_POST['author'] : 1,
						'publish'				=>	isset($_POST['publish']) ? $_POST['publish'] : 0
					];

					//save channel
					$ayvpp_options = $getWP->getOption('ayvpp_settings',$ayvpp_options,true);
					$getWP->addAlert(__('You have successfully added your channel.','ayvpp'));
					break;

				default :
					break;
			}
		}
	}

	private function channel_exists($channel_id) {
		global $ayvpp_options,$getWP;
		foreach((array)$ayvpp_options['channels'] as $v) {
			if($v['channel'] == $channel_id) {
				$getWP->addError(__('You have already added the channel','ayvpp').': "'.$channel_id.'".');
				return true;
			}
		}
		return false;
	}
	private function validate() {
		global $getWP;
		foreach(array('name','channel','type','author') as $v) {
			if(!isset($_POST[$v]) or empty($_POST[$v])) {
				$getWP->addError(__('Please fill out all the fields for a channel/playlist.','ayvpp'));
				return false;
			}
		}
		return true;
	}
	private function get_channel_by_id($channel_id) {
		global $getWP;
		if($this->get_key()) {
			return $this->get_entity($channel_id,'https://www.googleapis.com/youtube/v3/channels/?part=id,snippet,contentDetails&id='.$channel_id.'&key='.$this->get_key());
		}
		else {
			$getWP->addError(__('You must provide a Google API Key in the plugin settings','ayvpp'));
		}
		return false;
	}
	private function get_channel_by_name($channel_name) {
		global $getWP;
		if($this->get_key()) {
			return $this->get_entity($channel_name,'https://www.googleapis.com/youtube/v3/channels/?part=id,snippet,contentDetails&forUsername='.$channel_name.'&key='.$this->get_key());
		}
		else {
			$getWP->addError(__('You must provide a Google API Key in the plugin settings','ayvpp'));
		}
		return false;
	}
	private function get_playlist_by_id($playlist_id) {
		global $getWP;
		if($this->get_key()) {
			return $this->get_entity($playlist_id,'https://www.googleapis.com/youtube/v3/playlistItems/?part=id&playlistId='.$playlist_id.'&key='.$this->get_key());
		}
		else {
			$getWP->addError(__('You must provide a Google API Key in the plugin settings','ayvpp'));
		}
		return false;
	}
	private function get_entity($channel,$url) {
		$r = (new tern_curl())->get([
			'url'		=>	$url,
			'options'		=>	[
				'RETURNTRANSFER'	=>	true,
			],
			'headers'	=>	array(
				'Accept-Charset'	=>	'UTF-8',
			)
		]);
		$r = json_decode($r->body);
		if(isset($r->items) and !empty($r->items)) {
			return $r;
		}
		elseif(isset($r->error)) {
			$this->error[$channel] = $r->error;
		}
		return false;
	}
	private function get_terms() {
		$terms = [];
		if(isset($_POST['categories'])) {
			foreach((array)$_POST['categories'] as $v) {
				$t = explode('|',$v);
				if(!empty($t[0]) and !empty($t[1])) {
					$terms[$t[0]] = (isset($terms[$t[0]]) and is_array($terms[$t[0]])) ? $terms[$t[0]] : [];
					$terms[$t[0]][] = $t[1];
				}
			}
		}
		return $terms;
	}
	private function get_categories() {
		$cats = [];
		if(isset($_POST['categories'])) {
			foreach((array)$_POST['categories'] as $v) {
				$t = explode('|',$v);
				if(!empty($t[0]) and !empty($t[1])) {
					$cats[] = $t[1];
				}
			}
		}
		return $cats;
	}
	private function generate_id($n) {
		$c = "abcdefghijklmnopqrstuvwyxz0123456789!$";
		$s = '';
		for($i=0;$i<$n;$i++) {
			$s .= substr($c,rand(0,37),1);
		}
		return $s;
	}


}
new AYVPP_channel_free();

/****************************************Terminate Script******************************************/
?>
