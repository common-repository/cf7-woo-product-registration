<?php 
/**
 * Comments
 *
 * @since    1.0.0
 */

class Cf7_woo_products_settings {

	public function __construct() {

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'init_settings'  ) );

	}

	public function add_admin_menu() {

		add_options_page(
			esc_html__( 'CF7 WooCommerce Product Settings', 'cf7-woo-products' ),
			esc_html__( 'CF7 / Woo Settings', 'cf7-woo-products' ),
			'manage_options',
			'cf7-wc-products',
			array( $this, 'dd_cf7_wc_settings_callback' )
		);

	}

	public function init_settings() {

		register_setting(
			'cf7_woo_plugin_settings',
			'cf7_wc_products'
		);

		add_settings_section(
			'cf7_wc_products_section',
			'',
			false,
			'cf7_wc_products'
		);
        add_settings_field(
			'choose_type',
			__( 'Include or Exclude', 'cf7-woo-products' ),
			array( $this, 'render_choose_type_field' ),
			'cf7_wc_products',
			'cf7_wc_products_section'
		);

		add_settings_field(
			'wc_product_cats',
			__( 'Choose the Product Categories', 'cf7-woo-products' ),
			array( $this, 'render_wc_product_cats_field' ),
			'cf7_wc_products',
			'cf7_wc_products_section'
		);
		add_settings_field(
			'category_select',
			__( 'Choose Categories on Form', 'cf7-woo-products' ),
			array( $this, 'render_category_select_field' ),
			'cf7_wc_products',
			'cf7_wc_products_section'
		);

		add_settings_field(
			'category-placeholder',
			__( 'Choose Category Placeholder Text', 'cf7-woo-products' ),
			array( $this, 'render_category_placeholder_field' ),
			'cf7_wc_products',
			'cf7_wc_products_section'
		);

		add_settings_field(
			'include_select2',
			__( 'Include Select 2 on Front End', 'cf7-woo-products' ),
			array( $this, 'render_include_select2_field' ),
			'cf7_wc_products',
			'cf7_wc_products_section'
		);
		add_settings_field(
			'show_other',
			__( 'Show Other Product', 'cf7-woo-products' ),
			array( $this, 'render_show_other_field' ),
			'cf7_wc_products',
			'cf7_wc_products_section'
		);
		add_settings_field(
			'show_other_text',
			__( 'Product Not Listed Text', 'cf7-woo-products' ),
			array( $this, 'render_show_other_text' ),
			'cf7_wc_products',
			'cf7_wc_products_section'
		);
		add_settings_field(
			'other_margin_top',
			__( 'Other Text Top Margin', 'cf7-woo-products' ),
			array( $this, 'render_other_margin_top' ),
			'cf7_wc_products',
			'cf7_wc_products_section'
		);
		add_settings_field(
			'set_placeholder',
			__( 'Set Placeholder Text', 'cf7-woo-products' ),
			array( $this, 'render_set_placeholder_text' ),
			'cf7_wc_products',
			'cf7_wc_products_section'
		);
        add_settings_field(
			'validation_text',
			__( 'Validation Text', 'cf7-woo-products' ),
			array( $this, 'render_validation_text' ),
			'cf7_wc_products',
			'cf7_wc_products_section'
		);
	}

	public function dd_cf7_wc_settings_callback() {

		// Check required user capability
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'cf7-woo-products' ) );
		}

		// Admin Page Layout
		echo '<div class="wrap">' . "\n";
		echo '	<h1>' . get_admin_page_title() . '</h1>' . "\n";
        echo '	<p>Default settings are to exclude none of the product categories, which shows all WooCommerce products in the form field.</p>' . "\n";
		echo '	<form action="options.php" method="post">' . "\n";

		settings_fields( 'cf7_woo_plugin_settings' );
		do_settings_sections( 'cf7_wc_products' );
		submit_button();

		echo '	</form>' . "\n";
		echo '</div>' . "\n";

	}

	function render_wc_product_cats_field() {
		// Retrieve data from the database.
		$options = get_option( 'cf7_wc_products' );

		// Set default value.

        $value = isset( $options['wc_product_cats'] ) ? $options['wc_product_cats'] : array();
        
        $product_categories = get_terms( 'product_cat');
  
		foreach ($product_categories as $cats) {
                // Field output.
		  echo '<input type="checkbox" name="cf7_wc_products[wc_product_cats][]" class="wc_product_cats_field" value="' . esc_attr( $cats->term_id ) . '" ' . ( in_array( $cats->term_id , $value )? 'checked="checked"' : '' ) . '> ' . __( $cats->name , 'cf7-woo-products' ) . '<br>';
        }

		echo '<p class="description">' . __( 'Select the product categories to be available to the form tag.', 'cf7-woo-products' ) . '</p>';

	}
    function render_choose_type_field() {

		// Retrieve data from the database.
		$options = get_option( 'cf7_wc_products' );

		// Set default value.
		$value = isset( $options['choose_type'] ) ? $options['choose_type'] : 'exclude';
		// Field output.
		echo '<input type="radio" name="cf7_wc_products[choose_type]" class="choose_type_field" value="' . esc_attr( 'include' ) . '" ' . checked( $value, 'include', false ) . '> ' . __( 'Include', 'cf7-woo-products' ) . '<br>';
		echo '<input type="radio" name="cf7_wc_products[choose_type]" class="choose_type_field" value="' . esc_attr( 'exclude' ) . '" ' . checked( $value, 'exclude', false ) . '> ' . __( 'Exclude', 'cf7-woo-products' ) . '<br>';
        // TODO: Add method for registrable products
		//		echo '<input type="radio" name="cf7_wc_products[choose_type]" id="registrable" class="choose_type_field" value="' . esc_attr( 'registrable' ) . '" ' . checked( $value, 'registrable', false ) . '> ' . __( 'Only Registrable Products. This will add a checkbox to the product admin page.', 'cf7-woo-products' ) . '<br>';
        //		echo '<p class="description">' . __( 'Choose how the filter should operate. Do you want to include only the checked categories, or exclude the checked categories.', 'cf7-woo-products' ) . '</p>';

	}

	function render_include_select2_field() {

		// Retrieve data from the database.
		$options = get_option( 'cf7_wc_products' );

		// Set default value.
		$value = isset( $options['include_select2'] ) ? $options['include_select2'] : '';

		// Field output.
		echo '<input type="checkbox" name="cf7_wc_products[include_select2]" class="include_select2_field" value="checked" ' . checked( $value, 'checked', false ) . '> ' . __( '', 'cf7-woo-products' );
		echo '<span class="description">' . __( 'Choosing yes will include <a href="https://select2.org/getting-started/basic-usage" target="_blank">Select2 jQuery</a> (from the WooCommerce Package) on Frontend', 'cf7-woo-products' ) . '</span>';

	}

    function render_category_select_field() {

        // Retrieve data from the database.
        $options = get_option( 'cf7_wc_products' );

        // Set default value.
        $value = isset( $options['category_select'] ) ? $options['category_select'] : '';

        // Field output.
        echo '<input type="checkbox" name="cf7_wc_products[category_select]" class="show_other_field" value="checked" ' . checked( $value, 'checked', false ) . '> ' . __( '', 'cf7-woo-products' );
        echo '<span class="description">' . __( 'Allows users to pick a category first, then choose product on Frontend.', 'cf7-woo-products' ) . '</span>';

    }

    function render_category_placeholder_field() {
	    $options = get_option( 'cf7_wc_products' );

	    $value = isset( $options['category-placeholder'] ) ? $options['category-placeholder'] : '- - Choose Category - -';

        // Field output.
        echo '<input type="text" name="cf7_wc_products[category-placeholder]" class="category-placeholder" value="'.$value.'"><br> ';
        echo '<span class="description">' . __( 'Enter placeholder text for Choose Categories (if in use)', 'cf7-woo-products' ) . '</span>';

    }

    function render_show_other_field() {

		// Retrieve data from the database.
		$options = get_option( 'cf7_wc_products' );

		// Set default value.
		$value = isset( $options['show_other'] ) ? $options['show_other'] : '';

		// Field output.
		echo '<input type="checkbox" name="cf7_wc_products[show_other]" class="show_other_field" value="checked" ' . checked( $value, 'checked', false ) . '> ' . __( '', 'cf7-woo-products' );
		echo '<span class="description">' . __( 'This shows a text box for other field if the product is not listed', 'cf7-woo-products' ) . '</span>';

	}
    function render_show_other_text() {

		// Retrieve data from the database.
		$options = get_option( 'cf7_wc_products' );

		// Set default value.
		$value = isset( $options['show_other_text'] ) ? $options['show_other_text'] : "My product isn't listed";

		// Field output.
		echo '<input style="min-width: 200px;" type="text" name="cf7_wc_products[show_other_text]" class="show_other_text" value="'.$value.'"> ' . __( '', 'cf7-woo-products' );
		echo '<span class="description">' . __( 'This is the text label for other field if the product is not listed', 'cf7-woo-products' ) . '</span>';

	}

    function render_other_margin_top() {

		// Retrieve data from the database.
		$options = get_option( 'cf7_wc_products' );

		// Set default value.
		$value = isset( $options['other_margin_top'] ) ? $options['other_margin_top'] : '.8rem';

		// Field output.
		echo '<input type="text" name="cf7_wc_products[other_margin_top]" class="other_margin_top" value="'.$value.'"> ' . __( '', 'cf7-woo-products' );
		echo '<span class="description">' . __( 'This is the margin above the &#39;Other Product&#39 Checkbox. Units may be in any CSS unit, like px, em, rem, or % ', 'cf7-woo-products' ) . '</span>';

	}

    function render_set_placeholder_text() {

		// Retrieve data from the database.
		$options = get_option( 'cf7_wc_products' );

		// Set default value.
		$value = isset( $options['placeholder_text'] ) ? $options['placeholder_text'] : ' - - Choose Your Product - -';

		// Field output.
		echo '<input style="min-width: 200px;" type="text" name="cf7_wc_products[placeholder_text]" class="set_placeholder_text" value="'.$value.'"> ' . __( '', 'cf7-woo-products' );
		echo '<span class="description">' . __( 'This is the placeholder text for the dropdown menu.', 'cf7-woo-products' ) . '</span>';

	}    
    
    function render_validation_text() {

		// Retrieve data from the database.
		$options = get_option( 'cf7_wc_products' );

		// Set default value.
		$value = isset( $options['validation_text'] ) ? $options['validation_text'] : 'You must choose a product';

		// Field output.
		echo '<input style="max-width: 100%; width: 500px;" type="text" name="cf7_wc_products[validation_text]" class="set_validation_text" value="'.$value.'"> ' . __( '', 'cf7-woo-products' );
		echo '<span class="description">' . __( 'This is the text that appears if the field isn&rsquo;t selected. Since this is a product registration form, the field should be required.', 'cf7-woo-products' ) . '</span>';

	}

}