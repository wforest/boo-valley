<?php
/**
 * Admin "Welcome" page content component
 *
 * WP Filesystem info.
 *
 * @package    Boo Valley
 * @copyright  Sulli Digital
 *
 * @since    1.0.0
 * @version  1.0.0
 */





?>

<h3>
	<em>
		<strong>
			<?php esc_html_e( 'Important:', 'boo-valley' ); ?>
		</strong>
	</em>
</h3>

<p>
	<em>
		<?php esc_html_e( 'For the best performance, the theme generates a single CSS stylesheet file using WordPress native filesystem API.', 'boo-valley' ); ?>
		<?php esc_html_e( 'The file is being generated after saving theme customizer settings.', 'boo-valley' ); ?>
		<?php esc_html_e( 'If you notice an error message in WordPress dashboard after leaving the theme customizer, please check whether you should set up the FTP credentials in your "wp-config.php" file.', 'boo-valley' ); ?>
		<a href="http://codex.wordpress.org/Editing_wp-config.php#WordPress_Upgrade_Constants" target="_blank"><?php esc_html_e( 'In that case please read the instructions &raquo;', 'boo-valley' ); ?></a>
	</em>
</p>
