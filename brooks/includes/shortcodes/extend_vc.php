<?php
/**
 * Extend VC Row element with custom functionality
 */

$attributes = array(

    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Use video background?', 'brooks' ),
        'param_name' => 'video_bg',
        'description' => esc_html__( 'If checked, video will be used as row background.', 'brooks' ),
        'group' => esc_html__( 'Backrground Effect Options', 'brooks' ),
        'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'YouTube link', 'brooks' ),
        'param_name' => 'video_bg_url',
        'value' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
        'group' => esc_html__( 'Backrground Effect Options', 'brooks' ),
        'description' => esc_html__( 'Add YouTube link.', 'brooks' ),
        'dependency' => array(
            'element' => 'video_bg',
            'not_empty' => true,
        ),
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__('Parallax', 'brooks'),
        'param_name' => 'brooks_parallax_bg',
        'dependency' => array('element' => 'video_bg', 'is_empty' => true),
        'group' => esc_html__( 'Backrground Effect Options', 'brooks' ),
        'value'		=> array(
            esc_html__( 'Yes', 'brooks') => 'yes'
        ),
        'description' => esc_html__( 'Add parallax type background for row.', 'brooks' )
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__('Scale Animation Background', 'brooks'),
        'param_name' => 'brooks_scale_bg',
        'dependency' => array('element' => 'brooks_parallax_bg', 'is_empty' => true),
        'group' => esc_html__( 'Backrground Effect Options', 'brooks' ),
        'value'		=> array(
            esc_html__( 'Yes', 'brooks') => 'yes'
        ),
        'description' => esc_html__( 'Use scale animation effect in block background', 'brooks' )
    ),
    array(
        'type' => 'dropdown',
        'heading'		=> esc_html__('Background Overlay Scheme', 'brooks'),
        'param_name'		=> 'brooks_bg_overlay',
        'description'		=> esc_html__("Pick a scheme for the background overlay. 'Light'looks good over dark images while 'Dark' looks good on light images.", 'brooks'),
        'group' => esc_html__( 'Backrground Effect Options', 'brooks' ),
        'value'		=> array(
            esc_html__( 'None', 'brooks') => '',
            esc_html__( 'Dark', 'brooks') => 'dark',
            esc_html__( 'Light', 'brooks') => 'light',
            esc_html__( 'Theme color', 'brooks') => 'theme',
        )
    ),
    array(
        'type' => 'checkbox',
        'heading'		=> esc_html__('Background Overlay Gradient', 'brooks'),
        'param_name'		=> 'brooks_bg_grad',
        'dependency'		=> array('element' => 'brooks_bg_overlay', 'not_empty' => true),
        'description'		=> esc_html__( 'Choose to use pattern or just solid overlay.', 'brooks'),
        'group' => esc_html__( 'Backrground Effect Options', 'brooks' ),
        'value'		=> array(
            esc_html__( 'Yes', 'brooks') => 'yes',
        )
    ),
    array(
        'type'		=> 'brooks_layout_select',
        'heading'		=> esc_html__('Row stretch', 'brooks'),
        'param_name'		=> 'brooks_is_container',
        'description'		=> esc_html__( 'Select stretching options for row and content.', 'brooks'),
        'weight' => 1,
        'layouts'   => array(
            'theme__container__full' => BROOKS_IMAGES . '/vc_params/full_container.png',
            'theme__container' => BROOKS_IMAGES . '/vc_params/container.png',
            'theme__container__left' => BROOKS_IMAGES . '/vc_params/left_container.png',
            'theme__container__right' => BROOKS_IMAGES . '/vc_params/right_container.png',
        ),
        'value'		=> 'theme__container__full'
    )
);

vc_remove_param( "vc_row", "full_width" );
vc_remove_param( "vc_row", "gap" );
vc_remove_param( "vc_row", "parallax" );
vc_remove_param( "vc_row", "parallax_image" );
vc_remove_param( "vc_row", "video_bg_parallax" );
vc_remove_param( "vc_row", "video_bg" );
vc_remove_param( "vc_row", "video_bg_url" );
vc_remove_param( "vc_row", "parallax_speed_bg" );
vc_remove_param( "vc_row", "parallax_speed_video" );

vc_add_params( 'vc_row', $attributes );

/**
 * Extend VC Inner Row
 */

$attributes = array(
    array(
        'type'		=> 'brooks_layout_select',
        'heading'		=> esc_html__('Row stretch', 'brooks'),
        'param_name'		=> 'brooks_is_container',
        'description'		=> esc_html__( 'Select stretching options for row and content.', 'brooks'),
        'weight' => 1,
        'layouts'   => array(
            'theme__container__full' => BROOKS_IMAGES . '/vc_params/full_container.png',
            'theme__container' => BROOKS_IMAGES . '/vc_params/container.png',
            'theme__container__left' => BROOKS_IMAGES . '/vc_params/left_container.png',
            'theme__container__right' => BROOKS_IMAGES . '/vc_params/right_container.png',
        ),
        'value'		=> 'theme__container__full'
    )
);

vc_add_params( 'vc_row_inner', $attributes );

/**
 * Extend VC Column
 */
$attributes = array(
    array(
        'type'		=> 'brooks_layout_select',
        'heading'		=> esc_html__('Column side inner offset', 'brooks'),
        'param_name'		=> 'brooks_column_padding',
        'description'		=> esc_html__( 'Select inner offset options for column and content.', 'brooks'),
        'weight' => 1,
        'layouts'   => array(
            'theme__container__full' => BROOKS_IMAGES . '/vc_params/full_container.png',
            'theme__container__left' => BROOKS_IMAGES . '/vc_params/left_container.png',
            'theme__container__right' => BROOKS_IMAGES . '/vc_params/right_container.png',
        ),
        'value'		=> ' '
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__('Flex Inner Blocks', 'brooks'),
        'param_name' => 'inner_flex',
        'value'		=> array(
            esc_html__( 'Yes', 'brooks') => 'yes',
        ),
        'description' => esc_html__( 'Set inner blocks as flex elements', 'brooks' ),
    ),
    array(
        'type' => 'dropdown',
        'heading'		=> esc_html__('Justify Elements', 'brooks'),
        'param_name'		=> 'elements_justify',
        'description'		=> esc_html__( 'Set alignment for inner elements.', 'brooks'),
        'value'		=> array(
            esc_html__( 'Left', 'brooks') => 'left',
            esc_html__( 'Center', 'brooks') => 'center',
            esc_html__( 'Right', 'brooks') => 'right',
            esc_html__( 'Space Between', 'brooks') => 'space__between',
            esc_html__( 'Space Around', 'brooks') => 'space__around',
        ),
        'dependency' => array(
            'element' => 'inner_flex',
            'not_empty' => true,
        ),
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
        'dependency' => array(
            'element' => 'inner_flex',
            'not_empty' => true,
        ),
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__('Fit Inner Blocks In Row', 'brooks'),
        'param_name' => 'elements_in_row',
        'value'		=> array(
            esc_html__( 'Yes', 'brooks') => 'yes',
        ),
        'dependency' => array(
            'element' => 'inner_flex',
            'not_empty' => true,
        ),
        'description' => esc_html__( 'Fit inner blocks inside row without shift', 'brooks' ),
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__('Parallax', 'brooks'),
        'param_name' => 'brooks_parallax_item',
        'value'		=> array(
            esc_html__( 'Yes', 'brooks') => 'yes',
        ),
        'description' => esc_html__( 'Add parallax for this item', 'brooks' ),
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__('Track distance', 'brooks'),
        'description' => esc_html__('Define distance of track for parallax scene( can be positive and negative, it\'ll affect direction of parallax), in px','brooks'),
        'param_name' => 'parallax_delta',
        'value'		=> '0',
        'dependency' => array(
            'element' => 'brooks_parallax_item',
            'not_empty' => true,
        ),
    ),
    array(
        'type' => 'brooks_responsive_param',
        'heading' => esc_html__( 'Position Offset and Layer Index', 'brooks' ),
        'param_name' => 'position_offset',
        'group' => esc_html__( 'Responsive Options', 'brooks' ),
        'params' => array(
            'top' => array(
                'type' => 'size',
                'heading' => esc_html__( 'Vertical Offset', 'brooks'),
                'value'		=> 0,
            ),
            'left' => array(
                'type' => 'size',
                'heading' => esc_html__( 'Horizontal Offset', 'brooks'),
                'value'		=> 0,
            ),
            'z-index' => array(
                'type' => 'number',
                'heading' => esc_html__( 'Layer Index', 'brooks'),
                'value'		=> 0,
            ),
        ),
        'description' => esc_html__( 'Set vertical/horizontal offset, negative value shifts to top/left and layer index.', 'brooks' ),
    )
);

vc_add_params( 'vc_column', $attributes );

/**
 * Extend VC Inner Column
 */
$attributes = array(
    array(
        'type' => 'checkbox',
        'heading' => esc_html__('Flex Inner Blocks', 'brooks'),
        'param_name' => 'inner_flex',
        'value'		=> array(
            esc_html__( 'Yes', 'brooks') => 'yes',
        ),
        'description' => esc_html__( 'Set inner blocks as flex elements', 'brooks' ),
    ),
    array(
        'type' => 'dropdown',
        'heading'		=> esc_html__('Justify Elements', 'brooks'),
        'param_name'		=> 'elements_justify',
        'description'		=> esc_html__( 'Set alignment for inner elements.', 'brooks'),
        'value'		=> array(
            esc_html__( 'Left', 'brooks') => 'left',
            esc_html__( 'Center', 'brooks') => 'center',
            esc_html__( 'Right', 'brooks') => 'right',
            esc_html__( 'Space Between', 'brooks') => 'space-between',
            esc_html__( 'Space Around', 'brooks') => 'space-between',
        ),
        'dependency' => array(
            'element' => 'inner_flex',
            'not_empty' => true,
        ),
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
        'dependency' => array(
            'element' => 'inner_flex',
            'not_empty' => true,
        ),
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__('Fit Inner Blocks In Row', 'brooks'),
        'param_name' => 'elements_in_row',
        'value'		=> array(
            esc_html__( 'Yes', 'brooks') => 'yes',
        ),
        'dependency' => array(
            'element' => 'inner_flex',
            'not_empty' => true,
        ),
        'description' => esc_html__( 'Fit inner blocks inside row without shift', 'brooks' ),
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__('Parallax', 'brooks'),
        'param_name' => 'brooks_parallax_item',
        'value'		=> array(
            esc_html__( 'Yes', 'brooks') => 'yes',
        ),
        'description' => esc_html__( 'Add parallax for this item', 'brooks' ),
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__('Track distance', 'brooks'),
        'description' => esc_html__('Define distance of track for parallax scene( can be positive and negative, it\'ll affect direction of parallax), in px','brooks'),
        'param_name' => 'parallax_delta',
        'value'		=> '0',
        'dependency' => array(
            'element' => 'brooks_parallax_item',
            'not_empty' => true,
        ),
    ),
    array(
        'type' => 'brooks_responsive_param',
        'heading' => esc_html__( 'Position Offset and Layer Index', 'brooks' ),
        'param_name' => 'position_offset',
        'group' => esc_html__( 'Responsive Options', 'brooks' ),
        'params' => array(
            'top' => array(
                'type' => 'size',
                'heading' => esc_html__( 'Vertical Offset', 'brooks'),
                'value'		=> 0,
            ),
            'left' => array(
                'type' => 'size',
                'heading' => esc_html__( 'Horizontal Offset', 'brooks'),
                'value'		=> 0,
            ),
            'z-index' => array(
                'type' => 'number',
                'heading' => esc_html__( 'Layer Index', 'brooks'),
                'value'		=> 0,
            ),
        ),
        'description' => esc_html__( 'Set vertical/horizontal offset, negative value shifts to top/left and layer index.', 'brooks' ),
    )
);

vc_add_params( 'vc_column_inner', $attributes );

/**
 * Extend VC Custom Heading.
 */
vc_remove_param( "vc_custom_heading", "el_class" );
vc_remove_param( "vc_custom_heading", "font_container" );

$attributes = array(
    array(
        'type' => 'font_container',
        'param_name' => 'font_container',
        'value' => 'tag:h2|text_align:left',
        'settings' => array(
            'fields' => array(
                'tag' => 'h2', // default value h2
                'text_align',
                'color',
                'tag_description' => esc_html__( 'Select element tag.', 'brooks' ),
                'text_align_description' => esc_html__( 'Select text alignment.', 'brooks' ),
                'color_description' => esc_html__( 'Select heading color.', 'brooks' ),
            ),
        ),
    ),
    array(
        'type' => 'brooks_range',
        'heading' => esc_html__( 'Font Size', 'brooks' ),
        'param_name' => 'font_size',
        'min'   => 0,
        'max'   => 100,
        'step'  => 1,
        'display_value' => esc_html__('{{value}}px', 'brooks'),
        'value' => 0,
        'edit_field_class' => 'vc_col-sm-6 vc_column',
        'description' => esc_html__( 'Set font size. 0 will use default value', 'brooks' ),
    ),
    array(
        'type' => 'dropdown',
        'heading'		=> esc_html__('Font Weight', 'brooks'),
        'param_name'		=> 'brooks_font_weight',
        'description'		=> esc_html__( 'Choose font weight.', 'brooks'),
        'value'		=> array(
            esc_html__( 'Normal', 'brooks') => '',
            esc_html__( 'Light', 'brooks') => 'light',
            esc_html__( 'Bold', 'brooks') => 'bold',
        ),
        'dependency' => array(
            'element' => 'use_theme_fonts',
            'value' => 'yes',
        ),
    ),
    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'CSS Animation', 'brooks' ),
        'param_name' => 'brooks_css_animation',
        'value' => array(
            esc_html__( 'No', 'brooks' ) => '',
            esc_html__( 'Top to bottom', 'brooks' ) => 'fadeInDown',
            esc_html__( 'Bottom to top', 'brooks' ) => 'fadeInUp',
            esc_html__( 'Left to right', 'brooks' ) => 'fadeInRight',
            esc_html__( 'Right to left', 'brooks' ) => 'fadeInLeft',
            esc_html__( 'Appear from center', 'brooks' ) => 'zoomIn',
        ),
        'description' => esc_html__( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'brooks' ),
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Extra class name', 'brooks' ),
        'param_name' => 'el_class',
        'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'brooks' ),
    ),
);

vc_add_params( 'vc_custom_heading', $attributes );

/**
 * Extend VC Column Text.
 */

vc_remove_param( "vc_column_text", "css_animation" );

$attributes = array(
    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'CSS Animation', 'brooks' ),
        'param_name' => 'brooks_css_animation',
        'value' => array(
            esc_html__( 'No', 'brooks' ) => '',
            esc_html__( 'Top to bottom', 'brooks' ) => 'fadeInDown',
            esc_html__( 'Bottom to top', 'brooks' ) => 'fadeInUp',
            esc_html__( 'Left to right', 'brooks' ) => 'fadeInRight',
            esc_html__( 'Right to left', 'brooks' ) => 'fadeInLeft',
            esc_html__( 'Appear from center', 'brooks' ) => 'zoomIn',
        ),
        'description' => esc_html__( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'brooks' ),
    ),
    array(
        'type' => 'brooks_range',
        'heading' => esc_html__( 'Font Size Multiplier', 'brooks' ),
        'param_name' => 'font_size',
        'min'   => 1,
        'max'   => 3,
        'step'  => 0.5,
        'display_value' => esc_html__('{{value}}x', 'brooks'),
        'edit_field_class' => 'vc_col-sm-6 vc_column',
        'value' => 1,
        'description' => esc_html__( 'Select multiplier for all font size in block.Ex: 2x will increase font size from 14px to 28px', 'brooks' ),
    ),
);

vc_add_params( 'vc_column_text', $attributes );

/**
 * Extend VC Empty Space
 */

vc_remove_param( "vc_empty_space", "height" );

$attributes = array(
    'type' => 'brooks_responsive_param',
    'heading' => esc_html__( 'Responsive Options', 'brooks' ),
    'param_name' => 'brooks_responsive_height',
    'weight' => 1,
    'params' => array(
        'height' => array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Height', 'brooks'),
            'value'		=> array(
                '0px' => '0',
                '5px' => '5',
                '10px' => '10',
                '15px' => '15',
                '20px' => '20',
                '25px' => '25',
                '30px' => '30',
                '35px' => '35',
                '40px' => '40',
                '45px' => '45',
                '50px' => '50',
                '60px' => '60',
                '70px' => '70',
                '80px' => '80',
                '90px' => '90',
                '100px' => '100',
                '110px' => '110',
                '120px' => '120',
                '130px' => '130',
                '140px' => '140',
                '150px' => '150',
                '160px' => '160',
                '170px' => '170',
                '180px' => '180',
                '190px' => '190',
                '200px' => '200',
                '250px' => '250',
                '300px' => '300',
                '350px' => '350',
                '400px' => '400',
                '500px' => '500',
                '750px' => '750',
                '1000px' => '1000',
            ),
        ),
    ),
    'description' => esc_html__( 'Adjust block height for different screen sizes.', 'brooks' ),
);
vc_add_param( 'vc_empty_space', $attributes );