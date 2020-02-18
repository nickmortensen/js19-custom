<?php
/**
 * Creates a coordinates field. Two inputs for latitude and longitude.

 * @author Nick Mortensen
 * @package js19-custom
 * @license GPL-2.0+
 * @since 5.0.1
 * @link https://www.proy.info/how-to-create-cmb2-switch-field/
 */


if ( ! function_exists( 'js19_sanitize_coordinates_field' ) ) {
	/**
	 * Sanitize the data gotten from the coordinates field.
	 *
	 */
	function js19_sanitize_coordinates_field( $override_value, $value, $object_id, $field_args ) {

		$split = $field_args['split_values'];

		if ( isset ( $split ) && $split ) {
			if ( ! empty( $value['latitude'] ) ) {
				$latitude_field = $field_args['id'] . '_latitude';
				$latitude_data = $value['latitude'];
				update_post_meta( $object_id, $latitude_field, $latitude_data );
			}
			if ( ! empty( $value['longitude'] ) ) {
				$longitude_field = $field_args['id'] . '_longitude';
				$longitude_data = $value['longitude'];
				update_post_meta( $object_id, $longitude_field, $longitude_data );
			}
		}
	} // end def function js19_sanitize_coordinates_field.
	add_filter( 'cmb2_sanitize_coordinates', 'js19_sanitize_coordinates_field', 10, 4 );
} // end check if function sanitize_coordinates_field already exists.

/**
 * Adds a coordinates field in the array of field types for CMB2
 *
 * @param object  $field               The current CMB2_Field object.
 * @param string  $escaped_value      The value of this field passed through the escaping filter. It defaults to sanitize_text_field.
 * @param integer $object_id          The id of the object you are working with. Most commonly, the post id.
 * @param string  $object_type        The type of object you are working with. Most commonly, post (this applies to all post-types), but could also be comment, user or options-page.
 * @param object  $field_type_object   This is an instance of the CMB2_Types object and gives you access to all of the methods that CMB2 uses to build its field types.
 * @return void
 */
function js19_cmb2_render_coordinates( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
	$label = $field->args['label'] ?? [ 'first text field', 'second text field'];
	// Now we start building the outer div as well as the switch that it contains.
	$coordinates = '<div id="' . $field->args['_id'] . '">';
	$coordinates .= '<label>' . $label[0] . '</label>';
	$coordinates .= '<input type="text" id="coordinates_latitude" name="latitude" />';
	$coordinates .= '<label>' . $label[1] . '</label>';
	$coordinates .= '<input type="text" id="coordinates_longitude" name="longitude" />';
	$coordinates .= '</div>';
	$coordinates .= ! isset( $field->args['label'] ) ? '<p> set the label argument (array) to see custom labels</p>' : $field_type_object->_desc( true );

	// return $switch; // should this be echo?
	echo $coordinates;

}

add_action( 'cmb2_render_coordinates', 'js19_cmb2_render_coordinates', 10, 5 );
