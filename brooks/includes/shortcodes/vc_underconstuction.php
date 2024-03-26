<?php

class WPBakeryShortCode_Brooks_Coming_soon extends  WPBakeryShortCode
{
    /**
     * @param $atts
     * @param null $content
     * @return string
     */


    public function content($atts, $content = null)
    {

        $color = $is_animate = $date = $hour = $animate_time = '';

        extract(shortcode_atts(array(
            'color' => '',
            'is_animate' => '',
            'date' => '',
            'hour' => '',
        ), $atts));

        $output = '';

        $hour = intval( $hour );
        $hour = $hour > 23?23:abs($hour);

        brooks_enqueue_custom('underconstruction');

            $output .= '<div class="cover__comming-soon">';
            $output .=     '<svg style="fill:' . $color . ';"> ';
            $output .=         '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . BROOKS_IMAGES . '/BH-UC.svg#build"></use>';
            $output .=     '</svg>';
            $output .= '</div>';

        if($date) {
            $output .= '<div id="countdown" class="intro__countdown " style="color:'. $color .'" data-date="' . $date . ' ' . $hour . '">';
            $output .= '    <div class="intro__count-in" data-mark="years">';
            $output .= '        <span class="datatime"></span>';
            $output .= '        <span class="datamark" data-labels="'.esc_html__('0: years | 1:year | 2:years', 'brooks').'"></span>';
            $output .= '    </div>';
            $output .= '    <div class="intro__count-in" data-mark="months">';
            $output .= '        <span class="datatime"></span>';
            $output .= '        <span class="datamark" data-labels="'.esc_html__('0:months | 1:month | 2:months', 'brooks').'"></span>';
            $output .= '    </div>';
            $output .= '    <div class="intro__count-in" data-mark="days">';
            $output .= '        <span class="datatime"></span>';
            $output .= '        <span class="datamark" data-labels="'.esc_html__('0:days | 1:day | 2:days', 'brooks').'"></span>';
            $output .= '    </div>';
            $output .= '    <div class="intro__count-in" data-mark="hours">';
            $output .= '        <span class="datatime"></span>';
            $output .= '        <span class="datamark" data-labels="'.esc_html__('0:hours | 1:hour | 2:hours', 'brooks').'"></span>';
            $output .= '    </div>';
            $output .= '    <div class="intro__count-in" data-mark="minutes">';
            $output .= '        <span class="datatime"></span>';
            $output .= '        <span class="datamark" data-labels="'.esc_html__('0 :minutes | 1:minute | 2:minutes', 'brooks').'"></span>';
            $output .= '    </div>';
            $output .= '    <div class="intro__count-in" data-mark="seconds">';
            $output .= '        <span class="datatime"></span>';
            $output .= '        <span class="datamark" data-labels="'.esc_html__('0 :seconds | 1:second | 2:seconds', 'brooks').'"></span>';
            $output .= '    </div>';
            $output .= '</div>';
        }
        return $output;
    }
}



$opts = array(
    'name'		=> esc_html__( 'Underconstruction', 'brooks'),
    'base'		=> 'brooks_coming_soon',
    'controls'		=> 'edit_popup_delete',
    'icon'		=> BROOKS_IMAGES.'/vc_icons/underconstruction.png',
    'category'		=> esc_html__('Developed for Brooks', 'brooks'),

    'params'		=> array(

        array(
            'type'		=> 'brooks_datepicker',
            'heading'		=> esc_html__( 'Date', 'brooks'),
            'param_name'		=> 'date',
            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
            'value'		=> '',
            'description'		=> esc_html__( 'Choose date when you complete or leave it empty.', 'brooks'),

        ),
        array(
            'type' => 'brooks_range',
            'heading'		=> esc_html__( 'Hour', 'brooks'),
            'param_name' => 'hour',
            'min'   => 0,
            'max'   => 23,
            'step'  => 1,
            'display_value' => esc_html__('{{value}}.00', 'brooks'),
            'value' => 0,
            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
            'description'		=> esc_html__( 'Choose hour when you complete or leave it empty,from 00 to 23.', 'brooks'),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Text Color', 'brooks' ),
            'param_name' => 'color',
            'description' => esc_html__( 'Select color text.', 'brooks' ),
        ),
    )
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Coming_soon($opts);