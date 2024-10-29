<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<div class="wrap tern-wrap">
	<h2><?php echo _e('Plugin Settings','ayvpp'); ?></h2>
	<br /><br />
	<form method="post" action="">

		<div class="tern-tabs">
			<ul>
				<li><a href="#tab-api">API Settings</a></li>
				<li><a href="#tab-import">Import</a></li>
				<li><a href="#tab-display">Display</a></li>
				<li><a href="#tab-video">Video</a></li>
				<li><a href="#tab-player">Player</a></li>
				<li><a href="#tab-thumbnail">Thumbnail</a></li>
			</ul>


			<?php include('settings-api.php'); ?>
			<?php include('settings-import.php'); ?>
			<?php include('settings-display.php'); ?>
			<?php include('settings-video.php'); ?>
			<?php include('settings-player_free.php'); ?>
			<?php include('settings-thumbnail.php'); ?>

		</div>

		<input type="hidden" name="action" value="update_ayvpp_settings" />
		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('WP_ayvpp_nonce');?>" />
		<input type="hidden" name="_wp_http_referer" value="<?php wp_get_referer(); ?>" />

	</form>
</div>
