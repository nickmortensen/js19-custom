<?php
/**
 * Jones Sign Customizations
 *
 * Settings to register for the JS19 Customization plugin.
 *
 * @package JS19
 * @subpackage Settings Register
 * @author Nick Mortensen
 * @since 1.0.0
 * @license GPL-2.0+
 */

// phpcs:disable Squiz.Commenting.FileComment.SpacingAfterComment
// phpcs:disable Squiz.Commenting.FileComment.WrongStyle
// phpcs:disable WordPress.Arrays.ArrayDeclarationSpacing.AssociativeArrayFound

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Ensure function does not already exist. Standard checking in WordPress.
 */
if ( ! function_exists( 'js19_register_settings' ) ) {
	/**
	 * Registers settings for the JS19 Customization Plugin.
	 *
	 * @return void
	 */
	function js19_register_settings() {
		/*
		$option_group      = 'js19_options'; // Name of the option group. Should match the input of the settings_fields function in './settings-page'.
		$option_name       = 'js19_options'; // Used when retrieving info from database.
		$sanitize_callback = 'js19_validate_options'; // Function name to use that will validate the fields. Find in './settings-validate.php'.
		register_setting( $option_group, $option_name, $sanitize_callback );
		*/
		register_setting( 'js19_options', 'js19_options', 'js19_validate_options' );

		/**
		 * Define a new settings section for the plugin admin options page.
		 *
		 * @param string $id         Slug name that will identify the section.
		 * @param string $title      Shows up as the heading for this section.
		 * @param callable $callback Function that outputs any content at the top of the section between heading and the fields.
		 * @param string $page       Slug-name of the settings page on which to show the section.
		 * @return void
		 */
		/* ======= LOGIN PAGE SETTINGS SECTION ====== */

		/*
		$js19_id       = 'js19_section_login';
		$js19_title    = 'Customize Login Page';
		$js19_callback = 'js19_callback_section_login';
		$js19_page     = 'js19';
		add_settings_section( $js19_id, $js19_title, $js19_callback, $js19_page );
		*/
		add_settings_section( 'js19_section_login', 'Customize Login Page', 'js19_callback_section_login', 'js19' );

		/* ======= ADMIN PAGE SETTINGS SECTION ====== */

		/*
		$js19_id       = 'js19_section_admin';
		$js19_title    = 'Customize Admin Page';
		$js19_callback = 'js19_callback_section_admin';
		$js19_page     = 'js19';
		add_settings_section( $js19_id, $js19_title, $js19_callback, $js19_page );
		*/
		add_settings_section( 'js19_section_admin', 'Customize Admin Page', 'js19_callback_section_admin', 'js19' );

		/* ======= ADD FIELDS TO THE PLUGIN OPTIONS ADMIN PAGE ======= */

		/**
		 * Add Settings Fields.
		 *
		 * @param string   $id Slug-name to identify the field. Used in the 'id' attribute of tags. Used to retrieve value from database.
		 * @param string   $title Formatted title of the field. Shown as the label for the field during output.
		 * @param callable $callback Function that fills the field with the desired form inputs. The function should echo its output.
		 * @param string   $page The slug-name of the settings page on which to show the section (general, reading, writing, ...).
		 * @param string   $section = 'default' The slug-name of the section of the settings page in which to show the box. Should match settings section id.
		 * @param array    $args = ["label_for" => "", "class" => ""]
		 *
		 * @note Extra arguments used when outputting the field.
		 * When "label_for" is supplied, the setting title will be wrapped in a <label> element, its for attribute populated with this value.
		 * "class" is the CSS Class to be added to the <tr> element when the field is output
		 */
		/* Custom URL Field */
		add_settings_field(
			'custom_url',
			'Custom URL',
			'js19_callback_field_text',
			'js19',
			'js19_section_login',
			[ 'id' => 'custom_url', 'label' => 'Custom URL for the login logo link' ]
		);
		/* Custom Title Field */
		add_settings_field(
			'custom_title',
			'Custom Title',
			'js19_callback_field_text',
			'js19',
			'js19_section_login',
			[ 'id' => 'custom_title', 'label' => 'Custom title attribute for the logo link' ]
		);
		/* Custom Style Field */
		add_settings_field(
			'custom_style',
			'Custom Style',
			'js19_callback_field_radio',
			'js19',
			'js19_section_login',
			[ 'id' => 'custom_style', 'label' => 'Custom CSS for the Login screen' ]
		);
		/* Custom Message Field */
		add_settings_field(
			'custom_message',
			'Custom Message',
			'js19_callback_field_textarea',
			'js19',
			'js19_section_login',
			[ 'id' => 'custom_message', 'label' => 'Custom text and/or markup' ]
		);
		/* Custom Footer Field */
		add_settings_field(
			'custom_footer',
			'Custom Footer',
			'js19_callback_field_text',
			'js19',
			'js19_section_admin',
			[ 'id' => 'custom_footer', 'label' => 'Custom footer text' ]
		);
		/* Custom Toolbar Field */
		add_settings_field(
			'custom_toolbar',
			'Custom Toolbar',
			'js19_callback_field_checkbox',
			'js19',
			'js19_section_admin',
			[ 'id' => 'custom_toolbar', 'label' => 'Remove new post and comment links from the Toolbar' ]
		);
		/* Color Scheme Field */
		add_settings_field(
			'custom_scheme',
			'Custom Scheme',
			'js19_callback_field_select',
			'js19',
			'js19_section_admin',
			[ 'id' => 'custom_scheme', 'label' => 'Set New User Custom Scheme' ]
		);

	} // END def js19_register_settings()

	/*
	$wp_tag          = 'admin_init'; // Tag to hook into.
	$function_to_add = 'js19_register_settings'; // Name of function.
	$priority        = 11; // Order to run function - default = 10.
	$accepted_args   = 0; // Qty of args in the $function_to_add. Default is 1.
	*/
	add_action( 'admin_init', 'js19_register_settings' );
} // END ! function_exists( 'js19_register_settings' ).

