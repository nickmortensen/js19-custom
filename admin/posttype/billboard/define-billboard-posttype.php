<?php
/**
 * Register billboard post type.
 *
 * @package   js19 custom
 * @author    Nick Mortensen
 * @license   GPL-2.0+
 * @link      http://github.com/nickmortensen/js19-custom/
 * @copyright 2019 Nick Mortensen
 */
// Register Custom Post Type
function js19_billboard_custom_post_type_initialize() {

	$labels = array(
		'name'                  => _x( 'Billboards', 'Post Type General Name', 'js19-custom' ),
		'singular_name'         => _x( 'Billboard', 'Post Type Singular Name', 'js19-custom' ),
		'menu_name'             => __( 'Billboards', 'js19-custom' ),
		'name_admin_bar'        => __( 'Billboard', 'js19-custom' ),
		'archives'              => __( 'Item Archives', 'js19-custom' ),
		'attributes'            => __( 'Item Attributes', 'js19-custom' ),
		'parent_item_colon'     => __( 'Parent Item:', 'js19-custom' ),
		'all_items'             => __( 'All Billboards', 'js19-custom' ),
		'add_new_item'          => __( 'Add New Item', 'js19-custom' ),
		'add_new'               => __( 'Add New', 'js19-custom' ),
		'new_item'              => __( 'New Item', 'js19-custom' ),
		'edit_item'             => __( 'Edit Item', 'js19-custom' ),
		'update_item'           => __( 'Update Item', 'js19-custom' ),
		'view_item'             => __( 'View Item', 'js19-custom' ),
		'view_items'            => __( 'View Items', 'js19-custom' ),
		'search_items'          => __( 'Search Item', 'js19-custom' ),
		'not_found'             => __( 'Not found', 'js19-custom' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'js19-custom' ),
		'featured_image'        => __( 'Featured Image', 'js19-custom' ),
		'set_featured_image'    => __( 'Set featured image', 'js19-custom' ),
		'remove_featured_image' => __( 'Remove featured image', 'js19-custom' ),
		'use_featured_image'    => __( 'Use as featured image', 'js19-custom' ),
		'insert_into_item'      => __( 'Insert into item', 'js19-custom' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'js19-custom' ),
		'items_list'            => __( 'Items list', 'js19-custom' ),
		'items_list_navigation' => __( 'Items list navigation', 'js19-custom' ),
		'filter_items_list'     => __( 'Filter items list', 'js19-custom' ),
	);
	$rewrite = array(
		'slug'                  => 'billboard',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Billboard', 'js19-custom' ),
		'description'           => __( 'Billboards in the Jones Outdoor Portfolio', 'js19-custom' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'post-formats' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 100,
		'menu_icon'             => 'dashicons-tickets-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'billboard',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rest_base'             => 'billboard',
	);
	register_post_type( 'billboard', $args );
}
/**
 * Including the function to initialize custom post types within the JS19__ROOT . js19-custom.php file instead of here, but leave the function commented out in case I want to refactor.
 */
// add_action( 'init', 'js19_billboard_custom_post_type_initialize', 0 );