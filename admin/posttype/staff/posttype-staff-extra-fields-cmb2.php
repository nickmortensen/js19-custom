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


add_action( 'cmb2_admin_init', 'register_staff_posttype_metabox' );

/**
 * Hook in and add a metabox to add fields to 'staff' post type.
 */
function register_staff_posttype_metabox() {

	$staffmember = new_cmb2_box(

		array(
			'id'                           => 'staffmember_edit',
			'title'                        => __( 'Staff Post Type Additional Fields', 'js19-custom' ),
			'object_types'                 => array( 'staff' ),
			'context'                      => 'normal',
			'show_names'                   => true,
			'show_in_rest'                 => WP_REST_Server::ALLMETHODS,
			'get_box_permissions_check_cb' => 'staff_limit_rest_view_to_logged_in_users',
		)
	);
	/* Is staff currently working for Jones Sign Company? */
	$staffmember->add_field(
		array(
			'name' => 'Current',
			'type' => 'checkbox',
			'id'   => 'staffIsCurrent',
		)
	);
	/* Is staff management? */
	$staffmember->add_field(
		array(
			'name' => 'Management',
			'type' => 'checkbox',
			'id'   => 'staffIsManagement',
		)
	);
	/* Staff email address */
	$staffmember->add_field(
		array(
			'name' => 'Email',
			'id'   => 'staffEmail',
			'type' => 'text_email',
		)
	);
	/* staff phone (mobile) */
	$staffmember->add_field(
		array(
			'name'    => 'Mobile',
			'desc'    => '',
			'default' => '',
			'id'      => 'staffPhoneMobile',
			'type'    => 'text_medium',
		)
	);
	/* staff phone (desk) */
	$staffmember->add_field(
		array(
			'name'    => 'Desk',
			'desc'    => '',
			'default' => '',
			'id'      => 'staffPhoneDesk',
			'type'    => 'text_medium',
			'attributes' => array(
				'type' => 'tel',
			)
		)
	);
	/* staff phone (extension) */
	$staffmember->add_field(
		array(
			'name'    => 'ext',
			'desc'    => '',
			'default' => '',
			'id'      => 'staffPhoneExt',
			'type'    => 'text_small',
		)
	);
	/* Date of Hire */
	$staffmember->add_field(
		array(
			'name'        => 'Date of Hire',
			'id'          => 'staffDateOfHire',
			'type'        => 'text_date',
			'date_format' => 'yymmdd',
		)
	);
	/* Date of Hire */
	$staffmember->add_field(
		array(
			'name'        => 'Birthday',
			'id'          => 'staffBirthday',
			'type'        => 'text_date',
			'classes'       => 'no-year',
			'date_format' => 'mmdd',
		)
	);
	/* Staff Biography*/
	$staffmember->add_field(
		array(
			'name'    => 'Staff Bio',
			'desc'    => 'field description (optional)',
			'id'      => 'staffBio',
			'type'    => 'wysiwyg',
			'options' => array(),
		)
	);
	/* Staff Highlights Repeater */
	$staffmember->add_field(
		array(
			'name'    => 'Highlights',
			'desc'    => '',
			'default' => '',
			'id'      => 'staffHighlighs',
			'type'    => 'text_medium',
			'repeatable' => true,
			'text' => array(
				'add_row_text' => 'Add Another Highlight'
			),
		)
	);
} // end def function register_staff_post_type_metabox
