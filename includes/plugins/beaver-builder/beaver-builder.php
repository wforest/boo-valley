<?php
/**
 * Plugin compatibility file.
 *
 * Beaver Builder
 *
 * @link  https://www.wpbeaverbuilder.com/
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

	if ( ! class_exists( 'FLBuilder' ) ) {
		return;
	}





/**
 * 10) Plugin integration
 */

	define( 'BOO_VALLEY_PATH_PLUGINS_BEAVER_BUILDER', BOO_VALLEY_PATH_PLUGINS . 'beaver-builder/class-beaver-builder-' );

	require BOO_VALLEY_PATH_PLUGINS_BEAVER_BUILDER . 'setup.php';

	require BOO_VALLEY_PATH_PLUGINS_BEAVER_BUILDER . 'assets.php';

	require BOO_VALLEY_PATH_PLUGINS_BEAVER_BUILDER . 'form.php';

	require BOO_VALLEY_PATH_PLUGINS_BEAVER_BUILDER . 'row.php';

	require BOO_VALLEY_PATH_PLUGINS_BEAVER_BUILDER . 'column.php';

	require BOO_VALLEY_PATH_PLUGINS_BEAVER_BUILDER . 'helpers.php';
