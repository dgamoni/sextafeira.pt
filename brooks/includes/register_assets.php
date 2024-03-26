<?php

/**
 * Register main JS Theme object.
 */

add_action('init', 'brooks_init_frontend_data');

function brooks_init_frontend_data(){
    global $brooks_frontend_data;

    $brooks_frontend_data = array(
        'ThemeOptions' => Brooks_Theme_Options::getData(),
        'Ajax' => array(
            'url' => admin_url('admin-ajax.php')
        ),
        'Web' => array(
            'root'      => BROOKS_THEMEROOT,
            'images'    => BROOKS_IMAGES,
            'js'        => BROOKS_SCRIPTS,
            'css'       => BROOKS_STYLES
        )
    );
}


add_action('wp_enqueue_scripts', 'brooks_update_frontend_data');
function brooks_update_frontend_data(){
    global $brooks_frontend_data;

    $brooks_frontend_data['ThemeOptions'] = Brooks_Theme_Options::getData();

    if(is_rtl())
        $brooks_frontend_data['ThemeOptions']['rtl'] = true;
}


/**
 *  Register scripts and styles on hook
 */
function brooks_register_assets()
{

    /**
     * Register all styles and scripts
     */

    /** Main theme CSS framework    **/
    wp_register_style('bootstrap', BROOKS_STYLES . '/bootstrap.min.css');
    wp_register_style('bootstrap-rtl', BROOKS_STYLES . '/bootstrap-rtl.min.css');

    wp_register_script('materialize', BROOKS_SCRIPTS . '/materialize.min.js', array('jquery'), '1', true);

    /** External CDN Libraries  **/
    wp_register_script('google-map', '//maps.googleapis.com/maps/api/js?key='.Brooks_Theme_Options::getData('browser_key'), false);

    /** Thirdparty Libraries    **/
    wp_register_style('font-awesome', BROOKS_STYLES . '/font-awesome.min.css');
    wp_register_style('swiper', BROOKS_STYLES . '/swiper.min.css');
    wp_register_style('slick', BROOKS_STYLES . '/slick.css');
    wp_register_style('lightgallery', BROOKS_STYLES . '/lightgallery.min.css');
    wp_register_style('slick-theme', BROOKS_STYLES . '/slick-theme.css');


    wp_register_script('waypoints', BROOKS_SCRIPTS . '/waypoints.min.js', array('jquery'), '1', true);
    wp_register_script('tweenmax', BROOKS_SCRIPTS . '/TweenMax.min.js', array(), '1', true);
    wp_register_script('scrollto', BROOKS_SCRIPTS . '/ScrollToPlugin.min.js', array('tweenmax'), '1', true);
    wp_register_script('drawsvg', BROOKS_SCRIPTS . '/DrawSVGPlugin.min.js', array('tweenmax'), '1', true);
    wp_register_script('lightgallery', BROOKS_SCRIPTS . '/lightgallery.min.js', array('jquery'), '1', true);

    wp_register_script('swiper', BROOKS_SCRIPTS . '/swiper.min.js', array(), '1', true);
    wp_register_script('infobox', BROOKS_SCRIPTS . '/infobox.js', array('google-map'), '1', true);
    wp_register_script('markerclusterer', BROOKS_SCRIPTS . '/markerclusterer.js', array('google-map'), '1', true);
    wp_register_script('jquery-google-map', BROOKS_SCRIPTS . '/jquery-google-map.js', array('jquery', 'infobox', 'markerclusterer'), '1', true);
    wp_register_script('packery', BROOKS_SCRIPTS . '/packery.pkgd.min.js', array('jquery'), '1', true);
    wp_register_script('imagesloaded', BROOKS_SCRIPTS . '/imagesloaded.pkgd.min.js', array('jquery'), '1', true);
    wp_register_script('slick', BROOKS_SCRIPTS . '/slick.min.js', array('jquery'), '1', true);

    wp_register_script('moment', BROOKS_SCRIPTS . '/moment-with-locales.min.js', array(), '1', true);
    wp_register_script('counterdown', BROOKS_SCRIPTS . '/countdown.js', array(), '1', true);
    wp_register_script('moment-counterdown', BROOKS_SCRIPTS . '/moment-countdown.js', array(), '1', true);
    wp_register_script('scrollmagic', BROOKS_SCRIPTS . '/scrollmagic.min.js', array(), '1', true);

    /** Custom Styles and Scripts   **/
    wp_register_style('brooks-theme-custom-google-font', brooks_get_font_url());

    wp_register_script('brooks-theme-custom-global', BROOKS_SCRIPTS . '/custom/global.js', array('jquery'), '1', true);

    wp_register_script('brooks-theme-custom-parallax', BROOKS_SCRIPTS . '/custom/parallax.js', array('jquery', 'brooks-theme-custom-global', 'brooks-theme-custom-grid', 'tweenmax'), '1', true);
    wp_register_script('brooks-theme-custom-menu', BROOKS_SCRIPTS . '/custom/menu.js', array('jquery', 'brooks-theme-custom-global'), '1', true);
    wp_register_script('brooks-theme-custom-map', BROOKS_SCRIPTS . '/custom/map.js', array('jquery', 'brooks-theme-custom-global', 'jquery-google-map'), '1', true);
    wp_register_script('brooks-theme-custom-data-actions', BROOKS_SCRIPTS . '/custom/data_actions.js', array('jquery', 'brooks-theme-custom-global', 'scrollto'), '1', true);
    wp_register_script('brooks-theme-custom-loader', BROOKS_SCRIPTS . '/custom/loader.js', array('jquery', 'brooks-theme-custom-global', 'imagesloaded'), '1', true);
    wp_register_script('brooks-theme-custom-css-animation', BROOKS_SCRIPTS . '/custom/css_animation.js', array('jquery', 'brooks-theme-custom-global', 'waypoints', 'tweenmax'), '1', true);
    wp_register_script('brooks-theme-custom-counter', BROOKS_SCRIPTS . '/custom/counter.js', array('jquery', 'brooks-theme-counterup'), '1', true);
    wp_register_script('brooks-theme-custom-form', BROOKS_SCRIPTS . '/custom/form.js', array('materialize'), '1', true);
    wp_register_script('brooks-theme-custom-modal', BROOKS_SCRIPTS . '/custom/modal.js', array('materialize'), '1', true);
    wp_register_script('brooks-theme-custom-grid', BROOKS_SCRIPTS . '/custom/grid.js', array('jquery', 'brooks-theme-custom-global', 'packery'), '1', true);
    wp_register_script('brooks-theme-custom-chart', BROOKS_SCRIPTS . '/custom/chart.js', array('jquery', 'brooks-theme-custom-global', 'waypoints', 'drawsvg'), '1', true);
    wp_register_script('brooks-theme-custom-post-counter', BROOKS_SCRIPTS . '/custom/post-counter.js', array('jquery', 'brooks-theme-custom-global', 'brooks-theme-custom-ajax'), '1', true);

    wp_register_script('brooks-theme-custom-form', BROOKS_SCRIPTS . '/custom/form.js', array('materialize'), '1', true);

    wp_register_script('brooks-theme-custom-ajax', BROOKS_SCRIPTS . '/custom/ajax.js', array('jquery'), '1', true);
    wp_register_script('brooks-theme-custom-audio', BROOKS_SCRIPTS . '/custom/audio.js', array('jquery'), '1', true);
    wp_register_script('brooks-theme-custom-post-grid', BROOKS_SCRIPTS . '/custom/post-grid.js', array('jquery', 'brooks-theme-custom-ajax'), '1', true);
    wp_register_script('brooks-theme-custom-building-search', BROOKS_SCRIPTS . '/custom/building-search.js', array('jquery', 'brooks-theme-custom-ajax'), '1', true);

    wp_register_style('brooks-theme-custom-slider', '', array('swiper'));
    wp_register_script('brooks-theme-custom-slider', BROOKS_SCRIPTS . '/custom/slider.js', array('brooks-theme-custom-global', 'swiper'), '1', true);

    wp_register_style('brooks-theme-custom-gallery', '', array('lightgallery'));
    wp_register_script('brooks-theme-custom-gallery', BROOKS_SCRIPTS . '/custom/gallery.js', array('jquery', 'brooks-theme-custom-global', 'lightgallery'), '1', true);

    wp_register_script('brooks-theme-custom-product-slider', BROOKS_SCRIPTS . '/custom/product-slider.js', array('jquery', 'imagesloaded', 'slick'), '1', true);
    wp_register_script('brooks-theme-custom-testimonials-slider', BROOKS_SCRIPTS . '/custom/testimonials-slider.js', array('jquery', 'imagesloaded', 'slick'), '1', true);

    wp_register_script('brooks-theme-custom-woocommerce', BROOKS_SCRIPTS . '/custom/woocommerce.js', array('jquery'), '1', true);
    wp_register_script('brooks-theme-custom-underconstruction', BROOKS_SCRIPTS . '/custom/underconstruction.js', array('jquery', 'tweenmax', 'moment', 'counterdown', 'moment-counterdown'), '1', true);
    wp_register_script('brooks-theme-custom-parallax-item', BROOKS_SCRIPTS . '/custom/parallax-item.js', array('jquery', 'imagesloaded', 'tweenmax', 'scrollmagic'), '1', true);
    wp_register_script('brooks-theme-custom-slickslider', BROOKS_SCRIPTS . '/custom/slick-slider.js', array('jquery', 'imagesloaded', 'slick'), '1', true);
    wp_register_script('brooks-theme-custom-filter', BROOKS_SCRIPTS . '/custom/filter.js', array('jquery', 'scrollmagic'), '1', true);

    wp_register_style( 'brooks-theme-main', BROOKS_STYLES . '/main.min.css' );
    wp_register_style( 'brooks-theme-main-rtl', BROOKS_STYLES . '/main-rtl.min.css' );

    wp_register_style( 'brooks-theme-stylesheet', get_stylesheet_uri() );
}

/**
 *  Enqueue general Javascript, CSS and Custom Styles
 */
function brooks_enqueue_assets()
{

    /** Enqueue styles and scripts libraries*/
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'font-awesome' );

    wp_enqueue_script( 'materialize' );


    /** Enqueue custom styles and scripts */
    wp_enqueue_style( 'brooks-theme-main' );
    wp_enqueue_style( 'brooks-theme-stylesheet' );

    brooks_enqueue_custom('google-font');
    brooks_enqueue_custom('global');
    brooks_enqueue_custom('loader');
    brooks_enqueue_custom('menu');
    brooks_enqueue_custom('form');

    /** Add RTL Support */
    if(function_exists( 'is_rtl' ) && is_rtl()) {
        wp_enqueue_style( 'bootstrap-rtl' );
        wp_enqueue_style( 'brooks-theme-main-rtl' );
    }
}

/**
 *  Localize main theme data used from SERVER
 */
function brooks_localize_theme_data() {
    global $brooks_frontend_data;

    wp_localize_script( 'brooks-theme-custom-global', 'BrooksTheme', $brooks_frontend_data);
}

add_action('wp_footer', 'brooks_localize_theme_data', 0);


function brooks_enqueue_admin_assets() {
    /** Register Admin Styles **/
    wp_register_style( 'admin-brooks-main', BROOKS_STYLES . '/admin/main.css' );
    wp_register_script('admin-brooks-menu', BROOKS_SCRIPTS.'/admin/brooks_nav_menu.js', array(), '1', true);
    /** Enqueue Admin Styles **/
    wp_enqueue_style( 'admin-brooks-main' );
    wp_enqueue_style( 'font-awesome' );
    wp_enqueue_script( 'admin-brooks-menu' );
}


add_action('wp_enqueue_scripts', 'brooks_register_assets', 10);
add_action('admin_enqueue_scripts', 'brooks_register_assets', 10);
add_action('vc_frontend_editor_enqueue_js_css', 'brooks_register_assets', 10);

add_action('wp_enqueue_scripts', 'brooks_enqueue_assets', 11);
add_action( 'vc_frontend_editor_enqueue_js_css', 'brooks_enqueue_admin_assets', 11);
add_action( 'admin_enqueue_scripts', 'brooks_enqueue_admin_assets', 11);


add_action('wp_head', 'brooks_print_custom_styles');