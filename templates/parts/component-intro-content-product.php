<?php
/**
 * Page intro content for WooCommerce products
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.2.0
 */





// Helper variables

	$product = wc_setup_product_data( get_the_ID() );


?>

<?php woocommerce_breadcrumb(); ?>

<div class="product-title-price">
	<h1 class="product-title entry-title h1 intro-title"<?php Boo_Valley_Schema::get( 'itemprop="name"' ); ?>><?php single_post_title(); ?></h1>
	<p class="price"><?php echo $product->get_price_html(); ?></p>
</div>

<?php

/**
 * Product rating
 *
 * @see  woocommerce/templates/single-product/rating.php
 *
 * Modifications: Removed microformats and changed HTML.
 */

if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
	return;
}

$rating_count = $product->get_rating_count();

if ( ! $rating_count ) {
	return;
}

$average = $product->get_average_rating();

?>

<?php if ( comments_open() ) : ?>
<a href="#reviews" class="woocommerce-review-link star-rating" rel="nofollow" title="<?php printf( esc_attr__( 'Rated %s out of 5', 'boo-valley' ), $average ); ?>">
<?php else : ?>
<div class="woocommerce-review-link star-rating" title="<?php printf( esc_attr__( 'Rated %s out of 5', 'boo-valley' ), $average ); ?>">
<?php endif; ?>

	<span style="width: <?php echo $average / 5 * 100; ?>%;">
		<?php

		printf(
			esc_html__( '%s out of 5', 'boo-valley' ),
			'<strong class="rating">' . esc_html( $average ) . '</strong>'
		);

		printf(
			esc_html( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'boo-valley' ) ),
			'<span class="rating">' . $rating_count . '</span>'
		);

		?>
	</span>

<?php if ( comments_open() ) : ?>
</a>
<?php else : ?>
</div>
<?php endif; ?>
