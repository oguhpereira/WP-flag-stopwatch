<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://oguhpereira.github.io/
 * @since      1.0.0
 *
 * @package    Flag_Stopwatch
 * @subpackage Flag_Stopwatch/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Flag_Stopwatch
 * @subpackage Flag_Stopwatch/includes
 * @author     oguhpereira <guhpereira@outlook.com.br>
 */
class Flag_Stopwatch_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'flag-stopwatch',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
