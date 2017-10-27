/**
 * Masonry layouts
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.1.0
 */





( function( $ ) {

	if ( $().masonry ) {





		/**
		 * Masonry posts
		 */

			var
				$postsContainers = $( '.posts' );

			$postsContainers
				.imagesLoaded( function() {

					// Processing

						$postsContainers
							.masonry( {
								itemSelector    : '.entry',
								percentPosition : true,
								isOriginLeft    : ( 'rtl' !== $( 'html' ).attr( 'dir' ) )
							} );

				} );



			/**
			 * Jetpack Infinite Scroll posts loading
			 */

				$( document.body )
					.on( 'post-load', function() {

						// Processing

							$postsContainers
								.imagesLoaded( function() {

									// Processing

										$postsContainers
											.masonry( 'reload' );

								} );

					} );





	} // /masonry

} )( jQuery );
