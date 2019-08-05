<?php
/**
 * Jones Sign Customizations
 *
 * Core functions based on the added options fields.
 *
 * @package JS19Custom
 * @subpackage Validate Settings from the settings p[age.]
 * @author Nick Mortensen
 * @license GPL-2.0+
 * @since 5.0.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Make heading link go to a customized url.
 *
 * @param string $url url escaped url - complete with the 'http'.
 * @return string $url Output the url.
 */
function js19_custom_login_url( $url ) {

	$options = get_option( 'js19_options', js19_options_default() );
	if ( isset( $options['custom_url'] ) && ! empty( $options['custom_url'] ) ) {
		$url = esc_url( $options['custom_url'] );
	}
	return $url;
}
add_filter( 'login_headerurl', 'js19_custom_login_url' );

/**
 * Custom login logo title.
 *
 * @param string $title Custom title as added to the plugin settings.
 * @return string $title Escaped input.
 */
function js19_custom_login_title( $title ) {
	$options = get_option( 'js19_options', js19_options_default() );
	if ( isset( $options['custom_title'] ) && ! empty( $options['custom_title'] ) ) {
		$title = esc_attr( $options['custom_title'] );
	}
	return $title;
}
add_filter( 'login_headertext', 'js19_custom_login_title' );
/**
 * Custom login styles.
 *
 * @return void
 */
function js19_custom_login_styles() {
	$styles  = false;
	$options = get_option( 'js19_options', js19_options_default() );

	if ( isset( $options['custom_style'] ) && ! empty( $options['custom_style'] ) ) {
		$styles = sanitize_text_field( $options['custom_style'] );
	}

	if ( 'enable' === $styles ) {
		$version = microtime( 1 ) * 100; // Unix timestamp to 1/100th of a second.
		wp_enqueue_style( 'js19-login-styles', plugin_dir_url( dirname( __FILE__ ) ) . 'public/css/js19-login.css', array(), $version, 'screen' );
		wp_enqueue_script( 'js19-login-scripts', plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/js19-login.js', array(), $version, true );

	}

}
add_action( 'login_enqueue_scripts', 'js19_custom_login_styles' );

/**
 * Output a custom message on login.
 *
 * @param string $message What was entered into the field.
 * @return string $message The same message only run through the wp_kses_post() function.
 */
function js19_custom_login_message( $message ) {
	$options = get_option( 'js19_options', js19_options_default() );
	if ( isset( $options['custom_message'] ) && ! empty( $options['custom_message'] ) ) {
		$message = wp_kses_post( $options['custom_message'] ) . $message;
	}
	return $message;
}
add_filter( 'login_message', 'js19_custom_login_message' );

/**
 * Outputs a custom bit of footer text.
 *
 * @param string $message What would normally be shown in the footer.
 * @return string $message The new output.
 */
function js19_custom_admin_footer( $message ) {
	$options = get_option( 'js19_options', js19_options_default() );
	if ( isset( $options['custom_footer'] ) && ! empty( $options['custom_footer'] ) ) {
		$message = sanitize_text_field( $options['custom_footer'] );
	}
	return $message;
}
add_filter( 'admin_footer_text', 'js19_custom_admin_footer' );
/**
 * Remove items from the toolbar at the top of the admin pages.
 *
 * @return void
 */
function js19_custom_admin_toolbar() {
	$toolbar = false;
	$options = get_option( 'js19_options', js19_options_default() );
	if ( isset( $options['custom_toolbar'] ) && ! empty( $options['custom_toolbar'] ) ) {
		$toolbar = (bool) $options['custom_toolbar'];
	}
	if ( $toolbar ) {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'comments' );
		$wp_admin_bar->remove_menu( 'new-content' );
	}
}
add_action( 'wp_before_admin_bar_render', 'js19_custom_admin_toolbar', 999 );
/**
 * Enable users to have a customized admin color scheme of my own choice.
 *
 * @param number $user_id User id number as assigned by WordPress upon registration with the site.
 * @return void
 */
function js19_custom_admin_scheme( $user_id ) {
	$scheme  = 'default';
	$options = get_option( 'js19_options', js19_options_default() );
	if ( isset( $options['custom_scheme'] ) && ! empty( $options['custom_scheme'] ) ) {
		$scheme = sanitize_text_field( $options['custom_scheme'] );
	}
	$args = [
		'ID'          => $user_id,
		'admin_color' => $scheme,
	];
	wp_update_user( $args );
}
add_action( 'user_register', 'js19_custom_admin_scheme' );
