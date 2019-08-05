<?php
/**
 * Plugin Name: Projects
 * Plugin URI:  https://linkedin.com/learning
 * Description: Refactored Custom Project Posts and Fields Done in CMB2 to eventually Expose to the REST API.
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
 *
 */

/**
 * Hook in and add a projects metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function register_projects_metabox() {

	$prefix = 'project_';
	// Define the metabox itself. Fields will show up as $projects->add_field.
	$projects = new_cmb2_box(
		array(
			'id'                           => $prefix . 'metabox',
			'title'                        => esc_html__( 'Project Profile Fields', 'jsCustom' ),
			'object_types'                 => array( 'project' ), // Post type
			'cmb_styles'                   => true, // Disable cmb2 stylesheet.
			'show_in_rest'                 => WP_REST_Server::ALLMETHODS, // WP_REST_Server::READABLE|WP_REST_Server::EDITABLE, // Determines which HTTP methods the box is visible in.
			// Optional callback to limit box visibility.
			// See: https://github.com/CMB2/CMB2/wiki/REST-API#permissions
			'get_box_permissions_check_cb' => 'projects_limit_rest_view_to_logged_in_users',
		)
	);
	/**
	 * Job Number: projectJobNumber: Small Text Field.
	 * Project Job Number.
	 */
	$projects->add_field(
		array(
			'name'         => 'Job #',
			'desc'         => 'Assigned Job Number',
			'default'      => '000000',
			'id'           => 'projectJobNumber',
			'type'         => 'text_small',
			'object_types' => array( 'project' ), // Only show on project post types.
			'column'       => array(
				'position' => 2,
				'name'     => 'Job #',
			),
		)
	);
	/**
	 * Status: jobStatus: radio_inline
	 * Status of job: upcoming, complete, ongoing.
	 * Javascript attached shows a field based on the radio box checked for the year a job was either started, comp[leted, or expected to complete
	 */
	$projects->add_field(
		array(
			'name'         => 'Status',
			'id'           => 'projectJobStatus',
			'type'         => 'radio_inline',
			'options'      => array(
				'complete' => __( 'Complete', 'jsCustom' ), // completion_year.
				'ongoing'  => __( 'Ongoing', 'jsCustom' ),  // completion_expected.
				'upcoming' => __( 'Upcoming', 'jsCustom' ), // year_started.
			),
			'default'      => 'complete',
			'object_types' => array( 'project' ), // Only show on project post types.
		)
	);
	/**
	 * Year Job was completed - dependent on choosing the 'complete' option from the 'jobStatus' field.
	 * Project Job Number.
	 *
	 */
	$projects->add_field(
		array(
			'name'         => 'Completed In',
			'desc'         => '4 digit year representing when this project completed',
			'default'      => '2019',
			'id'           => 'projectCompletedYear', // was 'jobYear' - alter that in your database.
			'type'         => 'text_small',
			'object_types' => array( 'project' ), // Only show on project post types.
			'attributes'   => array(
				'data-conditional-id'    => 'projectJobStatus', // the ID value of the field that needs to be selected in order for this one to show up.
				'data-conditional-value' => 'complete',
			),
		)
	);
	/**
	 * Year Job was started - dependent on choosing the 'ongoing' option from the 'jobStatus' field.
	 * Project Job Number.
	 */
	$projects->add_field(
		array(
			'name'         => 'Completion Expected',
			'desc'         => '4 digit year for when this upcoming project is expected to complete',
			'default'      => '2019',
			'id'           => 'projectExpectedCompletionYear', // was 'jobYear' - alter that in your database.
			'type'         => 'text_small',
			'object_types' => array( 'project' ), // Only show on project post types.
			'attributes'   => array(
				'data-conditional-id'    => 'projectJobStatus', // the ID value of the field that needs to be selected in order for this one to show up.
				'data-conditional-value' => 'upcoming',
			),
		)
	);
	/**
	 * Year Job was started - dependent on choosing the 'ongoing' option from the 'projectJobStatus' field.
	 */
	$projects->add_field(
		array(
			'name'         => 'Year Started',
			'desc'         => '4 digit year of when we started working on this ongoing project',
			'default'      => '2019',
			'id'           => 'projectYearStarted',
			'type'         => 'text_small',
			'object_types' => array( 'project' ), // Only show on project post types.
			'attributes'   => array(
				'data-conditional-id'    => 'projectJobStatus', // the ID value of the field that needs to be selected in order for this one to show up.
				'data-conditional-value' => 'ongoing',
			),
		)
	);
	/**
	 * Teaser Field: Text Field.
	 * 140 characters or less summing up the project.
	 */
	$projects->add_field(
		array(
			'name'         => 'Tease',
			'desc'         => 'Brief Synopsis of the project. 140 characters or less.',
			'default'      => '',
			'id'           => 'projectTease',
			'type'         => 'text',
			'object_types' => array( 'project' ), // Only show on project post types.
		)
	);

	/**
	 * Project Alternate Name: Text Field.
	 * Did the project have an alternate name?
	 */
	$projects->add_field(
		array(
			'name'         => 'Alt. Name',
			'desc'         => 'Is there an alternate name or client for this project?',
			'default'      => '',
			'id'           => 'projectAltName',
			'type'         => 'text',
			'object_types' => array( 'project' ), // Only show on project post types.
		)
	);

	/**
	 * SVGLogo: file.
	 * A client logo. Should be square and ideally SVG.
	 */
	$projects->add_field(
		array(
			'name'         => 'SVG Logo',
			'desc'         => 'Upload a client SVG logo.',
			'id'           => 'projectSVGLogo',
			'type'         => 'file',
			'object_types' => array( 'project' ), // Only show this field on project post types.
			// Optional.
			'options' => array(
				'url' => false, // Hide the text input for the url.
			),
			'text'    => array(
				'add_upload_file_text' => 'Add SVG', // Change upload button text. Default: "Add or Upload File".
			),
			// query_args are passed to wp.media's library query.
			'query_args' => array (
				'type' => 'image/svg+xml', // Make library only display SVG.
			),
			'preview_size' => 'medium', // Image size to use when previewing in the admin.
		)
	);
	/**
	 * Project Narrative: narrative
	 */
	$projects->add_field(
		array(
			'name'         => 'Narrative',
			'desc'         => 'Project Write Up / Narrative',
			'id'           => 'projectNarrative',
			'type'         => 'textarea_code',
			'object_types' => array( 'project' ), // Only show on project post types.
			'options'      => $states,
		)
	);

	/**
	 * Square Images for Slideshow?
	 *
	 * @todo It would be good to reduce the images to select from to ones that have height and width attributes that are equal. Figure that out.
	 */
	$projects->add_field(
		array(
			'name'         => 'Square Images',
			'desc'         => 'Add any images that have an equal height and width here.',
			'id'           => 'projectImagesSquare',
			'type'         => 'file_list',
			'preview_size' => array( 100, 100 ),
			'query_args'   => array( 'type' => 'image' ), // Only images attachmt.
			// Optional, override default text strings.
			'text'         => array (
				'add_upload_files_text' => 'Add Images',
				'remove_image_text'     => 'Remove',
				'file_text'             => 'Files:',
				'file_download_text'    => 'DL',
				'remove_text'           => 'ReplaceREMOVE', // default: "Remove".
			),
		)
	);

	/**
	 * 4x3 Images for Slideshow
	 */
	$projects->add_field(
		array(
			'name'         => 'Slideshow Images',
			'desc'         => 'slideshow images',
			'id'           => 'projectImagesSlideshow',
			'type'         => 'file_list',
			'preview_size' => array( 200, 150 ), // Default: 50, 50.
			'query_args'   => array( 'type' => 'image' ), // Only images attachmt.
			// Optional, override default text strings.
			'text'         => array(
				'add_upload_files_text' => 'Add slides', // default: "Add or Upload Files"
				'remove_image_text'     => 'Remove', // default: "Remove Image"
				'file_text'             => 'Files:', // default: "File:"
				'file_download_text'    => 'DL', // default: "Download"
				'remove_text'           => 'ReplaceREMOVE', // default: "Remove"
			),
		)
	);
	/**
	 * ProjectLocation: City
	 */

	$projects->add_field(
		array(

			'name' => 'City',
			'desc' => 'City',
			'id'   => 'projectLocation_city',
			'type' => 'text',
		)
	);

	/**
	 * Project Location - State
	 */
	$projects->add_field(
		array(
			'name'    => 'state',
			'desc'    => 'choose the state',
			'id'      => 'projectLocation_state',
			'type'    => 'select',
			'options' => array(
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
		),
	);
	/**
	 * Project Location is a cluster of fields that are defined as a single field type of 'address'.
	 *
	 * @todo Get some formatting in there so it isn't so ugly - flexbox maybe? Plut the field names in the inputs with javascript?  Something to make the alignment not be so godawful.
	 */
	$projects->add_field(
		array(
			'name'         => 'Project Location',
			'desc'         => 'Project Address',
			'id'           => 'projectLocation',
			'type'         => 'address',
			'object_types' => array( 'project' ), // Only show on project post types.
			'options'      => array(),
		)
	);

	/**
	 * Establish the types of project partners for the selection field options.
	 *
	 * @param boolean $value
	 * @return string $partner_options  HTML containing the options fields for the field labeled partner type.
	 */
	function get_partner_types( $value = false ) {
		// Establish an associative array of the partner types. This isn't by any means finished. I cannot think of any more partner types offhand, however.
		$partnertypes    = array(
			'architect' => 'Architect',
			'gc'        => 'General Contractor',
			'designer'  => 'SEGD Firm',
		);
		$partner_options = '';
		// Keys will serve as the value attribute and the values will serve as the output.
		foreach ( $partnertypes as $abbrev => $partnertype ) {
			$output           = '<option value="';
			$output          .= esc_attr( $abbrev );
			$output          .= '" ';
			$output          .= selected( $value, $abbrev, false );
			$output          .= '>';
			$output          .= esc_html( $partnertype );
			$output          .= '</option>';
			$partner_options .= $output;
		}
		return $partner_options;
	}

	$partners_group_field = $projects->add_field(
		array(
			'id'          => 'partnerInformation',
			'type'        => 'group', // Several fields grouped together.
			'description' => '',
			'options'     => array(
				'group_title'    => 'Project Partner {#}',
				'add_button'     => 'Additional Partners',
				'remove_button'  => 'Remove This Partner',
				'sortable'       => true,
				'closed'         => 'true',
				'remove_confirm' => 'Are you sure you want to remove this partner?',
			),
		)
	);
	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$projects->add_group_field(
		$partners_group_field,
		array(
			'name' => 'Partner Name',
			'id'   => 'partnerName',
			'type' => 'text',
		)
	);
	$projects->add_group_field(
		$partners_group_field,
		array(
			'name'    => 'Partner Type',
			'id'      => 'partnerType',
			'type'    => 'select',
			'options' => get_partner_types( 'partner-types' ), // Callback function written 50 lines above. Populates select options.
		)
	);
	$projects->add_group_field(
		$partners_group_field,
		array(
			'name' => 'Partner Link',
			'id'   => 'partnerLink',
			'desc' => 'Link to partner page',
			'type' => 'text_url',
		)
	);
	$projects->add_group_field(
		$partners_group_field,
		array(
			'name'         => 'Partner Logo',
			'id'           => 'partnerogo',
			'desc'         => 'Partner Logo',
			'type'         => 'file',
			'text'         => [ 'add_upload_file_text' => 'Add SVG' ],
			'query_args'   => [ 'type' => 'image/svg+xml' ],
			'preview_size' => 'large',
		)
	);

} // End def function register_projects_metabox().

add_action( 'cmb2_init', 'register_projects_metabox' );
