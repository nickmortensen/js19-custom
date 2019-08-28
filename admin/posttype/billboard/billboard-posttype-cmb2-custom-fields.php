<?php
/**
 * Plugin Name: JS19 Custom
 * Plugin URI:  https://github.com/nickmortensen/js19-custom
 * desc: Custom Fields for the Billboard Custom Post Type
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

if ( ! function_exists ( 'register_billboards_post_type_metabox' ) ) {
/**
 * billboardFaceDirection
 *
 * @return void
 */
	/**
	 * Hook in and add a billboards metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
	 */

	function register_billboards_post_type_metabox() {

		$arguments = array(
			'context'      => 'normal',
			'classes'      => 'billboard-post-metabox',
			'id'           => 'billboard_metabox',
			'object_types' => array( 'billboard' ),
			'show_in_rest' => WP_REST_Server::ALLMETHODS,
			'show_names'   => true,
			'title'        => esc_html__( 'Billboard Overview', 'js19' ),
		);
		$metabox = new_cmb2_box( $arguments );
		$after = '<hr>';

// COORDINATES CUSTOM METAFIELD
$billboard_coordinates_args = array(
	'type' => 'coordinates',
	'name' => __( 'Coordinates', 'js19' ),
	'desc' => __( 'latitude and longitude of the billboard', 'js19' ),
	'id'   => 'coordinates',
	'default' => '',
	'label' => array( 0 => 'lat', 1 => 'long'),
);

$metabox->add_field( $billboard_coordinates_args );
// END COORDINATES CUSTOM METAFIELD




		// SWITCH CUSTOM METAFIELD
		/* Use the switch custom metafield to determine whether the billboard is a static billboard or a digital billboard */
		$billboard_type_switch_args = array(
			'name'    => __( 'Billboard Type', 'js19' ),
			'desc'    => __( 'Is it a digital or static Billboard?', 'js19' ),
			'id'      => 'DigitalOrStatic',
			'type'    => 'switch',
			'default' => 0,
			'label'   => array(
				'on'   => __( 'Digital', 'js19' ),
				'off'  => __( 'Static', 'js19' ),
			),
		);
		$metabox->add_field( $billboard_type_switch_args );
		// END SWITCH CUSTOM METAFIELD



		$faceDirectionFieldArgs = array(
			'type'             => 'select',
			'protocols'        => [ 'http', 'https' ],
			'desc'             => 'What direction does this face go in?',
			'name'             => 'Face Direction',
			'id'               => 'billboardFaceDirection',
			'show_names'       => 'true',
			'show_option_none' => true,
			'inline'           => true,
			'after_row'        => $after,
			'object_types'     => array( 'billboard' ),
			'options'          => array(
				'north' => __( 'North', 'js19-custom' ),
				'east'  => __( 'East', 'js19-custom' ),
				'south' => __( 'South', 'js19-custom' ),
				'west'  => __( 'West', 'js19-custom' ),
			),
		);
		// Lets not add this field. Perhaps a custom field type for billboard would be a better place.
		// $metabox->add_field( $faceDirectionArgs );

		// ======= BILLBOARD CUSTOM METAFIELD ========
		// These are the arguments that will be made to the add_field function.
		// Field type 'billboard' as defined in './includes/custom-cmb2-fields/billboard-field/billboard-metafield.php.
		$billboardCustomFieldArgs = array(
			'name' => 'Billboard Information',
			'desc' => 'Additional Information',
			'id'   => 'informationForBillboard',
			'type' => 'billboards',
		);
		$metabox->add_field( $billboardCustomFieldArgs );
		// END Billboard Face Direction Field.


		$description = [ 'id' => 'billboardDescription', 'name' => ucfirst('description'), 'type' => 'textarea_small', 'after_row' => $after, ];
		// $metabox->add_field( $description );
		$type   = 'image/svg+xml';
		$url    = false;
		$button = 'Upload logo';
		$logo   = [ 'options' => [ 'url' => $url ],'id' => 'billboardLogo', 'name' => ucfirst('logo'), 'type' => 'file', 'query_args' => [ 'type' => $type ], 'text' => [ 'add_upload_file_text' => $button], 'after_row' => $after, ];
		// $metabox->add_field( $logo );
	}

	add_action( 'cmb2_init', 'register_billboards_post_type_metabox' );
} // function_exists conditional.


/*


elem = ''; // what I am targeting in this case an input element with the name attribute of 'DigitalOrStatic



/** Target containing element */
/*


targetId = 'field_digitalorstatic_containing_div';
container = document.getElementById(targetId);

document.getElementBuId('field_digitalorstatic_containing_div').style.border = '3px solid goldenrod';

*/