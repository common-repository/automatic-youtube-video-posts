<div class="wrap ayvpp-wrap tern-wrap">

	<h2><?php _e('Automatic Video Posts Duplicate Post Removal','ayvpp'); ?></h2>

	<form id="WP_ayvpp_dups_form" method="post">
		<div class="tern-well">
			<h3><?php _e('Remove dupliate posts','ayvpp'); ?></h3>
			<p><?php _e('The following button will delete all duplicate videos, imported and stored, from the database and all WordPress posts associated with the videos.','ayvpp'); ?></p>
			<p><b>T<?php _e('HIS MAY TAKE SOME TIME.','ayvpp'); ?></b></p>
			<input type="submit" value="<?php _e('Cleanup','ayvpp'); ?>" name="submit" class="button-primary action tern-button tern-button-big" />
		</div>

		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('WP_ayvpp_nonce');?>" />
		<input type="hidden" name="_wp_http_referer" value="<?php wp_get_referer(); ?>" />
	</form>

</div>
