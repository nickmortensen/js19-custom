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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



add_action( 'cmb2_admin_init', 'register_quote_posttype_metabox' );

/**
 * Hook in and add a metabox to add fields to 'quote' post type.
 */
function register_quote_posttype_metabox() {

	$quote = new_cmb2_box(

		array(
			'id'                           => 'quote_edit',
			'title'                        => __( 'Quote Post Type Additional Fields', 'js19-custom' ),
			'object_types'                 => array( 'quote' ),
			'context'                      => 'normal',
			'show_names'                   => true,
			'show_in_rest'                 => WP_REST_Server::ALLMETHODS,
			'get_box_permissions_check_cb' => 'staff_limit_rest_view_to_logged_in_users',
		)
	);
	/* quote */
	$quote->add_field( array(
		'name'    => 'Content',
		'desc'    => 'Content of the Quote',
		'default' => '',
		'id'      => 'quoteContent',
		'type'    => 'textarea_small'
	) );
	/* quote_source */
	$quote->add_field(
		array(
			'name'    => 'source',
			'desc'    => '',
			'default' => '',
			'id'      => 'quoteSource',
			'type'    => 'text_medium',
		)
	);
	/* Have we done a project to link to for this client? */
	$quote->add_field(
		array(
			'name' => 'Link',
			'type' => 'text_medium',
			'id'   => 'quoteLinkURL',
		)
	);
	$quote->add_field(
		array(
			'name' => 'Title',
			'type' => 'text_medium',
			'id'   => 'quoteLinkTitle',
		)
	);
	$quote->add_field(
		array(
			'name' => 'Target',
			'type' => 'radio',
			'id'   => 'quoteLinkTarget',
			'show_option_none' => true,
			'options'          => array(
				'_self' => __( 'Self', 'cmb2' ),
				'_blank'   => __( 'Blank', 'js19-custom' ),
			),
				)
	);


} // end def function register_staff_post_type_metabox
