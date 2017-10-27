<?php
/**
 * Page intro content
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.2.0
 */





// Helper variables

	$title = $page_summary = '';

	$class_title  = ( is_single() ) ? ( 'entry-title' ) : ( 'page-title' );
	$class_title .= ' h1 intro-title';

	$posts_page          = get_option( 'page_for_posts' );
	$intro_title_tag     = ( is_page() ) ? ( 'h1' ) : ( 'h3' );
	$title_paginated_url = ( is_home() && $posts_page ) ? ( get_permalink( $posts_page ) ) : ( get_permalink() );
	$pagination_suffix   = Boo_Valley_Library::get_the_paginated_suffix( 'small' );


// Processing

	if ( ! $pagination_suffix ) {

		// Title setup

			$title = single_post_title( '', false );

		// Page summary setup

			if ( is_singular() && has_excerpt() ) {
				$page_summary = get_the_excerpt();
			} elseif ( is_home() && $posts_page ) {
				$page_for_posts = get_post( absint( $posts_page ) );
				$page_summary   = apply_filters( 'get_the_excerpt', $page_for_posts->post_excerpt );
			} elseif ( is_archive() ) {
				$page_summary = get_the_archive_description();
			}

			if ( $page_summary ) {
				$class_title .= ' has-page-summary';
			}

	} else {

		// Title setup

			$title = '<a href="' . esc_url( $title_paginated_url ) . '">' . single_post_title( '', false ) . '</a>';

	}

	$title = '<' . tag_escape( $intro_title_tag ) . ' class="' . esc_attr( $class_title ) . '">' . $title . '</' . tag_escape( $intro_title_tag ) . '>';


// Output

	/**
	 * Page title
	 */

		if ( is_archive() ) { // For archive pages.

			$title  = '<' . tag_escape( $intro_title_tag ) . ' class="' . esc_attr( $class_title ) . '">';
			$title .= get_the_archive_title();
			$title .= $pagination_suffix;
			$title .= '</' . tag_escape( $intro_title_tag ) . '>';

		} elseif ( is_search() ) { // For search results.

			$title  = '<' . tag_escape( $intro_title_tag ) . ' class="' . esc_attr( $class_title ) . '">';
			$title .= sprintf(
					esc_html__( 'Search Results for: %s', 'boo-valley' ),
					'<span>' . get_search_query() . '</span>'
				);
			$title .= $pagination_suffix;
			$title .= '</' . tag_escape( $intro_title_tag ) . '>';

		}

		if ( 'h3' === $intro_title_tag ) {
			$title = '<h2 class="screen-reader-text">' . esc_html__( 'Introduction', 'boo-valley' ) . '</h2>' . $title;
		}

		echo $title;



	/**
	 * Page summary
	 */
	if ( $page_summary ) :

		?>

		<div class="page-summary">
			<?php echo $page_summary; ?>
		</div>

		<?php

	endif;
