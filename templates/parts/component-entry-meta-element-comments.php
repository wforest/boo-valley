<?php
/**
 * Post meta: Comments count
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.1.0
 * @version  1.1.0
 */





// Requirements check

	if (
			post_password_required()
			|| ! comments_open( get_the_ID() )
		) {
		return;
	}


// Helper variables

	$comments_number = absint( get_comments_number( get_the_ID() ) );


?>

<span class="entry-meta-element comments-link">
	<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>#comments" title="<?php echo esc_attr( sprintf( esc_html_x( 'Comments: %s', '%s: number of comments.', 'boo-valley' ), number_format_i18n( $comments_number ) ) ); ?>">
		<span class="entry-meta-description">
			<?php echo esc_html_x( 'Comments:', 'Post meta info description: comments count.', 'boo-valley' ); ?>
		</span>
		<span class="comments-count">
			<?php echo $comments_number; ?>
		</span>
	</a>
</span>
