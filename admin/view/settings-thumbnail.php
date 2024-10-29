<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<?php global $ayvpp_options,$ternSel; ?>
<div id="tab-thumbnail">
	<h3><?php echo _e('Thumbnail Settings','ayvpp'); ?></h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="import_thumbnails"><?php echo _e('Import and store video thumbnails locally:','ayvpp'); ?></label></th>
			<td>
				<input type="checkbox" name="import_thumbnails" value=1 class="switchery" <?php if(isset($ayvpp_options['import_thumbnails']) and $ayvpp_options['import_thumbnails']) { ?>checked<?php } ?> />
				<span class="description">
					<?php echo _e('If you set this to yes all images will be imported and stored in your WordPress&trade; uploads folder. The import may slow down the first time viewing of pages on your site which display the thumbnails.','ayvpp'); ?>
				</span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="thumbs_show"><?php echo _e('Automatically display video thumbnails:','ayvpp'); ?></label></th>
			<td>
				<input type="checkbox" name="thumbs_show" value=1 class="switchery" <?php if(isset($ayvpp_options['thumbs_show']) and $ayvpp_options['thumbs_show']) { ?>checked<?php } ?> />
				<span class="description">
					<?php echo _e('This option will display or hide the video thumbnails provided by YouTube&reg;. If you choose yes, wherever your theme uses the built-in WordPress function "the_post_thumbnail" the video thumbnail will be displayed automatically.','ayvpp'); ?>
				</span>
			</td>
		</tr>
	</table>
	<p class="submit"><input type="submit" name="submit" class="button-primary tern-button tern-button-medium" value="<?php echo _e('Save Changes','ayvpp'); ?>" /></p>
</div>
