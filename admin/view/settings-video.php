<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<?php global $ayvpp_options,$ternSel; ?>
<div id="tab-video">
	<h3><?php echo _e('Video Settings','ayvpp'); ?></h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="video_responsive"><?php echo _e('Do you want your videos to be responsive?:','ayvpp'); ?></label></th>
			<td>
				<input type="checkbox" name="video_responsive" value=1 class="switchery" <?php if(isset($ayvpp_options['video_responsive']) and $ayvpp_options['video_responsive']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('If yes, your videos will become 100% width of their containing element and scale to fit the device being used.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_responsive_ratio"><?php echo _e('Responsive video ratio:','ayvpp'); ?></label></th>
			<td>
				<?php echo $ternSel->create(array(
					'data'		=>	array('1:1','3:2','4:3','5:3','5:4','16:9'),
					'name'		=>	'video_responsive_ratio',
					'selected'	=>	array($ayvpp_options['video_responsive_ratio'])

				)); ?>
				<span class="description"><?php echo _e('This defines the ratio by which your responsive videos will scale.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="video_dims"><?php echo _e('Video dimensions:','ayvpp'); ?></label></th>
			<td>
				<input type="text" name="video_dims[]" class="regular-text" value="<?php echo $ayvpp_options['video_dims'][0];?>" /> x <input type="text" name="video_dims[]" class="regular-text" value="<?php echo $ayvpp_options['video_dims'][1];?>" /><br />
				<span class="description"><?php echo _e('This defines the dimensions of the videos placed in their respective posts.','ayvpp'); ?></span>
			</td>
		</tr>
	</table>
	<p class="submit"><input type="submit" name="submit" class="button-primary tern-button tern-button-medium" value="<?php echo _e('Save Changes','ayvpp'); ?>" /></p>
</div>
