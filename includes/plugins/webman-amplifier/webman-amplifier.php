<?php
/**
 * Plugin compatibility file.
 *
 * SulliDigital Amplifier
 *
 * @link  https://wordpress.org/plugins/webman-amplifier/
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

	if ( ! class_exists( 'WM_Amplifier' ) ) {
		return;
	}





/**
 * 10) Plugin integration
 */

	define( 'BOO_VALLEY_PATH_PLUGINS_WEBMAN_AMPLIFIER', BOO_VALLEY_PATH_PLUGINS . 'webman-amplifier/class-webman-amplifier-' );

	require BOO_VALLEY_PATH_PLUGINS_WEBMAN_AMPLIFIER . 'setup.php';

	require BOO_VALLEY_PATH_PLUGINS_WEBMAN_AMPLIFIER . 'custom-post-types.php';

	require BOO_VALLEY_PATH_PLUGINS_WEBMAN_AMPLIFIER . 'metaboxes.php';

	require BOO_VALLEY_PATH_PLUGINS_WEBMAN_AMPLIFIER . 'shortcodes.php';

	require BOO_VALLEY_PATH_PLUGINS_WEBMAN_AMPLIFIER . 'icons.php';

	require BOO_VALLEY_PATH_PLUGINS_WEBMAN_AMPLIFIER . 'helpers.php';
