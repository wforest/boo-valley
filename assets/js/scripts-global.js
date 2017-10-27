/**
 * Theme frontend scripts
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 *
 * Contents:
 *
 * 10) Basics
 * 20) Content
 */





( function( $ ) {





	/**
	 * 10) Basics
	 */

		var
			$breakpoints          = ( 'undefined' !== typeof $booValleyBreakpoints ) ? ( $booValleyBreakpoints ) : ( { 'xl' : 1280 } ),
			$simpleLayoutProjects = $( '.simple-layout .type-wm_projects' );



		/**
		 * Tell CSS that JS is enabled...
		 */

			$( '.no-js' )
				.removeClass( 'no-js' );



		/**
		 * Fixing Recent Comments widget multiple appearances
		 */

			$( '.widget_recent_comments ul' )
				.attr( 'id', '' );



		/**
		 * Back to top link
		 */

			if ( parseInt( $breakpoints['xl'] ) < window.innerWidth ) {

				$( '.back-to-top' )
					.on( 'click', function( e ) {

						// Processing

							e.preventDefault();

							$( 'html, body' )
								.animate( {
									scrollTop : 0
								}, 600 );

					} );

			}



		/**
		 * Responsive videos
		 */

			if ( $().fitVids ) {

				$( document.getElementById( 'page' ) )
					.fitVids();

			} // /fitVids





	/**
	 * 20) Content
	 */

		/**
		 * Comment form improvements
		 *
		 * Set input fields placeholders from field labels.
		 * Set textarea rows.
		 */

			$( document.getElementById( 'commentform' ) )
				.find( 'input[type="text"], input[type="email"], input[type="url"], textarea' )
					.each( function( index, el ) {

						// Helper variables

							var
								$this = $( el );


						// Processing

							$this
								.attr( 'placeholder', $this.prev( 'label' ).text() )
								.prev( 'label' )
									.addClass( 'screen-reader-text' );

					} )
				.end()
				.find( 'textarea' )
					.attr( 'rows', 4 );



		/**
		 * Simple projects layout focus
		 */

			$simpleLayoutProjects
				.on( 'focus.aria mouseenter.aria', 'a', function( e ) {

					// Processing

						$( this )
							.closest( '.type-wm_projects' )
								.addClass( 'focus' );

				} )
				.on( 'blur.aria mouseleave.aria', 'a', function( e ) {

					// Processing

						$( this )
							.closest( '.type-wm_projects' )
								.removeClass( 'focus' );

				} );





} )( jQuery );
