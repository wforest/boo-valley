<?php
/**
 * Widget area displayed on single product page.
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.3.0
 */





// Requirements check

	if ( ! is_active_sidebar( 'product' ) ) {
		return;
	}


?>

<div class="product-widgets-container">
	<div class="product-widgets-inner">

		<aside id="product-widgets" class="widget-area product-widgets" role="complementary" aria-labelledby="sidebar-product-label">

			<h2 class="screen-reader-text" id="sidebar-product-label"><?php echo esc_html_x( 'Product sidebar', 'Sidebar aria label', 'boo-valley' ); ?></h2>

			<?php dynamic_sidebar( 'product' ); ?>

		</aside>

	</div>
</div>
