<?php
/**
 * Register a custom Taxonomy for 'location'.
 *
 * @see get_post_type_labels() for label keys.
 * @package jsCustom
 */


/**
 * Setup & Register the 'location' taxonomy.
 */
function js19_custom_location_taxonomy() {
	$labels = array(
		'add_new_item'               => __( 'Add Location', 'jsCustom' ),
		'add_or_remove_items'        => __( 'Add or Remove Location', 'jsCustom' ),
		'all_items'                  => __( 'All  Locations', 'jsCustom' ),
		'back_to_items'              => __( 'Back to  Locations', 'jsCustom' ),
		'choose_from_most_used'      => __( 'Often Used Location Tags', 'jsCustom' ),
		'edit_item'                  => __( 'Edit Location', 'jsCustom' ),
		'items_list'                 => __( 'Location List', 'jsCustom' ),
		'items_list_navigation'      => __( 'Locations List Nav', 'jsCustom' ),
		'menu_name'                  => __( 'Location Tags', 'jsCustom' ),
		'name'                       => _x( 'Location', 'Taxonomy General Name', 'jsCustom' ),
		'new_item_name'              => __( 'New Location', 'jsCustom' ),
		'no_terms'                   => __( 'No Location', 'jsCustom' ),
		'not_found'                  => __( 'Location Not Found', 'jsCustom' ),
		'popular_items'              => __( 'Popular  Locations', 'jsCustom' ),
		'search_items'               => __( 'Search  Locations', 'jsCustom' ),
		'separate_items_with_commas' => __( 'Separate Location Locations w/commas', 'jsCustom' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'jsCustom' ),
		'update_item'                => __( 'Update Location', 'jsCustom' ),
		'view_item'                  => __( 'View Location', 'jsCustom' ),
	);
	$args   = array(
		'has_archive'           => true,
		'hierarchical'          => false,
		'description'           => 'Apply a Location.',
		'labels'                => $labels,
		'public'                => true, // Sets the defaults for 'publicly_queryable', 'show_ui', & 'show_in_nav_menus' as well.
		'query_var'             => true,
		'show_in_menu'          => true,
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => 'location' ),
		'show_admin_column'     => true,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_tagcloud'         => true,
		'capabilities'          => array( 'manage_terms', 'edit_terms', 'delete_terms', 'assign_posts' ),
		'update_count_callback' => '_update_post_term_count',
	);
	$objects_array = [ 'project', 'attachment' ]; // Array of the objects within WordPress to assign this taxonomy to. Can be a single.
	register_taxonomy( 'location', $objects_array, $args );

}

// $tag_to_hook_into  = 'init'; // WordPress action that we wish to hook into.
// $new_function_name = 'js19_custom_location_taxonomy';
// $new_function_args = 0; // Quantity of arguments in the jonessign_custom_location_taxonomy() function.

// Add the jonessign_custom_location_taxonomy() function at init.
// add_action( $tag_to_hook_into, $new_function_name, $new_function_args );

