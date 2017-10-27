<?php
/**
 * Plugin compatibility file.
 *
 * One Click Demo Import
 *
 * @link  https://wordpress.org/plugins/one-click-demo-import/
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 *
 * Contents:
 *
 *  1) Requirements check
 * 10) Plugin integration
 */





/**
 * 1) Requirements check
 */

	if (
			! ( class_exists( 'OCDI_Plugin' ) || class_exists( 'PT_One_Click_Demo_Import' ) )
			|| ! is_admin()
		) {
		return;
	}





/**
 * 20) Plugin integration
 */

	require BOO_VALLEY_PATH_PLUGINS . 'one-click-demo-import/class-one-click-demo-import.php';
