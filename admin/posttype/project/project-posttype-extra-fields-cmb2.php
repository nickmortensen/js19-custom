<?php
/**
 * Plugin Name: Projects
 * Plugin URI:  https://linkedin.com/learning
 * desc: Refactored Custom Project Posts and Fields Done in CMB2 to eventually Expose to the REST API.
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
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */

/**
 * Experimental label callback. Generic for the moment, I am just experimenting.
 *
 * @param array $field_args
 * @return void
 */
function use_label_callback( $field_args ) {
	$label = $field_args['name'];
	echo '<style> h3{ color: salmon;}</style>';
	echo '<h3>' . esc_html( $label ) . '</h3>';
}

/** SANITIZATION CALLBACK FOR THE JOB FOLDER FIELD
 *
 *  I WANT TO WRITE A CALLBACK FUNCTION THAT REPLACES ALL SPACES WITH AN ESCAPED SPACE
*/

/**
 * Handles escaping for the projectLocalFolder field for display.
 *
 * @param  mixed      $value      The unescaped value from the database.
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 *
 * @return mixed                  Escaped value to be displayed.
 */




/**
 * Hook in and add a projects metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function register_projects_metabox() {

	$prefix = 'project_';
	// Define the metabox itself. Fields will show up as $projects->add_field.
	$projects = new_cmb2_box(
		array(
			'context'                      => 'normal',
			'classes'                      => 'project-profile-metabox',
			'show_names'                   => true,
			'id'                           => $prefix . 'metabox',
			'title'                        => esc_html__( 'Project Overview', 'js19' ),
			'object_types'                 => array( 'project' ), // Post type. This metabox will only show up on project post type pages. Could be 'page', 'user', 'term', 'comment', or 'options page as well'.
			'cmb_styles'                   => true, // Disable cmb2 stylesheet by setting to false.
			'show_in_rest'                 => WP_REST_Server::ALLMETHODS, // WP_REST_Server::READABLE|WP_REST_Server::EDITABLE, // Determines which HTTP methods the box is visible in.
			// Optional callback to limit box visibility.
			// See: https://github.com/CMB2/CMB2/wiki/REST-API#permissions
			'get_box_permissions_check_cb' => 'projects_limit_rest_view_to_logged_in_users',
		)
	);

$args = array(
	'type' => 'switch',
	'desc' => 'testing the original',
	'id'   => 'projectSwitchTest',
	'name' => 'switch test',
	'value' => 'on'
);
$projects->add_field( $args );


$betterswitch_args = array(
	'type' => 'betterswitch',
	'desc' => 'testing',
	'id'   => 'projectBetterswitchTest',
	'name' => 'betterswitch test',
	'value' => 'on',
	'options' => array (
		'height' => 'six five'
	)
);
$projects->add_field( $betterswitch_args );


	$job_folder_args = array(
			'name' => 'Local Folder',
			'id'   => 'projectLocalFolder',
			'type' => 'text',
			'desc' => 'Where is the archive on the Jones Sign Internal Servers?',
	);
	$projects->add_field( $job_folder_args );

	// $partners_field_identifier = $projects->add_field(
	// 	array(
	// 		'id'      => 'projectPartnerGroupExperiment',
	// 		'type'    => 'group',
	// 		'desc'    => __( 'Partners', 'js19-custom' ),
	// 		'options' => array(
	// 			'group_title'    => __( 'Partner{#}', 'js19-custom' ),
	// 			'add_button'     => __( 'Add Additional Partner', 'js19-custom' ),
	// 			'remove_button'  => __( 'Remove Additional Partner', 'js19-custom' ),
	// 			'sortable'       => true,
	// 			'remove_confirm' => esc_html__( 'You Sure?', 'js19-custom' ),
	// 			'closed'         => true,
	// 		),
	// 	)
	// );

	// $types_of_partners   = array(
	// 	'architect' => 'Architect',
	// 	'gc'        => 'General Contractor',
	// 	'designer'  => 'SEGD Firm',
	// );
	// $projects->add_field(
	// 	// $partners_field_identifier,
	// 	array(
	// 		'name'             => 'type',
	// 		'id'               => 'projectPartnerType',
	// 		'type'             => 'select',
	// 		'desc'             => '',
	// 		'show_option_none' => true,
	// 		// 'default'       => 'custom',
	// 		'options'          => $types_of_partners,
	// 	)
	// );
	// $projects->add_field(
	// 	// $partners_field_identifier,
	// 	array(
	// 		'name' => 'name',
	// 		'id'   => 'projectPartnerName',
	// 		'type' => 'text',
	// 		'desc' => '',
	// 	)
	// );
	// $projects->add_field(
	// 	// $partners_field_identifier,
	// 	array(
	// 		'name' => 'link',
	// 		'id'   => 'projectPartnerLink',
	// 		'type' => 'text_url',
	// 		'desc' => 'link to the partner homepage',
	// 	)
	// );
	// $projects->add_field(
	// 	// $partners_field_identifier,
	// 	array(
	// 		'name' => 'logo',
	// 		'id'   => 'projectPartnerLogo',
	// 		'type' => 'file',
	// 		'desc' => 'company logo',
	// 	)
	// );

	// $projects->add_field(
	// 	array(
	// 		'attributes' => array(
	// 			'data-group' => 'partner',
	// 		),
	// 		'classes'      => 'experimental-row-class',
	// 		'label_cb'     => 'use_label_callback',
	// 		'show_names'   => 0,
	// 		'name'         => 'Partner',
	// 		'desc'         => '',
	// 		'default'      => '',
	// 		'id'           => 'projectPartner',
	// 		'type'         => 'partner',
	// 		'object_types' => array( 'project' ),
	// 		'after_row'    => '<hr>',
	// 	)
	// );
	/**
	 * Project Location is a cluster of fields that are defined as a single field type of 'address'.
	 * The field is defined in the ../../includes/project-location-field-type.php file.
	 *
	 * @todo Get some formatting in there so it isn't so ugly - flexbox maybe? Plut the field names in the inputs with javascript?  Something to make the alignment not be so godawful.
	 */
	$projects->add_field(
		array(
			// 'show_names'   => false,
			'name'         => 'Project Location',
			// 'desc'         => 'Project Address',
			'id'           => 'projectLocation', // Name of the custom field type we setup.
			'type'         => 'address',
			'object_types' => array( 'project' ), // Only show on project post types.
			'options'      => array(),

		)
	);

	$projects->add_field(
		array(
			'name'         => 'Quotation',
			'show_names'   => true,
			'type'         => 'quote',
			'default'      => '',
			'id'           => 'projectQuote',
			'options'      => array(),
			'object_types' => array( 'project' ), // Only show on project post types.
		)
	);

	/**
	 * Job Number: projectJobNumber: Small Text Field.
	 * Project Job Number.
	 */
	$projects->add_field(
		array(
			'name'         => 'Job#',
			'desc'         => 'Assigned Job Number',
			'default'      => '',
			'id'           => 'projectJobNumber',
			'type'         => 'text_small',
			'object_types' => array( 'project' ), // Only show on project post types.
			// 'column'       => array(
			// 'position' => 2,
			// 'name'     => 'Job #',
			// ),
			'before_row'   => '', // callback.
			'after_row'    => '<hr>',
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
			'name'         => 'Completed',
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
			'name'         => 'Expected',
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
			'name'         => 'Started',
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
			'class'        => 'input-full-width',
			'name'         => 'Tease',
			'desc'         => 'Brief Synopsis of the project. 140 characters or less.',
			'default'      => '',
			'id'           => 'projectTease',
			'type'         => 'text',
			'object_types' => array( 'project' ), // Only show on project post types.
		)
	);

	/**
	 * ID projectAltName: Returns string.
	 * The alternative name for this project.
	 */
	$projects->add_field(
		array(
			'class'        => 'input-full-width',
			'name'         => 'Alt',
			'desc'         => 'Is there an alternate name or client for this project?',
			'default'      => '',
			'id'           => 'projectAltName',
			'type'         => 'text',
			'object_types' => array( 'project' ), // Only show on project post types.
		)
	);

	/**
	 * ID projectSVGLogo. Returns URL.
	 * A client logo. Should be square and ideally SVG.
	 */
	$projects->add_field(
		array(
			'name'         => 'SVG',
			'desc'         => 'Upload a client SVG logo.',
			'id'           => 'projectSVGLogo',
			'type'         => 'file',
			'object_types' => array( 'project' ), // Only show this field on project post types.
			// Optional.
			'options'      => array(
				'url' => false, // Hide the text input for the url.
			),
			'text'         => array(
				'add_upload_file_text' => 'Add SVG', // Change upload button text. Default: "Add or Upload File".
			),
			// query_args are passed to wp.media's library query.
			'query_args'   => array(
				'type' => 'image/svg+xml', // Make library only display SVG.
			),
			'preview_size' => 'medium', // Image size to use when previewing in the admin.
		)
	);
	/**
	 * ID projectNarrative. Returns Text.
	 * 1 or 2 paragraphs about the project.
	 */
	$projects->add_field(
		array(
			'name'         => 'Narrative',
			'desc'         => 'Project Write Up / Narrative',
			'id'           => 'projectNarrative',
			'type'         => 'textarea_code',
			'object_types' => array( 'project' ), // Only show on project post types.
			// 'options'      => $states,
		)
	);

	/**
	 * Square Images for Slideshow?
	 *
	 * @todo It would be good to reduce the images to select from to ones that have height and width attributes that are equal. Figure that out.
	 */
	$projects->add_field(
		array(
			'name'         => 'Square',
			'desc'         => 'Add any images that have an equal height and width here.',
			'id'           => 'projectImagesSquare',
			'type'         => 'file_list',
			'preview_size' => array( 100, 100 ),
			'query_args'   => array( 'type' => 'image' ), // Only images attachmt.
			// Optional, override default text strings.
			'text'         => array(
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
			'name'         => '4x3',
			'desc'         => 'Typically 4x3',
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


} // End def function register_projects_metabox().

add_action( 'cmb2_init', 'register_projects_metabox' );
