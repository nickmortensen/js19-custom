<?php


//phpcs:disable Generic.ControlStructures.InlineControlStructure.NotAllowed
//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
function get_state_options( $value = false ) {
	$states = array(
		'NONE' => 'Select a State',
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
 * Render Address Field
 */
function render_address_field_callback( $field, $value, $object_id, $object_type, $field_type ) {

	// make sure we specify each part of the value we need.
	$value = wp_parse_args(
		$value,
		array(
			'address-1' => '',
			'city'      => '',
			'state'     => '',
			'zip'       => '',
			'latitude'  => '',
			'longitude' => '',
		)
	);
?>

	<div>
		<label for="<?php echo $field_type->_id( '_address_1' ); ?>">Address</label>
		<?php
		echo $field_type->input(
			array(
				'name'  => $field_type->_name( '[address-1]' ),
				'id'    => $field_type->_id( '_address_1' ),
				'value' => $value['address-1'],
				'desc'  => '',

			)
		);
		?>
	</div><!-- end div#address-1 -->

	<div>
	<label for="<?php echo $field_type->_id( '_city' ); ?>'">City</label>
	<?php
	echo $field_type->input(
		array(
			'name'  => $field_type->_name( '[city]' ),
			'id'    => $field_type->_id( '_city' ),
			'value' => $value['city'],
			'desc'  => '',
		)
	);
	?>
	</div><!-- end div#city -->
	<div>
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

	<div>
		<label for="<?php echo $field_type->_id( '_zip' ); ?>'">Zip</label>
		<?php
		echo $field_type->input(
			array(
				'name'  => $field_type->_name( '[zip]' ),
				'id'    => $field_type->_id( '_zip' ),
				'value' => $value['zip'],
				'type'  => 'number',
				'desc'  => '',
			)
		);
		?>
	</div><!-- end div#zip -->

	<div>
		<label for="<?php echo $field_type->_id( '_latitude' ); ?>'">Latitude</label>
		<?php
		echo $field_type->input(
			array(
				'name'  => $field_type->_name( '[latitude]' ),
				'id'    => $field_type->_id( '_latitude' ),
				'value' => $value['latitude'],
				'desc'  => '',
			)
		);
		?>
	</div><!-- end div#latitude -->
	<div>
		<label for="<?php echo $field_type->_id( '_longitude' ); ?>'">Longitude</label>
		<?php echo $field_type->input(
			array(
				'name'  => $field_type->_name( '[longitude]' ),
				'id'    => $field_type->_id( '_longitude' ),
				'value' => $value['longitude'],
			)
		);
		?>
	</div><!-- end div#longitude -->


<?php
	// echo 'using project-location-field-type.php';

} // end def render_address_field_callback( $field, $value, $object_id, $object_type, $field_type )

add_filter( 'cmb2_render_address', 'render_address_field_callback', 10, 5 );
