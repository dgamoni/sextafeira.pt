<?php

if( ! class_exists( 'WooCommerce' ) || ! defined( 'YITH_WCWL'))
    return;

class Brooks_Woo_WishList_Widget extends WP_Widget {

    public function __construct() {

        $widget_ops = array( 'description' => esc_html__('Add a wishlist to the menu.', 'brooks') );
        parent::__construct( 'brooks_woo_wishlist', esc_html__('[Brooks] WooCommerce Wishlist', 'brooks'), $widget_ops );
    }

    public function widget($args, $instance) {

        if (  get_option( 'yith_wcwl_enabled' ) == 'yes' ):
            echo $args['before_widget'];
            $wishlist_url = YITH_WCWL()->get_wishlist_url();
            ?>
            <div class="menu__item__wishlist">
                <a href="<?php echo esc_url($wishlist_url); ?>">
                    <i class="bicon bi-heart"></i>
                </a>
            </div>
            <?php
            echo $args['after_widget'];
        endif;

    }


}

// Register widget
add_action('widgets_init', 'init_brooks_woo_wishlist_widget');

function init_brooks_woo_wishlist_widget(){

    register_widget('Brooks_Woo_WishList_Widget');

}