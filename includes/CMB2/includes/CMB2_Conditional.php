<?php
/*
Plugin Name: Projects
Plugin URI:  https://nickmortensen.com
Description: Refactored extra posts types and fields.
Version:     0.0.1
Author:      Nick Mortensen
Author URI:  https://nickmortensen.com
Text Domain: projects
Domain Path: ../../languages
License:     GPL3

Conditional Fields is an add on to CMB2. It is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Conditional Fields is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Conditional Fields. If not, see https://www.gnu.org/licenses/gpl.html.
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check to ensure this class doesn't already exist.
if ( ! class_exists( 'CMB2_Conditional', false ) ) {

	class CMB2_Conditional {
		const PRIORITY = 90000; // Set Action Priority number -- ideally it is a high number.
		const VERSION = '0.0.1'; // Set a version number.
		/**
		 * Existing form elements that have the ability to be set to 'required'.
		 */
		protected $optionally_required_form_fields = [
			'list_input',
			'input',
			'textarea',
			'input',
			'select',
			'checkbox',
			'radio',
			'radio_inline',
			'taxonomy_radio',
			'taxonomy_multicheck',
			'multicheck_inline',
		];

		/**
		 * Constructor. Sets up actions for the conditional field type option.
		 */
		public function __construct() {
			if ( false === CMB2_LOADED || ! defined( 'CMB2_LOADED' ) ) {
				return;
			}

			add_action( 'admin_init', array( $this, 'admin_init' ), self::PRIORITY );


			foreach ( $this->optionally_required_form_fields as $item ) {
				add_filter( "cmb2_{$item}_attributes", array( $this, 'optionally_required_form_fields' ), self::PRIORITY );
			}//end foreach.
		} // End __construct function definition (public).


		/**
		 * Ensure valid html for the required attribute.
		 *
		 * @param array $args Array of HTML attributes.
		 *
		 * @return array
		 */
		public function optionally_set_required_attribute( $args ) {
			if ( ! isset( $args['required'] ) ) {
				return $args;
			}
			// Comply with HTML specs.
			if ( true === $args['required'] ) {
				$args['required'] = 'required';
			}
			return $args;
		} // end function def for optionally_set_required_attribute.

		/**
		 * Hook in filtering for the data to save.
		 */
		public function admin_init() {
			$cmb2_boxes = CMB2_Boxes::get_all();

			foreach ( $cmb2_boxes as $identifier => $cmb_box ) {
				add_action( "cmb2_{$cmb_box->object_type()}_process_fields_{$identifier}", array( $this, 'filter_data_to_save' ), self::PRIORITY, 2 );
			}// end foreach.
		} // end definition of admin_init function.

		/**
		 * Filter data from the form to remove certain values.
		 *
		 * @param \CMB2 $cmb2      An instance of the CMB2 class.
		 * @param int   $object_id The id of the object being saved, could post_id, comment_id, user_id.
		 *
		 * The potentially adjusted array is returned via reference $cmb2.
		 */

		 public function filter_data_to_save( CMB2 $cmb2, $object_id ) {
			foreach ( $cmb2->prop( 'fields' ) as $field_args ) {
				if ( ! ( 'group' === $field_args['type'] || ( array_key_exists( 'attributes', $field_args ) && array_key_exists( 'data-conditional-id', $field_args['attributes'] ) ) ) ) {
					continue;
				}

				if ( 'group' === $field_args['type'] ) {
					foreach ( $field_args['type'] as $group_field ) {
						if ( ! ( array_key_exists( 'attributes', $group_field ) && array_key_exists( 'data-conditional-id', $group_field['attributes'] ) ) ) {
							continue;
						}

						$field_id               = $group_field['id'];
						$conditional_id         = $group_field['attributes']['data-conditional-id'];
						$decoded_conditional_id = @json_decode( $conditional_id );
						if ( $decoded_conditional_id ) {
							$conditional_id = $decoded_conditional_id;
						} // end if ( $decoded_conditional_id ).

						if ( is_array( $conditional_id ) && ! empty( $conditional_id ) && ! empty( $cmb2->data_to_save[ $conditional_id[0] ] ) ) {
							foreach ( $cmb2->data_to_save[ $conditional_id[0] ] as $key => $group_data ) {
								$cmb2->data_to_save[ $conditional_id[0] ][ $key ] = $this->filter_field_data_to_save( $group_data, $field_id, $conditional_id[1], $group_field['attributes'] );
							} // end foreach.
						}
						continue;
					} // end foreach.
				} else {
					$field_id           = $field_args['id'];
					$conditional_id     = $field_args['attributes']['data-conditional-id'];
					$cmb2->data_to_save = $this->filter_field_data_to_save( $cmb2->data_to_save, $field_id, $conditional_id, $field_args['attributes'] );

				}// end if('group' === $field_args['type']).
			} // end foreach( $cmb2->prop( 'fields' ) as $field_args )
		}// end filter_data_to_save().

		/**
		 * Determine if the data for one individual field should be saved or not.
		 *
		 * @param array  $data_to_save   The received $_POST data.
		 * @param string $field_id       The CMB2 id of this field.
		 * @param string $conditional_id The CMB2 id of the field this field is conditional on.
		 * @param array  $attributes     The CMB2 field attributes.
		 *
		 * @return array Array of data to save.
		 */
		protected function filter_field_data_to_save( $data_to_save, $field_id, $conditional_id, $attributes ) {
			if ( array_key_exists( 'data-conditional-value', $attributes ) ) {
				$conditional_value         = $attributes['data-conditional-value'];
				$decoded_conditional_value = @json_decode( $conditional_value );

				if ( $decoded_conditional_value ) {
					$conditional_value = $decoded_conditional_value;
				}
				if ( ! isset( $data_to_save[ $conditional_id ] ) ) {
					if ( 'off' !== $conditional_value ) {
						unset( $data_to_save[ $field_id ] );
					}
					return $data_to_save;
				}
				if ( ( ! is_array( $conditional_value ) && ! is_array( $data_to_save[ $conditional_id ] ) ) && $data_to_save[ $conditional_id ] != $conditional_value ) {
					unset( $data_to_save[ $field_id ] );
					return $data_to_save;
				}
				if ( is_array( $conditional_value ) && is_array( $data_to_save[ $conditional_id ] ) ) {
					$match = array_intersect( (array) $conditional_value, (array) $data_to_save[ $conditional_id ] );
					if ( empty( $match ) ) {
						unset( $data_to_save[ $field_id ] );
						return $data_to_save;
					}
				}
			}

			if ( ! isset( $data_to_save[ $conditional_id ] ) || ! $data_to_save[ $conditional_id ] ) {
				unset( $data_to_save[ $field_id ] );
			}
			return $data_to_save;
		} // end filter_field_data_to_save() definition.
	} // end class definition for CMB2_Conditional.

	/**
	 * Instantiate class.
	 *
	 * {@internal wp_installing() function was introduced in WP 4.4. The function exists and constant
	 * check can be removed once the min version for this plugin has been upped to 4.4.}}
	 */
		if ( ( function_exists( 'wp_installing' ) && wp_installing() === false ) || ( ! function_exists( 'wp_installing' ) && ( ! defined( 'WP_INSTALLING' ) || WP_INSTALLING === false ) ) ) {
			add_action( 'plugins_loaded', 'cmb2_conditional_init' );
		}
		if ( ! function_exists( 'cmb2_conditional_init' ) ) {
			/**
			 * Initialize the class
			 */
			function cmb2_conditional_init() {
				static $cmb2_conditional = null;
				if ( null === $cmb2_conditional ) {
					$cmb2_conditional = new CMB2_Conditional();
				}

				return $cmb2_conditional;
			}
		}

} // End 'class_exists' wrapper.
