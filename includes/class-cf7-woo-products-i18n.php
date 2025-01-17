<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.howardehrenberg.com
 * @since      1.0.0
 *
 * @package    Cf7_Woo_Products
 * @subpackage Cf7_Woo_Products/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cf7_Woo_Products
 * @subpackage Cf7_Woo_Products/includes
 * @author     Howard Ehrenberg <howard@howardehrenberg.com>
 */
class Cf7_Woo_Products_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cf7-woo-products',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
