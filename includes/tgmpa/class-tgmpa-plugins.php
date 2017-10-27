<?php
/**
 * Required Plugins Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.4.4
 *
 * Contents:
 *
 *   0) Init
 *  10) Recommend
 * 100) Helpers
 */
class Boo_Valley_TGMPA_Plugins {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'tgmpa_register', __CLASS__ . '::recommend' );

					// Filters

						add_filter( 'tgmpa_notice_action_links', __CLASS__ . '::notification_links' );

						add_filter( 'tgmpa_table_columns', __CLASS__ . '::table_columns' );

						add_filter( 'tgmpa_table_data_item', __CLASS__ . '::table_data', 10, 2 );

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
	 * 10) Recommend
	 */

		/**
		 * Recommend plugins
		 *
		 * @link  https://github.com/thomasgriffin/TGM-Plugin-Activation/blob/master/example.php
		 *
		 * @since    1.0.0
		 * @version  1.4.4
		 */
		public static function recommend() {

			// Processing

				/**
				 * Array of plugin arrays. Required keys are name and slug.
				 * If the source is NOT from the .org repo, then source is also required.
				 */
				$plugins = apply_filters( 'wmhook_boo_valley_tgmpa_plugins_recommend_plugins', array(

						/**
						 * WordPress Repository plugins
						 */

							// Recommended

								'webman-amplifier' => array(
									'name'        => 'WebMan Amplifier',
									'description' => esc_html__( 'Adding theme features, post types, shortcodes, icons.', 'boo-valley' ),
									'slug'        => 'webman-amplifier',
									'required'    => false,
								),

								'advanced-custom-fields' => array(
									'name'        => 'Advanced Custom Fields',
									'description' => esc_html__( 'For easy post and page attributes setup.', 'boo-valley' ),
									'slug'        => 'advanced-custom-fields',
									'required'    => false,
									'is_callable' => 'register_field_group',
								),

								'woocommerce' => array(
									'name'        => 'WooCommerce',
									'description' => esc_html__( 'Adding e-commerce functionality.', 'boo-valley' ),
									'slug'        => 'woocommerce',
									'required'    => false,
								),

								'woosidebars' => array(
									'name'        => 'WooSidebars',
									'description' => esc_html__( 'Adding custom sidebars management, allowing page layout modifications by removing sidebars.', 'boo-valley' ),
									'slug'        => 'woosidebars',
									'required'    => false,
								),

								'one-click-demo-import' => array(
									'name'        => 'One Click Demo Import',
									'description' => esc_html__( 'For installing theme demo content easily.', 'boo-valley' ),
									'slug'        => 'one-click-demo-import',
									'required'    => false,
								),

								'rich-text-excerpts' => array(
									'name'        => 'Rich Text Excerpts',
									'description' => esc_html__( 'To enable rich text editing also for post and page excerpt field.', 'boo-valley' ),
									'slug'        => 'rich-text-excerpts',
									'required'    => false,
								),


					) );

				$config = apply_filters( 'wmhook_boo_valley_tgmpa_plugins_recommend_config', array() );

				tgmpa( $plugins, $config );

		} // /recommend





	/**
	 * 100) Helpers
	 */

		/**
		 * Admin notification links
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $action_links
		 */
		public static function notification_links( $action_links ) {

		// Processing

			// Adding font weight classes

				$action_links[] = '<a href="' . esc_url( 'https://www.sullidigital.com/manual/boo-valley/#plugins' ) . '" target="_blank">' . esc_html__( 'Other useful plugins &raquo;', 'boo-valley' ) . '</a>';


		// Output

			return $action_links;

		} // /notification_links



		/**
		 * TGMPA plugins table: Columns
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $columns
		 */
		public static function table_columns( $columns = array() ) {

			// Processing

				$columns = array_merge(
						array_slice( $columns, 0, 2 ),
						array( 'description' => esc_html__( 'Description', 'boo-valley' ) ),
						array_slice( $columns, 2 )
					);


			// Output

				return $columns;

		} // /table_columns



		/**
		 * TGMPA plugins table: Plugin description
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $table_data
		 * @param  array $plugin
		 */
		public static function table_data( $table_data = array(), $plugin = array() ) {

			// Processing

				$table_data['description'] = ( isset( $plugin['description'] ) ) ? ( wp_kses_post( $plugin['description'] ) ) : ( '' );


			// Output

				return $table_data;

		} // /table_data





} // /Boo_Valley_TGMPA_Plugins

add_action( 'after_setup_theme', 'Boo_Valley_TGMPA_Plugins::init' );
