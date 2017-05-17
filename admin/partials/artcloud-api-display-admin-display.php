<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://webarts.io
 * @since      1.0.0
 *
 * @package    Artcloud_Api_Display
 * @subpackage Artcloud_Api_Display/admin/partials
 */

?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<!--Contenedor-->
<div class="container art-block">
<h1 class="art-titl"><span class="dashicons-before dashicons-admin-generic"></span>artcloud Api Settings</h1>
<form action="<?php echo admin_url() . 'admin-post.php' ?>" method='post' class="bs-example bs-example-form">
	<ul class="nav nav-tabs">

	  <li class="active"><a data-toggle="tab" href="#art">General</a></li>
	  <li><a data-toggle="tab" href="#howtouse">How to use</a></li>
	  <!--<li><a data-toggle="tab" href="#artist">Artist</a></li>
	  <li><a data-toggle="tab" href="#exhibition ">Exhibition </a></li> -->
	</ul>
	<?php 
		$options = get_option( ART_SETTINGS );
		
	?>
	<div class="tab-content row panel-body">
	  <!-- art -->
	  <div id="art" class="tab-pane fade in active">	    
	    <div class="col-md-6">
	    <!--div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">		    
		    Shortcode to show data from artcloud: <strong>[artcloud_display]</strong>
		</div-->
	    <input type="hidden" name="action" value="art_save_options" />
		    <div class="form-group">
			    <label for="exampleInputEmail1">artcloud API Key</label>
			     <?php $apiKey = ( isset( $options['api_key'] ) ) ? $options['api_key'] : ''; ?>
			    <input type="text" class="form-control" name="apiKey" id="apikey" aria-describedby="apiHelp" value="<?php echo esc_attr( $apiKey ); ?>" placeholder="Enter API Key">
			    <small id="apiHelp" class="form-text text-muted">To get your API key visit the billings page of your artcld.com account</small>
		 	 </div>
		 	 <!--div class="form-group">
			  <label for="type-art">Select type:</label>
			  <select class="form-control" name="type-art" id="type-art">
			    <option value="art">Art</option>
			    <option value="artist">Artist</option>
			    <option value="exh">Exhibition</option>			    
			  </select>
			</div>
			 <div class="form-group">
			  <label for="type-theme">Select theme:</label>
			  <select class="form-control" name="type-theme" id="type-theme">
			    <option value="non-grid">Masonry</option>
			    <option value="grid">Grid</option>			   		   
			  </select>
			</div-->
	 	 </div>

	  </div>
	  <!-- end art -->

	  <!-- artist -->

	   <div id="howtouse" class="tab-pane fade">
	    <h3>How to use</h3>
	    <div class="howtouse-block">
	    	
	    </div>
	  </div>

	  <!-- end artist -->
	</div>
	<div class="col-md-6">
		
		 <input type="submit" class="btn  dropdown-toggle" name='art_save_settings' value="<?php _e( 'Save', 'art-api-display' ); ?>" />
		 <?php wp_nonce_field( 'art_nonce_save_settings', 'art_add_nonce_save_settings' ); ?>
		 
	</div>
</form>

</div>
<script type="text/javascript">
	<?php 
		$type = $options['type'];		
		$theme = $options['theme'];		
	?>
	jQuery('.nav-tabs a').click(function(){
    	jQuery(this).tab('show');
	})

	jQuery(document).ready(function(){
		jQuery('#type-art option').each(function(){
			type = '<?php echo $type; ?>';
			console.log(type);
			v = jQuery(this).val();
			if(v == type) {
				jQuery(this).attr('selected', 'true');
			}
		})

		jQuery('#type-theme option').each(function(){
			theme = '<?php echo $theme; ?>';
			
			v = jQuery(this).val();
			if(v == theme) {
				jQuery(this).attr('selected', 'true');
			}
		})
	})
	

</script>