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
function js19_custom_location_taxonomy_initialize() {

	$labels = array(
		'name'                       => _x( 'Locations', 'Taxonomy General Name', 'js19-custom' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'js19-custom' ),
		'menu_name'                  => __( 'Locations', 'js19-custom' ),
		'all_items'                  => __( 'All Locations', 'js19-custom' ),
		'parent_item'                => __( 'Main', 'js19-custom' ),
		'parent_item_colon'          => __( 'Main Location', 'js19-custom' ),
		'new_item_name'              => __( 'New Location', 'js19-custom' ),
		'add_new_item'               => __( 'Add New Location', 'js19-custom' ),
		'edit_item'                  => __( 'Edit Location', 'js19-custom' ),
		'update_item'                => __( 'Update Location', 'js19-custom' ),
		'view_item'                  => __( 'View Location', 'js19-custom' ),
		'separate_items_with_commas' => __( 'Separate locations with commas', 'js19-custom' ),
		'add_or_remove_items'        => __( 'Add or remove Locations', 'js19-custom' ),
		'choose_from_most_used'      => __( 'Frequently Used Locations', 'js19-custom' ),
		'popular_items'              => __( 'Popular Locations', 'js19-custom' ),
		'search_items'               => __( 'Search Locations', 'js19-custom' ),
		'not_found'                  => __( 'Not Found', 'js19-custom' ),
		'no_terms'                   => __( 'No Locations', 'js19-custom' ),
		'items_list'                 => __( 'Locations list', 'js19-custom' ),
		'items_list_navigation'      => __( 'Locations list navigation', 'js19-custom' ),
	);
	$rewrite = array(
		'slug'                       => 'location',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'location',
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
		'rest_base'                  => 'location',
	);
	register_taxonomy( 'location', array( 'position', ' post', ' staff', ' attachments' ), $args );

	}
	// Commented out, but will add on the JS19-custom.php page.
	// add_action( 'init', 'js19_custom_location_taxonomy_initialize', 0 );
