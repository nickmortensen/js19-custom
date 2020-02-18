<?php
/**
 * Creates a switch field using cmb2.

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

// Check to see whether this class has been previously defined.

if ( ! class_exists( 'CMB2_Betterswitch_Button' ) ) {

	/**
	 * Class CMB2_Radio_Image



	 */

	 class CMB2_Betterswitch_Button {

		public function __construct() {
			add_action( 'cmb2_render_betterswitch', array( $this, 'callback'), 10, 5 );
			add_action( 'admin_head', array( $this, 'admin_head' ) );
		 } // end definition of __construct()

		 /**
			* Adds the better switch field in the array of field types for CMB2
			*
			* @param object  $field               The current CMB2_Field object.
			* @param string  $escaped_value      The value of this field passed through the escaping filter. It defaults to sanitize_text_field.
			* @param integer $object_id          The id of the object you are working with. Most commonly, the post id.
			* @param string  $object_type        The type of object you are working with. Most commonly, post (this applies to all post-types), but could also be comment, user or options-page.
			* @param object  $field_type_object   This is an instance of the CMB2_Types object and gives you access to all of the methods that CMB2 uses to build its field types.
			* @return void
		*/
		public function callback( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {

			$field_name = $field->_name();

			$args = array(
				'type'  => 'checkbox',
				'id'    => $field_name,
				'name'  => $field_name,
				'desc'  => '',
				'value' => 'off',
			);
			if ( $escaped_value == 'on' ) {
				$args['checked'] = 'checked';
			}
			$output = '<label class="betterswitch">';
			$output .= $field_type_object->input( $args );
			$output .= '<span class="betterswitch-slider round"></span>';
			$output .= '</label>';

			echo $output;
			$field_type_object->_desc( true, true );

		 } // end definition of betterswitch_callback()

		public function admin_head() {
			 ?>

			<style>
				.betterswitch {
					position: relative;
					display: inline-block;
					width: 49px;
					height: 23px;
				}
				.betterswitch input { display: none }
				.betterswitch-slider {
					position: absolute;
					cursor: pointer;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					background-color: #ccc;
					transition: .4s ease;
				}
				.betterswitch-slider:before {
					position: absolute;
					content: "";
					height: 17px;
					width: 17px;
					left: 3px;
					bottom: 3px;
					background-color: white;
					transition: .4s ease;
				}
				input:checked + .betterswitch-slider { background-color: #2196F3 }
				input:focus + .betterswitch-slider { box-shadow: 0 0 1px #2196F3 }
				input:checked + .betterswitch-slider:before { transform: translateX(26px) }
				.betterswitch-slider.round { border-radius: 34px }
				.betterswitch-slider.round:before { border-radius: 50% }
			</style>
			 <?php
		} // end definition of admin_head()

	} // end class CMB2_Better_Switch_Button definition.
	$betterswitch = new CMB2_Betterswitch_Button();

} // end check to see whether the class has been defined.
