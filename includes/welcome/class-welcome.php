<?php
/**
 * Welcome Page Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.2.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Renderer
 * 20) Admin menu
 * 30) Assets
 */
class Boo_Valley_Welcome {





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

				// Hooks

					// Actions

						add_action( 'admin_menu', __CLASS__ . '::admin_menu' );

						add_action( 'admin_enqueue_scripts', __CLASS__ . '::assets', 1000 );

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
	 * 10) Renderer
	 */

		/**
		 * Render the screen content
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 */
		public static function render() {

			// Helper variables

				$sections = (array) apply_filters( 'wmhook_boo_valley_welcome_render_sections', array(
						0   => 'header',
						10  => 'wordpress',
						20  => 'quickstart',
						30  => 'filesystem',
						40  => 'demo',
						100 => 'footer',
					) );

				ksort( $sections );


			// Output

				?>

				<div class="wrap welcome-wrap about-wrap">

					<?php

					do_action( 'wmhook_boo_valley_welcome_render_top' );

					foreach ( $sections as $section ) {
						get_template_part( 'templates/parts/component-welcome', $section );
					}

					do_action( 'wmhook_boo_valley_welcome_render_bottom' );

					?>

				</div>

				<?php

		} // /render





	/**
	 * 20) Admin menu
	 */

		/**
		 * Add screen to WordPress admin menu
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function admin_menu() {

			// Processing

				add_theme_page(
						// $page_title
						esc_html__( 'Welcome', 'boo-valley' ),
						// $menu_title
						esc_html__( 'Welcome', 'boo-valley' ),
						// $capability
						'edit_theme_options',
						// $menu_slug
						'boo-valley-welcome',
						// $function
						__CLASS__ . '::render'
					);

		} // /admin_menu





	/**
	 * 30) Assets
	 */

		/**
		 * Styles and scripts
		 *
		 * Use large priority (over 998) when hooking this method
		 * to make sure the `boo-valley-welcome` stylesheet
		 * has been registered already.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $hook_suffix
		 */
		public static function assets( $hook_suffix = '' ) {

			// Requirements check

				if ( $hook_suffix !== get_plugin_page_hookname( 'boo-valley-welcome', 'themes.php' ) ) {
					return;
				}


			// Processing

				// Styles

					wp_enqueue_style( 'boo_valley-welcome' );

		} // /assets





} // /Boo_Valley_Welcome

add_action( 'after_setup_theme', 'Boo_Valley_Welcome::init' );
