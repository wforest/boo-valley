<?php
/**
 * WebMan Amplifier: Shortcodes Class
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
 * 10) Globals
 * 20) Shortcode: Button
 * 30) Shortcode: Content Modules
 * 40) Shortcode: Posts
 * 50) Shortcode: Testimonials
 */
class Boo_Valley_WebMan_Amplifier_Shortcodes {





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

					// Filters

						add_filter( 'wmhook_boo_valley_post_media_image_size', __CLASS__ . '::image_size', 20, 2 );

						add_filter( 'wmhook_shortcode_supported_version', __CLASS__ . '::supported_shortcode_version' );

						add_filter( 'wmhook_shortcode_codes_globals', __CLASS__ . '::globals' );

						add_filter( 'wmhook_shortcode_wma_bb_shortcode_def_output', __CLASS__ . '::page_builder_module_name_prefix', 10, 2 );

						add_filter( 'wmhook_shortcode_definitions', __CLASS__ . '::definitions' );

						add_filter( 'wmhook_shortcode__attributes', __CLASS__ . '::attributes', 10, 2 );

						add_filter( 'wmhook_shortcode_button_classes', __CLASS__ . '::shortcode_button_class' );

						add_filter( 'wmhook_shortcode_content_module_layout_elements', __CLASS__ . '::shortcode_content_module_layout_elements', 10, 4 );

						add_filter( 'wmhook_shortcode_content_module_item_class', __CLASS__ . '::shortcode_content_module_item_class', 10, 3 );

						add_filter( 'wmhook_shortcode_posts_classes', __CLASS__ . '::shortcode_posts_class' );

						add_filter( 'wmhook_shortcode_posts_image_size', __CLASS__ . '::shortcode_posts_image_size', 10, 2 );

						add_filter( 'wmhook_shortcode_posts_helper', __CLASS__ . '::shortcode_posts_item_class', 10, 2 );

						add_filter( 'wmhook_shortcode_testimonials_image_size', __CLASS__ . '::shortcode_testimonials_image_size', 10, 2 );

						add_filter( 'wmhook_wmamp_wma_meta_option_output', __CLASS__ . '::shortcode_testimonials_source', 10, 3 );

						add_filter( 'wmhook_shortcode_testimonials_item_class', __CLASS__ . '::shortcode_testimonials_item_class', 10, 2 );

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
	 * 10) Globals
	 */

		/**
		 * Supported shortcodes version
		 *
		 * Use this to declare the plugin version that your theme supports.
		 * It is possible that in future versions of the plugin there will be more
		 * shortcodes added and your theme might not support them out of the box.
		 * Setting this version number will make sure only the shortcodes included
		 * with the specific plugin version will be available to your theme users.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function supported_shortcode_version() {

			// Output

				return '1.3';

		} // /supported_shortcode_version





		/**
		 * Modifying shortcodes globals
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $array
		 */
		public static function globals( $array ) {

			// Processing

				// Color names

					$array['colors'] = array(

							// Adding empty value for default settings

								'' => '',

							// Global predefined colors

								'success' => esc_html_x( 'Success', 'Generalized, abstract color name.', 'boo-valley' ),
								'info'    => esc_html_x( 'Info', 'Generalized, abstract color name.', 'boo-valley' ),
								'warning' => esc_html_x( 'Warning', 'Generalized, abstract color name.', 'boo-valley' ),
								'error'   => esc_html_x( 'Error', 'Generalized, abstract color name.', 'boo-valley' ),

						);

				// Sizes (adding empty size for default value)

					array_unshift( $array['sizes']['options'], '' );


			// Output

				return $array;

		} // /globals



		/**
		 * Prefix page builder modules names
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array  $output
		 * @param  string $shortcode
		 */
		public static function page_builder_module_name_prefix( $output, $shortcode ) {

			// Processing

				if ( '-' !== $output['name'] ) {
					$output['name'] = 'WM ' . $output['name'];
				}


			// Output

				return $output;

		} // /page_builder_module_name_prefix



		/**
		 * Modifying shortcodes definitions and removing obsolete shortcodes
		 *
		 * @uses  unset() - no need to check for isset()
		 * @link  http://php.net/manual/en/function.unset.php#72389
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $definitions
		 */
		public static function definitions( $definitions ) {

			// Helper variables

				$button_colors = array(
						''       => esc_html__( 'Accent button', 'boo-valley' ),
						'simple' => esc_html__( 'Simple, outline button', 'boo-valley' ),
					);


			// Processing

				// Removing obsolete shortcodes

					// WebMan Amplifier native

						unset( $definitions['audio'] );
						unset( $definitions['column'] );
						unset( $definitions['countdown_timer'] );
						unset( $definitions['dropcap'] );
						unset( $definitions['icon'] );
						unset( $definitions['list'] );
						unset( $definitions['marker'] );
						unset( $definitions['pre'] );
						unset( $definitions['price'] );
						unset( $definitions['pricing_table'] );
						unset( $definitions['progress'] );
						unset( $definitions['row'] );
						unset( $definitions['search_form'] );
						unset( $definitions['separator_heading'] );
						unset( $definitions['slideshow'] );
						unset( $definitions['table'] );
						unset( $definitions['video'] );
						unset( $definitions['widget_area'] );

					// Visual Composer related

						unset( $definitions['image'] );
						unset( $definitions['text_block'] );
						unset( $definitions['vc_row'] );
						unset( $definitions['vc_row_inner'] );
						unset( $definitions['vc_column'] );
						unset( $definitions['vc_column_inner'] );

					// Others

						unset( $definitions['soliloquy'] );
						unset( $definitions['masterslider'] );

				// Modifying definitions

					// Button colors

						$definitions['button']['bb_plugin']['form']['general']['sections']['general']['fields']['color']['options'] = $button_colors;

						$definitions['call_to_action']['bb_plugin']['form']['button']['sections']['general']['fields']['button_color']['options'] = $button_colors;

					// Content Module

						unset( $definitions['content_module']['bb_plugin']['form']['general']['sections']['multiple']['fields']['pagination'] );
						unset( $definitions['content_module']['bb_plugin']['form']['description'] );
						unset( $definitions['content_module']['bb_plugin']['form']['others']['sections']['general']['fields']['no_margin'] );
						unset( $definitions['content_module']['bb_plugin']['form']['others']['sections']['general']['fields']['image_size'] );
						unset( $definitions['content_module']['bb_plugin']['form']['others']['sections']['general']['fields']['layout'] );

					// Message

						unset( $definitions['message']['bb_plugin']['form']['others']['sections']['general']['fields']['size'] );

					// Posts

						unset( $definitions['posts']['bb_plugin']['form']['description'] );
						unset( $definitions['posts']['bb_plugin']['form']['others']['sections']['general']['fields']['filter_layout'] );
						unset( $definitions['posts']['bb_plugin']['form']['others']['sections']['general']['fields']['related'] );
						// unset( $definitions['posts']['bb_plugin']['form']['others']['sections']['general']['fields']['image_size'] );

					// Testimonials

						unset( $definitions['testimonials']['bb_plugin']['form']['description'] );
						unset( $definitions['testimonials']['bb_plugin']['form']['others']['sections']['general']['fields']['no_margin'] );


			// Output

				return $definitions;

		} // /definitions



		/**
		 * Shortcodes attributes: forced
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 *
		 * @param  array  $atts
		 * @param  string $shortcode
		 */
		public static function attributes( $atts, $shortcode ) {

			// Processing

				switch ( $shortcode ) {

					case 'call_to_action':

						// Call to action button class

							$atts['button_class'] = 'button';

					break;

					case 'content_module':
					case 'posts':

						// Isotope - force masonry layout (default is `fitRows`)

							$atts['filter_layout'] = 'masonry';

					break;

					default:
					break;

				}


			// Output

				return $atts;

		} // /attributes



		/**
		 * Post image size when displayed by shortcode
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $image_size
		 * @param  array  $args        Optional shortcode helper variables.
		 */
		public static function image_size( $image_size, $args = array() ) {

			// Processing

				if (
						isset( $args['helper']['image_size'] )
						&& $args['helper']['image_size']
					) {
					$image_size = $args['helper']['image_size'];
				}


			// Output

				return $image_size;

		} // /image_size





	/**
	 * 20) Shortcode: Button
	 */

		/**
		 * Button class
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $classes
		 */
		public static function shortcode_button_class( $classes ) {

			// Output

				return $classes . ' button';

		} // /shortcode_button_class





	/**
	 * 30) Shortcode: Content Modules
	 */

		/**
		 * Content Module shortcode
		 *
		 * Output icon without need to set an "iconbox" checkbox.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array  $layout_elements
		 * @param  absint $post_id
		 * @param  array  $helpers
		 * @param  array  $atts
		 */
		public static function shortcode_content_module_layout_elements( $layout_elements, $post_id, $helpers, $atts  ) {

			// Requirements check

				if ( ! function_exists( 'wma_meta_option' ) ) {
					return;
				}


			// Helper variables

				$icon = '';

				$icon_setup = array(
						'class' => wma_meta_option( 'icon-font', $post_id ),
						'color' => wma_meta_option( 'icon-color', $post_id ),
					);


			// Requirements check

				if ( empty( $icon_setup['class'] ) ) {
					return $layout_elements;
				}


			// Processing

				$icon .= '<span class="' . esc_attr( $icon_setup['class'] ) . '" aria-hidden="true"';

				// Icon color

					if ( $icon_setup['color'] ) {
						$icon .= ' style="color: ' . esc_attr( $icon_setup['color'] ) . '"';
					}

				$icon .= '></span>';

				// Apply custom link

					if ( $helpers['link'] ) {
						$icon = '<a' .  $helpers['link'] . '>' . $icon . '</a>';
					}

				// Output setup

					$layout_elements['image'] = '<div class="wm-content-module-element wm-html-element image image-container font-icon">' . $icon . '</div>';


			// Output

				return $layout_elements;

		} // /shortcode_content_module_layout_elements



		/**
		 * Content Module item class
		 *
		 * Setting "iconbox" class when icon used.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $class_item
		 * @param  int    $post_id
		 * @param  array  $atts
		 */
		public static function shortcode_content_module_item_class( $class_item, $post_id, $atts ) {

			// Requirements check

				if ( ! function_exists( 'wma_meta_option' ) ) {
					return;
				}


			// Processing

				if ( wma_meta_option( 'icon-font', $post_id ) ) {
					$class_item .= ' wm-iconbox-module';
				}


			// Output

				return str_replace( ' has-background', '', $class_item );

		} // /shortcode_content_module_item_class





	/**
	 * 40) Shortcode: Posts
	 */

		/**
		 * Posts class
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $classes
		 */
		public static function shortcode_posts_class( $classes ) {

			// Output

				return $classes . ' posts';

		} // /shortcode_posts_class



		/**
		 * Posts shortcode default image size
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $image_size
		 * @param  array  $atts        Shortcode attributes.
		 */
		public static function shortcode_posts_image_size( $image_size, $atts ) {

			// Output

				if ( isset( $atts['post_type'] ) ) {

					switch ( $atts['post_type'] ) {

						case 'wm_staff':
								return 'boo_valley-square';
							break;

						case 'wm_projects':
								return 'medium';
							break;

					} // /switch

				} else {

					return 'thumbnail';

				}

		} // /shortcode_posts_image_size



		/**
		 * Posts shortcode item class and link
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array  $helper
		 * @param  absint $post_id
		 */
		public static function shortcode_posts_item_class( $helper, $post_id ) {

			// Processing

				// Class

					if (
							isset( $helper['item_class'] )
							&& has_post_thumbnail( $post_id )
						) {
						$helper['item_class'] .= ' has-thumbnail';
					}

				// Link

					if ( isset( $helper['link'] ) ) {
						$helper['link'] = str_replace( 'data-target="modal"', 'rel="lightbox"', $helper['link'] );
					}


			// Output

				return $helper;

		} // /shortcode_posts_item_class





	/**
	 * 50) Shortcode: Testimonials
	 */

		/**
		 * Testimonials shortcode default image size
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $image_size
		 * @param  array  $atts        Shortcode attributes.
		 */
		public static function shortcode_testimonials_image_size( $image_size, $atts ) {

			// Output

				return 'boo_valley-square';

		} // /shortcode_testimonials_image_size



		/**
		 * Testimonial source (author)
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  string $output
		 * @param  string $name
		 * @param  int    $post_id
		 */
		public static function shortcode_testimonials_source( $output, $name, $post_id = null ) {

			// Processing

				if (
						'wm-author' == $name
						&& empty( $output )
					) {
					$output = get_the_title();
				}


			// Output

				return $output;

		} // /shortcode_testimonials_source



		/**
		 * Testimonials shortcode item class
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $classes
		 * @param  absint $post_id
		 */
		public static function shortcode_testimonials_item_class( $classes, $post_id ) {

			// Processing

				if ( has_post_thumbnail( $post_id ) ) {
					$classes .= ' has-thumbnail';
				}


			// Output

				return $classes;

		} // /shortcode_testimonials_item_class





} // /Boo_Valley_WebMan_Amplifier_Shortcodes

add_action( 'after_setup_theme', 'Boo_Valley_WebMan_Amplifier_Shortcodes::init' );
