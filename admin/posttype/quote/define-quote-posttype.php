<?php
/**
 * Plugin Name: JS19 Custom
 * Plugin URI:  https://linkedin.com/learning
 * Description: Define the post type 'quote'.
 * Version:     0.0.2
 * Author URI:  https://nickmortensen.com
 * Text Domain: js19-custom
 * Domain Path: /languages
 *
 * @author Nick Mortensen
 * @package JS19Custom
 * @license GPL-2.0+
 * @since 5.0.1
 */
// Register Custom Post Type
function js19_quote_custom_post_type_initialize() {

	$labels = array(
		'name'                  => _x( 'Quotes', 'Post Type General Name', 'js19-custom' ),
		'singular_name'         => _x( 'Quote', 'Post Type Singular Name', 'js19-custom' ),
		'menu_name'             => __( 'Quote', 'js19-custom' ),
		'name_admin_bar'        => __( 'Quote', 'js19-custom' ),
		'archives'              => __( 'Quote Archives', 'js19-custom' ),
		'attributes'            => __( 'Attributes', 'js19-custom' ),
		'parent_item_colon'     => __( 'Parent Item:', 'js19-custom' ),
		'all_items'             => __( 'All Quotes', 'js19-custom' ),
		'add_new_item'          => __( 'Add New Quote', 'js19-custom' ),
		'add_new'               => __( 'Add New', 'js19-custom' ),
		'new_item'              => __( 'New Quote', 'js19-custom' ),
		'edit_item'             => __( 'Edit Quote', 'js19-custom' ),
		'update_item'           => __( 'Update Quote', 'js19-custom' ),
		'view_item'             => __( 'View Quote', 'js19-custom' ),
		'view_items'            => __( 'View Quotes', 'js19-custom' ),
		'search_items'          => __( 'Search Quotes', 'js19-custom' ),
		'not_found'             => __( 'Not found', 'js19-custom' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'js19-custom' ),
		'featured_image'        => __( 'Featured Image', 'js19-custom' ),
		'set_featured_image'    => __( 'Set featured image', 'js19-custom' ),
		'remove_featured_image' => __( 'Remove featured image', 'js19-custom' ),
		'use_featured_image'    => __( 'Use as featured image', 'js19-custom' ),
		'insert_into_item'      => __( 'Insert into item', 'js19-custom' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Quote', 'js19-custom' ),
		'items_list'            => __( 'Quotes list', 'js19-custom' ),
		'items_list_navigation' => __( 'Quotes list nav', 'js19-custom' ),
		'filter_items_list'     => __( 'Filter Quotes List', 'js19-custom' ),
	);
	$rewrite = array(
		'slug'                  => 'quote',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Quote', 'js19-custom' ),
		'description'           => __( 'Open Staff Quotes with Descriptions', 'js19-custom' ),
		'labels'                => $labels,
		'supports'              => array( 'thumbnail', 'title', 'excerpt', 'slug' ),
		'taxonomies'            => array( 'location' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 100,
		'menu_icon'             => 'dashicons-format-chat',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rest_base'             => 'quote',
		'rest_controller_class' => 'WP_REST_Client_Controller',
	);
	register_post_type( 'quote', $args );

}
/**
 * Including the function to initialize custom post types within the JS19__ROOT . js19-custom.php file instead of here, but leave the function commented out in case I want to refactor.
 */
// add_action( 'init', 'js19_position_custom_post_type_initialize', 0 );