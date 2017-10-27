/**
 * Sticky header and row
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





( function( $ ) {

	var
		$breakpoints = ( 'undefined' !== typeof $booValleyBreakpoints ) ? ( $booValleyBreakpoints ) : ( { 'xl' : 1280 } );

	if (
			$( 'body' ).hasClass( 'has-sticky-header' )
			&& parseInt( $breakpoints['xl'] ) < window.innerWidth
		) {





		/**
		 * Scrolling classes on BODY
		 */

			/**
			 * Cache and variables
			 */

				var
					$window                 = $( window ),
					$body                   = $( 'body' ),
					$didScroll              = false,
					$lastScrollTop          = 0,
					$headerHeightMultiplier = .5,
					$header                 = $( document.getElementById( 'masthead' ) ),
					$headerHeight           = 0,
					$headerOffset           = 0,
					$scrollingOffset        = 0,
					$screenResized          = true,
					$headerPlaceholder      = $( '<div id="site-header-placeholder" class="site-header-placeholder" />' ).insertBefore( '#masthead' );



			/**
			 * Fire on browser window scroll
			 *
			 * Reset on browser window resize.
			 */

				$window
					.on( 'load', function() {

						// Helper variables

							$headerHeight    = $header.outerHeight();
							$headerOffset    = $header.offset();
							$scrollingOffset = $headerHeight * $headerHeightMultiplier + $headerOffset.top - $window.scrollTop();

						// Processing

							$headerPlaceholder
								.css( 'height', $headerHeight );

					} )
					.on( 'resize orientationchange', function( e ) {

						// Processing

							$didScroll       = false;
							$lastScrollTop   = 0;
							$headerHeight    = $header.outerHeight();
							$scrollingOffset = $headerHeight * $headerHeightMultiplier + $headerOffset.top;
							$screenResized   = true;

					} )
					.on( 'scroll', function( e ) {

						// Processing

							$didScroll = true;

					} );

				setInterval( function() {

					// Processing

						// Fixing Chrome inline styles after JavaScript loaded

							$( '#masthead[style]' )
								.removeAttr( 'style' );

						// Scrolling actions

							if ( $didScroll ) {

								hasScrolled();

								$didScroll = false;

							}

				}, 250 );



			/**
			 * Actions when scrolling screen
			 */
			function hasScrolled() {

				// Requirements check

					if (
							$screenResized
							&& parseInt( $breakpoints['xl'] ) > window.innerWidth
						) {
						return;
					}


				// Helper variables

					var
						$st = $window.scrollTop();


				// Processing

					// Do nothing and remove the scrolling class when not scrolled enough

						if ( $st < $scrollingOffset || $st < 5 ) {

							$body
								.removeClass( 'scrolling-up scrolling-down has-scrolled' );

							// Setting up global vars

								$lastScrollTop = $st;
								$screenResized = false;

							return;

						}

					// Apply the scrolling class

						$body
							.addClass( 'has-scrolled' );

						if ( $st < $lastScrollTop ) {

							$body
								.addClass( 'scrolling-up' )
								.removeClass( 'scrolling-down' );

						} else {

							$body
								.removeClass( 'scrolling-up' )
								.addClass( 'scrolling-down' );

						}

					// Setting sticky header placeholder height

						$headerPlaceholder
							.css( 'height', $headerHeight );

					// Setting up global vars

						$lastScrollTop = $st;
						$screenResized = false;

			} // /hasScrolled





	}

} )( jQuery );
