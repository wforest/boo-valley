<?php
/**
 * Beaver Builder Header Footer Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.2.0
 * @version  1.4.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Setup
 */
class Boo_Valley_BB_Header_Footer {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * Adding the hooks overrides very late,
		 * hoping no THA hook is inserted later.
		 *
		 * @since    1.2.0
		 * @version  1.2.0
		 */
		private function __construct() {

			// Processing

				// Setup

					add_theme_support( 'bb-header-footer' );

				// Hooks

					// Actions

						add_action( 'wp', __CLASS__ . '::hook_overrides', 999 );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.2.0
		 * @version  1.2.0
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
		 * Hooks overrides
		 *
		 * @since    1.2.0
		 * @version  1.4.0
		 */
		public static function hook_overrides() {

			// Helper variables

				$header_id = BB_Header_Footer::get_settings( 'bb_header_id' );
				$footer_id = BB_Header_Footer::get_settings( 'bb_footer_id' );


			// Processing

				// Custom header

					if ( ! empty( $header_id ) ) {

						remove_all_actions( 'tha_header_top' );
						remove_all_actions( 'tha_header_bottom' );

						add_action( 'tha_header_top', 'Boo_Valley_Header::open' );
						add_action( 'tha_header_top', 'BB_Header_Footer::get_header_content', 20 );
						add_action( 'tha_header_bottom', 'Boo_Valley_Header::close' );

						add_filter( 'theme_mod_' . 'layout_header_sticky', '__return_false', 100 );

					}

				// Custom footer

					if ( ! empty( $footer_id ) ) {

						remove_all_actions( 'tha_footer_top' );
						remove_all_actions( 'tha_footer_bottom' );

						add_action( 'tha_footer_top', 'Boo_Valley_Footer::open' );
						add_action( 'tha_footer_top', 'BB_Header_Footer::get_footer_content', 20 );
						add_action( 'tha_footer_bottom', 'Boo_Valley_Footer::close' );

					}

		} // /hook_overrides





} // /Boo_Valley_BB_Header_Footer

add_action( 'after_setup_theme', 'Boo_Valley_BB_Header_Footer::init', 100 );
