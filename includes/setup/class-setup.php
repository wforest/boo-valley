<?php
/**
 * Theme Setup Class
 *
 * Theme options with `__` prefix (`get_theme_mod( '__option_id' )`) are theme
 * setup related options and can not be edited via customizer.
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
 * 10) Installation
 * 20) Setup
 * 30) Globals
 * 40) Images
 * 50) Typography
 * 60) Visual editor
 * 70) Others
 */
class Boo_Valley_Setup {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 */
		private function __construct() {

			// Processing

				// Setup

					self::content_width();

					/**
					 * Declare support for stylesheet file generator
					 *
					 * Has to be declared early for theme upgrades to regenerate styles correctly.
					 */
					add_theme_support( 'stylesheet-generator' );

				// Hooks

					// Actions

						add_action( 'load-themes.php', __CLASS__ . '::welcome_admin_notice_activation' );

						add_action( 'after_setup_theme', __CLASS__ . '::installation', 5 );

						add_action( 'after_setup_theme', __CLASS__ . '::setup' );

						add_action( 'after_setup_theme', __CLASS__ . '::visual_editor' );

						add_action( 'init', __CLASS__ . '::register_meta' );

						add_action( 'admin_init', __CLASS__ . '::image_sizes_notice' );

						// add_action( 'switch_theme', __CLASS__ . '::image_sizes_reset' );

					// Filters

						add_filter( 'wmhook_boo_valley_enable_rtl', '__return_true' );

						add_action( 'wmhook_boo_valley_library_theme_upgrade', 'Boo_Valley_Library_Customize_Styles::generate_main_css_all' );

						add_filter( 'wmhook_boo_valley_setup_image_sizes', __CLASS__ . '::image_sizes' );

						add_filter( 'wmhook_boo_valley_assets_google_fonts_url_fonts_setup', __CLASS__ . '::google_fonts' );

						add_filter( 'wmhook_boo_valley_library_editor_custom_mce_format', __CLASS__ . '::visual_editor_formats' );

						add_filter( 'wmhook_boo_valley_is_masonry_layout', __CLASS__ . '::is_masonry' );

						add_filter( 'wmhook_boo_valley_widget_css_classes', __CLASS__ . '::widget_css_classes' );

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
	 * 10) Installation
	 */

		/**
		 * Theme installation process
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function installation() {

			// Helper variables

				$installed = get_theme_mod( '__theme_installed' );


			// Requirements check

				if ( $installed ) {
					return;
				}


			// Processing

				// Generate the custom stylesheet

					Boo_Valley_Library_Customize_Styles::generate_main_css_all();

				// Set Beaver Builder post types on theme's first activation
				// This is required here as the Beaver Builder plugin might not be active yet

					update_option( '_fl_builder_post_types', array(
							'post',
							'page',
							'wm_projects',
							'wm_staff',
							'product',
						) );

				// Site branding defaults

					if ( ! get_theme_mod( 'custom_logo' ) ) {
						set_theme_mod( 'header_textcolor', 'blank' );
						set_theme_mod( 'custom_logo', -1 );
					}

				// Other theme installation actions

					/**
					 * IMPORTANT:
					 *
					 * This action is being triggered on `after_setup_theme` action run
					 * with priority 1, so make sure you hook even earlier!
					 */
					do_action( 'wmhook_boo_valley_installation' );

		} // /installation



		/**
		 * Initiate "Welcome" admin notice
		 *
		 * @since    1.1.0
		 * @version  1.1.0
		 */
		public static function welcome_admin_notice_activation() {

			// Processing

				global $pagenow;

				if (
					is_admin()
					&& 'themes.php' == $pagenow
					&& isset( $_GET['activated'] )
				) {

					add_action( 'admin_notices', __CLASS__ . '::welcome_admin_notice', 99 );

				}

		} // /welcome_admin_notice_activation



		/**
		 * Display "Welcome" admin notice
		 *
		 * @since    1.1.0
		 * @version  1.4.0
		 */
		public static function welcome_admin_notice() {

			// Helper variables

				$theme_name = wp_get_theme( 'boo-valley' )->get( 'Name' );


			// Output

				?>

				<div class="updated notice is-dismissible theme-welcome-notice">
					<h2>
						<?php

							printf(
								esc_html_x( 'Thank you for installing %s!', '%s: Theme name.', 'boo-valley' ),
								'<strong>' . $theme_name . '</strong>'
							);

						?>
					</h2>
					<p>
						<?php esc_html_e( 'Please read "Welcome" page for information about the theme setup.', 'boo-valley' ); ?>
					</p>
					<p class="call-to-action">
						<a href="<?php echo esc_url( admin_url( 'themes.php?page=boo-valley-welcome' ) ); ?>" class="button button-primary button-hero">
							<?php

								printf(
									esc_html_x( 'Get started with %s', '%s: Theme name.', 'boo-valley' ),
									$theme_name
								);

							?>
						</a>
					</p>
				</div>

				<?php

				// Related styles

				?>

				<style type="text/css" media="screen">

					.notice.theme-welcome-notice {
						padding: 2.62em;
						text-align: center;
						background: rgba(0,0,0,.01);
						border: 1em solid rgba(255,255,255,.85);
					}

					.theme-welcome-notice h2 {
						margin: .5em 0;
						font-weight: 400;
					}

					.theme-welcome-notice strong {
						font-weight: bolder;
					}

					.theme-welcome-notice .call-to-action {
						margin-top: 1.62em;
					}

				</style>

				<?php

		} // /welcome_admin_notice





	/**
	 * 20) Setup
	 */

		/**
		 * Theme setup
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 */
		public static function setup() {

			// Helper variables

				$image_sizes   = array_filter( (array) apply_filters( 'wmhook_boo_valley_setup_image_sizes', array() ) );
				$editor_styles = array_filter( (array) apply_filters( 'wmhook_boo_valley_setup_editor_stylesheets', array() ) );


			// Processing

				// Localization

					/**
					 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
					 */

					// wp-content/languages/themes/boo-valley/en_GB.mo

						load_theme_textdomain( 'boo-valley', trailingslashit( WP_LANG_DIR ) . 'themes/' . get_template() );

					// wp-content/themes/child-theme/languages/en_GB.mo

						load_theme_textdomain( 'boo-valley', get_stylesheet_directory() . '/languages' );

					// wp-content/themes/boo-valley/languages/en_GB.mo

						load_theme_textdomain( 'boo-valley', get_template_directory() . '/languages' );

				// Declare support for child theme stylesheet automatic enqueuing

					add_theme_support( 'child-theme-stylesheet' );

				// Add editor stylesheets

					add_editor_style( $editor_styles );

				// Custom menus

					/**
					 * @see  includes/frontend/class-menu.php
					 */

				// Title tag

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
					 */
					add_theme_support( 'title-tag' );

				// Site logo

					/**
					 * @link  https://codex.wordpress.org/Theme_Logo
					 */
					add_theme_support( 'custom-logo' );

				// Feed links

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Feed_Links
					 */
					add_theme_support( 'automatic-feed-links' );

				// Enable HTML5 markup

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
					 */
					add_theme_support( 'html5', array(
							'caption',
							'comment-form',
							'comment-list',
							'gallery',
							'search-form',
						) );

				// Custom header

					/**
					 * @see  includes/custom-header/class-intro.php
					 */

				// Custom background

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Custom_Background
					 */
					add_theme_support( 'custom-background', apply_filters( 'wmhook_boo_valley_setup_custom_background_args', array(
							'default-image' => get_theme_file_uri( 'assets/images/pattern.png' ),
							'default-color' => 'a37852', // 5% lighter and 10% less saturated than accent color
						) ) );

				// Post formats

					/**
					 * @see  includes/frontend/class-post-media.php
					 */

				// Thumbnails support

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
					 */
					add_theme_support( 'post-thumbnails', array( 'attachment:audio', 'attachment:video' ) );
					add_theme_support( 'post-thumbnails' );

					// Image sizes (x, y, crop)

						if ( ! empty( $image_sizes ) ) {

							foreach ( $image_sizes as $size => $setup ) {

								if (
										in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) )
										&& ! get_theme_mod( '__image_size_' . $size )
									) {

									/**
									 * Force the default image sizes on theme installation only.
									 * This allows users to set their own sizes later, but a notification is displayed.
									 */

									$original_image_width = get_option( $size . '_size_w' );

										if ( $image_sizes[ $size ][0] != $original_image_width ) {
											update_option( $size . '_size_w', $image_sizes[ $size ][0] );
										}

									$original_image_height = get_option( $size . '_size_h' );

										if ( $image_sizes[ $size ][1] != $original_image_height ) {
											update_option( $size . '_size_h', $image_sizes[ $size ][1] );
										}

									$original_image_crop = get_option( $size . '_crop' );

										if ( $image_sizes[ $size ][2] != $original_image_crop ) {
											update_option( $size . '_crop', $image_sizes[ $size ][2] );
										}

									set_theme_mod(
											'__image_size_' . $size,
											array(
												$original_image_width,
												$original_image_height,
												$original_image_crop
											)
										);

								} else {

									add_image_size(
											$size,
											$image_sizes[ $size ][0],
											$image_sizes[ $size ][1],
											$image_sizes[ $size ][2]
										);

								}

							} // /foreach

						}

				// Force-regenerate styles

					if ( get_transient( 'boo_valley_regenerate_styles' ) ) {
						Boo_Valley_Library_Customize_Styles::generate_main_css_all();
						delete_transient( 'boo_valley_regenerate_styles' );
					}

		} // /setup





	/**
	 * 30) Globals
	 */

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet
		 *
		 * Priority -100 to make it available to lower priority callbacks.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @global  int $content_width
		 */
		public static function content_width() {

			// Processing

				$content_width = absint( get_theme_mod( 'layout_width_content', 1180 ) );
				$site_width    = absint( get_theme_mod( 'layout_width_site', 1640 ) );

				// Make content width max 88% of site width

					if ( $content_width > absint( $site_width * .88 ) ) {
						$content_width = absint( $site_width * .88 );
					}

				// Allow filtering

					$GLOBALS['content_width'] = absint( apply_filters( 'wmhook_boo_valley_content_width', $content_width ) );

		} // /content_width





	/**
	 * 40) Images
	 */

		/**
		 * Image sizes
		 *
		 * @example
		 *
		 *   $image_sizes = array(
		 *     'image_size_id' => array(
		 *       absint( width ),
		 *       absint( height ),
		 *       (bool) cropped?,
		 *       (string) optional_theme_usage_explanation_text
		 *     )
		 *   );
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  array $image_sizes
		 */
		public static function image_sizes( $image_sizes = array() ) {

			// Helper variables

				global $content_width;

				// Intro image size

					if ( 'boxed' === get_theme_mod( 'layout_site', 'fullwidth' ) ) {

						$intro_width = absint( get_theme_mod( 'layout_width_site', 1640 ) );

						if ( 1000 > $intro_width ) {
							// Can't set site width less then 1000 px,
							// so default to max boxed site width then.
							$intro_width = 1640;
						}

					} else {

						$intro_width = 1920;

					}


			// Processing

				$image_sizes = array(

						'thumbnail' => array(
								448,
								252,
								true,
								esc_html__( 'In list of child pages.', 'boo-valley' ) . '<br>' . esc_html__( 'In shortcodes and page builder modules.', 'boo-valley' ) . '<br>' . esc_html__( 'In gallery post format in posts list.', 'boo-valley' ),
							),

						'medium' => array(
								absint( $content_width * .62 ),
								0,
								false,
								esc_html__( 'In list of Projects.', 'boo-valley' ),
							),

						'large' => array(
								absint( $intro_width ),
								0,
								false,
								esc_html__( 'In page intro section.', 'boo-valley' ),
							),

						/**
						 * @since  WordPress 4.4.0
						 */
						'medium_large' => array(
								absint( $content_width),
								0,
								false,
								esc_html__( 'This is WordPress native image size.', 'boo-valley' ) . '<br>' . esc_html__( 'Not used in the theme.', 'boo-valley' ),
							),

						'boo_valley-thumbnail' => array(
								absint( $content_width * .62 ),
								absint( $content_width * .62 / 2 ),
								true,
								esc_html__( 'In posts list.', 'boo-valley' ),
							),

						'boo_valley-square' => array(
								448,
								448,
								true,
								esc_html__( 'In Staff posts.', 'boo-valley' ) . '<br>' . esc_html__( 'In list of Testimonials.', 'boo-valley' ),
							),

					);


			// Output

				return $image_sizes;

		} // /image_sizes



		/**
		 * Reset predefined image sizes to their original values
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 */
		public static function image_sizes_reset() {

			// Requirements check

				if (
						is_child_theme()
						&& 'boo-valley' == wp_get_theme()->get_template()
					) {
					return;
				}


			// Helper variables

				$image_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );
				$theme_mods  = get_theme_mods();


			// Processing

				foreach ( $image_sizes as $size ) {

					$values = (array) ( isset( $theme_mods[ '__image_size_' . $size ] ) ) ? ( $theme_mods[ '__image_size_' . $size ] ) : ( array() );

					// Skip processing if we do not have the image height and crop value

						if ( ! isset( $values[1] ) || ! isset( $values[2] ) ) {
							continue;
						}

					// Old image width

						if ( $values[0] ) {
							update_option( $size . '_size_w', $values[0] );
						}

					// Old image height

						if ( $values[1] ) {
							update_option( $size . '_size_h', $values[1] );
						}

					// Old image crop

						if ( $values[2] ) {
							update_option( $size . '_crop', $values[2] );
						}

					// Remove the saved reset size

						remove_theme_mod( '__image_size_' . $size );

				} // /foreach

		} // /image_sizes_reset



		/**
		 * Register recommended image sizes notice
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function image_sizes_notice() {

			// Processing

				add_settings_field(
						// $id
						'recommended-image-sizes',
						// $title
						'',
						// $callback
						__CLASS__ . '::image_sizes_notice_html',
						// $page
						'media',
						// $section
						'default',
						// $args
						array()
					);

				register_setting(
						// $option_group
						'media',
						// $option_name
						'recommended-image-sizes',
						// $sanitize_callback
						'esc_attr'
					);

		} // /image_sizes_notice



		/**
		 * Display recommended image sizes notice
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function image_sizes_notice_html() {

			// Processing

				get_template_part( 'templates/parts/component-media', 'image-sizes' );

		} // /image_sizes_notice_html





	/**
	 * 50) Typography
	 */

		/**
		 * Google Fonts
		 *
		 * Custom fonts setup left for plugins.
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  array $fonts_setup
		 */
		public static function google_fonts( $fonts_setup ) {

			// Requirements check

				if ( get_theme_mod( 'typography_custom_fonts', false ) ) {
					return array();
				}


			// Helper variables

				$fonts_setup = array();


			// Processing

				/**
				 * translators: Do not translate into your own language!
				 * If there are characters in your language that are not
				 * supported by Playfair Display font, translate this to 'off'.
				 * The font will not load then.
				 */
				if ( 'off' !== esc_html_x( 'on', 'Playfair Display font: on or off', 'boo-valley' ) ) {
					$fonts_setup[] = 'Playfair Display:400,400italic,700,700italic,900,900italic';
				}


			// Output

				return $fonts_setup;

		} // /google_fonts





	/**
	 * 60) Visual editor
	 */

		/**
		 * Include Visual Editor (TinyMCE) setup
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function visual_editor() {

			// Processing

				if (
						is_admin()
						|| isset( $_GET['fl_builder'] )
					) {

					require_once BOO_VALLEY_LIBRARY . 'includes/classes/class-visual-editor.php';

				}

		} // /visual_editor



		/**
		 * TinyMCE "Formats" dropdown alteration
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  array $formats
		 */
		public static function visual_editor_formats( $formats ) {

			// Processing

				// Font weight classes

					$font_weights = array(

							// Font weight names from https://developer.mozilla.org/en/docs/Web/CSS/font-weight

							100 => esc_html__( 'Thin (hairline) text', 'boo-valley' ),
							200 => esc_html__( 'Extra light text', 'boo-valley' ),
							300 => esc_html__( 'Light text', 'boo-valley' ),
							400 => esc_html__( 'Normal weight text', 'boo-valley' ),
							500 => esc_html__( 'Medium text', 'boo-valley' ),
							600 => esc_html__( 'Semi bold text', 'boo-valley' ),
							700 => esc_html__( 'Bold text', 'boo-valley' ),
							800 => esc_html__( 'Extra bold text', 'boo-valley' ),
							900 => esc_html__( 'Heavy text', 'boo-valley' ),

						);

					$formats[ 250 . 'text_weights' ] = array(
							'title' => esc_html__( 'Text weights', 'boo-valley' ),
							'items' => array(),
						);

					foreach ( $font_weights as $weight => $name ) {

						$formats[ 250 . 'text_weights' ]['items'][ 250 . 'text_weights' . $weight ] = array(
								'title'    => $name . ' (' . $weight . ')',
								'selector' => 'h1, h2, h3, h4, h5, h6, p, blockquote, address',
								'classes'  => 'weight-' . $weight,
							);

					} // /foreach

				// Font classes

					$formats[ 260 . 'font' ] = array(
							'title' => esc_html__( 'Fonts', 'boo-valley' ),
							'items' => array(

								100 . 'font' . 100 => array(
									'title'    => esc_html__( 'General font', 'boo-valley' ),
									'selector' => 'h1, h2, h3, h4, h5, h6, p, blockquote, address',
									'classes'  => 'font-body',
								),

								100 . 'font' . 110 => array(
									'title'    => esc_html__( 'Headings font', 'boo-valley' ),
									'selector' => 'h1, h2, h3, h4, h5, h6, p, blockquote, address',
									'classes'  => 'font-headings',
								),

								100 . 'font' . 120 => array(
									'title'    => esc_html__( 'Logo font', 'boo-valley' ),
									'selector' => 'h1, h2, h3, h4, h5, h6, p, blockquote, address',
									'classes'  => 'font-logo',
								),

								100 . 'font' . 130 => array(
									'title'    => esc_html__( 'Inherit font', 'boo-valley' ),
									'selector' => 'h1, h2, h3, h4, h5, h6, p, blockquote, address',
									'classes'  => 'font-inherit',
								),

							),
						);

				// Buttons

					$formats[ 500 . 'buttons' ] = array(
							'title' => esc_html__( 'Buttons', 'boo-valley' ),
							'items' => array(

								500 . 'buttons' . 100 => array(
									'title'    => esc_html__( 'Button from link', 'boo-valley' ),
									'selector' => 'a',
									'classes'  => 'button',
								),

								500 . 'buttons' . 110 => array(
									'title'    => esc_html__( 'Button from link, small', 'boo-valley' ),
									'selector' => 'a',
									'classes'  => 'button size-small',
								),

								500 . 'buttons' . 120 => array(
									'title'    => esc_html__( 'Button from link, large', 'boo-valley' ),
									'selector' => 'a',
									'classes'  => 'button size-large',
								),

								500 . 'buttons' . 130 => array(
									'title'    => esc_html__( 'Button from link, extra large', 'boo-valley' ),
									'selector' => 'a',
									'classes'  => 'button size-extra-large',
								),

							),
						);


			// Output

				return $formats;

		} // /visual_editor_formats





	/**
	 * 70) Others
	 */

		/**
		 * Set transient to force styles regeneration
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function regenerate_styles() {

			// Processing

				set_transient( 'boo_valley_regenerate_styles', true );

		} // /regenerate_styles



		/**
		 * Register post meta
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function register_meta() {

			// Processing

				register_meta( 'post', 'show_intro_widgets', 'absint' );
				register_meta( 'post', 'no_intro',           'absint' );
				register_meta( 'post', 'layout_no_paddings', 'absint' );
				register_meta( 'post', 'layout_stretched',   'absint' );
				register_meta( 'post', 'no_thumbnail',       'absint' );
				register_meta( 'post', 'intro_image',        'esc_attr' );
				register_meta( 'post', 'quote_source',       'esc_html' );

		} // /register_meta



		/**
		 * When to use masonry posts layout?
		 *
		 * @since    1.2.0
		 * @version  1.4.0
		 */
		public static function is_masonry() {

			// Helper variables

				$is_masonry_blog = ( 'masonry' === get_theme_mod( 'blog_style', 'list' ) );
				$is_masonry_blog = $is_masonry_blog && ( is_home() || is_category() || is_tag() || is_date() );


			// Output

				return $is_masonry_blog;

		} // /is_masonry



		/**
		 * Widget CSS classes
		 *
		 * @since    1.2.0
		 * @version  1.2.0
		 *
		 * @param  array $classes
		 */
		public static function widget_css_classes( $classes = array() ) {

			// Processing

				$classes = array_merge( (array) $classes, array(
						'hide-widget-title-accessibly',
						'hide-widget-title',
						'set-flex-grow-2',
						'set-flex-grow-3',
						'set-flex-grow-4',
					) );


			// Output

				return $classes;

		} // /widget_css_classes





} // /Boo_Valley_Setup

add_action( 'after_setup_theme', 'Boo_Valley_Setup::init', -100 ); // Low priority for early $content_width setup
