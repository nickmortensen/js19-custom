<?php
/**
 * Register client post type.
 *
 * @package   js19 custom
 * @author    Nick Mortensen
 * @license   GPL-2.0+
 * @link      http://github.com/nickmortensen/js19-custom/
 * @copyright 2019 Nick Mortensen
 */
function js19_client_custom_post_type_initialize() {

	$labels = array(
		'name'                  => _x( 'Clientele', 'Post Type General Name', 'js19-custom' ),
		'singular_name'         => _x( 'Client', 'Post Type Singular Name', 'js19-custom' ),
		'menu_name'             => __( 'Client', 'js19-custom' ),
		'name_admin_bar'        => __( 'Client', 'js19-custom' ),
		'archives'              => __( 'Client Archives', 'js19-custom' ),
		'attributes'            => __( 'Attributes', 'js19-custom' ),
		'parent_item_colon'     => __( 'Parent Item:', 'js19-custom' ),
		'all_items'             => __( 'All Clients', 'js19-custom' ),
		'add_new_item'          => __( 'Add New Client', 'js19-custom' ),
		'add_new'               => __( 'Add New', 'js19-custom' ),
		'new_item'              => __( 'New Client', 'js19-custom' ),
		'edit_item'             => __( 'Edit Client', 'js19-custom' ),
		'update_item'           => __( 'Update Client', 'js19-custom' ),
		'view_item'             => __( 'View Client', 'js19-custom' ),
		'view_items'            => __( 'View Clients', 'js19-custom' ),
		'search_items'          => __( 'Search Clients', 'js19-custom' ),
		'not_found'             => __( 'Not found', 'js19-custom' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'js19-custom' ),
		'featured_image'        => __( 'Featured Image', 'js19-custom' ),
		'set_featured_image'    => __( 'Set featured image', 'js19-custom' ),
		'remove_featured_image' => __( 'Remove featured image', 'js19-custom' ),
		'use_featured_image'    => __( 'Use as featured image', 'js19-custom' ),
		'insert_into_item'      => __( 'Insert into item', 'js19-custom' ),
		'uploaded_to_this_item' => __( 'Uploaded to this client', 'js19-custom' ),
		'items_list'            => __( 'Clients list', 'js19-custom' ),
		'items_list_navigation' => __( 'Clients list nav', 'js19-custom' ),
		'filter_items_list'      => __( 'Filter Clients List', 'js19-custom' ),
	);
	$rewrite = array(
		'slug'                  => 'client',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Client', 'js19-custom' ),
		'description'           => __( 'Jones Sign Company Clientele and Details', 'js19-custom' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'excerpt', 'post-formats' ),
		'taxonomies'            => array( 'location' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 100,
		'menu_icon'             => 'dashicons-admin-multisite',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rest_base'             => 'client',
		'rest_controller_class' => 'WP_REST_Client_Controller',
	);
	register_post_type( 'client', $args );

}
/**
 * Including the function to initialize custom post types within the JS19__ROOT . js19-custom.php file instead of here, but leave the function commented out in case I want to refactor.
 */
// add_action( 'init', 'js19_client_custom_post_type_initialize', 0 );