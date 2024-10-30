<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.howardehrenberg.com
 * @since      1.0.0
 *
 * @package    Cf7_Woo_Products
 * @subpackage Cf7_Woo_Products/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cf7_Woo_Products
 * @subpackage Cf7_Woo_Products/includes
 * @author     Howard Ehrenberg <howard@howardehrenberg.com>
 */
class Cf7_Woo_Products_Activator {

	/**
	 * Activation Hook
	 *
	 * Set some defatult options
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

	    if (false === get_option( 'cf7_wc_products' )){
	        update_option('cf7_wc_products', array (
                'choose_type' => 'exclude',
                'category-placeholder' => '- - Choose Category - -',
                'show_other_text' => "My product isn't listed",
                'other_margin_top' => '.8rem',
                'placeholder_text' => ' - - Choose Your Product - -',
                'validation_text' => 'You must choose a product',
            ) );

	    }

	}

}
