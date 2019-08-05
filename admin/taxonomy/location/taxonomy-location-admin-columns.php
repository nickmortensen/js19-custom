<?php
/**
 * 'Location' Taxonomy Admin customizations.
 *
 * Define and add content to additional admin columns to the 'location' taxonomy.
 *
 * @package JS19Custom
 * @subpackage Added Taxonomies.
 * @author Nick Mortensen
 * @license GPL-2.0+
 * @since 5.0.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
locationURL
locationWithinFooter
locationCapabilities
locationImage
locationPhone
locationAddress
locationCity
locationState
locationZip
locationLatitude
locationLongitude
locationGoogleCID
*/

/**
 * Add specific columns to the 'location' taxonomy admin page.
 *
 * @param [array] $columns Already existing columns.
 * @return [array] $columns The new columns.
 */
function js19_location_taxonomy_additional_admin_columns( $columns ) {
	unset( $columns['description'] );
	$checkbox                   = array_slice( $columns, 0, 1 );
	$columns                    = array_slice( $columns, 1 );
	$id['locationID']           = 'ID';
	$id['locationPhone']        = 'Phone';
	$id['locationImage']        = 'Image';
	$id['locationURL']          = 'URL';
	$columns                    = array_merge( $checkbox, $id, $columns );
	$columns['locationWithinFooter'] = 'Footer?';
	return $columns;
}
add_action( 'manage_edit-location_columns', 'js19_location_taxonomy_additional_admin_columns' );

/**
 * Add content to the new columns within the location taxonomy on the admin end.
 *
 * @param string $content Already existing content for the already existing rows.
 * @param 'string' $column_name As instantiated in the 'js19_location_taxonomy_additional_admin_columns' function.
 * @param number $term_id Term in quation.
 * @return string $content The content for the columns.
 */
function populate_location_custom_columns( $content, $column_name, $term_id ) {
	$taxonomy = 'location';
	$term     = get_term( $term_id, $taxonomy );
	switch ( $column_name ) {
		case 'locationID':
			$content = $term_id;
			break;
		case 'locationPhone':
			$content = get_term_meta( $term_id, 'locationPhone', true );
			break;
		case 'locationWithinFooter':
			$content = get_term_meta( $term_id, 'locationWithinFooter', true ) ? '<span style="font-size: 1.25rem;" class="dashicons dashicons-yes-alt"></span>' : '<span style="font-size: 1.25rem;" class="dashicons dashicons-dismiss"></span>';
			break;
		case 'locationURL':
			$content = get_term_meta( $term_id, 'locationURL', true ) ? get_term_meta( $term_id, 'locationURL', true ) : 'No URL';
			break;
		default:
			break;
	}

	return $content;
}


add_filter( 'manage_location_custom_column', 'populate_location_custom_columns', 10, 3 );
