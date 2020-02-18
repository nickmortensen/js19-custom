<?php
/**
 * Plugin Name: JS19 Custom
 * Plugin URI:  https://linkedin.com/learning
 * Description: Experimental Jones Sign Company specific plugin.
 * Version:     0.0.2
 * Author URI:  https://nickmortensen.com
 * Text Domain: js2020
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
defined( 'JS19__INCLUDES' ) || define( 'JS19__INCLUDES', JS19__ROOT . 'includes' ); // General Includes file - not specific to public or admin.
defined( 'JS19__CUSTOM_CMB2_FIELDS' ) || define( 'JS19__CUSTOM_CMB2_FIELDS', JS19__INCLUDES . '/custom-cmb2-fields' ); // General Includes file - not specific to public or admin.

defined( 'JS19__POSTTYPE' ) || define( 'JS19__POSTTYPE', JS19__ROOT . 'admin/posttype' ); // Directory of custom post types.
defined( 'JS19__TAXONOMY' ) || define( 'JS19__TAXONOMY', JS19__ROOT . 'admin/taxonomy' ); // Directory of custom taxonomies.

defined( 'JS19__STAFF' ) || define( 'JS19__STAFF', JS19__POSTTYPE . '/staff' );
defined( 'JS19__CLIENT' ) || define( 'JS19__CLIENT', JS19__POSTTYPE . '/client' );
defined( 'JS19__PROJECT' ) || define( 'JS19__PROJECT', JS19__POSTTYPE . '/project' );
defined( 'JS19__POSITION' ) || define( 'JS19__POSITION', JS19__POSTTYPE . '/position' );
defined( 'JS19__QUOTE' ) || define( 'JS19__QUOTE', JS19__POSTTYPE . '/quote' );
defined( 'JS19__BILLBOARD' ) || define( 'JS19__BILLBOARD', JS19__POSTTYPE . '/billboard' );

defined( 'JS19__LOCATION' ) || define( 'JS19__LOCATION', JS19__TAXONOMY . '/location' );
defined( 'JS19__SIGNTYPE' ) || define( 'JS19__SIGNTYPE', JS19__TAXONOMY . '/signtype' );


/**
 * Include Every '.php' File Within the 'Includes' Directory
 * As long as the following loop is displayed higher up than other files, we can use this loop and globs to require_once any php file in a directory.
 */
// foreach ( glob( plugin_dir_path( __FILE__ ) . 'includes/*.php' ) as $file ) {
// 	require_once $file;
// }
/**
 * Include the defined post types
 */
require_once JS19__CLIENT . '/define-client-posttype.php';
require_once JS19__TAXONOMY . '/location/define-location-taxonomy.php';
require_once JS19__POSTTYPE . '/project/define-project-posttype.php'; // Contains function js19_project_cpt_init().
require_once JS19__STAFF . '/define-staff-posttype.php';  // Contains function js19_staff_cpt_init().
require_once JS19__POSITION . '/define-position-posttype.php';  // Contains function js19_staff_cpt_init().
require_once JS19__QUOTE . '/define-quote-posttype.php';  // Contains function js19_staff_cpt_init().
require_once JS19__BILLBOARD . '/define-billboard-posttype.php';  // Contains function js19_staff_cpt_init().

if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php'; // Uses submenu rather than top-level menu.
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php'; // Displays the admin settings page.
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callbacks.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-validate.php';
	require_once JS19__PROJECT . '/partner/partner-field-type.php';
	require_once JS19__PROJECT . '/project-posttype-custom-columns.php';
	require_once JS19__PROJECT . '/project-posttype-extra-fields-cmb2.php';
	require_once JS19__CLIENT . '/client-posttype-cmb2-custom-fields.php';
	require_once JS19__QUOTE . '/posttype-quote-extra-fields-cmb2.php';
	require_once JS19__SIGNTYPE . '/define-signtype-taxonomy.php';
	require_once JS19__SIGNTYPE . '/taxonomy-signtype-extra-fields-cmb2.php';
	require_once JS19__LOCATION . '/taxonomy-location-extra-fields-cmb2.php';
	require_once JS19__LOCATION . '/taxonomy-location-admin-columns.php';
	require_once JS19__STAFF . '/posttype-staff-admin-columns.php';
	require_once JS19__STAFF . '/posttype-staff-extra-fields-cmb2.php';
	require_once JS19__BILLBOARD . '/billboard-posttype-cmb2-custom-fields.php';
}
require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php'; // Core functions for the js19 Custom plugin.


/**
 * CMB2 NON STANDARD FIELDS CREATED JUST FOR THIS SITE
 */

 // BILLBOARD FIELD.
require_once JS19__CUSTOM_CMB2_FIELDS . '/billboard-field/billboard-metafield.php';

// SWITCH FIELD
// Add Switch field.
require_once JS19__CUSTOM_CMB2_FIELDS . '/switch-button/switch-metafield-option-two.php';
require_once JS19__CUSTOM_CMB2_FIELDS . '/switch-button/switch-metafield.php';

// COORDINATES FIELD
// require_once JS19__CUSTOM_CMB2_FIELDS . '/coordinates-field/coordinates-metafield.php';
/**
 * Load up the custom js and css for the Custom Switch Field in CMB2.
 *
 * @return void
 */
function load_switch_cmb2_script() {
	wp_enqueue_style( 'cmb2_switch-css', plugins_url( 'js19-custom/includes/custom-cmb2-fields/switch-button/switch-metafield.css' ), false, '1.0.0' ); // CSS for switch field.

}
add_action( 'admin_enqueue_scripts', 'load_switch_cmb2_script', 20 );

/**
 * Create an array of the various custom post type initialization functions, then loop through that to initialize them here rather than in the definition files themselves.
 */
$js19_post_type_functions = [
	'js19_client_custom_post_type_initialize', // Initialize client custom post type.
	'js19_staff_custom_post_type_initialize', // Initialize staff custom post type.
	'js19_project_custom_post_type_initialize', // Initialize project custom post type.
	'js19_position_custom_post_type_initialize', // Initialize position custom post type for job openings.
	'js19_custom_location_taxonomy_initialize', // Initialize 'location' custom taxonomy.
	'js19_quote_custom_post_type_initialize', // Initialize the quote custom post type.
	'js19_billboard_custom_post_type_initialize', // Initialize the billboard custom post type.
];
foreach ( $js19_post_type_functions as $posttype ) {
	add_action( 'init', $posttype, 0 );
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
		remove_menu_page( $pagename . '.php' );
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
	wp_enqueue_script( 'cmb2_switch-js', plugins_url( 'js19-custom/includes/custom-cmb2-fields/switch-button/switch-metafield.js' ), '', '1.0.0', true ); // JS for switch field.
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
