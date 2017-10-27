<?php
/**
 * Jetpack Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.4.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Assets
 * 20) Sharing
 * 30) Infinite scroll
 */
class Boo_Valley_Jetpack {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.0.1
		 */
		private function __construct() {

			// Requirements check

				if ( ! Jetpack::is_active() && ! Jetpack::is_development_mode() ) {
					return;
				}


			// Processing

				// Setup

					// Responsive videos

						add_theme_support( 'jetpack-responsive-videos' );

					// Infinite scroll

						add_theme_support( 'infinite-scroll', apply_filters( 'wmhook_boo_valley_jetpack_setup_infinite_scroll', array(
								'container'      => 'posts',
								'footer'         => false,
								'posts_per_page' => 6,
								'render'         => 'Boo_Valley_Jetpack::infinite_scroll_render',
								'type'           => 'scroll',
								'wrapper'        => false,
							) ) );

					// Sharing

						self::sharing_display_intro();

				// Hooks

					// Actions

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets', 100 );

					// Filters

						add_filter( 'jetpack_sharing_display_markup', 'Boo_Valley_Content::headings_level_up', 999 );

						add_filter( 'jetpack_relatedposts_filter_headline', 'Boo_Valley_Content::headings_level_up', 999 );

						add_filter( 'jetpack_relatedposts_filter_post_heading', 'Boo_Valley_Content::headings_level_up', 999 );

						add_filter( 'sharing_show', __CLASS__ . '::sharing_show', 10, 2 );

						add_filter( 'infinite_scroll_js_settings', __CLASS__ . '::infinite_scroll_js_settings' );

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
	 * 10) Assets
	 */

		/**
		 * Assets
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function assets() {

			// Processing

				// Styles

					// Deregister Genericons as we've got them in the theme

						wp_deregister_style( 'genericons' );

		} // /assets





	/**
	 * 20) Sharing
	 */

		/**
		 * Show sharing?
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  boolean $show
		 * @param  object  $post
		 */
		public static function sharing_show( $show = false, $post = null ) {

			// Helper variables

				// Make sure we display sharing on these post types even if page builder used there:
				$forced_post_types = apply_filters( 'wmhook_boo_valley_jetpack_sharing_show_forced_post_types', array( 'product' ) );


			// Processing

				if (
						in_array( 'the_excerpt', (array) $GLOBALS['wp_current_filter'] )
						|| ! Boo_Valley_Post::is_singular()
						|| (
							in_array( 'the_content', (array) $GLOBALS['wp_current_filter'] )
							&& ! in_array( get_post_type(), (array) $forced_post_types )
							&& Boo_Valley_Post::is_page_builder_ready()
						)
					) {

					$show = false;

				}


			// Output

				return $show;

		} // /sharing_show



		/**
		 * Sharing display in Intro area
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function sharing_display_intro() {

			// Requirements check

				if ( apply_filters( 'wmhook_boo_valley_jetpack_sharing_intro_disable', false ) ) {
					return;
				}


			// Processing

				add_action( 'wmhook_boo_valley_intro', __CLASS__ . '::sharing_display' );

		} // /sharing_display_intro



		/**
		 * Sharing display
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function sharing_display() {

			// Requirements check

				if ( ! function_exists( 'sharing_display' ) ) {
					return;
				}


			// Output

				echo sharing_display();

		} // /sharing_display





	/**
	 * 30) Infinite scroll
	 */

		/**
		 * Infinite scroll JS settings array modifier
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $settings
		 */
		public static function infinite_scroll_js_settings( $settings ) {

			// Helper variables

				$settings['text'] = esc_js( esc_html__( 'Load more&hellip;', 'boo-valley' ) );


			// Output

				return $settings;

		} // /infinite_scroll_js_settings



		/**
		 * Infinite scroll posts renderer
		 *
		 * @see  __construct()
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function infinite_scroll_render() {

			// Output

				while ( have_posts() ) :

					the_post();

					/**
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 *
					 * Or, you can use the filter hook below to modify which content file to load.
					 */
					get_template_part( 'templates/parts/content', apply_filters( 'wmhook_boo_valley_loop_content_type', get_post_format() ) );

				endwhile;

		} // /infinite_scroll_render





} // /Boo_Valley_Jetpack

add_action( 'after_setup_theme', 'Boo_Valley_Jetpack::init' );
