<?php

class Brooks_Search_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'description' => esc_html__('Add a search to the menu.', 'brooks') );
        parent::__construct( 'brooks_search', esc_html__('[Brooks] Full Screen Search', 'brooks'), $widget_ops );
    }

    public function widget($args, $instance) {
        $uid = 'modal-' . brooks_get_unique_id();
        $content = '<div class="widget_search">' . get_search_form( false ) . '</div>';

        brooks_get_modal_form($content, $uid, 'modal__full__screen');?>

        <?php echo $args['before_widget']; ?>

         <div class="menu__item__search">
             <a href="#<?php echo $uid ?>" class="modal-trigger" ><i class="bicon bi-search"></i></a>
         </div>

         <?php echo $args['after_widget'];
    } 


}

// Register widget
add_action('widgets_init', 'init_brooks_search_widget');

function init_brooks_search_widget(){

    register_widget('Brooks_Search_Widget');

}