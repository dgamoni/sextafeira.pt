<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column_Inner
 */
$el_class = $width = $css = $offset = $brooks_parallax_item = $parallax_offset = $parallax_delta = '';
$inner_flex = $elements_justify = $elements_align = $elements_in_row = $position_offset = '';
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$css_classes = array(
	$this->getExtraClass( $el_class ),
	'wpb_column',
	'vc_column_container',
	$width,
	$brooks_parallax_item == true ? 'theme__parallax__item':'',
	'theme__to__hide__elements'
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	$css_classes[]='vc_col-has-fill';
}

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );

if($position_offset) {
    $position_offset = json_decode($position_offset, true);
    $class_name = 'theme__custom__'. brooks_get_unique_id();

    $custom_style_class = brooks_build_media_css($position_offset, $class_name);

    $css_class .= ' ' . $class_name;
    $output .= $custom_style_class;
}

$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

/*
 * Set background image maximum size to "large"
 */
preg_match('#\([^?]*\?id=([0-9]+)#', $css, $matches);

$image_id = '';
if(isset($matches[1]))
    $image_id = (int)$matches[1];


// Parallax settings
if( $brooks_parallax_item) {
	
	brooks_enqueue_custom('parallax-item');

    $parallax_delta = intval($parallax_delta);
    $wrapper_attributes[] = "data-parallax = '$parallax_delta'";
}

$wrap_flex_class = array();
if($inner_flex) {
    $wrap_flex_class[] = 'theme__column__flex';
    $wrap_flex_class[] = 'column__align__'.$elements_align;
    $wrap_flex_class[] = 'column__justify__'.$elements_justify;

    if($elements_in_row)
        $wrap_flex_class[] = 'column__wrap';
}
$wrap_flex_class = implode(' ', $wrap_flex_class);

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . ' >';
$output .= '<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . '" ' . ($image_id?('style="background-image: url('.wp_get_attachment_image_url($image_id, 'large').')!important;"'):'').'>';
$output .= '<div class="wpb_wrapper '.$wrap_flex_class.'">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
