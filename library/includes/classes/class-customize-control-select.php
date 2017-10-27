<?php
/**
 * Customizer custom controls
 *
 * Customizer select field (with optgroups).
 *
 * @package     SulliDigital WordPress Theme Framework
 * @subpackage  Customize
 *
 * @since    1.0.0
 * @version  2.1.0
 */
class Boo_Valley_Customize_Control_Select extends WP_Customize_Control {

	public $type = 'select';



	public function render_content() {

		// Output

			if ( ! empty( $this->choices ) && is_array( $this->choices ) ) :

				?>

				<label>
					<span class="customize-control-title"><?php echo $this->label; ?></span>
					<?php if ( $this->description ) : ?><span class="description customize-control-description"><?php echo $this->description; ?></span><?php endif; ?>

					<select name="<?php echo $this->id; ?>" <?php $this->link(); ?>>
						<?php

						foreach ( $this->choices as $value => $name ) {

							if ( 0 === strpos( $value, 'optgroup' ) ) {
								echo '<optgroup label="' . esc_attr( $name ) . '">';
							} elseif ( 0 === strpos( $value, '/optgroup' ) ) {
								echo '</optgroup>';
							} else {
								echo '<option value="' . esc_attr( $value ) . '" ' . selected( $this->value(), $value, false ) . '>' . esc_html( $name ) . '</option>';
							}

						} // /foreach

						?>
					</select>
				</label>

				<?php

			endif;

	} // /render_content

} // /Boo_Valley_Customize_Control_Select
