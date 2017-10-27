/**
 * Apply scrolling body classes only
 *
 * Use this script only if not using sticky navigation one.
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

	if ( parseInt( $breakpoints['xl'] ) < window.innerWidth ) {





		/**
		 * Cache and variables
		 */

			var
				$window        = $( window ),
				$body          = $( 'body' ),
				$didScroll     = false,
				$lastScrollTop = 0,
				$screenResized = true;



		/**
		 * Do on browser window scroll
		 *
		 * Reset on browser window resize.
		 */

			$window
				.on( 'resize orientationchange', function( e ) {

					// Processing

						$didScroll     = false;
						$lastScrollTop = 0;
						$screenResized = true;

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

					if ( $st < ( 5 - $window.scrollTop() ) ) {

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

				// Setting up global vars

					$lastScrollTop = $st;
					$screenResized = false;

		} // /hasScrolled





	}

} )( jQuery );
