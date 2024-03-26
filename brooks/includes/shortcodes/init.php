<?php
if(class_exists('WPBakeryShortCode' )) {
    add_action('init', 'brooks_init_vc_params', 49);
    add_action('init', 'brooks_init_vc_shortcodes', 50);
}

function brooks_init_vc_params(){
    include_once( BROOKS_INCLUDES . '/shortcodes/params/vc_layout_select.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/params/vc_responsive_param.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/params/vc_brooks_datepicker.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/params/vc_social_share.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/params/vc_range.php' );
}

function brooks_init_vc_shortcodes()
{
    include_once( BROOKS_INCLUDES . '/shortcodes/extend_vc.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_theme_btn.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_building_search.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_building_grid.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_testimonials_block.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_grid_container.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_grid_item.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_woo_single_product.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_underconstuction.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_image_gallery.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_portfolio_grid.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_team.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_chart.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_pricing_block.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_post_grid.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_slider_container.php' );
    include_once( BROOKS_INCLUDES . '/shortcodes/vc_slider_item.php' );

}