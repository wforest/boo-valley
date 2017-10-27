<?php
/**
 * WebMan WordPress Theme Framework
 *
 * Theme options with `__` prefix (`get_theme_mod( '__option_id' )`) are theme
 * setup related options and can not be edited via customizer.
 * This way we prevent creating additional options in the database.
 *
 * @copyright  Sulli Digital
 * @license    GPL-3.0, http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @link  https://github.com/webmandesign/webman-theme-framework
 * @link  http://www.webmandesign.eu
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Core
 *
 * @version  2.2.5
 *
 * Used global hooks:
 *
 * @uses  wmhook_boo_valley_theme_options
 * @uses  wmhook_boo_valley_esc_css
 * @uses  wmhook_boo_valley_custom_styles
 *
 * Used development prefixes:
 *
 * @uses theme_slug
 * @uses prefix_constant
 * @uses prefix_var
 * @uses prefix_class
 * @uses prefix_hook
 * @uses text_domain
 *
 * Contents:
 *
 * 10) Constants
 * 20) Load
 */





/**
 * 10) Constants
 */

	// Theme version

		if ( ! defined( 'BOO_VALLEY_THEME_VERSION' ) ) {
			define( 'BOO_VALLEY_THEME_VERSION', wp_get_theme( 'boo-valley' )->get( 'Version' ) );
		}

	// Paths

		if ( ! defined( 'BOO_VALLEY_PATH' ) ) {
			define( 'BOO_VALLEY_PATH', trailingslashit( get_template_directory() ) );
		}

		if ( ! defined( 'BOO_VALLEY_LIBRARY_DIR' ) ) {
			define( 'BOO_VALLEY_LIBRARY_DIR', trailingslashit( basename( dirname( __FILE__ ) ) ) );
		}

		define( 'BOO_VALLEY_LIBRARY', trailingslashit( BOO_VALLEY_PATH . BOO_VALLEY_LIBRARY_DIR ) );





/**
 * 20) Load
 */

	// Core class

		require BOO_VALLEY_LIBRARY . 'includes/classes/class-core.php';

	// Customize (has to be frontend accessible, otherwise it hides the theme settings)

		// Customize class

			require BOO_VALLEY_LIBRARY . 'includes/classes/class-customize.php';

		// CSS Styles Generator class

			require BOO_VALLEY_LIBRARY . 'includes/classes/class-customize-styles.php';

	// Admin

		if ( is_admin() ) {

			// Load the theme welcome page

				locate_template( 'includes/welcome/welcome.php', true );

			// Admin class

				require BOO_VALLEY_LIBRARY . 'includes/classes/class-admin.php';

			// Plugins suggestions

				if (
						apply_filters( 'wmhook_boo_valley_plugins_suggestion_enabled', true )
						&& locate_template( 'includes/tgmpa/plugins.php' )
					) {
					require BOO_VALLEY_LIBRARY . 'includes/vendor/tgmpa/class-tgm-plugin-activation.php';
					locate_template( 'includes/tgmpa/plugins.php', true );
				}

			// Child theme generator

				require BOO_VALLEY_LIBRARY . 'includes/vendor/use-child-theme/class-use-child-theme.php';

		}
