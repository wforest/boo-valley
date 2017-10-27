<?php
/**
 * CSS Styles Generator class
 *
 * @uses  `wmhook_boo_valley_theme_options` global hook
 * @uses  `wmhook_boo_valley_enable_rtl` global hook
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Customize
 *
 * @since    1.8.0
 * @version  2.2.4
 *
 * Contents:
 *
 *   0) Init
 *  10) Stylesheet generator
 *  20) Custom styles
 *  30) Filesystem
 * 100) Helpers
 */
final class Boo_Valley_Library_Customize_Styles {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.8.0
		 * @version  2.0.0
		 */
		private function __construct() {

			// Helper variables

				$supports_generator = current_theme_supports( 'stylesheet-generator' );


			// Processing

				// Hooks

					/**
					 * If the theme supports stylesheet file generator, use a WordPress Filesystem API
					 * to generate a single stylesheet file in `wp-content/uploads` folder.
					 *
					 * If the theme does not support the stylesheet file generator, output customized
					 * styles directly into the HTML head.
					 */

					// Actions

						if ( $supports_generator ) {

							add_action( 'customize_save_after', __CLASS__ . '::generate_main_css_all', 98 );

							add_action( 'after_switch_theme', __CLASS__ . '::generate_main_css_all' );

						} else {

							add_action( 'customize_save_after', __CLASS__ . '::custom_styles_cache' );

							add_action( 'switch_theme', __CLASS__ . '::custom_styles_transient_flusher' );

							add_action( 'wmhook_boo_valley_library_theme_upgrade', __CLASS__ . '::custom_styles_transient_flusher' );

						}

					// Filters

						if ( $supports_generator ) {

							// Minify CSS

								add_filter( 'wmhook_boo_valley_library_generate_main_css_output_min', __CLASS__ . '::minify_css' );

							// SSL ready URLs

								add_filter( 'wmhook_boo_valley_library_generate_main_css_output', 'Boo_Valley_Library::fix_ssl_urls', 9999 );

						} else {

							// Minify CSS

								add_filter( 'wmhook_boo_valley_library_custom_styles_output_cache', __CLASS__ . '::minify_css' );

							// SSL ready URLs

								add_filter( 'wmhook_boo_valley_library_custom_styles_output', 'Boo_Valley_Library::fix_ssl_urls', 9999 );

						}

						// Escape inline CSS

							add_filter( 'wmhook_boo_valley_esc_css', 'wp_strip_all_tags' );

						// Minify CSS

							add_filter( 'wmhook_boo_valley_library_generate_main_css_output_min', __CLASS__ . '::minify_css' );

							add_filter( 'wmhook_boo_valley_library_custom_styles_output_cache', __CLASS__ . '::minify_css' );

						// SSL ready URLs

							add_filter( 'wmhook_boo_valley_library_generate_main_css_output', 'Boo_Valley_Library::fix_ssl_urls', 9999 );

							add_filter( 'wmhook_boo_valley_library_custom_styles_output', 'Boo_Valley_Library::fix_ssl_urls', 9999 );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.8.0
		 * @version  1.8.0
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
	 * 10) Stylesheet generator
	 */

		/**
		 * Generate main CSS file
		 *
		 * @since    1.0.0
		 * @version  2.0.5
		 *
		 * @param  array $args
		 */
		public static function generate_main_css( $args = array() ) {

			// Pre

				$pre = apply_filters( 'wmhook_boo_valley_library_generate_main_css_pre', false, $args );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$args = wp_parse_args( $args, apply_filters( 'wmhook_boo_valley_library_generate_main_css_defaults', array(
						'message'        => '<strong>' . esc_html__( "The main theme CSS stylesheet was regenerated. Please refresh your web browser's and server's cache (if you are using a website server caching solution).", 'boo-valley' ) . '</strong>',
						'message_after'  => '',
						'message_before' => '',
						'type'           => '',
					) ) );
				$args = apply_filters( 'wmhook_boo_valley_library_generate_main_css_args', $args );

				$output = $output_min = '';

				$args['type'] = trim( $args['type'] );

				$filesystem = self::get_filesystem();


			// Requirements check

				if (
						! $filesystem
						|| ! is_callable( array( $filesystem, 'put_contents' ) )
						|| ! function_exists( 'wp_mkdir_p' )
					) {
					return;
				}


			// Processing

				// Get the file content with output buffering

					ob_start();

					require_once BOO_VALLEY_PATH . 'assets/css-generate/generate-css' . $args['type'] . '.php';

					$output = trim( ob_get_clean() );

				// Filter output

					$output = apply_filters( 'wmhook_boo_valley_library_generate_main_css_output', $output, $args );

				// Requirements check

					if ( ! $output ) {
						return;
					}

				// Minify output if set

					$output_min = apply_filters( 'wmhook_boo_valley_library_generate_main_css_output_min', $output, $args );

				// Create the theme CSS folder

					$wp_upload_dir = wp_upload_dir();

					$theme_css_url = trailingslashit( $wp_upload_dir['baseurl'] ) . 'wmtheme-boo-valley';
					$theme_css_dir = trailingslashit( $wp_upload_dir['basedir'] ) . 'wmtheme-boo-valley';

					if (
							! ( file_exists( $theme_css_dir ) && is_dir( $theme_css_dir ) )
							&& ! wp_mkdir_p( $theme_css_dir )
						) {

						set_transient(
								'boo_valley_admin_notice',
								array(
									'<strong>' . esc_html__( "ERROR: Wasn't able to create a theme CSS folder! Contact the theme support.", 'boo-valley' ) . '</strong>',
									'notice-error',
									'edit_theme_options',
									2
								),
								( 60 * 60 * 48 )
							);

						remove_theme_mod( '__url_css' . $args['type'] );
						remove_theme_mod( '__path_theme_generated_files' . $args['type'] );

						return false;

					}

				$file_name           = apply_filters( 'wmhook_boo_valley_library_generate_main_css_file_name', 'boo-valley-styles' . $args['type'], $args );
				$global_css_path     = apply_filters( 'wmhook_boo_valley_library_generate_main_css_global_css_path', trailingslashit( $theme_css_dir ) . $file_name . '.css', $args, $file_name );
				$global_css_url      = apply_filters( 'wmhook_boo_valley_library_generate_main_css_global_css_url', trailingslashit( $theme_css_url ) . $file_name . '.css', $args, $file_name );
				$global_css_path_dev = apply_filters( 'wmhook_boo_valley_library_generate_main_css_global_css_path_dev', trailingslashit( $theme_css_dir ) . 'dev-' . $file_name . '.css', $args, $file_name );

				if (
						$output
						&& $filesystem->put_contents( $global_css_path, $output_min )
					) {

					$filesystem->put_contents( $global_css_path_dev, $output );

					// Store the CSS files paths and urls in DB

						set_theme_mod( '__url_css' . $args['type'], $global_css_url );
						set_theme_mod( '__path_theme_generated_files' . $args['type'], str_replace( $wp_upload_dir['basedir'], '', $theme_css_dir ) );
						set_theme_mod( '__theme_installed', true );

					// Admin notice

						set_transient(
								'boo_valley_admin_notice',
								array(
									$args['message_before'] . $args['message'] . $args['message_after'],
									'notice-info',
									'edit_theme_options'
								),
								( 60 * 60 * 24 )
							);

					// Run custom actions

						do_action( 'wmhook_boo_valley_library_generate_main_css', $args );

					return true;

				}

				remove_theme_mod( '__url_css' . $args['type'] );
				remove_theme_mod( '__path_theme_generated_files' . $args['type'] );

				return false;

		} // /generate_main_css



			/**
			 * Generate editor CSS file
			 *
			 * @since    1.3.0
			 * @version  1.3.0
			 */
			public static function generate_main_css_editor() {

				// Output

					self::generate_main_css( array( 'type' => '-editor' ) );

			} // /generate_main_css_editor



			/**
			 * Generate RTL CSS file
			 *
			 * @since    1.3.0
			 * @version  1.3.0
			 */
			public static function generate_main_css_rtl() {

				// Output

					if ( apply_filters( 'wmhook_boo_valley_enable_rtl', false ) ) {
						self::generate_main_css( array( 'type' => '-rtl' ) );
						self::generate_main_css( array( 'type' => '-editor-rtl' ) );
					}

			} // /generate_main_css_rtl



			/**
			 * Generate all CSS files
			 *
			 * @since    1.3.0
			 * @version  1.3.0
			 */
			public static function generate_main_css_all() {

				// Output

					if ( self::generate_main_css() ) {
						self::generate_main_css_editor();
						self::generate_main_css_rtl();
					}

			} // /generate_main_css_all





	/**
	 * 20) Custom styles
	 */

		/**
		 * Replace variables in the custom CSS
		 *
		 * Just use a '[[customizer_option_id]]' tags in your custom CSS styles string
		 * where the specific option value should be used.
		 *
		 * This method allows using a single stylesheet generator, as well as hooking
		 * your custom CSS styles string onto `wmhook_boo_valley_custom_styles`
		 * filter hook when producing an inline CSS output in HTML head.
		 *
		 * @uses  `wmhook_boo_valley_theme_options` global hook
		 * @uses  `wmhook_boo_valley_custom_styles` global hook
		 *
		 * @since    1.0.0
		 * @version  2.2.4
		 *
		 * @param  string  $css        CSS string with variables to replace.
		 *
		 * @param  boolean $set_cache  Determines whether the results should be cached or not.
		 * @param  boolean $return     Whether to return a value or just run the process.
		 */
		public static function custom_styles( $css = '', $set_cache = false, $return = true ) {

			// Pre

				$pre = apply_filters( 'wmhook_boo_valley_library_custom_styles_pre', false, $css, $set_cache, $return );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				$css = trim( (string) apply_filters( 'wmhook_boo_valley_custom_styles', $css ) );

				if ( empty( $css ) ) {
					return;
				}


			// Helper variables

				$output = $css;

				$theme_options = (array) apply_filters( 'wmhook_boo_valley_theme_options', array() );
				$alphas        = array_filter( (array) apply_filters( 'wmhook_boo_valley_library_custom_styles_alphas', array() ) );

				$replacements     = array();
				$set_replacements = true;

				// For inline styles only

					if ( ! $supports_generator = current_theme_supports( 'stylesheet-generator' ) ) {

						$replacements  = array_unique( array_filter( (array) get_transient( 'boo-valley_customizer_values' ) ) );

						/**
						 * Force caching during the first theme display when no cache set
						 * and only default values are used.
						 * Cache is being set only after saving the theme customizer.
						 */
						if ( empty( $replacements ) ) {
							$set_cache = true;
						}

						$set_replacements = is_customize_preview() || empty( $replacements );

					}


			// Processing

				// Setting up replacements array

					if ( ! empty( $theme_options ) && $set_replacements ) {

						foreach ( $theme_options as $option ) {

							// Reset variables

								$option_id = $value = '';

							// Set option ID

								if ( isset( $option['id'] ) ) {
									$option_id = $option['id'];
								}

							// If no option ID set, jump to next option

								if ( empty( $option_id ) ) {
									continue;
								}

							// If we have an ID, get the default value if set

								if ( isset( $option['default'] ) && 'image' !== $option['type'] ) {
									$value = $option['default'];
								}

							// Get the option value saved in database and apply it when exists

								$mod = get_theme_mod( $option_id );

								/**
								 * As this is producing CSS output, we allow checking
								 * for an empty or zero value with checkbox and range controls.
								 * Checkbox can be used in conditional comments in CSS for example (see below).
								 * Also image control can have a value of `false` in which case the
								 * option default value is used. If the image control is of empty string
								 * the `none` is set as value.
								 */
								if (
										$mod
										|| is_numeric( $mod )
										|| in_array( $option['type'], array( 'checkbox', 'image' ) )
									) {
									$value = $mod;
								}

							// Make sure the color value contains '#'

								if ( 'color' === $option['type'] ) {
									$value = self::maybe_hash_hex_color( $value );
								}

							// Make sure the image URL is used in CSS format

								if ( 'image' === $option['type'] ) {

									if ( is_array( $value ) && isset( $value['id'] ) ) {
										$value = absint( $value['id'] );
									}

									if ( is_numeric( $value ) ) {
										$value = wp_get_attachment_image_src( absint( $value ), 'full' );
										$value = $value[0];
									}

									if ( ! empty( $value ) ) {
										$value = "url('" . esc_url( $value ) . "')";
									} elseif ( false === $value ) {
										$value = "url('" . esc_url( $option['default'] ) . "')";
									} else {
										$value = 'none';
									}

								}

							// CSS output

								if ( isset( $option['css_output'] ) ) {

									switch ( $option['css_output'] ) {
										case 'comma_list':
										case 'comma_list_quoted':

												if ( is_array( $value ) ) {

													if ( 'comma_list_quoted' == $option['css_output'] ) {
														$value = "'" . implode( "', '", $value ) . "'";
													} else {
														$value = implode( ', ', $value );
													}

												}

												$value .= ',';

											break;

										default:

												if ( is_callable( $option['css_output'] ) ) {
													$value = call_user_func( $option['css_output'], $value, $option );
												}

											break;
									} // /switch

								}

							// Value filtering

								$value = apply_filters( 'wmhook_boo_valley_library_custom_styles_value', $value, $option );

							// Convert array to string as otherwise the strtr() function throws error

								if ( is_array( $value ) ) {
									$value = (string) implode( ',', (array) $value );
								}

							// Finally, modify the output string

								$css_option_id = str_replace( '-', '_', $option_id );

								$replacements[ '[[' . $css_option_id . ']]' ] = $value;

								// Add also rgba() color interpretation

									if ( 'color' === $option['type'] && ! empty( $alphas ) ) {
										foreach ( $alphas as $alpha ) {
											$replacements[ '[[' . $css_option_id . '(' . absint( $alpha ) . ')]]' ] = self::color_hex_to_rgba( $value, absint( $alpha ) );
										} // /foreach
									}

								// Option related conditional CSS comment

									if ( isset( $option['is_css_condition'] ) ) {

										if ( 'image' === $option['type'] && 'none' === $value ) {
											$value = false;
										}

										if ( (bool) $value ) {
											$replacements[ '/**if(' . $css_option_id . ')' ]    = '';
											$replacements[ 'endif(' . $css_option_id . ')**/' ] = '';
										} else {
											$replacements[ '/**if!(' . $css_option_id . ')' ]    = '';
											$replacements[ 'endif!(' . $css_option_id . ')**/' ] = '';
										}

									}

						} // /foreach

						// Add WordPress Custom Background and Header support

							// Background color

								if ( $value = get_background_color() ) {
									$replacements['[[background_color]]'] = self::maybe_hash_hex_color( $value );

									if ( ! empty( $alphas ) ) {
										foreach ( $alphas as $alpha ) {
											$replacements[ '[[background_color(' . absint( $alpha ) . ')]]' ] = self::color_hex_to_rgba( $value, absint( $alpha ) );
										} // /foreach
									}
								}

							// Background image

								if ( $value = esc_url( get_background_image() ) ) {
									$replacements['[[background_image]]'] = "url('" . esc_url( $value ) . "')";
								} else {
									$replacements['[[background_image]]'] = 'none';
								}

							// Header text color

								if ( $value = get_header_textcolor() ) {
									$replacements['[[header_textcolor]]'] = self::maybe_hash_hex_color( $value );

									if ( ! empty( $alphas ) ) {
										foreach ( $alphas as $alpha ) {
											$replacements[ '[[header_textcolor(' . absint( $alpha ) . ')]]' ] = self::color_hex_to_rgba( $value, absint( $alpha ) );
										} // /foreach
									}
								}

							// Header image

								if ( $value = esc_url( get_header_image() ) ) {
									$replacements['[[header_image]]'] = "url('" . esc_url( $value ) . "')";
								} else {
									$replacements['[[header_image]]'] = 'none';
								}

						$replacements = (array) apply_filters( 'wmhook_boo_valley_library_custom_styles_replacements', $replacements, $theme_options, $output );

						// Create a new cache for replacements values, only when saving theme customizer

							if ( $set_cache && ! empty( $replacements ) ) {
								set_transient( 'boo-valley_customizer_values', $replacements );
							}

					}

				// Prepare output

					if ( $supports_generator ) {

						// Replace tags in custom CSS strings with actual values

							$output = strtr( $output, $replacements );

					} else {

						$output_cached = (string) get_transient( 'boo-valley_custom_css' );

						// Debugging (via "debug" URL parameter)

							if ( isset( $_GET['debug'] ) ) {
								$output_cached = (string) get_transient( 'boo-valley_custom_css_debug' );
							}

						if ( empty( $output_cached ) || is_customize_preview() ) {

							// Replace tags in custom CSS strings with actual values

								$output = strtr( $output, $replacements );

							if ( $set_cache ) {
								set_transient( 'boo-valley_custom_css_debug', apply_filters( 'wmhook_boo_valley_library_custom_styles_output_cache_debug', $output ) );
								set_transient( 'boo-valley_custom_css', apply_filters( 'wmhook_boo_valley_library_custom_styles_output_cache', $output ) );
							}

						} else {

							$output = $output_cached;

						}

					}


			// Output

				$output = (string) apply_filters( 'wmhook_boo_valley_library_custom_styles_output', $output );

				if ( $output && $return ) {
					return trim( (string) $output );
				}

		} // /custom_styles



			/**
			 * Flush out the transients used in `custom_styles`
			 *
			 * For HTML head inline CSS styles output only.
			 *
			 * @since    1.0.0
			 * @version  1.1.0
			 */
			public static function custom_styles_transient_flusher() {

				// Processing

					delete_transient( 'boo-valley_customizer_values' );
					delete_transient( 'boo-valley_custom_css_debug' );
					delete_transient( 'boo-valley_custom_css' );

			} // /custom_styles_transient_flusher



			/**
			 * Force cache only for the above function
			 *
			 * For HTML head inline CSS styles output only.
			 * Useful to pass into the action hooks.
			 *
			 * @since    1.0.0
			 * @version  1.0.0
			 */
			public static function custom_styles_cache() {

				// Processing

					// Set cache, do not return

						self::custom_styles( true, false );

			} // /custom_styles_cache





	/**
	 * 30) Filesystem
	 */

		/**
		 * Get WP_Filesystem
		 *
		 * Possible filesystem methods: 'direct', 'ssh2', 'ftpext' or 'ftpsockets'.
		 *
		 * No need to use `request_filesystem_credentials()` if using 'direct' method.
		 * @see  http://aquagraphite.com/2012/11/using-wp_filesystem-to-generate-dynamic-css/
		 *
		 * If not using 'direct' method, display an admin notice about setting up
		 * the FTP credentials in `wp-config.php`.
		 * @see  http://codex.wordpress.org/Editing_wp-config.php#WordPress_Upgrade_Constants
		 *
		 * @see  https://codex.wordpress.org/Filesystem_API
		 * @see  http://ottopress.com/2011/tutorial-using-the-wp_filesystem/
		 * @see  http://wordpress.findincity.net/view/63538464303732726692954/using-wpfilesystem-in-plugins-to-store-customizer-settings
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 */
		public static function get_filesystem() {

			// Pre

				$pre = apply_filters( 'wmhook_boo_valley_library_get_filesystem_pre', false );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				// Require the WordPress filesystem functionality if not found

					if (
							! function_exists( 'get_filesystem_method' )
							&& ABSPATH
						) {
						require_once( ABSPATH . '/wp-admin/includes/file.php' );
					}

				// Check the filesystem method

					if (
							'direct' !== get_filesystem_method()
							&& ! defined( 'FTP_USER' )
						) {

						// If we don't have filesystem access, display an admin notice

							set_transient(
									'boo_valley_admin_notice',
									array(
										esc_html__( 'The theme writes a files to your server. You do not appear to have your FTP credentials set up in "wp-config.php" file.', 'boo-valley' ) . ' <a href="http://codex.wordpress.org/Editing_wp-config.php#WordPress_Upgrade_Constants" target="_blank">' . esc_html__( 'Please set your FTP credentials first.', 'boo-valley' ) . '</a>',
										'notice-error',
										'edit_theme_options'
									),
									( 60 * 60 * 24 )
								);

						return false;

					}


			// Processing

				WP_Filesystem();

				global $wp_filesystem;


			// Output

				return $wp_filesystem;

		} // /get_filesystem





	/**
	 * 100) Helpers
	 */

		/**
		 * CSS minifier
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 *
		 * @param  string $css Code to minimize
		 */
		public static function minify_css( $css ) {

			// Pre

				$pre = apply_filters( 'wmhook_boo_valley_library_minify_css_pre', false, $css );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				if ( ! is_string( $css ) ) {
					return $css;
				}


			// Processing

				// Remove CSS comments

					$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );

				// Remove tabs, spaces, line breaks, etc.

					$css = str_replace( array( "\r\n", "\r", "\n", "\t" ), '', $css );
					$css = str_replace( array( '  ', '   ', '    ', '     ' ), ' ', $css );
					$css = str_replace( array( ' { ', ': ', '; }' ), array( '{', ':', '}' ), $css );


			// Output

				return $css;

		} // /minify_css



		/**
		 * Hex color to RGBA
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 *
		 * @link  http://php.net/manual/en/function.hexdec.php
		 *
		 * @param  string $hex
		 * @param  absint $alpha [0-100]
		 *
		 * @return  string Color in rgb() or rgba() format to use in CSS.
		 */
		public static function color_hex_to_rgba( $hex, $alpha = 100 ) {

			// Pre

				$pre = apply_filters( 'wmhook_boo_valley_library_color_hex_to_rgba_pre', false, $hex, $alpha );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$alpha = absint( $alpha );

				$output = ( 100 === $alpha ) ? ( 'rgb(' ) : ( 'rgba(' );

				$rgb = array();

				$hex = preg_replace( '/[^0-9A-Fa-f]/', '', $hex );
				$hex = substr( $hex, 0, 6 );


			// Processing

				// Converting hex color into rgb

					$color = (int) hexdec( $hex );

					$rgb['r'] = (int) 0xFF & ( $color >> 0x10 );
					$rgb['g'] = (int) 0xFF & ( $color >> 0x8 );
					$rgb['b'] = (int) 0xFF & $color;

					$output .= implode( ',', $rgb );

				// Using alpha (rgba)?

					if ( 100 > $alpha ) {
						$output .= ',' . ( $alpha / 100 );
					}

				// Closing opening bracket

					$output .= ')';


			// Output

				return $output;

		} // /color_hex_to_rgba



		/**
		 * Duplicating WordPress native function in case it does not exist yet
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @link  https://developer.wordpress.org/reference/functions/maybe_hash_hex_color/
		 * @link  https://developer.wordpress.org/reference/functions/sanitize_hex_color_no_hash/
		 *
		 * @param  string $color
		 */
		public static function maybe_hash_hex_color( $color ) {

			// Requirements check

				if (
						function_exists( 'maybe_hash_hex_color' )
						&& function_exists( 'sanitize_hex_color_no_hash' )
					) {
					return maybe_hash_hex_color( $color );
				}


			// Helper variables

				// 3 or 6 hex digits, or the empty string.

					if ( preg_match( '|([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
						$color = ltrim( $color, '#' );
					} else {
						$color = '';
					}


			// Processing

				if ( $color ) {
					$color = '#' . $color;
				}


			// Output

				return $color;

		} // /maybe_hash_hex_color





} // /Boo_Valley_Library_Customize_Styles

add_action( 'after_setup_theme', 'Boo_Valley_Library_Customize_Styles::init', 20 );
