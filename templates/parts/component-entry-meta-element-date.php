<?php
/**
 * Post meta: Publish and update date
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.1.0
 * @version  1.1.0
 */





// Helper variables

	$post_id = get_the_ID();


?>

<span class="entry-meta-element entry-date posted-on">
	<span class="entry-meta-description">
		<?php echo esc_html_x( 'Posted on:', 'Post meta info description: publish date.', 'boo-valley' ); ?>
	</span>
	<?php if ( is_singular( 'post' ) ) : ?>
		<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="published" title="<?php echo esc_attr( get_the_date() ) . ' | ' . esc_attr( get_the_time( '', $post_id ) ); ?>"<?php echo Boo_Valley_Schema::get( 'datePublished' ); ?>>
			<span class="day"><?php echo esc_html( get_the_date( 'd' ) ); ?></span>
			<span class="month"><?php echo esc_html( get_the_date( 'M' ) ); ?></span>
			<span class="year"><?php echo esc_html( get_the_date( 'Y' ) ); ?></span>
		</time>
	<?php else : ?>
		<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" rel="bookmark"<?php echo Boo_Valley_Schema::get( 'url' ); ?>>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="published" title="<?php echo esc_attr( get_the_date() ) . ' | ' . esc_attr( get_the_time( '', $post_id ) ); ?>"<?php echo Boo_Valley_Schema::get( 'datePublished' ); ?>>
				<?php echo esc_html( get_the_date() ); ?>
			</time>
		</a>
	<?php endif; ?>
	<time class="updated" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>">
		<?php echo esc_html( get_the_modified_date() ); ?>
	</time>
</span>
