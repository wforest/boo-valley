<?php
/**
 * Post meta bottom
 *
 * Display on page builder enabled single post page only.
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.1.0
 * @version  1.1.0
 */





// Requirements check

	if (
			! ( is_callable( 'Boo_Valley_Beaver_Builder_Helpers::is_builder_enabled' ) && Boo_Valley_Beaver_Builder_Helpers::is_builder_enabled() )
			&& ! Boo_Valley_Post::is_page_builder_ready()
		) {
		return;
	}

	if ( ! in_array( get_post_type( get_the_ID() ), (array) apply_filters( 'wmhook_boo_valley_entry_meta_post_type', array( 'post' ) ) ) ) {
		/**
		 * Yes, indeed, we use filter for top meta here.
		 * We are just moving meta to bottom of the post content for page builder
		 * enabled posts, so no need for different filter name.
		 */
		return;
	}


?>

<footer class="entry-meta"><?php

	get_template_part( 'templates/parts/component-entry-meta-element', 'date' );
	get_template_part( 'templates/parts/component-entry-meta-element', 'author' );
	get_template_part( 'templates/parts/component-entry-meta-element', 'comments' );
	get_template_part( 'templates/parts/component-entry-meta-element', 'category' );

?></footer>
