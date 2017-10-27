<?php
/**
 * WooCommerce: Single Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.4.3
 *
 * Contents:
 *
 *   0) Init
 *  10) Intro
 *  20) Image
 *  30) Tabs
 *  40) Loops
 *  50) Custom fields
 * 100) Others
 */
class Boo_Valley_WooCommerce_Single {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.4.3
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Removing

						remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

						remove_action( 'woocommerce_before_single_product', 'wc_print_notices' );

						remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );

						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );

						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

						remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

						remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

					// Actions

						add_action( 'init', __CLASS__ . '::acf', 9 );

						add_action( 'wp', __CLASS__ . '::display_title' );

						add_action( 'woocommerce_before_single_product_summary', __CLASS__ . '::schema_name', -10 );

						add_action( 'woocommerce_before_single_product_summary', 'wc_print_notices', -5 );

						add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 5 );

						add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing' );

						add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

						add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 15 );

						add_action( 'woocommerce_after_single_product_summary', __CLASS__ . '::related_products', 100 );

					// Filters

						add_filter( 'template_include', __CLASS__ . '::product_page_template_load', 99 );

						add_filter( 'wmhook_boo_valley_intro_disable', __CLASS__ . '::intro_disable' );

						add_filter( 'wmhook_boo_valley_intro_background_image_url', __CLASS__ . '::intro_image', 5, 2 );

						add_filter( 'woocommerce_get_price_html', __CLASS__ . '::price_separator' );

						add_filter( 'woocommerce_product_thumbnails_columns', __CLASS__ . '::product_thumbnails_columns' );

						add_filter( 'woocommerce_single_product_image_thumbnail_html', __CLASS__ . '::image_gallery_item' );
						add_filter( 'woocommerce_single_product_image_html',           __CLASS__ . '::image_gallery_item' );

						add_filter( 'woocommerce_short_description', __CLASS__ . '::read_more_link', 5 );

						add_filter( 'woocommerce_product_tabs', __CLASS__ . '::product_tabs' );

						add_filter( 'woocommerce_comment_pagination_args', __CLASS__ . '::comment_pagination_args' );

						add_filter( 'woocommerce_upsell_display_args',          __CLASS__ . '::products_list_args' );
						add_filter( 'woocommerce_output_related_products_args', __CLASS__ . '::products_list_args' );

						add_filter( 'wmhook_boo_valley_post_navigation_post_type', __CLASS__ . '::post_navigation' );

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
	 * 10) Intro
	 */

		/**
		 * Disable intro?
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  boolean $disable
		 */
		public static function intro_disable( $disable = false ) {

			// Requirements check

				if ( ! is_product() ) {
					return $disable;
				}


			// Output

				return get_theme_mod( 'woocommerce_product_disable_intro', false ) || is_page_template( 'templates/no-intro.php' );

		} // /intro_disable



		/**
		 * Intro background image
		 *
		 * Do not use a product thumbnail as an intro background (fall back
		 * to custom header image).
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $intro_image
		 * @param  string $image_size
		 */
		public static function intro_image( $image_url = '', $image_size = 'large' ) {

			// Requirements check

				if (
						! is_product()
						|| self::intro_disable()
					) {
					return $image_url;
				}


			// Output

				return get_header_image();

		} // /intro_image



		/**
		 * Where to display product title and breadcrumbs?
		 *
		 * Has to be hooked when main query is accessible.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function display_title() {

			// Requirements check

				if ( ! is_product() ) {
					return;
				}


			// Processing

				if ( ! self::intro_disable() ) {

					remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

				} else {

					add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 4 );

				}

		} // /display_title





	/**
	 * 20) Image
	 */

		/**
		 * Product thumbnails columns
		 *
		 * For styling product thumbnails aside the product image.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  integer $columns
		 */
		public static function product_thumbnails_columns( $columns ) {

			// Output

				return Boo_Valley_WooCommerce_Helpers::return_number( 'thumbnails_columns' );

		} // /product_thumbnails_columns



		/**
		 * Wrap images with figure.gallery-item
		 *
		 * Treating product images as a gallery improves compatibility
		 * with image lightbox plugins such as WP FeatherLight.
		 *
		 * IMPORTANT: This is not needed in WC 3.0+, remove in WC 3.2
		 *
		 * @since    1.0.0
		 * @version  1.3.1
		 *
		 * @param  string $html
		 */
		public static function image_gallery_item( $html ) {

			// Requirements check

				if (
						strpos( $html, '</figure>' )
						|| strpos( $html, 'woocommerce-product-gallery__image' )
					) {
					return $html;
				}


			// Output

				return '<figure class="gallery-item product-image">' . $html . '</figure>';

		} // /image_gallery_item





	/**
	 * 30) Tabs
	 */

		/**
		 * Tabs
		 *
		 * Default tabs:
		 * - descriptions
		 * - additional information
		 * - reviews (comments)
		 *
		 * Adding new tabs:
		 * - upsells
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 *
		 * @param  array $tabs
		 */
		public static function product_tabs( $tabs = array() ) {

			// Helper variables

				global $product;


			// Processing

				// Reviews tab - shows comments

					if ( Boo_Valley_WooCommerce_Helpers::get_product_upsell_ids( $product ) ) {

						$tabs['upsells'] = array(
							'title'    => esc_html__( 'You may also like&hellip;', 'boo-valley' ),
							'priority' => 40,
							'callback' => 'woocommerce_upsell_display'
						);

					}


			// Output

				return $tabs;

		} // /product_tabs



		/**
		 * Product comments pagination setup
		 *
		 * @since    1.0.0
		 * @version  1.4.3
		 *
		 * @param  array $args
		 */
		public static function comment_pagination_args( $args = array() ) {

			// Processing

				$args['prev_text'] = esc_html_x( '&laquo;', 'Pagination text (visible): previous.', 'boo-valley' ) . '<span class="screen-reader-text"> ' . esc_html_x( 'Previous page', 'Pagination text (hidden): previous.', 'boo-valley' ) . '</span>';
				$args['next_text'] = '<span class="screen-reader-text">' . esc_html_x( 'Next page', 'Pagination text (hidden): next.', 'boo-valley' ) . ' </span>' . esc_html_x( '&raquo;', 'Pagination text (visible): next.', 'boo-valley' );
				$args['type']      = 'plain';


			// Output

				return (array) apply_filters( 'wmhook_boo_valley_pagination_args', $args, 'woocommerce-comments' );

		} // /comment_pagination_args





	/**
	 * 40) Loops
	 */

		/**
		 * Up-sells and related products setup
		 *
		 * Setting up number of posts per page and number of columns.
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 *
		 * @param  array $args
		 */
		public static function products_list_args( $args ) {

			// Processing

				$args['posts_per_page'] = $args['columns'] = Boo_Valley_WooCommerce_Helpers::return_number( 'shop_columns' );


			// Output

				return $args;

		} // /products_list_args



		/**
		 * Related products
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 */
		public static function related_products() {

			// Output

				self::product_loop_container( 'related' );

		} // /related_products



		/**
		 * Wrapping multiple product loops in a container for additional styling
		 *
		 * @since    1.3.0
		 * @version  1.4.0
		 */
		public static function product_loop_container( $scope = '' ) {

			// Requirements check

				if ( ! is_product() ) {
					return;
				}


			// Helper variables

				if ( empty( $scope ) ) {
					$scope = 'related';
				}


			// Processing

				ob_start();

				if ( 'upsells' === $scope ) {
					woocommerce_upsell_display();
				} else {
					woocommerce_output_related_products();
				}


			// Output

				if ( $output = ob_get_clean() ) {
					echo '<aside class="products-container ' . esc_attr( $scope ) . '-container">' . $output . '</aside>';
				}

		} // /product_loop_container





	/**
	 * 50) Custom fields
	 */

		/**
		 * Product metaboxes
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 */
		public static function acf() {

			// Requirements check

				if (
						! function_exists( 'register_field_group' )
						|| get_theme_mod( 'woocommerce_product_disable_intro', false )
					) {
					return;
				}


			// Processing

				// Single product options

					register_field_group( (array) apply_filters( 'wmhook_boo_valley_acf_register_field_group', array(
						'id'     => 'boo_valley_intro_image',
						'title'  => esc_html__( 'Intro image', 'boo-valley' ),
						'fields' => array (

							// Custom intro image

								100 => array (
									'key'           => 'boo_valley_intro_image',
									'label'         => esc_html__( 'Intro section image', 'boo-valley' ),
									'instructions'  => esc_html__( 'Here you can override the default Intro section image with a custom one.', 'boo-valley' ),
									'name'          => 'intro_image',
									'type'          => 'image',
									'save_format'   => 'id',
									'preview_size'  => 'thumbnail',
									'library'       => 'all',
								),

						),
						'location' => array (

							// Display on Pages

								100 => array (

									100 => array (
										'param'    => 'post_type',
										'operator' => '==',
										'value'    => 'product',
										'order_no' => 0,
										'group_no' => 0,
									),

									200 => array (
										'param'    => 'page_template',
										'operator' => '!=',
										'value'    => 'templates/no-intro.php',
										'order_no' => 0,
										'group_no' => 1,
									),

								),

						),
						'options' => array (
							'position'       => 'side',
							'layout'         => 'default',
							'hide_on_screen' => array(),
						),
						'menu_order' => 0,
					), 'product' ) );

		} // /acf





	/**
	 * 100) Others
	 */

		/**
		 * Fix for page template assigned onto a product
		 *
		 * This will make sure we are actually loading the product post
		 * content, and not the content defined within the page template.
		 * Basically, we make sure the page template is used to provide
		 * HTML body class and post class, but we still want to display
		 * the actual product post content.
		 *
		 * This is also a fix for WooCommerce 3.2+ version.
		 *
		 * @since    1.4.3
		 * @version  1.4.3
		 *
		 * @param  string $template
		 */
		public static function product_page_template_load( $template ) {

			// Processing

				if (
						'product' === get_post_type()
						&& is_page_template()
						&& function_exists( 'wc_locate_template' )
					) {
					$template = wc_locate_template( 'single-product.php' );
				}


			// Output

				return $template;

		} // /product_page_template_load



		/**
		 * Price "from-to" separator
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function price_separator( $html ) {

			// Output

				return str_replace(
						array( '&ndash;', '&mdash;' ),
						array( '<span class="amount-separator">&ndash;</span>', '<span class="amount-separator">&mdash;</span>' ),
						$html
					);

		} // /price_separator



		/**
		 * Product Schema.org name
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function schema_name() {

			// Output

				echo Boo_Valley_Schema::get( 'name', get_the_title() );

		} // /schema_name



		/**
		 * Excerpt read more link
		 *
		 * IMPORTANT:
		 * With `$excerpt == $post->post_excerpt` below we make sure
		 * we are targeting product excerpt only! This is important
		 * as `woocommerce_short_description` filter this is hooked
		 * onto, is applied on other places too. Also, due to this
		 * check we need to hook the method before `wptexturize()`
		 * is applied.
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  string $excerpt
		 */
		public static function read_more_link( $excerpt ) {

			// Requirements check

				if ( ! is_product() ) {
					return $excerpt;
				}


			// Helper variables

				global $product, $post;


			// Processing

				if (
						$excerpt === $post->post_excerpt
						&& ( $post->post_content || $product->has_attributes() )
					) {
					$excerpt .= '<p class="product-description-link-container"><a href="#tab-description" class="product-description-link">' . esc_html__( 'More details&hellip;', 'boo-valley' ) . '</a></p>';
				}


			// Output

				return $excerpt;

		} // /read_more_link



		/**
		 * Enabling post navigation
		 *
		 * Adding `product` to post navigation enabled post types array.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $post_types
		 */
		public static function post_navigation( $post_types ) {

			// Processing

				$post_types[] = 'product';


			// Output

				return $post_types;

		} // /post_navigation





} // /Boo_Valley_WooCommerce_Single

add_action( 'after_setup_theme', 'Boo_Valley_WooCommerce_Single::init' );
