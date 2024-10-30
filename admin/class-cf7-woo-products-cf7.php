<?php
/**
 * Class to Include the Tag Form in CF7
 *
 * @since    1.0.0
 */

class dd_cf7_wc_formtags{
    
	public function __construct() {

        add_action( 'admin_init', array( $this, 'init_tag_generator_wc_products'), 99 );

	}

    /**
     * Add Tag to CF7 Form Generator
     *
     * @since    1.0.0
     */

    public function init_tag_generator_wc_products() {
        if (class_exists('WPCF7_TagGenerator')) {
            WPCF7_TagGenerator::get_instance()->add( 'wc_products', __( 'WooCommerce Products', 'cf7-woo-products' ), (array($this,'wc_products_tag_generator' )), array(
                    'id'    => 'wpcf7-tg-pane-wc_products',
                    'title' => __( 'WooCommerce Products', 'cf7-woo-products' ),
            ) );
        }
    }
    
    function wc_products_tag_generator($contact_form, $args){
        $args = wp_parse_args( $args, array() );
        ?>

        <div id="wpcf7-tg-pane-wc_products" class="control-box">
                <fieldset>
                    <h4><?php _e('This will add the products that were checked with the registerable flag in WooCommerce.', 'cf7-woo-products' ); ?></h4>
                    <p><?php   $url = admin_url() . 'options-general.php?page=cf7-wc-products';
                            $link = sprintf(  __( 'This field is set as required by default.  Additional options can be set using the <a href="%s" %s>Plugin Options</a>.', 'cf7-woo-products' ), esc_url( $url ), 'target="blank"' );
                            echo $link; ?></p>
                    <div>
                        <table class="form-table"><tbody>
                            <tr>
                                <th scope="row">
                                    <label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'cf7-woo-products' ) ); ?></label>
                                </th>
                                <td>
                                    <input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /><br>
                                    <em><?php echo esc_html( __( 'This is the name of the tag as it will appear in your email setting tab', 'cf7-woo-products' ) ); ?></em>
                                </td>
                            </tr>
                            <tr>
                            <th scope="row"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></th>
                            <td>
                                <fieldset>
                                <legend class="screen-reader-text"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></legend>
                                <label><input type="checkbox" name="required" checked/> <?php echo esc_html( __( 'Required field', 'contact-form-7' ) ); ?></label>
                                </fieldset>
                            </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class (optional)', 'cf7-woo-products' ) ); ?></label>
                                </th>
                                <td>
                                    <input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'ID (optional)', 'cf7-woo-products' ) ); ?></label>
                                </th>
                                <td>
                                    <input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" />
                                </td>
                            </tr>
                        </tbody></table>    
                    </div>
                </fieldset>
                <div class="insert-box" style="padding-left: 15px; padding-right: 15px;">
                    <div class="tg-tag clear"><?php echo __( "This will insert a dropdown menu with the product for RMA or Registraiton.", 'cf7-woo-products' ); ?><br /><input type="text" name="wc_products" class="tag code" readonly="readonly" onfocus="this.select();" onmouseup="return false;" /></div>

                    <div class="submitbox">
                        <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
                    </div>
                </div>
            </div>
        <?php 
    }
        
}