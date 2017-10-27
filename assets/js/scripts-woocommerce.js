/**
 * Theme's WooCommerce frontend scripts
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.3.0
 *
 * Contents:
 *
 * 10) Adding to cart
 * 20) Tabs
 */





( function( $ ) {





	/**
	 * Cache
	 */

		var
			$body       = $( document.body ),
			$headerCart = $( document.getElementById( 'header-shopping-cart' ) );





	/**
	 * 10) Adding to cart
	 */

		// Displaying sticky header (with header cart) when product is added to cart

			if ( $body.hasClass( 'has-header-cart' ) ) {

				$body
					.on( 'adding_to_cart', function() {

						// Processing

							$body
								.addClass( 'scrolling-up' )
								.removeClass( 'scrolling-down' );

							$headerCart
								.addClass( 'focus' );

					} )
					.on( 'added_to_cart', function() {

						// Processing

							setTimeout( function() {

								$headerCart
									.removeClass( 'focus' );

							}, $headerCart.data( 'preview-delay' ) );

					} );

			}





	/**
	 * 20) Tabs
	 */

		// Add class of tabs count on tab selector wrapper

			$( '.woocommerce-tabs' )
				.addClass( function() {
					return 'tabs-count-' + $( this ).find( '.tabs li' ).length;
				} );

		// Apply additional classes and attributes into reviews pagination

			$( '#reviews .woocommerce-pagination' )
				.addClass( 'pagination' )
				.attr( 'data-current', function() {

					// Output

						return jQuery( this ).find( '.current' ).text();

				} )
				.attr( 'data-total', function() {

					// Output

						return jQuery( this ).find( '.page-numbers:not(.prev):not(.next)' ).length;

				} );

		// Product "More details" link tabs switching and smooth scroll to product tabs

			$body
				.on( 'click', 'a.product-description-link', function() {

					// Helper variables

						var
							$tabs = $( '.woocommerce-tabs' ),
							$tab  = $( '.description_tab a' );


					// Requirements check

						if ( ! $tabs.length ) {
							return false;
						}


					// Processing

						if ( $tab.length ) {

							$( '.description_tab a' )
								.trigger( 'click' );

						} else {

							$( '.additional_information_tab a' )
								.trigger( 'click' );

						}

						$( 'html, body' )
							.stop()
							.animate( {
								scrollTop : $tabs.offset().top - 100 + 'px'
							}, 600 );

				} )
				.on( 'click', 'a.woocommerce-review-link', function() {

					// Helper variables

						var
							$tabs = $( '.woocommerce-tabs' );


					// Requirements check

						if ( ! $tabs.length ) {
							return false;
						}


					// Processing

						$( 'html, body' )
							.stop()
							.animate( {
								scrollTop : $tabs.offset().top - 100 + 'px'
							}, 600 );

				} );





} )( jQuery );
