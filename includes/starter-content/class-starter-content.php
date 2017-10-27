<?php
/**
 * Theme Starter Content Class
 *
 * @link  https://make.wordpress.org/core/2016/11/30/starter-content-for-themes-in-4-7/
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
 * 10) Content
 * 20) Partials
 */
class Boo_Valley_Starter_Content {





	/**
	 * 0) Init
	 */

		private static $content;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		private function __construct() {}





	/**
	 * 10) Content
	 */

		/**
		 * Theme starter content
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function content() {

			// Processing

				// Loading

					self::widgets();

					self::pages();

					self::options();

					self::nav_menus();

				// Setup

					if ( ! empty( self::$content ) ) {
						add_theme_support( 'starter-content', self::$content );
					}

		} // /content





	/**
	 * 20) Partials
	 */

		/**
		 * Widgets
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function widgets() {

			// Output

				self::$content['widgets'] = array(

						'sidebar' => array(
							'text_about',
							'search',
							'recent-comments',
							'categories',
						),

						'header' => array(

							'text_header' => array(
								'text',
								array(
									'title' => esc_html_x( 'Header Widgets', 'Theme starter content', 'boo-valley' ),
									'text'  => esc_html_x( 'This is a Header Widgets area where you can add any widgets or none at all.', 'Theme starter content', 'boo-valley' ),
								),
							),

							'meta',
						),

						'intro' => array(

							'text_intro' => array(
								'text',
								array(
									'title' => esc_html_x( 'Intro Widgets', 'Theme starter content', 'boo-valley' ),
									'text'  => esc_html_x( 'This is an Intro Widgets area. It only displays on pages with a specific page template assigned, or a dedicated option enabled.', 'Theme starter content', 'boo-valley' ),
								),
							),

							'text_about',
							'text_about',
						),

						'footer-secondary' => array(

							'text_testimonial' => array(
								'text',
								array(
									'title' => esc_html_x( 'Customer Testimonial', 'Theme starter content', 'boo-valley' ),
									'text'  => '<blockquote class="display-1">'
									           . esc_html_x( 'You can place any widget into Footer Secondary Widgets area.', 'Theme starter content', 'boo-valley' )
									           . '<cite style="font-size: 50%;"><em>Albert Einstein</em></cite></blockquote>',
								),
							),

							'text_subscribe' => array(
								'text',

								array(
									'title' => esc_html_x( 'Subscribe', 'Theme starter content', 'boo-valley' ),
									'text'  => '<form><p>'
									           . esc_html_x( 'A perfect place for subscription form here.', 'Theme starter content', 'boo-valley' )
									           . '</p><p class="fullwidth"><label for="subscribe-email" class="screen-reader-text">'
									           . esc_html_x( 'Email address', 'Theme starter content', 'boo-valley' )
									           . ' </label><input type="email" name="email" id="subscribe-email" placeholder="'
									           . esc_html_x( 'Email address', 'Theme starter content', 'boo-valley' )
									           . '" required></p><p class="fullwidth"><input type="submit" value="'
									           . esc_html_x( 'Subscribe', 'Theme starter content', 'boo-valley' )
									           . '"></p></form>',
								),
							),

						),

						'footer' => array(
							'text_about',
							'recent-posts',
							'recent-comments',
							'text_business_info',
						),

					);

		} // /widgets



		/**
		 * Pages
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function pages() {

			// Output

				self::$content['posts'] = array(
						'home' => array(
							'template' => 'templates/intro-widgets.php',
						),
						'about',
						'contact',
						'news',
					);

		} // /pages



		/**
		 * Navigational menus
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function nav_menus() {

			// Output

				self::$content['nav_menus'] = array(

						'primary' => array(
							'name' => esc_html_x( 'Primary Menu', 'Theme starter content', 'boo-valley' ),
							'items' => array(
								'page_home',
								'page_about',
								'page_news',
								'page_contact',
							),
						),

						'footer' => array(
							'name' => esc_html_x( 'Footer Menu', 'Theme starter content', 'boo-valley' ),
							'items' => array(
								'page_about',
								'page_news',
								'page_contact',
							),
						),

						'social' => array(
							'name' => esc_html_x( 'Social Links Menu', 'Theme starter content', 'boo-valley' ),
							'items' => array(

								'link_facebook' => array(
									'title' => esc_html_x( 'SulliDigital Design on Facebook', 'Theme starter content', 'boo-valley' ),
									'url'   => 'https://www.facebook.com/webmandesigneu',
								),

								'link_twitter' => array(
									'title' => esc_html_x( 'SulliDigital Design on Twitter', 'Theme starter content', 'boo-valley' ),
									'url'   => 'https://www.twitter.com/webmandesigneu',
								),

								'link_vimeo' => array(
									'title' => esc_html_x( 'SulliDigital Design on Vimeo', 'Theme starter content', 'boo-valley' ),
									'url'   => 'https://www.vimeo.com/webmandesigneu',
								),

								'link_webman_design' => array(
									'title' => 'SulliDigital Design',
									'url'   => 'https://www.sullidigital.com',
								),

								'link_email',
							),
						),

					);

		} // /nav_menus



		/**
		 * WordPress options
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function options() {

			// Output

				self::$content['options'] = array(
						'show_on_front'       => 'page',
						'page_on_front'       => '{{home}}',
						'page_for_posts'      => '{{news}}',
						'posts_per_page'      => 8,
						'permalink_structure' => '/%postname%/',
					);

		} // /options





} // /Boo_Valley_Starter_Content

add_action( 'after_setup_theme', 'Boo_Valley_Starter_Content::content' );
