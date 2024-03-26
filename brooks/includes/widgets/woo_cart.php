<?php

if( ! class_exists( 'WooCommerce' )  )
    return;

class Brooks_Woo_Cart_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'description' => esc_html__('Add a cart to the menu.', 'brooks') );
        parent::__construct( 'brooks_woo_cart', esc_html__('[Brooks] WooCommerce Cart', 'brooks'), $widget_ops );
    }

    public function widget($args, $instance) {

        echo $args['before_widget']; ?>

        <div class="menu__item__shop">
            <a href="<?php echo esc_url( wc_get_cart_url() ) ?>">
                <i class="bicon bi-cart " aria-hidden="true"></i>
                <span class="shopping-cart-items-count no-items"></span>
            </a>
            <div class="submenu">
                <div class="widget_shopping_cart_content">
                    <?php woocommerce_mini_cart() ?>
                </div>
            </div>
        </div>

        <?php echo $args['after_widget'];
    }


}

// Register widget
add_action('widgets_init', 'init_brooks_woo_cart_widget');

function init_brooks_woo_cart_widget(){

    register_widget('Brooks_Woo_Cart_Widget');

}