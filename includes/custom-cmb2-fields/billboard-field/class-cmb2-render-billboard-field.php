<?php
/**
 * Handles all the fields for a billboard post type.
 *
 * @author Nick Mortensen
 * @package js19-custom
 * @license GPL-2.0+
 * @since 5.0.1
 * @link https://www.proy.info/how-to-create-cmb2-switch-field/
 * @link https://github.com/themevan/CMB2-Switch-Button/blob/master/cmb2-switch-button.php
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists ( 'CMB2_Render_Billboard_Field' ) ) {

	class CMB2_Render_Billboard_Field extends CMB2_Type_Base {
		// Jones Outdoor only has the two types.
		protected static $billboard_types = array( 'digital' => 'Digital', 'static' => 'Static' );
		// What a billboard can be printed onto (or is digital)
		protected static $substrates      = array( 'vinyl' => 'Vinyl', 'digital' => 'Digital' );
		// What directions the specific face faces.
		protected static $directions      = array( 'north' => 'North', 'west' => 'West', 'east' => 'East', 'south' => 'South' );
		protected static $digital_markets = array( 'green_bay' => 'Green Bay', 'fox_valley' => 'Fox Valley', 'marathon' => 'Marathon'  );
		protected static $static_markets  = array( 'brown_depere' => 'Brown-DePere', 'brown_green bay' => 'Brown-Green Bay', 'brown_howard' => 'Brown-Howard', 'brown_lawrence' => 'Brown-Lawrence', 'brown_pittsfield' => 'Brown-Pittsfield', 'brown_pulaski' => 'Brown-Pulaski', 'brown_suamico' => 'Brown-Suamico', 'calumet_brillion' => 'Calumet-Brillion', 'calumet_chilton' => 'Calumet-Chilton', 'calumet_hilbert' => 'Calumet-Hilbert', 'columbia_columbus' => 'Columbia-Columbus', 'door_sturgeon bay' => 'Door-Sturgeon Bay', 'fonddulac' => 'Fond du Lac', 'fonddulac-north_fond_du_lac' => 'Fond du Lac-North Fond du Lac', 'kewaunee_kewaunee' => 'Kewaunee-Kewaunee', 'manitowoc_reedsville' => 'Manitowoc-Reedsville', 'marathon_wausau' => 'Marathon-Wausau', 'marinette' => 'Marinette', 'marinette_coleman' => 'Marinette-Coleman', 'marinette_crivitz' => 'Marinette-Crivitz', 'marquette_wisconsin_dells' => 'Marquette-Wisconsin Dells', 'monominee' => 'Monominee', 'oconto_abrams' => 'Oconto-Abrams', 'oconto_little_suamico' => 'Oconto-Little Suamico', 'oconto_oconto' => 'Oconto-Oconto', 'oconto_oconto_falls' => 'Oconto-Oconto Falls', 'outagamie_black_creek' => 'Outagamie-Black Creek', 'outagamie_buchanan' => 'Outagamie-Buchanan', 'outagamie_grand_chute' => 'Outagamie-Grand Chute', 'outagamie_kaukauna' => 'Outagamie-Kaukauna', 'outagamie_little_chute' => 'Outagamie-Little Chute', 'shawano_oconto falls' => 'Shawano-Oconto Falls', 'shawano_shawano' => 'Shawano-Shawano', 'waupaca' => 'Waupaca', 'winnebago_appleton' => 'Winnebago-Appleton', 'winnebago_neenah' => 'Winnebago-Neenah', 'winnebago_omro' => 'Winnebago-Omro', 'winnebago_oshkosh' => 'Winnebago-Oshkosh', 'wood_marshfield' => 'Wood-Marshfield' );

		public static function init() {
			add_filter( 'cmb2_render_class_billboard', array( __CLASS__, 'class_name' ) );
			add_filter( 'cmb2_sanitize_billboard', array( __CLASS__, 'maybe_save_split_values' ), 12, 4);
			/**
			 * NEED THE FIOLLOWING IF I WANT THE FIELD TO BE REPEATABLE - I DON't But the mental exercise is enriching on an intrinsic level
			 */
			add_filter( 'cmb2_sanitize_billboard', array( __CLASS__, 'sanitize' ), 10, 5 );
			add_filter( 'cmb2_types_esc_billboard', array( __CLASS__, 'escape' ), 10, 4);
			add_filter( 'cmb2_override_meta_value', array( __CLASS__, 'get_split_meta_value' ), 12, 4);
		} // end init()

		// This should come in handy to retrieve the class name.
		public static function class_name() {
			return __CLASS__;
		}

		/**
		 * This function handles ouputtingthe billboard field.
		 */
		public function render() {
			// Assign each part of the value that we need to render.
			wp_parse_args( $this->field->escaped_value(), array(
				'type'         => '',
				'dimensions'   => '',
				'description'  => '',
				'id'           => '',
				'substrate'    => '',
				'direction'    => '',
				'illumination' => '',
				'latitude'     => '',
				'longitude'    => '',
			) );


			ob_start();
			// The HTML for the many fields goes here.
			?>
			<div id="billboard-fields">
				<span>
					<label for="<?php echo $this->_id( '_type', false ); ?>">
					<?php echo esc_html( $this->_text( 'type_text', 'Billboard Type' ) ); ?>
					</label>
				</span>
			</div> <!-- end div#billboard-fields-->
			<?php


		} // end render() definition.


	} // end definition of CMB2_Render_Billboard_Field class.

} // end check to see if class already exists.