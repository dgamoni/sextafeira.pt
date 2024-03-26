<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$brooks_is_container = $brooks_parallax_bg = $brooks_scale_bg = $brooks_bg_overlay = $brooks_bg_grad = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class );

$css_classes = array(
    'vc_row',
    'wpb_row', //deprecated
    'vc_row-fluid',
    'theme__section',// Theme Section class
    $el_class,
    vc_shortcode_custom_css_class( $css ),
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) || $video_bg) {
    $css_classes[] = 'vc_row-has-fill';
}

if (!empty($atts['gap'])) {
    $css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
    $wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
    $wrapper_attributes[] = 'data-vc-full-width="true"';
    $wrapper_attributes[] = 'data-vc-full-width-init="false"';
    if ( 'stretch_row_content' === $full_width ) {
        $wrapper_attributes[] = 'data-vc-stretch-content="true"';
    } elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
        $wrapper_attributes[] = 'data-vc-stretch-content="true"';
        $css_classes[] = 'vc_row-no-padding';
    }
    $after_output .= '<div class="vc_row-full-width"></div>';
}

if ( ! empty( $full_height ) ) {
    $css_classes[] = ' vc_row-o-full-height';
    if ( ! empty( $columns_placement ) ) {
        $flex_row = true;
        $css_classes[] = ' vc_row-o-columns-' . $columns_placement;
    }
}

if ( ! empty( $equal_height ) ) {
    $flex_row = true;
    $css_classes[] = ' vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
    $flex_row = true;
    $css_classes[] = ' vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
    $css_classes[] = ' vc_row-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

if ( $has_video_bg ) {
    $parallax = $video_bg_parallax;
    $parallax_image = $video_bg_url;
    $css_classes[] = ' vc_video-bg-container';
    wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if (!empty($brooks_is_container))
    $css_classes[] = $brooks_is_container;

if (!empty($brooks_parallax_bg))
    $css_classes[] = '-parallax';

if (!empty($brooks_scale_bg))
    $css_classes[] = '-scale';


if ( ! $parallax && $has_video_bg ) {
    $wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

/*
 * Set background image maximum size to "large"
 */
preg_match('#\([^?]*\?id=([0-9]+)#', $css, $matches);

$image_id = '';
if(isset($matches[1]))
    $image_id = (int)$matches[1];

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . ' style="background-image:none ! important;">';

$output .= wpb_js_remove_wpautop( $content );

$style = $brooks_scale_bg?'scale':($brooks_parallax_bg?'parallax':'');

$output .= brooks_get_section_background( $image_id, $style, $brooks_bg_overlay, $brooks_bg_grad );

$output .= '</div>';
$output .= $after_output;

echo $output;
