<?php
//phpcs:disable Generic.ControlStructures.InlineControlStructure.NotAllowed
//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
/**
 * Create field type where the second field is chosen based on the result of the initial field.

 * @author Nick Mortensen
 * @package js19-custom
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
 * Create options for radio group 'jobStatus'.
 *
 * @param boolean $value Are there existing values?.
 * @return string $partner_options Options HTML.
 */
function get_jobstatus_options() {
	$statuses = (
		array(
			'complete' => 'Complete',
			'ongoing'  => 'Ongoing',
			'upcoming' => 'Upcoming',
		)
	);
	$checked        = '';
	$iterator       = 0;
	$status_options = '';
	foreach ( $statuses as $key => $value ) {
		// set the default value of the field to 'complete' - the option at index zero in the $statuses array.
		if ( 0 === $iterator ) {
			$checked = 'checked';
		}
		$status_options .= '<input type="radio" id="statusOption' . $iterator . '" value="statusOption' . $key . '" name="jobStatus" ' . $checked . '><label for="statusOption' . $iterator . '">' . $value . '</label>';
		$iterator++;
	}
	return $status_options;
}
/**
 * job status field and acoompanying text field
 *
 * @param [type] $field
 * @param [type] $value
 * @param [type] $object_id
 * @param [type] $object_type
 * @param [type] $field_type
 * @return void
 */
function render_jobstatus_field_callback( $field, $value, $object_id, $object_type, $field_type ) {
	$value = wp_parse_args(
		$value,
		array(
			'jobstatus' => 'jobStatus',
			'complete'  => 'statusComplete',
			'ongoing'   => 'statusOngoing',
			'upcoming'  => 'statusUpcoming',
		)
	);
	return '';
} ?>
<div id="projectStatusFields"></div>

/**
 * Render the job status field group.
 */
add_filter( 'cmb2_render_jobstatus', 'render_jobstatus_field_callback', 10, 5 );
