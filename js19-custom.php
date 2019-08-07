<?php
/**
 * Plugin Name: JS19 Custom
 * Plugin URI:  https://linkedin.com/learning
 * Description: Experimental Jones Sign Company specific plugin.
 * Version:     0.0.2
 * Author URI:  https://nickmortensen.com
 * Text Domain: js19-custom
 * Domain Path: /languages
 *
 * @author Nick Mortensen
 * @package JS19Custom
 * @license GPL-2.0+
 * @since 5.0.1

 * Projects is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * Projects is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Projects. If not, see https://www.gnu.org/licenses/gpl.html.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Additional fields are built on CMB2 - so include their init.php script here.
require_once __DIR__ . '/includes/CMB2/init.php';


/** Use the constant instead of the actual plugin name wherever possible -- will allow you to change it later on */
/**
 * Loads the text domain.
 */
function js19_load_textdomain() {
	load_plugin_textdomain( 'js19custom', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'js19_load_textdomain' );

defined( 'JS19__ROOT' ) || define( 'JS19__ROOT', plugin_dir_path( __FILE__ ) ); // The Root of this plugin.
defined( 'JS19__ROOT_URL' ) || define( 'JS19__ROOT_URL', plugins_url() . '/js19-custom' );
define( 'JS19_', 'js19' );
define( 'JS19__VERSION', '0.0.2' );
define( 'JS19__ADMIN', JS19__ROOT . '/admin' ); // Admin only folder.

/**
 * Get the bootstrap!
 * (Update path to use cmb2 or CMB2, depending on the name of the folder.
 * Case-sensitive is important on some systems.)
 */
defined( 'JS19__INCLUDES' ) || define( 'JS19__INCLUDES', JS19__ROOT . 'includes' );
defined( 'JS19__POSTTYPE' ) || define( 'JS19__POSTTYPE', JS19__ROOT . 'admin/posttype' );
defined( 'JS19__STAFFER' ) || define( 'JS19__STAFFER', JS19__ROOT . 'admin/posttype/staffer' );
defined( 'JS19__TAXONOMY' ) || define( 'JS19__TAXONOMY', JS19__ROOT . 'admin/taxonomy' );


/**
 * ANY PHP FILE WITHIN THE INCLUDES DIRECTORY!!
 * As long as the following loop is displayed higher up than other files, we can use this loop and globs to require_once any php file in a directory.
 */
foreach ( glob( plugin_dir_path( __FILE__ ) . 'includes/*.php' ) as $file ) {
	require_once $file;
}

if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php'; // Uses submenu rather than top-level menu.
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php'; // Displays the admin settings page.
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callbacks.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-validate.php';
	require_once JS19__INCLUDES . '/project-partners-field-type.php';
	require_once JS19__POSTTYPE . '/project/project-posttype-custom-columns.php';
	require_once JS19__POSTTYPE . '/project/project-posttype-extra-fields-cmb2.php';
	// require_once JS19__POSTTYPE . '/project/experimental-project-posttype-extra-fields-cmb2.php';
	require_once JS19__TAXONOMY . '/signtype/define-signtype-taxonomy.php';
	require_once JS19__TAXONOMY . '/signtype/taxonomy-signtype-extra-fields-cmb2.php';
	require_once JS19__TAXONOMY . '/location/taxonomy-location-extra-fields-cmb2.php';
	require_once JS19__TAXONOMY . '/location/taxonomy-location-admin-columns.php';
	require_once JS19__STAFFER . '/posttype-staff-admin-columns.php';
	require_once JS19__STAFFER . '/posttype-staff-extra-fields-cmb2.php';
}
require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php'; // Core functions for the js19 Custom plugin.



/**
 * Use a loop to define the additional post types.
 */
require_once JS19__TAXONOMY . '/location/define-location-taxonomy.php';
require_once JS19__POSTTYPE . '/project/define-project-posttype.php'; // Contains function js19_project_cpt_init().
require_once JS19__STAFFER . '/define-staff-posttype.php';  // Contains function js19_staff_cpt_init().
$js19_post_type_functions = [ 'js19_staff_cpt_init', 'js19_project_cpt_init', 'js19_custom_location_taxonomy' ];
foreach ( $js19_post_type_functions as $posttype ) {
	add_action( 'init', $posttype );
}
/**
 * Register Task post type.
 */
register_activation_hook( __FILE__, 'projects_rewrite_flush' );
/**
 * Remove Comments from the admin menu.
 */
function remove_unwanted_menu() {
	$remove_these_pages = [ 'edit-comments', 'tools', 'users' ];
	foreach ( $remove_these_pages as $pagename ) {
		remove_menu_page( $page . '.php' );
	}
	// remove_menu_page( 'edit-comments.php' );
	// remove_menu_page( 'users.php' );
	// remove_menu_page( 'tools.php' );
}
add_action( 'admin_menu', 'remove_unwanted_menu' );


/**
 * Loads custom javascript files.
 *
 * @param string $hook The pages that the custom javascript files should be loaded on within the admin.
 * @return void
 */
function projects_admin_scripts_load( $hook ) {

	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}
	wp_enqueue_script( 'projects-javascript', plugins_url( 'js19-custom/includes/js/custom_fields.js' ), array(), '20190614', true );
	wp_enqueue_script( 'projects-conditional-fields-js', plugins_url( 'js19-custom/includes/js/conditional_fields.js' ), array(), '20190614', true );
}

add_action( 'admin_enqueue_scripts', 'projects_admin_scripts_load' );

/** THIS SHOULD BE ONLY TEMPORARY */
/**
 * Default plugin options.
 *
 * @return array The default values for the options.
 */
function js19_options_default() {

	return array(
		'custom_url'     => 'https://wordpress.org/',
		'custom_title'   => 'Default Title for js19',
		'custom_style'   => 'enable',
		'custom_message' => '<p class="custom-message">My custom message</p>',
		'custom_footer'  => 'Special message for users',
		'custom_toolbar' => 1,
		'custom_scheme'  => 'default',
	);

}
