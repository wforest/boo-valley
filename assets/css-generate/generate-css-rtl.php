<?php
/**
 * Main RTL stylesheet generator
 *
 * @uses  `wmhook_boo_valley_esc_css` global hook
 * @uses  `wmhook_boo_valley_generate_css_replacements` global hook
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.1
 */





/**
 * Helper variables
 */

	$output = '';
	$scope  = 'rtl';

	$boo_valley_theme_css_files = array(
			10 => 'assets/css/main-rtl.css',
			20 => 'assets/css/shortcodes-rtl.css',
		);



		/**
		 * Allow filtering
		 */

			$boo_valley_theme_css_files = apply_filters( 'wmhook_boo_valley_css_files', $boo_valley_theme_css_files, $scope );

			ksort( $boo_valley_theme_css_files );





/**
 * Preparing output
 */

	// Buffer

		ob_start();

		// Start including files and editing output

			foreach ( $boo_valley_theme_css_files as $css_file_name ) {
				if ( file_exists( BOO_VALLEY_PATH . $css_file_name ) ) {
					require BOO_VALLEY_PATH . $css_file_name;
				}
			}

		$output = ob_get_clean();





/**
 * Customizer styles
 *
 * No need to load the 'assets/css-generate/custom-styles.php' as the file was already loaded
 * once while generating main stylesheet.
 */

	$output .= "\r\n\r\n\r\n/**\r\n * Customize styles\r\n */\r\n\r\n" . boo_valley_custom_styles();





/**
 * Replace variables
 */

	$replacements = (array) apply_filters( 'wmhook_boo_valley_generate_css_replacements', array() );

	if ( ! empty( $replacements ) ) {
		$output = strtr( $output, $replacements );
	}





/**
 * Output
 */

	echo apply_filters( 'wmhook_boo_valley_esc_css', $output );
