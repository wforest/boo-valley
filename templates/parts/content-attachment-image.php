<?php
/**
 * Attachment:image post content
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	$image_full = wp_get_attachment_image_src( get_the_ID(), 'full' );


?>

<?php do_action( 'tha_entry_before' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo apply_filters( 'wmhook_boo_valley_entry_container_atts', '' ); ?>>

	<?php do_action( 'tha_entry_top' ); ?>

	<div class="entry-content"<?php echo Boo_Valley_Schema::get( 'itemprop="description"' ); ?>>

		<?php do_action( 'tha_entry_content_before' ); ?>

		<table>

			<caption><?php echo esc_html_x( 'Image info', 'Attachment page image info table caption.', 'boo-valley' ); ?></caption>

			<tbody>

				<tr class="date">
					<th><?php echo esc_html_x( 'Image published on:', 'Attachment page publish time.', 'boo-valley' ); ?></th>
					<td><?php the_time( get_option( 'date_format' ) ); ?></td>
				</tr>

				<?php if ( isset( $image_full[1] ) && isset( $image_full[2] ) ) : ?>

				<tr class="size">
					<th><?php esc_html_e( 'Image size:', 'boo-valley' ); ?></th>
					<td><?php echo absint( $image_full[1] ) . ' &times; ' . absint( $image_full[2] ) . ' px'; ?></td>
				</tr>

				<?php endif; ?>

				<tr class="filename">
					<th><?php esc_html_e( 'Image file name:', 'boo-valley' ); ?></th>
					<td><code><?php echo basename( get_attached_file( get_the_ID() ) ); ?></code></td>
				</tr>

			</tbody>

		</table>

		<?php

		the_excerpt();

		do_action( 'tha_entry_content_after' );

		?>

	</div>

	<?php do_action( 'tha_entry_bottom' ); ?>

</article>

<?php do_action( 'tha_entry_after' ); ?>
