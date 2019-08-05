<?php
/**
 * Register a custom Taxonomy for 'signtype'.
 *
 * @see get_post_type_labels() for label keys.
 * @package jsCustom
 */

$tag_to_hook_into  = 'init'; // WordPress action that we wish to hook into.
$new_function_name = 'jonessign_custom_signtype_taxonomy';
$new_function_args = 0; // Quantity of arguments in the jonessign_custom_signtype_taxonomy() function.

// Add the jonessign_custom_signtype_taxonomy() function at init.
add_action( $tag_to_hook_into, $new_function_name, $new_function_args );
/**
 * Setup & Register the 'signtype' taxonomy.
 */
function jonessign_custom_signtype_taxonomy() {
	$labels = array(
		'add_new_item'               => __( 'Add Sign Type', 'jsCustom' ),
		'add_or_remove_items'        => __( 'Add or Remove Sign Type', 'jsCustom' ),
		'all_items'                  => __( 'All Sign Types', 'jsCustom' ),
		'back_to_items'              => __( 'Back to Sign Types', 'jsCustom' ),
		'choose_from_most_used'      => __( 'Often Used Sign Tags', 'jsCustom' ),
		'edit_item'                  => __( 'Edit Sign Type', 'jsCustom' ),
		'items_list'                 => __( 'Sign Type List', 'jsCustom' ),
		'items_list_navigation'      => __( 'Sign Types List Nav', 'jsCustom' ),
		'menu_name'                  => __( 'Sign Type Tags', 'jsCustom' ),
		'name'                       => _x( 'Sign Type', 'Taxonomy General Name', 'jsCustom' ),
		'new_item_name'              => __( 'New Sign Type Tag', 'jsCustom' ),
		'no_terms'                   => __( 'No Sign Type Tags', 'jsCustom' ),
		'not_found'                  => __( 'Sign Type Not Found', 'jsCustom' ),
		'popular_items'              => __( 'Popular Sign Types', 'jsCustom' ),
		'search_items'               => __( 'Search Sign Types', 'jsCustom' ),
		'separate_items_with_commas' => __( 'Separate Sign Types w/commas', 'jsCustom' ),
		'singular_name'              => _x( 'Sign Type', 'Taxonomy Singular Name', 'jsCustom' ),
		'update_item'                => __( 'Update Sign Type', 'jsCustom' ),
		'view_item'                  => __( 'View Sign Type ', 'jsCustom' ),
	);
	$args   = array(
		'hierarchical'          => false,
		'description'           => 'Apply a Sign Type Tag to Photos or Project pages.',
		'labels'                => $labels,
		'public'                => true, // Sets the defaults for 'publicly_queryable', 'show_ui', & 'show_in_nav_menus' as well.
		'query_var'             => 'signtype',
		'show_in_menu'          => true,
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => 'sign' ),
		'show_admin_column'     => true,
		// 'meta_box_cb'        => '' -- this might be something to use with CMB2
		'show_tagcloud'         => true,
		'capabilities'          => array( 'manage_terms', 'edit_terms', 'delete_terms', 'assign_posts' ),
		'update_count_callback' => '_update_post_term_count',
	);
	$objects_array = [ 'project', 'attachment' ]; // Array of the objects within WordPress to assign this taxonomy to. Can be a single.
	register_taxonomy( 'signtype', $objects_array, $args );
} // End of jonessign_custom_signtype_taxonomy() definition.
