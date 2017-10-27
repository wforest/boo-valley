<?php
/**
 * Loop Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.4.3
 *
 * Contents:
 *
 *   0) Init
 *  10) Pagination
 *  20) Search
 *  30) Archives
 * 100) Others
 */
class Boo_Valley_Loop {





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

						add_action( 'wmhook_boo_valley_postslist_after', __CLASS__ . '::pagination' );

						add_action( 'wmhook_boo_valley_postslist_before', __CLASS__ . '::search_form' );

					// Filters

						add_filter( 'get_the_archive_title', __CLASS__ . '::archive_title' );

						add_filter( 'get_the_archive_description', __CLASS__ . '::archive_author_description' );

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
	 * 10) Pagination
	 */

		/**
		 * Pagination
		 *
		 * @since    1.0.0
		 * @version  1.4.3
		 */
		public static function pagination() {

			// Requirements check

				// Don't display pagination if Jetpack Infinite Scroll in use

					if ( class_exists( 'The_Neverending_Home_Page' ) ) {
						return;
					}


			// Helper variables

				$output = '';

				$args = (array) apply_filters( 'wmhook_boo_valley_pagination_args', array(
					'prev_text' => esc_html_x( '&laquo;', 'Pagination text (visible): previous.', 'boo-valley' ) . '<span class="screen-reader-text"> '
					               . esc_html_x( 'Previous page', 'Pagination text (hidden): previous.', 'boo-valley' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . esc_html_x( 'Next page', 'Pagination text (hidden): next.', 'boo-valley' )
					               . ' </span>' . esc_html_x( '&raquo;', 'Pagination text (visible): next.', 'boo-valley' ),
				), 'loop' );


			// Processing

				if ( $output = paginate_links( $args ) ) {
					global $wp_query;

					$total   = ( isset( $wp_query->max_num_pages ) ) ? ( $wp_query->max_num_pages ) : ( 1 );
					$current = ( get_query_var( 'paged' ) ) ? ( absint( get_query_var( 'paged' ) ) ) : ( 1 );

					$output = '<nav class="pagination" role="navigation" aria-labelledby="pagination-label" data-current="' . esc_attr( $current ) . '" data-total="' . esc_attr( $total ) . '">'
					          . '<h2 class="screen-reader-text" id="pagination-label">' . esc_attr__( 'Posts Navigation', 'boo-valley' ) . '</h2>'
					          . $output
					          . '</nav>';
				}


			// Output

				echo $output;

		} // /pagination



		/**
		 * Parted post navigation
		 *
		 * Shim for passing the Theme Check review.
		 * Using table of contents generator instead.
		 *
		 * @see  Boo_Valley_Library::add_table_of_contents()
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function shim() {

			// Output

				wp_link_pages();

		} // /shim





	/**
	 * 20) Search
	 */

		/**
		 * Output search form on top of search results page
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function search_form() {

			// Requirements check

				if ( ! is_search() ) {
					return;
				}


			// Output

				get_search_form( true );

		} // /search_form





	/**
	 * 30) Archives
	 */

		/**
		 * Archive page title
		 *
		 * @since    1.1.0
		 * @version  1.1.0
		 *
		 * @param  string $title
		 */
		public static function archive_title( $title = '' ) {

			// Helper variables

				$remove_prefix = get_theme_mod( 'archive_title_prefix', array() );
				$remove_prefix = ( ! is_array( $remove_prefix ) ) ? ( explode( ',', $remove_prefix ) ) : ( $remove_prefix );


			// Requirements check

				if ( empty( $remove_prefix ) ) {
					return $title;
				}


			// Processing

				if ( in_array( 'category', $remove_prefix ) && is_category() ) {
					$title = single_cat_title( '', false );
				} elseif ( in_array( 'tag', $remove_prefix ) && is_tag() ) {
					$title = single_tag_title( '', false );
				} elseif ( in_array( 'author', $remove_prefix ) && is_author() ) {
					$title = '<span class="vcard">' . get_the_author() . '</span>';
				} elseif ( in_array( 'post_type', $remove_prefix ) && is_post_type_archive() ) {
					$title = post_type_archive_title( '', false );
				} elseif ( in_array( 'taxonomy', $remove_prefix ) && is_tax() ) {
					$title = single_term_title( '', false );
				}


			// Output

				return $title;

		} // /archive_title



		/**
		 * Author archive description
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $desc
		 */
		public static function archive_author_description( $desc = '' ) {

			// Requirements check

				if ( ! is_author() ) {
					return $desc;
				}


			// Output

				return apply_filters( 'the_content', get_the_author_meta( 'description' ) );

		} // /archive_author_description





	/**
	 * 100) Others
	 */

		/**
		 * Ignore sticky posts in main loop
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  obj $query
		 */
		public static function ignore_sticky_posts( $query ) {

			// Processing

				if ( $query->is_main_query() ) {
					$query->set( 'ignore_sticky_posts', 1 );
				}

		} // /ignore_sticky_posts





} // /Boo_Valley_Loop

add_action( 'after_setup_theme', 'Boo_Valley_Loop::init' );
