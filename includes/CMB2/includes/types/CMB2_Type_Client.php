<?php
/**
 * CMB field grouping type of client
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   CMB2
 * @author    Nick Mortensen
 * @license   GPL-2.0+
 * @link      https://cmb2.io
 */
class CMB2_Type_Client extends CMB2_Type_Base {
	/**
	 * Directions - baseline array for when you want to have a select option.
	 *
	 * @var array
	 */
	protected static $directions = array( 'north' => 'North United States', 'south' => 'South United States', 'east' => 'East United States', 'west' => 'West United States', );
	public static function init() {
		add_filter( 'cmb2_render_class_client', [ __CLASS__, 'class_name' ] );
		add_filter( 'cmb2_sanitize_client', array( __CLASS__, 'maybe_save_split_values' ), 12, 4 );
		/**
		 * In the event we'd like the field to be repeatable.
		 */
		add_filter( 'cmb2_sanitize_client', array( __CLASS__, 'sanitize' ), 10, 5);
		add_filter( 'cmb2_types_esc_client', array(  __CLASS__, 'escape' ), 10, 4);
		add_filter( 'cmb2_override_meta_value', array(  __CLASS__, 'get_split_meta_value' ), 12, 4);
	}
	/**
	 * Return the class name using the __CLASS__ magig method
	 */
	public static function class_name() {
		return __CLASS__;
	}
	protected static $client_fields = [ 'website', 'ticker', 'corporate_location', 'photo' ];
	/**
	 * Output the client field.
	 */
	public function render() {
		// list the field id names.
		$fields_array = array_fill_keys( self::$client_fields, '' );
		$value        = wp_parse_args( $this->field->escaped_value(), $fields_array );

		ob_start();
		// Do the HTML.
		?>
		<!-- web url -->
		<div>
			<label for="<?php echo $this->_id( '_website', false ); ?>"><?php echo esc_html( $this->_text( 'client_website_text', 'Website' ) ); ?></label>
			<?php
			echo $this->types->input(
				array(
					'name'  => $this->_name( '[website]' ),
					'id'    => $this->_id( '_website' ),
					'value' => $value['website'],
					'type'  => 'text_url',
					'desc'  => '',
				)
			);
			?>
		</div>

		<!-- ticker -->
		<div>
			<label for="<?php echo $this->_id( '_ticker', false ); ?>"><?php echo esc_html( $this->_text( 'client_ticker', 'ticker' ) ); ?></label>
			<?php
			echo $this->types->input(
				array(
					'name'  => $this->_name( '[ticker]' ),
					'id'    => $this->_id( '_ticker' ),
					'value' => $value['ticker'],
					'desc'  => '',
				)
			);
			?>
		</div>
		<?php
		// grab the data from the output buffer.
		return $this->rendered( ob_get_clean() );

	} // end render().

	/**
	 * Split the values if the plist_values option is true
	 */
	public static function maybe_save_split_values( $override_value, $value, $object_id, $field_args ) {
		// If it isn't set or it set to false, just return.
		if ( ! isset( $field_args['split_values'] ) || ! $field_args['split_values'] ) {
			return $override_value;
		}

		// $client_field_keys = array( 'website', 'ticker', 'corporate_location', 'photo' );
		$client_field_keys = self::$client_fields;
		foreach ( $client_field_keys as $key ) {
			if ( ! empty( $value[ $key ] ) ) {
				update_post_meta( $object_id, $field_args['id'] . 'client' . ucfirst( $key ), sanitize_text_field( $value[ $key ] ) );
			}
		}
		remove_filter( 'cmb2_sanitize_client', array( __CLASS__, 'sanitize' ), 10, 5 );
		// Tell CMB2 we already did the update.
		return true;
	} // end maybe_save_split_values().

	/**
	 * Sanitize if repeatable field.
	 */
	public static function sanitize( $check, $meta_value, $object_id, $field_args, $sanitize_object ) {
		// Check to see if the field is designated as 'repeatable'. If it isn't, end the function.
		if ( ! is_array( $meta_value ) || ! $field_args['repeatable'] ) {
			return $check;
		}

		foreach ( $meta_value as $key => $val ) {
			$meta_value[ $key ] = array_filter( array_map( 'sanitize_text_field', $val ) );
		}

		return array_filter( $meta_value );
	} // end sanitize().

	/**
	 * Escape if repeatable field.
	 */
	public static function escape( $check, $meta_value, $field_args, $field_object ) {
		if ( ! is_array( $meta_value ) || ! $field_args[ 'repeatable' ] ) {
			return $check;
		}

		foreach ( $meta_value as $key => $val ) {
			$meta_value[ $key ] = array_filter( array_map( 'esc_attr', $val ) );
		}

		return array_filter( $meta_value );
	} // end escape().

	/**
	 * Split each field into a separate meta within the database.
	 */
	public static function get_split_meta_value( $data, $object_id, $field_args, $field ) {
		if ( 'client' !== $field->args[ 'type' ] ) {
			return $data;
		}

		if ( ! isset( $field_args[ 'split_values' ] ) || ! $field_args[ 'split_values' ] ) {
			// Don't do the overrise in this case, either.
			return $data;
		}
		$prefix = $field->args[ 'id' ] . 'client';

		// construct an array to iterate and fetch individual meta values for the override.
		// should match the values in the render method
		$metakeys = self::$client_fields;

		$newdata = [];
		foreach ( $metakeys as $metakey ) {
			$newdata[ $metakey ] = get_post_meta( $object_id, $prefix . $metakey, true );
		}
		return $newdata;
	} // end get_split_meta_value()


} // end class_cmb2_type_client definition.
