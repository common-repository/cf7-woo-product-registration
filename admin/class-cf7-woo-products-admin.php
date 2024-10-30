<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.howardehrenberg.com
 * @since      1.0.0
 *
 * @package    Cf7_Woo_Products
 * @subpackage Cf7_Woo_Products/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cf7_Woo_Products
 * @subpackage Cf7_Woo_Products/admin
 * @author     Howard Ehrenberg <howard@howardehrenberg.com>
 */
class Cf7_Woo_Products_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->include_admin_classes();
        $this->include_metaboxes();
        new dd_cf7_wc_formtags;
        new Cf7_woo_products_settings;

	}

    /**
	 * Include the Additional Functions for Admin
	 *
	 * @since    1.0.0
	 */
    
    private function include_admin_classes() {
        include_once( plugin_dir_path(__FILE__) . 'class-cf7-woo-products-cf7.php');
        include_once( plugin_dir_path(__FILE__) . 'class-cf7-woo-products-settings.php');
        include_once( plugin_dir_path(__FILE__) . 'class-cf7-woo-products-metaboxes.php');
    }

    private function include_metaboxes(){
        $options = get_option( 'cf7_wc_products' );
        if (false !== $options && $options['choose_type'] === 'registrable'){
            new Cf7_Woo_Products_Metaboxes;
        }
    }
    public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/cf7-woo-products-admin.min.js', array('jquery'), $this->version, true );

    }
    
}
