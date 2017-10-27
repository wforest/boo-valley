<?php
/**
 * Plugin compatibility file.
 *
 * Beaver Themer
 *
 * @link  https://www.wpbeaverbuilder.com/beaver-themer/
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.4.0
 * @version  1.4.0
 *
 * Contents:
 *
 *  1) Requirements check
 * 10) Plugin integration
 */





/**
 * 1) Requirements check
 */

	if ( ! class_exists( 'FLThemeBuilder' ) ) {
		return;
	}





/**
 * 10) Plugin integration
 */

	require BOO_VALLEY_PATH_PLUGINS . 'beaver-themer/class-beaver-themer.php';
