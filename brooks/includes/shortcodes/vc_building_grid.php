<?php
if( !post_type_exists('building') )
    return;

class WPBakeryShortCode_Brooks_Building_Grid extends  WPBakeryShortCode
{
    public function __construct( $settings ) {
        parent::__construct($settings);


        brooks_register_ajax(
            array(
                'getGridPosts' => 'brooks_get_grid_posts',
            ),
            get_class()
        );
    }

    public static function getGridPosts(){
        $args = array(
            'post_type' => 'building',
            'numberposts'     => $_POST['max_items'],
//            'numberposts'     => ($_POST['style'] != 'all' && $_POST['items_per_page'] < $_POST['max_items'])?$_POST['max_items']:$_POST['items_per_page'],
//            'offset'    => $_POST['offset'], TODO: Post Grid Pagination
            'orderby'   => $_POST['orderby'],
            'order'     => $_POST['order'],
            'tax_query' => array()
        );

        $taxs = array();
        if(isset($_POST['city']) && !empty($_POST['city']))
            $taxs['location'] = $_POST['city'];
        elseif(isset($_POST['country']) && !empty($_POST['country']))
            $taxs['location'] = $_POST['country'];

        if(isset($_POST['type']) && !empty($_POST['type']))
            $taxs['types'] = $_POST['type'];

        foreach ($taxs as $tax => $id) {
            $args['tax_query'][] = array(
                'taxonomy' => $tax,
                'field'    => 'id',
                'terms'    => $id
            );
        }

        $buildings = get_posts($args);

        $buildings = array_map(function($post){
            $img_id = get_post_thumbnail_id($post->ID);

            $post->image = wp_get_attachment_image_url( $img_id,'large');
            $post->permalink = get_permalink($post->ID);


                $type = get_the_terms( $post->ID, 'types' );
                $type = $type?reset($type)->name:'';

                $post_params = array(
                    'permalink' => $post->permalink,
                    'image' => wp_get_attachment_image_url($img_id, 'medium'),
                    'title' => $post->post_title,
                    'address' => rwmb_meta('address', array(), $post->ID),
                    'type' => $type,
                );

                $position = explode(',', get_post_meta($post->ID, 'map', true));
                $post->marker = array(
                    'latitude' => $position[0],
                    'longitude' => $position[1],
                    'ID' => $post->ID,
                    'markup' => '<div class="simple-marker"><i class="bicon bi-pin-fill"></i></div>',
                    'content' => array(
                        'template' => 'marker_content',
                        'data' => $post_params
                    )
                );


            return $post;
        }, $buildings);

        wp_send_json_success($buildings);
    }

    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    public function content($atts, $content = null)
    {
        $terms = $post_type = $google_map = $max_items = $style = $items_per_page = $items_per_page = $element_width = $orderby = $order = $el_class = $grid_id = $css = '';

        $atts = shortcode_atts(array(
            'post_type' => 'building',
            'max_items' => 10,
            'style'     => 'all',
            'items_per_page'    => 8,
            'element_width'     => 4,
            'orderby'   => 'date',
            'order'     => 'DESC',
            'el_class'  => '',
            'grid_id'   => '',
            'google_map' => '',
            'css'       => '',
            'terms'     => ''
        ), $atts);

        $atts['element_width'] = brooks_get_responsive_class( $atts['element_width'] );

        extract($atts);

        unset($atts['el_class']);
        unset($atts['grid_id']);
        unset($atts['css']);

        $data_grid_query = $atts;

        $output = '';
        $args = array(
            'post_type' => $post_type,
//            'numberposts'     => ($style != 'all' && $items_per_page < $max_items)?$max_items:$items_per_page,
            'numberposts'     => $max_items,
            'orderby'   => $orderby,
            'order'     => $order,
        );

        if(!empty($terms)) {
            $terms = explode(',', $terms);

            foreach ($terms as $tax) {
                $tax = explode('|', $tax);

                $args['tax_query'][] = array(
                    'taxonomy' => $tax[1],
                    'field'    => 'id',
                    'terms'    => $tax[0]
                );
            }
        }

        $posts = get_posts($args);


        $single = include( BROOKS_INCLUDES . '/shortcodes/templates/vc_post_grid-single_post-building.php' );

        brooks_enqueue_custom('post-grid');

        $grid_settings = array(
            'gridQuery' => $data_grid_query,
            'template'  => $single,
        );

        if(empty($posts))
            return $output;

        if($google_map):
            brooks_enqueue_custom('map');

            $map_id = 'map_block_'.brooks_get_unique_id();
            $map_preloader_id = 'map_block_'.brooks_get_unique_id();

            $map_mode = '-normal';
            $map_bw = false;
            $map_bw = $map_bw?'-mono':'';

            $map_settings = array(
                'preloader'     => $map_preloader_id,
                'markerImage'   => BROOKS_IMAGES . '/40x40.png',
                'clusterImage'  => BROOKS_IMAGES . '/40x40.png',
                'markers'       => array(
                )
            );

            $grid_settings['mapId'] = $map_id;

            $output .= '<div class="theme__map__wrap">';
            $output .= '    <div class="space__offset__xs__150"></div>';
            $output .= '    <div class="theme__google__map__block '.$map_mode.' '.$map_bw.'" id="'.$map_id.'"></div>';
            $output .= '    <div class="theme__google__map__preloader" id="'.$map_preloader_id.'">';
            $output .= '        <div class="preloader-wrapper active">';
            $output .= '            <div class="spinner-layer">';
            $output .= '                <div class="circle-clipper left">';
            $output .= '                    <div class="circle"></div>';
            $output .= '                </div><div class="gap-patch">';
            $output .= '            <div class="circle"></div>';
            $output .= '            </div><div class="circle-clipper right">';
            $output .= '                <div class="circle"></div>';
            $output .= '                </div>';
            $output .= '            </div>';
            $output .= '        </div>';
            $output .= '    </div>';
            $output .= '    <div class="space__offset__xs__150"></div>';
            $output .= '</div>';

        endif;


        $output .= '<div class="row search__results__container wpb_content_element" id="' . $grid_id . '">';

        foreach($posts as $post):


                $type = get_the_terms( $post->ID, 'types' );
                $type = $type?reset($type)->name:'';

                $post_params = array(
                    'permalink' => get_permalink($post->ID),
                    'image'     => wp_get_attachment_image_url(get_post_thumbnail_id($post->ID) ,'medium'),
                    'title'     => get_the_title($post->ID),
                    'address'   => rwmb_meta( 'address', array(), $post->ID ),
                    'type'      => $type,
                    'email'     => rwmb_meta( 'email', array(), $post->ID ),
                    'phone'     => rwmb_meta( 'phone', array(), $post->ID ),
                    'id' => 'brooks-grid-single-post-' . $post->ID,
                    'responsive_item_class' => $element_width,
                );

                if($google_map):
                    $position = explode(',', rwmb_meta('map', array(), $post->ID));
                    $map_settings['markers'][] = array(
                        'latitude' => $position[0],
                        'longitude' => $position[1],
                        'ID'    => $post->ID,
                        'markup' => '<div class="simple-marker"><i class="bicon bi-pin-fill"></i></div>',
                        'content' => array(
                            'template' => 'marker_content',
                            'data' => $post_params
                        )
                    );
                endif;

                $output .= brooks_fill_template($single, $post_params);


        endforeach;

        $output .= '    <div class="hidden empty__search__result col-xs-12 text-center"><p>' . esc_html__('Buildings not found', 'brooks'). '</p></div>';
        $output .= '</div>';


        brooks_add_frontend_data( array('Data', 'Map', 'templates'), array( 'marker_content' => include BROOKS_TEMPLATES . '/map/marker-content.php') );

        if($google_map)
            brooks_add_frontend_data( array('Data', 'Map', $map_id), $map_settings );

        brooks_add_frontend_data( array('Data', 'PostGrid', $grid_id), $grid_settings );

        return $output;
    }
}

$building_terms = array();
$data = get_terms(array(
    'taxonomy'  => array('building_category', 'location', 'types'),
    'hide_empty'    => false,
));

if( !($data instanceof WP_Error) ){
    foreach($data as $term) {
        $building_terms[] = array(
            'label' => $term->name,
            'value' => $term->term_id . '|' . $term->taxonomy,
            'group' => ucfirst($term->taxonomy)
        );
    }
}

$opts = array(
    'name'		=> esc_html__( 'Buildings Grid', 'brooks' ),
    'base'		=> 'brooks_building_grid',
    'controls'		=> 'edit_popup_delete',
    'category'		=> esc_html__( 'Developed for Brooks', 'brooks' ),
    'icon'		=> BROOKS_THEMEROOT.'/images/vc_icons/building_grid.png',
    'params'		=> array(

                /** TODO: Load More **/
                /** TODO: Lazy loading **/
                /** TODO: Lazy Pagination **/

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Grid elements per row', 'brooks' ),
            'param_name' => 'element_width',
            'value' => array(2, 3, 4, 6, 8),
            'std' => 4,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'description' => esc_html__( 'Select number of single grid elements per row.', 'brooks' ),
        ),
        array(
            'type' => 'checkbox',
            'heading'		=> esc_html__('Use Google Map', 'brooks'),
            'param_name'		=> 'google_map',
            'description'		=> esc_html__( 'Choose to use google map before grid.', 'brooks'),
            'value'		=> array(
                esc_html__( 'Yes', 'brooks') => 'yes',
            )
        ),

        // Data settings
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Total items', 'brooks' ),
            'param_name' => 'max_items',
            'value' => 10,
            // default value
            'group' => esc_html__( 'Data Settings', 'brooks' ),
            'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all.', 'brooks' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Order by', 'brooks' ),
            'param_name' => 'orderby',
            'value' => array(
                esc_html__( 'Date', 'brooks' ) => 'date',
                esc_html__( 'Title', 'brooks' ) => 'title',
                esc_html__( 'Order by post ID', 'brooks' ) => 'ID',
                esc_html__( 'Author', 'brooks' ) => 'author',
                esc_html__( 'Title', 'brooks' ) => 'title',
                esc_html__( 'Last modified date', 'brooks' ) => 'modified',
                esc_html__( 'Number of comments', 'brooks' ) => 'comment_count',
                esc_html__( 'Category', 'brooks' ) => 'category',
                esc_html__( 'Menu order/Page Order', 'brooks' ) => 'menu_order',
                esc_html__( 'Random order', 'brooks' ) => 'rand',
            ),
            'description' => esc_html__( 'Select order type.', 'brooks' ),
            'group' => esc_html__( 'Data Settings', 'brooks' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Sort order', 'brooks' ),
            'param_name' => 'order',
            'group' => esc_html__( 'Data Settings', 'brooks' ),
            'value' => array(
                esc_html__( 'Descending', 'brooks' ) => 'DESC',
                esc_html__( 'Ascending', 'brooks' ) => 'ASC',
            ),
            'description' => esc_html__( 'Select sorting order.', 'brooks' ),
        ),
        array(
            'type'        => 'autocomplete',
            'heading'     => esc_html__( 'Taxonomies', 'brooks' ),
            'param_name'  => 'terms',
            'group' => esc_html__( 'Data Settings', 'brooks' ),
            'settings'    => array(
                'multiple' => true,
                'groups' => true,
                'unique_values' => true,
                'display_inline' => true,
                'values'   => $building_terms
            ),
            'description' => esc_html__( 'Filter by Building Taxonomies(Category, Location, Type)', 'brooks' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'brooks' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'brooks' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Unique Grid ID', 'brooks' ),
            'param_name' => 'grid_id',
            'description' => esc_html__( 'Set unique id if you want to use grid as result container for search.', 'brooks' ),
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'CSS box', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design Options', 'brooks' )
        ),
    )
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Building_Grid($opts);