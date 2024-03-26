<?php
if( !post_type_exists('testimonials') )
    return;

class WPBakeryShortCode_Brooks_Testimonials_Block extends  WPBakeryShortCode
{
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    public function content($atts, $content = null)
    {
        $color_text = $data_query = $css = '';

        extract(shortcode_atts(array(
            'data_query' => '',
            'css' => '',
            'color_text' => ''
        ), $atts));

        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        $data_query .= '|post_type:testimonials';

        $output = '';

        list($query_args, $query_body)  = vc_build_loop_query( $data_query );

        if ($query_body->have_posts()):
            brooks_enqueue_custom('testimonials-slider');
            $tabs = '';
            $tablist = '';

            $id = "customer-block-". brooks_get_unique_id();
            $output .= '<div id = "'. $id . '" class="testimonials-block  customers__container  text-light '.$css_class.'">'; //<!-- TODO : move to  styte -->
            $i = 0;

            while ($query_body->have_posts()) : $query_body->the_post();

                $tabs .= '<div role="tabpanel" class=" '.(($i == 0)?'active':'').' slick-slide">';

                $tabs .= '    <div class="customers__quote" style="color: ' .  $color_text . '">'.get_the_content().'</div>';
                $tabs .= '    <h4 class="customers__name"  style="color: ' .  $color_text . '">'.get_the_title().'</h4>';
                $tabs .= '</div>';

                $tablist .= '<div role="presentation" class="customers__tab__list__item slick-slide'.(($i == 0)?'active':'').'">';
                $tablist .= '  <div class="customers__tab__list__item-in">';
                $tablist .= '       <img src="'.wp_get_attachment_image_url(get_post_thumbnail_id()).'" alt="" >';
                $tablist .= '  </div>';
                $tablist .= '</div>';

                $i++;

            endwhile;

            $output .= '    <div class="customers__tab__list slick-slider" role="tablist">' . $tablist . '</div>';
            $output .= '    <div class="tab-content slick-slider">' . $tabs . '</div>';

            $output .= '</div>';
        endif;

        wp_reset_postdata();

        return $output;
    }
}

$opts = array(
    'name'		=> esc_html__( 'Testimonials block', 'brooks' ),
    'base'		=> 'brooks_testimonials_block',
    'controls'	=> 'edit_popup_delete',
    'category'  => esc_html__( 'Developed for Brooks', 'brooks' ),
    'icon' => BROOKS_IMAGES.'/vc_icons/testimonials.png',
    'params'	=> array(
        array(
            'type' => 'loop',
            'heading' => esc_html__( 'Testimonials content', 'brooks' ),
            'param_name' => 'data_query',
            'value' => '',
            'settings' => array(
                'post_type'     => array( 'hidden' => true ),
                'authors'       => array( 'hidden' => true ),
                'by_id'         => array( 'hidden' => true )
            ),
            'description' => esc_html__( 'Create WordPress loop, to populate content from your testimonials.', 'brooks' ),
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'brooks' ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Color text', 'brooks' ),
            'param_name' => 'color_text',
            'description' => esc_html__( 'Select color text.', 'brooks' ),
        ),
    )
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Testimonials_Block($opts);