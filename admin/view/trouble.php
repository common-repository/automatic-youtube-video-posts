<?php global $WP_ayvpp_ip; ?>
<div class="wrap ayvpp-wrap tern-wrap">

	<h2><?php _e('Puglin Trouble Shooting','ayvpp'); ?></h2>

		<div class="tern-well">
			<h3><?php _e('Server Information','ayvpp'); ?></h3>

			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label><?php _e('PHP "max_execution_time" setting','ayvpp'); ?>:</label></th>
					<td>
						<strong><?php echo $WP_ayvpp_met; ?> seconds</strong>
						<p class="description"><?php _e("This setting is very important if you're importing many videos. A standard setting is 30 seconds. Try setting this to 300 or greater in your php.ini file.",'ayvpp'); ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label><?php _e('Is plugin able change "max_execution_time" for longer imports itself?','ayvpp'); ?>:</label></th>
					<td>
						<?php if($WP_ayvpp_met_hard) { ?>
							<strong>NO</strong>
							<p class="description"><?php _e("This is not ideal. You may want to change this setting in your server's php.ini file to something more like 300.",'ayvpp'); ?></p>
						<?php } else { ?>
						<strong>YES</strong>
						<p class="description"><?php _e('This is great! The plugin should work for you for longer imports.','ayvpp'); ?></p>
						<?php } ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>Is cURL installed and enabled?:</label></th>
					<td>
						<?php if(!function_exists('curl_exec')) { ?>
							<strong>NO</strong>
							<p class="description"><?php _e('This is very bad. The plugin will not work for you!','ayvpp'); ?></p>
						<?php } else { ?>
						<strong>YES</strong>
						<p class="description"><?php _e('This is great!','ayvpp'); ?></p>
						<?php } ?>
					</td>
				</tr>
			</table>
		</div>


		<div class="tern-well">
			<h3><?php _e('Documentation','ayvpp'); ?></h3>
			<p>
				<a href="http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/documentation" class="button-primary tern-button tern-button-big" target="_blank">
					<?php _e('Click here to read the documenation for this plugin','ayvpp'); ?>
				</a>
				<a href="http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/change-log" class="button-primary tern-button tern-button-big" target="_blank">
					<?php _e('Click here for the Change Log','ayvpp'); ?>
				</a>
			</p>
		</div>


		<div class="tern-well">
			<h3><?php _e('Keep up to date','ayvpp'); ?></h3>
			<a href="https://www.facebook.com/ternstyle" class="button-primary tern-button tern-button-medium" target="_blank"><?php _e('Like us on Facebook','ayvpp'); ?></a>
			<a href="https://twitter.com/ternstyle" class="button-primary tern-button tern-button-medium" target="_blank"><?php _e('Follow us on Twitter','ayvpp'); ?></a>
		</div>
</div>
