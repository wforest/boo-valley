<?php
/**
 * Aside post format content
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	$args = ( ! isset( $helper ) ) ? ( null ) : ( array( 'helper' => $helper ) );


?>

<?php do_action( 'tha_entry_before', $args ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo apply_filters( 'wmhook_boo_valley_entry_container_atts', '' ); ?>>

	<?php do_action( 'tha_entry_top', $args ); ?>

	<div class="entry-content"<?php echo Boo_Valley_Schema::get( 'entry_body' ); ?>><?php

		do_action( 'tha_entry_content_before', $args );

		the_content();

		do_action( 'tha_entry_content_after', $args );

	?></div>

	<?php do_action( 'tha_entry_bottom', $args ); ?>

</article>

<?php do_action( 'tha_entry_after', $args ); ?>
