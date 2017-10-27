<?php
/**
 * Widget area in site header.
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.3.0
 */





// Requirements check

	if ( ! is_active_sidebar( 'header' ) ) {
		return;
	}


?>

<div class="header-widgets-container">

	<aside id="header-widgets" class="widget-area header-widgets" role="complementary" aria-label="<?php echo esc_attr_x( 'Header widgets', 'Sidebar aria label', 'boo-valley' ); ?>">

		<?php dynamic_sidebar( 'header' ); ?>

	</aside>

</div>
