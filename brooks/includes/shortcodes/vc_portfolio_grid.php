<?php

if( !post_type_exists('portfolio') )
    return;

class   WPBakeryShortCode_Brooks_Portfolio_Grid extends  WPBakeryShortCode
{
    public function __construct( $settings ) {
        parent::__construct($settings);

        brooks_register_ajax(array(
            'brooks_like_post' => 'brooks_like_post'
        ));
        brooks_register_ajax(
            array(
                'getItems' => 'brooks_get_grid_items',
            ),
            get_class()
        );
    }
    public function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
    public function array_intersection($array, $array2, $key) {
        $temp_array = array();
        foreach($array as $val) {
            if (in_array($val[$key], $array2)) {
                $temp_array[] = $val;
            }
        }
        return $temp_array;
    }
    public static function getItems(){

        if( count($_POST['terms']) > 0 )
        {   if($_POST['category'] == -1) {
                $filtered_terms = $_POST['terms'];
                array_shift($filtered_terms);
                $filtered_terms = array_map(function ($item) {
                    return $item['term_id'];
                }, $filtered_terms);
            }
            else{
                $filtered_terms = $_POST['category'];
            }
            $args = array(
                'post_type' => 'portfolio',
                'numberposts' => $_POST['items'],
                'offset' => $_POST['offset'],
                'orderby' => $_POST['orderby'],
                'order' => $_POST['order'],
                'exclude' => $_POST['exclude'],
                'tax_query' => array(
                    array(
                        'taxonomy' => 'portfolio_category',
                        'terms' =>  $filtered_terms ,
                        'field' => 'term_id',
                    ),
                )
            );
        } else {

            $args = array(
                'post_type' => 'portfolio',
                'numberposts' => $_POST['items'],
                'offset' => $_POST['offset'],
                'exclude' => $_POST['exclude'],
                'orderby' => $_POST['orderby'],
                'order' => $_POST['order']
            );

        }

        $portfolio = get_posts($args);

        $portfolio = array_map(function($post){
            $featured = $image = $cover = null;
            $format = '1__1';
            $class = '';
            $output = '';
            $img_size = $_POST['columns'] <= 6?'medium_large':'medium';
            $img_id = get_post_thumbnail_id($post->ID);
            if($_POST['grid_type'] == 'metro' || $_POST['grid_type'] == 'simple'){
                $featured = Brooks_Meta_Options::getData('post_featured', $post->ID);

                if($_POST['grid_type'] == 'metro')
                    $format = Brooks_Meta_Options::getData('post_loop_format', $post->ID);

                $format = explode('__', $format);

                if($featured) {
                    $format[0] = $format[0] + 1;
                    $format[1] = $format[1] + 1;
                    $img_size = 'medium_large';
                }

                $class .= ' item__width__' . $format[0];
                $class .= ' item__height__' . $format[1];

                if($img_id) {
                    $image = image_downsize($img_id, $img_size);
                    $image = '<div class="figure__holder__'.$format[0].'__'.$format[1].' portfolio__image image-fill" style="background-image: url('.$image[0].')"></div>';
                } else {
                    $image = '<div class="figure__holder__'.$format[0].'__'.$format[1].' portfolio__image theme__no__image__pattern"></div>';
                }
            } else {
                if($img_id) {
                    $image = image_downsize($img_id, $img_size);

                    if($image[1] / $image[2] > 2)
                        $image = '<div class="portfolio__image figure__holder__3__2 image-fill" style="background-image: url('.$image[0].')"></div>';
                    else
                        $image = '<img src="' . $image[0] . '" alt="" class="img-responsive">';
                } else {
                    $image = '<div class="portfolio__image figure__holder__1__1 theme__no__image__pattern"></div>';
                }
            }

            $cats = wp_get_post_terms($post->ID, 'portfolio_category');

            $cats = array_map(function($cat){
                return $cat->name;
            }, $cats);
            $cats = implode(' | ', $cats);

            if($_POST['layout'] == 'standard') {
                $class .= ' padding-top-80';

                $cover  = '<div class="portfolio__standard__cover"><div class="content__holder"><a class="theme__like__post" data-post-id="'.$post->ID.'" href="#!">';
                if(empty($_COOKIE['brooks_post_' . $post->ID . '_liked'])):
                    $cover .= '<i class="post__unliked bicon bi-heart"></i><i class="post__liked hidden bicon bi-heart-fill"></i></a><a href="'.get_permalink($post->ID).'"><i class="bicon bi-link"></i>';
                else:
                    $cover .= '<i class="post__unliked hidden bicon bi-heart"></i><i class="post__liked bicon bi-heart-fill"></i></a><a href="'.get_permalink($post->ID).'"><i class="bicon bi-link"></i>';
                endif;
                $cover .= '</a></div></div>';
            }

            $output .= '    <div id="'. $post->ID .'" class="grid__item ' . $class . '">';
            $output .= '        <div class="grid__item__content__wrap">';
            $output .= '            <div class="grid__item__content">';
            $output .= '                        <a href="'.get_permalink($post->ID).'" class="portfolio__content__wrap">';
            $output .= '                <div class="portfolio__grid__item portfolio__item__'.$_POST['layout'].' theme__animation -fadeInDown">';
            $output .= '                    <div class="portfoliio__image__wrap">';
            $output .=                          $image;
            $output .=                          $cover;
            $output .= '                    </div>';
            $output .= '                    <div class="portfolio__inner">';
           
            $output .= '                            <h4>'.$post->post_title.'</h4>';
           
            $output .= '                        <div class="portfolio__categories">'. $cats .'</div>';
            $output .= '                    </div>';
            $output .= '                </div>';
            $output .= '                        </a>';
            $output .= '            </div>';
            $output .= '        </div>';
            $output .= '    </div>';
            return $output;
        }, $portfolio);

        wp_send_json_success($portfolio);

    }
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    public function content($atts, $content = null)
    {
        $layout = $items = $terms = $orderby = $order = $columns = $gap = $grid_type = $css = $ajax_folio = $ajax_button = $filter_folio = '';

        extract(shortcode_atts(array(
            'layout' => 'standard',
            'items' => 12,
            'terms' => '',
            'orderby' => 'date',
            'order' => 'DESC',
            'grid_type' => 'masonry',
            'columns' => 2,
            'gap' => '',
            'images' => '',
            'css' => '',
            'ajax_button' => false,
            'ajax_folio' => false,
            'filter_folio' => false
        ), $atts));

        $output = '';
        $exclude = array();
        $categoties = array();
        $terms_cat_id = array();
        $args = array(
            'post_type' => 'portfolio',
            'numberposts' => $items,
            'orderby' => $orderby,
            'order' => $order
        );

        if (!empty($terms)) {
            $terms = explode(',', $terms);
            $args['tax_query']['relation'] = 'OR';
            foreach ($terms as $tax) {
                $tax = explode('|', $tax);
                $terms_cat_id[] = $tax[0];
                $args['tax_query'][] = array(
                    'taxonomy' => $tax[1],
                    'field' => 'id',
                    'terms' => $tax[0],
                );
                $quantityTermObject = get_term_by( 'id', $tax[0], $tax[1] );
                $categoties[] = array('name' => $quantityTermObject->name, 'term_id' => $tax[0]) ;
            }

        }

        $posts = get_posts($args);

        if (empty($posts))
            return $output;

        brooks_enqueue_custom('post-counter');
        brooks_enqueue_custom('css-animation');
        brooks_enqueue_custom('filter');

        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), $this->settings['base'], $atts);
        $img_size = $columns <= 6 ? 'medium_large' : 'medium';

        brooks_enqueue_custom('grid');
        $uid = brooks_get_unique_id();


        $output .= '<div class="theme__grid__wrap -gap__' . $gap . '" id="' . $uid . '">';
        $output .= '    <div class="theme__grid theme__portfolio__grid wpb_content_element portfolio__type__' . $layout . ' grid__type__' . $grid_type . ' grid__columns__' . $columns . ' ' . $css_class . '">';

        foreach ($posts as $one):
            $img_id = get_post_thumbnail_id($one->ID);

            $featured = $image = $cover = null;
            $format = '1__1';
            $class = '';

            if ($grid_type == 'metro' || $grid_type == 'simple') {
                $featured = Brooks_Meta_Options::getData('post_featured', $one->ID);

                if ($grid_type == 'metro')
                    $format = Brooks_Meta_Options::getData('post_loop_format', $one->ID);

                $format = explode('__', $format);

                if ($featured) {
                    $format[0] = $format[0] + 1;
                    $format[1] = $format[1] + 1;
                    $img_size = 'medium_large';
                }

                $class .= ' item__width__' . $format[0];
                $class .= ' item__height__' . $format[1];

                if ($img_id) {
                    $image = image_downsize($img_id, $img_size);
                    $image = '<div class="figure__holder__' . $format[0] . '__' . $format[1] . ' portfolio__image image-fill" style="background-image: url(' . $image[0] . ')"></div>';
                } else {
                    $image = '<div class="figure__holder__' . $format[0] . '__' . $format[1] . ' portfolio__image theme__no__image__pattern"></div>';
                }
            } else {
                if ($img_id) {
                    $image = image_downsize($img_id, $img_size);

                    if ($image[1] / $image[2] > 2)
                        $image = '<div class="portfolio__image figure__holder__3__2 image-fill" style="background-image: url(' . $image[0] . ')"></div>';
                    else
                        $image = '<img src="' . $image[0] . '" alt="" class="img-responsive">';
                } else {
                    $image = '<div class="portfolio__image figure__holder__1__1 theme__no__image__pattern"></div>';
                }
            }

            $catsObjs = wp_get_post_terms($one->ID, 'portfolio_category');

            $cats = array_map(function ($cat) {
                return $cat->name;
            }, $catsObjs);


            $cats = implode(' | ', $cats);


            if ($layout == 'standard') {
                $class .= ' padding-top-80';

                $cover = '<div class="portfolio__standard__cover"><div class="content__holder"><a class="theme__like__post" data-post-id="' . $one->ID . '" href="#!">';
                if (empty($_COOKIE['brooks_post_' . $one->ID . '_liked'])):
                    $cover .= '<i class="post__unliked bicon bi-heart"></i><i class="post__liked hidden bicon bi-heart-fill"></i></a><a href="' . get_permalink($one->ID) . '"><i class="bicon bi-link"></i>';
                else:
                    $cover .= '<i class="post__unliked hidden bicon bi-heart"></i><i class="post__liked bicon bi-heart-fill"></i></a><a href="' . get_permalink($one->ID) . '"><i class="bicon bi-link"></i>';
                endif;
                $cover .= '</a></div></div>';
            }

            $output .= '    <div id="'. $one->ID .'" class="grid__item ' . $class . '">';
            $output .= '        <div class="grid__item__content__wrap">';
            $output .= '            <div class="grid__item__content">';
            $output .= '                        <a href="' . get_permalink($one->ID) . '" class="portfolio__content__wrap">';
            $output .= '                <div class="portfolio__grid__item portfolio__item__' . $layout . ' theme__animation -fadeInDown">';
            $output .= '                    <div class="portfoliio__image__wrap">';
            $output .= $image;
            $output .= $cover;
            $output .= '                    </div>';
            $output .= '                    <div class="portfolio__inner">';
            $output .= '                            <h4>' . $one->post_title . '</h4>';
           
            $output .= '                        <div class="portfolio__categories">' . $cats . '</div>';
            $output .= '                    </div>';
            $output .= '                </div>';
            $output .= '                        </a>';
            $output .= '            </div>';
            $output .= '        </div>';
            $output .= '    </div>';

        endforeach;

        $output .= '    </div>';
        if($ajax_folio){
        $output .= ($ajax_button )
            ?
            '<button class="btn btn-md btn-color" id="brooks__loader-button"><span> <div class="preloader-wrapper active">
                <div class="spinner-layer">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            </span>'. esc_html__('LOAD MORE','brooks') .'</button>'
            :
            '<div id="brooks__loader-trigger">
                <div class="preloader-wrapper active">
                <div class="spinner-layer">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                        </div><div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>';
        }
        $output .= '</div>';



        $categoties = $this->unique_multidim_array($categoties, 'name');
        $categoties = $this->array_intersection($categoties, $terms_cat_id ,'term_id');
        if($terms != '') {
            array_unshift($categoties, array('name' => esc_html__('ALL', 'brooks'), 'term_id' => -1));
        }
        $grid_settings = array(

            'orderby'   => $orderby,
            'order'     => $order,
            'grid_type'=> $grid_type,
            'layout' => $layout,
            'columns'     => $columns,
            'terms'   =>  $categoties,
            'items' => $items,
            'ajax_folio' => $ajax_folio,
            'ajax_button' => $ajax_button,
            'filter_folio' => $filter_folio || $ajax_folio
        );

        brooks_add_frontend_data( array('Data', 'PortfolioGrid'), $grid_settings );
        return $output;
    }
}

$portfolio_terms = array();
$data = get_terms(array(
    'taxonomy'  => array('portfolio_category'),
    'hide_empty'    => false,
));

if( !($data instanceof WP_Error) ){
    foreach($data as $term) {
        $portfolio_terms[] = array(
            'label' => $term->name,
            'value' => $term->term_id . '|' . $term->taxonomy,
            'group' => ucfirst($term->taxonomy)
        );
    }
}

$opts = array(
    'name'		=> esc_html__( 'Portfolio Grid', 'brooks'),
    'base'		=> 'brooks_portfolio_grid',
    'controls'		=> 'edit_popup_delete',
    'category'		=> esc_html__('Developed for Brooks', 'brooks'),
    'icon'		=> BROOKS_IMAGES.'/vc_icons/portfolio_grid.png',

    'params'		=> array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Layout type', 'brooks'),
            'param_name' => 'layout',
            'admin_label' => true,
            'description' => esc_html__('Choose layout type.', 'brooks'),
            'value'   => array(
                esc_html__( 'Standard', 'brooks' ) => 'standard',
                esc_html__( 'Cover', 'brooks' ) => 'cover',
            )
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Columns number', 'brooks'),
            'param_name' => 'columns',
            'admin_label' => true,
            'description' => esc_html__('Select number of columns.', 'brooks'),
            'value'   => array(
                esc_html__( '1 columns', 'brooks' ) => '1',
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

        // Data settings
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Items number', 'brooks' ),
            'param_name' => 'items',
            'value' => 12,
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
                'values'   => $portfolio_terms
            ),
            'description' => esc_html__( 'Filter by Portfolio Categories', 'brooks' ),
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__('Enable filters mode ', 'brooks'),
            'param_name' => 'filter_folio',
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'description' => esc_html__('Enable/Disable filters in portfolio', 'brooks'),

        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__('Enable ajax mode ', 'brooks'),
            'param_name' => 'ajax_folio',
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'description' => esc_html__('Ajax can change content dynamically without the need to reload the entire page.', 'brooks'),

        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__('Enable button', 'brooks'),
            'param_name' => 'ajax_button',
            'value' => array( esc_html__( 'Yes', 'brooks' ) => 'yes' ),
            'description' => esc_html__('By default the content are loaded while you scroll, but if you prefer do it by press button, enable this option', 'brooks'),
            'dependency' => array(
                'element' => 'ajax_folio',
                'not_empty'   => true
            ),
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'brooks' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'brooks' ),
            'dependency' => array(
                'element' => 'type',
                'not_empty'   => true
            ),
        ),

    )
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Portfolio_Grid($opts);