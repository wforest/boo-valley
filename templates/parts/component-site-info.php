<?php
/**
 * Site info / footer credits area.
 *
 * IMPORTANT:
 * Do not remove the HTML comment from `</div><!-- /footer-area-site-info -->`
 * as it is required for customizer partial refresh manipulation.
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.3.0
 */





// Helper variables

	$site_info_text = trim( get_theme_mod( 'texts_site_info' ) );


// Requirements check

	if ( '-' === $site_info_text ) {
		return;
	}


?>

<div class="site-footer-area footer-area-site-info">
	<div class="site-footer-area-inner site-info-inner">

		<?php do_action( 'wmhook_boo_valley_site_info_before' ); ?>

		<div class="site-info">
			<?php if ( empty( $site_info_text ) ) : ?>

				&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				<span class="sep"> | </span>
				<?php

				printf(
					esc_html_x( 'Using %1$s %2$s theme created by %3$s', '1: theme name, 2: linked "WordPress" word, 3: theme developer name.', 'boo-valley' ),
					'<a href="' . esc_url( wp_get_theme( 'boo-valley' )->get( 'ThemeURI' ) ) . '"><strong>' . wp_get_theme( 'boo-valley' )->get( 'Name' ) . '</strong></a>',
					'<a href="' . esc_url( __( 'http://wordpress.org/', 'boo-valley' ) ) . '">WordPress</a>',
					'<a href="https://www.sullidigital.com">Sulli Digital</a>'
				);

				?>
				<span class="sep"> | </span>
				<a href="#top" id="back-to-top" class="back-to-top"><?php esc_html_e( 'Back to top &uarr;', 'boo-valley' ); ?></a>

			<?php else : ?>

				<?php

				// No need to apply wp_kses_post() on output as it is already validated via Customizer.

					echo (string) $site_info_text;

				?>

			<?php endif; ?>
		</div>

		<?php do_action( 'wmhook_boo_valley_site_info_after' ); ?>

	</div>
</div><!-- /footer-area-site-info -->
