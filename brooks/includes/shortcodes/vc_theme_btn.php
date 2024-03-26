<?php

class WPBakeryShortCode_Brooks_Theme_Btn extends  WPBakeryShortCode
{
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    public function content($atts, $content = null)
    {
        $contact_form = $link = $modal = $type = $title = $link = $color = $align = $size = $css = $css_animation = '';
        $add_icon = $i_align = $icon_lib = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = '';
        $output = '';

        $css_classes = array();
        $wrap_classes = array();

        extract(shortcode_atts(array(
            'link' => '',
            'modal' => '',
            'type' => '',
            'title' => '',
            'color' => 'color',
            'align' => 'left',
            'size' => '',
            'contact_form' => '',
            'css_animation' => '',
            'add_icon' => '',
            'i_align' => 'left',
            'icon_lib' => 'fontawesome',
            'icon_fontawesome' => '',
            'icon_openiconic' => '',
            'icon_typicons' => '',
            'icon_entypo' => '',
            'icon_linecons' => '',
            'css' => ''
        ), $atts));

        $css_classes[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        $css_classes[] = 'wpb_content_element';



        if( !empty($css_animation) ){
            $wrap_classes[] = 'theme__animation';
            $wrap_classes[] = '-'.$css_animation;
            brooks_enqueue_custom('css-animation');
        }
        $wrap_classes[] = 'text-'.$align;

        $link = vc_build_link($link);
        $icon = $href = $target = '';

        if($add_icon) {
            if(!empty(${'icon_'.$icon_lib})) {
                vc_icon_element_fonts_enqueue($icon_lib);
                $icon = '    <i class="' . ${'icon_' . $icon_lib} . '"></i>';
            }
        }

        if($type && $contact_form) {
            brooks_enqueue_custom('form');

            $modal_content = '<h4 class="text-center">'. get_the_title($contact_form) .'</h4>' . do_shortcode('[contact-form-7 id="'. $contact_form .'"]');
            $modal_id = 'modal-form-' . brooks_get_unique_id();
            $href = '#'.$modal_id;

            $css_classes[] = 'modal-trigger';

            brooks_get_modal_form($modal_content, $modal_id);
        }

        $title = $type?$title:$link['title'];
        $href = $type?$href:$link['url'];
        $target = $type?$target:($link['target'] ? ('target="' . esc_attr($link['target']) . '"') : '');

        $color = explode('|', $color);

        $css_classes[] = 'btn waves-effect';
        $css_classes[] = '_animation_' . $i_align;
        $css_classes[] = 'waves-' . reset($color);
        $css_classes[] = 'btn-' . implode(' btn-', $color);
        $css_classes[] = $size;

        $output .= '<div class="' . implode(' ', $wrap_classes) . '">';
        $output .= '    <a href="'. $href .'" class="' . implode( ' ', $css_classes ) . '" '. $target .'>' . ($i_align == 'left' ? ($icon . esc_html($title)) : (esc_html($title) . $icon)) . '</a>';
        $output .= '</div>';

        return $output;
    }
}

$opts = array(
    'name'		=> esc_html__('Theme Button', 'brooks'),
    'base'		=> 'brooks_theme_btn',
    'controls'	=> 'edit_popup_delete',
    'category'  => esc_html__('Developed for Brooks', 'brooks'),
    'icon' =>   BROOKS_IMAGES.'/vc_icons/theme_button.png',
    'params'	=> array(
        array(
            'type' => 'brooks_layout_select',
            'heading' => esc_html__('Color', 'brooks'),
            'param_name' => 'color',
            'description' => esc_html__('Select button color.', 'brooks'),
            'layouts'   => array(
                'color' => BROOKS_IMAGES . '/vc_params/filled.png',
                'color|inverse' => BROOKS_IMAGES . '/vc_params/filled-outline.png',
                'white' => BROOKS_IMAGES . '/vc_params/white.png',
                'white|inverse' => BROOKS_IMAGES . '/vc_params/white-outline.png',
            ),
            'value' => 'color'
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__('Modal Box Button', 'brooks'),
            'param_name' => 'type',
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'description' => esc_html__('If checked button will call Modal Box.', 'brooks'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Button text', 'brooks'),
            'param_name' => 'title',
            'value' => '',
            'dependency' => array(
                'element' => 'type',
                'not_empty'   => true
            ),
            'description' => esc_html__('Type name', 'brooks')
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('Link', 'brooks'),
            'param_name' => 'link',
            'value' => '',
            'dependency' => array(
                'element' => 'type',
                'is_empty' => true
            ),
            'description' => esc_html__('Type link', 'brooks')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Select contact form', 'brooks' ),
            'param_name' => 'contact_form',
            'dependency' => array(
                'element' => 'type',
                'not_empty' => true
            ),
            'value' => brooks_get_posts_list( array('post_type' => 'wpcf7_contact_form', 'numberposts' => -1) ),
            'description' => esc_html__( 'Choose previously created contact form from the drop down list.', 'brooks' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Size', 'brooks'),
            'param_name' => 'size',
            'value' => array(
                esc_html__('default','brooks') => '',
                esc_html__('large','brooks') => 'btn-md'
            ),
            'description' => esc_html__('Choose from specified options.', 'brooks'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Align', 'brooks'),
            'param_name' => 'align',
            'value' => array(
                esc_html__('left','brooks') => 'left',
                esc_html__('center','brooks') => 'center',
                esc_html__('right','brooks') => 'right'
            ),
            'description' => esc_html__('Choose from specified options.', 'brooks'),
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Add icon?', 'brooks' ),
            'param_name' => 'add_icon',
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon Alignment', 'brooks' ),
            'description' => esc_html__( 'Select icon alignment.', 'brooks' ),
            'param_name' => 'i_align',
            'value' => array(
                esc_html__( 'Left', 'brooks' ) => 'left',
                esc_html__( 'Right', 'brooks' ) => 'right',
            ),
            'dependency' => array(
                'element' => 'add_icon',
                'not_empty' => true
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon library', 'brooks' ),
            'value' => array(
                esc_html__( 'Font Awesome', 'brooks' )   => 'fontawesome',
                esc_html__( 'Open Iconic', 'brooks' )    => 'openiconic',
                esc_html__( 'Typicons', 'brooks' )       => 'typicons',
                esc_html__( 'Entypo', 'brooks' )         => 'entypo',
                esc_html__( 'Linecons', 'brooks' )       => 'linecons',
            ),
            'dependency' => array(
                'element' => 'add_icon',
                'not_empty' => true
            ),
            'param_name' => 'icon_lib',
            'description' => esc_html__( 'Select icon library.', 'brooks' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'brooks' ),
            'param_name' => 'icon_fontawesome',
            'value' => 'fa fa-adjust', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => true,
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_lib',
                'value' => 'fontawesome',
            ),
            'description' => esc_html__( 'Select icon from library.', 'brooks' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'brooks' ),
            'param_name' => 'icon_openiconic',
            'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => true, // default true, display an 'EMPTY' icon?
                'type' => 'openiconic',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'icon_lib',
                'value' => 'openiconic',
            ),
            'description' => esc_html__( 'Select icon from library.', 'brooks' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'brooks' ),
            'param_name' => 'icon_typicons',
            'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => true, // default true, display an 'EMPTY' icon?
                'type' => 'typicons',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'icon_lib',
                'value' => 'typicons',
            ),
            'description' => esc_html__( 'Select icon from library.', 'brooks' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'brooks' ),
            'param_name' => 'icon_entypo',
            'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => true, // default true, display an 'EMPTY' icon?
                'type' => 'entypo',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'icon_lib',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'brooks' ),
            'param_name' => 'icon_linecons',
            'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => true, // default true, display an 'EMPTY' icon?
                'type' => 'linecons',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'icon_lib',
                'value' => 'linecons',
            ),
            'description' => esc_html__( 'Select icon from library.', 'brooks' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'CSS Animation', 'brooks' ),
            'param_name' => 'css_animation',
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
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'brooks' ),
        ),
    )
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Theme_Btn($opts);