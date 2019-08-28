<?php
//phpcs:disable Generic.ControlStructures.InlineControlStructure.NotAllowed
//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
/**
 * Create field type of project partner using CMB2.

 * @author Nick Mortensen
 * @package projects
 * @license GPL-2.0+
 * @since 5.0.1
 */
function url_field_callback( $field ) {
	$id = $field->args( 'id' );
	echo '<h1>The ID is' . $id . '</h1>';
}
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
		$output           = '<option value="' . $abbrev . '" ' . esc_attr( selected( $value, $abbrev, false ) ) . '>' . $partnertype . '</option>';
		$partner_options .= $output;
	}
	return $partner_options;
}

/**
 * Render Address Field
 */
function render_partner_field_callback( $field, $value, $object_id, $object_type, $field_type ) {

	// make sure we specify each part of the value we need.
	$value = wp_parse_args(
		$value,
		array(
			'name' => '',
			'link' => '',
			'type' => '',
			'logo' => '',
		)
	);
	?>

	<div>

		<div class="alignleft">
			<label for="<?php echo $field_type->_id( '_type' ); ?>'">Type</label>
			<?php
			echo $field_type->select(
				array(
					'name'    => $field_type->_name( '[type]' ),
					'id'      => $field_type->_id( '_type' ),
					'options' => output_partner_type_options( $value['type'] ),
					'desc'    => '',
				)
			);
			?>
		</div><!-- end div#type -->
		<div>
			<label for="<?php echo $field_type->_id( '_name' ); ?>">Name</label>
			<?php
			echo $field_type->input(
				array(
					'name'  => $field_type->_name( '[name]' ),
					'id'    => $field_type->_id( '_name' ),
					'value' => $value['name'],
					'desc'  => '',

				)
			);
			?>
		</div><!-- end div#name -->
	</div>
	<div>
		<div class="alignleft">
		<label for="<?php echo $field_type->_id( '_link' ); ?>'">Link </label>
		<?php
		echo $field_type->input(
			array(
				'name'          => $field_type->_name( '[link]' ),
				'id'            => $field_type->_id( '_link' ),
				'value'         => $value['link'],
				'desc'          => '',
				'type'          => 'text_url',
				'render_row_cb' => 'url_field_callback',

			)
		);
		?>
		</div><!-- end div#link -->


		<div class="alignright">
			<label for="<?php echo $field_type->_id( '_logo' ); ?>'">Logo</label>
			<?php
			echo $field_type->input(
				array(
					'class'        => 'cmb_text_small',
					'name'         => $field_type->_name( '[logo]' ),
					'id'           => $field_type->_id( '_logo' ),
					'value'        => $value['logo'],
					'type'         => 'file',
					'desc'         => '',
					'text'         => array( 'add_upload_file_text' => 'Add SVG' ),
					'query_args'   => array( 'type' => 'image/svg+xml' ),
					'preview_size' => 'large',
				)
			);
			?>
		</div><!-- end div#logo -->
	</div>


<br>

	<br class="clear">
<?php
	// echo 'using project-location-field-type.php';

} // end def render_partner_field_callback( $field, $value, $object_id, $object_type, $field_type )

add_filter( 'cmb2_render_partner', 'render_partner_field_callback', 10, 5 );
