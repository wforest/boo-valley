<?php
/**
 * Template Name: No intro
 * Template Post Type: page, post, wm_projects, wm_staff, product, jetpack-portfolio
 *
 * Removes page intro.
 * Other than that it is normal page (or post, or custom post type).
 *
 * @see  includes/custom-header/custom-header.php
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.4.3
 */

/* translators: Custom page template name. */
__( 'No intro', 'boo-valley' );





if ( is_page() ) {
	get_template_part( 'page' );
} else {
	get_template_part( 'single', get_post_type() );
}
