<?php

class WPBakeryShortCode_Brooks_Grid_Container extends  WPBakeryShortCodesContainer
{
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    public function content($atts, $content = null)
    {
        $gap = $grid_type = $columns = $css = '';


        extract(shortcode_atts(array(
            'css'   => '',
            'columns'       => 2,
            'grid_type'  => 'masonry',
            'gap'           => ''
        ), $atts));

        brooks_enqueue_custom( 'grid' );

        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

        $content = str_replace('[brooks_grid_item', '[brooks_grid_item ' . 'grid_type="' . $grid_type . '"', $content);

        $output = '';


        $output .= '<div class="wpb_content_element ' . $css_class . '">';
        $output .= '<div class="theme__grid__wrap -gap__' . $gap . ' wpb_content_element">';
        $output .= '    <div class="theme__grid grid__type__' . $grid_type . ' grid__columns__' . $columns . ' ' . $css_class . '">';
        $output .=          do_shortcode($content);
        $output .= '    </div>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}

$opts = array(
    'name' => esc_html__('Grid Container', 'brooks'),
    'base' => 'brooks_grid_container',
    'show_settings_on_create' => true,
    'is_container' => true,
    'as_parent' => array('only' => 'brooks_grid_item'),
    'category'  => esc_html__( 'Developed for Brooks', 'brooks' ),
    'icon' => BROOKS_IMAGES.'/vc_icons/grid_container.png',
    'js_view' => 'VcColumnView',
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Columns number', 'brooks'),
            'param_name' => 'columns',
            'description' => esc_html__('Select number of columns.', 'brooks'),
            'value'   => array(
                esc_html__( '2 columns', 'brooks' ) => '2',
                esc_html__( '3 columns', 'brooks' ) => '3',
                esc_html__( '4 columns', 'brooks' ) => '4',
                esc_html__( '6 columns', 'brooks' ) => '6'
            )
        ),
        array(
            'type' => 'brooks_layout_select',
            'heading' => esc_html__('Grid Type', 'brooks'),
            'param_name' => 'grid_type',
            'description' => esc_html__('Select grid type.', 'brooks'),
            'layouts'   => array(
                'masonry' => BROOKS_IMAGES . '/metabox_params/masonry.png',
                'simple' => BROOKS_IMAGES . '/metabox_params/simple.png',
                'metro'     => BROOKS_IMAGES . '/metabox_params/complex.png'
            ),
            'value' => 'masonry'
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Grid Gap', 'brooks'),
            'param_name' => 'gap',
            'value' => array(
                esc_html__( 'No', 'brooks' ) =>  '',
                esc_html__( 'Small Gap', 'brooks' ) => '15',
                esc_html__( 'Large Gap', 'brooks' ) => '30'
            )
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'brooks' ),
        ),
    )
);
vc_map($opts);
new WPBakeryShortCode_Brooks_Grid_Container($opts);