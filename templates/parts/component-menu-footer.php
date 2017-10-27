<?php
/**
 * Footer menu template
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Requirements check

	if ( ! has_nav_menu( 'footer' ) ) {
		return;
	}


?>

<div class="site-footer-area footer-area-footer-menu">
	<div class="site-footer-area-inner footer-menu-inner">

		<?php do_action( 'wmhook_boo_valley_menu_footer_before' ); ?>

		<nav class="footer-menu" role="navigation" aria-labelledby="footer-menu-label">

			<h2 class="screen-reader-text" id="footer-menu-label"><?php esc_html_e( 'Footer Menu', 'boo-valley' ); ?></h2>

			<?php

			wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => false,
				) );

			?>

		</nav>

		<?php do_action( 'wmhook_boo_valley_menu_footer_after' ); ?>

	</div>
</div>
