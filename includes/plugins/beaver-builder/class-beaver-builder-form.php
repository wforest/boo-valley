<?php
/**
 * Beaver Builder: Form Class
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
 * 10) Custom options
 * 20) Classes
 */
class Boo_Valley_Beaver_Builder_Form {





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

						add_filter( 'fl_builder_register_settings_form', __CLASS__ . '::register_settings_form', 10, 2 );

						add_filter( 'fl_builder_render_settings_field', __CLASS__ . '::predefined_classes_dropdown', 10, 2 );

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
	 * 10) Custom options
	 */

		/**
		 * Settings form alterations
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 *
		 * @param  array $form
		 * @param  string $id
		 */
		public static function register_settings_form( $form, $id ) {

			// Processing

				// Row and/or column settings only

					if ( in_array( $id, array( 'col', 'row' ) ) ) {

						// Adding column content vertical centering option

							$form['tabs']['style']['sections']['general']['fields']['vertical_alignment'] = array(
									'type'    => 'select',
									'label'   => esc_html__( 'Content Vertical Alignment', 'boo-valley' ),
									'help'    => esc_html__( 'As the theme makes all columns in a row equally high automatically, it allows you to set the column content vertical alignment here.', 'boo-valley' ),
									'default' => '',
									'options' => array(
										''                      => esc_html_x( 'Initial', 'Vertical content alignment value', 'boo-valley' ),
										'vertical-align-top'    => esc_html_x( 'Top', 'Vertical content alignment value', 'boo-valley' ),
										'vertical-align-middle' => esc_html_x( 'Middle', 'Vertical content alignment value', 'boo-valley' ),
										'vertical-align-bottom' => esc_html_x( 'Bottom', 'Vertical content alignment value', 'boo-valley' ),
									),
									'preview' => array(
										'type' => 'none',
									),
								);

						// Adding "Predefined colors" section just after the "General" section

							// Backing up all the sections to keep the order of the fields

								$sections = $form['tabs']['style']['sections'];

							// Backing up and removing the first section ("General"), so we can merge it later in the correct order

								$section_general = array( 'general' => $form['tabs']['style']['sections']['general'] );

								unset( $sections['general'] );

							// "Predefined colors" section setup

								$section_colors_predefined = array(

										'colors_predefined' => array(
											'title'  => esc_html__( 'Predefined Colors', 'boo-valley' ),
											'fields' => array(

												'predefined_color' => array(
													'type'        => 'select',
													'label'       => esc_html__( 'Assign predefined colors', 'boo-valley' ),
													'help'        => esc_html__( 'You can override these further below by setting up a custom background or text color', 'boo-valley' ),
													'description' => '<br><br>' . esc_html__( 'Set this to match the colors of theme predefined sections', 'boo-valley' ),
													'default' => '',
													'options' => array(
														'' => esc_html__( '- No predefined color -', 'boo-valley' ),

														// Color classes

															'optgroup-sections' => array(
																'label'   => esc_html__( 'Theme sections colors:', 'boo-valley' ),
																'options' => array(

																	'set-colors-header'                   => esc_html__( 'Set header colors', 'boo-valley' ),
																	'set-colors-header-widgets'           => esc_html__( 'Set header widgets colors', 'boo-valley' ),
																	'set-colors-content'                  => esc_html__( 'Set content colors', 'boo-valley' ),
																	'set-colors-footer'                   => esc_html__( 'Set footer colors', 'boo-valley' ),
																	'set-colors-footer-secondary-widgets' => esc_html__( 'Set footer secondary widgets colors', 'boo-valley' ),
																	'set-colors-credits'                  => esc_html__( 'Set footer credits colors', 'boo-valley' ),

																),
															),

														// Accent colors

															'optgroup-accents' => array(
																'label'   => esc_html__( 'Accent colors:', 'boo-valley' ),
																'options' => array(

																	'set-colors-accent'  => esc_html__( 'Set primary accent colors', 'boo-valley' ),
																	'hover-color-accent' => esc_html__( 'Set primary accent colors on mouse hover', 'boo-valley' ),

																	'set-colors-error'  => esc_html__( 'Set error colors', 'boo-valley' ),
																	'hover-color-error' => esc_html__( 'Set error colors on mouse hover', 'boo-valley' ),

																	'set-colors-info'  => esc_html__( 'Set info colors', 'boo-valley' ),
																	'hover-color-info' => esc_html__( 'Set info colors on mouse hover', 'boo-valley' ),

																	'set-colors-success'  => esc_html__( 'Set success colors', 'boo-valley' ),
																	'hover-color-success' => esc_html__( 'Set success colors on mouse hover', 'boo-valley' ),

																	'set-colors-warning'  => esc_html__( 'Set warning colors', 'boo-valley' ),
																	'hover-color-warning' => esc_html__( 'Set warning colors on mouse hover', 'boo-valley' ),

																),
															),

													),
													'preview' => array(
														'type' => 'none',
													),
												),

											),
										),

									);

							// Putting the sections all together in specific order

								$form['tabs']['style']['sections'] = array_merge( $section_general, $section_colors_predefined, $sections );

					}


			// Output

				return $form;

		} // /register_settings_form





	/**
	 * 20) Classes
	 */

		/**
		 * Add predefined classes helper dropdown
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 *
		 * @param  array $field
		 * @param  name  $name
		 */
		public static function predefined_classes_dropdown( $field, $name ) {

			// Processing

				if ( 'class' == $name ) {

					$field['options'] = array(

							'' => esc_html__( '- Choose from predefined classes -', 'boo-valley' ),

							// Posts list classes

								'optgroup-posts' => array(
									'label'   => esc_html__( 'Post lists:', 'boo-valley' ),
									'options' => array(

										'masonry'       => esc_html__( 'Masonry items layout', 'boo-valley' ),

										// 'hide-media'    => esc_html__( 'Posts: Hide media (featured images, video and audio players)', 'boo-valley' ),

										'simple-layout' => esc_html__( 'Posts & Projects: Simple layout', 'boo-valley' ),

										// 'hide-excerpt'  => esc_html__( 'Staff: Hide excerpt', 'boo-valley' ),

										'inline'           => esc_html__( 'Content Module: Inline icon box layout', 'boo-valley' ),
										'hide-title'       => esc_html__( 'Content Module: Hide title', 'boo-valley' ),
										'hide-more-button' => esc_html__( 'Content Module: Hide "Read more" button', 'boo-valley' ),
										'item-border'      => esc_html__( 'Content Module: Border around items', 'boo-valley' ),

									),
								),

							// Decoration classes

								'optgroup-decoration' => array(
									'label'   => esc_html__( 'Decorations:', 'boo-valley' ),
									'options' => array(

										'box-shadow-small'  => esc_html__( 'Column shadow, small', 'boo-valley' ),
										'box-shadow-medium' => esc_html__( 'Column shadow, medium', 'boo-valley' ),
										'box-shadow-large'  => esc_html__( 'Column shadow, large', 'boo-valley' ),

									),
								),

							// Layout classes

								'optgroup-layout' => array(
									'label'   => esc_html__( 'Layout:', 'boo-valley' ),
									'options' => array(

										'text-center'      => esc_html__( 'Text center', 'boo-valley' ),
										'text-left'        => esc_html__( 'Text left', 'boo-valley' ),
										'text-right'       => esc_html__( 'Text right', 'boo-valley' ),

										'fullwidth'        => esc_html__( 'Fullwidth elements', 'boo-valley' ),

										'hide-accessibly'  => esc_html__( 'Hide accessibly (displayed in page builder edit mode only)', 'boo-valley' ),

										'split-screen-row' => esc_html__( 'Split screen row (apply on full-height row only)', 'boo-valley' ),

										'zindex-10'        => esc_html__( 'Bring element to front (CSS z-index)', 'boo-valley' ),

									),
								),

							// Widget classes

								'optgroup-widget' => array(
									'label'   => esc_html__( 'Widgets:', 'boo-valley' ),
									'options' => array(

										'widget-title-style'           => esc_html__( 'Use default widget title styling', 'boo-valley' ),
										'hide-widget-title-accessibly' => esc_html__( 'Hide widget title accessibly', 'boo-valley' ),
										'hide-widget-title'            => esc_html__( 'Hide widget title forcefully', 'boo-valley' ),

									),
								),

							// Typography classes

								'optgroup-typography' => array(
									'label'   => esc_html__( 'Typography:', 'boo-valley' ),
									'options' => array(

										'font-size-xs' => esc_html__( 'Font size, extra small', 'boo-valley' ),
										'font-size-s'  => esc_html__( 'Font size, small', 'boo-valley' ),
										'font-size-sm' => esc_html__( 'Font size, smaller', 'boo-valley' ),
										'font-size-l'  => esc_html__( 'Font size, large', 'boo-valley' ),
										'font-size-xl' => esc_html__( 'Font size, extra large', 'boo-valley' ),

									),
								),

						);

				}


			// Output

				return $field;

		} // /predefined_classes_dropdown





} // /Boo_Valley_Beaver_Builder_Form

add_action( 'after_setup_theme', 'Boo_Valley_Beaver_Builder_Form::init' );
