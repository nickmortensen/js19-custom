<?php
/**
 * 'Staff' Post Type Admin customizations.
 *
 * Define and add content to additional admin columns for the 'staff' custom post type..
 *
 * @package JS19Custom
 * @subpackage Added Post Types.
 * @author Nick Mortensen
 * @license GPL-2.0+
 * @since 5.0.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Add specific columns to the 'staffer' posttype admin page.
 *
 * @param [array] $columns Already existing columns.
 * @return [array] $columns The new columns.
 */
function staffer_filter_post_columns( $columns ) {
	unset( $columns['date'] );
	unset( $columns['author'] );
	$checkbox              = array_slice( $columns, 0, 1 );
	$id['post_id']  = 'Identifier';
	$columns               = array_slice( $columns, 1 );
	$columns               = array_merge( $checkbox, $id, $columns );
	return $columns;
}
add_filter( 'manage_staff_posts_columns', 'staffer_filter_post_columns' );

/**
 * Add content to the new columns within the staff post type on the admin end.
 *
 * @param string $content Already existing content for the already existing rows.
 * @param 'string' $column_name As instantiated in the 'js19_location_taxonomy_additional_admin_columns' function.
 * @param number $term_id Term in quation.
 * @return string $content The content for the columns.
 */
function populate_staffer_custom_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'post_id':
			$content = $post->ID;
			echo "<strong>$content</strong>";
			break;
		default:
			break;
	}
}
add_action( 'manage_staff_posts_custom_column', 'populate_staffer_custom_columns', 20, 2 );
// add_action( 'manage_movie_posts_custom_column', 'my_manage_movie_columns', 10, 2 );
