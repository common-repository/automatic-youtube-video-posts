<?php use ternplugin\youtube_video as youtube_video; ?>

<div class="wrap tern-wrap">

	<h2><?php _e('Video Posts','ayvpp'); ?></h2>

	<div class="tern-well">
		<h4><?php _e('Below you can delete, publish or draft your video posts.','ayvpp'); ?></h4>

		<p><?php _e("Let's talk about this video list a little. This list displays all the videos that have been found in your YouTube&reg; channels and playlists. For each of these videos a WordPress post has been created. From this list you can manipulate the WordPress post by publishing, drafting or deleting it. When deleting a post you are simply moving it to the trash. Any of these actions taken does not affect the list of videos below PROVIDED THAT YOU NEVER PERMANENTLY DELETE THE POST CREATED. You cannot delete a video from the list below unless you reset the list below or manually delete a post from the trash. Publishing, deleting or drafting only affects the post associated with the YouTube&reg; video. Remember this list is simply a reference to the videos that this plugin has found in your YouTube&reg; channels and playlists. However, upon the permanent deletion of a post the import may republish the deleted video post automatically. If you wish to hide a video post from your blog, set the post to draft or move it to the trash.",'ayvpp'); ?></p>


		<form method="post" action="">
			<p><?php _e('The following button will delete all videos from the list below and all WordPress posts associated with the videos below. THIS MAY TAKE SOME TIME.','ayvpp'); ?></p>
			<input type="submit" value="<?php _e('Completely Refresh Videos','ayvpp'); ?>" name="refresh" class="button-primary action tern-button tern-button-medium" />
			<input type="hidden" name="action" value="refresh" />
			<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('WP_ayvpp_nonce');?>" />
		</form>
	</div>

	<form id="tern_wp_youtube_list_fm" method="post" action="">
		<div class="tablenav">
			<?php
				$paging_text = paginate_links(array(
					'total'		=>	ceil($video_count/10),
					'current'	=>	$page,
					'base'		=>	'admin.php?page=ayvpp-video-posts&%_%',
					'format'	=>	'paged=%#%'
				));
				if($paging_text) {
					$paging_text = sprintf( '<span class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s','ayvpp' ) . '</span>%s',
						number_format_i18n(($page-1)*10+1),
						number_format_i18n(min($page*10,$video_count)),
						number_format_i18n($video_count),
						$paging_text
					);
				}
			?>
			<div class="tablenav-pages"><?php echo $paging_text; ?></div>
			<div class="alignleft actions">
				<select name="action">
					<option value="" selected="selected"><?php _e('Bulk Actions','ayvpp'); ?></option>
					<option value="delete"><?php _e('Delete','ayvpp'); ?></option>
					<option value="publish"><?php _e('Publish','ayvpp'); ?></option>
					<option value="draft"><?php _e('Draft','ayvpp'); ?></option>
				</select>
				<input type="submit" value="<?php _e('Apply','ayvpp'); ?>" name="doaction" class="button-secondary action" />
			</div>
			<br class="clear" />
		</div>
		<table class="widefat fixed" cellspacing="0">
			<thead>
				<tr class="thead">
					<th scope="col" style="width:40px;" class="manage-column column-cb check-column"><input type="checkbox" /></th>
					<th scope="col" style="width:130px;"><?php _e('Preview','ayvpp'); ?></th>
					<th scope="col" style="width:300px;"><?php _e('Video Title','ayvpp'); ?></th>
					<th scope="col"><?php _e('Publish Date','ayvpp'); ?></th>
					<th scope="col"><?php _e('URL','ayvpp'); ?></th>
					<th scope="col"><?php _e('Edit Post','ayvpp'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr class="thead">
					<th scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></th>
					<th scope="col"><?php _e('Preview','ayvpp'); ?></th>
					<th scope="col"><?php _e('Video Title','ayvpp'); ?></th>
					<th scope="col"><?php _e('Publish Date','ayvpp'); ?></th>
					<th scope="col"><?php _e('URL','ayvpp'); ?></th>
					<th scope="col"><?php _e('Edit Post','ayvpp'); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php

					foreach($videos as $v) {

						global $post;
						$post = get_post($v);

						$video = new youtube_video($ayvpp_options);

						$k = get_post_meta($v,'_ayvpp_video',true);
						$d = empty($d) ? ' class="alternate"' : '';
				?>
						<tr id='field-<?php echo $k;?>' <?php echo $d;?>>
							<th scope="row" class="manage-column column-cb check-column"><input type='checkbox' name='videos[]' id='field_<?php echo $k;?>' value='<?php echo $v;?>' /></th>
							<td>
								<img src="<?php echo $video->thumb('default'); ?>" alt="thumbnail" />
							</td>
							<td>
								<strong><?php echo $post->post_title; ?></strong>
								<div class="row-actions">
									<?php
										$s = '';
										if($post->ID and $post->post_status != 'trash') {
											$s = '<span class="edit"><a href="admin.php?page=ayvpp-video-posts&videos%5B%5D='.$v.'&action=delete&_wpnonce='.wp_create_nonce('WP_ayvpp_nonce').'&paged='.$page.'">Delete</a></span>';
										}
										if($post->ID and $post->post_status != 'publish') {
											$s .= empty($s) ? '' : ' | ';
											$s .= '<span class="edit"><a href="admin.php?page=ayvpp-video-posts&videos%5B%5D='.$v.'&action=publish&_wpnonce='.wp_create_nonce('WP_ayvpp_nonce').'&paged='.$page.'">Publish</a></span>';
										}
										if($post->ID and $post->post_status != 'draft') {
											$s .= empty($s) ? '' : ' | ';
											$s .= '<span class="edit"><a href="admin.php?page=ayvpp-video-posts&videos%5B%5D='.$v.'&action=draft&_wpnonce='.wp_create_nonce('WP_ayvpp_nonce').'&paged='.$page.'">Draft</a></span>';
										}
										echo $s;
									?>
								</div>
							</td>
							<td>
								<?php the_time('n/j/Y g:ia'); ?>
							</td>
							<td>
								<a href="<?php echo $video->video_watch_url(); ?>" target="_blank"><?php echo $video->video_watch_url(); ?></a>
							</td>
							<td>
								<a href="<?php echo admin_url('post.php?action=edit&post='.$v); ?>" target="_blank" class="button">Edit</a>
							</td>
						</tr>
				<?php
					}
				?>
			</tbody>
		</table>
		<div class="tablenav">
			<div class="alignleft actions">
				<select name="action2">
					<option value="" selected="selected"><?php _e('Bulk Actions','ayvpp'); ?></option>
					<option value="delete"><?php _e('Delete','ayvpp'); ?></option>
					<option value="publish"><?php _e('Publish','ayvpp'); ?></option>
					<option value="draft"><?php _e('Draft','ayvpp'); ?></option>
				</select>
				<input type="submit" value="<?php _e('Apply','ayvpp'); ?>" name="doaction2" class="button-secondary action" />
			</div>
			<br class="clear" />
		</div>
		<input type="hidden" id="paged" name="paged" value="<?php echo $page; ?>" />
		<input type="hidden" id="page" name="page" value="ayvpp-video-posts" />
		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('WP_ayvpp_nonce');?>" />
	</form>
</div>
