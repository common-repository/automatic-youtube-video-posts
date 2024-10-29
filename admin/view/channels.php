<?php global $wpdb,$ayvpp_options,$ternSel; ?>
<div class="wrap tern-wrap">

	<h2><?php _e('Channels / Playlists','ayvpp'); ?></h2>
	<br class="clear">

	<div id="col-container">
		<div id="col-right">
			<div class="col-wrap">

				<form method="post" action="">

					<div class="tablenav top">
						<div class="alignleft actions">
							<select name="action">
								<option value="" selected="selected"><?php _e('Bulk Actions','ayvpp'); ?></option>
								<option value="delete"><?php _e('Delete','ayvpp'); ?></option>
								<option value="activate"><?php _e('Activate','ayvpp'); ?></option>
								<option value="deactivate"><?php _e('Deactivate','ayvpp'); ?></option>
							</select>
							<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply','ayvpp'); ?>">
						</div>
						<br class="clear">
					</div>

					<table class="wp-list-table widefat fixed tags" cellspacing="0">
						<thead>
						<tr class="thead">
							<th scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></th>
							<th scope="col"><?php _e('Name','ayvpp'); ?></th>
							<th scope="col"><?php _e('Type','ayvpp'); ?></th>
							<th scope="col"><?php _e('Catgories','ayvpp'); ?></th>
							<th scope="col"><?php _e('Author','ayvpp'); ?></th>
							<th scope="col"><?php _e('Import','ayvpp'); ?></th>
							<th scope="col"><?php _e('Activate / Deactivate','ayvpp'); ?></th>
						</tr>
						</thead>
						<tfoot>
						<tr class="thead">
							<th scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></th>
							<th scope="col"><?php _e('Name','ayvpp'); ?></th>
							<th scope="col"><?php _e('Type','ayvpp'); ?></th>
							<th scope="col"><?php _e('Catgories','ayvpp'); ?></th>
							<th scope="col"><?php _e('Author','ayvpp'); ?></th>
							<th scope="col"><?php _e('Import','ayvpp'); ?></th>
							<th scope="col"><?php _e('Activate / Deactivate','ayvpp'); ?></th>
						</tr>
						</tfoot>
						<tbody>
							<?php if(isset($ayvpp_options['channels']) and is_array($ayvpp_options['channels']) and !empty($ayvpp_options['channels'])) { ?>
							<?php foreach((array)$ayvpp_options['channels'] as $k => $v) { $d = empty($d) ? ' class="alternate"' : ''; ?>
								<tr id='field-<?php echo $k;?>'<?php echo $d;?>>
									<th scope='row' class="manage-column column-cb check-column">
										<input type='checkbox' name='items[]' id='field_<?php echo $k;?>' value='<?php echo $k;?>' />

										<input type="hidden" name="name" value="<?php echo $v['name']; ?>" />
										<input type="hidden" name="channel" value="<?php echo $v['channel']; ?>" />
										<input type="hidden" name="limit" value="<?php echo $v['limit']; ?>" />
										<input type="hidden" name="publish_type" value="<?php echo $v['post_type']; ?>" />
										<input type="hidden" name="type" value="<?php echo $v['type']; ?>" />
										<input type="hidden" name="publish" value=<?php echo $v['publish']; ?> />
										<input type="hidden" name="auto_play" value=<?php echo $v['auto_play']; ?> />
										<input type="hidden" name="related_show" value=<?php echo $v['related_show']; ?> />
										<input type="hidden" name="import_description" value=<?php echo $v['import_description']; ?> />
										<input type="hidden" name="import_private" value=<?php echo $v['import_private']; ?> />
										<input type="hidden" name="author" value=<?php echo $v['author']; ?> />

									</th>
									<td>
										<strong><?php echo $v['name']; ?></strong>
										<div class="row-actions">
											<span class='edit WP_ayvpp_edit'>
												<a href="#TB_inline?width=400&height=600&inlineId=WP_ayvpp_add_item" class="thickbox">
													<?php _e('Edit','ayvpp'); ?>
												</a>
											</span> |
											<span class="edit">
												<a href="admin.php?page=ayvpp-channels&items%5B%5D=<?php echo $k; ?>&action=delete&_wpnonce=<?php echo wp_create_nonce('WP_ayvpp_nonce'); ?>">
													<?php _e('Delete','ayvpp'); ?>
												</a>
											</span>
										</div>
									</td>
									<td><?php echo $v['type']; ?></td>
									<td>
										<?php $c = '';$d = 0;$e = ''; ?>

										<?php foreach($v['categories'] as $w) {
											$d = $wpdb->get_row('select * from '.$wpdb->prefix.'terms where term_id='.$w);
											if(!$d) {
												continue;
											}
											$c .= empty($c) ? '' : ',';
											$e .= empty($e) ? '' : ',';
											$c .= $d->name;
											$e .= $d->term_id;
										}echo $c; ?>
										<input type="hidden" name="cats" value="<?php echo $e; ?>" />
									</td>
									<td><input type="hidden" value="<?php echo $v['author']; ?>" /><?php $a = get_userdata($v['author']);echo $a->display_name; ?></td>
									<td>
										<a href="<?php echo get_admin_url(); ?>admin.php?page=ayvpp-import-videos&channel=<?php echo $k; ?>" class="button-primary import tern-button">
											<?php _e('Import','ayvpp'); ?>
										</a>
									</td>
									<td>
										<?php if(!isset($v['activated']) or (isset($v['activated']) and $v['activated'])) { ?>
										<a href="admin.php?page=ayvpp-channels&items%5B%5D=<?php echo $k; ?>&action=deactivate&_wpnonce=<?php echo wp_create_nonce('WP_ayvpp_nonce'); ?>" class="button-primary import tern-button">
											<?php _e('Deactivate','ayvpp'); ?>
										</a>
										<?php } else if(isset($v['activated']) and !$v['activated']) { ?>
										<a href="admin.php?page=ayvpp-channels&items%5B%5D=<?php echo $k; ?>&action=activate&_wpnonce=<?php echo wp_create_nonce('WP_ayvpp_nonce'); ?>" class="button-primary import tern-button">
											<?php _e('Activate','ayvpp'); ?>
										</a>
										<?php } ?>
									</td>
								</tr>
							<?php }?>
							<?php }?>
						</tbody>
					</table>

					<div class="tablenav top">
						<div class="alignleft actions">
							<select name="action2">
								<option value="" selected="selected"><?php _e('Bulk Actions','ayvpp'); ?></option>
								<option value="delete"><?php _e('Delete','ayvpp'); ?></option>
							</select>
							<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply','ayvpp'); ?>">
						</div>
						<br class="clear">
					</div>

					<input type="hidden" id="page" name="page" value="ayvpp-channels" />
					<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('WP_ayvpp_nonce');?>" />
				</form>

			</div>
		</div>

		<div id="col-left">
			<div class="col-wrap">
				<div class="form-wrap tern-well">
					<h3><?php _e('Add a new channel, playlist, or search term','ayvpp'); ?>:</h3>

					<form id="WP_ayvpp_add_item_form" method="post" action="<?php bloginfo('wpurl'); ?>/wp-admin/admin.php?page=ayvpp-channels">

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
							<p class="description"><?php _e('Enter just the name of the channel, the ID of the playlist, or the search term.','ayvpp'); ?></p>
						</div>

						<div class="form-field">
							<label><?php _e('Limit the number of videos imported each import to','ayvpp'); ?>:</label>
							<input type="text" name="limit" size="40" />
							<p class="description"><?php _e('Leave this field blank to set NO limit.','ayvpp'); ?></p>
						</div>

						<div class="form-field">
							<label><?php _e('Automatically publish posts','ayvpp'); ?>:</label>
							<input type="radio" name="publish" value=1 class="yes chk" checked /> <?php _e('yes','ayvpp'); ?> &nbsp;
							<input type="radio" name="publish" value=0 class="no chk" /> <?php _e('no','ayvpp'); ?>
						</div>
						<div class="form-field">
							<label><?php _e('Import private videos','ayvpp'); ?>:</label>
							<input type="radio" name="import_private" value=1 class="yes chk" checked />
							 &nbsp;
							<input type="radio" name="import_private" value=0 class="no chk" />
							<?php _e('no','ayvpp'); ?>
						</div>

						<div class="form-field">
							<label><?php _e('Import and display video descriptions','ayvpp'); ?>:</label>
							<input type="radio" name="import_description" value=1 class="yes chk" checked />  &nbsp;
							<input type="radio" name="import_description" value=0 class="no chk" /> <?php _e('no','ayvpp'); ?>
							<p class="description"><?php _e('If set to yes, the YouTube&reg; video description will be imported and set as the post content.','ayvpp'); ?>.</p>
						</div>

						<div class="form-field">
							<label><?php _e('Add videos from this channel/playlist to the following categories','ayvpp'); ?>:</label>
							<div class="categories"><div>
								<?php $r = get_categories();unset($r['post_tag'],$r['nav_menu'],$r['link_category'],$r['post_format']); ?>
								<?php foreach((array)get_terms($r,array('hide_empty'=>0)) as $k => $v) { ?>
								<label>
									<input type="checkbox" name="categories[]" class="chk" value="<?php echo $v->taxonomy; ?>|<?php echo $v->term_id; ?>" /> <?php echo $v->name; ?> (<?php echo $v->taxonomy; ?>)
								</label>
								<?php } ?>
							</div></div>
						</div>

						<div class="form-field">
							<label><?php _e('Attribute videos from this channel to what author?','ayvpp'); ?>:</label>
							<?php wp_dropdown_users(array('name'=>'author')); ?>
						</div>

						<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary tern-button  tern-button-medium" value="<?php _e('Add Channel','ayvpp'); ?>"></p>

						<input type="hidden" name="item" />
						<input type="hidden" name="action" value="add" />
						<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('WP_ayvpp_nonce'); ?>" />
					</form>
				</div>
			</div>
		</div>

	</div>
	<br class="clear" />
</div>
