<?php
/**
 * Footer Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.1.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Site footer
 * 20) Body ending
 */
class Boo_Valley_Footer {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.1.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'tha_footer_top', __CLASS__ . '::open', 100 );

						add_action( 'tha_footer_bottom', __CLASS__ . '::close', 100 );

						add_action( 'tha_footer_bottom', __CLASS__ . '::site_info', 90 );

						add_action( 'tha_body_bottom', __CLASS__ . '::site_close', 100 );

						add_action( 'tha_body_bottom', __CLASS__ . '::site_borders', 110 );

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
	 * 10) Site footer
	 *
	 * Footer widgets:
	 * @see  includes/frontend/class-sidebar.php
	 *
	 * Footer menu:
	 * @see  includes/frontend/class-menu.php
	 */

		/**
		 * Footer: Open
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function open() {

			// Output

				echo "\r\n\r\n" . '<footer id="colophon" class="site-footer" role="contentinfo"' . Boo_Valley_Schema::get( 'WPFooter' ) . '>' . "\r\n\r\n";

		} // /open



		/**
		 * Footer: Close
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function close() {

			// Output

				echo "\r\n\r\n" . '</footer>' . "\r\n\r\n";

		} // /close



		/**
		 * Site info
		 *
		 * @since    1.0.0
		 * @version  1.1.0
		 */
		public static function site_info() {

			// Output

				get_template_part( 'templates/parts/component-site', 'info' );

		} // /site_info





	/**
	 * 20) Body ending
	 */

		/**
		 * Site container: Close
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function site_close() {

			// Output

				echo "\r\n" . '</div><!-- /#page -->' . "\r\n\r\n";

		} // /site_close



		/**
		 * Site decorative borders
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function site_borders() {

			// Requirements check

				if ( 'boxed' == get_theme_mod( 'layout_site' ) ) {
					return;
				}


			// Output

				echo "\r\n\r\n";

				echo '<div class="site-border top"></div>';
				echo '<div class="site-border bottom"></div>';
				echo '<div class="site-border left"></div>';
				echo '<div class="site-border right"></div>';

				echo "\r\n\r\n";

		} // /site_borders





} // /Boo_Valley_Footer

add_action( 'after_setup_theme', 'Boo_Valley_Footer::init' );
