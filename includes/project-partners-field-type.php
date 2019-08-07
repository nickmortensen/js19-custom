<?php
/**
 * Create field type of project partner using CMB2.

 * @author Nick Mortensen
 * @package projects
 * @license GPL-2.0+
 * @since 5.0.1
 */

//phpcs:disable Generic.ControlStructures.InlineControlStructure.NotAllowed
//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
/**
 * Create options for select field 'partner_type'.
 *
 * @param boolean $value Are there existing values?.
 * @return string $partner_options Options HTML.
 */
function output_partner_type_options( $value = false ) {
	$partnertypes   = array(
		'architect' => 'Architect',
		'gc'        => 'General Contractor',
		'designer'  => 'SEGD Firm',
	);
	$partner_options = '';
	foreach ( $partnertypes as $abbrev => $partnertype ) {
		$output           = '<option value="';
		$output          .= $abbrev;
		$output          .= '" ';
		$output          .= selected( $value, $abbrev, false );
		$output          .= '>';
		$output          .= $partnertype;
		$output          .= '</option>';
		$partner_options .= $output;
	}
	return $partner_options;
}

/**
 * Render out the partner fields.
 * This field type is now called 'partner'.
 *
 * @param string  $field The current CMB2_Field object.
 * @param string  $value The value of this field passed through the escaping filter. It defaults to sanitize_text_field. If you need the unescaped value, you can access it via $field_type_object->value().
 * @param integer $object_id The id of the object you are working with. Most commonly, the post id.
 * @param string  $object_type Post type these fields should appear with.
 * @param string  $field_type This is an instance of the CMB2_Types object and gives you access to all of the methods that CMB2 uses to build its field types.
 * @return void
 */
function cmb2_render_callback_for_partner_field( $field, $value, $object_id, $object_type, $field_type ) {
	// Include all the fields we will be using within the field type.
	$partner_fields = array(
		'partner-name' => '',
		'partner-type' => '',
		'partner-link' => '',
		'partner-logo' => '',
	);
	$value          = wp_parse_args( $value, $partner_fields );
	?>
	<!-- HTML Output of the fields starts here. -->
	<div>
		<label for="<?php echo $field_type->_id( 'partnerName' ); ?>">Partner Name</label>
		<?php
		echo $field_type->input(
			array(
				'name'  => $field_type->_name( '[partner-name]' ),
				'id'    => $field_type->_id( 'partnerName' ),
				'value' => $value['partner-name'],
				'desc'  => '',
			)
		);
		?>
	</div><!-- End partnerName field -->
	<!-- start partnerType field-->
	<div>
		<label for="<?php echo $field_type->_id( 'partnerType' ); ?>">Partner Type</label>
		<?php
		echo $field_type->select(
			array(
				'name'    => $field_type->_name( '[partner-type]' ),
				'id'      => $field_type->_id( 'partnerType' ),
				'options' => output_partner_type_options( $value['partner-type'] ),
				'desc'    => '',
			)
		);
		?>
	</div><!-- End partnerType field-->
	<!-- Start partnerLink field -->
	<div>
		<label for="<?php echo $field_type->_id( 'partnerLink' ); ?>">Partner Link</label>
		<?php
		echo $field_type->input(
			array(
				'name'  => $field_type->_name( '[partner-link]' ),
				'id'    => $field_type->_id( 'partnerLink' ),
				'value' => $value['partner-link'],
				'desc'  => '',
			)
		);
		?>
	</div><!-- End partnerLink field -->
	<!-- Start partnerLogo field -->
	<div>
		<label for="<?php echo $field_type->_id( 'partnerLogo' ); ?>">Partner Logo</label>
		<?php
		echo $field_type->file(
			array(
				'name'         => $field_type->_name( '[partner-logo]' ),
				'id'           => $field_type->_id( 'partnerLogo' ),
				'value'        => $value['partner-logo'],
				'desc'         => '',
				'text'         => [ 'add_upload_file_text' => 'Add SVG' ],
				'query_args'   => [ 'type'                 => 'image/svg+xml' ],
				'preview_size' => 'large',
			)
		);
		?>
	</div><!-- END partnerLogo field -->
	<br class="clear">
	<?php
}
// end definition of cmb2_render_callback_for_partner_field function.
// Creates a hook to output the partner field - which consists of other fields as well.
// The 5 at the end is the number of arguments in the cmb2_render_callback_for_partner_field function as defined.
add_filter( 'cmb2_render_partner', 'cmb2_render_callback_for_partner_field', 10, 5 );
