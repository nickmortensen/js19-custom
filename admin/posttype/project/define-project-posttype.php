<?php
/**
 * Register a custom post type called "Project".
 *
 * @see get_post_type_labels() for label keys.
 */
function js19_project_cpt_init() {
	$labels = array(
		'name'                  => _x( 'Projects', 'Post type general name', 'js19-custom' ),
		'singular_name'         => _x( 'Project', 'Post type singular name', 'js19-custom' ),
		'menu_name'             => _x( 'Projects', 'Admin Menu text', 'js19-custom' ),
		'name_admin_bar'        => _x( 'Project', 'Add New on Toolbar', 'js19-custom' ),
		'add_new'               => __( 'Add New Project', 'js19-custom' ),
		'add_new_item'          => __( 'Add New Project', 'js19-custom' ),
		'new_item'              => __( 'New Project', 'js19-custom' ),
		'edit_item'             => __( 'Edit Project', 'js19-custom' ),
		'view_item'             => __( 'View Project', 'js19-custom' ),
		'all_items'             => __( 'All Projects', 'js19-custom' ),
		'search_items'          => __( 'Search Projects', 'js19-custom' ),
		'parent_item_colon'     => __( 'Parent Projects:', 'js19-custom' ),
		'not_found'             => __( 'No Projects found.', 'js19-custom' ),
		'not_found_in_trash'    => __( 'No Projects found in Trash.', 'js19-custom' ),
		'featured_image'        => _x( 'Project 16x9 Img', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'js19-custom' ),
		'archives'              => _x( 'Project archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'js19-custom' ),
		'insert_into_item'      => _x( 'Insert into Project', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'js19-custom' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Project', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'js19-custom' ),
		'filter_items_list'     => _x( 'Filter Projects list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'js19-custom' ),
		'items_list_navigation' => _x( 'Projects list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'js19-custom' ),
		'items_list'            => _x( 'Projects list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'js19-custom' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Sign Project Profiles', 'js19-custom' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'projects' ),
		'has_archive'        => true,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'rest_base'          => 'projects',
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-portfolio',
		'menu_position'      => 21,
		'supports'           => array( 'thumbnail', 'title', 'author', 'excerpt' ),
		'map_meta_cap'       => true,
	);

	register_post_type( 'project', $args );
}



// /**
//  * Flush rewrite rules on activation.
//  */
// function projects_rewrite_flush() {
// 	project_cpt_init();
// 	flush_rewrite_rules();
// }
