<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<?php global $ayvpp_options,$ternSel; ?>
<div id="tab-import">
	<h3><?php echo _e('Import Settings','ayvpp'); ?></h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="import_date"><?php echo _e('Set publish date to time of import instead of YouTube upload date:','ayvpp'); ?></label></th>
			<td>
				<input type="checkbox" name="import_date" value=1 class="switchery" <?php if(isset($ayvpp_options['import_date']) and $ayvpp_options['import_date']) { ?>checked<?php } ?> />
				<span class="description"><?php echo _e('If you set this to yes all videos will have a publish date of the time they were imported into WordPress&trade;.','ayvpp'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cron"><?php echo _e('Import the latest videos every:','ayvpp'); ?></label></th>
			<td>
				<?php echo $ternSel->create(array(
					'data'		=>	array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24),
					'name'		=>	'cron',
					'selected'	=>	array((int)$ayvpp_options['cron'])

				)); ?> hours<br />
				<div class="description">
					<p><?php echo _e('Set this to determine how many hours to wait between imports.','ayvpp'); ?></p>
					<small><?php echo _e('PLEASE NOTE: This plugin uses WP-Cron. It is not an actual cronjonb, unless you configure your server to run WP-Cron as cronjob. Therefore, unless someone visits your site at or after the specified amount of time in this setting, the videos will not be imported until the next visit to your site.','ayvpp'); ?></small>
				</div>
			</td>
		</tr>
		<!--
		<tr valign="top">
			<th scope="row"><label for="admin_import"><?php echo _e('Import only when logged in:','ayvpp'); ?></label></th>
			<td>
				<input type="checkbox" name="admin_import" value=1 class="switchery" <?php if(isset($ayvpp_options['admin_import']) and $ayvpp_options['admin_import']) { ?>checked<?php } ?> />
			</td>
		</tr>
		-->
	</table>
	<p class="submit"><input type="submit" name="submit" class="button-primary tern-button tern-button-medium" value="<?php echo _e('Save Changes','ayvpp'); ?>" /></p>
</div>
