<?php
/**
 * Post meta: Tags
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.1.0
 * @version  1.1.0
 */





// Requirements check

	if ( ! $tags = get_the_tag_list( '', ' ', '', get_the_ID() ) ) {
		return;
	}


?>

<span class="entry-meta-element tags-links"<?php echo Boo_Valley_Schema::get( 'keywords' ); ?>>
	<span class="entry-meta-description">
		<?php echo esc_html_x( 'Tagged as:', 'Post meta info description: tags list.', 'boo-valley' ); ?>
	</span>
	<?php echo $tags; ?>
</span>
