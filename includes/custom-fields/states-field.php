<?php


//phpcs:disable Generic.ControlStructures.InlineControlStructure.NotAllowed
//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
function us_states( $value = false ) {
	$states = array(
		'AL' => 'Alabama',
		'AK' => 'Alaska',
		'AZ' => 'Arizona',
		'AR' => 'Arkansas',
		'CA' => 'California',
		'CO' => 'Colorado',
		'CT' => 'Connecticut',
		'DE' => 'Delaware',
		'DC' => 'District Of Columbia',
		'FL' => 'Florida',
		'GA' => 'Georgia',
		'HI' => 'Hawaii',
		'ID' => 'Idaho',
		'IL' => 'Illinois',
		'IN' => 'Indiana',
		'IA' => 'Iowa',
		'KS' => 'Kansas',
		'KY' => 'Kentucky',
		'LA' => 'Louisiana',
		'ME' => 'Maine',
		'MD' => 'Maryland',
		'MA' => 'Massachusetts',
		'MI' => 'Michigan',
		'MN' => 'Minnesota',
		'MS' => 'Mississippi',
		'MO' => 'Missouri',
		'MT' => 'Montana',
		'NE' => 'Nebraska',
		'NV' => 'Nevada',
		'NH' => 'New Hampshire',
		'NJ' => 'New Jersey',
		'NM' => 'New Mexico',
		'NY' => 'New York',
		'NC' => 'North Carolina',
		'ND' => 'North Dakota',
		'OH' => 'Ohio',
		'OK' => 'Oklahoma',
		'OR' => 'Oregon',
		'PA' => 'Pennsylvania',
		'RI' => 'Rhode Island',
		'SC' => 'South Carolina',
		'SD' => 'South Dakota',
		'TN' => 'Tennessee',
		'TX' => 'Texas',
		'UT' => 'Utah',
		'VT' => 'Vermont',
		'VA' => 'Virginia',
		'WA' => 'Washington',
		'WV' => 'West Virginia',
		'WI' => 'Wisconsin',
		'WY' => 'Wyoming',
	);
	$state_option = '';
	foreach ( $states as $abrev => $state ) {
		$state_option .= '<option value="' . esc_attr( $abrev ) . '" ' . esc_attr( selected( $value, $abrev, false ) ) . '>' . esc_html( $state ) . '</option>';
	}
	return $state_option;
}

/**
 * Render States Field
 */
function render_states_field_callback( $field, $value, $object_id, $object_type, $field_type ) {

	// make sure we specify each part of the value we need.
	$value = wp_parse_args(
		$value,
		array(
			'state'     => '',
	);
?>

<div class="alignleft">
		<label for="<?php echo $field_type->_id( '_state' ); ?>'">State</label>
		<?php
		echo $field_type->select(
			array(
				'name'    => $field_type->_name( '[state]' ),
				'id'      => $field_type->_id( '_state' ),
				'options' => get_state_options( $value['state'] ),
				'desc'    => '',
			)
		);
		?>
	</div><!-- end div#state -->



<?php
	// echo $field_type->_desc( true );
	echo "states";

} // end def render_states_field_callback( $field, $value, $object_id, $object_type, $field_type )

add_filter( 'cmb2_render_states', 'render_states_field_callback', 10, 5 );
