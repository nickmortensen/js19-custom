<?php
/**
 * Jones Sign Customizations
 *
 * Add post types and taxonomies to WordPress that Jones Sign Company finds useful.
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
 * Ensure function does not already exist. Standard checking in WordPress.
 */
if ( ! function_exists( 'js19_validate_options' ) ) {
	/**
	 * Validate the data entered into the options fields within the JS19 Custom plugin admin settings option pages.
	 *
	 * @param  array $input Asociative array of all the data coming from the additional fields.
	 * @return array $input Associative array of all sanitized data elicited from the options input fields.
	 */
	function js19_validate_options( $input ) {
		/*
			Validate text input(type="url") field given the id of "custom_url" from "settings-register.php".
		*/
		if ( isset( $input['custom_url'] ) ) {
			$input['custom_url'] = esc_url( $input['custom_url'] ); // esc_url is the proper escaping function for a web address.
		}

		/*
			Validate text input field given the id of "custom_title" from "settings-register.php".
			@link https://developer.wordpress.org/reference/functions/sanitize_text_field/
		*/
		if ( isset( $input['custom_title'] ) ) {
			$input['custom_title'] = sanitize_text_field( $input['custom_title'] );
		}

		/*
			Validate radio button field given the id of "custom_style" from "settings-register.php".
		*/
		$radio_options = array(
			'enable'  => 'Enable custom styles',
			'disable' => 'Disable custom styles',
		);
		// Check to see whether there is an entry at all, if nothing was chosen, set as 'null'.
		if ( ! isset( $input['custom_style'] ) ) {
			$input['custom_style'] = null;
		}

		// Check to see whether what was chosen is one of the keys in the $radio_options array.If not, then set to null.
		if ( ! array_key_exists( $input['custom_style'], $radio_options ) ) {
			$input['custom_style'] = null;
		}

		/*
			Validate textarea field given the id of "custom_message" from "settings-register.php".
			@link https://core.trac.wordpress.org/browser/trunk/src/wp-includes/kses.php.
		*/
		if ( isset( $input['custom_message'] ) ) {
			$input['custom_message'] = wp_kses_post( $input['custom_message'] );
		}

		/*
			Validate text input field given the id of "custom_footer" from "settings-register.php".
		*/
		if ( isset( $input['custom_footer'] ) ) {
			$input['custom_footer'] = sanitize_text_field( $input['custom_footer'] );
		}

		/*
			Validate checkbox field given the id of "custom_toolbar" from "settings-register.php".
		*/
		// First, check if this option was set - if it wasn't set the value to 'null'.
		if ( ! isset( $input['custom_toolbar'] ) ) {
			$input['custom_toolbar'] = null;
		}
		// If the custom_toolbar option was set, it is either true (1) or false(0).
		// loose comparison is important here.
		// phpcs:disable WordPress.PHP.StrictComparisons.LooseComparison
		$input['custom_toolbar'] = ( 1 == $input['custom_toolbar'] ? 1 : 0 );

		/*
			Validate the select field given the id of "custom_scheme" from "settings-register.php".
		*/
		$select_options = array(
			'default'   => 'Default',
			'light'     => 'Light',
			'blue'      => 'Blue',
			'coffee'    => 'Coffee',
			'ectoplasm' => 'Ectoplasm',
			'midnight'  => 'Midnight',
			'ocean'     => 'Ocean',
			'sunrise'   => 'Sunrise',
		);
		// Check to see whether the value was set at all, if it was not, then set the $input['color_scheme'] to 'null'.
		if ( ! isset( $input['custom_scheme'] ) ) {
			$input['custom_scheme'] = null;
		}
		// If the 'custom_scheme' option was set, make sure it is a key within the $select_options array. If it isn't a key within the $select_options array, then set it to 'null'.
		if ( ! array_key_exists( $input['custom_scheme'], $select_options ) ) {
			$input['custom_scheme'] = null;
		}

		return $input;

	} // END def js19_validate_options( $input ).
} // end function_exists check.
