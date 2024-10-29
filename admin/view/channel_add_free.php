<?php global $ayvpp_options,$ternSel; ?>
<div id="WP_ayvpp_add_item" class="add_item">
	<h3><?php _e('Add a new channel or playlist','ayvpp'); ?></h3>
	<form id="WP_ayvpp_add_channel_form" method="post" action="<?php bloginfo('wpurl'); ?>/wp-admin/admin.php?page=ayvpp-channels">
		<div class="form-field">
			<label><?php _e('Name','ayvpp'); ?>:</label>
			<input type="text" name="name" size="40" />
		</div>
		<div class="form-field">
			<label><?php _e('Type','ayvpp'); ?>:</label>
			<select name="type" class="postform">
				<option value="channel"><?php _e('Channel','ayvpp'); ?></option>
				<option value="playlist"><?php _e('Playlist','ayvpp'); ?></option>
				<option value="search"><?php _e('Search','ayvpp'); ?></option>
			</select>
		</div>
		<div class="form-field">
			<label><?php _e('Channel / Playlist / Search Term','ayvpp'); ?>:</label>
			<input type="text" name="channel" size="40" />
			<p class="description">
				<?php _e('Enter just the name of the channel, the ID of the playlist, or the search term.','ayvpp'); ?>
			</p>
		</div>

		<div class="form-field">
			<label><?php _e('Limit the number of videos imported each import to','ayvpp'); ?>:</label>
			<input type="text" name="limit" size="40" />
			<p class="description"><?php _e('Leave this field blank to set NO limit.','ayvpp'); ?></p>
		</div>

		<div class="form-field">
			<label><?php _e('Automatically publish posts','ayvpp'); ?>:</label>
			<input type="radio" name="publish" value=1 class="yes chk" />
			<?php _e('yes','ayvpp'); ?> &nbsp;
			<input type="radio" name="publish" value=0 class="no chk" />
			<?php _e('no','ayvpp'); ?>
		</div>
		<div class="form-field">
			<label><?php _e('Import private videos','ayvpp'); ?>:</label>
			<input type="radio" name="import_private" value=1 class="yes chk" />
			<?php _e('yes','ayvpp'); ?> &nbsp;
			<input type="radio" name="import_private" value=0 class="no chk" />
			<?php _e('no','ayvpp'); ?>
		</div>
		<div class="form-field">
			<label><?php _e('Import and display video descriptions','ayvpp'); ?>:</label>
			<input type="radio" name="import_description" value=1 class="yes chk" /> <?php _e('yes','ayvpp'); ?> &nbsp;
			<input type="radio" name="import_description" value=0 class="no chk" /> <?php _e('no','ayvpp'); ?>
			<p class="description"><?php _e('If set to yes, the YouTube&reg; video description will be imported and set as the post content.','ayvpp'); ?>.</p>
		</div>


		<div class="form-field">
			<label><?php _e('Add videos from this channel/playlist to the following categories','ayvpp'); ?>:</label>
			<div class="categories">
				<div>
					<?php $r = get_categories();unset($r['post_tag'],$r['nav_menu'],$r['link_category'],$r['post_format']); ?>
					<?php foreach((array)get_terms($r,array('hide_empty'=>0)) as $k => $v) { ?>
					<label>
						<input type="checkbox" name="categories[]" class="chk" value="<?php echo $v->taxonomy; ?>|<?php echo $v->term_id; ?>" /> <?php echo $v->name; ?> (<?php echo $v->taxonomy; ?>)
					</label>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="form-field">
			<label><?php _e('Attribute videos from this channel to what author?','ayvpp'); ?>:</label>
			<?php wp_dropdown_users(array('name'=>'author')); ?>
		</div>
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button-primary tern-button tern-button-medium" value="<?php _e('Edit Channel','ayvpp'); ?>">
		</p>
		<input type="hidden" name="item" />
		<input type="hidden" name="action" value="add" />
		<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('WP_ayvpp_nonce'); ?>" />
	</form>
</div>
<br class="clear" />
