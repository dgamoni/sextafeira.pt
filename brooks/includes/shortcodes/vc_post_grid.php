<?php

class WPBakeryShortCode_Brooks_Post_Grid extends  WPBakeryShortCode
{
    public function __construct( $settings ) {
        parent::__construct($settings);

        brooks_register_ajax(array(
            'brooks_like_post' => 'brooks_like_post'
        ));
    }

    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    public function content($atts, $content = null)
    {
        $data_query = $columns = $gap = $grid_type = $css = '';

        extract(shortcode_atts(array(
            'data_query'    => '',
            'grid_type'     => 'simple',
            'columns'       => 1,
            'gap'           => '',
            'css'           => ''
        ), $atts));

        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

        $output = '';

        $data_query .= '|post_type:post';


        list($query_args, $query_body)  = vc_build_loop_query( $data_query );

        if ($query_body->have_posts()):
            if($grid_type != 'standart') {
                brooks_enqueue_custom('grid');
                brooks_enqueue_custom('css-animation');
            }

            global $brooks_blog_settings;
            $brooks_blog_settings = array(
                'blog_grid' => $grid_type,
                'grid_item_simple' => true,
            );

            $output .= '<div class="wpb_content_element ' . $css_class . '">';
            $output .= '<div class="'. ($grid_type != 'standart'?'theme__grid__wrap -gap__'.$gap:'') .'">';
            $output .= '    <div class="padding-top-0 blog__list__'. $grid_type .' '. ($grid_type != 'standart'?('theme__grid grid__columns__' . $columns):'').'">';

            ob_start();

            while($query_body->have_posts()):$query_body->the_post();
                if(is_sticky())
                    continue;

                if($grid_type == 'standart')
                    get_template_part( '/templates/blog/loop-standart/format', brooks_get_post_format() );
                else
                    get_template_part( '/templates/blog/loop-grid/format', brooks_get_post_format() );

            endwhile;

            $output .= ob_get_contents();
            ob_clean();

            $output .= '    </div>';
            $output .= '</div>';
            $output .= '</div>';

        endif;

        wp_reset_postdata();

        return $output;
    }
}

$opts = array(
    'name'		=> esc_html__( 'Post Feed', 'brooks'),
    'base'		=> 'brooks_post_grid',
    'controls'		=> 'edit_popup_delete',
    'category'		=> esc_html__('Developed for Brooks', 'brooks'),
    'icon'		=> BROOKS_IMAGES.'/vc_icons/portfolio_grid.png',

    'params'		=> array(
        array(
            'type' => 'loop',
            'heading' => esc_html__( 'Posts', 'brooks' ),
            'param_name' => 'data_query',
            'value' => '',
            'settings' => array(
                'post_type'     => array( 'hidden' => true ),
                'authors'       => array( 'hidden' => true ),
                'tax_query'     => array( 'hidden' => true ),
            ),
            'description' => esc_html__( 'Create WordPress loop, to populate content from your posts.', 'brooks' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Columns number', 'brooks'),
            'param_name' => 'columns',
            'admin_label' => true,
            'description' => esc_html__('Select number of columns.', 'brooks'),
            'value'   => array(
                esc_html__( '1 columns', 'brooks' ) => 1,
                esc_html__( '2 columns', 'brooks' ) => 2,
                esc_html__( '3 columns', 'brooks' ) => 3,
                esc_html__( '4 columns', 'brooks' ) => 4,
                esc_html__( '5 columns', 'brooks' ) => 5,
                esc_html__( '6 columns', 'brooks' ) => 6,
                esc_html__( '8 columns', 'brooks' ) => 8,
            )
        ),
        array(
            'type' => 'brooks_layout_select',
            'heading' => esc_html__('Grid Type', 'brooks'),
            'param_name' => 'grid_type',
            'description' => esc_html__('Select grid type.', 'brooks'),
            'admin_label' => true,
            'layouts'   => array(
                'standart' => BROOKS_IMAGES . '/metabox_params/standart.png',
                'masonry' => BROOKS_IMAGES . '/metabox_params/masonry.png',
                'simple'  => BROOKS_IMAGES . '/metabox_params/simple.png',
                'metro'   => BROOKS_IMAGES . '/metabox_params/complex.png'
            ),
            'value' => 'simple'
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
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'brooks' ),
        ),
    )
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Post_Grid($opts);