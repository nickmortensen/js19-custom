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

include 'billboard-posttype-cmb2-custom-fields-functions.php'; // These are all the callback functions.

if ( ! function_exists ( 'register_billboards_post_type_metabox' ) ) {

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


		// SWITCH CUSTOM METAFIELD Arguments.
		/* Use the switch custom metafield to determine whether the billboard is a static billboard or a digital billboard */
		$billboardIsDigitalArgs = array(
			'name'    => __( 'Billboard Type', 'js19' ),
			'desc'    => __( 'slide the toggle is it is a digital, default is static', 'js19' ),
			'id'      => 'billboardIsDigital',
			'type'    => 'betterswitch',
			'default' => 0,
			'label'   => array(
				'on'   => __( 'Digital', 'js19' ),
				'off'  => __( 'Static', 'js19' ),
			),
		);
		// END SWITCH CUSTOM METAFIELD ARGS


		// Face Direction Field Arguments.
		$billboardFaceDirectionArgs = array(
			'type'             => 'select',
			'protocols'        => [ 'http', 'https' ],
			'desc'             => 'What direction does this face go in?',
			'name'             => 'Face Direction',
			'id'               => 'billboardFaceDirection',
			'show_names'       => 'true',
			'show_option_none' => true,
			'inline'           => true,
			'after_row'        => '<hr />',
			'object_types'     => array( 'billboard' ),
			'options'          => array(
				'north' => __( 'North', 'js19-custom' ),
				'east'  => __( 'East', 'js19-custom' ),
				'south' => __( 'South', 'js19-custom' ),
				'west'  => __( 'West', 'js19-custom' ),
			),
		);
		// END Face Direction Field Arguments.

		// Billboard Dimensions arguments.
		$billboardDimensionsArgs = array(
			'type'       => 'text',
			'desc'       => 'face dimensions',
			'name'       => 'Dimensions',
			'id'         => 'billboardDimensions',
			'show_names' => 'true',
		);
		// END Billboard Dimensions arguments.

		$billboardIdArgs = array(
			'type'       => 'text_small',
			'desc'       => 'billboard Identifier',
			'name'       => 'ID',
			'id'         => 'billboardId',
			'show_names' => 'true',
		);
		// coordinates field arguments
		$billboardLatitudeArgs = array(
			'type'       => 'text_small',
			'desc'       => 'billboard latitude',
			'name'       => 'Latitude',
			'id'         => 'billboardLatitude',
			'show_names' => 'true',
			'before_row' => '<div id="coordinates">'
		);
		$billboardLongitudeArgs = array(
			'type'       => 'text_small',
			'desc'       => 'billboard longitude',
			'name'       => 'Longitude',
			'id'         => 'billboardLongitude',
			'show_names' => 'true',
			'after_row'  => '</div><!-- end div#coordinates-->'
		);
		// end // coordinates field arguments.

		// conditional field for illumination type. options are dust to dawn and not illuminated
		$billboardIlluminationArgs = array(
			'type' => 'text_small',
			'desc' => 'billboard Illumination',
			'name' => 'illumination',
			'id'   => 'billboardIllumination',
			'show_names' => 'true',
			// only show this field if the billboardIsDigital field shows false.
			'attributes' => array(
				'data-conditional-id'    => 'billboardIsDigital',
				'data-conditional-value' => 'off',
			),

		);

		$billboardMarketArgs = array(
			'type'       => 'text',
			'desc'       => 'market the billboard is in',
			'name'       => 'Billboard Market',
			'id'         => 'billboardMarket',
			'show_names' => true,
			'attributes' => array(
				'data-conditional-id'    => 'billboardIsDigital',
				'data-conditional-value' => 'off',
			),
		);

		$billboardMediaTypeArgs = array(
			'id'         => 'billboardMediaType',
			'name'       => 'Media Type',
			'type'       => 'select',
			'desc'       => 'Type of Media - options will depend on whether it is a static or digital unit.',
			'show_names' => true,
			'options_cb' => 'billboard_mediatype_options',
			'attributes' => array(
				'data-conditional-id'    => 'billboardIsDigital',
				'data-conditional-value' => 'off',
			),
		);



		$fields = array(
			$billboardIsDigitalArgs,
			$billboardFaceDirectionArgs,
			$billboardDimensionsArgs,
			$billboardIdArgs,
			$billboardLatitudeArgs,
			$billboardLongitudeArgs,
			$billboardIlluminationArgs,
			$billboardMarketArgs,
			$billboardMediaTypeArgs,
		);


		// NOW ADD THE FIELDS Using the field arguments.
		$metabox->add_field( $billboardIsDigitalArgs );
		$metabox->add_field( $billboardFaceDirectionArgs );
		$metabox->add_field( $billboardDimensionsArgs );
		$metabox->add_field( $billboardIdArgs );
		$metabox->add_field( $billboardLatitudeArgs );
		$metabox->add_field( $billboardLongitudeArgs );
		$metabox->add_field( $billboardIlluminationArgs ); // Dawn to dusk or not at all.
		$metabox->add_field( $billboardMarketArgs ); // Markets are a select field.
		$metabox->add_field( $billboardMediaTypeArgs ); // Markets are a select field.

		// END ADD THE FIELDS.
	}

	add_action( 'cmb2_init', 'register_billboards_post_type_metabox' );
} // function_exists conditional.


/*


$metaFieldArgs = array(
	'id'         => '',
	'name'       => '',
	'type'       => '',
	'desc'       => '',
	'show_names' => true,
	'attributes' => array(),
);



elem = ''; // what I am targeting in this case an input element with the name attribute of 'DigitalOrStatic



/** Target containing element */
/*


targetId = 'field_digitalorstatic_containing_div';
container = document.getElementById(targetId);

document.getElementBuId('field_digitalorstatic_containing_div').style.border = '3px solid goldenrod';

 version 1.4.1
document.getElementById('coordinates').style.background = 'red';

*/