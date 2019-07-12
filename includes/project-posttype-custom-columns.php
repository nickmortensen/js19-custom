<?php
/**
 * Plugin Name: Projects
 * Plugin URI:  https://linkedin.com/learning
 * Description: Custom Projects Admin columns and layout.
 * Version:     0.0.1
 * Author URI:  https://nickmortensen.com
 * Text Domain: js_custom
 * Domain Path: /languages
 *
 * @author Nick Mortensen
 * @package js_custom
 * @license GPL-2.0+
 * @since 5.0.1

 * Projects is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * Projects is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Projects. If not, see https://www.gnu.org/licenses/gpl.html.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Unset existing columns for the project type.
 *
 * @param array $columns  The off-the-rack post columns from WordPress.
 * @return array $columns The ones that I want to stick around.
 */
function js_custom_set_custom_edit_project_columns( $columns ) {
	unset( $columns['author'] );
	unset( $columns['categories'] );
	unset( $columns['tags'] );
	unset( $columns['comments'] );
	unset( $columns['date'] );
	return $columns;
}
add_filter( 'manage_project_posts_columns', 'js_custom_set_custom_edit_project_columns' );
/**
 * Create new columns on the project post type admin edit page
 *
 *
 */

/**
 * Create new columns on the project post type admin edit page
 *
 * @param array $columns Already existing columns on a project post type admin page.
 * @return array $columns New columns, just not the content for them quite yet.
 */
function js_custom_set_project_columns( $columns ) {
	$columns  = array(
		'cb'                 => '<input type="checkbox" />',
		'title'              => __( 'Project Name' ),
		'at_a_glance' => __( 'Project' ),
		'signtypes'         => __( 'Featured Signage' ),
		// 'has_featured_image' => __( 'img' ),
		// 'service-type'       => __( 'Services' ),
		// 'expertise'          => __( 'Expertise' ),
		// 'sign-types'         => __( 'Featured Signage' ),
	);
	$checkbox                         = array_slice( $columns, 0, 4 );
	$added_columns['project_post_id'] = 'ID';
	$columns                          = array_merge( $checkbox, $added_columns );
	return $columns;
}
add_filter( 'manage_project_posts_columns', 'js_custom_set_project_columns' );

function js_custom_project_column( $column, $post_id ) {
	$default = '';
	$no_img = '<span class="dashicons dashicons-format-image negative" style="color:red;"></span>';
	$featured_img = get_the_post_thumbnail( $post_id, array( 400, 250 ) );
	$thumbnail_id = get_post_thumbnail_id( $post_id );
	$thumbnail_src = '';
	$project_name = get_the_title( $post_id );
	// I'd like to get the post thumbnail by url and then include it as a picture element with metadata underneath.
/*
$project_information = <<<PROJECT
<figure>
    <img src="$thumbnail_src"
		 alt="$thumbnail_caption"
		 data-post-identifier="$post_id"
		 >
    <figcaption>$post_id $project_name</figcaption>
</figure>

PROJECT;
*/

	$main_img = $featured_img ?? $no_img;
	switch( $column ) {
		case 'project_post_id':
			echo "<strong>{$post_id}</strong>";
			break;

		case 'at_a_glance':
			echo "Thumbnail {$thumbnail_id}:<br> Project Name: {$project_name} ";
			break;
//signtypes
		default:
			break;
	}
}
// function js_custom_custom_project_column( $column, $post_id ) {
// 	$default  = '';
// 	switch ( $column ) {
// 		case 'project_post_id':
// 			echo $post_id;
// 			break;
// 		case 'has_featured_image':
// 			$default = '<span class="dashicons dashicons-format-image negative" style="color:red;"></span>';
// 			echo get_the_post_thumbnail( $post_id, array( 200, 125 ) ) ?? $default;
// 			break;
// 		case 'sign-types':
// 			$taxonomy  = 'sign';
// 			$sign_types = get_the_term_list( $post_id, $taxonomy, '', '<br> ', '' );
// 			echo $sign_types ?? $default;
// 			break;
// 		case 'expertise':
// 			$taxonomy = 'expertise';
// 			echo get_the_term_list( $post_id, $taxonomy, '', '<br> ', '' ) ?? $default;
// 		break;
// 		case 'service-type':
// 			$taxonomy      = 'service';
// 			echo get_the_term_list( $post_id, $taxonomy, '', '<br>', '' ) ?? $default;
// 			break;
// 		default:
// 			break;
// 	} // END switch.
// }
// end def js_custom_custom_project_column( )
add_action( 'manage_project_posts_custom_column', 'js_custom_project_column', 20, 2 );
/**
 * Determine which columns to add sortability.
 *
 * @param array $columns Existing columns.
 * @return array $columns All the columns I want to be able to sort by.
 */
function js_custom_project_admin_sortable_columns( $columns ) {
	$columns['project_post_id']    = 'ID';
	return $columns;
};
add_filter( 'manage_edit-project_sortable_columns', 'js_custom_project_admin_sortable_columns' );
