<?php
/**
 * Jones Sign Customizations
 *
 * Add sublevel admin menu item for the JS19 Plugin.
 *
 * @package JS19
 * @subpackage Loader
 * @author Nick Mortensen
 * @since 1.0.0
 * @license GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'js19_add_sublevel_menu' ) ) {
	/**
	 * Add sublevel menu for the js19 plugin
	 *
	 * @return void
	 */
	function js19_add_sublevel_menu() {
		/*
		$parent_slug = 'options-general.php'; // Adds to the options-settings menu - could use plugins.php if I wanted.
		$page_title  = 'JS19 Settings';
		$menu_title  = 'JS19 Customizations';
		$capability  = 'manage_options'; // Users can manage options.
		$menu_slug   = 'js19';  // Unique string in url. use plugin name.
		$function    = 'js19_display_settings_page'; // Callback function to display the submenu. Defined above on this page.
		add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		*/
		add_submenu_page( 'options-general.php', 'JS19 Settings', 'JS19', 'manage_options', 'js19', 'js19_display_settings_page' );
	}
	add_action( 'admin_menu', 'js19_add_sublevel_menu' );
}
