<?php
/**
 * WooCommerce: Helpers Class
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
 * 10) Numbers
 * 20) Product
 */
class Boo_Valley_WooCommerce_Helpers {





	/**
	 * 0) Init
	 */

		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		private function __construct() {}





	/**
	 * 10) Numbers
	 */

		/**
		 * Helper setup function to return numbers depending on context
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 *
		 * @param  string $context  Which number to return.
		 */
		public static function return_number( $context = '' ) {

			// Helper variables

				$output = array();


			// Processing

				$output['shop_columns']         = 4;
				$output['shop_columns_sidebar'] = 2;

				$output['thumbnails_columns'] = ( version_compare( WC_VERSION, '3.0', '<' ) ) ? ( 20 ) : ( 4 );

				$output['cross_sells_total']   = 2;
				$output['cross_sells_columns'] = 1;

				$output = (array) apply_filters( 'wmhook_boo_valley_woocommerce_helpers_return_number', $output, $context );


			// Output

				return ( isset( $output[ $context ] ) ) ? ( absint( $output[ $context ] ) ) : ( 1 );

		} // /return_number





	/**
	 * 20) Product
	 */

		/**
		 * Get cart product ID
		 *
		 * @since    1.3.0
		 * @version  1.3.0
		 */
		public static function get_cart_product_id( $product ) {

			// Output

				return ( isset( $product['product_id'] ) ) ? ( $product['product_id'] ) : ( null );

		} // /get_cart_product_id



		/**
		 * Get product gallery image IDs
		 *
		 * @since    1.3.0
		 * @version  1.3.0
		 */
		public static function get_product_gallery_image_ids( $product ) {

			// Requirements check

				if ( ! is_a( $product, 'WC_Product' ) ) {
					return;
				}


			// Output

				if ( is_callable( 'WC_Product::get_gallery_image_ids' ) ) {
					return $product->get_gallery_image_ids();
				} else {
					return $product->get_gallery_attachment_ids();
				}

		} // /get_product_gallery_image_ids



		/**
		 * Get product upsells IDs
		 *
		 * @since    1.3.0
		 * @version  1.3.0
		 */
		public static function get_product_upsell_ids( $product ) {

			// Requirements check

				if ( ! is_a( $product, 'WC_Product' ) ) {
					return;
				}


			// Output

				if ( is_callable( 'WC_Product::get_upsell_ids' ) ) {
					return $product->get_upsell_ids();
				} else {
					return $product->get_upsells();
				}

		} // /get_product_upsell_ids





} // /Boo_Valley_WooCommerce_Helpers
