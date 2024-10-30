<?php
add_filter( 'plugin_action_links', 'dd_cf7_wc_products_action_links', 10, 5 );
function dd_cf7_wc_products_action_links( $actions, $plugin_file ) {
	static $plugin;
    
	if (!isset($plugin))
		$plugin = 'cf7-woo-products/cf7-woo-products.php';

    if ($plugin == $plugin_file) {

			$settings = array('settings' => '<a href="options-general.php?page=cf7-wc-products">' . __('Settings', 'General') . '</a>');
		
            $actions = array_merge($settings, $actions);
			
		}
		
		return $actions;
}

add_filter( 'plugin_row_meta', 'dd_cf7_wc_plugin_row_meta', 10, 2 );

function dd_cf7_wc_plugin_row_meta( $links, $file ) {

	if ( strpos( $file, 'cf7-woo-products.php' ) !== false ) {
		$new_links = array(
				'settings' => '<a href="'.admin_url('options-general.php?page=cf7-wc-products').'" title="Settings">Settings</a>',
		        'donate' => '<a href="https://www.duckdiverllc.com/easy-product-reg…h-contact-form-7/" target="_blank">Donate</a>',
                //'doc' => '<a href="doc_url" target="_blank">Documentation</a>'
				);
		
		$links = array_merge( $links, $new_links );
	}
	
	return $links;
}