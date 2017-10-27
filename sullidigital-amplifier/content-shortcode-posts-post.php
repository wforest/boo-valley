<?php
/**
 * Posts shortcode item template
 *
 * Default post item template.
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 *
 * @uses  array $helper  Contains shortcode $atts array plus additional helper variables.
 */





?>

<div class="<?php echo $helper['item_class']; ?>">

	<?php

	if (
			get_post_format()
			&& file_exists( locate_template( 'templates/parts/content-' . get_post_format() . '.php' ) )
		) {

		include( locate_template( 'templates/parts/content-' . get_post_format() . '.php' ) );

	} else {

		include( locate_template( 'templates/parts/content.php' ) );

	}

	?>

</div>
