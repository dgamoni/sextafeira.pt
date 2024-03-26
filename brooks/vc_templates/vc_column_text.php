<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $brooks_css_animation
 * @var $css
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column_text
 */
$el_class = $css = $css_animation = '';
$brooks_css_animation = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'wpb_text_column wpb_content_element ';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

if( !empty($brooks_css_animation) ){
    $css_class .= ' theme__animation -'.$brooks_css_animation;
    brooks_enqueue_custom('css-animation');
}

if(!empty($font_size))
    $css_class .= ' font-'.str_replace('.', '_', $font_size).'x';

$output = '
	<div class="' . esc_attr( $css_class ) . '">
		<div class="wpb_wrapper">
			' . wpb_js_remove_wpautop( $content, true ) . '
		</div>
	</div>
';

echo $output;
