<?php
/**
 * Plugin Name: jsCustom
 * Plugin URI:  https://linkedin.com/learning
 * Description: Refactored Custom-to-Jones-Sign-Company Posttypes, Taxonomies, and Fields Done with CMB2 to eventually Expose to the REST API.
 * Version:     0.0.1
 * Author URI:  https://nickmortensen.com
 * Text Domain: jsCustom
 * Domain Path: /languages
 *
 * @author Nick Mortensen
 * @package jsCustom
 * @license GPL-2.0+
 * @since 5.0.1
 * @link https://github.com/CMB2/CMB2
 * @note This iteration of the plugin uses CMB2.
 */

/**
 * Callback for the locationState field.
 *
 * @param bool $value Whether the specific state should be the default.
 *
 * @return string $state_option HTML for all the options in the select dropdown.
 */
$states_array = array(
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

function dashicons_callback() {
	return "<span class=\"dashicons dashicons-format-gallery\" style=\"padding-right: 20px;font-size: 1.2rem;\"></span>";
}
/*
locationURL
locationWithinFooter
locationCapabilities
locationImage
locationPhone
locationAddress
locationCity
locationState
locationZip
locationLatitude
locationLongitude
locationGoogleCID
*/
/*
Location_capability locationCapabilities
jones_display_location_in_footer, locationWithinFooter
*/
add_action( 'cmb2_init', 'register_location_taxonomy_metabox' );

function add_these_classes( $field_args, $field ) {
	$classes = array( 'dont-show-description' );
	return $classes;
}

/**
 * Hook in and add a metabox to add fields to 'location' taxonomy terms
 */
function register_location_taxonomy_metabox() {
	// Establish prefeix.
	$prefix = '$location_';
	// Create an instance of the cmbs2box called $location.
	$location = new_cmb2_box(
		array(
			'id'                           => $prefix . 'edit',
			'title'                        => esc_html__( 'Location Taxonomy Extra Info', 'jsCustom' ),
			'object_types'                 => array( 'term' ), // indicate to cmb we are using terms and not posts.
			'taxonomies'                   => array( 'location' ), // Fields can be added to more than one taxonomy term, but we will limit these just to the signtype taxonomy term.
			'cmb_styles'                   => true, // Disable cmb2 stylesheet.
			'show_in_rest'                 => WP_REST_Server::ALLMETHODS, // WP_REST_Server::READABLE|WP_REST_Server::EDITABLE, // Determines which HTTP methods the box is visible in.
			// Optional callback to limit box visibility.
			// See: https://github.com/CMB2/CMB2/wiki/REST-API#permissions.
			'get_box_permissions_check_cb' => 'projects_limit_rest_view_to_logged_in_users',
			)
	);
	$location->add_field(
		array(
			'name'        => __( 'Website URL', 'cmb2' ),
			'description' => 'nimble website url',
			'id'          => 'locationURL',
			'type'        => 'text_url',
			'show_names'  => true,
			'classes_cb'  => 'add_these_classes',
			'protocols'   => ['http', 'https'],
			'attributes'  => (
				array(
					'placeholder' => 'http://jonessign.com',
					'data-fucking' => 'ConditionalFucking',
				)
			),
		)
	);

	/* CAPABILITIES OF THE LOCATION */
	$location->add_field(
		array(
			'name'              => 'Capability',
			'desc'              => 'check all that apply',
			'id'                => 'locationCapabilities',
			'type'              => 'multicheck',
			'inline'            => true,
			'select_all_button' => false,
			'options'           => array(
				'Fabrication'        => 'Fab',
				'Installation'       => 'Install',
				'Project Management' => 'PM',
				'Sales'              => 'Sales',
			),

		)
	);

	$location->add_field(
		array(
			'before'    => 'dashicons_callback',
			'name'      => 'Location Image',
			'show_names' => false,
			'desc'      => '',
			'id'        => 'locationImage',
			'type'      => 'file',
			'options'   => array(
				'url' => false, // No box that allows for the url to be typed in as I want to use the image ids.
			),
			'text'         => array(
				'add_upload_file_text' => 'Upload or Find Location Image',
			),
			// query_args are passed to wp.media's library query.
			'query_args'   => array(
				'type' => array(
					'image/jpg',
					'image/jpeg',
				),
			),
			'preview_size' => 'medium', // Image size to use when previewing in the admin.
		)
	);
	/* Location Phone */
	$location->add_field(
		array(
			'name'    => 'Phone',
			'desc'    => '',
			'default' => '',
			'id'      => 'locationPhone',
			'type'    => 'text_medium',
		)
	);
	/* Location Fax */
	$location->add_field(
		array(
			'name'    => 'Fax',
			'desc'    => '',
			'default' => '',
			'id'      => 'locationFax',
			'type'    => 'text_medium',
		)
	);
	/* Location Street Address */
	$location->add_field(
		array(
			'name'    => 'Address',
			'desc'    => '',
			'default' => '',
			'id'      => 'locationAddress',
			'type'    => 'text_medium',
		)
	);

	/* Location City */
	$location->add_field(
		array(
			'name'    => 'City',
			'desc'    => '',
			'default' => '',
			'id'      => 'locationCity',
			'type'    => 'text_medium',
		)
	);
	/* Location State */
	$location->add_field(
		array(
			'type'             => 'select',
			'default'          => 'custom',
			'name'             => 'State',
			'desc'             => '',
			'id'               => 'locationState',
			'show_option_none' => 'Select State',
			'options'          => array(
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
			),
		)
	);
	/* ENDLocation State */

	/* Location Zip */
	$location->add_field(
		array(
			'name'    => 'Zip',
			'desc'    => '',
			'default' => '',
			'id'      => 'locationZip',
			'type'    => 'text_medium',
		)
	);
	/* Location Latitude */
	$location->add_field(
		array(
			'name'    => 'latitude',
			'desc'    => '',
			'default' => '',
			'id'      => 'locationLatitude',
			'type'    => 'text_medium',
		)
	);
	/* Location Longitude */
	$location->add_field(
		array(
			'name'    => 'longitude',
			'desc'    => '',
			'default' => '',
			'id'      => 'locationLongitude',
			'type'    => 'text_medium',
		)
	);
		/* Location GoogleCID */
		$location->add_field(
			array(
				'name'    => 'Google CID',
				'desc'    => '',
				'default' => '',
				'id'      => 'locationGoogleCID',
				'type'    => 'text_medium',
			)
		);
		/* SHOW THIS FIELD IN FOOTER? */
		$location->add_field(
			array(
				'name'       => 'Footer',
				'desc'       => 'Show this location within the site footer',
				'id'         => 'locationWithinFooter',
				'type'       => 'checkbox',
				'show_names' => false,
			)
		);

} // End def function register_projects_metabox().
