<?php
// phpcs:disable

//phpcs:disable Generic.ControlStructures.InlineControlStructure.NotAllowed
//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
function state_options( $value = false ) {
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


function capability_options( $value = false ) {
	$capability_option = array(
		'fab'     => 'Fabrication',
		'install' => 'Install',
		'pm'      => 'Project Management',
		'sales'   => 'Sales',
	);
	$capabilities = '';
	$order = 1;
	foreach ($capability_option as $abbreviation => $capability ) {
		$capabilities .= '<option value="' . esc_attr( $abbreviation ) . '" ' . esc_attr( selected( $value, $abbreviation, false ) ) . '>' . esc_html( $capability ) . '</option>';
	}

	return $capabilities;

}
/**
 * Render Address Field
 */
function render_jonesaddress_field_callback( $field, $value, $object_id, $object_type, $field_type ) {

	// make sure we specify each part of the value we need.
	$value = wp_parse_args(
		$value,
		array(
			'capability' => '',
			'footer' => '',
			'address' => '',
			'city'      => '',
			'state'     => '',
			'zip'       => '',
			'latitude'  => '',
			'longitude' => '',
			'cid'       => '',
		)
	);
?>

<section style="padding: 1vw;margin: 1vw;">
	<div>
	<label for="<?php echo $field_type->_id( '_capability' ); ?>'">capability</label>
		<?php
		echo $field_type->multicheck(
			array(
				'name'    => $field_type->_name( '[capability]' ),
				'id'      => $field_type->_id( '_capability' ),
				'type' => 'checkbox',
				'options' => (
					array(
						'fab'     => 'Fabrication',
						'install' => 'Install',
						'pm'      => 'Project Management',
						'sales'   => 'Sales',
					)
				),
			)
		);
		?>
	</div><!-- end div#address-->

	<div>
	<label for="<?php echo $field_type->_id( '_city' ); ?>'">City   </label>
	<?php
	echo $field_type->input(
		array(
			'class' => 'cmb_text_small',
			'name'  => $field_type->_name( '[city]' ),
			'id'    => $field_type->_id( '_city' ),
			'value' => $value['city'],
			'desc'  => '',
		)
	);
	?>


		<label for="<?php echo $field_type->_id( '_state' ); ?>'">State</label>
		<?php
		echo $field_type->select(
			array(
				'name'    => $field_type->_name( '[state]' ),
				'id'      => $field_type->_id( '_state' ),
				'options' => state_options( $value['state'] ),
				'desc'    => '',
			)
		);
		?>


		<label for="<?php echo $field_type->_id( '_zip' ); ?>'">Zip</label>
		<?php
		echo $field_type->input(
			array(
				'class' => 'cmb_text_small',
				'name'  => $field_type->_name( '[zip]' ),
				'id'    => $field_type->_id( '_zip' ),
				'value' => $value['zip'],
				'type'  => 'number',
				'desc'  => '',
			)
		);
		?>
<br>
		<label for="<?php echo $field_type->_id( '_latitude' ); ?>'">Latitude</label>
		<?php
		echo $field_type->input(
			array(
				'class' => 'cmb_text_small',
				'name'  => $field_type->_name( '[latitude]' ),
				'id'    => $field_type->_id( '_latitude' ),
				'value' => $value['latitude'],
				'desc'  => '',
			)
		);
		?>

		<label for="<?php echo $field_type->_id( '_longitude' ); ?>'">Longitude</label>
		<?php echo $field_type->input(
			array(
				'class' => 'cmb_text_small',
				'name'  => $field_type->_name( '[longitude]' ),
				'id'    => $field_type->_id( '_longitude' ),
				'value' => $value['longitude'],
			)
		);
		?>
<br>
		<label for="<?php echo $field_type->_id( '_cid' ); ?>'">Google CID Value</label>
		<?php echo $field_type->input(
			array(
				'class' => 'cmb_text_small',
				'name'  => $field_type->_name( '[cid]' ),
				'id'    => $field_type->_id( '_cid' ),
				'value' => $value['cid'],
			)
		);
		?>
	</div><!-- end div#googlecid -->


	<label for="<?php echo $field_type->_id( '_footer' ); ?>">Show Location Within Footer?</label>
		<?php
		echo $field_type->checkbox(
			array(
				'name'  => $field_type->_name( '[footer]' ),
				'id'    => $field_type->_id( '_footer' ),
				'value' => $value['footer'],
				'desc'  => '',
			)
		);
		?>
</section>
	<br class="clear">
<?php
	// echo $field_type->_desc( true );
echo 'refactored version';

} // end def render_address_field_callback( $field, $value, $object_id, $object_type, $field_type )

add_filter( 'cmb2_render_jonesaddress', 'render_jonesaddress_field_callback', 10, 5 );
