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


/* MEDIATYPE FUNCTIONS */
function js19_cmb2_mediatype_return_array() {
	$facetypes = array(
		'digital'          => __( ucwords( 'digital' ), 'js19' ),
		'digital_bulletin' => __( ucwords( 'digital bulletin' ), 'js19' ),
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

/**
 * Custom CMB2 css for mediattype field
 *
 * @return void
 */
function js19_cmb2_mediatype_radio_css() {
	static $added = false;
	if ( $added ) {
		return;
	}
	$added = true;
	?>
	<style type="text/css" media="screen">
		div.cmb-type-billboards > div > div > ul.cmb2-radio-list > li {
			display: inline;
			min-width: 142px;
			border: none;
		}
	</style>
	<?php
}
/* ======= END MEDIATYPE FUNCTIONS */

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
function cmb2_render_callback_for_billboards_field( $field, $value, $object_id, $object_type, $field_type_object ) {

	$directions      = [ 'north' => __( 'North', 'js19' ), 'west' => __( 'West', 'js19' ), 'east' => __( 'East', 'js19' ), 'south' => __( 'South', 'js19' ) ];
	$digital_markets = [ 'green_bay' => __( 'Green Bay', 'js19' ), 'fox_valley' => __( 'Fox Valley', 'js19' ), 'marathon' => __( 'Marathon', 'js19' ) ];
	$static_markets  = [ 'brown_depere' =>__( 'Brown-DePere', 'js19' ), 'brown_green bay' =>__( 'Brown-Green Bay', 'js19' ), 'brown_howard' =>__( 'Brown-Howard', 'js19' ), 'brown_lawrence' =>__( 'Brown-Lawrence', 'js19' ), 'brown_pittsfield' =>__( 'Brown-Pittsfield', 'js19' ), 'brown_pulaski' =>__( 'Brown-Pulaski', 'js19' ), 'brown_suamico' =>__( 'Brown-Suamico', 'js19' ), 'calumet_brillion' =>__( 'Calumet-Brillion', 'js19' ), 'calumet_chilton' =>__( 'Calumet-Chilton', 'js19' ), 'calumet_hilbert' =>__( 'Calumet-Hilbert', 'js19' ), 'columbia_columbus' =>__( 'Columbia-Columbus', 'js19' ), 'door_sturgeon bay' =>__( 'Door-Sturgeon Bay', 'js19' ), 'fonddulac' =>__( 'Fond du Lac', 'js19' ), 'north_fonddulac' =>__( 'Fond du Lac-North Fond du Lac', 'js19' ), 'kewaunee_kewaunee' =>__( 'Kewaunee-Kewaunee', 'js19' ), 'manitowoc_reedsville' =>__( 'Manitowoc-Reedsville', 'js19' ), 'marathon_wausau' =>__( 'Marathon-Wausau', 'js19' ), 'marinette' =>__( 'Marinette', 'js19' ), 'marinette_coleman' =>__( 'Marinette-Coleman', 'js19' ), 'marinette_crivitz' =>__( 'Marinette-Crivitz', 'js19' ), 'marquette_wisconsin_dells' =>__( 'Marquette-Wisconsin Dells', 'js19' ), 'monominee' =>__( 'Monominee', 'js19' ), 'oconto_abrams' =>__( 'Oconto-Abrams', 'js19' ), 'oconto_little_suamico' =>__( 'Oconto-Little Suamico', 'js19' ), 'oconto_oconto' =>__( 'Oconto-Oconto', 'js19' ), 'oconto_oconto_falls' =>__( 'Oconto-Oconto Falls', 'js19' ), 'outagamie_black_creek' =>__( 'Outagamie-Black Creek', 'js19' ), 'outagamie_buchanan' =>__( 'Outagamie-Buchanan', 'js19' ), 'outagamie_grand_chute' =>__( 'Outagamie-Grand Chute', 'js19' ), 'outagamie_kaukauna' =>__( 'Outagamie-Kaukauna', 'js19' ), 'outagamie_little_chute' =>__( 'Outagamie-Little Chute', 'js19' ), 'shawano_oconto falls' =>__( 'Shawano-Oconto Falls', 'js19' ), 'shawano_shawano' =>__( 'Shawano-Shawano', 'js19' ), 'waupaca' =>__( 'Waupaca', 'js19' ), 'winnebago_appleton' =>__( 'Winnebago-Appleton', 'js19' ), 'winnebago_neenah' =>__( 'Winnebago-Neenah', 'js19' ), 'winnebago_omro' =>__( 'Winnebago-Omro', 'js19' ), 'winnebago_oshkosh' =>__( 'Winnebago-Oshkosh', 'js19' ), 'wood_marshfield' =>__( 'Wood-Marshfield', 'js19' ) ];

	$value = wp_parse_args( $value, array(
		'substrate'   => '',
		'mediatype'     => '',
		'faceDirection' => 'north',
		'market'        => '',
		// 'latitude'      => 'the latitude',
		// 'longitude'     => 'the longitude',
		'illumination'  => 'illumination',
	));

?>




<?php

// js19_cmb2_mediatype_radio_attributes
// js19_cmb2_mediatype_radio_css
// js19_cmb2_mediatype_return_array
	add_filter( 'cmb2_list_input_attributes', 'js19_cmb2_mediatype_radio_attributes', 10, 4 );
	$field->args['options'] = js19_cmb2_mediatype_return_array();
	?>
	<!-- FACE TYPE -->
	<div id='choose_facetype' class="alignleft">
		<p><label for="<?php echo $field_type_object->_id( '_faceType' ); ?>">Face Type</label></p>
		<?php
				echo $field_type_object->radio();
				remove_filter( 'cmb2_list_input_attributes', 'js19_cmb2_mediatype_radio_attributes', 10, 4 );
				js19_cmb2_mediatype_radio_css();
		?>
	</div>

	<div>
		<!-- FACE DIRECTION SELECT -->
		<div id="facedirection" class="alignleft">
			<p>
				<label for="<?php echo $field_type_object->_id( '_faceDirection' ); ?>'">Face Direction</label>
			</p>
			<?php echo $field_type_object->select( array(
				'name'    => $field_type_object->_name( '[faceDirection]' ),
				'id'      => $field_type_object->_id( '_faceDirection' ),
				'options' => cmb2_callback_select_options( $value['faceDirection'], $options_array = $directions ),
				'desc'    => '',
			) ); ?>
		</div><!-- end div.alignleft -->

		<!-- MARKET SELECT -->
		<div id="market" class="alignright" style="padding-left:15px;">
			<p>
				<label for="<?php echo $field_type_object->_id( '_market' ); ?>'">Market</label>
			</p>

			<?php echo $field_type_object->select( array(
				'name'    => $field_type_object->_name( '[market]' ),
				'id'      => $field_type_object->_id( '_market' ),
				'options' => cmb2_callback_select_options( $value['market'], $options_array = $static_markets ),
				'desc'    => '',
			) ); ?>
		</div><!-- end div.alignright -->
	</div>

	<div id="illuminationType"class="alignleft"><p><label for="<?php echo $field_type_object->_id( '_illumination' ); ?>'">Illumination</label></p>
		<?php echo $field_type_object->input( array(
			'class' => 'cmb_text_small',
			'name'  => $field_type_object->_name( '[illumination]' ),
			'id'    => $field_type_object->_id( '_illumination' ),
			'desc'  => '',
		) ); ?>
	</div><!-- end div#illuminationtype -->
	<hr />

<?php

}
add_filter( 'cmb2_render_billboards', 'cmb2_render_callback_for_billboards_field', 10, 5 );


/* These are associative arrays of options */
$directions      = [ 'north' => __( 'North', 'js19' ), 'west' => __( 'West', 'js19' ), 'east' => __( 'East', 'js19' ), 'south' => __( 'South', 'js19' ) ];
$digital_markets = [ 'green_bay' => __( 'Green Bay', 'js19' ), 'fox_valley' => __( 'Fox Valley', 'js19' ), 'marathon' => __( 'Marathon', 'js19' ) ];
$static_markets  = [ 'brown_depere' =>__( 'Brown-DePere', 'js19' ), 'brown_green bay' =>__( 'Brown-Green Bay', 'js19' ), 'brown_howard' =>__( 'Brown-Howard', 'js19' ), 'brown_lawrence' =>__( 'Brown-Lawrence', 'js19' ), 'brown_pittsfield' =>__( 'Brown-Pittsfield', 'js19' ), 'brown_pulaski' =>__( 'Brown-Pulaski', 'js19' ), 'brown_suamico' =>__( 'Brown-Suamico', 'js19' ), 'calumet_brillion' =>__( 'Calumet-Brillion', 'js19' ), 'calumet_chilton' =>__( 'Calumet-Chilton', 'js19' ), 'calumet_hilbert' =>__( 'Calumet-Hilbert', 'js19' ), 'columbia_columbus' =>__( 'Columbia-Columbus', 'js19' ), 'door_sturgeon bay' =>__( 'Door-Sturgeon Bay', 'js19' ), 'fonddulac' =>__( 'Fond du Lac', 'js19' ), 'fonddulac-north_fond_du_lac' =>__( 'Fond du Lac-North Fond du Lac', 'js19' ), 'kewaunee_kewaunee' =>__( 'Kewaunee-Kewaunee', 'js19' ), 'manitowoc_reedsville' =>__( 'Manitowoc-Reedsville', 'js19' ), 'marathon_wausau' =>__( 'Marathon-Wausau', 'js19' ), 'marinette' =>__( 'Marinette', 'js19' ), 'marinette_coleman' =>__( 'Marinette-Coleman', 'js19' ), 'marinette_crivitz' =>__( 'Marinette-Crivitz', 'js19' ), 'marquette_wisconsin_dells' =>__( 'Marquette-Wisconsin Dells', 'js19' ), 'monominee' =>__( 'Monominee', 'js19' ), 'oconto_abrams' =>__( 'Oconto-Abrams', 'js19' ), 'oconto_little_suamico' =>__( 'Oconto-Little Suamico', 'js19' ), 'oconto_oconto' =>__( 'Oconto-Oconto', 'js19' ), 'oconto_oconto_falls' =>__( 'Oconto-Oconto Falls', 'js19' ), 'outagamie_black_creek' =>__( 'Outagamie-Black Creek', 'js19' ), 'outagamie_buchanan' =>__( 'Outagamie-Buchanan', 'js19' ), 'outagamie_grand_chute' =>__( 'Outagamie-Grand Chute', 'js19' ), 'outagamie_kaukauna' =>__( 'Outagamie-Kaukauna', 'js19' ), 'outagamie_little_chute' =>__( 'Outagamie-Little Chute', 'js19' ), 'shawano_oconto falls' =>__( 'Shawano-Oconto Falls', 'js19' ), 'shawano_shawano' =>__( 'Shawano-Shawano', 'js19' ), 'waupaca' =>__( 'Waupaca', 'js19' ), 'winnebago_appleton' =>__( 'Winnebago-Appleton', 'js19' ), 'winnebago_neenah' =>__( 'Winnebago-Neenah', 'js19' ), 'winnebago_omro' =>__( 'Winnebago-Omro', 'js19' ), 'winnebago_oshkosh' =>__( 'Winnebago-Oshkosh', 'js19' ), 'wood_marshfield' =>__( 'Wood-Marshfield', 'js19' ) ];
$substrates      = [ 'vinyl' => __( ucfirst( 'vinyl' ), 'js19' ), 'digital' => __( ucfirst( 'digital' ), 'js19' ) ];
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

