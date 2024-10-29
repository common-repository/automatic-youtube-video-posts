<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<?php global $ayvpp_options,$ternSel; ?>
<div id="tab-display">
	<h3><?php echo _e('Display Settings','ayvpp'); ?></h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="content_display_meta"><?php echo _e('Display video meta:','ayvpp'); ?></label></th>
			<td>
				<input type="checkbox" name="content_display_meta" value=1 class="switchery" <?php if(isset($ayvpp_options['content_display_meta']) and $ayvpp_options['content_display_meta']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('This option will display or hide the video post meta such as the author and post date when viewing your video post.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="content_truncate"><?php echo _e('Do you want to add the WordPress "More" tag to your video descriptions?:','ayvpp'); ?></label></th>
			<td>
				<input type="checkbox" name="content_truncate" value=1 class="switchery" <?php if(isset($ayvpp_options['content_truncate']) and $ayvpp_options['content_truncate']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e("If yes, the more tag will be added so that the whole video description isn't displayed in your post lists.",'ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="content_truncate_after"><?php echo _e('Number of words before WordPress "More" tag:','ayvpp'); ?></label></th>
			<td>
				<?php echo $ternSel->create(array(
					'data'		=>	array(10,20,25,30,35,40,45,50,100,200),
					'name'		=>	'content_truncate_after',
					'selected'	=>	array((int)$ayvpp_options['content_truncate_after'])

				)); ?>
				<span class="description"><?php echo _e('This defines the number of words after which the excerpt will cut-off.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="content_top"><?php echo _e('Place video after description:','ayvpp'); ?></label></th>
			<td>
				<input type="checkbox" name="content_top" value=1 class="switchery" <?php if(isset($ayvpp_options['content_top']) and $ayvpp_options['content_top']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('If yes, the video in each post will be programmatically added after the description.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_post_list_show"><?php echo _e('Display videos in post lists:','ayvpp'); ?></label></th>
			<td>
				<input type="checkbox" name="video_post_list_show" value=1 class="switchery" <?php if(isset($ayvpp_options['video_post_list_show']) and $ayvpp_options['video_post_list_show']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('If set to yes, videos assigned to posts will be displayed in the posts truncated content in post loops.','ayvpp'); ?></span>
			</td>
		</tr>
	</table>
	<p class="submit"><input type="submit" name="submit" class="button-primary tern-button tern-button-medium" value="<?php echo _e('Save Changes','ayvpp'); ?>" /></p>
</div>
