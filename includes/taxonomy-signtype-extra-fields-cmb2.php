<?php
/**
 * Plugin Name: jsCustom
 * Plugin URI:  https://linkedin.com/learning
 * Description: Refactored Custom-to-Jones-Sign-Company Posttypes, Taxonomies, and Fields Done with CMB2 to eventually Expose to the REST API.
 * Version:     0.0.1
 * Author URI:  https://nickmortensen.com
 * Text Domain: jsCustom
 * Domain Path: /languages
 *
 * @author Nick Mortensen
 * @package jsCustom
 * @license GPL-2.0+
 * @since 5.0.1
 * @link https://github.com/CMB2/CMB2
 * @note This iteration of the plugin uses CMB2.
 */

add_action( 'cmb2_init', 'register_signtype_taxonomy_metabox' );

/**
 * Hook in and add a metabox to add fields to 'signtype' taxonomy terms
 */
function register_signtype_taxonomy_metabox() {
	// Establish prefeix.
	$prefix = 'signtype_';
	// Create an instance of the cmbs2box called $signtype.
	$signtype = new_cmb2_box(
		array(
			'id'                           => $prefix . 'edit',
			'title'                        => esc_html__( 'Signtype Extra Info', 'jsCustom' ),
			'object_types'                 => array( 'term' ), // indicate to cmb we are using terms and not posts.
			'taxonomies'                   => array( 'signtype' ), // Fields can be added to more than one taxonomy term, but we will limit these just to the signtype taxonomy term.
			'cmb_styles'                   => true, // Disable cmb2 stylesheet.
			'show_in_rest'                 => WP_REST_Server::ALLMETHODS, // WP_REST_Server::READABLE|WP_REST_Server::EDITABLE, // Determines which HTTP methods the box is visible in.
			// Optional callback to limit box visibility.
			// See: https://github.com/CMB2/CMB2/wiki/REST-API#permissions.
			'get_box_permissions_check_cb' => 'projects_limit_rest_view_to_logged_in_users',
		)
	);
	$instance_field = [
		'name'       => 'Instance',
		'desc'       => 'Scenario Wherein this type of sign is best.',
		'default'    => '',
		'id'         => 'signtypeUseCase',
		'type'       => 'textarea_small',
		'repeatable' => true,
		'attributes' => array(
			'rows' => 2,
		),
		'text'       => array(
			'add_row_text' => 'Add Use Case Instance',
		),
	];
	$signtype->add_field( $instance_field );
	// Best images should be a file_list field in CMB2. That way there are several images to choose among.
	$best_images_text_array = [
		'add_upload_files_text' => 'Add Image',
		'remove_image_text'     => 'Remove',
		'file_text'             => 'File: ',
		'file_download_text'    => 'Download Photo',
		'remove_text'           => 'Remove',
	];
	$best_images_field      = [
		'name'         => 'Best Images',
		'desc'         => 'Several Images that are representative of this sign type ',
		'id'           => 'signtypeMainImages',
		'type'         => 'file_list',
		'preview_size' => array( 400, 300 ),
		'query_args'   => array( 'type' => 'image' ), // Only images attachment.
		'text'         => $best_images_text_array,
	];
	$signtype->add_field( $best_images_field );

} // End def function register_projects_metabox().
