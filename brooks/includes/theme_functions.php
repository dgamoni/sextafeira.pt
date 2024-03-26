<?php
use Mexitek\PHPColors\BrooksColor;


/**
 * Generate unique random slug
 *
 * @return string
 */
function brooks_get_unique_id() {
    return mt_rand(1000,9000) . '_' . mt_rand(1000,9999);
}


/**
 * Display one comment template
 *
 * @param $comment
 * @param $args
 * @param $depth
 */
function brooks_comment_template($comment, $args, $depth) { ?>
<li id="comment-<?php comment_ID() ?>">
    <div class="comments__list__inner">
        <div class="comments__list__head">
            <?php echo get_avatar($comment, $size='60', '', '', array('class'=>'img-circle')); ?>
            <div class="user__info">
                <p class="comments__autor__name"><?php comment_author_link();?><span class="comment__date"><?php printf(esc_html__('%1$s %2$s', 'brooks'), get_comment_date(),  get_comment_time()) ?></span></p>
            </div>
            <?php comment_reply_link(array_merge( $args, array('reply_text' => esc_html__('Reply', 'brooks'), 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </div>
        <div class="comment__text"><?php comment_text() ?></div>
    </div>
<?php
}


/**
 * Display post pagination block
 *
 * @param string $pages
 * @param int $range
 */
function brooks_post_navigation($pages = '', $range = 2)
{
    $showitems = ($range * 2)+1;

    global $paged;
    if(empty($paged)) $paged = 1;

    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }

    if(1 != $pages)
    {
        echo '<div class="pagination">';
        if($paged > 2 && $paged > $range+1 && $showitems < $pages)
            echo '<a href="'.get_pagenum_link(1).'"><span class="bicon bi-double-carret-left" aria-hidden="true"></span></a>';

        if($paged > 1)
            echo '<a href="'.get_pagenum_link($paged - 1).'"><span class="bicon bi-carret-left" aria-hidden="true"></span></a>';

        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo '';
                echo    ($paged == $i)? "<span class=\"active\">".$i."</span>":"<a href='".get_pagenum_link($i)."'>".$i."</a>";
                echo '';
            }
        }

        if ($paged < $pages)
            echo '<a href="'.get_pagenum_link($paged + 1).'"><span class="bicon bi-carret-right" aria-hidden="true"></span></a>';
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages)
            echo '<a href="'.get_pagenum_link($pages).'"><span class="bicon bi-double-carret-right" aria-hidden="true"></span></a>';

        echo '</div>';

        echo '<div class="space__offset__sm__50"></div>';
    }
}

/**
 * Enqueue custom styles and scripts by slug name
 *
 * @param $slug
 * @return string
 */
function brooks_enqueue_custom($slug) {
    $slug = 'brooks-theme-custom-' . $slug;

    if(wp_script_is( $slug, 'registered' ))
        wp_enqueue_script( $slug );

    if(wp_style_is( $slug, 'registered' ))
        wp_enqueue_style( $slug );

    return $slug;
}


function brooks_include_template( $template, $variables = array() ) {
    is_array( $variables ) && extract( $variables );

    return include $template;
}

function brooks_dropdown_posts_list( $result, $item ){
    $result[$item->post_title] = $item->ID;
    return $result;
}
function brooks_autocomplete_posts_list( $item ){
    return array(
        'label' => $item->post_title,
        'value' => $item->ID,
    );
}

function brooks_get_posts_list($options, $type = 'select') {
    if(!isset($options) || !is_array($options))
        $options = array();

    if( isset($options['post_type']) && !post_type_exists( $options['post_type'] ))
        return array();

    $posts_list = get_posts( $options );

    if ( !empty($posts_list) ){
        if($type == 'select')
            $posts_list = array_reduce($posts_list, "brooks_dropdown_posts_list");
        else
            $posts_list = array_map('brooks_autocomplete_posts_list', $posts_list);
    } else {
        $post_type = get_post_type_object($options['post_type']);
        $posts_list = array(sprintf( esc_html__("No %s found", 'brooks'), $post_type->labels->name) => 0);
    }

    return $posts_list;
}

function brooks_allowed_html(){
    static $brooks_allowed_tags;

    if(!isset($brooks_allowed_tags))
        $brooks_allowed_tags = array(
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'sup' => array(),
            'sub' => array(),
            'b' => array(),
        );

    return $brooks_allowed_tags;
}

function brooks_get_section_background( $image = '', $style = '', $overlay = '', $gradient = '', $src = null ) {
    $output = '';

    if(!empty($image) || !empty($src)):
        $output .= '<div class="theme__section__overlay -' . ($style?$style:'image') . '">';
        if($style == 'parallax'):
            brooks_enqueue_custom('parallax');

            $output .= '<div class="parallax__wrap parallax">';
            if(!Brooks_Theme_Options::getData('enable_preloader'))
                $output .= '    <div class="parallax__image" style="background-image: url('.(($url = wp_get_attachment_image_url($image, 'large'))?$url:$src).')"></div>';
            else
                $output .= '    <div class="parallax__image" data-bg-src="'.(($url = wp_get_attachment_image_url($image, 'large'))?$url:$src).'"></div>';
            $output .= '</div>';
        else:
            if(!Brooks_Theme_Options::getData('enable_preloader'))
                $output .= '<div class="-image" style="background-image:url('.(($url = wp_get_attachment_image_url($image, 'large'))?$url:$src).')"></div>';
            else
                $output .= '    <div class="-image" data-bg-src="'.(($url = wp_get_attachment_image_url($image, 'large'))?$url:$src).'"></div>';
        endif;
        $output .= '</div>';
    endif;

    if(!empty($overlay)):
        $output .= '<div class="theme__section__overlay -overlay_'.$overlay.' -'.($gradient?'gradient':'').' -opacity"></div>';
    endif;

    return $output;
}

function brooks_section_background( $image = '', $style = '', $overlay = '', $gradient = '', $src = null ) {
    echo brooks_get_section_background( $image, $style, $overlay, $gradient, $src);
}

/**
 * Function that carries out about modal window. It has added button in place where function was called add add body of
 * modal in footer.
 * @param $content
 * @param $uid
 * @return bool
 */
function brooks_get_modal_form($content, $uid, $extraclasses = "") {
    brooks_enqueue_custom('modal');

    $modal =   '<!-- Modal  -->' .
        '<div id="' . $uid . '" class="wrapper__modal ' . $extraclasses . '">' .
        '   <div class="wrapper__modal-in">' .
        '       <div class="wrapper__modal-center">' .
        '           <span class="modal__close" ></span>' .
        $content .
        '       </div> ' .
        '   </div> ' .
        '</div>'.
        '<!-- Modal END -->' ;

    new Brooks_Footer_Action_Content($modal);
}

add_filter('wp_tag_cloud', 'brooks_clear_tag_cloud');
function brooks_clear_tag_cloud($out){
    return preg_replace("#style='[^']+'#", '', $out);
}

add_filter('previous_comments_link_attributes', 'brooks_prev_comments_link_attributes');
function brooks_prev_comments_link_attributes($attr) {
    $attr = 'class="btn btn-color waves-effect waves-light _animation_left"';
    return $attr;
}
    
add_filter('next_comments_link_attributes', 'brooks_next_comments_link_attributes');
function brooks_next_comments_link_attributes($attr) {
    $attr = 'class="btn btn-color waves-effect waves-light _animation_right"';
    return $attr;
}

function brooks_clear_contact_form($id) {
    $output = do_shortcode('[contact-form-7 id="'.$id.'"]');
    $output = preg_replace('#<br />#', '', $output);
    $output = preg_replace('#</p>#', '', $output);
    $output = preg_replace('#<p>#', '', $output);

    echo $output;
}

function brooks_get_post_types(){
    $postTypes = get_post_types( array() );
    $postTypesList = array();
    $excludedPostTypes = array(
        'revision',
        'nav_menu_item',
        'vc_grid_item',
    );
    if ( is_array( $postTypes ) && ! empty( $postTypes ) ) {
        foreach ( $postTypes as $postType ) {
            if ( ! in_array( $postType, $excludedPostTypes ) ) {
                $label = ucfirst( $postType );
                $postTypesList[] = array(
                    $postType,
                    $label,
                );
            }
        }
    }

    return $postTypesList;
}

function brooks_get_responsive_class( $items){
    $classes = array(
        '1' => 'col-xs-12 col-sm-12 col-md-12',
        '2' => 'col-xs-12 col-sm-6 col-md-6',
        '3' => 'col-xs-12 col-sm-6 col-md-4',
        '4' => 'col-xs-12 col-sm-6 col-md-3 col-lg-3',
        '6' => 'col-xs-12 col-sm-6 col-md-3 col-lg-2'
    );

    if(!$items)
        return $classes['3'];

    return $classes[$items];
}

function brooks_add_frontend_data($array_path, $data){
    if(empty($array_path) || !is_array($array_path) || empty($data) || !is_array($data))
        return;

    global $brooks_frontend_data;

    $path_from_root = &$brooks_frontend_data;

    foreach($array_path as $path) {
        if(!isset($path_from_root[$path]))
            $path_from_root[$path] = array();

        $path_from_root = &$path_from_root[$path];
    }

    foreach($data as $key => $value) {
        $path_from_root[$key] = $value;
    }

}

function brooks_register_ajax($data, $classObject = null) {
    static $ajaxActions;

    if(!is_null($classObject) && (!class_exists($classObject) && !is_object($classObject)))
        return;

    foreach($data as $methodName => $actionName) {
        if(isset($ajaxActions[$actionName]))
            continue;

        if(!$classObject) {

            if(!function_exists($methodName))
                continue;

            add_action('wp_ajax_'.$actionName, $methodName );
            add_action('wp_ajax_nopriv_'.$actionName, $methodName );
        } else {
            if(!method_exists($classObject, $methodName))
                continue;

            add_action('wp_ajax_'.$actionName, array( $classObject, $methodName ));
            add_action('wp_ajax_nopriv_'.$actionName, array( $classObject, $methodName ));
        }

        $ajaxActions[$actionName] = $methodName;

        brooks_add_frontend_data( array('Ajax', 'actions'), array($methodName => $actionName) );

    }
}

function brooks_fill_template($template = '', $vars = array()) {
    foreach ($vars as $name => $value) {
        $template = str_replace('{{'.$name.'}}', $value, $template);
    }
    return $template;
}

function brooks_data_attrs($data_params) {
    if(empty($data_params) || !is_array($data_params))
        return;

    $output = "";

    foreach($data_params as $key => $value) {
        if(is_object($value) || is_array($value))
            continue;
        $output .= ' data-'.$key.'="'.$value.'" ';
    }

    return $output;
}

function brooks_rgba($hex, $opacity) {
    if(!preg_match('/^#(([a-f0-9]{6})|([a-f0-9]{3}))$/i', $hex))
        return $hex;


    $color = new BrooksColor($hex);

    return 'rgba('.implode(',',$color->getRgb()).','.$opacity.')';
}

function brooks_color_lighten( $hex, $percent ) {
    if(!preg_match('/^#(([a-f0-9]{6})|([a-f0-9]{3}))$/i', $hex))
        return $hex;

    $color = new BrooksColor($hex);

    return '#'.$color->lighten($percent);
}

function brooks_color_darken( $hex, $percent ) {
    if(!preg_match('/^#(([a-f0-9]{6})|([a-f0-9]{3}))$/i', $hex))
        return $hex;

    $color = new BrooksColor($hex);

    return '#'.$color->darken($percent);
}

function brooks_print_custom_styles(){
    extract( Brooks_Theme_Options::getData() );
    extract( brooks_get_option_fonts() );

    include_once( BROOKS_TEMPLATES . '/template-part-style.php');
}


function brooks_clear_title_parts($parts){
    return array($parts['title']);
}


function brooks_get_blog_settings(){
    static $settings;

    if($settings)
        return $settings;

    add_filter( 'document_title_parts' , 'brooks_clear_title_parts' );

    $settings = array(
        'type'      => brooks_get_page_type(),
        'title'     => wp_get_document_title(),
        'header_bg' => null,
        'id'        => null,
        'animation' => true
    );

    if($settings['type'] == 'home' || $settings['type'] == 'page_blog') {
        $settings['id'] = $settings['type'] == 'home'?get_option('page_for_posts'):get_the_ID();
        $settings['header_bg'] = brooks_get_section_background(get_post_thumbnail_id($settings['id']), Brooks_Theme_Options::getData('blog_other_bg_style'), Brooks_Theme_Options::getData('blog_other_bg_overlay'), Brooks_Theme_Options::getData('blog_other_bg_color_grad'));

        $settings['page_width'] = Brooks_Meta_Options::getData( 'page_width', $settings['id'] );
        $settings['sidebar'] = Brooks_Meta_Options::getData( 'sidebar', $settings['id'] );
        $settings['blog_grid'] = Brooks_Meta_Options::getData( 'blog_grid', $settings['id'] );
        $settings['blog_columns'] = Brooks_Meta_Options::getData( 'blog_columns', $settings['id'] );
        $settings['blog_gap'] = Brooks_Meta_Options::getData( 'blog_gap', $settings['id'] );
    } else {
        $type = $settings['type'];

        if($type == 'front' || substr_count($type, 'archive') > 0)
            $type = 'archive_post';

        $settings['header_bg'] = brooks_get_section_background(Brooks_Theme_Options::getData('blog_other_header_image', true), Brooks_Theme_Options::getData('blog_other_bg_style'), Brooks_Theme_Options::getData('blog_other_bg_overlay'), Brooks_Theme_Options::getData('blog_other_bg_color_grad'));

        $settings['page_width'] = Brooks_Theme_Options::getData( $type . '_page_width' );
        $settings['sidebar'] = Brooks_Theme_Options::getData( $type . '_sidebar' );
        $settings['blog_grid'] = Brooks_Theme_Options::getData( $type . '_blog_grid' );
        $settings['blog_columns'] = Brooks_Theme_Options::getData( $type . '_blog_columns' );
        $settings['blog_gap'] = Brooks_Theme_Options::getData( $type . '_blog_gap' );
    }
    return $settings;
}


function brooks_get_page_type() {
    static $type;

    if($type)
        return $type;

    switch(true) {
        case is_front_page():
            $type = 'front';
            break;
        case is_home():
            $type = 'home';
            break;
        case is_search():
            $type = 'search';
            break;
        case class_exists( 'WooCommerce' ) && is_shop():
            $type = 'shop';
            break;
        case is_archive():
            $type = 'archive_' . get_post_type();
            break;
        case is_single():
            $type = 'single_' . get_post_type();
            break;

        default:
            $slug = str_replace('.php', '', get_page_template_slug());
            $type = 'page_' . ($slug?($slug):'default');
    }

    return $type;
}


function brooks_get_post_format($post = null){
    static $theme_formats;

    if(!$theme_formats) {
        $theme_formats = get_theme_support('post-formats');
        $theme_formats = reset($theme_formats);
    }

    $format = get_post_format($post);

    if(!$format || !in_array($format, $theme_formats))
        return 'standart';

    return $format;
}

function brooks_get_related_posts() {
    $tags = get_the_tags();
    $cats = get_the_category();

    $tags = !empty($tags)?array_map( function($tag){return $tag->term_id;}, $tags):array();
    $cats = !empty($cats)?array_map( function($cat){return $cat->term_id;}, $cats):array();

    $posts = new WP_Query(
        array(
            'post_type'     => 'post',
            'posts_per_page'   => 4,  /** TODO: Theme option**/
            'post__not_in'     => array( get_the_ID() ),
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'id',
                    'terms'    => $tags
                ),
                array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $cats
                )
            )
        )
    );

    return $posts;
}

/**
 * Function which create query for blog lists
 *
 * @return wp query object
 */
function brooks_get_blog_query(){
    $post_number = Brooks_Meta_Options::getData('blog_post_per_page', get_the_ID());

    if(get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif(get_query_var('page')) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }

    $query_array = array(
        'post_type' => 'post',
        'paged' => $paged,
        'posts_per_page' => $post_number
    );

    if($individual = Brooks_Meta_Options::getData('blog_individual', get_the_ID())) {
        $query_array['post__in'] = explode(',', $individual);
        $query_array['post__not_in'] = get_option('sticky_posts');
    } else {
        if(!Brooks_Meta_Options::getData('blog_include_sticky', get_the_ID()))
            $query_array['post__not_in'] = get_option('sticky_posts');

        $tax_query = array(
            'relation'  => Brooks_Meta_Options::getData('blog_tax_relation', get_the_ID())
        );

        if($cats = Brooks_Meta_Options::getData('blog_categories', get_the_ID()))
            $tax_query[] = array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => explode(',', $cats),
                'operator' => Brooks_Meta_Options::getData('blog_categories_relation', get_the_ID()),
            );

        if($tags = Brooks_Meta_Options::getData('blog_categories', get_the_ID()))
            $tax_query[] = array(
                'taxonomy' => 'post_tag',
                'field'    => 'id',
                'terms'    => explode(',', $tags),
                'operator' => Brooks_Meta_Options::getData('blog_tags_relation', get_the_ID())
            );

        $query_array['tax_query'] = $tax_query;
    }

    query_posts($query_array);
}

function brooks_get_image_ratio($ratio = 1){
    static $sizes;

    if(!$sizes)
        $sizes = array(
            '3__1'  => '2.5',
            '2__1'  => '1.7',
            '3__2'  => '1.3',
            '1__1'  => '0.7',
            '2__3'  => '0.5',
            '1__2'  => '0',
        );

    $ratio = abs( floatval( $ratio ) );

    foreach($sizes as $out => $num) {
        if( floatval($num) <= $ratio)
            return $out;
    }
}


function brooks_like_post() {
    $post_id = isset($_POST['ID'])?$_POST['ID']:null;

    if(!$post_id)
        wp_send_json_error();

    $data = array('cookie' => $_COOKIE['brooks_post_' . $post_id . '_liked']);

    if(empty($_COOKIE['brooks_post_' . $post_id . '_liked'])) {
        $liked = Brooks_Meta_Options::getData('post_liked', $post_id);
        $liked = intval($liked) + 1;

        Brooks_Meta_Options::setData('post_liked', $liked, $post_id);

        setcookie('brooks_post_' . $post_id . '_liked', true, (time() + 24 * 3600 * 1000), SITECOOKIEPATH );
        $data['liked'] = true;
    } else {
        $liked = Brooks_Meta_Options::getData('post_liked', $post_id);
        $liked = intval($liked) - 1;
        $liked = $liked < 0?0:$liked;

        Brooks_Meta_Options::setData('post_liked', $liked, $post_id);

        setcookie('brooks_post_' . $post_id . '_liked', false, (time() + 24 * 3600 * 1000), SITECOOKIEPATH );
        $data['liked'] = false;
    }

    wp_send_json_success($data);
}


function brooks_get_option_fonts() {
    $fonts = array();
    $option_font_keys = array('general_font', 'menu_font', 'h1_font', 'h2_font', 'h3_font', 'h4_font', 'h5_font', 'h6_font');

    foreach($option_font_keys as $key) {
        $data = Brooks_Theme_Options::getData($key);
        if($data)
            $fonts[$key] = json_decode( $data, true );
    }

    return $fonts;
}


function brooks_get_font_url(){
    $default_font = array(
        array(
            'family' => 'Open Sans',
            'variants' => array('300', '400', '700')
        )
    );

    $option_fonts = brooks_get_option_fonts();

    if(empty($option_fonts))
        $option_fonts = $default_font;

    $option_fonts = array_reduce($option_fonts, function($result, $item){
        if(!empty($item))
            $result[] = $item['family'] . ':' . implode(',', $item['variants']);

        return $result;
    });

    if(empty($option_fonts))
        return false;
    
    $option_fonts = implode('|', $option_fonts);

    $font_url = '';

    if ( 'off' !== _x( 'on', 'Google font: on or off', 'brooks' ) ) {
        $font_url = add_query_arg( 'family', urlencode( $option_fonts ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}


function brooks_add_editor_styles() {
    add_editor_style();
}
add_action( 'current_screen', 'brooks_add_editor_styles' );


function brooks_post_counter() {
    if(!isset($_COOKIE['brooks_post_viewed'])) {
        $viewed = Brooks_Meta_Options::getData('post_viewed', get_the_ID());
        $viewed = intval($viewed) + 1;

        Brooks_Meta_Options::setData('post_viewed', $viewed, get_the_ID());

        setcookie('brooks_post_viewed', true, (time() + 24 * 3600 * 1000), SITECOOKIEPATH . get_page_uri(get_the_ID()) );
    }
}

add_action('init', 'brooks_post_counter');


function brooks_generate_icon_pack_options() {
    global $brooks_IconCollections;

    $html = '';
    $icon_pack = isset($_POST['icon_pack']) ? $_POST['icon_pack'] : '';
    $collections_object = $brooks_IconCollections->getIconCollection($icon_pack);

    if($collections_object) {
        $icons = $collections_object->getIconsArray();
        if(is_array($icons) && count($icons)) {
            foreach ($icons as $key => $icon) {
                $html .= '<option value="'.esc_attr($key).'">'.esc_html($key).'</option>';
            }
        }
    }

    print $html;
}

add_action('wp_ajax_update_admin_nav_icon_options', 'brooks_generate_icon_pack_options');

function brooks_icon_collections() {
    return BrooksClassIconCollections::get_instance();
}


function brooks_build_media_css($data, $class_name) {
    $css = '';
    static $media;

    if(!$media)
        $media = array(
            'xs'    => '@media (min-width: 0px)',
            'sm'    => '@media (min-width: 768px)',
            'md'    => '@media (min-width: 992px)',
            'lg'    => '@media (min-width: 1200px)'
        );

    $media_params = array();

    foreach ($data as $param_name => $param) {
        if(empty($param))
            continue;


        foreach ($param as $media_key => $value) {
            if(empty($media_params[$media_key]))
                $media_params[$media_key] = array();

            $media_params[$media_key][] = $param_name .':'. $value;
        }
    }

    krsort($media_params);

    foreach($media_params as $media_key => $style) {
        $css .= $media[$media_key] . '{.' . $class_name . '{' . implode(' !important; ' ,$style) . ' !important;} }';
    }

    $css = '<style type="text/css">' . $css . '</style>';

    return $css;
}


// add custom menu fields to menu
add_filter( 'wp_setup_nav_menu_item', 'brooks_add_custom_nav_fields');

// save menu custom fields
add_action( 'wp_update_nav_menu_item', 'brooks_update_custom_nav_fields', 10, 3 );

// edit menu walker
add_filter( 'wp_edit_nav_menu_walker', 'brooks_edit_walker', 10, 2 );


function brooks_add_custom_nav_fields( $menu_item ) {

    $menu_item->anchor = get_post_meta( $menu_item->ID, '_menu_item_anchor', true );
    $menu_item->nolink = get_post_meta( $menu_item->ID, '_menu_item_nolink', true );
    $menu_item->hide = get_post_meta( $menu_item->ID, '_menu_item_hide', true );
    $menu_item->type_menu = get_post_meta( $menu_item->ID, '_menu_item_type_menu', true );
    $menu_item->icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
    $menu_item->icon_pack = get_post_meta( $menu_item->ID, '_menu_item_icon_pack', true );
    $menu_item->sidebar = get_post_meta( $menu_item->ID, '_menu_item_sidebar', true );
    $menu_item->featured_badge = get_post_meta( $menu_item->ID, '_menu_item_featured_badge', true );
    return $menu_item;
}

/**
 * Save menu custom fields
 *
 * @access      public
 * @since       1.0
 * @return      void
 */
function brooks_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

    $check = array('anchor', 'nolink', 'hide', 'type_menu', 'icon', 'icon_pack', 'sidebar', 'featured_badge');

    if(isset($_POST['brooks_menu_options'])) {
        parse_str(urldecode($_POST['brooks_menu_options']), $parse_array);

        foreach ( $check as $key ){
            if(!isset($parse_array['menu_item_'.$key.'_'.$menu_item_db_id])) {
                $parse_array['menu_item_'.$key.'_'.$menu_item_db_id] = "";
            }

            $value = $parse_array['menu_item_'.$key.'_'.$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_'.$key, $value );
        }
    }
}


function brooks_edit_walker($walker,$menu_id) {

    return 'Brooks_Admin_Walker_Nav_Menu_Custom';
}

add_action('init', 'brooks_register_import');

function brooks_register_import() {
    if(is_admin() && class_exists('ION_Progress_Importer')) {
        ION_Progress_Importer::getInstance('main-content', array('heading' => esc_html__('Main Demo' ,'brooks'), 'content_file' => BROOKS_INCLUDES . '/demo/brooks-all.xml'));
        ION_Progress_Importer::getInstance('creative-agency', array('heading' => esc_html__('Agency Creative Demo' ,'brooks'), 'content_file' => BROOKS_INCLUDES . '/demo/brooks-agency.xml'));
        ION_Progress_Importer::getInstance('app-showcase', array('heading' => esc_html__('App Showcase Demo' ,'brooks'), 'content_file' => BROOKS_INCLUDES . '/demo/brooks-app-showcase.xml'));
        ION_Progress_Importer::getInstance('digital-agency', array('heading' => esc_html__('Digital Agency Demo' ,'brooks'), 'content_file' => BROOKS_INCLUDES . '/demo/brooks-digital-agency.xml'));
        ION_Progress_Importer::getInstance('studio', array('heading' => esc_html__('Studio Demo' ,'brooks'), 'content_file' => BROOKS_INCLUDES . '/demo/brooks-studio.xml'));
        ION_Progress_Importer::getInstance('mobile-app', array('heading' => esc_html__('Mobile App' ,'brooks'), 'content_file' => BROOKS_INCLUDES . '/demo/brooks-mobile-app.xml'));

    }
}

function brooks_render_import() {
    $output = '';

    if(!class_exists('ION_Progress_Importer'))
        return $output;

    $output .= '<div class="brooks-rwmb-demo-import rwmb-row">';
    $output .= '    <div class="rwmb-column rwmb-column-4">';
    $output .= '        <div class="demo-import-item">';
    $output .= '            <div class="demo-import-image" style="background-image: url('.BROOKS_IMAGES . '/demo-import/main-demo.png'.')"></div>';
    $output .=              ION_Progress_Importer::getInstance('main-content')->render();
    $output .= '        </div>';
    $output .= '    </div>';
    $output .= '    <div class="rwmb-column rwmb-column-4">';
    $output .= '        <div class="demo-import-item">';
    $output .= '            <div class="demo-import-image" style="background-image: url('.BROOKS_IMAGES . '/demo-import/app-showcase.png'.')"></div>';
    $output .=              ION_Progress_Importer::getInstance('app-showcase')->render();
    $output .= '        </div>';
    $output .= '    </div>';
    $output .= '    <div class="rwmb-column rwmb-column-4">';
    $output .= '        <div class="demo-import-item">';
    $output .= '            <div class="demo-import-image" style="background-image: url('.BROOKS_IMAGES . '/demo-import/creative-agency.png'.')"></div>';
    $output .=              ION_Progress_Importer::getInstance('creative-agency')->render();
    $output .= '        </div>';
    $output .= '    </div>';
    $output .= '    <div class="rwmb-column rwmb-column-4">';
    $output .= '        <div class="demo-import-item">';
    $output .= '            <div class="demo-import-image" style="background-image: url('.BROOKS_IMAGES . '/demo-import/digital-agency.png'.')"></div>';
    $output .=              ION_Progress_Importer::getInstance('digital-agency')->render();
    $output .= '        </div>';
    $output .= '    </div>';
    $output .= '    <div class="rwmb-column rwmb-column-4">';
    $output .= '        <div class="demo-import-item">';
    $output .= '            <div class="demo-import-image" style="background-image: url('.BROOKS_IMAGES . '/demo-import/studio.png'.')"></div>';
    $output .=              ION_Progress_Importer::getInstance('studio')->render();
    $output .= '        </div>';
    $output .= '    </div>';
    $output .= '    <div class="rwmb-column rwmb-column-4">';
    $output .= '        <div class="demo-import-item">';
    $output .= '            <div class="demo-import-image" style="background-image: url('.BROOKS_IMAGES . '/demo-import/mobile-app.png'.')"></div>';
    $output .=              ION_Progress_Importer::getInstance('mobile-app')->render();
    $output .= '        </div>';
    $output .= '    </div>';
    $output .= '</div>';


    return $output;
}