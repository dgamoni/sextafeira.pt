<?php
if ( !class_exists( 'WooCommerce' ) )
    return;

class WPBakeryShortCode_Brooks_Woo_Single_Product extends  WPBakeryShortCode {
    public function content($atts, $content = null)
    {
        $format = $featured = $css = $grid_type = $position = $id = $sku = '';

        extract(shortcode_atts(array(
            'css' => '',
            'format' => '1__1',
            'id'        => '',
        ), $atts));

        $output = '';

        if(!$id)
            return $output;


        global $product;
        global $post;

        $product = wc_get_product((int) $id);
        $post = $product->post;

        setup_postdata($post);

        ob_start();
        brooks_content_product(array(
            'native_image' => true,
            'stretch_content' => $format?true:false,
            'image_format'  => $format,
            'show_title'    => true
        ));
        $product_content = ob_get_clean();

        unset($product);
        wp_reset_postdata();

        $output .= '<div class="wpb_content_element theme__product__item '.'hover__format__' . $format.'">';
        $output .=      $product_content;
        $output .= '</div>';


        return $output;
    }
}

$opts = array(
    'name' => esc_html__('Single Woo Product', 'brooks'),
    'base' => 'brooks_woo_single_product',
    'icon' => BROOKS_IMAGES.'/vc_icons/single_woo_product.png',
    'content_element' => true,
    'category'  => esc_html__('Developed for Brooks', 'brooks' ),
    'params' => array(
        array(
            'type'        => 'autocomplete',
            'heading'     => esc_html__( 'Select identificator', 'brooks' ),
            'param_name'  => 'id',
            'description' => esc_html__( 'Input product ID or product SKU or product title to see suggestions', 'brooks' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Product Display Format', 'brooks'),
            'param_name' => 'format',
            'value' => array(
                esc_html__( 'Square', 'brooks' )     => '1__1',
                esc_html__( 'Horizontal', 'brooks' ) => '2__1',
                esc_html__( 'Vertical', 'brooks' )   => '1__2',
            )
        ),
    ),
);

add_filter( 'vc_autocomplete_brooks_woo_single_product_id_callback', 'brooks_woo_autocomplete_suggester', 10, 1 );
add_filter( 'vc_autocomplete_brooks_woo_single_product_id_render', 'brooks_woo_autocomplete_render', 10, 1 );

function brooks_woo_autocomplete_suggester( $query ) {
    global $wpdb;
    $product_id = (int) $query;
    $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
					FROM {$wpdb->posts} AS a
					LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
					WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

    $results = array();
    if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
        foreach ( $post_meta_infos as $value ) {
            $data = array();
            $data['value'] = $value['id'];
            $data['label'] = esc_html__( 'Id', 'brooks' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'brooks' ) . ': ' . $value['title'] : '' ) . ( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . esc_html__( 'Sku', 'brooks' ) . ': ' . $value['sku'] : '' );
            $results[] = $data;
        }
    }

    return $results;
}

function brooks_woo_autocomplete_render( $query ) {
    $query = trim( $query['value'] ); // get value from requested
    if ( ! empty( $query ) ) {
        // get product
        $product_object = wc_get_product( (int) $query );
        if ( is_object( $product_object ) ) {
            $product_sku = $product_object->get_sku();
            $product_title = $product_object->get_title();
            $product_id = $product_object->id;

            $product_sku_display = '';
            if ( ! empty( $product_sku ) ) {
                $product_sku_display = ' - ' . esc_html__( 'Sku', 'brooks' ) . ': ' . $product_sku;
            }

            $product_title_display = '';
            if ( ! empty( $product_title ) ) {
                $product_title_display = ' - ' . esc_html__( 'Title', 'brooks' ) . ': ' . $product_title;
            }

            $product_id_display = esc_html__( 'Id', 'brooks' ) . ': ' . $product_id;

            $data = array();
            $data['value'] = $product_id;
            $data['label'] = $product_id_display . $product_title_display . $product_sku_display;

            return ! empty( $data ) ? $data : false;
        }

        return false;
    }

    return false;
}

vc_map($opts);
new WPBakeryShortCode_Brooks_Woo_Single_Product($opts);