<?php
/**
 * Register a custom post type called "Staffer".
 *
 * @category   Plugins
 * @package    js19 custom
 * @subpackage posttypes
 * @author     Nick Mortensen
 * @license    GPL-2.0+
 * @link       http://github.com/nickmortensen/js19-custom/
 * @since      5.0.2
 */
function js19_staff_cpt_init() {
	$labels = array(
		'name'                  => _x( 'Staffers', 'Post type general name', 'js19-custom' ),
		'singular_name'         => _x( 'Staffmember', 'Post type singular name', 'js19-custom' ),
		'menu_name'             => _x( 'Staffers', 'Admin Menu text', 'js19-custom' ),
		'name_admin_bar'        => _x( 'Staffmember', 'Add New on Toolbar', 'js19-custom' ),
		'add_new'               => __( 'Add New Staffmember', 'js19-custom' ),
		'add_new_item'          => __( 'Add New Staffmember', 'js19-custom' ),
		'new_item'              => __( 'New Staffmember', 'js19-custom' ),
		'edit_item'             => __( 'Edit Staffmember', 'js19-custom' ),
		'view_item'             => __( 'View Staffmember', 'js19-custom' ),
		'all_items'             => __( 'All Staffers', 'js19-custom' ),
		'search_items'          => __( 'Search Staffers', 'js19-custom' ),
		'parent_item_colon'     => __( 'Parent Staffers:', 'js19-custom' ),
		'not_found'             => __( 'No Staffers found.', 'js19-custom' ),
		'not_found_in_trash'    => __( 'No Staffers found in Trash.', 'js19-custom' ),
		'featured_image'        => _x( 'Staffmember 16x9 Img', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'archives'              => _x( 'Staffmember archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'js19-custom' ),
		'insert_into_item'      => _x( 'Insert into Staffmember', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'js19-custom' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Staffmember', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'js19-custom' ),
		'filter_items_list'     => _x( 'Filter Staffers list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'js19-custom' ),
		'items_list_navigation' => _x( 'Staffers list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'js19-custom' ),
		'items_list'            => _x( 'Staffers list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'js19-custom' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Staffmember Profiles', 'js19-custom' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'staff' ),
		'has_archive'        => true,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'rest_base'          => 'staff',
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-id',
		'menu_position'      => 226,
		'supports'           => array( 'thumbnail', 'title', 'page-attributes', 'excerpt' ),
		'map_meta_cap'       => true,
		'taxonomies'         => [ 'location' ],
	);

	register_post_type( 'staff', $args );
}
