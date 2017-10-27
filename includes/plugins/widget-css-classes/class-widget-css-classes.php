<?php
/**
 * Adding Custom Widget CSS Classes
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.4.2
 *
 * Contents:
 *
 *  0) Init
 * 10) Functionality
 */
class Boo_Valley_Widget_CSS_Classes {





	/**
	 * 0) Init
	 */

		private static $classes;

		private static $instance;



		/**
		 * Constructor
		 *
		 * @uses  `wmhook_boo_valley_widget_css_classes` global hook
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 */
		private function __construct() {

			// Requirements check

				if ( ! is_admin() ) {
					return;
				}


			// Helper variables

				self::$classes = (array) apply_filters( 'wmhook_boo_valley_widget_css_classes', array() );


			// Processing

				// Hooks

					// Filters

						add_filter( 'option_WCSSC_options', __CLASS__ . '::widget_css_classes' );

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
	 * 10) Functionality
	 */

		/**
		 * Widget CSS Classes plugin integration
		 *
		 * @since    1.0.0
		 * @version  1.4.2
		 *
		 * @param  array $settings  Widget CSS Classes plugin settings array.
		 */
		public static function widget_css_classes( $settings = array() ) {

			// Requirements check

				if (
						empty( self::$classes )
						|| ! function_exists( 'widget_css_classes_loader' )
					) {
					return $settings;
				}


			// Helper variables

				$settings = (array) $settings;


			// Processing

				// Add predefined theme classes

					$settings['defined_classes'] = ( isset( $settings['defined_classes'] ) && is_string( $settings['defined_classes'] ) ) ? ( explode( ';', (string) $settings['defined_classes'] ) ) : ( array() );

					$settings['defined_classes'] = array_unique(
							array_filter(
								array_merge(
									(array) self::$classes,
									(array) $settings['defined_classes']
								)
							)
						);

					$settings['defined_classes'] = implode( ';', $settings['defined_classes'] );

				// Make predefined theme classes visible

					if ( apply_filters( 'wmhook_boo_valley_widget_css_classes_force_type', true ) ) {
						$settings['type'] = 3;
					}


			// Output

				return $settings;

		} // /widget_css_classes





} // /Boo_Valley_Widget_CSS_Classes

add_action( 'after_setup_theme', 'Boo_Valley_Widget_CSS_Classes::init' );
