<?php

class WPBakeryShortCode_Brooks_Grid_Item extends  WPBakeryShortCodesContainer {
    public function content($atts, $content = null)
    {
        $format = $featured = $css = $grid_type = $position = '';

        extract(shortcode_atts(array(
            'css' => '',
            'grid_type' => 'masonry',
            'format'    => '1__1',
            'featured'  => '',
            'position'  => 'top'
        ), $atts));

        $format = explode('__', $format);

        if($featured) {
            $format[0] = $format[0] + 1;
            $format[1] = $format[1] + 1;
        }

        $format = 'item__width__' . $format[0] . ' item__height__' . $format[1];

        if($grid_type == 'masonry')
            $format = null;

        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        $css_class .= ' content__align__' . $position;
        $output = '';

        $output .= '<div class="grid__item ' . $format . '">';
        $output .= '    <div class="grid__item__content__wrap">';
        $output .= '        <div class="grid__item__content '.$css_class.'">';
        $output .=          do_shortcode($content);
        $output .= '        </div>';
        $output .= '    </div>';
        $output .= '</div>';

        return $output;
    }
}

$opts = array(
    'name' => esc_html__('Grid Item', 'brooks'),
    'base' => 'brooks_grid_item',
    'content_element' => true,
    'icon' => BROOKS_IMAGES.'/vc_icons/grid_item.png',
    'category'  => esc_html__('Developed for Brooks', 'brooks' ),
    'as_child' => array('only' => 'brooks_grid_container'),
    'is_container' => true,
    'js_view' => 'VcColumnView',
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Grid Item Format', 'brooks'),
            'param_name' => 'format',
            'value' => array(
                esc_html__( 'Square', 'brooks' )     => '1__1',
                esc_html__( 'Horizontal', 'brooks' ) => '2__1',
                esc_html__( 'Vertical', 'brooks' )   => '1__2',
            )
        ),
        array(
            'type' => 'checkbox',
            'heading'		=> esc_html__('Featured Item ?', 'brooks'),
            'param_name'		=> 'featured',
            'description'		=> esc_html__( 'Choose to make item stand out.', 'brooks'),
            'value'		=> array(
                esc_html__( 'Yes', 'brooks') => 'yes',
            )
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Content position', 'brooks'),
            'description'		=> esc_html__( 'Select content position within columns.', 'brooks'),
            'param_name' => 'position',
            'value' => array(
                esc_html__( 'Top', 'brooks' )      => 'top',
                esc_html__( 'Bottom', 'brooks' )   => 'bottom',
                esc_html__( 'Center', 'brooks' )   => 'center',
                esc_html__( 'Stretch', 'brooks' )  => 'stretch',
            )
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'brooks' ),
        )
    ),
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Grid_Item($opts);