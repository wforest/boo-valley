<?php
/**
 * Post meta top
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.1.0
 * @version  1.1.0
 */





// Helper variables

	$post_id = get_the_ID();


// Requirements check

	if ( ! in_array( get_post_type( $post_id ), (array) apply_filters( 'wmhook_boo_valley_entry_meta_post_type', array( 'post' ) ) ) ) {
		return;
	}

	if (
			is_single( $post_id )
			&& (
				( is_callable( 'Boo_Valley_Beaver_Builder_Helpers::is_builder_enabled' ) && Boo_Valley_Beaver_Builder_Helpers::is_builder_enabled() )
				|| Boo_Valley_Post::is_page_builder_ready()
			)
		) {
		/**
		 * Don't display on single post page when using a page builder.
		 */
		return;
	}


?>

<footer class="entry-meta"><?php

	get_template_part( 'templates/parts/component-entry-meta-element', 'date' );
	get_template_part( 'templates/parts/component-entry-meta-element', 'author' );
	get_template_part( 'templates/parts/component-entry-meta-element', 'comments' );

	if ( is_single( $post_id ) ) {
		get_template_part( 'templates/parts/component-entry-meta-element', 'category' );
	}

?></footer>
