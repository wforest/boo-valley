<?php
/**
 * Header Class
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
 * 10) HTML head
 * 20) Body start
 * 30) Site header
 * 40) Setup
 */
class Boo_Valley_Header {





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

						add_action( 'tha_html_before', __CLASS__ . '::doctype' );

						add_action( 'wp_head', __CLASS__ . '::head', 1 );

						add_action( 'tha_body_top', __CLASS__ . '::oldie', 5 );

						add_action( 'tha_body_top', __CLASS__ . '::skip_links', 5 );

						add_action( 'tha_body_top', __CLASS__ . '::site_open' );

						add_action( 'tha_header_top', __CLASS__ . '::open', 100 );

						add_action( 'tha_header_bottom', __CLASS__ . '::close', 100 );

						add_action( 'tha_header_top', __CLASS__ . '::open_inner', 110 );

						add_action( 'tha_header_bottom', __CLASS__ . '::close_inner' );

						add_action( 'tha_header_top', __CLASS__ . '::site_branding', 120 );

					// Filters

						add_filter( 'body_class', __CLASS__ . '::body_class', 98 );

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
	 * 10) HTML head
	 */

		/**
		 * HTML DOCTYPE
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function doctype() {

			// Output

				echo '<!DOCTYPE html>';

		} // /doctype



		/**
		 * HTML HEAD
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function head() {

			// Processing

				get_template_part( 'templates/parts/component', 'head' );

		} // /head





	/**
	 * 20) Body start
	 */

		/**
		 * IE upgrade message
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function oldie() {

			// Requirements check

				if ( ! isset( $GLOBALS['is_IE'] ) || ! $GLOBALS['is_IE'] ) {
					return;
				}


			// Processing

				get_template_part( 'templates/parts/component', 'oldie' );

		} // /oldie



		/**
		 * Skip links: Body top
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function skip_links() {

			// Processing

				$output  = Boo_Valley_Library::link_skip_to( 'site-navigation', __( 'Skip to main navigation', 'boo-valley' ) );

				if (
						is_callable( 'Boo_Valley_WooCommerce_Widgets::is_cart_header' )
						&& Boo_Valley_WooCommerce_Widgets::is_cart_header()
					) {
					$output .= Boo_Valley_Library::link_skip_to( 'header-shopping-cart', __( 'Skip to shopping cart', 'boo-valley' ) );
				}

				$output .= Boo_Valley_Library::link_skip_to( 'content' );
				$output .= Boo_Valley_Library::link_skip_to( 'colophon', __( 'Skip to footer', 'boo-valley' ) );


			// Output

				echo $output;

		} // /skip_links



		/**
		 * Site container: Open
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function site_open() {

			// Output

				echo '<div id="page" class="site">' . "\r\n";

		} // /site_open





	/**
	 * 30) Site header
	 *
	 * Header widgets:
	 * @see  includes/frontend/class-sidebar.php
	 *
	 * Header menu:
	 * @see  includes/frontend/class-menu.php
	 */

		/**
		 * Header: Open
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function open() {

			// Output

				echo "\r\n\r\n" . '<header id="masthead" class="site-header" role="banner"' . Boo_Valley_Schema::get( 'WPHeader' ) . '>' . "\r\n\r\n";

		} // /open



		/**
		 * Header: Close
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function close() {

			// Output

				echo "\r\n\r\n" . '</header>' . "\r\n\r\n";

		} // /close



		/**
		 * Header inner container: Open
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function open_inner() {

			// Output

				echo "\r\n\r\n" . '<div class="site-header-content"><div class="site-header-inner">' . "\r\n\r\n";

		} // /open_inner



		/**
		 * Header inner container: Close
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function close_inner() {

			// Output

				echo "\r\n\r\n" . '</div></div>' . "\r\n\r\n";

		} // /close_inner



		/**
		 * Logo, site branding
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function site_branding() {

			// Output

				get_template_part( 'templates/parts/component-site', 'branding' );

		} // /site_branding





	/**
	 * 40) Setup
	 */

		/**
		 * HTML Body classes
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  array $classes
		 */
		public static function body_class( $classes = array() ) {

			// Helper variables

				$classes = (array) $classes; // Just in case...


			// Processing

				// JS fallback

					$classes[] = 'no-js';

				// Website layout

					if ( $layout_site = get_theme_mod( 'layout_site', 'fullwidth' ) ) {
						$classes[] = esc_attr( 'site-layout-' . $layout_site );
					}

				// Header layout

					if ( $layout_header = get_theme_mod( 'layout_header', 'fullwidth' ) ) {
						$classes[] = esc_attr( 'header-layout-' . $layout_header );
					}

				// Footer layout

					if ( $layout_footer = get_theme_mod( 'layout_footer', 'boxed' ) ) {
						$classes[] = esc_attr( 'footer-layout-' . $layout_footer );
					}

				// Is mobile navigation enabled?

					if ( ! get_theme_mod( 'navigation_mobile_disable', false ) ) {
						$classes[] = 'has-navigation-mobile';
					}

				// Is site branding text displayed?

					if ( 'blank' === get_header_textcolor() ) {
						$classes[] = 'site-title-hidden';
					}

				// Singular?

					if ( is_singular() ) {
						$classes[] = 'is-singular';

						$post_id = get_the_ID();

						// Has featured image?

							if ( has_post_thumbnail() ) {
								$classes[] = 'has-post-thumbnail';
							}

						// Has custom intro image?

							if ( get_post_meta( $post_id, 'intro_image', true ) ) {
								$classes[] = 'has-custom-intro-image';
							}

						// Any page builder layout

							if ( get_post_meta( $post_id, 'layout_stretched', true ) ) {
								$classes[] = 'content-layout-no-paddings';
								$classes[] = 'content-layout-stretched';
							} elseif ( get_post_meta( $post_id, 'layout_no_paddings', true ) ) {
								$classes[] = 'content-layout-no-paddings';
							}

					} else {

						// Add a class of hfeed to non-singular pages

							$classes[] = 'hfeed';

					}

				// Has more than 1 published author?

					if ( is_multi_author() ) {
						$classes[] = 'group-blog';
					}

				// Sticky header enabled?

					if (
							get_theme_mod( 'layout_header_sticky', true )
							&& ! apply_filters( 'wmhook_boo_valley_disable_header', false )
						) {
						$classes[] = 'has-sticky-header';
					}

				// Intro displayed?

					if ( ! (bool) apply_filters( 'wmhook_boo_valley_intro_disable', false ) ) {
						$classes[] = 'has-intro';
					} else {
						$classes[] = 'no-intro';
					}

				// Widget areas

					foreach ( (array) apply_filters( 'wmhook_boo_valley_header_body_classes_sidebars', array() ) as $sidebar ) {
						if ( ! is_active_sidebar( $sidebar ) ) {
							$classes[] = 'no-widgets-' . $sidebar;
						} else {
							$classes[] = 'has-widgets-' . $sidebar;
						}
					}

				// Posts layout

					if (
							is_home()
							|| is_category()
							|| is_tag()
							|| is_date()
						) {
						$classes[] = 'posts-layout-' . sanitize_html_class( get_theme_mod( 'blog_style', 'list' ) );
					}

					if ( (bool) apply_filters( 'wmhook_boo_valley_is_masonry_layout', false ) ) {
						$classes[] = 'posts-layout-masonry';
					}

				// Fullwidth submenus

					if ( get_theme_mod( 'layout_submenu_fullwidth', true ) ) {
						$classes[] = 'has-fullwidth-submenu';
					}

				// Body borders

					if (
							'fullwidth' == $layout_site
							&& $site_borders = get_theme_mod( 'layout_site_borders', 'has-site-borders-around' )
						) {
						$classes[] = 'has-site-borders';
						$classes[] = esc_attr( $site_borders );
					}

				// Intro section background filter

					if ( get_theme_mod( 'intro_filter', true ) ) {
						$classes[] = 'has-intro-filter';
					}


			// Output

				asort( $classes );

				return array_unique( $classes );

		} // /body_class





} // /Boo_Valley_Header

add_action( 'after_setup_theme', 'Boo_Valley_Header::init' );
