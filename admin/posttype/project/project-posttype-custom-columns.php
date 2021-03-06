<?php
/**
 * Plugin Name: JS19 Customizations
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
	unset( $columns['title'] );
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
		'thumbnail' => 'Image',
		// 'project_title'              => __( 'Project Name' ),
		// 'at_a_glance' => __( 'at a glance' ),
		// 'raw_data' => __( 'raw' ),
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
	$project = get_post( $post_id );
	$name = $project->post_title;
	// $edit_fields = '<span class="edit"><a href="https://jonessign.co/wp-admin/post.php?post=' . $post_id . '&action=edit">EditAGAIN</a></span>'
	$default       = '';
	// $no_img        = '<span class = "dashicons dashicons-format-image negative" style = "color: red;"></span>';
	$featured_img  = get_the_post_thumbnail( $post_id, array( 400, 300 ) );
	$thumbnail_id  = get_post_thumbnail_id( $post_id ) ? get_post_thumbnail_id( $post_id ) : 923;
	$thumbnail_src = wp_get_attachment_image_src( $thumbnail_id, 'wpRigRelated', $icon = false );
	$project_name  = get_the_title( $post_id );
	$job_number    = get_post_meta( $post_id, 'projectJobNumber', true );
	$job_name      = get_the_title( $post_id );
	// I'd like to get the post thumbnail by url and then include it as a picture element with metadata underneath.

	switch( $column ) {
		case 'thumbnail':
		$output = '<div><img src="' . $thumbnail_src[0] . '" width="100%" style="z-index:-10;" /><span style="display:block;font-size:1.1rem;color:white;padding:0.15rem 0.8rem;background:black;z-index:150;position:relative; top: -1.15rem;">' . $name . '</span></div>';
		echo $output;
		echo '<div style=""></div>';
			break;
		case 'project_post_id':
			echo "<strong>{$post_id}</strong>";
			break;
		case 'signtypes':
			$taxonomy  = 'signtype';
			$sign_types = get_the_term_list( $post_id, $taxonomy, '', '<br> ', '' );
			echo $sign_types ?? $default;
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
