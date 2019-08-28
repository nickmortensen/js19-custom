<?php
/*
 * Plugin Name: CMB2 Custom Field Type - Partner
 * Description: Makes available an 'partner' CMB2 Custom Field Type. Based on https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types#example-4-multiple-inputs-one-field-lets-create-an-partner-field
 * Author: jtsternberg
 * Author URI: http://dsgnwrks.pro
 * Version: 0.1.0
 */

/**
 * Template tag for displaying an partner from the CMB2 partner field type (on the front-end)
 *
 * @since  0.1.0
 *
 * @param  string  $metakey The 'id' of the 'partner' field (the metakey for get_post_meta)
 * @param  integer $post_id (optional) post ID. If using in the loop, it is not necessary
 */
function jt_cmb2_partner_field( $metakey, $post_id = 0 ) {
	echo jt_cmb2_get_partner_field( $metakey, $post_id );
}

/**
 * Template tag for returning an partner from the CMB2 partner field type (on the front-end)
 *
 * @since  0.1.0
 *
 * @param  string  $metakey The 'id' of the 'partner' field (the metakey for get_post_meta)
 * @param  integer $post_id (optional) post ID. If using in the loop, it is not necessary
 */
function jt_cmb2_get_partner_field( $metakey, $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$partner = get_post_meta( $post_id, $metakey, 1 );

	// Set default values for each partner key
	$partner = wp_parse_args( $partner, array(
		'partner-1' => '',
		'partner-2' => '',
		'city'      => '',
		'state'     => '',
		'zip'       => '',
		'country'   => '',
	) );

	$output = '<div class="cmb2-partner">';
	$output .= '<p><strong>Partner:</strong> ' . esc_html( $partner['partner-1'] ) . '</p>';
	if ( $partner['partner-2'] ) {
		$output .= '<p>' . esc_html( $partner['partner-2'] ) . '</p>';
	}
	$output .= '<p><strong>City:</strong> ' . esc_html( $partner['city'] ) . '</p>';
	$output .= '<p><strong>State:</strong> ' . esc_html( $partner['state'] ) . '</p>';
	$output .= '<p><strong>Zip:</strong> ' . esc_html( $partner['zip'] ) . '</p>';
	$output .= '</div><!-- .cmb2-partner -->';

	return apply_filters( 'jt_cmb2_get_partner_field', $output );
}

function cmb2_init_partner_field() {
	require_once dirname( __FILE__ ) . '/class-cmb2-render-partner-field.php';
	CMB2_Render_Partner_Field::init();
}
add_action( 'cmb2_init', 'cmb2_init_partner_field' );