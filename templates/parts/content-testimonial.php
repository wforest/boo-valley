<?php
/**
 * Testimonial post content for archives
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





echo do_shortcode( '[wm_testimonials testimonial="' . get_the_ID() . '" heading_tag="h2" class="entry" /]' );
