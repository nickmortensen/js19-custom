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

$directions      = [ 'north' => __( 'North', 'js19' ), 'west' => __( 'West', 'js19' ), 'east' => __( 'East', 'js19' ), 'south' => __( 'South', 'js19' ) ];
$digital_markets = [ 'green_bay' => __( 'Green Bay', 'js19' ), 'fox_valley' => __( 'Fox Valley', 'js19' ), 'marathon' => __( 'Marathon', 'js19' ) ];
$static_markets  = [ 'brown_depere' =>__( 'Brown-DePere', 'js19' ), 'brown_green bay' =>__( 'Brown-Green Bay', 'js19' ), 'brown_howard' =>__( 'Brown-Howard', 'js19' ), 'brown_lawrence' =>__( 'Brown-Lawrence', 'js19' ), 'brown_pittsfield' =>__( 'Brown-Pittsfield', 'js19' ), 'brown_pulaski' =>__( 'Brown-Pulaski', 'js19' ), 'brown_suamico' =>__( 'Brown-Suamico', 'js19' ), 'calumet_brillion' =>__( 'Calumet-Brillion', 'js19' ), 'calumet_chilton' =>__( 'Calumet-Chilton', 'js19' ), 'calumet_hilbert' =>__( 'Calumet-Hilbert', 'js19' ), 'columbia_columbus' =>__( 'Columbia-Columbus', 'js19' ), 'door_sturgeon bay' =>__( 'Door-Sturgeon Bay', 'js19' ), 'fonddulac' =>__( 'Fond du Lac', 'js19' ), 'north_fonddulac' =>__( 'Fond du Lac-North Fond du Lac', 'js19' ), 'kewaunee_kewaunee' =>__( 'Kewaunee-Kewaunee', 'js19' ), 'manitowoc_reedsville' =>__( 'Manitowoc-Reedsville', 'js19' ), 'marathon_wausau' =>__( 'Marathon-Wausau', 'js19' ), 'marinette' =>__( 'Marinette', 'js19' ), 'marinette_coleman' =>__( 'Marinette-Coleman', 'js19' ), 'marinette_crivitz' =>__( 'Marinette-Crivitz', 'js19' ), 'marquette_wisconsin_dells' =>__( 'Marquette-Wisconsin Dells', 'js19' ), 'monominee' =>__( 'Monominee', 'js19' ), 'oconto_abrams' =>__( 'Oconto-Abrams', 'js19' ), 'oconto_little_suamico' =>__( 'Oconto-Little Suamico', 'js19' ), 'oconto_oconto' =>__( 'Oconto-Oconto', 'js19' ), 'oconto_oconto_falls' =>__( 'Oconto-Oconto Falls', 'js19' ), 'outagamie_black_creek' =>__( 'Outagamie-Black Creek', 'js19' ), 'outagamie_buchanan' =>__( 'Outagamie-Buchanan', 'js19' ), 'outagamie_grand_chute' =>__( 'Outagamie-Grand Chute', 'js19' ), 'outagamie_kaukauna' =>__( 'Outagamie-Kaukauna', 'js19' ), 'outagamie_little_chute' =>__( 'Outagamie-Little Chute', 'js19' ), 'shawano_oconto falls' =>__( 'Shawano-Oconto Falls', 'js19' ), 'shawano_shawano' =>__( 'Shawano-Shawano', 'js19' ), 'waupaca' =>__( 'Waupaca', 'js19' ), 'winnebago_appleton' =>__( 'Winnebago-Appleton', 'js19' ), 'winnebago_neenah' =>__( 'Winnebago-Neenah', 'js19' ), 'winnebago_omro' =>__( 'Winnebago-Omro', 'js19' ), 'winnebago_oshkosh' =>__( 'Winnebago-Oshkosh', 'js19' ), 'wood_marshfield' =>__( 'Wood-Marshfield', 'js19' ) ];
/* MEDIATYPE FUNCTIONS */
function js19_cmb2_mediatype_return_array() {
	$facetypes = array(
		// 'digital'          => __( ucwords( 'digital' ), 'js19' ),
		// 'digital_bulletin' => __( ucwords( 'digital bulletin' ), 'js19' ),
		'bulletin'         => __( ucwords( 'bulletin' ), 'js19' ),
		'junior_bulletin'  => __( ucwords( 'junior bulletin' ), 'js19' ),
		'trivision'        => __( ucwords( 'trivision' ), 'js19' ),
		'superscape'       => __( ucwords( 'superscape' ), 'js19' ),
	);
	return $facetypes;
}
/**
 * Custom labels for mediatype inputs
 *
 * @param  array $args
 * @param  array $defaults
 * @param  object $field
 * @param  object $cmb
 * @return array
 */
function js19_cmb2_mediatype_radio_attributes( $args, $defaults, $field, $cmb ) {
	if ( $args['value'] ) {
		$args['label'] = '<span class="mediatype ' . $args['value'] . '"></span>' . $args['label'];
	}
	return $args;
}