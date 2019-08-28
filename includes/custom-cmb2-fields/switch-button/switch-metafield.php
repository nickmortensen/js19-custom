<?php
/**
 * Creates a switch field using cmb2.

 * @author Nick Mortensen
 * @package js19-custom
 * @license GPL-2.0+
 * @since 5.0.1
 * @link https://www.proy.info/how-to-create-cmb2-switch-field/
 */

/**
 * Adds a switch field in the array of field types for CMB2
 *
 * @param object  $field               The current CMB2_Field object.
 * @param string  $escaped_value      The value of this field passed through the escaping filter. It defaults to sanitize_text_field.
 * @param integer $object_id          The id of the object you are working with. Most commonly, the post id.
 * @param string  $object_type        The type of object you are working with. Most commonly, post (this applies to all post-types), but could also be comment, user or options-page.
 * @param object  $field_type_object   This is an instance of the CMB2_Types object and gives you access to all of the methods that CMB2 uses to build its field types.
 * @return void
 */
function js19_cmb2_render_switch( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {

	// The next few variables are comprised of a long ternary operator, so I've decided to place it on three lines for readability. You're welcome.
	$conditional_value = (
		isset( $field->args['attributes']['data-conditional-value'] )
		? ' data-conditional-value="' . esc_attr( $field->args['attributes']['data-conditional-value'] ) . '"'
		: ''
	);
	$conditional_id = (
		isset( $field->args['attributes']['data-conditional-id'] )
		? ' data-conditional-id="' . esc_attr( $field->args['attributes']['data-conditional-id'] ) . '"'
		: ''
	);
	$label_on = (
		isset( $field->args['label'] )
		? esc_attr( $field->args['label']['on'] )
		: ' On'
	);
	$label_off = (
		isset( $field->args['label'] )
		? esc_attr( $field->args['label']['off'] )
		: ' Off'
	);
	// Now we start building the outer div as well as the switch that it contains.
	$switch = '<div id="field_' . strtolower( $field->args['_id'] ) . '_containing_div" class="cmb2-switch">';
	$switch .= '<input ' . $conditional_value . $conditional_id . ' type="radio" id="' . strtolower( $field->args['_id'] ) . '_option_0" value="' . strtolower( $label_off ) .'" ' . ( $escaped_value == 1 ? 'checked="checked"' : '' ) . ' name="' . strtolower(esc_attr( $field->args['_name'] )) . '_input" />';
	$switch .= '<input '. $conditional_value . $conditional_id . ' type="radio" id="' . strtolower( $field->args['_id'] ) . '_option_1" value="' . strtolower( $label_on ) .'" ' . ( ( $escaped_value == '' || $escaped_value == 0 ) ? 'checked="checked"' : '' ) . ' name="' . esc_attr( $field->args['_name'] ) . '" />';
	$switch .= '<label for="' . $field->args['_id'] . '1" class="cmb2-enable ' . ( $escaped_value == 1 ? 'selected' : '' ) . '"><span>' . $label_on . '</span></label>';
	$switch .= '<label for="' . $field->args['_id'] . '2" class="cmb2-disable ' . ( ( $escaped_value == '' || $escaped_value == 0 ) ? 'selected' : '' ) . '"><span>' . $label_off . '</span></label>';
	$switch .= '</div><!-- end switch div -->';
	$switch .= $field_type_object->_desc( true );

	// return $switch; // should this be echo?
	echo $switch;

}

add_action( 'cmb2_render_switch', 'js19_cmb2_render_switch', 10, 5 );
