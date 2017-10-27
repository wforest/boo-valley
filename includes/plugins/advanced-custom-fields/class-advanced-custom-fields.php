<?php
/**
 * Advanced Custom Fields Class
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
 * 10) Intro section
 * 20) Child pages list section
 * 30) Any page builder setup
 */
class Boo_Valley_Advanced_Custom_Fields {





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

			// Requirements check

				if ( ! is_admin() ) {
					return;
				}


			// Processing

				// Hooks

					// Actions

						add_action( 'init', __CLASS__ . '::intro' );

						add_action( 'init', __CLASS__ . '::child_pages' );

						add_action( 'init', __CLASS__ . '::any_page_builder' );

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
	 * 10) Intro section
	 */

		/**
		 * Intro metaboxes
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 */
		public static function intro() {

			// Processing

				register_field_group( (array) apply_filters( 'wmhook_boo_valley_acf_register_field_group', array(
					'id'     => 'boo_valley_intro_options',
					'title'  => esc_html__( 'Intro options', 'boo-valley' ),
					'fields' => array (

						// Disable intro

							100 => array (
								'key'           => 'boo_valley_no_intro',
								'label'         => esc_html__( 'Intro section', 'boo-valley' ),
								'name'          => 'no_intro',
								'type'          => 'true_false',
								'message'       => esc_html__( 'Disable intro section for this page', 'boo-valley' ),
								'default_value' => 0,
							),

						// Custom intro image

							200 => array (
								'key'               => 'boo_valley_intro_image',
								'label'             => esc_html__( 'Intro section image', 'boo-valley' ),
								'instructions'      => esc_html__( 'Here you can override the default Intro section image with a custom one.', 'boo-valley' ),
								'name'              => 'intro_image',
								'type'              => 'image',
								'save_format'       => 'id',
								'preview_size'      => 'thumbnail',
								'library'           => 'all',
								'conditional_logic' => array (
									'status'   => 1,
									'allorany' => 'all',
									'rules'    => array (
										array (
											'field'    => 'boo_valley_no_intro',
											'operator' => '!=',
											'value'    => 1,
										),
									),
								),
							),

						// Display intro widgets

							300 => array (
								'key'               => 'boo_valley_show_intro_widgets',
								'label'             => esc_html__( 'Intro widgets', 'boo-valley' ),
								'name'              => 'show_intro_widgets',
								'type'              => 'true_false',
								'message'           => esc_html__( 'Show widgets in intro section of this page', 'boo-valley' ),
								'default_value'     => 0,
								'conditional_logic' => array (
									'status'   => 1,
									'allorany' => 'all',
									'rules'    => array (
										array (
											'field'    => 'boo_valley_no_intro',
											'operator' => '!=',
											'value'    => 1,
										),
									),
								),
							),

					),
					'location' => array (

						// Display everywhere except blog page, "No intro" page template, WebMan Amplifier, Beaver Builder/Themer and WooSidebars related CPTs

							100 => array (

								100 => array (
									'param'    => 'page_type',
									'operator' => '!=',
									'value'    => 'posts_page',
									'order_no' => 0,
									'group_no' => 1,
								),

								200 => array (
									'param'    => 'page_template',
									'operator' => '!=',
									'value'    => 'templates/no-intro.php',
									'order_no' => 0,
									'group_no' => 2,
								),

								// CPTs

									300 => array (
										'param'    => 'post_type',
										'operator' => '!=',
										'value'    => 'wm_modules',
										'order_no' => 0,
										'group_no' => 1,
									),

										310 => array (
											'param'    => 'post_type',
											'operator' => '!=',
											'value'    => 'wm_logos',
											'order_no' => 0,
											'group_no' => 1,
										),

										320 => array (
											'param'    => 'post_type',
											'operator' => '!=',
											'value'    => 'wm_testimonials',
											'order_no' => 0,
											'group_no' => 1,
										),

									400 => array (
										'param'    => 'post_type',
										'operator' => '!=',
										'value'    => 'fl-builder-template',
										'order_no' => 0,
										'group_no' => 1,
									),

										410 => array (
											'param'    => 'post_type',
											'operator' => '!=',
											'value'    => 'fl-theme-layout',
											'order_no' => 0,
											'group_no' => 1,
										),

									500 => array (
										'param'    => 'post_type',
										'operator' => '!=',
										'value'    => 'sidebar',
										'order_no' => 0,
										'group_no' => 1,
									),

							),

					),
					'options' => array (
						'position'       => 'normal',
						'layout'         => 'default',
						'hide_on_screen' => array(),
					),
					'menu_order' => 20,
				), 'intro' ) );

		} // /intro





	/**
	 * 20) Child pages list section
	 */

		/**
		 * Child pages list metaboxes
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function child_pages() {

			// Processing

				register_field_group( (array) apply_filters( 'wmhook_boo_valley_acf_register_field_group', array(
					'id'     => 'boo_valley_child_pages_options',
					'title'  => esc_html__( 'Child pages list options', 'boo-valley' ),
					'fields' => array (

						// Instructions message

							100 => array (
								'key'     => 'boo_valley_child_pages_options_instructions',
								'label'   => esc_html__( 'Instructions', 'boo-valley' ),
								'name'    => '',
								'type'    => 'message',
								'message' => esc_html__( 'These settings will modify the page display in the list of child pages. The page needs to be nested under a parent page that is set up as a "List child pages" page template.', 'boo-valley' ),
							),

						// Disable child page image

							200 => array (
								'key'           => 'boo_valley_no_thumbnail',
								'label'         => esc_html__( 'Disable image', 'boo-valley' ),
								'name'          => 'no_thumbnail',
								'type'          => 'true_false',
								'message'       => esc_html__( 'Do not display page image in list of child pages', 'boo-valley' ),
								'default_value' => 0,
							),

					),
					'location' => array (

						// Display on Pages

							100 => array (

								100 => array (
									'param'    => 'post_type',
									'operator' => '==',
									'value'    => 'page',
									'order_no' => 0,
									'group_no' => 0,
								),

								200 => array (
									'param'    => 'page_type',
									'operator' => '!=',
									'value'    => 'posts_page',
									'order_no' => 0,
									'group_no' => 1,
								),

								300 => array (
									'param'    => 'page_parent',
									'operator' => '!=',
									'value'    => '',
									'order_no' => 0,
									'group_no' => 2,
								),

							),

					),
					'options' => array (
						'position'       => 'normal',
						'layout'         => 'default',
						'hide_on_screen' => array(),
					),
					'menu_order' => 20,
				), 'child_pages' ) );

		} // /child_pages





	/**
	 * 30) Any page builder setup
	 */

		/**
		 * Post modifiers to support any page builder
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 */
		public static function any_page_builder() {

			// Requirements check

				if ( class_exists( 'FLBuilder' ) ) {
					return;
				}


			// Processing

				register_field_group( (array) apply_filters( 'wmhook_boo_valley_acf_register_field_group', array(
					'id'     => 'boo_valley_any_page_builder',
					'title'  => esc_html__( 'Page builder layout', 'boo-valley' ),
					'fields' => array (

						// Explanatory message

							'001' => array (
								'key'     => 'boo_valley_any_page_builder_message',
								'label'   => '',
								'name'    => 'any_page_builder_message',
								'type'    => 'message',
								'message' => '<small><em>' . esc_html__( 'These options prepare the page/post layout for use with page builder.', 'boo-valley' ) . ' ' . esc_html__( 'Please set the options cautiously as every page builder plugin works differently.', 'boo-valley' ) . '</em></small>',
							),

						// Stretched

							100 => array (
								'key'           => 'boo_valley_layout_stretched',
								'label'         => esc_html__( 'Fullwidth sections&hellip;', 'boo-valley' ),
								'name'          => 'layout_stretched',
								'type'          => 'true_false',
								'message'       => esc_html__( 'Stretch the content area full width and remove content area paddings', 'boo-valley' ),
								'default_value' => 0,
							),

						// No paddings

							200 => array (
								'key'               => 'boo_valley_layout_no_paddings',
								'label'             => esc_html__( '&hellip;or just remove paddings', 'boo-valley' ),
								'name'              => 'layout_no_paddings',
								'type'              => 'true_false',
								'message'           => esc_html__( 'Remove content area paddings only', 'boo-valley' ),
								'default_value'     => 0,
								'conditional_logic' => array (
									'status'   => 1,
									'allorany' => 'all',
									'rules'    => array (
										array (
											'field'    => 'boo_valley_layout_stretched',
											'operator' => '!=',
											'value'    => 1,
										),
									),
								),
							),

					),
					'location' => array (

						// Display everywhere except blog page, WebMan Amplifier and WooSidebars related CPTs

							100 => array (

								100 => array (
									'param'    => 'page_type',
									'operator' => '!=',
									'value'    => 'posts_page',
									'order_no' => 0,
									'group_no' => 0,
								),

								200 => array (
									'param'    => 'post_type',
									'operator' => '!=',
									'value'    => 'wm_modules',
									'order_no' => 0,
									'group_no' => 1,
								),

									210 => array (
										'param'    => 'post_type',
										'operator' => '!=',
										'value'    => 'wm_logos',
										'order_no' => 0,
										'group_no' => 1,
									),

									220 => array (
										'param'    => 'post_type',
										'operator' => '!=',
										'value'    => 'wm_testimonials',
										'order_no' => 0,
										'group_no' => 1,
									),

								300 => array (
									'param'    => 'post_type',
									'operator' => '!=',
									'value'    => 'sidebar',
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
					'menu_order' => 20,
				), 'any_page_builder' ) );

		} // /any_page_builder





} // /Boo_Valley_Advanced_Custom_Fields

add_action( 'after_setup_theme', 'Boo_Valley_Advanced_Custom_Fields::init' );
