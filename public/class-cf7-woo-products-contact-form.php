<?php

class Cf7_Woo_Products_Public_CF7{

    public function __construct(){

        add_action( 'wpcf7_init', array( $this , 'add_wc_products_to_cf7'));
        add_filter( 'wpcf7_validate_wc_products', array($this ,'wc_cf7_products_validation'), 10, 2 );
        add_filter( 'wpcf7_validate_wc_products*', array($this, 'wc_cf7_products_validation'), 10, 2 );
        add_action( 'wp_ajax_dd_cf7_get_wc_products', array( $this, 'get_wc_products'));
        add_action( 'wp_ajax_nopriv_dd_cf7_get_wc_products', array( $this, 'get_wc_products'));
    }

    public function add_wc_products_to_cf7(){
        $options = get_option('cf7_wc_products');
        if (isset($options['category_select']) && $options['category_select'] === 'checked') {
            wpcf7_add_form_tag(array('wc_products', 'wc_products*'), array($this, 'wc_cf7_products_plus_ajax'), array('name-attr' => true));
        } else {
            wpcf7_add_form_tag(array('wc_products', 'wc_products*'), array($this, 'wc_cf7_products_handler'), array('name-attr' => true));
        }
    }

    /**
     * Handler for Choosing Product Only
     *
     * @param $tag
     * @return string
     */
    public function wc_cf7_products_handler($tag){
        if ( empty( $tag->name ) ) {
            return '';
        }
        global $post;

        /**
         * @since 1.0.0
         *
         * Get Options and Categories
         */

        $options = get_option( 'cf7_wc_products' );

        $placeholder = (isset($options['placeholder_text'])) ? $options['placeholder_text'] : '- - Choose Your Product --';
        $margin = (isset($options['other_margin_top'])) ? $options['other_margin_top'] : '.8rem';
        $notlisted = (isset($options['show_other_text'])) ? $options['show_other_text'] : 'My product is&#39t listed';
        $options = get_option( 'cf7_wc_products' );
        $cats = isset( $options['wc_product_cats'] ) ? $options['wc_product_cats'] : array();
        $operator = (isset($options['choose_type']) && $options['choose_type'] == 'include')  ? 'IN' : 'NOT IN';

        // Run the WP Query to get all of the products.
        $results = new WP_Query( $this->get_query_args( $cats, $operator ) );

        // CF7 Form Field Class and ID option from form tag.
        $validation_error = wpcf7_get_validation_error( $tag->name );

        $class = wpcf7_form_controls_class( $tag->type, 'wpcf7-select' );
        $class .= ' duck-select ';

        if ( $validation_error ) {
            $class .= ' wpcf7-not-valid';
        }

        $atts = array();


        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
        }

        $atts['aria-invalid'] = $validation_error ? 'true' : 'false';

        $class .= $tag->get_class_option( $class );
        $atts['id'] = (!null == $tag->get_id_option()) ? $tag->get_id_option() : 'WC-CF7-'.$tag->name;

        $atts = wpcf7_format_atts( $atts );

        $output = '<span class="wpcf7-form-control-wrap '.sanitize_html_class( $tag->name ).'">';
        $output .= '<select name="'.$tag->name.'" class="'.$class.'" data-placeholder="'.$placeholder.'"'.$atts.'>';

        $output .= $this->get_select_2();

        // The Loop
        if ( $results->have_posts() ) {
            while ( $results->have_posts() ) {
                $results->the_post();
                $output .= "<option value='{$post->post_title}'>{$post->post_title}</output>";
            }
        }
        $output .= '</select></span>';
        // Show other box?
        if (isset($options['show_other'])) {
            $output .= '<div class="other-product" style="margin-top: '.$margin.';">
                            <label for="other-'.$tag->name.'"><input type="checkbox" id="other-'.$tag->name.'" name="other-'.$tag->name.'"> '.$notlisted.'</label>
                            <span class="wpcf7-form-control-wrap '.$tag->name.'-text"><input type="hidden" id="other-'.$tag->name.'-entry" class="wpcf7-form-control wpcf7-select" placeholder="Other Product Name"></span>
                        </div>';

            ob_start();?> <script type="text/javascript">
                (function($){
                    $("input#other-<?php echo $tag->name;?>").on('change', function(){
                        var name = $(this).prop("name");
                        if ($(this).is(":checked")){
                            $("input#"+name+"-entry").prop("type", "text");
                        }else{
                            $("input#"+name+"-entry").prop("type", "hidden");
                        }
                    });
                    $("input#other-<?php echo $tag->name;?>-entry").on('focusout', function(){
                        var value = $(this).val();
                        $("select[name='<?php echo $tag->name;?>']").append('<option value="'+value+'">'+value+'</option>').val(value);
                    });

                })(jQuery);
            </script>
            <?php
            $output .= ob_get_clean();

        }
        wp_reset_query();
        return $output;
    }

    /**
     *
     * Get Categories and Products
     *
     * since 1.1.0
     *
     * @param object $tag
     * @return string
     */
    public function wc_cf7_products_plus_ajax($tag){
        if ( empty( $tag->name ) ) {
            return '';
        }

        $options = get_option( 'cf7_wc_products' );

        $placeholder = (isset($options['placeholder_text'])) ? $options['placeholder_text'] : '- - Choose Your Product --';
        $margin = (isset($options['other_margin_top'])) ? $options['other_margin_top'] : '.8rem';
        $notlisted = (isset($options['show_other_text'])) ? $options['show_other_text'] : 'My product is&#39t listed';

        // CF7 Form Field Class and ID option from form tag.
        $validation_error = wpcf7_get_validation_error( $tag->name );

        $class = wpcf7_form_controls_class( $tag->type, 'wpcf7-select' );
        $class .= ' duck-select ';

        if ( $validation_error ) {
            $class .= ' wpcf7-not-valid';
        }

        $atts = array();


        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
        }

        $atts['aria-invalid'] = $validation_error ? 'true' : 'false';

        $class .= $tag->get_class_option( $class );
        $atts['id'] = (!null == $tag->get_id_option()) ? $tag->get_id_option() : 'WC-CF7-'.$tag->name;

        $atts = wpcf7_format_atts( $atts );


        $cats = isset( $options['wc_product_cats'] ) ? $options['wc_product_cats'] : array();
        $operator = (isset($options['choose_type']) && $options['choose_type'] == 'include')  ? 'object_ids' : 'exclude';
        $terms = get_terms(
            array(
                'taxonomy'         => 'product_cat',
                $operator          => $cats,
                'include_children' => true,
            )
        );
        $output = '<div id="chooseCategory"><span class="wpcf7-form-control-wrap wc-product-category-wrapper">';
        $output .= '<select name="product-category" id="categorySelected" class="wpcf7-form-control wpcf7-select wpcf7-validates-as-required" aria-required="true" aria-invalid="false">';
        $output .= $this->get_select_2('category');
        foreach ($terms as $term){

            $output .= sprintf('<option value="%s">%s</option>', $term->term_id, $term->name);

        }
        $output .= '</select></span>';
        $output .= '<div id="spinner" style="display: none;"><img src="'.site_url().'/wp-includes/js/tinymce/skins/lightgray/img/loader.gif" alt="Loading..."></div>';
        $output .= '<div id="Chooseproduct" style="display: none;"><span class="wpcf7-form-control-wrap '.sanitize_html_class( $tag->name ).'">';
        $output .= '<select name="'.$tag->name.'" class="'.$class.'" data-placeholder="'.$placeholder.'"'.$atts.'>';
        $output .= '</select></span></div></div>    ';

        if (isset($options['show_other'])) {
            $output .= '<div class="other-product" style="margin-top: '.$margin.';">
                            <label for="other-'.$tag->name.'"><input type="checkbox" id="other-'.$tag->name.'" name="other-'.$tag->name.'"> '.$notlisted.'</label>
                            <span class="wpcf7-form-control-wrap '.$tag->name.'-text"><input type="hidden" id="other-'.$tag->name.'-entry" class="wpcf7-form-control wpcf7-select" placeholder="Other Product Name"></span>
                        </div>';

            ob_start();?> <script type="text/javascript">
                (function($){
                    $("input#other-<?php echo $tag->name;?>").change(function(){
                        var name = $(this).prop("name");
                        if ($(this).is(":checked")){
                            $("input#"+name+"-entry").prop("type", "text");
                        }else{
                            $("input#"+name+"-entry").prop("type", "hidden");
                        }
                    });
                    $("input#other-<?php echo $tag->name;?>-entry").focusout(function(){
                        var value = $(this).val();
                        $("select[name='<?php echo $tag->name;?>']").append('<option value="'+value+'">'+value+'</option>').val(value);
                    });

                })(jQuery);
            </script>
            <?php
            $output .= ob_get_clean();
        }
        wp_reset_query();
        return $output;
    }

    /**
     * function wc_cf7_products_validation
     *
     * @param $result
     * @param $tag
     * @return mixed
     */
    public function wc_cf7_products_validation( $result, $tag ) {
        $options = get_option( 'cf7_wc_products' );

        // Set default value.
        $value = isset( $options['validation_text'] ) ? $options['validation_text'] : 'You must choose a product';


        $name = $tag->name;

        if ( isset( $_POST[$name] ) && is_array( $_POST[$name] ) ) {
            foreach ( $_POST[$name] as $key => $value ) {
                if ( '' === $value ) {
                    unset( $_POST[$name][$key] );
                }
            }
        }

        $empty = ! isset( $_POST[$name] ) || empty( $_POST[$name] ) && '0' !== $_POST[$name];

        if ( $tag->is_required() && $empty ) {
            $result->invalidate( $tag, $value );
        }

        return $result;
    }

    public function get_query_args($cats, $operator){

        // Tax Query Args
        $tax_query = array(
            'relation' => 'AND',
            array(
                'taxonomy'         => 'product_cat',
                'terms'            => $cats,
                'operator'         => $operator,
                'include_children' => true,
            ),
        );

        // WP_Query arguments
        $args = array(
            'post_type'     => array( 'product' ),
            'posts_per_page'=> -1,
            'tax_query'     => $tax_query,
            'orderby'       => 'title',
            'order'         => 'ASC'
        );

        return $args;
    }

    public function get_select_2($placeholder=null){
        $options = get_option( 'cf7_wc_products' );
        if (null === $placeholder){
            $placeholder = (isset($options['placeholder_text'])) ? $options['placeholder_text'] : '- - Choose Your Product --';
        } else {
            $placeholder = isset( $options['category-placeholder'] ) ? $options['category-placeholder'] : '- - Choose Category - -';
        }
        if (isset($options['include_select2'])){
            wp_enqueue_script('selectWoo');
            wp_enqueue_style('select2');
            $output ='<option value="" selected></option>';
        } else {
            $output ='<option value="" selected>'.$placeholder.'</option>';
        }
        return $output;
    }

    /**
     * Get Products Ajax Handler
     */
    public function get_wc_products(){

        $options = get_option( 'cf7_wc_products' );
        $placeholder = (isset($options['placeholder_text'])) ? $options['placeholder_text'] : '- - Choose Your Product --';
        echo '<option value="" selected="selected">'.$placeholder.'</option>';

        $args = $this->get_query_args($_POST['category'], 'IN');

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()){
                $query->the_post();
                echo sprintf('<option value="%s">%s</option>', get_the_title(), get_the_title());
            }
        }

        exit();
    }
}