<?php
/**
 * Plugin Name: JS19 Custom
 * Plugin URI:  https://github.com/nickmortensen/js19-custom
 * desc: Custom Fields for the Client Custom Post Type
 * Version:     0.0.1
 * Author URI:  https://nickmortensen.com
 * Text Domain: js19-custom
 * Domain Path: /languages
 *
 * @author Nick Mortensen
 * @package js19-custom
 * @license GPL-2.0+
 * @since 5.0.1
 * @link https://github.com/CMB2/CMB2
 * @note This iteration of the plugin uses CMB2.
 */

 /**
 * Hook in and add a clients metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */

function register_client_metabox() {
	$client_metabox_arguments = array(
		'context' => 'normal',
		'classes' => 'client-post-metabox',
		'id' => 'client_metabox',
		'object_types' => array( 'client' ),
		'show_in_rest' => WP_REST_Server::ALLMETHODS,
		'show_names'                   => true,
		'title'                        => esc_html__( 'Client Overview', 'js19' ),
		// 'cmb_styles'                   => true, // Disable cmb2 stylesheet by setting to false.
	);
	$client_metabox = new_cmb2_box( $client_metabox_arguments );
	$after = '<hr>';
	$website = array(
		'protocols' => [ 'http', 'https' ],
		'name'         => 'Client Website',
		'id'           => 'clientWebsite',
		'type'         => 'text_url',
		'show_names'   => 'true',
		'inline' => true,
		'object_types' => array( 'client' ),
		'after_row' => $after,
	);
	$client_metabox->add_field( $website );
	$ticker = [ 'id' => 'clientTicker', 'name' => ucfirst('stock ticker'), 'type' => 'text_small', 'after_row' => $after, ];
	$client_metabox->add_field( $ticker );
	$type   = 'image/svg+xml';
	$url    = false;
	$button = 'Upload logo';
	$logo   = [ 'options' => [ 'url' => $url ],'id' => 'clientLogo', 'name' => ucfirst('logo'), 'type' => 'file', 'query_args' => [ 'type' => $type ], 'text' => [ 'add_upload_file_text' => $button], 'after_row' => $after, ];
	$client_metabox->add_field( $logo );
}
add_action( 'cmb2_init', 'register_client_metabox' );
