<?php
/**
 * WebMan Amplifier: Custom Post Types Class
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
 *  10) General setup
 *  20) Projects
 *  30) Staff
 *  40) Testimonials
 * 100) Others
 */
class Boo_Valley_WebMan_Amplifier_Custom_Post_Types {





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

					// Actions

						add_action( 'template_redirect', __CLASS__ . '::redirects' );

						// Projects

							add_action( 'tha_entry_bottom', __CLASS__ . '::project_category' );

							add_action( 'tha_entry_bottom', __CLASS__ . '::project_tag' );

						// Staff

							add_action( 'tha_entry_bottom', __CLASS__ . '::staff_department' );

							add_action( 'tha_entry_bottom', __CLASS__ . '::staff_specialty' );

							add_action( 'tha_entry_content_after', __CLASS__ . '::staff_more_link' );

					// Filters

						add_filter( 'body_class', __CLASS__ . '::body_class' );

						add_filter( 'wmhook_boo_valley_is_masonry_layout', __CLASS__ . '::is_archive', 100 );

						add_filter( 'wmhook_boo_valley_post_navigation_post_type', __CLASS__ . '::navigation_post_types' );

						add_filter( 'wmhook_boo_valley_subtitles_post_types', __CLASS__ . '::subtitles' );

						add_filter( 'wmhook_boo_valley_post_type_redirect', __CLASS__ . '::redirects_setup' );

						// Projects

							add_filter( 'wmhook_boo_valley_loop_content_type', __CLASS__ . '::project_content_type' );

							add_filter( 'wmhook_boo_valley_schema_creative_work_array', __CLASS__ . '::project_schema_creativework' );

							add_filter( 'wmhook_boo_valley_post_media_image_size', __CLASS__ . '::project_post_media_size', 15 );

						// Staff

							add_filter( 'wmhook_wmamp_cp_register_wm_staff', __CLASS__ . '::staff_args' );

							add_filter( 'wmhook_boo_valley_loop_content_type', __CLASS__ . '::staff_content_type' );

							add_filter( 'wmhook_boo_valley_entry_container_atts', __CLASS__ . '::staff_entry_container_atts', 20 );

							add_filter( 'wmhook_boo_valley_schema_pre', __CLASS__ . '::staff_schema', 10, 2 );

							add_filter( 'wmhook_boo_valley_post_media_image_size', __CLASS__ . '::staff_post_media_size', 15 );

							add_filter( 'wmhook_boo_valley_post_media_image_featured_link', __CLASS__ . '::staff_link' );

							add_filter( 'wmhook_boo_valley_post_title_args', __CLASS__ . '::staff_title_args' );

						// Testimonials

							add_filter( 'wmhook_wmamp_cp_register_wm_testimonials', __CLASS__ . '::testimonial_args' );

							add_filter( 'wmhook_boo_valley_loop_content_type', __CLASS__ . '::testimonial_content_type' );

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
	 * 10) General setup
	 */

		/**
		 * Custom posts types redirects
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function redirects() {

			// Requirements check

				if ( ! function_exists( 'wma_meta_option' ) ) {
					return;
				}


			// Helper variables

				$get_post_type = get_post_type( get_the_ID() );

				$redirects = (array) apply_filters( 'wmhook_boo_valley_post_type_redirect', array() );


			// Processing

				if (
						! empty( $redirects )
						&& in_array( $get_post_type, array_keys( $redirects ) )
					) {
					wp_redirect( esc_url( $redirects[ $get_post_type ] ), 301 );
					exit;
				}

		} // /redirects



		/**
		 * Custom posts types redirects
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $redirects  Pairs: key = post type, value = redirect URL.
		 */
		public static function redirects_setup( $redirects = array() ) {

			// Processing

				$redirects = array(
						'wm_logos'   => home_url( '/' ),
						'wm_modules' => home_url( '/' ),
					);

				if ( is_singular() ) {
					$redirects['wm_testimonials'] = home_url( '/' );
				}


			// Output

				return $redirects;

		} // /redirects_setup



		/**
		 * Body classes
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 *
		 * @param  array $classes
		 */
		public static function body_class( $classes = array() ) {

			// Helper variables

				$classes = (array) $classes; // Just in case...


			// Processing

				if ( is_archive() ) {

					switch ( get_post_type() ) {

						case 'wm_projects':
							$classes[] = 'archive-projects';
							break;

						case 'wm_staff':
							$classes[] = 'archive-staff';
							break;

						case 'wm_testimonials':
							$classes[] = 'archive-testimonials';
							break;

						default:
							break;

					} // /switch

				}


			// Output

				return array_unique( $classes );

		} // /body_class



		/**
		 * Is specific archive page?
		 *
		 * @since    1.0.0
		 * @version  1.2.0
		 *
		 * @param  boolean $is_archive
		 */
		public static function is_archive( $is_archive = false ) {

			// Processing

				if (
						is_archive()
						&& in_array( get_post_type(), array(
							'wm_staff',
							'wm_projects',
							'wm_testimonials',
						) )
					) {
					return true;
				}


			// Output

				return $is_archive;

		} // /is_archive



		/**
		 * Post navigation support
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $post_types  Post types supporting post navigation.
		 */
		public static function navigation_post_types( $post_types = array() ) {

			// Helper variables

				$post_types[] = 'wm_projects';
				$post_types[] = 'wm_staff';


			// Processing

				return $post_types;

		} // /navigation_post_types



		/**
		 * Subtitles plugin support
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $post_types  Post types supporting Subtitles plugin.
		 */
		public static function subtitles( $post_types = array() ) {

			// Helper variables

				$post_types[] = 'wm_modules';
				$post_types[] = 'wm_projects';
				$post_types[] = 'wm_staff';


			// Processing

				return $post_types;

		} // /subtitles





	/**
	 * 20) Projects
	 */

		/**
		 * Custom posts type content: Project
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $type
		 */
		public static function project_content_type( $type ) {

			// Processing

				if ( 'wm_projects' == get_post_type( get_the_ID() ) ) {
					return 'project';
				}


			// Output

				return $type;

		} // /project_content_type



		/**
		 * Adding projects to CreativeWork Schema.org compatible posts
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $post_types
		 */
		public static function project_schema_creativework( $post_types ) {

			// Processing

				$post_types[] = 'wm_projects';


			// Output

				return $post_types;

		} // /project_schema_creativework



		/**
		 * Project media size
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $image_size
		 */
		public static function project_post_media_size( $image_size ) {

			// Processing

				if (
						( is_single( get_the_ID() ) || is_archive() )
						&& 'wm_projects' === get_post_type()
					) {
					$image_size = 'medium';
				}


			// Output

				return $image_size;

		} // /project_post_media_size



		/**
		 * Project taxonomy: Category
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function project_category() {

			// Requirements check

				if ( is_single( get_the_ID() ) ) {
					return;
				}


			// Output

				echo self::output_taxonomy( 'project_category' );

		} // /project_category



		/**
		 * Project taxonomy: Tag
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function project_tag() {

			// Requirements check

				if ( is_single( get_the_ID() ) ) {
					return;
				}


			// Output

				echo self::output_taxonomy( 'project_tag' );

		} // /project_tag





	/**
	 * 30) Staff
	 */

		/**
		 * Custom posts type setup: Staff
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $args
		 */
		public static function staff_args( $args ) {

			// Processing

				$args['taxonomies'] = array( 'post_tag' );


			// Output

				return $args;

		} // /staff_args



		/**
		 * Custom posts type content: Staff
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $type
		 */
		public static function staff_content_type( $type ) {

			// Processing

				if ( 'wm_staff' == get_post_type( get_the_ID() ) ) {
					return 'staff';
				}


			// Output

				return $type;

		} // /staff_content_type



		/**
		 * Custom posts type link: Staff
		 *
		 * Remove single post link when there is no post content.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $image_link
		 */
		public static function staff_link( $image_link = array() ) {

			// Processing

				if (
						'wm_staff' == get_post_type( get_the_ID() )
						&& ! get_the_content()
					) {
					$image_link = false;
				}


			// Output

				return $image_link;

		} // /staff_link



		/**
		 * Custom posts type title: Staff
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $args
		 */
		public static function staff_title_args( $args ) {

			// Processing

				// Remove single post link when there is no post content

					if ( false === self::staff_link() ) {
						$args['title'] = get_the_title();
					}


			// Output

				return $args;

		} // /staff_title_args



		/**
		 * Entry container attributes
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $atts  Already set container HTML atts.
		 */
		public static function staff_entry_container_atts( $atts ) {

			// Processing

				if ( 'wm_staff' == get_post_type( get_the_ID() ) ) {
					$atts = Boo_Valley_Schema::get( 'ProfilePage' );
				}


			// Output

				return (string) $atts;

		} // /staff_entry_container_atts



		/**
		 * Fixing Schema.org for Staff posts
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  bool/string $pre
		 * @param  string      $element
		 */
		public static function staff_schema( $pre, $element ) {

			// Processing

				if ( is_singular( 'wm_staff' ) ) {

					switch ( $element ) {

						case 'entry_body':
								$pre = '';
							break;

						case 'headline':
								$pre = ' itemprop="name"';
							break;

						default:
							break;

					}

				}


			// Output

				return $pre;

		} // /staff_schema



		/**
		 * Staff media size
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $image_size
		 */
		public static function staff_post_media_size( $image_size ) {

			// Processing

				if (
						( is_single( get_the_ID() ) || is_search() || is_archive() )
						&& 'wm_staff' === get_post_type()
					) {
					$image_size = 'boo_valley-square';
				}


			// Output

				return $image_size;

		} // /staff_post_media_size



		/**
		 * Staff taxonomy: Department
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function staff_department() {

			// Requirements check

				if ( is_single( get_the_ID() ) ) {
					return;
				}


			// Output

				echo self::output_taxonomy( 'staff_department' );

		} // /staff_department



		/**
		 * Staff taxonomy: Specialty
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function staff_specialty() {

			// Requirements check

				if ( is_single( get_the_ID() ) ) {
					return;
				}


			// Output

				echo self::output_taxonomy( 'staff_specialty' );

		} // /staff_specialty



		/**
		 * Staff more link
		 *
		 * @since    1.2.0
		 * @version  1.2.0
		 */
		public static function staff_more_link() {

			// Requirements check

				if ( is_single( get_the_ID() ) || 'wm_staff' !== get_post_type() ) {
					return;
				}


			// Output

				if ( trim( get_the_content() ) ) {

					echo '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="button color-simple" rel="bookmark">';
					esc_html_e( 'Nice to meet you!', 'boo-valley' );
					echo '</a>';

				}

		} // /staff_more_link





	/**
	 * 40) Testimonials
	 */

		/**
		 * Custom posts type setup: Testimonial
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $args
		 */
		public static function testimonial_args( $args ) {

			// Processing

				$args['exclude_from_search'] = false;


			// Output

				return $args;

		} // /testimonial_args



		/**
		 * Custom posts type content: Testimonial
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $type
		 */
		public static function testimonial_content_type( $type ) {

			// Processing

				if ( 'wm_testimonials' == get_post_type( get_the_ID() ) ) {
					return 'testimonial';
				}


			// Output

				return $type;

		} // /testimonial_content_type





	/**
	 * 100) Others
	 */

		/**
		 * Taxonomies
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $taxonomy
		 */
		public static function output_taxonomy( $taxonomy = '' ) {

			// Pre

				$pre = apply_filters( 'wmhook_boo_valley_webman_amplifier_custom_post_types_output_taxonomy_pre', false, $taxonomy );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				if ( ! taxonomy_exists( $taxonomy ) ) {
					return;
				}


			// Helper variables

				$output       = '';
				$terms_array  = array();
				$terms        = get_the_terms( get_the_ID(), $taxonomy );
				$taxonomy_obj = get_taxonomy( $taxonomy );


			// Processing

				if (
						! is_wp_error( $terms )
						&& ! empty( $terms )
					) {

					foreach( $terms as $term ) {

						$output_single = '';
						$term_link     = get_term_link( $term, $taxonomy );

						if ( $term_link && ! is_wp_error( $term_link ) ) {
							$output_single .= '<a href="' . esc_url( $term_link ) . '"';
						} else {
							$output_single .= '<span';
						}

						$output_single .= ' class="term term-' . esc_attr( $taxonomy ) . ' term-' . sanitize_html_class( $term->slug ) . '">';
						$output_single .= $term->name;

						if ( $term_link && ! is_wp_error( $term_link ) ) {
							$output_single .= '</a>';
						} else {
							$output_single .= '</span>';
						}

						$terms_array[] = $output_single;

					} // /foreach

				}

				if ( ! empty( $terms_array ) ) {

					$output .= '<div class="wm-posts-element wm-html-element taxonomy taxonomy-' . esc_attr( $taxonomy ) . '">';

						$output .= '<span class="taxonomy-label">' . $taxonomy_obj->labels->singular_name . ': </span>';

						$output .= wp_kses(
								implode( ', ', $terms_array ),
								array(
									'a' => array(
											'href' => true,
											'class' => true,
										),
									'span' => array(
											'class' => true,
										),
								)
							);

					$output .= '</div>';

				}


			// Output

				return $output;

		} // /output_taxonomy





} // /Boo_Valley_WebMan_Amplifier_Custom_Post_Types

add_action( 'after_setup_theme', 'Boo_Valley_WebMan_Amplifier_Custom_Post_Types::init' );
