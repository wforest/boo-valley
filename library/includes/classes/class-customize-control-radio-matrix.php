<?php
/**
 * Customizer custom controls
 *
 * Customizer matrix radio fields.
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Customize
 *
 * @since    1.0.0
 * @version  2.1.0
 */
class Boo_Valley_Customize_Control_Radio_Matrix extends WP_Customize_Control {

	public $type = 'radiomatrix';

	public $class = '';



	public function enqueue() {

		// Processing

			// Scripts

				wp_enqueue_script(
						'boo_valley-customize-control-radio-matrix',
						get_theme_file_uri( BOO_VALLEY_LIBRARY_DIR . 'js/customize-control-radio-matrix.js' ),
						array( 'customize-controls' ),
						esc_attr( BOO_VALLEY_THEME_VERSION ),
						true
					);

	} // /enqueue



	public function render_content() {

		// Output

			if ( ! empty( $this->choices ) && is_array( $this->choices ) ) :

				?>

				<span class="customize-control-title"><?php echo $this->label; ?></span>
				<?php if ( $this->description ) : ?><span class="description customize-control-description"><?php echo $this->description; ?></span><?php endif; ?>

				<div class="<?php echo trim( 'custom-radio-container ' . $this->class ); ?>">
					<?php

					$i = 0;

					foreach ( $this->choices as $value => $name ) {

						$checked      = checked( $this->value(), $value, false );
						$active_class = ( $checked ) ? ( ' class="active"' ) : ( '' );

						if ( is_array( $name ) ) {
							$title = ' title="' . esc_attr( $name[0] ) . '"';
							$name  = $name[1];
						} else {
							$title = ' title="' . esc_attr( wp_strip_all_tags( $name ) ) . '"';
						}

						?>

						<label for="<?php echo esc_attr( $this->id . ++$i ); ?>"<?php echo $active_class . $title; ?>>
							<?php echo $name; ?>
							<input class="custom-radio-item" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id . $i ); ?>" <?php echo $this->get_link() . $checked; ?> />
						</label>

						<?php

					} // /foreach

					?>
				</div>

				<?php

			endif;

	} // /render_content

} // /Boo_Valley_Customize_Control_Radio_Matrix
