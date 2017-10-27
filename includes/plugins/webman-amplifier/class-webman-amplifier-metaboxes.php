<?php
/**
 * WebMan Amplifier: Metaboxes Class
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
 * 10) Content Modules
 */
class Boo_Valley_WebMan_Amplifier_Metaboxes {





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

					// Filters

						// Content Modules

							add_filter( 'wmhook_wmamp_cp_metafields_wm_modules', __CLASS__ . '::content_modules' );

						// Projects

							add_filter( 'wmhook_wmamp_cp_metafields_wm_projects', '__return_empty_array' );

						// Staff

							add_filter( 'wmhook_wmamp_cp_metafields_wm_staff', '__return_empty_array' );

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
	 * 10) Content Modules
	 */

		/**
		 * Content Modules fields alteration
		 *
		 * Note: do not remove custom link setup due to "More link" conditional display.
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  array $fields
		 */
		public static function content_modules( $fields = array() ) {

			// Processing

				// Change labels

					$fields[1000]['title'] = esc_html__( 'Icon', 'boo-valley' );
					$fields[1000]['id']    = 'module-icon-section';

					$fields[1240]['label'] = esc_html__( 'Icon', 'boo-valley' );
					$fields[1260]['label'] = esc_html__( 'Icon color', 'boo-valley' );

				// Remove 'icon-box' option

					unset( $fields[1060] );

				// Remove featured image setup notice

					unset( $fields[1220] );

				// Remove icon background color option

					unset( $fields[1280] );

				// Move icon color before the icon selection

					$fields[1200] = $fields[1260]; // Also removes icon setup wrapper opening (by overriding the array key)

					unset( $fields[1260] ); // Remove original icon color setup position

				// Remove icon setup wrapper closing

					unset( $fields[1480] );

				// Moving link setup to a new tab

					$fields[2000] = array(
							'type'  => 'section-open',
							'id'    => 'module-link-section',
							'title' => esc_html_x( 'Link', 'Metabox section title.', 'boo-valley' ),
						);

					$fields[2020] = $fields[1020];
					$fields[2040] = $fields[1040];

					$fields[2980] = array(
							'type' => 'section-close',
						);

					unset( $fields[1020] );
					unset( $fields[1040] );


			// Output

				return $fields;

		} // /content_modules





} // /Boo_Valley_WebMan_Amplifier_Metaboxes

add_action( 'after_setup_theme', 'Boo_Valley_WebMan_Amplifier_Metaboxes::init' );
