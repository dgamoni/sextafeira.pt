<?php

class WPBakeryShortCode_Brooks_Chart extends  WPBakeryShortCode
{
    /**
     * @param $atts
     * @param null $content
     * @return string
     */

    public function content($atts, $content = null)
    {
        $layout = $percentage = $label = $chart_bg_color = $text_color = $chart_active_color = $css = $desc = '';

        extract(shortcode_atts(array(
            'layout'        => 'pie',
            'percentage'    => '',
            'label'         => '',
            'desc'          => '',
            'css'           => '',
            'chart_bg_color'      => '#FFFFFF',
            'chart_active_color'  => '#EE3F54',
            'text_color'    => '#FFFFFF',
        ), $atts));

        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

        $output = '';
        $percentage = intval($percentage);


        if( empty( $percentage ) && $layout != 'text' )
            return $output;

        brooks_enqueue_custom( 'chart' );

        $output .= '<div class="theme__chart__block wpb_content_element chart__type__'. $layout .' ' .$css_class. '" data-percentage="'. $percentage .'" data-bg-color="'. $chart_bg_color .'" data-active-color="'. $chart_active_color .'" data-type="'. $layout .'"  style="color: '.$text_color.'">';

        if($layout == 'pie'):

            $output .= '<div class="chart__wrap">';
            $output .= '    <div class="figure__holder__square"></div>';
            $output .= '    <div class="chart__holder">';
            $output .= '        <svg width="400" height="400" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve">';
            $output .= '            <circle stroke-width="10" stroke="'.$chart_bg_color.'" fill="none" cx="200" cy="200" r="195" class="part"/>';
            $output .= '            <circle stroke-width="11" stroke="'.$chart_active_color.'" fill="none" cx="200" cy="200" r="195" class="part active"/>';
            $output .= '        </svg>';
            $output .= '    </div>';
            $output .= '    <div class="label__wrap">';
            $output .= '        <div class="label__data">' . preg_replace( '#([0-9]+)#', "<span data-number=\"$1\" class=\"label__number\">0</span>", esc_html($label) ) . '</div>';
            $output .= '    </div>';
            $output .= '</div>';
            $output .= '<div class="chart__description">' . esc_html( $desc ) . '</div>';

        elseif($layout == 'linear'):

            $output .= '<div class="chart__description">' . esc_html( $desc ) . '</div>';
            $output .= '<div class="chart__wrap">';
            $output .= '    <div class="chart__holder">';

            $output .= '        <svg width="400" height="10" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve">';
            $output .= '            <line stroke-width="10" stroke="'.$chart_bg_color.'" fill="none" x1="0" y1="5" x2="400" y2="5" class="part"/>';
            $output .= '            <line stroke-width="10" stroke="'.$chart_active_color.'" fill="none" x1="0" y1="5" x2="400" y2="5" class="part active"/>';
            $output .= '        </svg>';
            $output .= '    </div>';
            $output .= '    <div class="label__wrap">';
            $output .= '        <div class="label__data">' . preg_replace( '#([0-9]+)#', "<span data-number=\"$1\" class=\"label__number\">0</span>", esc_html($label) ) . '</div>';
            $output .= '    </div>';
            $output .= '</div>';

        else:

            $output .= '<div class="chart__wrap">';
            $output .= '    <div class="label__wrap">';
            $output .= '        <div class="label__data">' . preg_replace( '#([0-9]+)#', "<span data-number=\"$1\" class=\"label__number\">0</span>", esc_html($label) ) . '</div>';
            $output .= '    </div>';
            $output .= '</div>';
            $output .= '<div class="chart__description">' . esc_html( $desc ) . '</div>';

        endif;

        $output .= '</div>';

        return $output;
    }
}


$opts = array(
    'name'		    => esc_html__( 'Dynamic Chart', 'brooks'),
    'base'		    => 'brooks_chart',
    'controls'	    => 'edit_popup_delete',
    'icon'          => BROOKS_IMAGES.'/vc_icons/chart.png',
    'category'		=> esc_html__('Developed for Brooks', 'brooks'),
    'params'		=> array(

        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Layout Type', 'brooks'),
            'param_name' => 'layout',
            'description' => esc_html__('Choose chart layout.', 'brooks'),
            'value'   => array(
                esc_html__( 'Pie Chart', 'brooks' )  => 'pie',
                esc_html__( 'Linear Chart', 'brooks' ) => 'linear',
                esc_html__( 'Dynamic Text Numbers', 'brooks' ) => 'text',
            )
        ),
        array(
            'type' => 'brooks_range',
            'heading' => esc_html__( 'Progress percentage', 'brooks' ),
            'param_name' => 'percentage',
            'dependency' => array(
                'element' => 'layout',
                'value' => array( 'pie', 'linear' ),
            ),
            'min'   => 1,
            'max'   => 100,
            'step'  => 1,
            'display_value' => esc_html__('{{value}}%', 'brooks'),
            'value' => 40,
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Dynamic Chart Label', 'brooks' ),
            'description' => esc_html__('Set text label, any numeric values will be dynamically changed.', 'brooks'),
            'param_name' => 'label',
        ),
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Chart Description', 'brooks' ),
            'param_name' => 'desc',
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'brooks' ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Chart background color', 'brooks' ),
            'param_name' => 'chart_bg_color',
            "value" => '#FFFFFF',
            'dependency' => array(
                'element' => 'layout',
                'value' => array( 'pie', 'linear' ),
            ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Chart active color', 'brooks' ),
            'param_name' => 'chart_active_color',
            "value" => '#EE3F54',
            'dependency' => array(
                'element' => 'layout',
                'value' => array( 'pie', 'linear' ),
            ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Text color', 'brooks' ),
            'param_name' => 'text_color',
            "value" => '#FFFFFF',
        ),
    )
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Chart($opts);