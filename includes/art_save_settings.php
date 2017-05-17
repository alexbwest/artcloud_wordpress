<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
//insert value if exists inside wp_option table if value is empty then the option value default will be set

$art_settings  	= array();
$apiKey  		= sanitize_text_field($_POST['apiKey']);
$type 			= sanitize_text_field($_POST['type-art']);
$typeTheme 		= sanitize_text_field($_POST['type-theme']);


$art_settings['api_key'] = $apiKey;
$art_settings['type']  	 = $type;
$art_settings['theme'] 	 = $typeTheme;

update_option( ART_SETTINGS, $art_settings);

//$_SESSION['ssp_message'] = __( 'Smart Scroll Posts Data Saved Successfully.', 'smart-scroll-posts' );
wp_redirect( admin_url() . 'admin.php?page=art_cloud_setting' );
exit;


