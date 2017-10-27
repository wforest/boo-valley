<?php
/**
 * WooCommerce: Widgets Class
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
 * 10) Sidebars
 * 20) Widget: Shopping cart
 * 30) Widget: Product Search
 */
class Boo_Valley_WooCommerce_Widgets {





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

						remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );

					// Actions

						add_action( 'widgets_init', __CLASS__ . '::register_widget_areas', 1 );

						add_filter( 'sidebars_widgets', __CLASS__ . '::shop_sidebar', 5 );

						add_action( 'woocommerce_after_single_product_summary', __CLASS__ . '::sidebar_product', 15 );

						add_action( 'woocommerce_before_shop_loop', __CLASS__ . '::sidebar_shop_before', 5 );

						add_action( 'tha_header_top', __CLASS__ . '::cart_header', 150 );

						add_action( 'woocommerce_before_mini_cart', __CLASS__ . '::cart_buttons' );

					// Filters

						add_filter( 'wmhook_boo_valley_sidebar_disable', __CLASS__ . '::sidebar_disable' );

						add_filter( 'get_product_search_form', __CLASS__ . '::product_search_form' );

						add_filter( 'woocommerce_add_to_cart_fragments', __CLASS__ . '::cart_fragments' );

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
	 * 10) Sidebars
	 */

		/**
		 * Product widget area: registration
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 */
		public static function register_widget_areas() {

			// Processing

				register_sidebar( array(
						'id'            => 'shop',
						'name'          => esc_html__( 'Shop Sidebar', 'boo-valley' ),
						'description'   => esc_html__( 'This sidebar replaces the default sidebar area for shop page and product archive pages.', 'boo-valley' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h3 class="widget-title screen-reader-text">',
						'after_title'   => '</h3>'
					) );

				register_sidebar( array(
						'id'            => 'product',
						'name'          => esc_html__( 'Product', 'boo-valley' ),
						'description'   => esc_html__( 'This widget area is displayed on single product page, just above the related products list.', 'boo-valley' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>'
					) );

				register_sidebar( array(
						'id'            => 'shop-before',
						'name'          => esc_html__( 'Before Products List', 'boo-valley' ),
						'description'   => esc_html__( 'This widget area is displayed on shop archive pages before the products list.', 'boo-valley' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h2 class="widget-title screen-reader-text">',
						'after_title'   => '</h2>'
					) );

		} // /register_widget_areas



		/**
		 * Product widgets area: display
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function sidebar_product() {

			// Output

				get_sidebar( 'product' );

		} // /sidebar_product



		/**
		 * Before Products List widgets area: display
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function sidebar_shop_before() {

			// Output

				get_sidebar( 'shop-before' );

		} // /sidebar_shop_before



		/**
		 * Replace default sidebar with Shop Sidebar
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function shop_sidebar( $sidebars_widgets ) {

			// Requirements check

				if (
						! ( is_shop() || is_product_taxonomy() )
						|| ! isset( $sidebars_widgets['shop'] )
						|| empty( $sidebars_widgets['shop'] )
					) {
					return $sidebars_widgets;
				}


			// Helper variables

				$shop_sidebar_widgets = $sidebars_widgets['shop'];


			// Processing

				// Replace default sidebar widgets with the shop sidebar ones

					$sidebars_widgets['sidebar'] = $shop_sidebar_widgets;


			// Output

				return $sidebars_widgets;

		} // /shop_sidebar



		/**
		 * Sidebar disabling
		 *
		 * Disable sidebar on single products.
		 * Enable shop sidebar on product archives.
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 *
		 * @param  boolean $disabled
		 */
		public static function sidebar_disable( $disabled = false ) {

			// Processing

				if ( is_product() ) {
					return true;
				} elseif ( is_shop() || is_product_taxonomy() ) {
					return ! is_active_sidebar( 'shop' );
				}


			// Output

				return $disabled;

		} // /sidebar_disable





	/**
	 * 20) Widget: Shopping cart
	 */

		/**
		 * Shopping cart
		 *
		 * Adding shopping cart in header.
		 * When shopping cart is displayed, social menu in header is not.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function cart_header() {

			// Requirements check

				if ( ! self::is_cart_header() ) {
					return;
				}


			// Output

				echo '<div id="header-shopping-cart" class="header-shopping-cart" data-preview-delay="' . absint( apply_filters( 'wmhook_boo_valley_woocommerce_widgets_cart_header_preview_delay', 1500 ) ) . '">';

				echo self::get_cart_link();

				the_widget(
						'WC_Widget_Cart',
						array(
							'title'         => esc_html__( 'Shopping cart', 'boo-valley' ),
							'hide_if_empty' => false,
						),
						array(
							'before_widget' => '<section class="widget %s">',
							'after_widget'  => '</section>',
							'before_title'  => '<h2 class="widget-title">',
							'after_title'   => '</h2>',
						)
					);

				echo '</div>';

		} // /cart_header



		/**
		 * Conditional check whether to display cart in header
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function is_cart_header() {

			// Output

				return apply_filters( 'wmhook_boo_valley_woocommerce_widgets_is_cart_header', (
						0 < wc_get_page_id( 'cart' )
						&& 0 < wc_get_page_id( 'checkout' )
						&& get_theme_mod( 'woocommerce_cart_header', true )
					) );

		} // /is_cart_header



		/**
		 * Shopping cart fragments
		 *
		 * Ensure cart contents update when products are added to the cart via AJAX.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $fragments  Fragments to refresh via AJAX.
		 */
		public static function cart_fragments( $fragments ) {

			// Processing

				$fragments['.cart-contents'] = self::get_cart_link();


			// Output

				return $fragments;

		} // /cart_fragments



		/**
		 * Shopping cart link
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function get_cart_link() {

			// Requirements check

				if ( is_cart() && ! WC()->cart->is_empty() ) {
					return '<a class="checkout-link button" href="' . esc_url( wc_get_checkout_url() ) . '"><span class="checkout-link-text">' . esc_html__( 'Checkout', 'boo-valley' ) . '</span></a>';
				}


			// Helper variables

				$output = $class = '';

				$amount = wp_strip_all_tags( WC()->cart->get_cart_subtotal() );
				$count  = wp_strip_all_tags( WC()->cart->get_cart_contents_count() );
				$url    = wc_get_cart_url();

				$title = sprintf(
						esc_html( _n( 'You have 1 product of value of %2$s in the cart', 'You have %1$s products of value of %2$s in the cart', absint( $count ), 'boo-valley' ) ),
						absint( $count ),
						$amount
					);

				if ( WC()->cart->is_empty() ) {
					$class .= ' amount-null';
					$title  = esc_html__( 'No products in the cart.', 'boo-valley' );
					$url    = apply_filters( 'wmhook_boo_valley_woocommerce_widgets_get_cart_link_is_empty_url', wc_get_page_permalink( 'shop' ) );
				}


			// Processing

				$output .= '<a class="cart-contents" href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '">';

				// Title

					$output .= '<span class="screen-reader-text">' . esc_attr__( 'Shopping cart:', 'boo-valley' ) . ' </span>';

				// Subtotal

					$output .= '<span class="amount' . esc_attr( $class ) . '">';
					$output .= '<span class="screen-reader-text">' . esc_html__( 'Subtotal:', 'boo-valley' ) . ' </span>';
					$output .= $amount;
					$output .= '</span>';

				// Products count

					$output .= '<span class="count' . esc_attr( $class ) . '">';
					$output .= '<span class="screen-reader-text">' . esc_html__( 'Products count:', 'boo-valley' ) . ' </span>';
					$output .= $count;
					$output .= '</span>';

				$output .= '</a>';


			// Output

				return $output;

		} // /get_cart_link



		/**
		 * Shopping cart buttons
		 *
		 * @see  woocommerce/templates/cart/mini-cart.php
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function cart_buttons() {

			// Output

				if ( ! WC()->cart->is_empty() ) {

					echo '<p class="buttons before-cart-list">';

						echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button cart wc-forward">';
							esc_html_e( 'Cart', 'boo-valley' );
						echo '</a>';

						echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button checkout wc-forward">';
							esc_html_e( 'Checkout', 'boo-valley' );
						echo '</a>';

					echo '</p>';

				}

		} // /cart_buttons





	/**
	 * 30) Widget: Product Search
	 */

		/**
		 * Fixing search field ID for multiple display
		 *
		 * @since    1.0.0
		 * @version  1.1.0
		 */
		public static function product_search_form( $html ) {

			// Output

				return str_replace( 'woocommerce-product-search-field', 'woocommerce-product-search-field-' . esc_attr( uniqid() ), $html );

		} // /product_search_form





} // /Boo_Valley_WooCommerce_Widgets

add_action( 'after_setup_theme', 'Boo_Valley_WooCommerce_Widgets::init' );
