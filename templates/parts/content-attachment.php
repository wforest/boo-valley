<?php
/**
 * Attachment post content
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.3.0
 * @version  1.3.0
 */





?>

<?php do_action( 'tha_entry_before' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo apply_filters( 'wmhook_boo_valley_entry_container_atts', '' ); ?>>

	<?php do_action( 'tha_entry_top' ); ?>

	<div class="entry-content"<?php echo Boo_Valley_Schema::get( 'itemprop="description"' ); ?>>

		<?php do_action( 'tha_entry_content_before' ); ?>

		<div class="attachment-download">
			<span class="attachment-download-label"><?php esc_html_e( 'Download attachment file:', 'boo-valley' ); ?></span>
			<?php the_attachment_link(); ?>
		</div>

		<?php

		if ( has_excerpt() ) {
			the_excerpt();
		}

		the_content();

		do_action( 'tha_entry_content_after' );

		?>

	</div>

	<?php do_action( 'tha_entry_bottom' ); ?>

</article>

<?php do_action( 'tha_entry_after' ); ?>
