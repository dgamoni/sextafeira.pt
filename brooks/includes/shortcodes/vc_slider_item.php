<?php

class WPBakeryShortCode_Brooks_Slider_Item extends  WPBakeryShortCodesContainer {
    public function content($atts, $content = null)
    {
        $css  = $widthv = $widthp = $heightp = $heightv = $unitw = $unith = $horizontal = $vertical = '';

        extract(shortcode_atts(array(
            'css' => '',
            'widthp' => '',
            'widthv' => '',
            'heightp' => '',
            'heightv' => '',
            'unitw' => '',
            'unith' => '',
            'horizontal' => '',
            'vertical' => ''
        ), $atts));

        if( $widthp != '')
            $widthp.= 'px';

        if( $widthv != '')
            $widthv.=  'vw';

        if( $heightp != '')
            $heightp.= 'px';

        if( $heightv != '')
            $heightv.=  'vw';

        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        $output = '';


        $output .=  '<div style="display: flex; flex-direction:column; align-items:'. $vertical .'; justify-content:'. $horizontal .'; overflow: hidden; width:' . (($unitw != 'none')?$widthv :'').''.(($unitw != 'none')?$widthp :'')  . ';height:' . (($unith != 'none')?$heightv :'').''.(($unith != 'none')?$heightp :'') . '">' . do_shortcode($content) . '</div>';


        return $output;
    }
}

$opts = array(
    'name' => esc_html__('Slider Item', 'brooks'),
    'base' => 'brooks_slider_item',
    'content_element' => true,
    'icon' => BROOKS_IMAGES.'/vc_icons/grid_item.png',
    'category'  => esc_html__('Developed for Brooks', 'brooks' ),
    'as_child' => array('only' => 'brooks_slider_container'),
    'is_container' => true,
    'js_view' => 'VcColumnView',
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => 'Unit of mesuarment width',
            'param_name' => 'unitw',
            'group' => esc_html__( 'General', 'brooks' ),
            'value' => array(
                'None' => 'none',
                'Pixels' => 'pixel',
                'Viewport' => 'view'
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => 'Unit of mesuarment height',
            'param_name' => 'unith',
            'group' => esc_html__( 'General', 'brooks' ),
            'value' => array(
                'None' => 'none',
                'Pixels' => 'pixel',
                'Viewport' => 'view'
            ),
        ),
        array(
            'type' => 'brooks_range',
            'heading' => esc_html__( 'Width in pixels', 'brooks' ),
            'param_name' => 'widthp',
            'group' => esc_html__( 'General', 'brooks' ),
            'description' => esc_html__( 'Number of slides to scroll', 'brooks' ),
            'min'   => 10,
            'max'   => 2000,
            'step'  => 1,
            'display_value' => esc_html__('{{value}} px', 'brooks'),
            'dependency' => array(
                'element' => 'unitw',
                'value' => 'pixel',
            )
        ),
        array(
            'type' => 'brooks_range',
            'heading' => esc_html__( 'Width in viewport', 'brooks' ),
            'param_name' => 'widthv',
            'group' => esc_html__( 'General', 'brooks' ),
            'description' => esc_html__( 'Number of slides to scroll', 'brooks' ),
            'min'   => 0,
            'max'   => 100,
            'step'  => 1,
            'display_value' => esc_html__('{{value}} vw', 'brooks'),
            'dependency' => array(
                'element' => 'unitw',
                'value' => 'view',
            )
        ),
        array(
            'type' => 'brooks_range',
            'heading' => esc_html__( 'Height in pixels', 'brooks' ),
            'param_name' => 'heightp',
            'group' => esc_html__( 'General', 'brooks' ),
            'description' => esc_html__( 'Number of slides to scroll', 'brooks' ),
            'min'   => 10,
            'max'   => 2000,
            'step'  => 1,
            'display_value' => esc_html__('{{value}} px', 'brooks'),
            'dependency' => array(
                'element' => 'unith',
                'value' => 'pixel',
            )
        ),
        array(
            'type' => 'brooks_range',
            'heading' => esc_html__( 'Height in viewport', 'brooks' ),
            'param_name' => 'heightv',
            'group' => esc_html__( 'General', 'brooks' ),
            'description' => esc_html__( 'Number of slides to scroll', 'brooks' ),
            'min'   => 0,
            'max'   => 100,
            'step'  => 1,
            'display_value' => esc_html__('{{value}} vh', 'brooks'),
            'dependency' => array(
                'element' => 'unith',
                'value' => 'view',
            )
        ),

        array(
            'type' => 'dropdown',
            'heading'		=> esc_html__('Elements Vertical Alignment', 'brooks'),
            'param_name'		=> 'elements_align',
            'description'		=> esc_html__( 'Set vertical alignment for inner elements.', 'brooks'),
            'value'		=> array(
                esc_html__( 'Top', 'brooks') => 'top',
                esc_html__( 'Middle', 'brooks') => 'center',
                esc_html__( 'Bottom', 'brooks') => 'bottom',
                esc_html__( 'Stretch', 'brooks') => 'stretch',
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => 'Vertical alignment',
            'param_name' => 'vertical',
            'group' => esc_html__( 'General', 'brooks' ),
            'value' => array(
                'Normal' => 'flex-start',
                'End' => 'flex-end',
                'Center' => 'center',
                'Baseline' => 'baseline',
                'Stretch' => 'stretch',

            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => 'Horizontal alignment',
            'param_name' => 'horizontal',
            'group' => esc_html__( 'General', 'brooks' ),
            'value' => array(
                'Normal' => 'flex-start',
                'End' => 'flex-end',
                'Center' => 'center',
                'Space Between' => 'space-between',
                'Space Around' => 'space-around',

            ),
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'brooks' ),
        ),


    ),
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Slider_Item($opts);