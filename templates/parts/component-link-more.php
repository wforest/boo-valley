<?php
/**
 * More link HTML
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





?>

<div class="link-more">
	<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" class="more-link">
		<?php

		printf(
				esc_html_x( 'Continue reading%s&hellip;', '%s: Name of current post.', 'boo-valley' ),
				the_title( '<span class="screen-reader-text"> &ldquo;', '&rdquo;</span>', false )
			);

		?>
	</a>
</div>
