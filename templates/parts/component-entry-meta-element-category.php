<?php
/**
 * Post meta: Category
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.1.0
 * @version  1.1.0
 */





// Requirements check

	if (
			! Boo_Valley_Library::is_categorized_blog()
			|| ! $categories = get_the_category_list( ', ', '', get_the_ID() )
		) {
		return;
	}


?>

<span class="entry-meta-element cat-links">
	<span class="entry-meta-description">
		<?php echo esc_html_x( 'Categorized in:', 'Post meta info description: categories list.', 'boo-valley' ); ?>
	</span>
	<?php echo $categories; ?>
</span>
