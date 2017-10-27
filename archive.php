<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
			<?php

			the_archive_title( '<h1 class="page-title">', Boo_Valley_Library::get_the_paginated_suffix( 'small' ) . '</h1>' );

			the_archive_description( '<div class="taxonomy-description">', '</div>' );

			?>
		</header>

		<?php

	endif;

	get_template_part( 'templates/parts/loop', 'archive' );

get_footer();
