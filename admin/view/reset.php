<div class="wrap ayvpp-wrap tern-wrap">

	<h2><?php _e('Automatic Video Posts Reset','ayvpp'); ?></h2>

	<form id="WP_ayvpp_reset_form" method="post">
		<div class="tern-well">
			<h3><?php _e('Refreshing your video lists','ayvpp'); ?></h3>
			<p><?php _e('The following button will delete all videos imported and stored from the database and all WordPress posts associated with the videos.','ayvpp'); ?></p>
			<p><b><?php _e('THIS MAY TAKE SOME TIME.','ayvpp'); ?></b></p>
			<input type="submit" value="<?php _e('Completely Refresh Videos','ayvpp'); ?>" name="submit" class="button-primary action tern-button tern-button-big" />
		</div>

		<div class="tern-well">
			<h3><?php _e('Plugin stopped importing?','ayvpp'); ?></h3>
			<p><?php _e('When an import does not complete itself properly (usually by attempting to import too many videos) a value in the database needs to be reset.','ayvpp'); ?></p>
			<p><b><?php _e('PLEASE NOTE: IF AN IMPORT IS ACTUALLY TAKING PLACE AND YOU CLICK THIS BUTTON THERE IS THE POSSIBILITY OF CREATING DUPLICATE POSTS.','ayvpp'); ?></b></p>
			<input type="submit" value="<?php _e('Reset Import Field in the Database','ayvpp'); ?>" name="submit" class="button-primary action tern-button tern-button-big" />
		</div>

		<div class="tern-well">
			<h3><?php _e('Completely reset this plugin','ayvpp'); ?></h3>
			<p><?php _e('The following button will remove all the settings associated with this plugin as well as delete all videos imported and stored from the database and all WordPress posts associated with the videos.','ayvpp'); ?></p>
			<p><b><?php _e('THIS MAY TAKE SOME TIME.','ayvpp'); ?></b></p>
			<input type="submit" value="<?php _e('Reset this Plugin','ayvpp'); ?>" name="submit" class="button-primary action tern-button tern-button-big" />
		</div>

		<div class="tern-well">
			<h3><?php _e('Keep video posts but refresh all plugin settings','ayvpp'); ?></h3>
			<p><?php _e('The following button will remove all the settings associated with this plugin as well as delete all videos imported and stored from the database but will not delete all WordPress posts associated with the videos.','ayvpp'); ?></p>
			<input type="submit" value="<?php _e('Reset this Plugin but keep posts','ayvpp'); ?>" name="submit" class="button-primary action tern-button tern-button-big" />
		</div>

		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('WP_ayvpp_nonce');?>" />
		<input type="hidden" name="_wp_http_referer" value="<?php wp_get_referer(); ?>" />
	</form>

</div>
