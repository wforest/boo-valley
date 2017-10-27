<?php
/**
 * Schema.org Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.3.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Get
 * 20) Set
 * 30) Disable
 */
class Boo_Valley_Schema {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'tha_entry_top', __CLASS__ . '::entry_container_meta', -10 );

					// Filters

						add_filter( 'wmhook_boo_valley_entry_container_atts', __CLASS__ . '::entry_container_atts' );

						add_filter( 'wmhook_boo_valley_theme_options', __CLASS__ . '::options' );

						add_filter( 'wmhook_boo_valley_schema_pre', __CLASS__ . '::disable', 9999 );

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
	 * 10) Get
	 */

		/**
		 * Schema.org function wrapper
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 *
		 * @param  string  $element
		 * @param  boolean $output_meta_tag
		 */
		public static function get( $element = '', $output_meta_tag = false ) {

			// Pre

				$pre = apply_filters( 'wmhook_boo_valley_schema_pre', false, $element, $output_meta_tag );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				if ( empty( $element ) ) {
					return;
				}


			// Helper variables

				$output = '';
				$base   = esc_attr( apply_filters( 'wmhook_boo_valley_schema_base', 'https://schema.org/', $element, $output_meta_tag ) );

				// Add custom post types that describe a single item to this array

					$creative_work_array = (array) apply_filters( 'wmhook_boo_valley_schema_creative_work_array', array( 'jetpack-portfolio' ), $element, $output_meta_tag );


			// Processing

				switch ( $element ) {

					case 'author':
							$output = 'itemprop="author"';
						break;

					case 'Brand':
							$output = 'itemscope itemtype="' . $base . 'Brand"';
						break;

					case 'BreadcrumbList':
							$output = 'itemscope itemtype="' . $base . 'BreadcrumbList"';
						break;

					case 'datePublished':
							$output = 'itemprop="datePublished"';
						break;

					case 'dateModified':
							$output = 'itemprop="dateModified"';
						break;

					case 'entry':
							$output = 'itemscope ';

							if ( is_page() ) {
								$output .= 'itemtype="' . $base . 'WebPage"';

							} elseif ( is_singular( $creative_work_array ) ) {
								$output .= 'itemtype="' . $base . 'CreativeWork"';

							} else {
								if ( ! is_single( get_the_ID() ) ) {
									$output .= 'itemprop="itemListElement" ';
								}
								$output .= 'itemtype="' . $base . 'BlogPosting"';

							}
						break;

					case 'entry_body':
							if ( ! is_single( get_the_ID() ) || is_singular( $creative_work_array ) ) {
								$output = 'itemprop="description"';

							} else {
								$output = 'itemprop="articleBody"';

							}
						break;

					case 'headline':
							$output = 'itemprop="headline"';
						break;

					case 'height':
							$output = 'itemprop="height"';
						break;

					case 'image':
							$output = 'itemprop="image" itemscope itemtype="' . $base . 'ImageObject"';
						break;

					case 'ItemList':
							$output = 'itemscope itemtype="' . $base . 'ItemList"';
						break;

					case 'keywords':
							$output = 'itemprop="keywords"';
						break;

					case 'mainContentOfPage':
							$output = 'itemprop="mainContentOfPage"';
						break;

					case 'mainEntityOfPage':
							$output = 'itemscope itemprop="mainEntityOfPage" itemType="' . $base . 'WebPage"';
						break;

					case 'name':
							$output = 'itemprop="name"';
						break;

					case 'Person':
							$output = 'itemscope itemtype="' . $base . 'Person"';
						break;

					case 'ProfilePage':
							$output = 'itemscope itemtype="' . $base . 'ProfilePage"';
						break;

					case 'SiteNavigationElement':
							$output = 'itemscope itemtype="' . $base . 'SiteNavigationElement"';
						break;

					case 'url':
							$output = 'itemprop="url"';
						break;

					case 'WebPage':
							if ( ! is_singular() ) {
								$output .= 'itemscope itemtype="' . $base . 'WebPage"';
							}
						break;

					case 'width':
							$output = 'itemprop="width"';
						break;

					case 'WPFooter':
							$output = 'itemscope itemtype="' . $base . 'WPFooter"';
						break;

					case 'WPSideBar':
							$output = 'itemscope itemtype="' . $base . 'WPSideBar"';
						break;

					case 'WPHeader':
							$output = 'itemscope itemtype="' . $base . 'WPHeader"';
						break;

					default:
							$output = $element;
						break;

				} // /switch

				$output = ' ' . $output;

				// Output in <meta> tag

					if ( $output_meta_tag ) {
						if ( is_string( $output_meta_tag ) ) {
							$output .= ' content="' . esc_attr( trim( $output_meta_tag ) ) . '"';
						} else {
							$output .= ' content="true"';
						}
						$output = '<meta ' . trim( $output ) . ' />';
					}


			// Output

				return $output;

		} // /get





	/**
	 * 20) Set
	 */

		/**
		 * Entry container attributes
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function entry_container_atts() {

			// Output

				return (string) self::get( 'entry' );

		} // /entry_container_atts



		/**
		 * Entry Schema.org meta
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 */
		public static function entry_container_meta() {

			// Requirements check

				if ( ! Boo_Valley_Post::is_singular() ) {
					return;
				}


			// Output

				echo self::get( 'mainEntityOfPage', true );

		} // /entry_container_meta





	/**
	 * 30) Disable
	 */

		/**
		 * Disabling theme microformats
		 *
		 * @since    1.3.0
		 * @version  1.3.0
		 *
		 * @param  boolean/string $pre
		 */
		public static function disable( $pre ) {

			// Output

				return ( get_theme_mod( 'others_disable_schema', false ) ) ? ( '' ) : ( $pre );

		} // /disable



		/**
		 * Theme options addons and modifications
		 *
		 * @since    1.3.0
		 * @version  1.3.0
		 *
		 * @param  array $options
		 */
		public static function options( $options = array() ) {

			// Processing

				$options[ 950 . 'others' . 200 ] = array(
						'type'        => 'checkbox',
						'id'          => 'others_disable_schema',
						'label'       => esc_html__( 'Disable theme microformats markup', 'boo-valley' ),
						'description' => esc_html__( 'If you are using a dedicated plugin for microformats, it is recommended to disable the theme microformats markup here.', 'boo-valley' ),
						'default'     => false,
						'preview_js'  => false, // This is to prevent customizer preview reload
					);


			// Output

				return $options;

		} // /options





} // /Boo_Valley_Schema

add_action( 'after_setup_theme', 'Boo_Valley_Schema::init' );
