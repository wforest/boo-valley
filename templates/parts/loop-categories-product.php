<?php
/**
 * WooCommerce product categories loop
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	$taxonomy = 'product_cat';

	$args = array( 'parent' => 0 );

	if ( is_tax( $taxonomy ) ) {
		$args['parent'] = get_queried_object_id();
	}

	$terms = get_terms( $taxonomy, $args );


// Requirements check

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return;
	}


?>

<h2 class="screen-reader-text"><?php esc_html_e( 'List of categories', 'boo-valley' ); ?></h2>

<ul class="products products-categories">
	<?php

	foreach ( $terms as $term ) {
		wc_get_template( 'content-product_cat.php', array(
				'category' => $term,
			) );
	}

	?>
</ul>
