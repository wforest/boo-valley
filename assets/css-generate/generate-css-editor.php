<?php
/**
 * Visual Editor stylesheet generator
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
	$scope  = 'editor';

	$boo_valley_theme_css_files = array(
			10 => 'assets/css/main.css',
			20 => 'assets/css/editor-style.css',
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
 * Use `boo_valley_custom_styles( true )` to generate Visual Editor Customizer styles only.
 */

	$output .= "\r\n\r\n\r\n/**\r\n * Customize styles\r\n */\r\n\r\n" . boo_valley_custom_styles( true );





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
