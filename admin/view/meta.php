<p><button id="ayvpp_meta_sync_button" class="button button-primary">Sync with YouTube</button></p>

<label for="_ayvpp_video">YouTube&reg; ID:</label>
<input type="text" name="_ayvpp_video" id="_ayvpp_video" size="30" value="<?php echo $meta['_ayvpp_video'][0]; ?>" />

<label for="_ayvpp_video">YouTube&reg; URL:</label>
<input type="text" name="_ayvpp_video_url" id="_ayvpp_video_url" size="30" value="<?php echo $meta['_ayvpp_video_url'][0]; ?>" />

<label for"_ayvpp_author"="">YouTube&reg; <?php _e('Author','ayvpp'); ?>:</label>
<input type="text" name="_ayvpp_author" id="_ayvpp_author" size="30" value="<?php echo $meta['_ayvpp_author'][0]; ?>" />

<label><?php _e('Automatically play video','ayvpp'); ?>:</label>
<input type="radio" name="_ayvpp_auto_play" value="1" class="yes chk" <?php if((int)$meta['_ayvpp_auto_play'][0]) { ?>checked<?php } ?> /> yes &nbsp;
<input type="radio" name="_ayvpp_auto_play" value="0" class="no chk" <?php if(!(int)$meta['_ayvpp_auto_play'][0]) { ?>checked<?php } ?> /> no

<label><?php _e('Show related videos at the end of each video','ayvpp'); ?>:</label>
<input type="radio" name="_ayvpp_show_related" value="1" class="yes chk" <?php if((int)$meta['_ayvpp_show_related'][0]) { ?>checked<?php } ?> /> yes &nbsp;
<input type="radio" name="_ayvpp_show_related" value="0" class="no chk" <?php if(!(int)$meta['_ayvpp_show_related'][0]) { ?>checked<?php } ?> /> no


<input type="hidden" name="WP_ayvpp_nonce" id="WP_ayvpp_nonce" value="<?php echo wp_create_nonce('WP_ayvpp_nonce'); ?>" />
<input type="hidden" name="WP_ayvpp_action" />
