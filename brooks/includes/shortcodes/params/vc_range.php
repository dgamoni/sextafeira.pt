<?php
WpbakeryShortcodeParams::addField( 'brooks_range', 'brooks_range_field', BROOKS_SCRIPTS . '/admin/vc_params/brooks_range_field.js' );
function brooks_range_field( $settings, $value ) {
    $min = !empty($settings['min'])?floatval($settings['min']):0;
    $max = !empty($settings['max'])?floatval($settings['max']):100;
    $step = !empty($settings['step'])?floatval($settings['step']):1;
    $display_value = esc_attr( !empty($settings['display_value'])?$settings['display_value']:'{{value}}');

    $return  = '<div class="brooks-range-field vc_row">';
    $return .= '    <div class="vc_col-sm-9">';
    $return .= '        <input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . ' input-range" type="range" value="' . esc_attr( $value ) . '" min="'.$min.'" max="'.$max.'" step="'.$step.'"/>';
    $return .= '    </div>';
    $return .= '    <div class="vc_col-sm-3">';
    $return .= '        <input class="input-text" type="text" disabled="disabled" value="' . str_replace('{{value}}', esc_attr( $value ), $display_value) . '" data-display-value="'.$display_value.'" />';
    $return .= '    </div>';
    $return .= '</div>';

    return $return;
}
