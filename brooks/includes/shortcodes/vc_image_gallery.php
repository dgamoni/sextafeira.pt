<?php

class WPBakeryShortCode_Brooks_Image_Gallery extends  WPBakeryShortCode
{
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    public function content($atts, $content = null)
    {
        $images = $columns = $gap = $grid_type = $css = '';

        extract(shortcode_atts(array(
            'grid_type'     =>  'masonry',
            'columns'       =>  2,
            'gap'           =>  '',
            'images'        =>  '',
            'css'           =>  ''
        ), $atts));

        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        $images = explode(',', $images);
        $img_size = $columns <= 6?'medium_large':'medium';
        $output = '';

        if(!empty($images)):
            brooks_enqueue_custom('grid');
            brooks_enqueue_custom('gallery');

            $output .= '<div class="theme__grid__wrap -gap__'.$gap.'">';
            $output .= '    <div class="theme__grid theme__media__gallery grid__type__' . $grid_type . ' grid__columns__' . $columns . ' ' . $css_class . '">';

            foreach($images as $img):
                $w = $h = 1;
                $class = '';

                if($grid_type == 'metro') {
                    $image_meta = wp_get_attachment_metadata($img);
                    $ratio = $image_meta['width'] / $image_meta['height'];
                    $schema = explode('__', brooks_get_image_ratio($ratio));

                    $w = $schema[0];
                    $h = $schema[1];

                    if($w > 1 || $h > 1)
                        $img_size = 'medium_large';
                }

                $class .= ' item__width__'.$w;
                $class .= ' item__height__'.$h;

                if($grid_type == 'masonry'):
                    $output .= '    <div class="grid__item">';
                    $output .= '        <div class="grid__item__content__wrap">';
                    $output .= '            <div class="grid__item__content">';
                    $output .= '                <a class="gallery__item" href="' . wp_get_attachment_image_url($img, 'large') . '">';
                    $output .= '                    <div class="gallery__item__description">';
                    $output .= '                        <i class="bicon bi-zoom-in"></i>';
                    $output .= '                    </div>';
                    $output .= '                    <img src="' . wp_get_attachment_image_url($img, $img_size) . '" alt="" class="img-responsive">';
                    $output .= '                </a>';
                    $output .= '            </div>';
                    $output .= '        </div>';
                    $output .= '    </div>';
                else:
                    $output .= '    <div class="grid__item '.$class.'">';
                    $output .= '        <div class="grid__item__content__wrap">';
                    $output .= '            <div class="grid__item__content">';
                    $output .= '                <a class="gallery__item" href="' . wp_get_attachment_image_url($img, 'large') . '">';
                    $output .= '                    <div class="gallery__item__description">';
                    $output .= '                        <i class="bicon bi-zoom-in"></i>';
                    $output .= '                    </div>';
                    $output .= '                    <div class="blog__grid__image -image__fill" style="background-image: url(' . wp_get_attachment_image_url($img, $img_size) . ');"></div>';
                    $output .= '                </a>';
                    $output .= '            </div>';
                    $output .= '        </div>';
                    $output .= '    </div>';
                endif;

            endforeach;

            $output .= '    </div>';
            $output .= '</div>';
        endif;

        return $output;
    }
}


$opts = array(
    'name'		=> esc_html__( 'Image Gallery', 'brooks'),
    'base'		=> 'brooks_image_gallery',
    'controls'		=> 'edit_popup_delete',
    'category'		=> esc_html__('Developed for Brooks', 'brooks'),
    'icon'		=> BROOKS_IMAGES.'/vc_icons/image_gallery.png',

    'params'		=> array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Columns number', 'brooks'),
            'param_name' => 'columns',
            'admin_label' => true,
            'description' => esc_html__('Select number of columns.', 'brooks'),
            'value'   => array(
                esc_html__( '2 columns', 'brooks' ) => '2',
                esc_html__( '3 columns', 'brooks' ) => '3',
                esc_html__( '4 columns', 'brooks' ) => '4',
                esc_html__( '5 columns', 'brooks' ) => '5',
                esc_html__( '6 columns', 'brooks' ) => '6',
                esc_html__( '8 columns', 'brooks' ) => '8',
            )
        ),
        array(
            'type' => 'brooks_layout_select',
            'heading' => esc_html__('Grid Type', 'brooks'),
            'param_name' => 'grid_type',
            'description' => esc_html__('Select grid type.', 'brooks'),
            'admin_label' => true,
            'layouts'   => array(
                'masonry' => BROOKS_IMAGES . '/metabox_params/masonry.png',
                'simple' => BROOKS_IMAGES . '/metabox_params/simple.png',
                'metro'     => BROOKS_IMAGES . '/metabox_params/complex.png'
            ),
            'value' => 'masonry'
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Grid Gap', 'brooks'),
            'param_name' => 'gap',
            'admin_label' => true,
            'value' => array(
                esc_html__( 'No', 'brooks' ) =>  '',
                esc_html__( 'Small Gap', 'brooks' ) => '15',
                esc_html__( 'Large Gap', 'brooks' ) => '30'
            )
        ),
        array(
            'type' => 'attach_images',
            'heading' => esc_html__( 'Images', 'brooks' ),
            'param_name' => 'images',
            'value' => '',
            'description' => esc_html__( 'Select images from media library.', 'brooks' ),
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
new WPBakeryShortCode_Brooks_Image_Gallery($opts);