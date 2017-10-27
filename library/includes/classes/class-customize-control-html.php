<?php
/**
 * Customizer custom controls
 *
 * Customizer custom HTML.
 *
 * @package     SulliDigital WordPress Theme Framework
 * @subpackage  Customize
 *
 * @since    1.0.0
 * @version  1.9.0
 */
class Boo_Valley_Customize_Control_HTML extends WP_Customize_Control {

	public $type = 'html';

	public $content = '';



	public function render_content() {

		// Output

			if ( isset( $this->label ) && ! empty( $this->label ) ) {
				echo '<span class="customize-control-title">' . $this->label . '</span>';
			}

			if ( isset( $this->content ) ) {
				echo $this->content;
			} else {
				esc_html_e( 'Please set the `content` parameter for the HTML control.', 'boo-valley' );
			}

			if ( isset( $this->description ) && ! empty( $this->description ) ) {
				echo '<span class="description customize-control-description">' . $this->description . '</span>';
			}

	} // /render_content

} // /Boo_Valley_Customize_Control_HTML
