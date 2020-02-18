<?php
/**
 * Jones Sign Customizations Plugin
 *
 *  Billboard Fields
 *
 * @package JS19 Custom
 * @author Nick Mortensen
 * @since 5.0.2
 * @copyright 2019 Nick Mortensen
 * @license GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: JS19 Custom
 * Plugin URI: https://github.com/nickmortensen/js19-custom
 * Description: Custom post types & taxonomies for Jones Sign Company Websites.
 * Version: 1.0.2
 * Author: Nick Mortensen
 * Author URI:  http://nickmortensen.com
 * Text Domain: js19-custom
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Additonal functions file to keep this one clean.
require_once 'billboard-field-additional-functions/additional-functions.php';

/**
 * Add fields for billboards post type in custom layout.
 *
 * @param object $field The current CMB2_Field object.
 * @param string $escaped_value The value of this field passed through the escaping filter. It defaults to sanitize_text_field.
 * @param integer $object_id The id of the object you are working with. Most commonly, the post id.
 * @param string $object_type The type of object you are working with. Most commonly, post (this applies to all post-types), but could also be comment, user or options-page.
 * @param object $field_type_object  This is an instance of the CMB2_Types object and gives you access to all of the methods that CMB2 uses to build its field types.
 * @return void
 */





/* These are associative arrays of options */
$bb_type         = [ 'digital' => 'Digital', 'static' => 'Static'];
$substrates      = [ 'vinyl' => __( ucfirst( 'vinyl' ), 'js19' ), 'digital' => __( ucfirst( 'digital' ), 'js19' ) ];

$face_directions = [  ];
$digital_markets = [ 'green_bay' => __( 'Green Bay', 'js19' ), 'fox_valley' => __( 'Fox Valley', 'js19' ), 'marathon' => __( 'Marathon', 'js19' ) ];
$static_markets  = [ 'brown_depere' =>__( 'Brown-DePere', 'js19' ), 'brown_green bay' =>__( 'Brown-Green Bay', 'js19' ), 'brown_howard' =>__( 'Brown-Howard', 'js19' ), 'brown_lawrence' =>__( 'Brown-Lawrence', 'js19' ), 'brown_pittsfield' =>__( 'Brown-Pittsfield', 'js19' ), 'brown_pulaski' =>__( 'Brown-Pulaski', 'js19' ), 'brown_suamico' =>__( 'Brown-Suamico', 'js19' ), 'calumet_brillion' =>__( 'Calumet-Brillion', 'js19' ), 'calumet_chilton' =>__( 'Calumet-Chilton', 'js19' ), 'calumet_hilbert' =>__( 'Calumet-Hilbert', 'js19' ), 'columbia_columbus' =>__( 'Columbia-Columbus', 'js19' ), 'door_sturgeon bay' =>__( 'Door-Sturgeon Bay', 'js19' ), 'fonddulac' =>__( 'Fond du Lac', 'js19' ), 'fonddulac-north_fond_du_lac' =>__( 'Fond du Lac-North Fond du Lac', 'js19' ), 'kewaunee_kewaunee' =>__( 'Kewaunee-Kewaunee', 'js19' ), 'manitowoc_reedsville' =>__( 'Manitowoc-Reedsville', 'js19' ), 'marathon_wausau' =>__( 'Marathon-Wausau', 'js19' ), 'marinette' =>__( 'Marinette', 'js19' ), 'marinette_coleman' =>__( 'Marinette-Coleman', 'js19' ), 'marinette_crivitz' =>__( 'Marinette-Crivitz', 'js19' ), 'marquette_wisconsin_dells' =>__( 'Marquette-Wisconsin Dells', 'js19' ), 'monominee' =>__( 'Monominee', 'js19' ), 'oconto_abrams' =>__( 'Oconto-Abrams', 'js19' ), 'oconto_little_suamico' =>__( 'Oconto-Little Suamico', 'js19' ), 'oconto_oconto' =>__( 'Oconto-Oconto', 'js19' ), 'oconto_oconto_falls' =>__( 'Oconto-Oconto Falls', 'js19' ), 'outagamie_black_creek' =>__( 'Outagamie-Black Creek', 'js19' ), 'outagamie_buchanan' =>__( 'Outagamie-Buchanan', 'js19' ), 'outagamie_grand_chute' =>__( 'Outagamie-Grand Chute', 'js19' ), 'outagamie_kaukauna' =>__( 'Outagamie-Kaukauna', 'js19' ), 'outagamie_little_chute' =>__( 'Outagamie-Little Chute', 'js19' ), 'shawano_oconto falls' =>__( 'Shawano-Oconto Falls', 'js19' ), 'shawano_shawano' =>__( 'Shawano-Shawano', 'js19' ), 'waupaca' =>__( 'Waupaca', 'js19' ), 'winnebago_appleton' =>__( 'Winnebago-Appleton', 'js19' ), 'winnebago_neenah' =>__( 'Winnebago-Neenah', 'js19' ), 'winnebago_omro' =>__( 'Winnebago-Omro', 'js19' ), 'winnebago_oshkosh' =>__( 'Winnebago-Oshkosh', 'js19' ), 'wood_marshfield' =>__( 'Wood-Marshfield', 'js19' ) ];
/**
 * Returns options markup for a given select field.
 * @param mixed $value Selected/saved item.
 * @param array $options The given associative array to utilize in this function.
 * @return string html string containing all state options
 */
function cmb2_callback_select_options( $value = false, $options_array ) {
	$options = '';
	foreach ( $options_array as $key => $option ) {
		$options .= '<option value="'. $key . '" ' . selected( $value, $key, false ) . '>' . $option . '</option>';
	}
	return $options;
}

/* SUBSTRATE FIELD FUNCTIONS */
/**
 * Custom labels for substrate inputs
 *
 * @param  array $args
 * @param  array $defaults
 * @param  object $field
 * @param  object $cmb
 * @return array
 */
function js19_cmb2_substrate_radio_attributes( $args, $defaults, $field, $cmb ) {
	if ( $args['value'] ) {
		$args['label'] = '<span class="substrate' . $args['value'] . '"></span>' . $args['label'];
	}
	return $args;
}

function js19_cmb2_substrates_return_array() {
	$substrates      = array( 'vinyl' => __( ucfirst( 'vinyl' ), 'js19' ), 'digital' => __( ucfirst( 'digital' ), 'js19' ) );
	return $substrates;
}

/* ======= END SUBSTRATE FIELD FUNCTIONS */

