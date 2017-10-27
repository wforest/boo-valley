<?php
/**
 * Beaver Builder: Helpers Class
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.2.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Is page builder active?
 */
class Boo_Valley_Beaver_Builder_Helpers {





	/**
	 * 0) Init
	 */

		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		private function __construct() {}





	/**
	 * 10) Is page builder enabled?
	 */

		/**
		 * Is page builder enabled on single post?
		 *
		 * @since    1.1.0
		 * @version  1.1.0
		 */
		public static function is_builder_enabled() {

			// Processing

				if (
						! Boo_Valley_Post::is_singular()
						|| ! is_callable( 'FLBuilderModel::is_builder_enabled' )
					) {
					return false;
				}


			// Output

				return FLBuilderModel::is_builder_enabled();

		} // /is_builder_enabled





} // /Boo_Valley_Beaver_Builder_Helpers
