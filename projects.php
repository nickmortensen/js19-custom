<?php
/**
 * Plugin Name: Projects
 * Plugin URI:  https://linkedin.com/learning
 * Description: Refactored Custom Project Posts and Fields Done in CMB2 to eventually Expose to the REST API.
 * Version:     0.0.1
 * Author URI:  https://nickmortensen.com
 * Text Domain: jonessignProjects
 * Domain Path: /languages
 *
 * @author Nick Mortensen
 * @package jonessignProjects
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

/**
 * Get the bootstrap!
 * (Update path to use cmb2 or CMB2, depending on the name of the folder.
 * Case-sensitive is important on some systems.)
 */
define( 'PROJECTS_ROOT', plugin_dir_path( __FILE__ ) );
define( 'PROJECT_INCLUDES', PROJECTS_ROOT . 'includes' );
require_once __DIR__ . '/includes/CMB2/init.php';
require_once PROJECT_INCLUDES . '/project-partners-field-type.php';

// phpcs:disable Generic.ControlStructures.InlineControlStructure.NotAllowed
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * ANY PHP FILE WITHIN THE INCLUDES DIRECTORY!!
 * As long as the following loop is displayed higher up than other files, we can use this loop and globs to require_once any php file in a directory.
 */
foreach ( glob( plugin_dir_path( __FILE__ ) . 'includes/*.php' ) as $file ) {
	require_once $file;
}
/**
 * Register Task post type.
 */
// require_once plugin_dir_path( __FILE__ ) . 'includes/posttypes.php'; // covered by the loop.
register_activation_hook( __FILE__, 'projects_rewrite_flush' );


// Add capabilities.
register_activation_hook( __FILE__, 'projects_add_capabilities' );
register_deactivation_hook( __FILE__, 'projects_remove_capabilities' );


/**
 * Load custom javascript files.
 *
 * @param string $hook The pages that the custom javascript files should be loaded on within the admin.
 * @return void
 */
function projects_admin_scripts_load( $hook ) {

	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) return;
	wp_enqueue_script( 'projects-javascript', plugins_url( 'projects/includes/js/custom_fields.js' ), array(), '20190614', true );
	wp_enqueue_script( 'projects-conditional-fields-js', plugins_url( 'projects/includes/js/conditional_fields.js' ), array(), '20190614', true );
}

add_action( 'admin_enqueue_scripts', 'projects_admin_scripts_load' );
