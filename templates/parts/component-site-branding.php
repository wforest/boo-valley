<?php
/**
 * Displays header site branding
 *
 * On front page uses H1 for (unlinked) site title.
 * On subpage uses accessibly hidden H2 for HTML body title
 * and paragraph for linked site title.
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.3.0
 */





// Helper variables

	$site_description = get_bloginfo( 'description', 'display' );


?>

<div class="site-branding"<?php echo Boo_Valley_Schema::get( 'Brand' ); ?>>

	<?php

	if ( -1 === get_theme_mod( 'custom_logo' ) ) {

		/**
		 * Default theme logo image fallback
		 *
		 * HTML was taken from WordPress native `the_custom_logo()` function.
		 * Hard-coding microformats here as this is a demo logo anyway.
		 */
		$logo_image_svg = '';

		ob_start();
		locate_template( 'assets/images/svg/boo-valley-logo.svg', true );
		$logo_image_svg = str_replace( '<svg ', '<svg class="custom-logo" itemprop="logo"', ob_get_clean() );

		printf(
				'<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
				esc_url( home_url( '/' ) ),
				$logo_image_svg
			);

	} else {

		the_custom_logo();

	}

	?>

	<div class="site-branding-text">

		<?php if ( is_front_page() ) : ?>
			<h1 class="site-title site-title-text"<?php echo Boo_Valley_Schema::get( 'itemprop="name"' ); ?>><?php bloginfo( 'name' ); ?></h1>
		<?php else : ?>
			<h2 class="screen-reader-text"><?php echo wp_get_document_title(); ?></h2>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title-text" rel="home"<?php echo Boo_Valley_Schema::get( 'itemprop="name"' ); ?>><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>

		<?php if ( $site_description || is_customize_preview() ) : ?>
			<p class="site-description"<?php echo Boo_Valley_Schema::get( 'itemprop="description"' ); ?>><?php echo $site_description; ?></p>
		<?php endif; ?>

	</div>

</div>
