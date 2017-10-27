<?php
/**
 * WooCommerce: Loop Class
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
 *  10) Setup
 *  20) Categories
 *  30) Controls
 * 100) Others
 */
class Boo_Valley_WooCommerce_Loop {





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

					// Removing

						remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

						remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

						remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );

						remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );

					// Actions

						add_action( 'woocommerce_before_shop_loop', __CLASS__ . '::categories', 5 );

						add_action( 'woocommerce_before_shop_loop', __CLASS__ . '::products_sorting' );

						add_action( 'woocommerce_before_shop_loop', __CLASS__ . '::shop_loop_title', 100 );

						add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 5 );

						add_action( 'woocommerce_before_subcategory_title', __CLASS__ . '::category_label', 95 );

						add_action( 'woocommerce_after_subcategory', __CLASS__ . '::category_button', 20 );

						add_action( 'woocommerce_after_shop_loop', __CLASS__ . '::products_sorting', 5 );

						add_action( 'woocommerce_after_shop_loop', __CLASS__ . '::pagination' );

						add_action( 'wp', __CLASS__ . '::search_results' );

					// Filters

						add_filter( 'woocommerce_before_shop_loop', __CLASS__ . '::active_filters',  20 );
						add_filter( 'woocommerce_after_shop_loop',  __CLASS__ . '::active_filters', -10 );

						add_filter( 'woocommerce_pagination_args', __CLASS__ . '::pagination_args' );

						add_filter( 'loop_shop_columns', __CLASS__ . '::shop_columns' );

						add_filter( 'the_title', __CLASS__ . '::search_results_product_title', 10, 2 );

						add_filter( 'wmhook_boo_valley_summary_continue_reading_post_type', __CLASS__ . '::add_product_post_type' );

						add_filter( 'wmhook_boo_valley_post_media_image_size', __CLASS__ . '::product_media_size', 15 );

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
		 * Shop columns
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  integer $columns
		 */
		public static function shop_columns( $columns ) {

			// Processing

				if ( is_active_sidebar( 'sidebar' ) ) {
					$columns = Boo_Valley_WooCommerce_Helpers::return_number( 'shop_columns_sidebar' );
				}


			// Output

				return $columns;

		} // /shop_columns



		/**
		 * Product image size in search
		 *
		 * @since    1.4.0
		 * @version  1.4.0
		 *
		 * @param  string $image_size
		 */
		public static function product_media_size( $image_size ) {

			// Processing

				if (
						is_search()
						&& 'product' === get_post_type()
					) {
					$image_size = 'shop_catalog_image_size';
				}


			// Output

				return $image_size;

		} // /product_media_size





	/**
	 * 20) Categories
	 */

		/**
		 * Display list of (sub)categories
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function categories() {

			// Requirements check

				if (
						is_paged()
						|| is_filtered()
						|| is_search()
						|| ! ( is_shop() || is_tax( 'product_cat' ) )
						|| ( is_shop() && 'both' !== get_option( 'woocommerce_shop_page_display' ) )
						|| ( is_tax( 'product_cat' ) && 'both' !== get_option( 'woocommerce_category_archive_display' ) )
					) {
					return;
				}


			// Output

				get_template_part( 'templates/parts/loop', 'categories-product' );

				add_filter( 'pre_option_woocommerce_shop_page_display', '__return_empty_string' );

				add_filter( 'pre_option_woocommerce_category_archive_display', '__return_empty_string' );

		} // /categories



		/**
		 * Category description top
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function category_label() {

			// Output

				echo '<p class="category-label">' . esc_html__( 'Shop Category', 'boo-valley' ) . '</p>';

		} // /category_label



		/**
		 * Category description bottom
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  object $category
		 */
		public static function category_button( $category = null ) {

			// Helper variables

				$term_link = get_term_link( $category, 'product_cat' );


			// Requirements check

				if ( empty( $term_link ) || is_wp_error( $term_link ) ) {
					return;
				}


			// Output

				echo '<a href="' . esc_url( $term_link ) . '" class="button">' . esc_html__( 'Shop Now &rarr;', 'boo-valley' ) . '</a>';

		} // /category_button





	/**
	 * 30) Controls
	 */

		/**
		 * Products sorting
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function products_sorting() {

			// Output

				echo '<div class="products-sorting">';

					woocommerce_result_count();
					woocommerce_catalog_ordering();

				echo '</div>';

		} // /products_sorting



		/**
		 * Active filters
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function active_filters() {

			// Helper variables

				$widget = 'WC_Widget_Layered_Nav_Filters';


			// Requirements check

				if ( ! class_exists( $widget ) ) {
					return;
				}


			// Output

				the_widget( $widget );

		} // /active_filters



		/**
		 * Pagination
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function pagination() {

			// Processing

				ob_start();
				wc_get_template( 'loop/pagination.php' );

				global $wp_query;

				$total   = ( isset( $wp_query->max_num_pages ) ) ? ( $wp_query->max_num_pages ) : ( 1 );
				$current = ( get_query_var( 'paged' ) ) ? ( absint( get_query_var( 'paged' ) ) ) : ( 1 );

				$html = str_replace(
						'<nav class="woocommerce-pagination">',
						'<nav class="woocommerce-pagination pagination" role="navigation" aria-labelledby="pagination-label" data-current="' . esc_attr( $current ) . '" data-total="' . esc_attr( $total ) . '">'
						. '<h2 class="screen-reader-text" id="pagination-label">' . esc_attr__( 'Products Navigation', 'boo-valley' ) . '</h2>',
						ob_get_clean()
					);


			// Output

				echo $html;

		} // /pagination



		/**
		 * Pagination setup
		 *
		 * @since    1.0.0
		 * @version  1.4.3
		 *
		 * @param  array $args
		 */
		public static function pagination_args( $args = array() ) {

			// Processing

				$args['type'] = 'plain';

				$args['prev_text'] = esc_html_x( '&laquo;', 'Pagination text (visible): previous.', 'boo-valley' )
				                     . '<span class="screen-reader-text"> '
				                     . esc_html_x( 'Previous page', 'Pagination text (hidden): previous.', 'boo-valley' )
				                     . '</span>';

				$args['next_text'] = '<span class="screen-reader-text">'
				                     . esc_html_x( 'Next page', 'Pagination text (hidden): next.', 'boo-valley' )
				                     . ' </span>'
				                     . esc_html_x( '&raquo;', 'Pagination text (visible): next.', 'boo-valley' );


			// Output

				return (array) apply_filters( 'wmhook_boo_valley_pagination_args', $args, 'woocommerce' );

		} // /pagination_args





	/**
	 * 100) Others
	 */

		/**
		 * Products list title
		 *
		 * Adding heading to non-titled lists to improve accessibility.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  integer $columns
		 */
		public static function shop_loop_title() {

			// Output

				echo '<h2 class="screen-reader-text">' . esc_html__( 'List of products', 'boo-valley' ) . '</h2>';

		} // /shop_loop_title



		/**
		 * Fix search results list
		 *
		 * Removing WooCommerce body classes on blog search results page.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function search_results() {

			// Processing

				if ( is_search() && ! is_post_type_archive( 'product' ) ) {
					remove_filter( 'body_class', 'wc_body_class' );
				}

		} // /search_results



		/**
		 * Price in product title in global search
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 *
		 * @param  string $title The post title.
		 * @param  int    $id    The post ID.
		 */
		public static function search_results_product_title( $title, $id ) {

			// Requirements check

				if (
						! is_search()
						|| is_post_type_archive( 'product' )
						|| 'product' !== get_post_type( $id )
					) {
					return $title;
				}


			// Helper variables

				$product = wc_setup_product_data( $id );


			// Output

				return $title . ' <span class="price">' . $product->get_price_html() . '</span>';

		} // /search_results_product_title



		/**
		 * Allow theme features to work with products
		 *
		 * @since    1.0.1
		 * @version  1.0.1
		 *
		 * @param  array $post_types
		 */
		public static function add_product_post_type( $post_types = array() ) {

			// Processing

				$post_types[] = 'product';


			// Output

				return $post_types;

		} // /add_product_post_type





} // /Boo_Valley_WooCommerce_Loop

add_action( 'after_setup_theme', 'Boo_Valley_WooCommerce_Loop::init' );
