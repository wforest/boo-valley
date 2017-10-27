<?php
/**
 * Breadcrumbs content
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.1.0
 * @version  1.1.1
 */





// Requirements check

	if (
			! function_exists( 'bcn_display' )
			|| is_front_page()
			|| apply_filters( 'wmhook_boo_valley_breadcrumb_navxt_disabled', false )
		) {
		return;
	}


// Helper variables

	$unique_id = uniqid();


?>

<?php do_action( 'wmhook_boo_valley_breadcrumb_navxt_before' ); ?>

<div class="breadcrumbs-container">
	<nav class="breadcrumbs" aria-labelledby="breadcrumbs-label-<?php echo esc_attr( $unique_id ); ?>"<?php echo Boo_Valley_Schema::get( 'BreadcrumbList' ); ?>>

		<h2 class="screen-reader-text" id="breadcrumbs-label-<?php echo esc_attr( $unique_id ); ?>"><?php esc_attr_e( 'Breadcrumbs navigation', 'boo-valley' ); ?></h2>

		<?php bcn_display(); ?>

	</nav>
</div>

<?php do_action( 'wmhook_boo_valley_breadcrumb_navxt_after' ); ?>
