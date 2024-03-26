<?php
if( !post_type_exists('team') )
    return;

class WPBakeryShortCode_Brooks_Theme_Team extends  WPBakeryShortCode
{
    /**
     * @param $atts
     * @param null $content
     * @return string
     */

    public function content($atts, $content = null)
    {
        $css = $layout = $data_query = $cols = $no_gap = $image_bg_color = $text_bg_color = $text_color = '';


        extract(shortcode_atts(array(
            'layout'        => 'column',
            'css'           => '',
            'data_query'    => '',
            'no_gap'        => '',
            'cols'          => 1,
            'image_bg_color'    => '#EEEEEE',
            'text_bg_color'     => '#EE3F54',
            'text_color'        => '#FFFFFF',
        ), $atts));

        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

        $output = '';

        $data_query .= '|post_type:team';


        list($query_args, $query_body)  = vc_build_loop_query( $data_query );

        if ($query_body->have_posts()):

            $col_class = brooks_get_responsive_class($cols);
            $output .= '<div class="theme__team__block '.$css_class.' '. ($no_gap?'-no__gap':'row') .' wpb_content_element">';
            $size = $cols >= 4 ? 'medium':'medium_large';

            while($query_body->have_posts()):$query_body->the_post();
                $title = get_the_title();
                if(empty($title))
                    continue;

                $output .= '    <div class="theme__team theme__team-' . $layout . ' ' . $col_class . '">';
                $output .= '        <div class="theme__team-in">';
                $output .= '            <div class="theme__team-pic" style="background-color: '.$image_bg_color.'">';
                $output .= '                <div class="figure__holder__1__1 image-fill" style="background-image: url(' . wp_get_attachment_image_url( get_post_thumbnail_id(), $size ) . ');"></div>';
                $output .= '            </div>';
                $output .= '            <div class="theme__team-text" style="color: '.$text_color.';background-color: '.$text_bg_color.';">';

                $output .= '                <h4 class="theme__team-fullname">'.  get_the_title()  . '</h4>';

                $position = Brooks_Meta_Options::getData('member_position', get_the_ID());
                if(!empty($position)):
                    $output .= '                <div class="theme__team-position">'.  esc_html( $position )  . '</div>';
                endif;

                $cont = get_the_content();
                if ( $layout !== 'column' && !empty($cont)):
                    $output .= '                <div class="theme__team-description">'.   $cont   . '</div>';   
                endif;
//wp_trim_words($cont, 30)
                $networks = Brooks_Meta_Options::getData('member_social', get_the_ID());

                if(!empty($networks) && !empty($networks[0]['social']) ):
                    $output .= '            <div class="team__networks">';
                    foreach( $networks as $network ):
                        if(empty($network['url']))
                            continue;

                        $output .= '                <a class="team__network" href="' . esc_url($network["url"]) . '">';
                        $output .= '                        <i class="bicon bi-' . $network["social"] . ' "></i>';
                        $output .= '                </a>';
                    endforeach;
                    $output .= '            </div>';
                endif;

                $output .= '            </div>';
                $output .= '        </div>';
                $output .= '    </div>';

            endwhile;

            $output .= '</div>';
        endif;

        return $output;
    }
}


$opts = array(
    'name'          => esc_html__( 'Team', 'brooks'),
    'base'          => 'brooks_theme_team',
    'controls'      => 'edit_popup_delete',
    'icon'          => BROOKS_IMAGES.'/vc_icons/team.png',
    'category'      => esc_html__('Developed for Brooks', 'brooks'),
    'params'        => array(
        array(
            'type' => 'loop',
            'heading' => esc_html__( 'Team Members', 'brooks' ),
            'param_name' => 'data_query',
            'value' => '',
            'settings' => array(
                'post_type'     => array( 'hidden' => true ),
                'authors'       => array( 'hidden' => true ),
                'tax_query'     => array( 'hidden' => true ),
                'categories'    => array( 'hidden' => true ),
                'tags'          => array( 'hidden' => true )
            ),
            'description' => esc_html__( 'Create WordPress loop, to populate content from your team members.', 'brooks' ),
        ),
        array(
            'type'      => 'brooks_layout_select',
            'heading'       => esc_html__('Layout Type', 'brooks'),
            'param_name'        => 'layout',
            'layouts'   => array(
                'column' => BROOKS_IMAGES . '/vc_params/column.png',
                'left' => BROOKS_IMAGES . '/vc_params/row_left.png',
                'right' => BROOKS_IMAGES . '/vc_params/row_right.png',
            ),
            'value'     => 'column'
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Columns number', 'brooks'),
            'param_name' => 'cols',
            'description' => esc_html__('Select number of columns.', 'brooks'),
            'value'   => array(
                esc_html__( '1 column', 'brooks' )  => 1,
                esc_html__( '2 columns', 'brooks' ) => 2,
                esc_html__( '3 columns', 'brooks' ) => 3,
                esc_html__( '4 columns', 'brooks' ) => 4,
                esc_html__( '6 columns', 'brooks' ) => 6,
            )
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'No gap between cells', 'brooks' ),
            'param_name' => 'no_gap',
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'brooks' ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Image background color', 'brooks' ),
            'param_name' => 'image_bg_color',
            "value" => '#EEEEEE',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Text background color', 'brooks' ),
            'param_name' => 'text_bg_color',
            "value" => '#EE3F54',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Text color', 'brooks' ),
            'param_name' => 'text_color',
            "value" => '#FFFFFF',
        ),
    )
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Theme_Team($opts);