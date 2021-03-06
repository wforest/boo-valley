<?php
/**
 * Plugin compatibility file.
 *
 * Widget CSS Classes
 *
 * @link  https://wordpress.org/plugins/widget-css-classes/
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

	if ( ! function_exists( 'widget_css_classes_loader' ) ) {
		return;
	}





/**
 * 20) Plugin integration
 */

	require BOO_VALLEY_PATH_PLUGINS . 'widget-css-classes/class-widget-css-classes.php';
