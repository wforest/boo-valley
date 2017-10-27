<?php
/**
 * Post meta: Author
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.1.0
 * @version  1.1.0
 */





?>

<span class="entry-meta-element byline author vcard"<?php echo Boo_Valley_Schema::get( 'author' ) . Boo_Valley_Schema::get( 'Person' ); ?>>
	<span class="entry-meta-description">
		<?php echo esc_html_x( 'Written by:', 'Post meta info description: author name.', 'boo-valley' ); ?>
	</span>
	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="url fn n" rel="author"<?php echo Boo_Valley_Schema::get( 'name' ); ?>>
		<?php the_author(); ?>
	</a>
</span>
