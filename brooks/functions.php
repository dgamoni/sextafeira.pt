<?php

/**

 * The theme's functions and definitions.

 */



/**

 * Define constants.

 */

define( 'BROOKS_THEMENAME', 'brooks' );

define( 'BROOKS_THEMEROOT', get_template_directory_uri() );



define( 'BROOKS_IMAGES',    BROOKS_THEMEROOT . '/images' );

define( 'BROOKS_SCRIPTS',   BROOKS_THEMEROOT . '/js' );

define( 'BROOKS_STYLES',    BROOKS_THEMEROOT . '/css' );



define( 'BROOKS_TEMPLATES', get_template_directory() . '/templates' );

define( 'BROOKS_INCLUDES',  get_template_directory() . '/includes' );

define( 'BROOKS_WOOCOMMERCE',  BROOKS_INCLUDES . '/woocommerce' );





/**

 * Register Custom Navigation Walker, Widgets, Shortcodes, External classes and Plugins

 */

include_once( BROOKS_INCLUDES . '/init.php');



/**

 * Set up the content width value based on the theme's design.

 */

if ( ! isset( $content_width ) ) {

    $content_width = 1170;

}       

 



/**

 * Set up theme default and register various supported features.

 */

if ( ! function_exists( 'brooks_theme_setup' ) ) {

    function brooks_theme_setup() {

        /**

         * Make the theme available for translation.

         */

        $lang_dir = BROOKS_THEMEROOT . '/languages';

        load_theme_textdomain( 'brooks', $lang_dir );





        /**

         * Add support for automatic feed links.

         */

        add_theme_support( 'automatic-feed-links' );



        /**

         * Add support for post thumbnails.

         */

        add_theme_support( 'post-thumbnails' );



        /**

         * Add support for title tag directly in wp_head action

         */

        add_theme_support('title-tag');



        /**

         * Add support for custom-background

         */

        add_theme_support( 'custom-background', array(

            'default-color'     => '#FFF'

        ) );



        /**

         * Add support for custom-background

         */

        add_theme_support( 'custom-header' );



        /**

         * Enable support for Post Formats

         */

        add_theme_support('post-formats', array(

            'audio', 'gallery', 'link', 'quote', 'video'

        ));



    }



    add_action( 'after_setup_theme', 'brooks_theme_setup' );

}





/**

 *	Register Navigation Menus

 */

if( !function_exists('brooks_register_menu') ) {

    function brooks_register_menu() {

        register_nav_menus(

            array(

                'main_menu' => esc_html__('Main Header Menu', 'brooks'),

                'secondary_menu'    => esc_html__('Secondary Header Menu', 'brooks')

            )

        );

    }

    add_action( 'init', 'brooks_register_menu', 2 );

}





/**

 *	Register blog sidebar, footer and custom sidebar

 */



if( function_exists('register_sidebar') ) {

    register_sidebar(array(

        'name' => esc_html__('Blog Sidebar', 'brooks'),

        'id' => 'sidebar',

        'description' => esc_html__('Widgets in this area will be shown in the sidebar.', 'brooks'),

        'before_widget' => '<div class="theme__widget">',

        'after_widget' => '</div>',

        'before_title' => '<h5>',

        'after_title' => '</h5>',

    ));

    register_sidebar(array(

        'name' => esc_html__('Header Right Sidebar', 'brooks'),

        'id' => 'header-right',

        'description' => esc_html__('Widgets in this area will be shown in the header right sidebar of every page.', 'brooks'),

        'before_widget' => '<li class="menu__item">',

        'after_widget' => '</li>',

        'before_title' => '<h4>',

        'after_title' => '</h4>',

    ));

    register_sidebar(array(

        'name' => esc_html__('Footer Bottom Sidebar', 'brooks'),

        'id' => 'footer-bottom-sidebar',

        'description' => esc_html__('Widgets in this area will be shown in the footer right sidebar of every page.', 'brooks'),

        'before_widget' => '<div class="theme__widget">',

        'after_widget' => '</div>',

        'before_title' => '<h4>',

        'after_title' => '</h4>',

    ));



    register_sidebar(array(

        'name' => esc_html__('Woo', 'brooks'),

        'id' => 'woocommerce',

        'description' => esc_html__('Widgets in this area will be shown in the sidebar.', 'brooks'),

        'before_widget' => '<div class="theme__widget">',

        'after_widget' => '</div>',

        'before_title' => '<h4>',

        'after_title' => '</h4>',

    ));



    register_sidebar(array(

        'name' => esc_html__('Inner Menu Area', 'brooks'),

        'id' => 'menu-feature',

        'description' => esc_html__('Widgets in this area will be shown in the main menu.', 'brooks'),

        'before_widget' => '<div class="theme__widget">',

        'after_widget' => '</div>',

        'before_title' => '<h4>',

        'after_title' => '</h4>',

    ));



    register_sidebar(array(

        'name' => esc_html__('Header Contact Area', 'brooks'),

        'id' => 'header_contact',

        'description' => esc_html__('Put here text in header contact details.', 'brooks'),

        'before_widget' => '<div class="theme__widget">',

        'after_widget' => '</div>',

        'before_title' => '<h4>',

        'after_title' => '</h4>',

    ));



    //Register Footer Sidebars Depending on Number of Columns

    function brooks_register_footer_sidebars() {

        $nums = array(1 => esc_html__('1st - First', 'brooks'), 2 => esc_html__('2nd - Second', 'brooks'), 3 => esc_html__('3rd - Third', 'brooks'), 4 => esc_html__('4th - Fourth', 'brooks'));

        $rows = Brooks_Theme_Options::getData('footer_cols');



        for ($i = 1; $i <= $rows; $i++) {

            register_sidebar(array(

                'name' => $nums[$i] . esc_html__(' Footer Column', 'brooks'),

                'id' => 'footer-sidebar-' . $i,

                'description' => esc_html__('Widgets in this area will be shown in the footer appropriate column.','brooks'),

                'before_widget' => '<div class="theme__widget">',

                'after_widget' => '</div>',

                'before_title' => '<h4>',

                'after_title' => '</h4>',

            ));

        }

    }



    add_action('init', 'brooks_register_footer_sidebars');
	
	

}





/**

 * Update image size setting

 */

update_option('large_size_w', 1920);

update_option('large_size_h', 1080);



add_filter('show_admin_bar', '__return_false');



add_action('init', 'wpse_74054_add_author_woocommerce', 999 );



function wpse_74054_add_author_woocommerce() {

    add_post_type_support( 'product', 'author' );

}



// originally by Camden Ross. Thanks



/* bypass wordpress are you sure you want to logout screen when logging out of an already logged out account. */

function smart_logout() {

	if (!is_user_logged_in()) {

		$smart_redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '/';

		wp_safe_redirect( $smart_redirect_to );

		exit();

	} else {

		check_admin_referer('log-out');

		wp_logout();

		$smart_redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '/';

		wp_safe_redirect( $smart_redirect_to );

		exit();

	}

}

add_action ( 'login_form_logout' , 'smart_logout' );





function wppbc_confirm_logout() {

	wp_enqueue_script( 'wppbc_confirm_logout', get_template_directory_uri() . '/js/wppbc_confirm_logout.js', array ( 'jquery' ), 1.1, true);

}

add_action( 'wp_enqueue_scripts', 'wppbc_confirm_logout' );

add_action( 'init', 'yourtheme_woocommerce_image_dimensions', 1 );
function yourtheme_woocommerce_image_dimensions() {
  	$catalog = array(
		'width' 	=> '400',	// px
		'height'	=> '',	// px
		'crop'		=> 0 		// true
	);

	$single = array(
		'width' 	=> '600',	// px
		'height'	=> '',	// px
		'crop'		=> 0 		// true
	);

	$thumbnail = array(
		'width' 	=> '120',	// px
		'height'	=> '120',	// px
		'crop'		=> 0 		// false
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}