<?php

class WPBakeryShortCode_Brooks_Slider_Container extends  WPBakeryShortCodesContainer
{
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    public function content($atts, $content = null)
    {
        $slidestoshow = $slidestoscroll = $dots = $centermode = $arrows = $css = $focusonselect = $adaptiveheight = $autoplay = $autoplayspeed = $centerpadding = $draggable = $fadeel = $variablewidth = $vertical = $speed  = "";

        $prefix = 'brooks__slider-';

        extract(shortcode_atts(array(
            'css'   => '',
            'slidestoshow' => 1,
            'slidestoscroll' => 1,
            'dots' => '',
            'centermode' => '',
            'focusonselect' => '',
            'arrows' => '',
            'adaptiveheight' => '',
            'autoplay' => '',
            'autoplaySpeed' => 3000,
            'centerpadding' => 50,
            'draggable' => '',
            'fadeel' => '',
            'variablewidth' => '',
            'vertical' => '',
            'speed' => 300
        ), $atts));

        brooks_enqueue_custom( 'slickslider' );
        wp_enqueue_style( 'slick' );
        wp_enqueue_style( 'slick-theme' );
        $id = brooks_get_unique_id();
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

        $output = '';

        $output .= '<div class="brooks__slider " 
                    data-slider=\'{"id" : "'. $prefix . $id .'","slidesToShow" : "'. $slidestoshow .'","slidesToScroll" : "'. $slidestoscroll .'","dots" : "'. $dots .'", "centerMode" : "'. $centermode .'","focusOnSelect" : "'. $focusonselect .'","arrows" : "'. $arrows .'","adaptiveHeight" : "'. $adaptiveheight .'","autoplay" : "'. $autoplay .'","autoplaySpeed" : "'. $autoplayspeed .'","centerPadding" : "'. $centerpadding .'","draggable" : "'. $draggable .'","fade" : "'. $fadeel .'","variableWidth" : "'. $variablewidth .'","vertical" : "'. $vertical .'","speed" : "'. $speed .'"}\' >';
        $output .= '    <div  id=brooks__slider-'. $id .' class="brooks__slider-in">';
        $output .=          do_shortcode($content);
        $output .= '    </div>';
        $output .= '</div>';

        return $output;
    }
}

$opts = array(
    'name' => esc_html__('Slider Container', 'brooks'),
    'base' => 'brooks_slider_container',
    'show_settings_on_create' => true,
    'is_container' => true,
    'as_parent' => array('only' => 'brooks_slider_item'),
    'category'  => esc_html__( 'Developed for Brooks', 'brooks' ),
    'icon' => BROOKS_IMAGES.'/vc_icons/grid_container.png',
    'js_view' => 'VcColumnView',
    'params' => array(
        
        array(
            'type' => 'brooks_range',
            'heading' => esc_html__( 'Slides To Show', 'brooks' ),
            'param_name' => 'slidestoshow',
            'min'   => 1,
            'max'   => 10,
            'step'  => 1,
            'display_value' => esc_html__('{{value}} columns', 'brooks'),
            'value' => 1,
            'description' => esc_html__( 'Number of slides to show', 'brooks' ),
        ),
        array(
            'type' => 'brooks_range',
            'heading' => esc_html__( 'Slides To Scroll', 'brooks' ),
            'param_name' => 'slidestoscroll',
            'description' => esc_html__( 'Number of slides to scroll', 'brooks' ),
            'min'   => 1,
            'max'   => 10,
            'step'  => 1,
            'display_value' => esc_html__('{{value}} columns', 'brooks'),
            'value' => 1,
        ),
        array(
            'type' => 'brooks_range',
            'heading' => esc_html__( 'Speed', 'brooks' ),
            'param_name' => 'speed',
            'description' => esc_html__( 'Slide/Fade animation speed', 'brooks' ),
            'min'   => 100,
            'max'   => 3000,
            'step'  => 100,
            'display_value' => esc_html__('{{value}} ms', 'brooks'),
            'value' => 300,
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Dots?', 'brooks' ),
            'param_name' => 'dots',
            'description' => esc_html__( 'Show dot indicators?', 'brooks' ),
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'std' => 'no',
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Center mode?', 'brooks' ),
            'param_name' => 'centermode',
            'description' => esc_html__( 'Enables centered view with partial prev/next slides. Use with odd numbered Slides To Show counts', 'brooks' ),
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'std' => 'no',
        ),
        array(
            'type' => 'brooks_range',
            'heading' => esc_html__( 'Set Center Padding', 'brooks' ),
            'param_name' => 'centerpadding',
            'description' => esc_html__( 'Side padding when in center mode', 'brooks' ),
            'min'   => 0,
            'max'   => 300,
            'step'  => 10,
            'display_value' => esc_html__('{{value}} px', 'brooks'),
            'value' => 50,
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Focus On Select?', 'brooks' ),
            'param_name' => 'focusonselect',
            'description' => esc_html__( 'Enables centered view with partial prev/next slides. Use with odd numbered Slides To Show counts', 'brooks' ),
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'std' => 'no',
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Arrows?', 'brooks' ),
            'param_name' => 'arrows',
            'description' => esc_html__( 'Prev/Next Arrows', 'brooks' ),
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'std' => 'no',
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Adaptive Height?', 'brooks' ),
            'param_name' => 'adaptiveheight',
            'description' => esc_html__( 'Enables adaptive height for single slide horizontal carousels.', 'brooks' ),
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'std' => 'no',
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'autoplay?', 'brooks' ),
            'param_name' => 'autoplay',
            'description' => esc_html__( 'Enables Autoplay', 'brooks' ),
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'std' => 'no',
        ),
        array(
            'type' => 'brooks_range',
            'heading' => esc_html__( 'Autoplay Speed', 'brooks' ),
            'param_name' => 'autoplayspeed',
            'description' => esc_html__( 'Number of slides to scroll', 'brooks' ),
            'min'   => 1000,
            'max'   => 10000,
            'step'  => 1000,
            'display_value' => esc_html__('{{value}} ms', 'brooks'),
            'value' => 3000,
        ),

        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Draggable?', 'brooks' ),
            'param_name' => 'draggable',
            'description' => esc_html__( 'Enable mouse dragging', 'brooks' ),
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'std' => 'yes',
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Fade?', 'brooks' ),
            'param_name' => 'fadeel',
            'description' => esc_html__( 'Enable fade', 'brooks' ),
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'std' => 'no',
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Variable Width?', 'brooks' ),
            'param_name' => 'variablewidth',
            'description' => esc_html__( 'Variable width slides', 'brooks' ),
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'std' => 'no',
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Vertical?', 'brooks' ),
            'param_name' => 'vertical',
            'description' => esc_html__( 'Vertical slide mode', 'brooks' ),
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'std' => 'no',
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
new WPBakeryShortCode_Brooks_Slider_Container($opts);
