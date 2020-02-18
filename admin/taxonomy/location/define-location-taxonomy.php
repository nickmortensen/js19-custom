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
		'name'                       => _x( 'Locations', 'Taxonomy General Name', 'js2020' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'js2020' ),
		'menu_name'                  => __( 'Jones Locations', 'js2020' ),
		'all_items'                  => __( 'All Locations', 'js2020' ),
		'parent_item'                => __( 'Main', 'js2020' ),
		'parent_item_colon'          => __( 'Main Location', 'js2020' ),
		'new_item_name'              => __( 'New Location', 'js2020' ),
		'add_new_item'               => __( 'Add New Location', 'js2020' ),
		'edit_item'                  => __( 'Edit Location', 'js2020' ),
		'update_item'                => __( 'Update Location', 'js2020' ),
		'view_item'                  => __( 'View Location', 'js2020' ),
		'separate_items_with_commas' => __( 'Separate locations with commas', 'js2020' ),
		'add_or_remove_items'        => __( 'Add or remove Locations', 'js2020' ),
		'choose_from_most_used'      => __( 'Frequently Used Locations', 'js2020' ),
		'popular_items'              => __( 'Popular Locations', 'js2020' ),
		'search_items'               => __( 'Search Locations', 'js2020' ),
		'not_found'                  => __( 'Not Found', 'js2020' ),
		'no_terms'                   => __( 'No Locations', 'js2020' ),
		'items_list'                 => __( 'Locations list', 'js2020' ),
		'items_list_navigation'      => __( 'Locations list navigation', 'js2020' ),
	);
	$rewrite = array(
		'slug'                       => 'location',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'             => $labels,
		'description'        => 'Covers Various Jones Sign Company Locations around North America',
		'hierarchical'       => false,
		'public'             => true,
		'show_ui'            => true,
		'show_in_quick_edit' => true,
		'show_in_menu'       => true,
		'show_admin_column'  => true,
		'show_in_nav_menus'  => true,
		'show_tagcloud'      => true,
		'query_var'          => 'location',
		'rewrite'            => $rewrite,
		'show_in_rest'       => true,
		'rest_base'          => 'location',
	);
	register_taxonomy( 'location', array( 'position', ' post', ' staff', ' attachments' ), $args );

	}
	// Commented out, but will add on the JS19-custom.php page.
	// add_action( 'init', 'js19_custom_location_taxonomy_initialize', 0 );
