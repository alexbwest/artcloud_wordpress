<?php
/**
 * All the main shortcode functions.
 *
 * @since  1.0
 * @author webarts.io
 * @link   http://www.webarts.io
 */

if ( ! function_exists( 'webarts_refresh_mce' ) ) {
	function webarts_refresh_mce( $ver ) {
		$ver += 3;
		return $ver;
	}
}
// init process for button control
add_filter( 'tiny_mce_version', 'webarts_refresh_mce' );


if ( ! function_exists( 'webarts_pre_add_shortcode_buttons' ) ) {
	function webarts_pre_add_shortcode_buttons() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
			return;

		// Add only in Rich Editor mode
		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', 'webarts_pre_add_shortcodes_tinymce_plugin' );
			add_filter( 'mce_buttons', 'webarts_pre_register_shortcode_buttons' );
		}
	}
	
	add_action( 'init', 'webarts_pre_add_shortcode_buttons' );
}

if ( ! function_exists( 'webarts_pre_register_shortcode_buttons' ) ) {
	function webarts_pre_register_shortcode_buttons( $buttons ) {
		array_push( $buttons, 'webarts_pre_shortcodes_button' );
		return $buttons;
	}
}

// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
if ( ! function_exists( 'webarts_pre_add_shortcodes_tinymce_plugin' ) ) {
	function webarts_pre_add_shortcodes_tinymce_plugin( $plugin_array ) {
		$plugin_array['webarts_pre_shortcodes_button'] = plugins_url() . '/artcloud/admin/js/mce.js';
		return $plugin_array;
	}
}


add_action('media_buttons_context','add_my_tinymce_media_button');
function add_my_tinymce_media_button($context){
return $context.=__("
	<a href=\"#TB_inline?width=480&inlineId=my_shortcode_popup&width=640&height=513\" class=\"button arcloud_button thickbox\" id=\"my_shortcode_popup_button\" title=\"Add My Shortcode\"><i class=\"artcloud wp-media-buttons-icon\"></i>Add artcloud Shortcode</a>");
}
add_action('admin_footer','my_shortcode_media_button_popup');
//Generate inline content for the popup window when the "my shortcode" button is clicked
function my_shortcode_media_button_popup(){?>
  <div id="my_shortcode_popup" style="display:none;">
    <!--".wrap" class div is needed to make thickbox content look good-->
    <div class="wrap">
      <div>
        <h2>Insert artcloud Shortcode</h2>
        <div class="my_shortcode_add">          
          <table>
          	<tr>
          		<td class="label">Type</td>
          		<td>
          			<select id="type" name="type">
          				<option value="art">Art</option>
          				<option value="artists">Artists</option>
          				<option value="artist">Artist</option>
          				<option value="exh">Exhibition</option>
          			</select>
          		</td>
          	</tr>
          	<tr >
          		<td class="label">Theme</td>
          		<td>
          			<select id="theme" name="theme">
          				<option value="masonry">Masonry</option>
          				<option value="grid">Grid</option>          				
          			</select>
          		</td>
          	</tr>
          	<tr>
          		<td class="label">Link Artist</td>
          		<td><input type="text" name="artist" id="artist"></td>
          	</tr>
          	<tr>
          		<td class="label">Min price</td>
          		<td><input type="text" name="min_price" id="min_price"></td>
          	</tr>
          	 <tr>
          		<td class="label">Min price</td>
          		<td><input type="text" name="max_price" id="max_price"></td>
          	</tr>
          	 <tr>
          		<td class="label">Tags</td>
          		<td><input type="text" name="tag" id="tag"></td>
          	</tr>
          	<tr>
          		<td></td>
          		<td><button class="button-primary" id="id_of_button_clicked">Add artcloud Shortcode</button></td>
          	</tr>
          </table>
        </div>
        
      </div>
    </div>
  </div>
  <style type="text/css">
  	table td.label {
  		width: 200px;
  	}
  </style>
<?php
}
//javascript code needed to make shortcode appear in TinyMCE edtor
add_action('admin_footer','my_shortcode_add_shortcode_to_editor');
function my_shortcode_add_shortcode_to_editor(){?>
<script>
jQuery('#id_of_button_clicked ').on('click',function(){
  var type     = jQuery('#type option:selected').val();
  var theme    = jQuery('#theme option:selected').val();
  var artist   = jQuery('#artist').val();
  var minprice = jQuery('#min_price').val();
  var maxprice = jQuery('#max_price').val();
  var tag      = jQuery('#tag').val();
  var shortcode = '[artcloud type="'+type+'" theme="'+theme+'" artist="'+artist+'" min_price="'+minprice+'" max_price="'+maxprice+'" tag="'+tag+'"/]';
  if( !tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
    jQuery('textarea#content').val(shortcode);
  } else {
    tinyMCE.execCommand('mceInsertContent', false, shortcode);
  }
  //close the thickbox after adding shortcode to editor
  self.parent.tb_remove();
});
</script>
<?php
}