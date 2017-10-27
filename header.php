<?php
/**
 * The header for our theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





/**
 * HTML
 */

	do_action( 'tha_html_before' );

?>

<html class="no-js" <?php language_attributes(); ?>>

<head>

<?php

/**
 * HTML head
 */

	do_action( 'tha_head_top' );

	do_action( 'tha_head_bottom' );

	wp_head();

?>

</head>


<body <?php body_class(); echo Boo_Valley_Schema::get( 'WebPage' ); ?>>

<?php

/**
 * Body
 */

	do_action( 'tha_body_top' );



/**
 * Header
 */

	if ( ! apply_filters( 'wmhook_boo_valley_disable_header', false ) ) {

		do_action( 'tha_header_before' );

		do_action( 'tha_header_top' );

		do_action( 'tha_header_bottom' );

		do_action( 'tha_header_after' );

	}



/**
 * Content
 */

	do_action( 'tha_content_before' );

	do_action( 'tha_content_top' );
