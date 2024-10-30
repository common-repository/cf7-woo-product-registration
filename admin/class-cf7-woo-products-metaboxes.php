<?php

/**
 * Class Cf7_Woo_Products_Metaboxes
 */

class Cf7_Woo_Products_Metaboxes {

    public function __construct() {

        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox'));
            add_action('load-post-new.php', array($this, 'init_metabox'));
        }

    }

    public function init_metabox() {

        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_metabox'), 10, 2);

    }

    public function add_metabox() {

        add_meta_box(
            'registrable',
            __('Is Registrable', 'cf7-woo-products'),
            array($this, 'render_metabox'),
            'product',
            'side',
            'default'
        );

    }

    public function render_metabox($post) {

        // Retrieve an existing value from the database.
        $cf7_isregistrable = get_post_meta($post->ID, 'cf7_isregistrable', true);

        // Set default values.
        if (empty($cf7_isregistrable)) $cf7_isregistrable = '';

        // Form fields.
        echo '<table class="form-table">';

        echo '	<tr>';
        echo '		<th><label for="cf7_isregistrable" class="cf7_isregistrable_label">' . __('Product is Registrable', 'cf7-woo-products') . '</label></th>';
        echo '		<td>';
        echo '			<label><input type="checkbox" id="cf7_isregistrable" name="cf7_isregistrable" class="cf7_isregistrable_field" value="checked" ' . checked($cf7_isregistrable, 'checked', false) . '> ' . __('', 'cf7-woo-products') . '</label>';
        echo '		</td>';
        echo '	</tr>';
        echo '<tr><td colspan="2">';
        echo '			<span class="description">' . __('Check this box for product to appear on CF7 Form for RMA or Registration', 'cf7-woo-products') . '</span>';
        echo '</td></tr>';
        echo '</table>';

    }

    public function save_metabox($post_id, $post) {

// Sanitize user input.
        $cf7_new_isregistrable = isset($_POST['cf7_isregistrable']) ? 'checked' : '';

// Update the meta field in the database.
        update_post_meta($post_id, 'cf7_isregistrable', $cf7_new_isregistrable);

    }

}