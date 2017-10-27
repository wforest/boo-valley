<?php
/**
 * Secondary widget area in site footer.
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.3.0
 */





// Requirements check

	if ( ! is_active_sidebar( 'footer-secondary' ) ) {
		return;
	}


?>

<div class="site-footer-area footer-area-footer-secondary-widgets">
	<div class="footer-secondary-widgets-inner site-footer-area-inner">

		<aside id="footer-secondary-widgets" class="widget-area footer-secondary-widgets" role="complementary" aria-label="<?php echo esc_attr_x( 'Footer secondary widgets', 'Sidebar aria label', 'boo-valley' ); ?>">

			<?php dynamic_sidebar( 'footer-secondary' ); ?>

		</aside>

	</div>
</div>
