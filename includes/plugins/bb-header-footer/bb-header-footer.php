<?php
/**
 * Plugin compatibility file.
 *
 * Beaver Builder Header Footer
 *
 * @link  https://wordpress.org/plugins/bb-header-footer/
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.2.0
 * @version  1.2.0
 *
 * Contents:
 *
 *  1) Requirements check
 * 10) Plugin integration
 */





/**
 * 1) Requirements check
 */

	if ( ! class_exists( 'BB_Header_Footer' ) ) {
		return;
	}





/**
 * 10) Plugin integration
 */

	require BOO_VALLEY_PATH_PLUGINS . 'bb-header-footer/class-bb-header-footer.php';
