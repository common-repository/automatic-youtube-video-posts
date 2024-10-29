<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<?php global $ayvpp_options,$ternSel; ?>
<div id="tab-api">
	<h3><?php echo _e('API Settings','ayvpp'); ?></h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="google_api_key"><?php echo _e('Google API Key','ayvpp'); ?></label></th>
			<td>
				<input type="text" name="key" class="regular-text" value="<?php echo isset($ayvpp_options['key']) ? $ayvpp_options['key'] : ''; ?>" />
				<span class="description">
					<?php echo _e('You must provide a valid configured Google API Key to use this plugin!','ayvpp'); ?>
					<a href="https://code.google.com/apis/console" target="_blank">https://code.google.com/apis/console</a>
				</span>
			</td>
		</tr>
	</table>
	<p class="submit"><input type="submit" name="submit" class="button-primary tern-button tern-button-medium" value="<?php echo _e('Save Changes','ayvpp'); ?>" /></p>
</div>
