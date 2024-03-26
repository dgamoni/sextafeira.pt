<?php
class WPBakeryShortCode_Brooks_Pricing_Block extends  WPBakeryShortCode
{
    /**
     * @param $atts
     * @param null $content
     * @return string
     */

    public function content($atts, $content = null)
    {
        $title = $price = $text_color = $text_bg_color = $image = $button_type = $button_link = $button_title = $contact_form = $css = '';

        extract(shortcode_atts(array(
            'title'         => '',
            'price'         => '',
            'text_color'    => '#FFF',
            'text_bg_color' => '#EE3F54',
            'image'         => '',
            'button_type'   => '',
            'button_link'   => '',
            'button_title'  => '',
            'contact_form'  => '',
            'css'           => ''
        ), $atts));

        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

        $output = '';

        if(empty($price) || empty($title))
            return $output;

        $button = '';

        if(!$button_type) {
            $button_link = vc_build_link($button_link);
            $button = '<a href="' . esc_url($button_link['url']) . '" class="btn btn-color btn-inverse btn-block waves-effect waves-light" target="'.esc_attr($button_link['target']).'" rel="'.esc_attr($button_link['rel']).'">'.esc_html($button_link['title']).'</a>';
        } elseif( $contact_form ) {
            brooks_enqueue_custom('modal');
            brooks_enqueue_custom('form');

            $modal_content = '<h4 class="text-center">'. get_the_title($contact_form) .'</h4>' . do_shortcode('[contact-form-7 id="'. $contact_form .'"]');

            $modal_id = 'modal-form-' . brooks_get_unique_id();

            $button = '<a href="#'.$modal_id.'" class="modal-trigger btn btn-color btn-inverse btn-block waves-effect waves-light">' . esc_html($button_title) . '</a>';

            brooks_get_modal_form($modal_content, $modal_id);
        }

        $output .= '<div class="theme__pricing__item wpb_content_element '.$css_class.'">';
        $output .= '    <h2 class="theme__pricing__item__title">';
        $output .= '        <span class="theme__pricing__item__title__col theme__pricing__item__title__price" style="color:'.$text_color.';background-color:'.$text_bg_color.'">' . esc_html($price) . '</span>';
        $output .= '        <span class="theme__pricing__item__title__col">'. esc_html($title) .'</span>';
        $output .= '    </h2>';

        if(!empty($image)):
            $output .= '    <div class="theme__pricing__item__image">';
            $output .= '        <div class="image__cover" style="background-image: url('.wp_get_attachment_image_url($image, 'medium_large').');"></div>';
            $output .= '    </div>';
        endif;

        $output .= '    <div class="theme__pricing__item__wrap">';
        $output .=          wpb_js_remove_wpautop( $content, true );
        $output .=          $button;
        $output .= '    </div>';
        $output .= '</div>';


        return $output;
    }
}


$opts = array(
    'name'		    => esc_html__( 'Pricing Block', 'brooks'),
    'base'		    => 'brooks_pricing_block',
    'controls'	    => 'edit_popup_delete',
    'icon'          => BROOKS_IMAGES.'/vc_icons/pricing.png',
    'category'		=> esc_html__('Developed for Brooks', 'brooks'),
    'params'		=> array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title', 'brooks' ),
            'param_name' => 'title',
            'description' => esc_html__( 'Enter price title.', 'brooks' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Price', 'brooks' ),
            'param_name' => 'price',
            'description' => esc_html__( 'Enter price content.', 'brooks' ),
            'edit_field_class' => 'vc_col-sm-4 vc_column vc_column-with-padding',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Text color', 'brooks' ),
            'param_name' => 'text_color',
            'edit_field_class' => 'vc_col-sm-4 vc_column',
            'description' => esc_html__( 'Choose price text color.', 'brooks' ),
            'value' => '#FFFFFF',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Text background color', 'brooks' ),
            'param_name' => 'text_bg_color',
            'description' => esc_html__( 'Choose price label background color.', 'brooks' ),
            'edit_field_class' => 'vc_col-sm-4 vc_column',
            'value' => '#EE3F54',
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Image', 'brooks' ),
            'param_name' => 'image',
            'value' => '',
            'description' => esc_html__( 'Select image from media library.', 'brooks' )
        ),
        array(
            'type' => 'textarea_html',
            'heading' => esc_html__( 'Description', 'brooks' ),
            'param_name' => 'content',
            'description' => esc_html__( 'Enter your content.', 'brooks' )
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__('Modal Box Button', 'brooks'),
            'param_name' => 'button_type',
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'description' => esc_html__('If checked button will call Modal Box.', 'brooks'),
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('Link', 'brooks'),
            'param_name' => 'button_link',
            'value' => '',
            'dependency' => array(
                'element' => 'button_type',
                'is_empty' => true
            ),
            'description' => esc_html__('Set link information', 'brooks')
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Button text', 'brooks'),
            'param_name' => 'button_title',
            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
            'dependency' => array(
                'element' => 'button_type',
                'not_empty'   => true
            ),
            'description' => esc_html__('Type button text', 'brooks')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Select contact form', 'brooks' ),
            'param_name' => 'contact_form',
            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
            'dependency' => array(
                'element' => 'button_type',
                'not_empty' => true
            ),
            'value' => brooks_get_posts_list( array('post_type' => 'wpcf7_contact_form', 'numberposts' => -1) ),
            'description' => esc_html__( 'Choose previously created contact form from the drop down list.', 'brooks' )
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'brooks' ),
        )

    )
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Pricing_Block($opts);