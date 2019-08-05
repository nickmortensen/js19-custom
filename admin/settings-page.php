<?php
/**
 * Jones Sign Customizations
 *
 * Add the settings page for the JS19 Plugin.
 *
 * @package JS19
 * @subpackage Loader
 * @author Nick Mortensen
 * @since 1.0.0
 * @license GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * If there is another function of this same name anywhere, use that. Otherwise, use this one.
 */
if ( ! function_exists( 'js19_display_settings_page' ) ) {
	/**
	 * Callback function to display the plugin settings page.
	 *
	 * @return void
	 */
	function js19_display_settings_page() {

		// Determine if user is allowed access to this page.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		?>

		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">

				<?php

				// output security fields.
				settings_fields( 'js19_options' );

				// output setting sections.
				do_settings_sections( 'js19' );

				// submit button.
				/*
				$text = 'Save Customization'; // Button text.
				$type = 'cooler'; // Button css type.
				$name = 'js19-save-plugin-options'; // ends up being the 'id' and 'name' attribute in the HTML of the button.
				$wrap = false; // Do not wrap this field in a paragraph tag.
				submit_button( $text, $type, $name, $wrap );
				*/
				submit_button();

				?>

			</form>
		</div><!-- end div.wrap -->

		<?php

	}
}
