<?php
/**
 * Page intro container
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	$class = 'page-header';

	if ( is_singular() ) {

		$class = 'entry-header';

		if (
				has_post_thumbnail( get_the_ID() )
				|| wp_attachment_is_image()
			) {
			$class .= ' has-featured-image';
		}

	}

	if ( apply_filters( 'wmhook_boo_valley_intro_class_no_image', false ) ) {
		$class .= ' no-intro-image';
	}


?>

<section id="intro-container" class="<?php echo esc_attr( $class ); ?> intro-container">

	<?php do_action( 'wmhook_boo_valley_intro_before' ); ?>

	<div id="intro" class="intro"><div class="intro-inner">

		<?php do_action( 'wmhook_boo_valley_intro' ); ?>

	</div></div>

	<?php do_action( 'wmhook_boo_valley_intro_after' ); ?>

</section>
