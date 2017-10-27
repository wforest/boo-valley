<?php
/**
 * Posts shortcode item template
 *
 * Default wm_staff item template.
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

	<?php include( locate_template( 'templates/parts/content-staff.php' ) ); ?>

</div>
