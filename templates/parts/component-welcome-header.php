<?php
/**
 * Admin "Welcome" page content component
 *
 * Header.
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.2.0
 */





?>

<div class="wm-notes special">

	<h1>
		<?php

		printf(
			esc_html_x( 'Welcome to %1$s %2$s', '1: theme name, 2: theme version number.', 'boo-valley' ),
			'<strong>' . wp_get_theme( 'boo-valley' )->get( 'Name' ) . '</strong>',
			'<small>' . BOO_VALLEY_THEME_VERSION . '</small>'
		);

		?>
	</h1>

	<div class="welcome-text about-text">
		<?php

		printf(
			esc_html_x( 'Thank you for using %1$s WordPress theme by %2$s!', '1: theme name, 2: theme developer link.', 'boo-valley' ),
			'<strong>' . wp_get_theme( 'boo-valley' )->get( 'Name' ) . '</strong>',
			'<a href="' . esc_url( wp_get_theme( 'boo-valley' )->get( 'AuthorURI' ) ) . '" target="_blank"><strong>SulliDigital Design</strong></a>'
		);

		?>
		<br>
		<?php esc_html_e( 'Please take time to read the steps below to set up your website.', 'boo-valley' ); ?>
	</div>

	<p class="wm-actions">

		<a href="https://www.sullidigital.com/manual/boo-valley/" class="button button-primary button-hero" target="_blank"><?php esc_html_e( 'Theme Documentation', 'boo-valley' ); ?></a>

		<a href="https://www.sullidigital.com/reference/#links-support" class="button button-hero" target="_blank"><?php esc_html_e( 'Support Center', 'boo-valley' ); ?></a>

	</p>

</div>

<div class="welcome-content">
