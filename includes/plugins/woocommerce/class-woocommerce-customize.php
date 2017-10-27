<?php
/**
 * WooCommerce: Customize Class
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
 * 10) Files
 * 20) Styles
 * 30) Options
 */
class Boo_Valley_WooCommerce_Customize {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'customize_register', __CLASS__ . '::options_pointers' );

					// Filters

						add_filter( 'wmhook_boo_valley_css_files', __CLASS__ . '::theme_css_files', 10, 2 );

						add_filter( 'wmhook_boo_valley_custom_styles_custom_types', __CLASS__ . '::custom_styles' );

						add_filter( 'wmhook_boo_valley_custom_styles_array', __CLASS__ . '::custom_styles_array', 10, 3 );

						add_filter( 'wmhook_boo_valley_theme_options', __CLASS__ . '::options' );

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
	 * 10) Files
	 */

		/**
		 * Register custom WooCommerce stylesheets
		 *
		 * Adding custom CSS stylesheets with static styles
		 * into these generator files:
		 * - `css-generate/generate-css.php`
		 * - `css-generate/generate-css-rtl.php`
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array  $files
		 * @param  string $scope
		 */
		public static function theme_css_files( $files = array(), $scope = '' ) {

			// Processing

				if ( empty( $scope ) ) {

					// WooCommerce styles

						$files[90] = 'assets/css/woocommerce.css';

				} elseif ( 'rtl' === $scope ) {

					// RTL WooCommerce styles

						$files[90] = 'assets/css/woocommerce-rtl.css';

				}


			// Output

				return $files;

		} // /theme_css_files



		/**
		 * Register custom WooCommerce stylesheets
		 *
		 * Adding custom CSS stylesheet with customize variables
		 * into `css-generate/custom-style.php` generator file.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $file_types
		 */
		public static function custom_styles( $file_types = array() ) {

			// Processing

				$file_types['frontend'][] = 'woocommerce';


			// Output

				return $file_types;

		} // /custom_styles





	/**
	 * 20) Styles
	 */

		/**
		 * Helper CSS selectors in array
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  string $key
		 */
		public static function css_selectors( $key = '' ) {

			// Pre

				$pre = apply_filters( 'wmhook_boo_valley_woocommerce_customize_css_selectors_pre', false, $key );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output = array();


			// Processing

				// Header colors selectors

					$output['color_header_background'] = array(

							'as_background' => array(
								'.header-shopping-cart .widget',
							),

						);

				// Content colors selectors

					$output['color_content_background'] = array(

							'as_background' => array(
								'ul.products .product .onsale',
								'ul.products .product .star-rating',
							),

							'as_box_shadow' => array(
								'ul.products .product .star-rating',
							),

						);

					$output['color_content_text'] = array(

							'as_background_gradient' => array(
								'ul.order_details::after',
								'ul.order_details::before',
							),

						);

					$output['color_content_headings'] = array(

							'as_color' => array(
								'.shop_table th',
								'.onsale',
								'.variations',
								'.quantity',
								'.single-product .summary .price',
							),

						);

				// Content width selectors

					$output['content_width'] = array(

							'full' => array(
								// All the selectors with `@extend %wc_content_width;` from SASS files // $content_width
								'.related',
								'.single-product .summary-container-inner',
								'.woocommerce-tabs .panel',
								'.content-layout-no-paddings .woocommerce-tabs .woocommerce-Tabs-panel--description',
								'.content-layout-no-paddings .woocommerce-tabs .woocommerce-Tabs-panel--description > h2:first-child',
								'.fl-builder .woocommerce-tabs .woocommerce-Tabs-panel--description > h2:first-child',
								'.product-widgets-inner',
							),

						);

				$output = (array) apply_filters( 'wmhook_boo_valley_woocommerce_customize_css_selectors', $output, $key );


			// Output

				return ( isset( $output[ $key ] ) ) ? ( (array) $output[ $key ] ) : ( $output );

		} // /css_selectors



		/**
		 * Add custom WooCommerce styles
		 *
		 * Adding custom CSS into `css-generate/custom-style.php` generator
		 * file dynamic styles processor.
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @uses  `wmhook_boo_valley_custom_styles_array` filter hook
		 *
		 * @param  array   $custom_styles
		 * @param  boolean $visual_editor
		 * @param  array   $helper
		 */
		public static function custom_styles_array( $custom_styles = array(), $visual_editor = false, $helper = array() ) {

			// Helper variables

				$selectors = (array) self::css_selectors();

				$selectors_default = ( isset( $custom_styles['layout-width-content']['selector'] ) ) ? ( $custom_styles['layout-width-content']['selector'] ) : ( '' );

				if ( ! empty( $selectors_default ) ) {
					$selectors_default .= ', ';
				}


			// Processing

				if ( ! $visual_editor ) {

					// Adding WooCommerce CSS selectors with `@extend %wc_content_width;` defined // $content_width

						if ( isset( $selectors['content_width']['full'] ) ) {
							$custom_styles['layout-width-content']['selector'] = $selectors_default . implode( ', ', $selectors['content_width']['full'] );
						}

					// Product gallery image max width.
					// From `woocommerce/main/__gallery.scss` SASS file.

						$custom_styles['woocommerce-product-gallery-media-query-open'] = array(
							'custom' => "\t" . '@media only screen and (min-width: 55em) {',
						);

							$custom_styles['woocommerce-product-gallery'] = array(
								'selector' => '.woocommerce-product-gallery__image',
								'styles'   => array(
									'max-width|1' => absint( ( .62 - .04 ) * $helper['layout_width_content'] ) . 'px',
									'max-width|2' => ( ( .62 - .04 ) * $helper['layout_width_content'] / $helper['typography_size_html'] ) . 'rem',
								),
							);

						$custom_styles['woocommerce-product-gallery-media-query-close'] = array(
							'custom' => "\t" . '}',
						);

				} else {

					$custom_styles['editor-layout-width-excerpt-product'] = array(
							'selector' => '.mce-content-body.post-type-product.excerpt',
							'styles'   => array(
								// From `/assets/scss/woocommerce/main/__single.scss`
								'max-width' => ( $helper['layout_width_content'] * .36 + 40 ) . 'px',
							)
						);

				}


			// Output

				return $custom_styles;

		} // /custom_styles_array





	/**
	 * 30) Options
	 */

		/**
		 * Theme options addons and modifications
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  array $options
		 */
		public static function options( $options = array() ) {

			// Helper variables

				$selectors = (array) self::css_selectors();


			// Processing

				// Preview JS for header colors

					if ( isset( $selectors['color_header_background']['as_background'] ) ) {
						$options[ 100 . 'colors' . 20 . 110 ]['preview_js']['css'][ implode( ', ', $selectors['color_header_background']['as_background'] ) ] = array(
								'background-color'
							);
					}

				// Preview JS for content colors

					if ( isset( $selectors['color_content_background']['as_background'] ) ) {
						$options[ 100 . 'colors' . 30 . 110 ]['preview_js']['css'][ implode( ', ', $selectors['color_content_background']['as_background'] ) ] = array(
								'background-color'
							);
					}

					if ( isset( $selectors['color_content_background']['as_box_shadow'] ) ) {
						$options[ 100 . 'colors' . 30 . 110 ]['preview_js']['css'][ implode( ', ', $selectors['color_content_background']['as_box_shadow'] ) ] = array(
								array(
									'property' => 'box-shadow',
									'prefix'   => '0 0 0 .62em ',
								),
							);
					}

					if ( isset( $selectors['color_content_text']['as_background_gradient'] ) ) {
						$options[ 100 . 'colors' . 30 . 120 ]['preview_js']['css'][ implode( ', ', $selectors['color_content_text']['as_background_gradient'] ) ] = array(
								array(
									'property' => 'background-image',
									'custom'   => 'linear-gradient( 45deg, [[value]] 25%, transparent 25%, transparent 75%, [[value]] 75%, [[value]] ), linear-gradient( -45deg, [[value]] 25%, transparent 25%, transparent 75%, [[value]] 75%, [[value]] )',
								),
							);
					}

					if ( isset( $selectors['color_content_headings']['as_color'] ) ) {
						$options[ 100 . 'colors' . 30 . 130 ]['preview_js']['css'][ implode( ', ', $selectors['color_content_headings']['as_color'] ) ] = array(
								'color'
							);
					}

				// Preview JS for `layout_width_content` option

					if ( isset( $selectors['content_width']['full'] ) ) {
						$options[ 300 . 'layout' . 130 ]['preview_js']['css'][ implode( ', ', $selectors['content_width']['full'] ) ] = array(
								array(
									'property' => 'max-width',
									'suffix'   => 'px',
								),
							);
					}

					// Product gallery image max width.
					// From `woocommerce/main/__gallery.scss` SASS file.

						$options[ 300 . 'layout' . 130 ]['preview_js']['css']['.woocommerce-product-gallery__image'] = array(
								'selector_before' => '@media only screen and (min-width: 55em) { ',
								'selector_after'  => ' }',
								array(
									'property' => 'width',
									'suffix'   => 'px !important',
								),
								array(
									'property' => 'max-width',
									'prefix'   => 'calc(.58*',
									'suffix'   => 'px) !important',
								),
							);

				// WooCommerce specific options

					$options = array_merge( $options, array(

							970 . 'woocommerce' => array(
								'id'             => 'woocommerce',
								'type'           => 'section',
								'create_section' => esc_html_x( 'Shop', 'Customizer section title.', 'boo-valley' ),
								'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
							),

								970 . 'woocommerce' . 100 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Single product page', 'boo-valley' ) . '</h3>',
								),

									970 . 'woocommerce' . 110 => array(
										'type'        => 'checkbox',
										'id'          => 'woocommerce_product_disable_intro',
										'label'       => esc_html__( 'Disable intro section', 'boo-valley' ),
										'description' => esc_html__( 'Removes intro section title on single product pages.', 'boo-valley' ),
										'default'     => false,
									),

									970 . 'woocommerce' . 120 => array(
										'type'        => 'checkbox',
										'id'          => 'woocommerce_product_background_shade',
										'label'       => esc_html__( 'Shaded product summary background', 'boo-valley' ),
										'description' => esc_html__( 'The color of the shade is calculated from content text color.', 'boo-valley' ),
										'default'     => true,
										'preview_js'  => array(
											'custom' => "jQuery( '.summary-container' ).toggleClass( 'has-shaded-background' );",
										),
									),

								970 . 'woocommerce' . 200 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Cart and Checkout', 'boo-valley' ) . '</h3>',
								),

									970 . 'woocommerce' . 210 => array(
										'type'    => 'checkbox',
										'id'      => 'woocommerce_cart_header',
										'label'   => esc_html__( 'Cart in header', 'boo-valley' ),
										'default' => true,
										// No need for `preview_js` here as we also need to load the scripts.
									),
									970 . 'woocommerce' . 220 => array(
										'type'        => 'checkbox',
										'id'          => 'woocommerce_checkout_guide',
										'label'       => esc_html__( 'Checkout guide', 'boo-valley' ),
										'description' => esc_html__( 'Enables the checkout process steps visualization.', 'boo-valley' ),
										'default'     => true,
										// No need for `preview_js` here as we also need to load the scripts.
									),

						) );


			// Output

				return $options;

		} // /options



		/**
		 * Theme options pointers
		 *
		 * @since    1.4.0
		 * @version  1.4.0
		 *
		 * @param  array $wp_customize  WP customizer object.
		 */
		public static function options_pointers( $wp_customize ) {

			// Processing

				$wp_customize->selective_refresh->add_partial( 'woocommerce_product_disable_intro', array(
						'selector' => '.single-product .intro-container',
					) );

				$wp_customize->selective_refresh->add_partial( 'woocommerce_product_background_shade', array(
						'selector' => '.single-product .summary-container',
					) );

				$wp_customize->selective_refresh->add_partial( 'woocommerce_cart_header', array(
						'selector' => '#header-shopping-cart',
					) );

				$wp_customize->selective_refresh->add_partial( 'woocommerce_checkout_guide', array(
						'selector' => '.checkout-guide',
					) );

		} // /options_pointers





} // /Boo_Valley_WooCommerce_Customize

add_action( 'after_setup_theme', 'Boo_Valley_WooCommerce_Customize::init' );
