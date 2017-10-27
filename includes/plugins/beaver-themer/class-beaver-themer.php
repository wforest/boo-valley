<?php
/**
 * Beaver Themer Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.4.0
 * @version  1.4.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Setup
 * 100) Others
 */
class Boo_Valley_Beaver_Themer {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.4.0
		 * @version  1.4.0
		 */
		private function __construct() {

			// Processing

				// Setup

					add_theme_support( 'fl-theme-builder-headers' );
					add_theme_support( 'fl-theme-builder-footers' );
					add_theme_support( 'fl-theme-builder-parts' );

				// Hooks

					// Actions

						add_action( 'wp', __CLASS__ . '::sidebar_disable' );

						add_action( 'wp', __CLASS__ . '::headers_footers', 999 );

					// Filters

						add_filter( 'fl_theme_builder_part_hooks', __CLASS__ . '::parts' );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.4.0
		 * @version  1.4.0
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
		 * Custom header and footer renderer
		 *
		 * @since    1.4.0
		 * @version  1.4.0
		 */
		public static function headers_footers() {

			// Helper variables

				$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();
				$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();


			// Processing

				// Custom header

					if ( ! empty( $header_ids ) ) {

						remove_all_actions( 'tha_header_top' );
						remove_all_actions( 'tha_header_bottom' );

						add_action( 'tha_header_top', 'FLThemeBuilderLayoutRenderer::render_header', 20 );

						add_filter( 'theme_mod_' . 'layout_header_sticky', '__return_false', 100 );

					}

				// Custom footer

					if ( ! empty( $footer_ids ) ) {

						remove_all_actions( 'tha_footer_top' );
						remove_all_actions( 'tha_footer_bottom' );

						add_action( 'tha_footer_top', 'FLThemeBuilderLayoutRenderer::render_footer', 20 );

					}

		} // /headers_footers



		/**
		 * Registers hooks for theme parts
		 *
		 * @since    1.4.0
		 * @version  1.4.0
		 */
		public static function parts() {

			// Output

				return array(

					array(
						'label' => esc_html_x( 'Page', 'Website hooks category name.', 'boo-valley' ),
						'hooks' => array(
							'tha_body_top'    => esc_html_x( 'Page Open', 'Website hook name.', 'boo-valley' ),
							'tha_body_bottom' => esc_html_x( 'Page Close', 'Website hook name.', 'boo-valley' ),
						),
					),

					array(
						'label' => esc_html_x( 'Header', 'Website hooks category name.', 'boo-valley' ),
						'hooks' => array(
							'tha_header_before' => esc_html_x( 'Before Header', 'Website hook name.', 'boo-valley' ),
							'tha_header_top'    => esc_html_x( 'Header Top', 'Website hook name.', 'boo-valley' ),
							'tha_header_bottom' => esc_html_x( 'Header Bottom', 'Website hook name.', 'boo-valley' ),
							'tha_header_after'  => esc_html_x( 'After Header', 'Website hook name.', 'boo-valley' ),
						),
					),

					array(
						'label' => esc_html_x( 'Intro', 'Website hooks category name.', 'boo-valley' ),
						'hooks' => array(
							'wmhook_boo_valley_intro_before' => esc_html_x( 'Before Intro', 'Website hook name.', 'boo-valley' ),
							'wmhook_boo_valley_intro'        => esc_html_x( 'Intro Content', 'Website hook name.', 'boo-valley' ),
							'wmhook_boo_valley_intro_after'  => esc_html_x( 'After Intro', 'Website hook name.', 'boo-valley' ),
						),
					),

					array(
						'label' => esc_html_x( 'Content Area', 'Website hooks category name.', 'boo-valley' ),
						'hooks' => array(
							'tha_content_before' => esc_html_x( 'Before Content Area', 'Website hook name.', 'boo-valley' ),
							'tha_content_top'    => esc_html_x( 'Content Area Top', 'Website hook name.', 'boo-valley' ),
							'tha_content_bottom' => esc_html_x( 'Content Area Bottom', 'Website hook name.', 'boo-valley' ),
							'tha_content_after'  => esc_html_x( 'After Content Area', 'Website hook name.', 'boo-valley' ),
						),
					),

					array(
						'label' => esc_html_x( 'Post Entry', 'Website hooks category name.', 'boo-valley' ),
						'hooks' => array(
							'tha_entry_before'         => esc_html_x( 'Before Post', 'Website hook name.', 'boo-valley' ),
							'tha_entry_top'            => esc_html_x( 'Post Top', 'Website hook name.', 'boo-valley' ),
							'tha_entry_content_before' => esc_html_x( 'Before Post Content', 'Website hook name.', 'boo-valley' ),
							'tha_entry_content_after'  => esc_html_x( 'After Post Content', 'Website hook name.', 'boo-valley' ),
							'tha_entry_bottom'         => esc_html_x( 'Post Bottom', 'Website hook name.', 'boo-valley' ),
							'tha_entry_after'          => esc_html_x( 'After Post', 'Website hook name.', 'boo-valley' ),
						),
					),

					array(
						'label' => esc_html_x( 'Comments', 'Website hooks category name.', 'boo-valley' ),
						'hooks' => array(
							'tha_comments_before' => esc_html_x( 'Before Comments', 'Website hook name.', 'boo-valley' ),
							'tha_comments_after'  => esc_html_x( 'After Comments', 'Website hook name.', 'boo-valley' ),
						),
					),

					array(
						'label' => esc_html_x( 'Posts List', 'Website hooks category name.', 'boo-valley' ),
						'hooks' => array(
							'wmhook_boo_valley_postslist_before' => esc_html_x( 'Before Posts List', 'Website hook name.', 'boo-valley' ),
							'wmhook_boo_valley_postslist_after'  => esc_html_x( 'After Posts List', 'Website hook name.', 'boo-valley' ),
						),
					),

					array(
						'label' => esc_html_x( 'Child Pages List', 'Website hooks category name.', 'boo-valley' ),
						'hooks' => array(
							'wmhook_boo_valley_loop_child_pages_before' => esc_html_x( 'Before Child Pages List', 'Website hook name.', 'boo-valley' ),
							'wmhook_boo_valley_loop_child_pages_after'  => esc_html_x( 'After Child Pages List', 'Website hook name.', 'boo-valley' ),
						),
					),

					array(
						'label' => esc_html_x( 'Sidebar', 'Website hooks category name.', 'boo-valley' ),
						'hooks' => array(
							'tha_sidebars_before' => esc_html_x( 'Before Sidebar', 'Website hook name.', 'boo-valley' ),
							'tha_sidebar_top'     => esc_html_x( 'Sidebar Top', 'Website hook name.', 'boo-valley' ),
							'tha_sidebar_bottom'  => esc_html_x( 'Sidebar Bottom', 'Website hook name.', 'boo-valley' ),
							'tha_sidebars_after'  => esc_html_x( 'After Sidebar', 'Website hook name.', 'boo-valley' ),
						),
					),

					array(
						'label' => esc_html_x( 'Footer', 'Website hooks category name.', 'boo-valley' ),
						'hooks' => array(
							'tha_footer_before' => esc_html_x( 'Before Footer', 'Website hook name.', 'boo-valley' ),
							'tha_footer_top'    => esc_html_x( 'Footer Top', 'Website hook name.', 'boo-valley' ),
							'tha_footer_bottom' => esc_html_x( 'Footer Bottom', 'Website hook name.', 'boo-valley' ),
							'tha_footer_after'  => esc_html_x( 'After Footer', 'Website hook name.', 'boo-valley' ),

							'wmhook_boo_valley_site_info_before' => esc_html_x( 'Before Site Info', 'Website hook name.', 'boo-valley' ),
							'wmhook_boo_valley_site_info_after'  => esc_html_x( 'After Site Info', 'Website hook name.', 'boo-valley' ),
						),
					),

				);

		} // /parts





	/**
	 * 100) Others
	 */

		/**
		 * Disable sidebar
		 *
		 * @since    1.4.0
		 * @version  1.4.0
		 */
		public static function sidebar_disable() {

			// Helper variables

				$layouts      = array_keys( (array) FLThemeBuilderLayoutData::get_current_page_layouts() );
				$disable_here = array( 'singular', '404', 'archive' );


			// Processing

				if ( count( array_intersect( $layouts, $disable_here ) ) ) {
					add_filter( 'wmhook_boo_valley_sidebar_disable', '__return_true' );
				}

		} // /sidebar_disable





} // /Boo_Valley_Beaver_Themer

add_action( 'after_setup_theme', 'Boo_Valley_Beaver_Themer::init' );
