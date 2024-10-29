<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<?php global $ayvpp_options,$ternSel,$WP_ayvpp_lang_codes; ?>
<div id="tab-player">
	<h3><?php echo _e('Player Settings','ayvpp'); ?></h3>
	<div class="tern_errors"><p><?php _e('Note: These settings are avilable for PRO only.','ayvpp'); ?> <a href="https://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/purchase" target="_blank"><?php _e('Upgrade Now!','ayvpp'); ?></a></p></div>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="video_autoplay"><?php echo _e('Autoplay:','ayvpp'); ?></label></th>
			<td>
				<input disabled type="checkbox" name="video_autoplay" value=1 class="switchery" <?php if(isset($ayvpp_options['video_autoplay']) and $ayvpp_options['video_autoplay']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('This parameter specifies whether the initial video will automatically start to play when the player loads.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_cc_lang"><?php echo _e('Closed Caption Language:','ayvpp'); ?></label></th>
			<td>
				<?php echo $ternSel->create([
					'type'		=>	'assoc',
					'data'		=>	array_flip($WP_ayvpp_lang_codes),
					'name'		=>	'video_cc_lang" disabled="disabled',
					'selected'	=>	[$ayvpp_options['video_cc_lang']]

				]); ?>
				<span class="description"><?php echo _e('This parameter specifies the default language that the player will use to display captions.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_cc_load"><?php echo _e('Force Closed Caption:','ayvpp'); ?></label></th>
			<td>
				<input disabled type="checkbox" name="video_cc_load" value=1 class="switchery" <?php if(isset($ayvpp_options['video_cc_load']) and $ayvpp_options['video_cc_load']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('Turning this on causes closed captions to be shown by default, even if the user has turned captions off.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_color"><?php echo _e('Turn color to white:','ayvpp'); ?></label></th>
			<td>
				<input disabled type="checkbox" name="video_color" value=1 class="switchery" <?php if(isset($ayvpp_options['video_color']) and $ayvpp_options['video_color']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('If turned on the video progress bar to highlight the amount of the video that the viewer has already seen will be white.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_controls"><?php echo _e('Controls:','ayvpp'); ?></label></th>
			<td>
				<input disabled type="checkbox" name="video_controls" value=1 class="switchery" <?php if(isset($ayvpp_options['video_controls']) and $ayvpp_options['video_controls']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('This parameter indicates whether the video player controls are displayed.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_fs"><?php echo _e('Show fullscreen button:','ayvpp'); ?></label></th>
			<td>
				<input disabled type="checkbox" name="video_fs" value=1 class="switchery" <?php if(isset($ayvpp_options['video_fs']) and $ayvpp_options['video_fs']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('Turning this on causes the fullscreen button to be displayed.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_lang"><?php echo _e('Interface Language:','ayvpp'); ?></label></th>
			<td>
				<?php echo $ternSel->create([
					'type'		=>	'assoc',
					'data'		=>	array_flip($WP_ayvpp_lang_codes),
					'name'		=>	'video_lang" disabled="disabled',
					'selected'	=>	[$ayvpp_options['video_cc_lang']]

				]); ?>
				<span class="description"><?php echo _e("Sets the player's interface language.",'ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_loop"><?php echo _e('Loop:','ayvpp'); ?></label></th>
			<td>
				<input disabled type="checkbox" name="video_loop" value=1 class="switchery" <?php if(isset($ayvpp_options['video_loop']) and $ayvpp_options['video_loop']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('Turning this on causes the player to play the initial video again and again.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_rel"><?php echo _e('Show related videos:','ayvpp'); ?></label></th>
			<td>
				<input disabled type="checkbox" name="video_rel" value=1 class="switchery" <?php if(isset($ayvpp_options['video_rel']) and $ayvpp_options['video_rel']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('This parameter indicates whether the player should show related videos when playback of the initial video ends.','ayvpp'); ?></span>
			</td>
		</tr>
	</table>
	<p class="submit"><input disabled type="submit" name="submit" class="button-primary tern-button tern-button-medium" value="<?php echo _e('Save Changes','ayvpp'); ?>" /></p>
</div>
