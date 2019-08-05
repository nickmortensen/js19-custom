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
function client_cpt_init() {
	$labels = array(
		'name'                  => _x( 'Clientele', 'Post type general name', 'js19-custom' ),
		'singular_name'         => _x( 'Client', 'Post type singular name', 'js19-custom' ),
		'menu_name'             => _x( 'Clientele', 'Admin Menu text', 'js19-custom' ),
		'name_admin_bar'        => _x( 'Client', 'Add New on Toolbar', 'js19-custom' ),
		'add_new'               => __( 'Add New Client', 'js19-custom' ),
		'add_new_item'          => __( 'Add New Client', 'js19-custom' ),
		'new_item'              => __( 'New Client', 'js19-custom' ),
		'edit_item'             => __( 'Edit Client', 'js19-custom' ),
		'view_item'             => __( 'View Client', 'js19-custom' ),
		'all_items'             => __( 'All Clientele', 'js19-custom' ),
		'search_items'          => __( 'Search Clientele', 'js19-custom' ),
		'parent_item_colon'     => __( 'Parent Clientele:', 'js19-custom' ),
		'not_found'             => __( 'No Clientele found.', 'js19-custom' ),
		'not_found_in_trash'    => __( 'No Clientele found in Trash.', 'js19-custom' ),
		'featured_image'        => _x( 'Client 16x9 Img', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'archives'              => _x( 'Client archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'js19-custom' ),
		'insert_into_item'      => _x( 'Insert into Client', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'js19-custom' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Client', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'js19-custom' ),
		'filter_items_list'     => _x( 'Filter Clientele list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'js19-custom' ),
		'items_list_navigation' => _x( 'Clientele list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'js19-custom' ),
		'items_list'            => _x( 'Clientele list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'js19-custom' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Client Profiles', 'js19-custom' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'client' ),
		'has_archive'        => true,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'rest_base'          => 'client',
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-buddicons-buddypress-logo',
		'menu_position'      => 26,
		'supports'           => array( 'thumbnail', 'title', 'author', 'excerpt' ),
		'map_meta_cap'       => true,
	);

	register_post_type( 'client', $args );
}
$action_to_hook_into = 'init'; // Action that Clientele_cpt_init() is hooked to.
$function_to_add     = 'client_cpt_init';
add_action( 'init', $function_to_add );
