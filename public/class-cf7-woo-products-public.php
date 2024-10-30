<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.howardehrenberg.com
 * @since      1.0.0
 *
 * @package    Cf7_Woo_Products
 * @subpackage Cf7_Woo_Products/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cf7_Woo_Products
 * @subpackage Cf7_Woo_Products/public
 * @author     Howard Ehrenberg <howard@duckdiverllc.com>
 */
class Cf7_Woo_Products_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->public_includes();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cf7-woo-products-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cf7-woo-products-public.js', array( 'jquery' ), $this->version, false );
        $options = get_option( 'cf7_wc_products' );
        $select2 = (isset($options['include_select2'])) ? 'true' : 'false';
        $cat_placeholder = isset( $options['category-placeholder'] ) ? $options['category-placeholder'] : '- - Choose Category - -';
        $placeholder = (isset($options['placeholder_text'])) ? $options['placeholder_text'] : '- - Choose Your Product --';
        wp_localize_script( $this->plugin_name, 'dd_cf7_ajax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'select2' => $select2,
            'cat_placeholder' => $cat_placeholder,
            'placeholder' => $placeholder,
        ));

	}

	private function public_includes() {

	    require_once (plugin_dir_path(__FILE__) . 'class-cf7-woo-products-contact-form.php');
        new Cf7_Woo_Products_Public_CF7;

    }

}
