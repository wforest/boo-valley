<?php
/**
 * Default WordPress loop content
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





if ( have_posts() ) :

	do_action( 'wmhook_boo_valley_postslist_before' );

	?>

	<div class="posts posts-list"<?php echo Boo_Valley_Schema::get( 'ItemList' ); ?>>

		<?php

		do_action( 'tha_content_while_before' );

		while ( have_posts() ) : the_post();

			/**
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 *
			 * Or, you can use the filter hook below to modify which content file to load.
			 */
			get_template_part( 'templates/parts/content', apply_filters( 'wmhook_boo_valley_loop_content_type', get_post_format() ) );

		endwhile;

		do_action( 'tha_content_while_after' );

		?>

	</div>

	<?php

	do_action( 'wmhook_boo_valley_postslist_after' );

else :

	get_template_part( 'templates/parts/content', 'none' );

endif;
