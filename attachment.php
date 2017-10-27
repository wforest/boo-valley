<?php
/**
 * Attachment template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.3.0
 * @version  1.3.0
 */





get_header();

	while ( have_posts() ) : the_post();

		get_template_part( 'templates/parts/content', 'attachment' );

	endwhile;

get_footer();
