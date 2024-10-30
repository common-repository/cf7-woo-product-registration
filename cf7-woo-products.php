<?php
/**
 *
 * @link              https://www.howardehrenberg.com
 * @since             1.0.0
 * @package           Cf7_Woo_Products
 *
 * @wordpress-plugin
 * Plugin Name:       CF7 Woo Product Registration
 * Plugin URI:        https://www.duckdiverllc.com
 * Description:       Easily create a Product Registration form or RMA form for WooCommerce products.  Requires Contact Form 7
 * Version:           1.1.1
 * Author:            Howard Ehrenberg
 * Author URI:        https://www.howardehrenberg.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cf7-woo-products
 * Domain Path:       /languages
 * WC requires at least: 3.0
 * WC tested up to: 5.0
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
define( 'CF7_WC_PRODUCTS_VERSION', '1.1.1' );

include plugin_dir_path( __FILE__) . 'vendor/admin-notices/AdminNotice.php';
Use YeEasyAdminNotices\V1\AdminNotice;

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cf7-woo-products-activator.php
 */
function activate_cf7_woo_products() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cf7-woo-products-activator.php';
    Cf7_Woo_Products_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cf7-woo-products-deactivator.php
 */
function deactivate_cf7_woo_products() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cf7-woo-products-deactivator.php';
    Cf7_Woo_Products_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cf7_woo_products' );
register_deactivation_hook( __FILE__, 'deactivate_cf7_woo_products' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cf7-woo-products.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cf7_woo_products() {

    $plugin = new Cf7_Woo_Products();
    $plugin->run();

}
run_cf7_woo_products();

/**
 * Include Plugin Admin Stuff
 *
 * @since    1.0.0
 */

if ( is_admin() ) {
    require_once plugin_dir_path( __FILE__ ) . 'admin/admin-functions.php';
}

/**
 * Verify and Check that both WooCommerce and Contact Form 7 is active
 *
 * @since    1.0.0
 */

class dd_check_wc_cf7 {
    function __construct(){
       add_action('admin_notices', array($this, 'on_admin_notices' ) );
    }
    function on_admin_notices(){
        if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) || (!is_plugin_active('contact-form-7/wp-contact-form-7.php'))  ) {
            echo '<div class="error"><p>' . __('CF7 Woo Product Registration needs both  plugins Contact Form 7 and WooCommerce to be active.', 'cf7-woo-products') . '</p></div>';
        }
    }
}
new dd_check_wc_cf7;

$url = admin_url('options-general.php?page=cf7-wc-products');

AdminNotice::create('activate_dd_cf7_woo')
    ->info()
    ->html('<strong>CF7 Woo Product Registration</strong>: Go to <a href="'.$url.'">Settings -&gt; CF7 / Woo Settings</a> to configure the plugin.')
    ->persistentlyDismissible(AdminNotice::DISMISS_PER_SITE)
    ->onPage('plugins')
    ->show();
