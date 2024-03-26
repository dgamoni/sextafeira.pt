<?php
if( !post_type_exists('building') )
    return;

class WPBakeryShortCode_Brooks_Building_Search extends WPBakeryShortCode
{
    private static $ajaxActions = false;

    public function __construct( $settings ) {
        parent::__construct($settings);


        brooks_register_ajax(
            array(
                'getLocations'  => 'brooks_get_child_location',
            ),
            get_class()
        );
    }

    public static function getTermsImages($terms){
        foreach( $terms as $term ) {
            $term->image = wp_get_attachment_image_url(get_term_meta( $term->term_id, 'featured_image', true ));
        }

        return $terms;
    }

    public static function getLocations(){
        if(empty($_POST['id']))
            wp_send_json_error();

        $cities = self::getTerms(
            array(
                'taxonomy' => 'location',
                'hide_empty' => false,
                'parent' => $_POST['id'],
                'order_by' => 'name'
            ),
            true
        );

        if($cities instanceof WP_Error)
            $cities = array();

        wp_send_json_success($cities);
    }

    private static function getTerms($args, $getImages = false) {
        if($getImages)
            add_filter('get_terms', array(get_class(), 'getTermsImages'));

        $terms = get_terms($args);

        remove_filter('get_terms', array(get_class(), 'getTermsImages'));

        return $terms;
    }

    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    public function content($atts, $content = null)
    {
        $grid_id = $ajax = '';

        extract(shortcode_atts(array(
            'grid_id'   => '',
            'ajax'      => true
        ), $atts));

        $output = '';

        $countries = self::getTerms(
            array(
                'taxonomy' => 'location',
                'hide_empty' => false,
                'parent' => 0,
                'order_by' => 'name'
            ),
            true
        );

        $types = self::getTerms(
            array(
                'taxonomy' => 'types',
                'hide_empty' => false,
                'order_by' => 'name',
                'fields' => 'id=>name',
            )
        );

        if( $countries instanceof WP_Error || $types instanceof WP_Error )
            return $output;

        brooks_enqueue_custom( 'building-search' );
        brooks_enqueue_custom( 'form' );


        $output .= '<div class="building__search__form rent__list inline-form" data-container-id="'.$grid_id.'"><form>';

        $output .= '    <div class="rent__list__item">';
        $output .= '        <div class="input-field">';
        $output .= '            <select name="location" class="country__select icons"'.(empty($countries)?'disabled':'').'>';
        $output .= '                <option value="" selected>'.esc_html('ALL', 'brooks').'</option>';

        foreach($countries as $country):
            $output .= '                <option value="'.$country->term_id.'" data-icon="'.$country->image.'" class="circle">'.$country->name.'</option>';
        endforeach;

        $output .= '            </select>';
        $output .= '            <label class="text-white">'.esc_html('CHOOSE COUNTRY', 'brooks').'</label>';
        $output .= '        </div>';
        $output .= '    </div>';

        $output .= '    <div class="rent__list__item">';
        $output .= '        <div class="input-field">';
        $output .= '            <select disabled name="location" class="city__select">';
        $output .= '                <option value="" selected>'.esc_html('ALL', 'brooks').'</option>';
        $output .= '            </select>';
        $output .= '            <label class="text-white">'.esc_html('CHOOSE CITY', 'brooks').'</label>';
        $output .= '            <div class="progress ajax-loader city-loader hidden"><div class="indeterminate"></div></div>';
        $output .= '        </div>';
        $output .= '    </div>';


        $output .= '    <div class="rent__list__item">';
        $output .= '        <div class="input-field">';
        $output .= '            <select '.(empty($countries)?'disabled':'').' name="types" class="type__select">';
        $output .= '                <option value="" selected>'.esc_html('ALL', 'brooks').'</option>';

        foreach($types as $id => $name):
            $output .= '                <option value="'.$id.'">'.$name.'</option>';
        endforeach;

        $output .= '            </select>';
        $output .= '            <label class="text-white">'.esc_html('CHOOSE BUILDING TYPE', 'brooks').'</label>';
        $output .= '        </div>';
        $output .= '    </div>';

        $output .= '    <div class="rent__list__item">';
        $output .= '        <button type="submit" class="btn btn-white waves-effect waves-white"><i class="bicon bi-search margin-right-15"></i> '.esc_html('SEARCH', 'brooks').'</button>';
        $output .= '        <div class="progress ajax-loader submit-loader hidden"><div class="indeterminate"></div></div>';
        $output .= '    </div>';
        $output .= '</form></div>';

        return $output;
    }
}



$opts = array(
    'name'		=> esc_html__( 'Building Search', 'brooks' ),
    'base'		=> 'brooks_building_search',
    'controls'		=> 'edit_popup_delete',
    'category'		=> esc_html__( 'Developed for Brooks', 'brooks' ),
    'icon'		=> BROOKS_THEMEROOT.'/images/vc_icons/building_search.png',
    'params'		=> array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Unique Grid ID', 'brooks' ),
            'param_name' => 'grid_id',
            'description' => esc_html__( 'Enter unique id of "Posts Grid" if you want to use grid as result container for search.', 'brooks' ),
        ),
    )
);

vc_map($opts);
new WPBakeryShortCode_Brooks_Building_Search($opts);