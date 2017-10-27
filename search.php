<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





get_header();

	if ( have_posts() ) :

		?>

		<header class="page-header">
			<h1 class="page-title"><?php

				printf(
					esc_html__( 'Search Results for: %s', 'boo-valley' ),
					'<span>' . get_search_query() . '</span>'
				);

			?></h1>
		</header>

		<?php

	endif;

	get_template_part( 'templates/parts/loop', 'search' );

get_footer();
