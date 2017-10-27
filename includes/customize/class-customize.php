<?php
/**
 * Theme Customization Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.4.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Options
 *  20) Replacements
 *  30) Active callbacks
 *  40) Partial refresh
 * 100) Helpers
 */
class Boo_Valley_Customize {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @uses  `wmhook_boo_valley_theme_options` global hook
		 * @uses  `wmhook_boo_valley_generate_css_replacements` global hook
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		private function __construct() {

			// Processing

				// Setup

					// Indicate widget sidebars can use selective refresh in the Customizer

						add_theme_support( 'customize-selective-refresh-widgets' );

				// Hooks

					// Actions

						add_action( 'customize_register', __CLASS__ . '::setup' );

					// Filters

						add_filter( 'wmhook_boo_valley_theme_options', __CLASS__ . '::options', 5 );

						add_filter( 'wmhook_boo_valley_generate_css_replacements', __CLASS__ . '::css_replacements' );

						add_filter( 'wmhook_boo_valley_library_custom_styles_alphas', __CLASS__ . '::rgba_alphas' );

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
	 * 10) Options
	 */

		/**
		 * Modify native WordPress options and setup partial refresh
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  object $wp_customize  WP customizer object.
		 */
		public static function setup( $wp_customize ) {

			// Processing

				// Move the custom logo option down

					$wp_customize->get_control( 'custom_logo' )->priority = 101;

				// Remove header color in favor of theme options

					$wp_customize->remove_control( 'header_textcolor' );

				// Partial refresh

					// Site title

						$wp_customize->selective_refresh->add_partial( 'blogname', array(
								'selector'        => '.site-title-text',
								'render_callback' => __CLASS__ . '::partial_blogname',
							) );

					// Site description

						$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
								'selector'        => '.site-description',
								'render_callback' => __CLASS__ . '::partial_blogdescription',
							) );

					// Site info (footer credits)

						$wp_customize->selective_refresh->add_partial( 'texts_site_info', array(
								'selector'        => '.footer-area-site-info',
								'render_callback' => __CLASS__ . '::partial_texts_site_info',
							) );

					// Option pointers only

						$wp_customize->selective_refresh->add_partial( 'archive_title_prefix', array(
								'selector' => '.archive .intro-title',
							) );

						$wp_customize->selective_refresh->add_partial( 'blog_style', array(
								'selector' => '.blog #main > .posts',
							) );

		} // /setup



		/**
		 * Set theme options array
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  array $options
		 */
		public static function options( $options = array() ) {

			// Helper variables

				global $content_width;

				$alpha = (array) self::rgba_alphas();

				// Helper CSS selectors for `preview_js` (the "@" will be replaced with `selector_replace`)

					$h_tags  =   '@h1, @.h1';
					$h_tags .= ', @h2, @.h2';
					$h_tags .= ', @h3, @.h3';
					$h_tags .= ', @h4, @.h4';

				// Registered image sizes

					$image_sizes = (array) get_intermediate_image_sizes();
					$image_sizes = array_combine( $image_sizes, $image_sizes );


			// Processing

				/**
				 * Theme customizer options array
				 */

					$options = array(

						/**
						 * Site identity: Logo image size
						 */

							'0' . 10 . 'logo' . 10 => array(
								'id'          => 'custom_logo_dimenstions_info',
								'section'     => 'title_tagline',
								'priority'    => 100,
								'type'        => 'html',
								'content'     => '<h3>' . esc_html__( 'Logo image', 'boo-valley' ) . '</h3>',
								'description' => esc_html__( 'Please, do not forget to set the logo max height.', 'boo-valley' ) . ' ' . esc_html__( 'To make your logo image ready for high DPI screens, please upload twice as big image.', 'boo-valley' ),
							),

								'0' . 10 . 'logo' . 20 => array(
									'section'     => 'title_tagline',
									'priority'    => 102,
									'type'        => 'text',
									'id'          => 'custom_logo_height',
									'label'       => esc_html__( 'Max logo image height (px)', 'boo-valley' ),
									'default'     => 28,
									'validate'    => 'absint',
									'input_attrs' => array(
										'size'     => 5,
										'maxwidth' => 3,
									),
									'preview_js'  => array(
										'custom' => "jQuery( '.custom-logo' ).css( 'max-height', to + 'px' );",
									),
								),



						/**
						 * Theme credits
						 */
						'0' . 90 . 'placeholder' => array(
							'id'                   => 'placeholder',
							'type'                 => 'section',
							'create_section'       => '',
							'in_panel'             => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
							'in_panel-description' => '<h3>' . esc_html__( 'Theme Credits', 'boo-valley' ) . '</h3>'
								. '<p class="description">'
								. sprintf(
									esc_html_x( '%1$s is a WordPress theme developed by %2$s.', '1: linked theme name, 2: theme author name.', 'boo-valley' ),
									'<a href="' . esc_url( wp_get_theme( 'boo-valley' )->get( 'ThemeURI' ) ) . '" target="_blank"><strong>' . esc_html( wp_get_theme( 'boo-valley' )->get( 'Name' ) ) . '</strong></a>',
									'<strong>' . esc_html( wp_get_theme( 'boo-valley' )->get( 'Author' ) ) . '</strong>'
								)
								. '</p>'
								. '<p class="description">'
								. sprintf(
									esc_html_x( 'You can obtain other professional WordPress themes at %s.', '%s: theme author link.', 'boo-valley' ),
									'<strong><a href="' . esc_url( wp_get_theme( 'boo-valley' )->get( 'AuthorURI' ) ) . '" target="_blank">' . esc_html( str_replace( 'http://', '', untrailingslashit( wp_get_theme( 'boo-valley' )->get( 'AuthorURI' ) ) ) ) . '</a></strong>'
								)
								. '</p>'
								. '<p class="description">'
								. esc_html__( 'Thank you for using a theme by WebMan Design!', 'boo-valley' )
								. '</p>',
						),



						/**
						 * Colors: Accents and predefined colors
						 *
						 * Don't use `preview_js` here as these colors affect too many elements.
						 */
						100 . 'colors' . 10 => array(
							'id'             => 'colors-accents',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'boo-valley' ), esc_html_x( 'Accents', 'Customizer color section title', 'boo-valley' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
						),



							/**
							 * Accent colors
							 */

								100 . 'colors' . 10 . 100 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . esc_html__( 'These colors affect links, buttons and other elements.', 'boo-valley' ) . '</p>',
								),

								100 . 'colors' . 10 . 200 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Primary accent color', 'boo-valley' ) . '</h3>',
								),

									100 . 'colors' . 10 . 210 => array(
										'type'    => 'color',
										'id'      => 'color_accent',
										'label'   => esc_html__( 'Accent color', 'boo-valley' ),
										'default' => '#9d693f',
									),
									100 . 'colors' . 10 . 220 => array(
										'type'        => 'color',
										'id'          => 'color_accent_text',
										'label'       => esc_html__( 'Accent text color', 'boo-valley' ),
										'description' => esc_html__( 'Color of text on accent color background.', 'boo-valley' ),
										'default'     => '#ffffff',
									),



						/**
						 * Colors: Header
						 */
						100 . 'colors' . 20 => array(
							'id'             => 'colors-header',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'boo-valley' ), esc_html_x( 'Header', 'Customizer color section title', 'boo-valley' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
						),



							/**
							 * Header colors
							 */

								100 . 'colors' . 20 . 100 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Header', 'boo-valley' ) . '</h3>',
								),

									100 . 'colors' . 20 . 110 => array(
										'type'        => 'color',
										'id'          => 'color_header_background',
										'label'       => esc_html__( 'Background color', 'boo-valley' ),
										'description' => esc_html__( 'This color is also used to style a mobile device browser address bar.', 'boo-valley' ) . ' <a href="https://wordpress.org/plugins/chrome-theme-color-changer/" target="_blank">' . esc_html__( 'You can further customize it with a dedicated plugin.', 'boo-valley' ) . '</a>',
										'default'     => '#232323',
										'preview_js'  => array(
											'css' => array(

												'.site-header-content, .site-header-placeholder, ' . self::color_selectors( 'header' ) => array(
													'background-color'
												),
												'.main-navigation-container li ul' => array(
													'selector_before' => '@media only screen and (min-width: 55em) { ',
													'selector_after'  => ' }',
													'background-color',
												),
												'.main-navigation-container' => array(
													'selector_before' => '@media only screen and (max-width: 54.9375em) { ',
													'selector_after'  => ' }',
													'background-color',
												),

											),
										),
									),
									100 . 'colors' . 20 . 120 => array(
										'type'       => 'color',
										'id'         => 'color_header_text',
										'label'      => esc_html__( 'Text color', 'boo-valley' ),
										'default'    => '#e3e3e3',
										'preview_js' => array(
											'css' => array(

												'.site-header-content, .site-header-placeholder, ' . self::color_selectors( 'header' ) => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'booValley.Customize.hexToRgbJoin',
													),
												),
												'.main-navigation-container li ul' => array(
													'selector_before' => '@media only screen and (min-width: 55em) { ',
													'selector_after'  => ' }',
													'color',
												),
												'.main-navigation-container' => array(
													'selector_before' => '@media only screen and (max-width: 54.9375em) { ',
													'selector_after'  => ' }',
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'booValley.Customize.hexToRgbJoin',
													),
												),

											),
										),
									),



							/**
							 * Header widgets colors
							 */

								100 . 'colors' . 20 . 300 => array(
									'type'        => 'html',
									'content'     => '<h3>' . esc_html__( 'Header widgets', 'boo-valley' ) . '</h3>',
									'description' => esc_html__( 'Please note that this widgets area is displayed only if it contains some widgets.', 'boo-valley' ),
								),

									100 . 'colors' . 20 . 310 => array(
										'type'       => 'color',
										'id'         => 'color_header_widgets_background',
										'label'      => esc_html__( 'Background color', 'boo-valley' ),
										'default'    => '#373737',
										'preview_js' => array(
											'css' => array(

												'.header-widgets-container, ' . self::color_selectors( 'header-widgets' ) => array(
													'background-color'
												),

											),
										),
									),
									100 . 'colors' . 20 . 320 => array(
										'type'       => 'color',
										'id'         => 'color_header_widgets_text',
										'label'      => esc_html__( 'Text color', 'boo-valley' ),
										'default'    => '#a3a3a3',
										'preview_js' => array(
											'css' => array(

												'.header-widgets-container, ' . self::color_selectors( 'header-widgets' ) => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'booValley.Customize.hexToRgbJoin',
													),
												),

											),
										),
									),



						/**
						 * Colors: Intro
						 */
						100 . 'colors' . 25 => array(
							'id'             => 'colors-intro',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'boo-valley' ), esc_html_x( 'Intro', 'Customizer color section title', 'boo-valley' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
						),



							/**
							 * Intro title area colors
							 */

								100 . 'colors' . 25 . 100 => array(
									'type'        => 'html',
									'content'     => '<h3>' . esc_html__( 'Intro title', 'boo-valley' ) . '</h3>',
									'description' => esc_html__( 'This is a specially styled, main, dominant page title section.', 'boo-valley' ),
								),

									100 . 'colors' . 25 . 110 => array(
										'type'       => 'color',
										'id'         => 'color_intro_background',
										'label'      => esc_html__( 'Section background color', 'boo-valley' ),
										'default'    => '#9d693f',
										'preview_js' => array(
											'css' => array(

												'.intro-container' => array(
													'background-color'
												),

											),
										),
									),
									100 . 'colors' . 25 . 120 => array(
										'type'       => 'color',
										'id'         => 'color_intro_text',
										'label'      => esc_html__( 'Title text color', 'boo-valley' ),
										'default'    => '#ffffff',
										'preview_js' => array(
											'css' => array(

												'.intro' => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'booValley.Customize.hexToRgbJoin',
													),
												),

											),
										),
									),



							/**
							 * Intro background filter
							 */

								100 . 'colors' . 25 . 150 => array(
									'type'        => 'html',
									'content'     => '<h3>' . esc_html__( 'Intro background filter', 'boo-valley' ) . '</h3>',
								),

									100 . 'colors' . 25 . 160 => array(
										'type'       => 'color',
										'id'         => 'color_intro_filter',
										'label'      => esc_html__( 'Filter color', 'boo-valley' ),
										'default'    => '#9d693f',
										'preview_js' => array(
											'css' => array(

												'.has-intro-filter .intro-container:not(.no-intro-image)' => array(
													'background-color'
												),

											),
										),
									),
									100 . 'colors' . 25 . 170 => array(
										'type'        => 'checkbox',
										'id'          => 'intro_filter',
										'label'       => esc_html__( 'Apply filter on background image', 'boo-valley' ),
										'description' => esc_html__( 'Colorize the intro section background image.', 'boo-valley' )
										                 . '<br><br>'
										                 . esc_html__( 'Please note that this feature does not work in Internet Explorer, Edge and old versions of web browsers, where a non-filtered background is served.', 'boo-valley' )
										                 . '<br><br>'
										                 . '<a href="http://caniuse.com/#search=background-blend-mode" target="_blank">' . esc_html__( 'Check the browser compatibility &raquo;', 'boo-valley' ) . '</a>',
										'default'     => true,
										'preview_js'  => array(
											'custom' => "jQuery( 'body' ).toggleClass( 'has-intro-filter' );",
										),
									),



							/**
							 * Intro overlay colors
							 */

								100 . 'colors' . 25 . 200 => array(
									'type'        => 'html',
									'content'     => '<h3>' . esc_html__( 'Intro overlay', 'boo-valley' ) . '</h3>',
									'description' => esc_html__( 'This overlay is displayed only if header image is used or there is a featured image set for the page/post.', 'boo-valley' ),
								),

									100 . 'colors' . 25 . 210 => array(
										'type'       => 'color',
										'id'         => 'color_intro_overlay',
										'label'      => esc_html__( 'Overlay gradient color', 'boo-valley' ),
										'default'    => '#1c1c1c',
										'preview_js' => array(
											'css' => array(

												'.intro::before' => array(
													array(
														'property' => 'background',
														'prefix'   => 'linear-gradient(transparent,',
														'suffix'   => ')',
													),
												),
												'.intro:not(.no-text-shadow)' => array(
													array(
														'property' => 'text-shadow',
														'prefix'   => '0 2px .62rem ',
													),
												),

											),
										),
									),
									100 . 'colors' . 25 . 220 => array(
										'type'       => 'range',
										'id'         => 'opacity_intro_overlay',
										'label'      => esc_html__( 'Overlay gradient opacity (in %)', 'boo-valley' ),
										'default'    => .9,
										'min'        => 0,
										'max'        => 1,
										'step'       => .05,
										'multiplier' => 100,
										'suffix'     => '%',
										'validate'   => __CLASS__ . '::sanitize_floatval',
										'preview_js' => array(
											'css' => array(

												'.intro::before' => array(
													'opacity'
												),

											),
										),
									),
									100 . 'colors' . 25 . 230 => array(
										'type'       => 'checkbox',
										'id'         => 'text_shadow_intro',
										'label'      => esc_html__( 'Text shadow', 'boo-valley' ),
										'default'    => true,
										'preview_js' => array(
											'custom' => "jQuery( '.intro' ).toggleClass( 'no-text-shadow' );",
										),
									),



							/**
							 * Intro widgets colors
							 */

								100 . 'colors' . 25 . 500 => array(
									'type'        => 'html',
									'content'     => '<h3>' . esc_html__( 'Intro widgets', 'boo-valley' ) . '</h3>',
									'description' => esc_html__( 'Please note that this widgets area is displayed only if it contains some widgets.', 'boo-valley' ),
								),

									100 . 'colors' . 25 . 510 => array(
										'type'       => 'color',
										'id'         => 'color_intro_widgets_background',
										'label'      => esc_html__( 'Background color', 'boo-valley' ),
										'default'    => '#232323',
										'preview_js' => array(
											'css' => array(

												'.intro-widgets-container::before' => array(
													'background-color'
												),

											),
										),
									),
									100 . 'colors' . 25 . 520 => array(
										'type'       => 'color',
										'id'         => 'color_intro_widgets_text',
										'label'      => esc_html__( 'Text color', 'boo-valley' ),
										'default'    => '#a3a3a3',
										'preview_js' => array(
											'css' => array(

												'.intro-widgets-container' => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'booValley.Customize.hexToRgbJoin',
													),
												),

											),
										),
									),
									100 . 'colors' . 25 . 530 => array(
										'type'       => 'color',
										'id'         => 'color_intro_widgets_headings',
										'label'      => esc_html__( 'Headings color', 'boo-valley' ),
										'default'    => '#e3e3e3',
										'preview_js' => array(
											'css' => array(

												$h_tags . ', @a' => array(
													'selector_replace' => '.intro-widgets-container ',
													'color'
												),

											),
										),
									),



						/**
						 * Colors: Content
						 */
						100 . 'colors' . 30 => array(
							'id'             => 'colors-content',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'boo-valley' ), esc_html_x( 'Content', 'Customizer color section title', 'boo-valley' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
						),



							/**
							 * Content colors
							 */

								100 . 'colors' . 30 . 100 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Content', 'boo-valley' ) . '</h3>',
								),

									100 . 'colors' . 30 . 110 => array(
										'type'       => 'color',
										'id'         => 'color_content_background',
										'label'      => esc_html__( 'Background color', 'boo-valley' ),
										'default'    => '#fcfcfc',
										'preview_js' => array(
											'css' => array(

												'.site, .site-content, ' . self::color_selectors( 'content' ) => array(
													'background-color'
												),
												'.child-page' => array(
													'background-color'
												),

											),
										),
									),
									100 . 'colors' . 30 . 120 => array(
										'type'       => 'color',
										'id'         => 'color_content_text',
										'label'      => esc_html__( 'Text color', 'boo-valley' ),
										'default'    => '#737373',
										'preview_js' => array(
											'css' => array(

												'.site, .site-content, ' . self::color_selectors( 'content' ) => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'booValley.Customize.hexToRgbJoin',
													),
												),

											),
										),
									),
									100 . 'colors' . 30 . 130 => array(
										'type'       => 'color',
										'id'         => 'color_content_headings',
										'label'      => esc_html__( 'Headings color', 'boo-valley' ),
										'default'    => '#131313',
										'preview_js' => array(
											'css' => array(

												$h_tags . ', .post-navigation, .dropcap-text::first-letter, .single .entry-meta-element' => array(
													'selector_replace' => '',
													'color'
												),

											),
										),
									),



						/**
						 * Colors: Footer
						 */
						100 . 'colors' . 40 => array(
							'id'             => 'colors-footer',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'boo-valley' ), esc_html_x( 'Footer', 'Customizer color section title', 'boo-valley' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
						),



							/**
							 * Footer colors
							 */

								100 . 'colors' . 40 . 100 => array(
									'type'        => 'html',
									'content'     => '<h3>' . esc_html__( 'Footer', 'boo-valley' ) . '</h3>',
									'description' => esc_html__( 'The main footer widgets area is displayed only if it contains some widgets.', 'boo-valley' ),
								),

									100 . 'colors' . 40 . 110 => array(
										'type'       => 'color',
										'id'         => 'color_footer_background',
										'label'      => esc_html__( 'Background color', 'boo-valley' ),
										'default'    => '#232323',
										'preview_js' => array(
											'css' => array(

												'.site-footer, ' . self::color_selectors( 'footer' ) => array(
													'background-color'
												),
												'@mark, @.highlight, @.widget_calendar tbody a, @.widget .tagcloud a:hover, @.widget .tagcloud a:focus, @.widget .tagcloud a:active, @.button, @button, @input[type="button"], @input[type="reset"], @input[type="submit"]' => array(
													'selector_replace' => '.site-footer ',
													'background-color'
												),

											),
										),
									),
									100 . 'colors' . 40 . 120 => array(
										'type'       => 'color',
										'id'         => 'color_footer_text',
										'label'      => esc_html__( 'Text color', 'boo-valley' ),
										'default'    => '#a3a3a3',
										'preview_js' => array(
											'css' => array(

												'.site-footer, ' . self::color_selectors( 'footer' ) => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'booValley.Customize.hexToRgbJoin',
													),
												),

											),
										),
									),
									100 . 'colors' . 40 . 130 => array(
										'type'       => 'color',
										'id'         => 'color_footer_headings',
										'label'      => esc_html__( 'Headings color', 'boo-valley' ),
										'default'    => '#e3e3e3',
										'preview_js' => array(
											'css' => array(

												$h_tags . ', @a, @mark, @.highlight, @.widget_calendar tbody a, @.widget .tagcloud a:hover, @.widget .tagcloud a:focus, @.widget .tagcloud a:active, @.button, @button, @input[type="button"], @input[type="reset"], @input[type="submit"]'=> array(
													'selector_replace' => '.site-footer ',
													'color'
												),

											),
										),
									),



							/**
							 * Footer secondary widgets colors
							 */

								100 . 'colors' . 40 . 200 => array(
									'type'        => 'html',
									'content'     => '<h3>' . esc_html__( 'Secondary widgets', 'boo-valley' ) . '</h3>',
									'description' => esc_html__( 'Please note that this widgets area is displayed only if it contains some widgets.', 'boo-valley' ),
								),

									100 . 'colors' . 40 . 210 => array(
										'type'       => 'color',
										'id'         => 'color_footer_secondary_background',
										'label'      => esc_html__( 'Background color', 'boo-valley' ),
										'default'    => '#9d693f',
										'preview_js' => array(
											'css' => array(

												'.footer-area-footer-secondary-widgets, ' . self::color_selectors( 'footer-secondary-widgets' ) => array(
													'background-color'
												),

											),
										),
									),
									100 . 'colors' . 40 . 220 => array(
										'type'       => 'color',
										'id'         => 'color_footer_secondary_text',
										'label'      => esc_html__( 'Text color', 'boo-valley' ),
										'default'    => '#ffffff',
										'preview_js' => array(
											'css' => array(

												'.footer-area-footer-secondary-widgets, ' . self::color_selectors( 'footer-secondary-widgets' ) => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'booValley.Customize.hexToRgbJoin',
													),
												),

											),
										),
									),
									100 . 'colors' . 40 . 230 => array(
										'type'       => 'color',
										'id'         => 'color_footer_secondary_headings',
										'label'      => esc_html__( 'Headings color', 'boo-valley' ),
										'default'    => '#ffffff',
										'preview_js' => array(
											'css' => array(

												$h_tags . ', @a' => array(
													'selector_replace' => '.footer-area-footer-secondary-widgets ',
													'color'
												),

											),
										),
									),



							/**
							 * Site info colors
							 */

								100 . 'colors' . 40 . 300 => array(
									'type'        => 'html',
									'content'     => '<h3>' . esc_html__( 'Credits area', 'boo-valley' ) . '</h3>',
									'description' => esc_html__( 'To manage footer copyright text please see "Texts" section here in theme customizer.', 'boo-valley' ),
								),

									100 . 'colors' . 40 . 310 => array(
										'type'       => 'color',
										'id'         => 'color_site_info_background',
										'label'      => esc_html__( 'Background color', 'boo-valley' ),
										'default'    => '#fcfcfc',
										'preview_js' => array(
											'css' => array(

												'.footer-area-site-info, ' . self::color_selectors( 'credits' ) => array(
													'background-color'
												),

											),
										),
									),
									100 . 'colors' . 40 . 320 => array(
										'type'       => 'color',
										'id'         => 'color_site_info_text',
										'label'      => esc_html__( 'Text color', 'boo-valley' ),
										'default'    => '#737373',
										'preview_js' => array(
											'css' => array(

												'.footer-area-site-info, ' . self::color_selectors( 'credits' ) => array(
													'color'
												),

											),
										),
									),



						/**
						 * Blog
						 */
						200 . 'blog' => array(
							'id'             => 'blog',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Blog', 'Customizer section title.', 'boo-valley' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
						),

							200 . 'blog' . 100 => array(
								'type'        => 'radio',
								'id'          => 'blog_style',
								'label'       => esc_html__( 'Blog style', 'boo-valley' ),
								'description' => esc_html__( 'This layout style will be applied on blog, category and tag archive pages.', 'boo-valley' ),
								'default'     => 'list',
								'choices'     => array(
									'list'    => esc_html__( 'List', 'boo-valley' ),
									'masonry' => esc_html__( 'Masonry', 'boo-valley' ),
								),
							),

							200 . 'blog' . 110 => array(
								'type'            => 'select',
								'id'              => 'blog_style_masonry_image_size',
								'label'           => esc_html__( 'Masonry image size', 'boo-valley' ),
								'description'     => esc_html__( 'Select a size for post thumbnail image in masonry style blog.', 'boo-valley' ),
								'default'         => 'boo_valley-thumbnail',
								'choices'         => (array) $image_sizes,
								'active_callback' => __CLASS__ . '::is_blog_style_masonry',
							),



						/**
						 * Layout
						 */
						300 . 'layout' => array(
							'id'             => 'layout',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Layout', 'Customizer section title.', 'boo-valley' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
						),



							/**
							 * Site layout
							 */

								300 . 'layout' . 100 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html_x( 'Site Container', 'A website container.', 'boo-valley' ) . '</h3>',
								),

									300 . 'layout' . 110 => array(
										'type'    => 'radio',
										'id'      => 'layout_site',
										'label'   => esc_html__( 'Website layout', 'boo-valley' ),
										'default' => 'fullwidth',
										'choices' => array(
											'fullwidth' => esc_html__( 'Fullwidth', 'boo-valley' ),
											'boxed'     => esc_html__( 'Boxed', 'boo-valley' ),
										),
										// No need for `preview_js` here as it won't trigger the `active_callback` below.
									),

									300 . 'layout' . 120 => array(
										'type'        => 'range',
										'id'          => 'layout_width_site',
										'label'       => esc_html__( 'Website max width', 'boo-valley' ),
										'description' => esc_html__( 'For boxed website layout.', 'boo-valley' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'boo-valley' ), number_format_i18n( 1640 ) ),
										'default'     => 1640,
										'min'         => 1000,
										'max'         => 1840, // cca 1920 x 96%
										'step'        => 20,
										'suffix'      => 'px',
										'preview_js'  => array(
											'css' => array(

												'.site-layout-boxed .site' => array(
													array(
														'property' => 'max-width',
														'suffix'   => 'px',
													),
												),

											),
										),
										'active_callback' => __CLASS__ . '::is_layout_site_boxed',
									),
									300 . 'layout' . 130 => array(
										'type'        => 'range',
										'id'          => 'layout_width_content',
										'label'       => esc_html__( 'Content width', 'boo-valley' ),
										'description' => sprintf( esc_html__( 'Default value: %s', 'boo-valley' ), number_format_i18n( 1180 ) ),
										'default'     => 1180,
										'min'         => 880,
										'max'         => 1620, // cca ( 1920 x 96% ) x 88%
										'step'        => 20,
										'suffix'      => 'px',
										'preview_js'  => array(
											'css' => array(

												implode( ', ', array(
													// All the selectors with `@extend %content_width;` from SASS files // $content_width
													'.site-header-inner',
													'.intro-inner',
													'.site-content-inner',
													'.nav-links',
													'.page-template-child-pages:not(.fl-builder) .site-main .entry-content',
													'.list-child-pages-container',
													'.fl-builder .comments-area',
													'.content-layout-no-paddings .comments-area',
													'.content-layout-stretched .comments-area',
													'.site-footer-area-inner',
													'.header-widgets',
													'.site .fl-row-fixed-width',
													'.breadcrumbs',
												) ) => array(
													array(
														'property' => 'max-width',
														'suffix'   => 'px',
													),
												),

											),
										),
									),
									300 . 'layout' . 140 => array(
										'type'        => 'select',
										'id'          => 'layout_site_borders',
										'label'       => esc_html__( 'Website border', 'boo-valley' ),
										'description' => esc_html__( 'Border color is set to website background and can be tweaked in "Background" section of the customizer.', 'boo-valley' ),
										'default'     => 'has-site-borders-around',
										'choices'     => array(
											''                           => esc_html__( 'No border', 'boo-valley' ),
											'has-site-borders-around'    => esc_html__( 'Border around whole website', 'boo-valley' ),
											'has-site-borders-static'    => esc_html__( 'Browser viewport border', 'boo-valley' ),
											'has-site-borders-on-scroll' => esc_html__( 'Browser viewport border on scrolling only', 'boo-valley' ),
										),
										'preview_js'  => array(
											'custom' => "jQuery( '.site-layout-fullwidth' ).removeClass( 'has-site-borders has-site-borders-static has-site-borders-around has-site-borders-on-scroll' ); if ( to ) { jQuery( '.site-layout-fullwidth' ).addClass( 'has-site-borders ' + to ); }",
										),
										'active_callback'  => __CLASS__ . '::is_layout_site_fullwidth',
										'is_css_condition' => true,
									),
									300 . 'layout' . 150 => array(
										'type'            => 'range',
										'id'              => 'layout_site_borders_width',
										'label'           => esc_html__( 'Website border width (in %)', 'boo-valley' ),
										'description'     => esc_html__( 'This setting is only relevant if website border is set.', 'boo-valley' ),
										'default'         => 1.4,
										'min'             => .4,
										'max'             => 4,
										'step'            => .1,
										'suffix'          => '%',
										'decimal_places'  => 1,
										'validate'        => __CLASS__ . '::sanitize_floatval',
										'active_callback' => __CLASS__ . '::is_layout_site_fullwidth',
									),



							/**
							 * Header layout
							 */

								300 . 'layout' . 200 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Header', 'boo-valley' ) . '</h3>',
								),

									300 . 'layout' . 210 => array(
										'type'    => 'radio',
										'id'      => 'layout_header',
										'label'   => esc_html__( 'Header layout', 'boo-valley' ),
										'default' => 'fullwidth',
										'choices' => array(
											'fullwidth' => esc_html__( 'Fullwidth', 'boo-valley' ),
											'boxed'     => esc_html__( 'Boxed', 'boo-valley' ),
										),
										'preview_js'  => array(
											'custom' => "jQuery( 'body' ).toggleClass( 'header-layout-boxed' ).toggleClass( 'header-layout-fullwidth' );",
										),
									),

									300 . 'layout' . 220 => array(
										'type'        => 'checkbox',
										'id'          => 'layout_header_sticky',
										'label'       => esc_html__( 'Sticky header', 'boo-valley' ),
										'description' => esc_html__( 'Allow header to appear when user attempt to scroll up.', 'boo-valley' ),
										'default'     => true,
										// No need for `preview_js` here as we also need to load the scripts.
									),



							/**
							 * Navigation layout
							 */

								300 . 'layout' . 300 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Navigation', 'boo-valley' ) . '</h3>',
								),

									300 . 'layout' . 310 => array(
										'type'       => 'checkbox',
										'id'         => 'layout_submenu_fullwidth',
										'label'      => esc_html__( 'Fullwidth submenus', 'boo-valley' ),
										'default'    => true,
										'preview_js' => array(
											'custom' => "jQuery( 'body' ).toggleClass( 'has-fullwidth-submenu' );",
										),
									),



							/**
							 * Intro layout
							 */

								300 . 'layout' . 400 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Intro', 'boo-valley' ) . '</h3>',
								),

									300 . 'layout' . 410 => array(
										'type'        => 'radio',
										'id'          => 'layout_intro_widgets_display',
										'label'       => esc_html__( 'Enable intro widgets', 'boo-valley' ),
										'description' => sprintf( esc_html_x( 'If you enable this widget area also for archives, we recommend using %s plugin to control its appearance further more.', '%s: Linked plugin name.', 'boo-valley' ), '<a href="https://wordpress.org/plugins/woosidebars/" target="_blank">WooSidebars</a>' ),
										'default'     => '',
										'choices'     => array(
											''       => esc_html__( 'On singular pages only', 'boo-valley' ),
											'always' => esc_html__( 'On both archive and singular pages', 'boo-valley' ),
										),
									),



							/**
							 * Footer layout
							 */

								300 . 'layout' . 500 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Footer', 'boo-valley' ) . '</h3>',
								),

									300 . 'layout' . 510 => array(
										'type'    => 'radio',
										'id'      => 'layout_footer',
										'label'   => esc_html__( 'Footer layout', 'boo-valley' ),
										'default' => 'boxed',
										'choices' => array(
											'fullwidth' => esc_html__( 'Fullwidth', 'boo-valley' ),
											'boxed'     => esc_html__( 'Boxed', 'boo-valley' ),
										),
										'preview_js'  => array(
											'custom' => "jQuery( 'body' ).toggleClass( 'footer-layout-boxed' ).toggleClass( 'footer-layout-fullwidth' );",
										),
									),



						/**
						 * Texts
						 *
						 * Don't use `preview_js` here as it outputs escaped HTML.
						 */
						800 . 'texts' => array(
							'id'             => 'texts',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Texts', 'Customizer section title.', 'boo-valley' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
						),

							800 . 'texts' . 500 => array(
								'type'        => 'textarea',
								'id'          => 'texts_site_info',
								'label'       => esc_html__( 'Footer credits (copyright)', 'boo-valley' ),
								'description' => sprintf( esc_html__( 'Set %s to disable this area.', 'boo-valley' ), '<code>-</code>' ) . ' ' . esc_html__( 'Leaving the field empty will fall back to default theme setting.', 'boo-valley' ),
								'default'     => '',
								'validate'    => 'wp_kses_post',
								'preview_js'  => array(
									'custom' => "jQuery( '.site-info' ).html( to ); if ( '-' === to ) { jQuery( '.footer-area-site-info' ).hide(); } else { jQuery( '.footer-area-site-info:hidden' ).show(); }",
								),
							),



						/**
						 * Typography
						 */
						900 . 'typography' => array(
							'id'             => 'typography',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Typography', 'Customizer section title.', 'boo-valley' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
						),

							900 . 'typography' . 100 => array(
								'type'        => 'range',
								'id'          => 'typography_size_html',
								'label'       => esc_html__( 'Basic font size in px', 'boo-valley' ),
								'description' => esc_html__( 'All other font sizes are calculated automatically from this basic font size.', 'boo-valley' ),
								'default'     => 16,
								'min'         => 12,
								'max'         => 24,
								'step'        => 1,
								'suffix'      => 'px',
								'validate'    => 'absint',
								'preview_js'  => array(
									'css' => array(

										'html' => array(
											array(
												'property' => 'font-size',
												'suffix'   => 'px',
											),
										),

									),
								),
							),

							900 . 'typography' . 200 => array(
								'type'             => 'checkbox',
								'id'               => 'typography_custom_fonts',
								'label'            => esc_html__( 'Use custom fonts', 'boo-valley' ),
								'default'          => false,
								'is_css_condition' => true,
							),

								900 . 'typography' . 210 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Custom fonts setup', 'boo-valley' ) . '</h3><p class="description">' . sprintf(
											esc_html_x( 'This theme does not restrict you to choose from a predefined set of fonts. Instead, please use any font service (such as %s) plugin you like.', '%s: linked examples of web fonts libraries such as Google Fonts or Adobe Typekit.', 'boo-valley' ),
											'<a href="http://www.google.com/fonts" target="_blank"><strong>Google Fonts</strong></a>, <a href="https://typekit.com/fonts" target="_blank"><strong>Adobe Typekit</strong></a>'
										) . '</p><p class="description">' . esc_html__( 'You can set your fonts plugin according to information provided below, or insert your custom font names (a value of "font-family" CSS property) directly into input fields (you still need to use a plugin to load those fonts on the website).', 'boo-valley' ) . '</p>',
									'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
								),

								900 . 'typography' . 220 => array(
									'type'            => 'text',
									'id'              => 'typography_fonts_text',
									'label'           => esc_html__( 'General text font', 'boo-valley' ),
									'default'         => "'Segoe UI', Frutiger, 'Frutiger Linotype', 'Dejavu Sans', 'Helvetica Neue', Arial, sans-serif",
									'input_attrs'     => array(
										'placeholder' => "'Segoe UI', sans-serif",
									),
									'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
									'validate'        => __CLASS__ . '::sanitize_fonts',
								),

								900 . 'typography' . 230 => array(
									'type'            => 'text',
									'id'              => 'typography_fonts_headings',
									'label'           => esc_html__( 'Headings font', 'boo-valley' ),
									'default'         => "'Segoe UI', Frutiger, 'Frutiger Linotype', 'Dejavu Sans', 'Helvetica Neue', Arial, sans-serif",
									'input_attrs'     => array(
										'placeholder' => "'Segoe UI', sans-serif",
									),
									'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
									'validate'        => __CLASS__ . '::sanitize_fonts',
								),

								900 . 'typography' . 240 => array(
									'type'            => 'text',
									'id'              => 'typography_fonts_logo',
									'label'           => esc_html__( 'Logo font', 'boo-valley' ),
									'default'         => "'Playfair Display', Palatino, 'Palatino Linotype', 'Palatino LT STD', 'Book Antiqua', Georgia, serif",
									'input_attrs'     => array(
										'placeholder' => "'Playfair Display', serif",
									),
									'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
									'validate'        => __CLASS__ . '::sanitize_fonts',
								),

								900 . 'typography' . 290 => array(
									'type'            => 'html',
									'content'         => '<h3>' . esc_html__( 'Info: CSS selectors', 'boo-valley' ) . '</h3>'
										. '<p class="description">' . esc_html__( 'Here you can find CSS selectors list associated with each font group in the theme. You can use these in your custom font plugin settings.', 'boo-valley' ) . '</p>'

										. '<p>'
										. '<strong>' . esc_html__( 'General text font CSS selectors:', 'boo-valley' ) . '</strong>'
										. '</p>'
										. '<pre>'
										. implode( ', ', array(
												'html',
												'.site .font-body',
											) )
										. '</pre>'

										. '<p>'
										. '<strong>' . esc_html__( 'Headings font CSS selectors:', 'boo-valley' ) . '</strong>'
										. '</p>'
										. '<pre>'
										. implode( ', ', array(
												'.site .font-headings',
												'.site .font-headings-primary',

												'h1, .h1',
												'h2, .h2',
												'h3, .h3',
												'h4, .h4',
												'h5, .h5',
												'h6, .h6',

												'.entry-subtitle',
											) )
										. '</pre>'

										. '<p>'
										. '<strong>' . esc_html__( 'Logo font CSS selectors:', 'boo-valley' ) . '</strong>'
										. '</p>'
										. '<pre>'
										. implode( ', ', array(
												'.site-title',
												'.site .font-logo',
												'.site .font-headings-secondary',

												'h1, .h1',

												'h1.display-1',
												'h1.display-2',
												'h1.display-3',
												'h1.display-4',

												'h2.display-1',
												'h2.display-2',
												'h2.display-3',
												'h2.display-4',

												'h3.display-1',
												'h3.display-2',
												'h3.display-3',
												'h3.display-4',

												'.h1.display-1',
												'.h1.display-2',
												'.h1.display-3',
												'.h1.display-4',

												'.h2.display-1',
												'.h2.display-2',
												'.h2.display-3',
												'.h2.display-4',

												'.h3.display-1',
												'.h3.display-2',
												'.h3.display-3',
												'.h3.display-4',

												'.entry-title',
												'.page-title',
												'.child-page-title',
												'.wm-content-module .title h2',
												'.wm-content-module .title h3',
												'.product-title-price .price',
												'.add_to_cart_inline .amount',
											) )
										. '</pre>',

									'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
								),



						/**
						 * Others
						 */
						950 . 'others' => array(
							'id'             => 'others',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Others', 'Customizer section title.', 'boo-valley' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'boo-valley' ),
						),

							950 . 'others' . 100 => array(
								'type'        => 'checkbox',
								'id'          => 'admin_welcome_page',
								'label'       => esc_html__( 'Show "Welcome" page', 'boo-valley' ),
								'description' => esc_html__( 'Under "Appearance" WordPress dashboard menu.', 'boo-valley' ),
								'default'     => true,
								'preview_js'  => false, // This is to prevent customizer preview reload
							),

							950 . 'others' . 110 => array(
								'type'        => 'checkbox',
								'id'          => 'navigation_mobile_disable',
								'label'       => esc_html__( 'Disable mobile navigation', 'boo-valley' ),
								'description' => esc_html__( 'Maybe your website navigation is very simple and you do not want to use the mobile navigation functionality?', 'boo-valley' ),
								'default'     => false,
							),

							950 . 'others' . 120 => array(
								'type'    => 'multicheckbox',
								'id'      => 'archive_title_prefix',
								'label'   => esc_html__( 'Archive page title prefix', 'boo-valley' ),
								'choices' => array(
									'category'  => esc_html__( 'Remove "Category:" prefix', 'boo-valley' ),
									'tag'       => esc_html__( 'Remove "Tag:" prefix', 'boo-valley' ),
									'author'    => esc_html__( 'Remove "Author:" prefix', 'boo-valley' ),
									'post_type' => esc_html__( 'Remove "Archives:" prefix', 'boo-valley' ),
									'taxonomy'  => esc_html__( 'Remove "Taxonomy:" prefix', 'boo-valley' ),
								),
							),



					);


			// Output

				return $options;

		} // /options





	/**
	 * 20) Replacements
	 */

		/**
		 * CSS generator replacements
		 *
		 * You can also use a `SLASH**if(option_id)` and `endif(option_id)**SLASH`
		 * conditional CSS replacements. These CSS comments will get uncommented
		 * once there is a value set to `option_id`.
		 * (Don't forget to replace `SLASH` with `/` above when used in CSS.)
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 *
		 * @param  array $replacements
		 */
		public static function css_replacements( $replacements = array() ) {

			// Processing

				$replacements = array(
						'/*[*/'                            => '/** ', // Open a comment
						'/*]*/'                            => ' **/', // Close a comment
						'/*//'                             => '', // Remove a comment opening
						'//*/'                             => '', // Remove a comment closing
						'[[get_template_directory]]'       => untrailingslashit( get_template_directory() ),
						'[[get_stylesheet_directory]]'     => untrailingslashit( get_stylesheet_directory() ),
						'[[get_template_directory_uri]]'   => untrailingslashit( get_template_directory_uri() ),
						'[[get_stylesheet_directory_uri]]' => untrailingslashit( get_stylesheet_directory_uri() ),
					);


			// Output

				return $replacements;

		} // /css_replacements





	/**
	 * 30) Active callbacks
	 */

		/**
		 * Is site layout: Boxed?
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $control
		 */
		public static function is_layout_site_boxed( $control ) {

			// Helper variables

				$option = $control->manager->get_setting( 'layout_site' );


			// Output

				return ( 'boxed' == $option->value() );

		} // /is_layout_site_boxed



		/**
		 * Is site layout: Fullwidth?
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $control
		 */
		public static function is_layout_site_fullwidth( $control ) {

			// Helper variables

				$option = $control->manager->get_setting( 'layout_site' );


			// Output

				return ( 'fullwidth' == $option->value() );

		} // /is_layout_site_fullwidth



		/**
		 * Do you want to use custom fonts?
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $control
		 */
		public static function is_typography_custom_fonts( $control ) {

			// Helper variables

				$option = $control->manager->get_setting( 'typography_custom_fonts' );


			// Output

				return (bool) $option->value();

		} // /is_typography_custom_fonts



		/**
		 * Is masonry blog style?
		 *
		 * @since    1.4.0
		 * @version  1.4.0
		 *
		 * @param  array $control
		 */
		public static function is_blog_style_masonry( $control ) {

			// Helper variables

				$option = $control->manager->get_setting( 'blog_style' );


			// Output

				return ( 'masonry' == $option->value() );

		} // /is_blog_style_masonry





	/**
	 * 40) Partial refresh
	 */

		/**
		 * Render the site title for the selective refresh partial
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function partial_blogname() {

			// Output

				bloginfo( 'name' );

		} // /partial_blogname



		/**
		 * Render the site tagline for the selective refresh partial
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function partial_blogdescription() {

			// Output

				bloginfo( 'description' );

		} // /partial_blogdescription



		/**
		 * Render the site info in the footer for the selective refresh partial
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function partial_texts_site_info() {

			// Processing

				ob_start();
				get_template_part( 'templates/parts/component-site', 'info' );
				$output = ob_get_clean();


			// Output

				echo str_replace(
						array( '<div class="site-footer-area footer-area-site-info">', '</div><!-- /footer-area-site-info -->' ),
						'',
						$output
					);

		} // /partial_texts_site_info





	/**
	 * 100) Helpers
	 */

		/**
		 * Alpha values (%) for generating rgba() colors
		 *
		 * Values taken from `assets/scss/_setup.scss` file's `$border_opacity_from_text` variable.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $alphas
		 */
		public static function rgba_alphas( $alphas = array() ) {

			// Output

				return array( 40 );

		} // /rgba_alphas



		/**
		 * Sanitize float
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  float $value
		 */
		public static function sanitize_floatval( $value ) {

			// Output

				return floatval( $value );

		} // /sanitize_floatval



		/**
		 * Sanitize fonts
		 *
		 * Allow only alphanumeric characters, spaces, commas, underscores,
		 * dashes, single and/or double quotes.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $value
		 */
		public static function sanitize_fonts( $value ) {

			// Output

				return trim( preg_replace( '/[^a-zA-Z0-9 ,_\-\'\"]+/', '', (string) $value ) );

		} // /sanitize_fonts



		/**
		 * Get special color class selectors
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $context
		 */
		public static function color_selectors( $context = '' ) {

			// Pre

				$pre = apply_filters( 'wmhook_boo_valley_customize_color_selectors_pre', false );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output  = array();
				$context = sanitize_html_class( trim( (string) $context ) );


			// Requirements check

				if ( empty( $context ) ) {
					return;
				}


			// Processing

				$output[] = '.set-colors-' . $context;
				$output[] = '.set-colors-' . $context . ' > .fl-row-content-wrap';
				$output[] = '.set-colors-' . $context . ' > .fl-col-content';


			// Output

				return implode( ', ', $output );

		} // /color_selectors





} // /Boo_Valley_Customize

add_action( 'after_setup_theme', 'Boo_Valley_Customize::init', 1 ); // Hook before installation so the CSS is generated with all replacements
