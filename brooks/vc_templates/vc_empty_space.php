<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $height
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Empty_space
 */

$el_class = $css = '';
$brooks_responsive_height = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class = 'vc_empty_space ' . $this->getExtraClass( $el_class ) . vc_shortcode_custom_css_class( $css, ' ' );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$brooks_responsive_height = json_decode($brooks_responsive_height, true);
if(!empty($brooks_responsive_height['height']))
    foreach($brooks_responsive_height['height'] as $key => $value) {
        $css_class .= ' space__offset__'.$key.'__'.$value;
    }

?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>"><span class="vc_empty_space_inner"></span></div>