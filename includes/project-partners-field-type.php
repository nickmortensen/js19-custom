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
function get_partner_options( $value = false ) {
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
 *
 * @param string $field html for field.
 * @param string $value The values of the fields. Start at ''.
 * @param integer $object_id Post ID these fields will attach to.
 * @param string $object_type Post type these fields should appear with.
 * @param string $field_type Type of field.
 * @return void
 */
function render_partner_field_callback( $field, $value, $object_id, $object_type, $field_type ) {
	$partner_fields = [ 'partner-name' => '', 'partner-type' => '', 'partner-link' => '', 'partner-logo' => '', ];
	$value          = wp_parse_args( $value, $partner_fields );

?>
	<!-- start partner-name -->
	<div>
		<label for="<?php echo $field_type->_id( '_partner_name' ); ?>">Partner Name</label>
		<?php
		echo $field_type->input(
			array(
				'name'  => $field_type->_name( '[partner-name]'),
				'id'    => $field_type->_id( '_partner_name' ),
				'value' => $value['partner-name'],
				'desc'  => '',
			)
		);
		?>
	</div>
	<!-- start partner-type-->
	<div>
		<label for="<?php echo $field_type->_id( '_partner_type' ); ?>">Partner Type</label>
		<?php
		echo $field_type->select(
			array(
				'name'  => $field_type->_name( '[partner-type]'),
				'id'    => $field_type->_id( '_partner_type' ),
				'options' => get_partner_options( $value['partner-type'] ),
				'desc'  => '',
			)
		);
		?>
	</div>
	<!-- start partner-link -->
	<div>
		<label for="<?php echo $field_type->_id( '_partner_link' ); ?>">Partner Link</label>
		<?php
		echo $field_type->input(
			array(
				'name'  => $field_type->_name( '[partner-link]'),
				'id'    => $field_type->_id( '_partner_link' ),
				'value' => $value['partner-link'],
				'desc'  => '',
			)
		);
		?>
	</div>
	<!-- start field partner-logo -->
	<div>
		<label for="<?php echo $field_type->_id( '_partner_logo' ); ?>">Partner Logo</label>
		<?php
		echo $field_type->file(
			array(
				'name'  => $field_type->_name( '[partner-logo]' ),
				'id'    => $field_type->_id( '_partner_logo' ),
				'value' => $value['partner-logo'],
				'desc'  => '',
				'text' => [ 'add_upload_file_text' => 'Add SVG' ],
				'query_args' => [ 'type' => 'image/svg+xml' ],
				'preview_size' => 'large',
			)
		);
		?>
	</div><!-- end field partner-logo -->
	<br class="clear">
<?php
} // end definition of render_partner_field_callback( $field, $value, $object_id, $object_type, $field_type ).
add_filter( 'cmb2_render_partner', 'render_partner_field_callback', 10, 5 );
