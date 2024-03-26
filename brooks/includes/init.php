<?php

/**
 * Register custom theme functions
 */

include_once( BROOKS_INCLUDES . '/theme_functions.php' );


/**
 * Register WooCommerce Module
 */

if ( class_exists( 'WooCommerce' ) )
    include_once( BROOKS_WOOCOMMERCE . '/init.php' );


/**
 * Register Theme Classes
 */

include_once( BROOKS_INCLUDES . '/classes/brooks_footer_action_content.php' );
include_once( BROOKS_INCLUDES . '/classes/brooks.icons/brooks.icons.php' );
include_once( BROOKS_INCLUDES . '/classes/brooks_colors.php' );
include_once( BROOKS_INCLUDES . '/classes/brooks_meta_options.php' );
include_once( BROOKS_INCLUDES . '/classes/brooks_theme_options.php' );
include_once( BROOKS_INCLUDES . '/classes/brooks_widget.php' );
include_once( BROOKS_INCLUDES . '/classes/brooks_walker_nav_menu.php' );
//include_once( BROOKS_INCLUDES . '/classes/brooks_post_listing.php' );
include_once( BROOKS_INCLUDES . '/classes/brooks_admin_walker_nav_menu_custom.php' );


/**
 * Load the theme options.
 */
add_action( 'init', 'brooks_init_theme_fields' );

function brooks_init_theme_fields() {
    include_once( BROOKS_INCLUDES . '/custom_theme_fields.php');
}


/**
 * Enqueue styles and scripts
 */
include_once( BROOKS_INCLUDES . '/register_assets.php' );


/**
 * Register Custom Fields.
 */
add_action( 'init', 'brooks_init_post_fields' );

function brooks_init_post_fields() {
    include_once( BROOKS_INCLUDES . '/custom_post_fields.php' );
}


/**
 * Register widgets
 */
include_once( BROOKS_INCLUDES . '/widgets/init.php' );



/**
 * Register Visual Composer shortcodes
 */
include_once( BROOKS_INCLUDES . '/shortcodes/init.php' );


/**
 * Require and recommend plugins
 */

include_once( BROOKS_INCLUDES . '/plugins/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'brooks_register_required_plugins' );

function brooks_register_required_plugins() {

    $plugins = array(

        array(
            'name'      => esc_html__('Brooks Core', 'brooks' ),
            'version'   => '1.1.2',
            'slug'      => 'brooks_core',
            'source'    => BROOKS_INCLUDES . '/plugins/brooks-core/brooks_core.zip',
            'required'  => true,
        ),
        array(
            'name'      => esc_html__('WPBakery Visual Composer', 'brooks' ),
            'version'   => '4.12',
            'slug'      => 'js_composer',
            'source'    => BROOKS_INCLUDES . '/plugins/visual-composer/js_composer.zip',
            'required'  => true,
        ),
        array(
            'name'      => esc_html__('Slider Revolution', 'brooks' ),
            'version'   => '5.2.6',
            'slug'      => 'revslider',
            'source'    => BROOKS_INCLUDES . '/plugins/slider-revolution/revslider.zip',
            'required'  => true,
        ),
        array(
            'name' 		=> esc_html__('Contact Form 7', 'brooks' ),
            'slug' 		=> 'contact-form-7',
            'required' 	=> false,
        )
    );

    if(class_exists('WooCommerce'))
        $plugins[] = array(
            'name'             => 'YITH WooCommerce Wishlist',
            'slug'             => 'yith-woocommerce-wishlist',
            'required'         => false,
        );

    $config = array(
        'id'           => 'brooks',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
    );

    tgmpa( $plugins, $config );

}