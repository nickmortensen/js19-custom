<?php
/**
 * Plugin Name: JS19 Custom
 *
 * Callback functions for the fields added to the js19 Customizations plugin.
 *
 * @package JS19Custom
 * @subpackage Settings Callbacks
 * @author Nick Mortensen
 * @license GPL-2.0+
 * @since 5.0.1
 */

//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
// phpcs:disable Squiz.Commenting.FileComment.WrongStyle
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/* ======= SECTION CALLBACK FUNCTIONS ======= */
if ( ! function_exists( 'js19_callback_section_admin' ) ) {
	/**
	 * Output fields in the login section of the plugin settings.
	 *
	 * @return void
	 */
	function js19_callback_section_admin() {
		echo '<p>Customize the WP Admin Area.</p>';
	} // end definition of js19_callback_section_admin().
} // end check if function exists for js19_callback_section_admin().

if ( ! function_exists( 'js19_callback_section_login' ) ) {
	/**
	 * Output fields in the login section of the plugin settings.
	 *
	 * @return void
	 */
	function js19_callback_section_login() {
		echo '<p>Customize the WP Login screen.</p>';
	} // end definition of js19_callback_section_login().
} // end check if function exists for js19_callback_section_login().


/* ======= OPTION FIELDS CALLBACK FUNCTIONS ======= */
/**
 * Callback Text Field.
 *
 * @param array $args Optional Arguments to supply to the input field and label.
 */
function js19_callback_field_text( $args ) {
	$options = get_option( 'js19_options', js19_options_default() );
	$id      = isset( $args['id'] ) ? $args['id'] : '';
	$label   = isset( $args['label'] ) ? $args['label'] : '';
	$value   = isset( $options[ $id ] ) ? sanitize_text_field( $options[ $id ] ) : '';
	echo '<input id="js19_options_' . $id . '" name="js19_options[' . $id . ']" type="text" size="40" value="' . $value . '"><br />';
	echo '<label for="js19_options_' . $id . '">' . $label . '</label>';
}

/**
 * Radio field options
 *
 * @return array Options.
 */
function js19_options_radio() {

	return array(
		'enable'  => 'Enable custom styles',
		'disable' => 'Disable custom styles',
	);

}
/**
 * Display a Radio Field on the admin options page.
 *
 * @param array $args Were added in the add_settings_field() function for this field.
 * @return void
 */
function js19_callback_field_radio( $args ) {

	$options         = get_option( 'js19_options', js19_options_default() );
	$id              = isset( $args['id'] ) ? $args['id'] : '';
	$label           = isset( $args['label'] ) ? $args['label'] : '';
	$selected_option = isset( $options[ $id ] ) ? sanitize_text_field( $options[ $id ] ) : '';
	$radio_options   = js19_options_radio();

	foreach ( $radio_options as $value => $label ) {

		$checked = checked( $selected_option === $value, 1, 0 );

		echo '<label><input name="js19_options[' . $id . ']" type="radio" value="' . $value . '"' . $checked . '> ';
		echo '<span>' . $label . '</span></label><br />';

	}

}



	/**
	 * Display a Textarea Field
	 *
	 * @param array $args Were added in the add_settings_field() function for this field.
	 * @return void
	 */
function js19_callback_field_textarea( $args ) {

	$options      = get_option( 'js19_options', js19_options_default() );
	$id           = isset( $args['id'] ) ? $args['id'] : '';
	$label        = isset( $args['label'] ) ? $args['label'] : '';
	$allowed_tags = wp_kses_allowed_html( 'post' );
	$value        = isset( $options[ $id ] ) ? wp_kses( stripslashes_deep( $options[ $id ] ), $allowed_tags ) : '';

	echo '<textarea id="js19_options_' . $id . '" name="js19_options[' . $id . ']" rows="5" cols="50">' . $value . '</textarea><br />';
	echo '<label for="js19_options_' . $id . '">' . $label . '</label>';

}

/**
 * Displays a Checkbox Field.
 *
 * @param array $args Set in add_settings_field() declaration for this field.
 * @return void
 */
function js19_callback_field_checkbox( $args ) {

	$options = get_option( 'js19_options', js19_options_default() );

	$id    = isset( $args['id'] ) ? $args['id'] : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$checked = isset( $options[ $id ] ) ? checked( $options[ $id ], 1, false ) : '';

	echo '<input id="js19_options_' . $id . '" name="js19_options[' . $id . ']" type="checkbox" value="1"' . $checked . '> ';
	echo '<label for="js19_options_' . $id . '">' . $label . '</label>';

}

	/**
	 * REtrieve the options for this select field.
	 *
	 * @return array All the options.
	 */
function js19_options_select() {

	return array(
		'default'   => 'Default',
		'light'     => 'Light',
		'blue'      => 'Blue',
		'coffee'    => 'Coffee',
		'ectoplasm' => 'Ectoplasm',
		'midnight'  => 'Midnight',
		'ocean'     => 'Ocean',
		'sunrise'   => 'Sunrise',
	);

}

/**
 * Callback Select Field.
 *
 * @param array $args Set within the add_settings declaration.
 * @return void
 */
function js19_callback_field_select( $args ) {
	$options         = get_option( 'js19_options', js19_options_default() );
	$id              = isset( $args['id'] ) ? $args['id'] : '';
	$label           = isset( $args['label'] ) ? $args['label'] : '';
	$selected_option = isset( $options[ $id ] ) ? sanitize_text_field( $options[ $id ] ) : '';
	$select_options  = js19_options_select();

	echo '<select id="js19_options_' . $id . '" name="js19_options[' . $id . ']">';

	foreach ( $select_options as $value => $option ) {

		$selected = selected( $selected_option === $value, true, false );

		echo '<option value="' . $value . '"' . $selected . '>' . $option . '</option>';

	}

	echo '</select> <label for="js19_options_' . $id . '">' . $label . '</label>';

}
