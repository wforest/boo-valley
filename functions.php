<?php
/**
 * Theme loading
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.4.0
 *
 * Contents:
 *
 *   0) Path base
 *   1) Theme framework
 *  10) Theme setup
 *  20) Frontend
 *  30) Features
 * 100) Custom widgets
 * 999) Plugins integration
 */





/**
 * 0) Paths
 */

	// Theme directory path

		define( 'BOO_VALLEY_PATH', trailingslashit( get_template_directory() ) );

	// Includes path

		define( 'BOO_VALLEY_PATH_INCLUDES', trailingslashit( BOO_VALLEY_PATH . 'includes' ) );

		// Plugin compatibility files

			define( 'BOO_VALLEY_PATH_PLUGINS', trailingslashit( BOO_VALLEY_PATH_INCLUDES . 'plugins' ) );





/**
 * 1) Theme framework
 */

	require BOO_VALLEY_PATH . 'library/init.php';

	if ( is_admin() ) {
		require BOO_VALLEY_PATH_INCLUDES . 'update-notifier/update-notifier.php';
	}





/**
 * 10) Theme setup
 */

	require BOO_VALLEY_PATH_INCLUDES . 'setup/class-setup.php';

	require BOO_VALLEY_PATH_INCLUDES . 'starter-content/class-starter-content.php';





/**
 * 20) Frontend
 */

	// Theme Hook Alliance

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/theme-hook-alliance.php';

	// SVG

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-svg.php';

	// Schema.org

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-schema.php';

	// Assets (styles and scripts)

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-assets.php';

	// Header

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-header.php';

	// Menu

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-menu.php';

	// Content

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-content.php';

	// Loop

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-loop.php';

	// Post

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-post.php';
		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-post-summary.php';
		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-post-media.php';

	// Footer

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-footer.php';

	// Sidebars (widget areas)

		require BOO_VALLEY_PATH_INCLUDES . 'frontend/class-sidebar.php';





/**
 * 30) Features
 */

	// Theme Customization

		require BOO_VALLEY_PATH_INCLUDES . 'customize/class-customize.php';

	// Custom Header / Intro

		require BOO_VALLEY_PATH_INCLUDES . 'custom-header/class-intro.php';

	// Post Formats

		require BOO_VALLEY_PATH_INCLUDES . 'post-formats/class-post-formats.php';





/**
 * 100) Custom widgets
 */

	// WordPress Recent Posts Widget

		require BOO_VALLEY_PATH_INCLUDES . 'widgets/class-wp-widget-recent-posts.php';





/**
 * 999) Plugins integration
 */

	// SulliDigital Amplifier

		if ( class_exists( 'WM_Amplifier' ) ) {
			require BOO_VALLEY_PATH_PLUGINS . 'sullidigital-amplifier/sullidigital-amplifier.php';
		}

	// Advanced Custom Fields

		if ( function_exists( 'register_field_group' ) && is_admin() ) {
			require BOO_VALLEY_PATH_PLUGINS . 'advanced-custom-fields/advanced-custom-fields.php';
		}

	// Beaver Builder

		if ( class_exists( 'FLBuilder' ) ) {
			require BOO_VALLEY_PATH_PLUGINS . 'beaver-builder/beaver-builder.php';
		}

	// Beaver Themer

		if ( class_exists( 'FLThemeBuilder' ) ) {
			require BOO_VALLEY_PATH_PLUGINS . 'beaver-themer/beaver-themer.php';
		}

	// Beaver Builder Header Footer

		if ( class_exists( 'BB_Header_Footer' ) ) {
			require BOO_VALLEY_PATH_PLUGINS . 'bb-header-footer/bb-header-footer.php';
		}

	// Breadcrumb NavXT

		if ( function_exists( 'bcn_display' ) ) {
			require BOO_VALLEY_PATH_PLUGINS . 'breadcrumb-navxt/breadcrumb-navxt.php';
		}

	// Jetpack

		if ( class_exists( 'Jetpack' ) ) {
			require BOO_VALLEY_PATH_PLUGINS . 'jetpack/jetpack.php';
		}

	// One Click Demo Import

		if ( ( class_exists( 'OCDI_Plugin' ) || class_exists( 'PT_One_Click_Demo_Import' ) ) && is_admin() ) {
			require BOO_VALLEY_PATH_PLUGINS . 'one-click-demo-import/one-click-demo-import.php';
		}

	// Smart Slider 3

		if ( class_exists( 'N2SS3' ) ) {
			require BOO_VALLEY_PATH_PLUGINS . 'smart-slider/smart-slider.php';
		}

	// Subtitles

		if ( class_exists( 'Subtitles' ) ) {
			require BOO_VALLEY_PATH_PLUGINS . 'subtitles/subtitles.php';
		}

	// Widget CSS Classes

		if ( function_exists( 'widget_css_classes_loader' ) ) {
			require BOO_VALLEY_PATH_PLUGINS . 'widget-css-classes/widget-css-classes.php';
		}

	// WooCommerce

		/**
		 * Regenerate styles on WooCommerce activation and deactivation.
		 * Has to be outside WooCommerce compatibility files and outside WooCommerce class exists check.
		 */
		register_activation_hook(   'woocommerce/woocommerce.php', 'Boo_Valley_Setup::regenerate_styles' );
		register_deactivation_hook( 'woocommerce/woocommerce.php', 'Boo_Valley_Setup::regenerate_styles' );

		if ( class_exists( 'WooCommerce' ) ) {
			require BOO_VALLEY_PATH_PLUGINS . 'woocommerce/woocommerce.php';
		}
