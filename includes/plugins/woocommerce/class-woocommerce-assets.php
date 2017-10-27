<?php
/**
 * WooCommerce: Assets Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Setup
 */
class Boo_Valley_WooCommerce_Assets {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		private function __construct() {

			// Processing

				// Actions

					add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets', 100 );

					add_action( 'wp_enqueue_scripts', __CLASS__ . '::styles_fallback', 100 );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function init() {

			// Processing

				if ( null === self::$instance ) {
					self::$instance = new self;
				}


			// Output

				return self::$instance;

		} // /init





	/**
	 * 10) Setup
	 */

		/**
		 * Enqueue assets
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function assets() {

			// Processing

				// Scripts

					wp_enqueue_script(
							'boo_valley-scripts-woocommerce',
							get_theme_file_uri( 'assets/js/scripts-woocommerce.js' ),
							array( 'jquery' ),
							esc_attr( trim( BOO_VALLEY_THEME_VERSION ) ),
							true
						);

		} // /assets



		/**
		 * Enqueue fallback stylesheet
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function styles_fallback() {

			// Helper variables

				$wp_upload_dir    = wp_upload_dir();
				$theme_upload_dir = trailingslashit( $wp_upload_dir['basedir'] . get_theme_mod( '__path_theme_generated_files' ) );


			// Requirements check

				if (
						file_exists( $theme_upload_dir . 'boo-valley-styles.css' )
						&& ! ( defined( 'BOO_VALLEY_DEBUG_SASS' ) && BOO_VALLEY_DEBUG_SASS )
					) {
					return;
				}


			// Processing

				wp_enqueue_style(
						'boo_valley-stylesheet-woocommerce',
						get_theme_file_uri( 'fallback-woocommerce.css' ),
						array( 'boo_valley-stylesheet-global' ),
						esc_attr( trim( BOO_VALLEY_THEME_VERSION ) ),
						'screen'
					);

				// RTL setup

					wp_style_add_data( 'boo_valley-stylesheet-woocommerce', 'rtl', 'replace' );

		} // /styles_fallback





} // /Boo_Valley_WooCommerce_Assets

add_action( 'after_setup_theme', 'Boo_Valley_WooCommerce_Assets::init' );
