<?php
/**
 * Admin "Welcome" page content component
 *
 * Demo content installation.
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.1
 */





?>

<div class="wm-notes special">

	<h2 class="mt0"><strong><?php esc_html_e( 'Installing the theme demo content', 'boo-valley' ); ?></strong></h2>

	<p>
		<?php esc_html_e( 'You can install the theme demo content including pages, posts, custom post types, layouts, menus and widgets directly from your WordPress dashboard by clicking the button bellow.', 'boo-valley' ); ?>
	</p>

	<p>
		<?php esc_html_e( 'Alternatively (such as when the automated installation fails) you can follow theme documentation instructions for manual demo content installation.', 'boo-valley' ); ?>
		<a href="https://www.sullidigital.com/manual/boo-valley/#demo-content" target="_blank"><?php esc_html_e( 'Read the instructions &raquo;', 'boo-valley' ); ?></a>
	</p>

	<?php if ( ! ( class_exists( 'OCDI_Plugin' ) || class_exists( 'PT_One_Click_Demo_Import' ) ) ) : ?>

		<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-hero"><strong><?php esc_html_e( 'Install and run "One Click Demo Import" plugin', 'boo-valley' ); ?></strong></a>

	<?php else : ?>

		<a href="<?php echo esc_url( 'themes.php?page=pt-one-click-demo-import' ); ?>" class="button button-hero button-primary"><strong><?php esc_html_e( 'Install theme demo content', 'boo-valley' ); ?></strong></a>

		<br>
		<small><em>
			<?php esc_html_e( 'Or head over to Appearance &raquo; Import Demo Data to start the import process.', 'boo-valley' ); ?>
		</em></small>

	<?php endif; ?>

</div>
