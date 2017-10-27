<?php
/**
 * WooCommerce: Pages Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.4.3
 *
 * Contents:
 *
 *  0) Init
 * 10) Title
 * 20) Page: Shop
 * 30) Page: Cart
 * 40) Page: Checkout
 * 50) Custom fields
 */
class Boo_Valley_WooCommerce_Pages {





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

					// Actions

						add_action( 'woocommerce_before_cart_table', __CLASS__ . '::cart_products_list_title' );

						add_action( 'woocommerce_before_checkout_form', __CLASS__ . '::checkout_title', 5 );

						add_action( 'woocommerce_cart_coupon', __CLASS__ . '::coupon_description' );

						add_action( 'woocommerce_proceed_to_checkout', __CLASS__ . '::button_continue_shopping', 30 );

						add_action( 'woocommerce_before_shipping_calculator', __CLASS__ . '::shipping_calculator_wrapper' );

						add_action( 'woocommerce_before_template_part', __CLASS__ . '::guide' );

						add_action( 'before_woocommerce_pay', __CLASS__ . '::guide_generator' );

						add_action( 'init', __CLASS__ . '::acf' );

					// Filters

						add_filter( 'theme_page_templates', __CLASS__ . '::shop_page_templates', 20 );

						add_filter( 'wmhook_boo_valley_intro_disable', __CLASS__ . '::intro_disable' );

						add_filter( 'get_the_archive_title', __CLASS__ . '::shop_archive_title' );

						add_filter( 'get_the_archive_description', __CLASS__ . '::shop_archive_description' );

						add_filter( 'single_post_title', __CLASS__ . '::page_endpoint_title' );
						add_filter( 'wmhook_boo_valley_intro_title', __CLASS__ . '::page_endpoint_title' );

						add_filter( 'the_content', __CLASS__ . '::page_title_replace' );

						add_filter( 'woocommerce_cross_sells_total', __CLASS__ . '::cross_sells_total' );

						add_filter( 'wmhook_boo_valley_woocommerce_checkout_guide', __CLASS__ . '::guide_steps', 10, 2 );

						add_filter( 'wmhook_boo_valley_acf_register_field_group', __CLASS__ . '::acf_modify', 10, 2 );

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
	 * 10) Title
	 */

		/**
		 * Intro
		 *
		 * Disable intro on shop page.
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  boolean $disable
		 */
		public static function intro_disable( $disable ) {

			// Requirements check

				if (
						! is_shop()
						&& ! is_product_taxonomy()
					) {
					return $disable;
				}


			// Helper variables

				$shop_page_id = wc_get_page_id( 'shop' );
				$shop_page    = get_post( $shop_page_id );


			// Processing

				if (
						in_array( $shop_page->__get( 'page_template' ), array(
							'templates/no-intro.php',
							'templates/blank.php',
						) )
						|| get_post_meta( $shop_page_id, 'no_intro', true )
					) {
					$disable = true;
				}


			// Output

				return $disable;

		} // /intro_disable



		/**
		 * Sets correct shop archive title
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $title
		 */
		public static function shop_archive_title( $title ) {

			// Requirements check

				if (
						! is_shop()
						&& ! is_product_taxonomy()
					) {
					return $title;
				}


			// Helper variables

				$shop_page_id = wc_get_page_id( 'shop' );


			// Processing

				if ( is_search() ) {

					// Search results title override (removing WooCommerce paged suffix)

						$title = sprintf(
								esc_html__( 'Search Results for: %s', 'boo-valley' ),
								'<span>' . get_search_query() . '</span>'
							);

				} else {

					$title = woocommerce_page_title( false );

				}

				// Support for subtitle

					if (
							is_shop()
							&& ! is_search()
							&& function_exists( 'get_the_subtitle' )
							&& $shop_page_subtitle = get_the_subtitle( $shop_page_id )
						) {
						$title  = '<span class="entry-title-primary">' . $title . '</span>';
						$title .= ' <span class="entry-subtitle">' . $shop_page_subtitle . '</span>';
					}


			// Output

				return $title;

		} // /shop_archive_title



		/**
		 * Sets correct shop archive description
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  string $description
		 */
		public static function shop_archive_description( $description ) {

			// Requirements check

				if (
						! is_shop()
						|| is_search()
					) {
					return $description;
				}


			// Helper variables

				$shop_page_id = wc_get_page_id( 'shop' );


			// Processing

				if ( has_excerpt( $shop_page_id ) ) {
					$description = get_the_excerpt( $shop_page_id );
				}


			// Output

				return $description;

		} // /shop_archive_description



		/**
		 * Replace a page title with the endpoint title
		 *
		 * This is a copy of `wc_page_endpoint_title()` modified for `single_post_title`
		 * filter and making it work outside the loop (removing `in_the_loop()` check).
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $title
		 */
		public static function page_endpoint_title( $title ) {

			// Helper variables

				global $wp_query;


			// Processing

				if (
						! is_null( $wp_query )
						&& ! is_admin()
						&& is_main_query()
						&& is_page()
						&& is_wc_endpoint_url()
					) {

					$endpoint = WC()->query->get_current_endpoint();

					if ( $endpoint_title = WC()->query->get_endpoint_title( $endpoint ) ) {
						$title = $endpoint_title;
					}

					remove_filter( 'single_post_title', 'wc_page_endpoint_title' );

				}


			// Output

				return $title;

		} // /page_endpoint_title



		/**
		 * Page title replacing for dynamic WooCommerce titles
		 *
		 * Useful in page builder "Checkout" or "My Account" page content.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $content  Page content
		 */
		public static function page_title_replace( $content ) {

			// Requirements check

				if ( ! function_exists( 'wc_page_endpoint_title' ) ) {
					return $content;
				}


			// Helper variables

				$title = get_the_title();
				$title = wc_page_endpoint_title( $title );


			// Output

				return str_replace( '%wc_title%', $title, $content );

		} // /page_title_replace





	/**
	 * 20) Page: Shop
	 */

		/**
		 * Set page templates when editing Shop page
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 *
		 * @param  array $page_templates
		 */
		public static function shop_page_templates( $page_templates ) {

			// Processing

				if ( get_the_ID() === wc_get_page_id( 'shop' ) ) {

					// Remove page templates not compatible with Shop page

						unset( $page_templates['templates/blank.php'] );
						unset( $page_templates['templates/child-pages.php'] );
						unset( $page_templates['templates/intro-widgets.php'] );
						unset( $page_templates['templates/sidebar.php'] );

					/**
					 * Yes, unfortunately we need to declare this for WC3.0+
					 * @see  https://github.com/woocommerce/woocommerce/issues/13508
					 */
					$page_templates['templates/no-intro.php'] = esc_html__( 'No intro', 'boo-valley' );

				}


			// Output

				return $page_templates;

		} // /shop_page_templates





	/**
	 * 30) Page: Cart
	 */

		/**
		 * Products list title
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 */
		public static function cart_products_list_title() {

			// Output

				echo '<h2 class="cart-table-title">'
				     . esc_html__( 'Cart content', 'boo-valley' )
				     . '<small class="cart-table-products-count"> '
				     . sprintf(
				     		esc_html( _n( '(1 item)', '(%s items)', absint( wp_strip_all_tags( WC()->cart->get_cart_contents_count() ) ), 'boo-valley' ) ),
				     		absint( wp_strip_all_tags( WC()->cart->get_cart_contents_count() ) )
				     	)
				     . '</small>'
				     . '</h2>';

		} // /cart_products_list_title



		/**
		 * Coupon description
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function coupon_description() {

			// Output

				echo '<p class="description coupon-description">' . esc_html__( 'Use your discount coupon code here', 'boo-valley' ) . '</p>';

		} // /coupon_description



		/**
		 * Cross sells products count
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  integer $total
		 */
		public static function cross_sells_total( $total ) {

			// Output

				return Boo_Valley_WooCommerce_Helpers::return_number( 'cross_sells_total' );

		} // /cross_sells_total



		/**
		 * Shipping calculator
		 *
		 * @see  woocommerce/templates/cart/cart-shipping.php
		 * @see  woocommerce/templates/cart/shipping-calculator.php
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  int $index  Needed for conditional check.
		 */
		public static function shipping_calculator_wrapper( $index ) {

			// Output

				if ( is_cart() && ! $index ) {
					echo '</td></tr><tr class="shipping"><td class="shipping-calculator" colspan="2">';
				}

		} // /shipping_calculator_wrapper



		/**
		 * "Continue shopping" button
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function button_continue_shopping() {

			// Output

				echo '<a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="button button-continue-shopping">' . esc_html__( 'Continue Shopping', 'boo-valley' ) . '</a>';

		} // /button_continue_shopping





	/**
	 * 40) Page: Checkout
	 */

		/**
		 * Checkout page title to keep correct heading levels
		 *
		 * @since    1.4.0
		 * @version  1.4.0
		 */
		public static function checkout_title() {

			// Output

				echo '<h2 class="screen-reader-text">' . esc_html__( 'Checkout', 'boo-valley' ) . '</h2>';

		} // /checkout_title



		/**
		 * Guide output
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $template_name
		 */
		public static function guide( $template_name = '' ) {

			// Requirements check

				if ( ! get_theme_mod( 'woocommerce_checkout_guide', true ) ) {
					return;
				}


			// Helper variables

				$templates = array();

				$steps = (array) apply_filters( 'wmhook_boo_valley_woocommerce_checkout_guide', array(), $template_name );

				foreach ( $steps as $step ) {
					if (
							isset( $step['template'] )
							&& is_array( $step['template'] )
						) {
						$templates = array_merge( (array) $templates, (array) $step['template'] );
					}
				} // /foreach

				$templates = array_filter( $templates );


			// Requirements check

				if ( empty( $templates ) ) {
					return;
				}


			// Output

				if ( in_array( $template_name, $templates ) ) {
					self::guide_generator( $template_name );
				}

		} // /guide



		/**
		 * Guide generator
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $template_name
		 */
		public static function guide_generator( $template_name = '' ) {

			// Requirements check

				if ( ! get_theme_mod( 'woocommerce_checkout_guide', true ) ) {
					return;
				}


			// Helper variables

				global $wp;

				$output    = '';
				$is_active = ' is-active';

				$steps = (array) apply_filters( 'wmhook_boo_valley_woocommerce_checkout_guide', array(), $template_name );


			// Requirements check

				if (
						empty( $steps )
						|| empty( $wp->query_vars )
					) {
					return;
				}


			// Processing

				foreach ( $steps as $key => $step ) {
					if ( isset( $step['title'] ) ) {

						// Current step setup

							if (
									(
										isset( $step['query_vars_key'] )
										&& in_array( $step['query_vars_key'], array_keys( (array) $wp->query_vars ) )
									)
									|| (
										isset( $step['template'] )
										&& is_array( $step['template'] )
										&& in_array( $template_name, $step['template'] )
									)
								) {
								$is_active .= ' is-current';
							}

						$output .= '<li class="checkout-guide-step checkout-guide-step-' . esc_attr( $key . $is_active ) . '">';

							if ( isset( $step['link_url'] ) && $step['link_url'] ) {
								$output .= '<a href="' . esc_url( $step['link_url'] ) . '" class="checkout-guide-title">';
							} else {
								$output .= '<span class="checkout-guide-title">';
							}

							$output .= $step['title'];

							if ( isset( $step['link_url'] ) && $step['link_url'] ) {
								$output .= '</a>';
							} else {
								$output .= '</span>';
							}

						$output .= '</li>';

						// Future steps setup

							if (
									(
										isset( $step['query_vars_key'] )
										&& in_array( $step['query_vars_key'], array_keys( (array) $wp->query_vars ) )
									)
									|| (
										isset( $step['template'] )
										&& is_array( $step['template'] )
										&& in_array( $template_name, $step['template'] )
									)
								) {
								$is_active = '';
							}

					}
				} // /foreach

				if ( $output ) {
					$output = '<div class="checkout-guide"><ol class="checkout-guide-steps">' . $output . '</ol></div>';
				}


			// Output

				echo $output;

		} // /guide_generator



		/**
		 * Guide steps
		 *
		 * Step setup args:
		 * - `title` - Step title.
		 * - `link_url` - If set, the step will get linked to this URL.
		 * - `template` - If set, used in conditional for active step and also for where the guide is displayed.
		 * - `query_vars_key` - If set, used in conditional for active step.
		 *
		 * Either `template` or `query_vars_key` should be used. Don't use both.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array  $steps
		 * @param  string $template_name
		 */
		public static function guide_steps( $steps = array(), $template_name = '' ) {

			// Helper variables

				global $wp;


			// Processing

				$steps[ 10 . 'cart' ] = array(
						'title'    => esc_html__( 'Shopping Cart', 'boo-valley' ),
						'link_url' => wc_get_page_permalink( 'cart' ),
						'template' => array(
								'cart/cart.php',
							),
					);

				$steps[ 20 . 'checkout' ] = array(
						'title'    => esc_html__( 'Checkout', 'boo-valley' ),
						'link_url' => wc_get_page_permalink( 'checkout' ),
						'template' => array(
								'checkout/form-checkout.php',
							),
					);

				$steps[ 30 . 'completed' ] = array(
						'title'    => esc_html__( 'Order Completed', 'boo-valley' ),
						'template' => array(
								'checkout/thankyou.php',
							),
					);

				if ( ! empty( $wp->query_vars['order-pay'] ) ) {

					$steps[ 25 . 'order-pay' ] = array(
							'title'          => esc_html__( 'Pay for Order', 'boo-valley' ),
							'query_vars_key' => 'order-pay',
						);

				}

				ksort( $steps );


			// Output

				return $steps;

		} // /guide_steps





	/**
	 * 50) Custom fields
	 */

		/**
		 * Modifying registered metaboxes for shop page
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 *
		 * @param  array  $args
		 * @param  string $scope
		 */
		public static function acf_modify( $args = array(), $scope = '' ) {

			// Processing

				if ( in_array( $scope, array( 'child_pages', 'any_page_builder' ) ) ) {

					$args['location'][100][555] = array (
							'param'    => 'page',
							'operator' => '!=',
							'value'    => ( function_exists( 'wc_get_page_id' ) ) ? ( wc_get_page_id( 'shop' ) ) : ( null ),
							'order_no' => 0,
							'group_no' => 555,
						);

				}


			// Output

				return $args;

		} // /acf_modify



		/**
		 * Shop page metaboxes
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 */
		public static function acf() {

			// Requirements check

				if ( ! function_exists( 'register_field_group' ) ) {
					return;
				}


			// Processing

				// Shop page options

					register_field_group( (array) apply_filters( 'wmhook_boo_valley_acf_register_field_group', array(
						'id'     => 'boo_valley_shop_layout',
						'title'  => esc_html__( 'Shop layout', 'boo-valley' ),
						'fields' => array (

							// Stretched

								100 => array (
									'key'           => 'boo_valley_layout_stretched_shop',
									'label'         => esc_html__( 'Stretched shop layout', 'boo-valley' ),
									'name'          => 'layout_stretched',
									'type'          => 'true_false',
									'message'       => esc_html__( 'Stretch the shop content area', 'boo-valley' ),
									'default_value' => 0,
								),

						),
						'location' => array (

							// Display on Shop page only

								100 => array (

									100 => array (
										'param'    => 'page',
										'operator' => '==',
										'value'    => ( function_exists( 'wc_get_page_id' ) ) ? ( wc_get_page_id( 'shop' ) ) : ( null ),
										'order_no' => 0,
										'group_no' => 0,
									),

								),

						),
						'options' => array (
							'position'       => 'side',
							'layout'         => 'default',
							'hide_on_screen' => array(),
						),
						'menu_order' => 0,
					), 'shop' ) );

		} // /acf







} // /Boo_Valley_WooCommerce_Pages

add_action( 'after_setup_theme', 'Boo_Valley_WooCommerce_Pages::init' );
