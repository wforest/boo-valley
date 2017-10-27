<?php
/**
 * Child page item content
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.1
 */





// Helper variables

	$child_id      = get_the_ID();
	$has_excerpt   = has_excerpt();
	$has_more_link = (bool) apply_filters( 'wmhook_boo_valley_content_child_page_has_more_link', true );
	$image_size    = (string) apply_filters( 'wmhook_boo_valley_content_child_page_image_size', 'medium' );

	$page_image_url = trim( get_post_meta( $child_id, 'custom_image', true ) );
	$image_alt_attr = trim( get_post_meta( $child_id, 'custom_image_alt', true ) );

	if ( get_post_meta( $child_id, 'no_thumbnail', true ) ) {
		$page_image_url = '-';
	}

	if ( empty( $image_alt_attr ) ) {
		$image_alt_attr = the_title_attribute( 'echo=0' );
	}

	if ( is_object( $page_image_url ) ) {
		$page_image_url = absint( $page_image_url->ID );
	}

	if ( is_numeric( $page_image_url ) ) {
		$image_alt_attr = get_post_meta( absint( $page_image_url ), '_wp_attachment_image_alt', true );
		$page_image_url = wp_get_attachment_image_src( absint( $page_image_url ), $image_size );
		$page_image_url = $page_image_url[0];
	}

	if ( empty( $page_image_url ) && has_post_thumbnail( $child_id ) ) {
		$image_alt_attr = get_post_meta( get_post_thumbnail_id( $child_id ), '_wp_attachment_image_alt', true );
		$page_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $child_id ), $image_size );
		$page_image_url = $page_image_url[0];
	}

	$page_image_url = (string) apply_filters( 'wmhook_boo_valley_content_child_page_image_url', $page_image_url, $child_id );

	$child_page_class = ( $page_image_url && '-' != $page_image_url ) ? ( ' has-child-page-image' ) : ( ' no-child-page-image' );


?>

<article id="post-<?php echo esc_attr( $child_id ); ?>" class="child-page post-<?php echo esc_attr( $child_id ) . esc_attr( $child_page_class ); ?>">

	<?php if ( $page_image_url && '-' != $page_image_url ) : ?>

		<figure class="child-page-image">
			<?php

			if ( $has_excerpt && $has_more_link ) {
				echo '<a href="' . esc_url( get_permalink( $child_id ) ) . '">';
			}

			?>

			<img
				src="<?php echo esc_url( $page_image_url ); ?>"
				alt="<?php echo esc_attr( $image_alt_attr ); ?>"
				title="<?php echo the_title_attribute( 'echo=0&post=' . $child_id ); ?>"
				/>

			<?php

			if ( $has_excerpt && $has_more_link ) {
				echo '</a>';
			}

			?>
		</figure>

	<?php endif; ?>

	<h2 class="child-page-title">
		<?php

		if ( $has_excerpt && $has_more_link ) {
			echo '<a href="' . esc_url( get_permalink( $child_id ) ) . '">';
		}

		the_title();

		if ( $has_excerpt && $has_more_link ) {
			echo '</a>';
		}

		?>
	</h2>

	<div class="child-page-summary">
		<?php

		$content = get_the_content( wp_kses(
				apply_filters( 'wmhook_boo_valley_summary_continue_reading', '', 'child-page' ),
				array(
					'span' => array(
						'class' => true,
					),
				)
			) );
		$content = str_replace( '#more-' . $child_id, '', $content ); // Removing more link hash to prevent page jumping

		if ( $has_excerpt ) {
			$content = get_the_excerpt();
		}

		echo $content;

		?>
	</div>

	<?php

	/**
	 * Displayed only if we have a page excerpt.
	 * When no page excerpt set and full page content is displayed,
	 * you should use a more tag to display the continue reading link.
	 */
	if ( $has_excerpt && $has_more_link ) {
		echo apply_filters( 'wmhook_boo_valley_summary_continue_reading', '', 'child-page' );
	}

	?>

</article>
