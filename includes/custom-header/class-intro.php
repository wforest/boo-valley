<?php
/**
 * Custom Header / Intro Class
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
 * 10) Setup
 * 20) Output
 * 30) Conditions
 * 40) Assets
 */
class Boo_Valley_Intro {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 */
		private function __construct() {

			// Processing

				// Setup

					self::setup();

				// Hooks

					// Actions

						add_action( 'tha_content_top', __CLASS__ . '::container', 15 );

						add_action( 'wmhook_boo_valley_intro', __CLASS__ . '::content' );

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::background_image', 120 );

					// Filters

						add_filter( 'wmhook_boo_valley_intro_disable', __CLASS__ . '::disable', 5 );

						add_filter( 'wmhook_boo_valley_intro_background_image_url', __CLASS__ . '::custom_image', 10, 2 );

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
		 * Setup custom header
		 *
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Custom_Header
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 */
		public static function setup() {

			// Helper variables

				$image_sizes = array_filter( apply_filters( 'wmhook_boo_valley_setup_image_sizes', array() ) );


			// Processing

				add_theme_support( 'custom-header', apply_filters( 'wmhook_boo_valley_custom_header_args', array(
						'random-default'     => true,
						'default-text-color' => 'ffffff',
						'width'              => ( isset( $image_sizes['boo_valley-intro'] ) ) ? ( $image_sizes['boo_valley-intro'][0] ) : ( 1920 ),
						'height'             => ( isset( $image_sizes['boo_valley-intro'] ) ) ? ( $image_sizes['boo_valley-intro'][1] ) : ( 1080 ),
						'flex-height'        => true,
						'flex-width'         => true,
					) ) );

				// Default custom headers packed with the theme

					register_default_headers( array(

							'architecture' => array(
								'url'           => '%s/assets/images/header/architecture.jpg',
								'thumbnail_url' => '%s/assets/images/header/thumbnail/architecture.jpg',
								'description'   => esc_html_x( 'Architecture', 'Header image description.', 'boo-valley' ),
							),

							'canyon' => array(
								'url'           => '%s/assets/images/header/canyon.jpg',
								'thumbnail_url' => '%s/assets/images/header/thumbnail/canyon.jpg',
								'description'   => esc_html_x( 'Canyon', 'Header image description.', 'boo-valley' ),
							),

							'city' => array(
								'url'           => '%s/assets/images/header/city.jpg',
								'thumbnail_url' => '%s/assets/images/header/thumbnail/city.jpg',
								'description'   => esc_html_x( 'City', 'Header image description.', 'boo-valley' ),
							),

							'forest' => array(
								'url'           => '%s/assets/images/header/forest.jpg',
								'thumbnail_url' => '%s/assets/images/header/thumbnail/forest.jpg',
								'description'   => esc_html_x( 'Forest', 'Header image description.', 'boo-valley' ),
							),

							'gooseneck' => array(
								'url'           => '%s/assets/images/header/gooseneck.jpg',
								'thumbnail_url' => '%s/assets/images/header/thumbnail/gooseneck.jpg',
								'description'   => esc_html_x( 'Gooseneck', 'Header image description.', 'boo-valley' ),
							),

							'boo-valley' => array(
								'url'           => '%s/assets/images/header/boo-valley.jpg',
								'thumbnail_url' => '%s/assets/images/header/thumbnail/boo-valley.jpg',
								'description'   => esc_html_x( 'Boo Valley', 'Header image description.', 'boo-valley' ),
							),

							'trees' => array(
								'url'           => '%s/assets/images/header/trees.jpg',
								'thumbnail_url' => '%s/assets/images/header/thumbnail/trees.jpg',
								'description'   => esc_html_x( 'Trees', 'Header image description.', 'boo-valley' ),
							),

							'woodland' => array(
								'url'           => '%s/assets/images/header/woodland.jpg',
								'thumbnail_url' => '%s/assets/images/header/thumbnail/woodland.jpg',
								'description'   => esc_html_x( 'Woodland', 'Header image description.', 'boo-valley' ),
							),

						) );

		} // /setup





	/**
	 * 20) Output
	 */

		/**
		 * Container
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 */
		public static function container() {

			// Pre

				$disable = (bool) apply_filters( 'wmhook_boo_valley_intro_disable', false );

				$pre = apply_filters( 'wmhook_boo_valley_intro_container_pre', $disable );

				if ( false !== $pre ) {
					if ( true !== $pre ) {
						echo $pre;
					}
					return;
				}


			// Processing

				get_template_part( 'templates/parts/component-intro', 'container' );

		} // /container



		/**
		 * Content
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 */
		public static function content() {

			// Helper variables

				$post_type = ( is_singular() ) ? ( get_post_type() ) : ( '' );


			// Processing

				get_template_part( 'templates/parts/component-intro-content', $post_type );

		} // /content





	/**
	 * 30) Conditions
	 */

		/**
		 * Disabling conditions
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 *
		 * @param  boolean $disable
		 */
		public static function disable( $disable = false ) {

			// Helper variables

				// Check if is_singular() to prevent issues in archives

					$meta_no_intro = ( is_singular() ) ? ( get_post_meta( get_the_ID(), 'no_intro', true ) ) : ( '' );


			// Output

				return ( is_front_page() && ! is_page() ) || is_404() || is_attachment() || ! empty( $meta_no_intro );

		} // /disable





	/**
	 * 40) Assets
	 */

		/**
		 * Background image
		 *
		 * @uses  `wmhook_boo_valley_esc_css` global hook
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 */
		public static function background_image() {

			// Pre

				$disable = (bool) apply_filters( 'wmhook_boo_valley_intro_disable', false );

				$pre = apply_filters( 'wmhook_boo_valley_intro_background_image_pre', $disable );

				if ( false !== $pre ) {
					if ( true !== $pre ) {
						echo $pre;
					}
					return;
				}


			// Helper variables

				$output = $image_url = '';

				$image_size = 'large';

				$post_id = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );


			// Processing

				// Use featured image when appropriate

					if (
							( is_singular() || is_home() )
							&& has_post_thumbnail( $post_id )
						) {

						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $image_size );
						$image_url = $image_url[0];

					}

				// Custom Header image fallback

					if ( empty( $image_url ) ) {
						$image_url = get_header_image();
					}

				// Filter image URL

					$image_url = apply_filters( 'wmhook_boo_valley_intro_background_image_url', $image_url, $image_size );

				// Preparing CSS output

					$output .= ".intro-container { background-image: url('" . esc_url_raw( $image_url ) . "'); }" . "\r\n\r\n";


			// Output

				if ( $image_url ) {
					wp_add_inline_style( 'boo_valley-stylesheet', apply_filters( 'wmhook_boo_valley_esc_css', $output ) );
				} else {
					add_filter( 'wmhook_boo_valley_intro_class_no_image', '__return_true' );
				}

				return $image_url;

		} // /background_image



		/**
		 * Custom intro background image
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $intro_image
		 * @param  string $image_size
		 */
		public static function custom_image( $image_url = '', $image_size = 'large' ) {

			// Pre

				$pre = apply_filters( 'wmhook_boo_valley_intro_custom_image_pre', false, $image_url, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				if ( ! Boo_Valley_Post::is_singular() ) {
					return $image_url;
				}


			// Helper variables

				$image = trim( get_post_meta( get_the_ID(), 'intro_image', true ) );


			// Requirements check

				if ( empty( $image ) ) {
					return $image_url;
				}


			// Processing

				if ( is_numeric( $image ) ) {
					$image_url = wp_get_attachment_image_src( absint( $image ), $image_size );
					$image_url = $image_url[0];
				} else {
					$image_url = (string) $image;
				}


			// Output

				return $image_url;

		} // /custom_image





} // /Boo_Valley_Intro

add_action( 'after_setup_theme', 'Boo_Valley_Intro::init' );
