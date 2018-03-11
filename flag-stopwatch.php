<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://oguhpereira.github.io/
 * @since             1.0.0
 * @package           Flag_Stopwatch
 *
 * @wordpress-plugin
 * Plugin Name:       Flag stopwatch
 * Plugin URI:        onlinesites.com.br
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            oguhpereira
 * Author URI:        https://oguhpereira.github.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       flag-stopwatch
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-flag-stopwatch-activator.php
 */
function activate_flag_stopwatch() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flag-stopwatch-activator.php';
	Flag_Stopwatch_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-flag-stopwatch-deactivator.php
 */
function deactivate_flag_stopwatch() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flag-stopwatch-deactivator.php';
	Flag_Stopwatch_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_flag_stopwatch' );
register_deactivation_hook( __FILE__, 'deactivate_flag_stopwatch' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-flag-stopwatch.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_flag_stopwatch() {

	$plugin = new Flag_Stopwatch();
	$plugin->run();

}
run_flag_stopwatch();
add_action('admin_menu', 'test_plugin_setup_menu');
function test_plugin_setup_menu(){
	add_menu_page( 'Crônometro', 'Crônometro', 'manage_options', 'test-plugin', 'test_init' );
	add_action( 'admin_init', 'register_my_cool_plugin_settings' );
}

function register_my_cool_plugin_settings() {
	//register our settings
	register_setting( 'my-cool-plugin-settings-group', 'date_stop' );
	register_setting( 'my-cool-plugin-settings-group', 'image_attachment_id' );
}
function test_init(){
	settings_fields( 'my-cool-plugin-settings-group' );
    do_settings_sections( 'my-cool-plugin-settings-group' );
	echo "<h1>Configurações do Cronometro</h1>";
	echo "<h2>Defina o tempo desejado de seu crônometro.</h2>";
	// Save attachment ID
	if ( isset( $_POST['submit_image_selector'] ) && isset( $_POST['image_attachment_id'] ) ) :
		update_option( 'media_selector_attachment_id', absint( $_POST['image_attachment_id'] ) );
	endif;
	wp_enqueue_media();
	?>
	<form method="post" action="options.php">
    <?php settings_fields( 'my-cool-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'my-cool-plugin-settings-group' ); ?>
    <table class="form-table">

         
        <tr valign="top">
        <td style="width: 10%;";><label for="date_stop">Data Final :</label></td>
        <td><input id="date_stop"type="date" name="date_stop" value="<?php echo esc_attr( get_option('date_stop') ); ?>" /></td>
		<td><input type='hidden' name='image_attachment_id' id='image_attachment_id' value='<?php echo get_option( 'image_attachment_id' ); ?>'></td>

        </tr>
       
    </table>
    
	

		<h2>Defina a imagem de banner</h2>
		<div class='image-preview-wrapper'>
			<img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'image_attachment_id' ) ); ?>' height='100'>
		</div>

		<br/>
		<input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
		<input id="remove_image_text_button" type="button" class="button" value="<?php _e( 'Remover Crônometro' ); ?>" />
	
		<input type="submit" name="submit_image_selector" value="Save" class="button-primary">
	</form>
	
	<?php
}



add_action( 'admin_footer', 'media_selector_print_scripts' );

function media_selector_print_scripts() {
	$my_saved_attachment_post_id =  esc_attr( get_option('image_attachment_id') )==null?0:esc_attr( get_option('image_attachment_id') );
	?><script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
			jQuery('#upload_image_button').on('click', function( event ){
				event.preventDefault();
				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}
				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});
				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();
					// Do something with attachment.id and/or attachment.url here
					$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					$( '#image_attachment_id' ).val( attachment.id );
					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});
					// Finally, open the modal
					file_frame.open();
			});
			jQuery('#remove_image_text_button').on('click', function( event ){
				event.preventDefault();
				// If the media frame already exists, reopen it.
				$( '#image-preview' ).attr( 'src',"" ).css( 'width', 'auto' );
				$( '#image_attachment_id' ).val("");
				// Restore the main post ID
				wp.media.model.settings.post.id = null;
				$('#date_start').val(null);
				$('#date_stop').val(null);
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
				
			});
		});
	</script><?php
}