<?php
/**
 *  Display custom recent posts
 */
class Brooks_Recent_Posts_Widget extends WP_Widget_Recent_Posts {

    public function __construct() {
        $widget_ops = array( 'description' => esc_html__('Your site`s most recent Posts.', 'brooks') );
        WP_Widget::__construct( 'brooks_recent_posts_widget', esc_html__('[Brooks] Recent posts', 'brooks'), $widget_ops );
    }

    public function widget($args, $instance) {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title = apply_filters( 'widget_title', $instance['title'] );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        /**
         * Filter the arguments for the Recent Posts widget.
         *
         * @since 3.4.0
         *
         * @see WP_Query::get_posts()
         *
         * @param array $args An array of arguments used to retrieve the recent posts.
         */
        $r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ) ) );

        global $brooks_blog_settings;

        $brooks_blog_settings = array(
            'blog_grid' => 'simple',
            'grid_item_simple' => true,
        );

        if ($r->have_posts()) : ?>

            <?php brooks_enqueue_custom('grid'); ?>

            <?php echo $args['before_widget']; ?>

            <?php if ( $title ): echo $args['before_title'] . $title . $args['after_title']; endif;?>

            <div class="row -gap__30">
                <div class="theme__recent__posts theme__grid grid__columns__1 blog__list__simple">
                    <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                        <?php get_template_part( 'templates/blog/loop-grid/format', 'standart' );?>

                    <?php endwhile; ?>
                </div>
            </div>
            <?php echo $args['after_widget']; ?>
            <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;
    }
}

// Register widget
add_action('widgets_init', 'init_brooks_recent_posts_widget');

function init_brooks_recent_posts_widget(){

    register_widget('Brooks_Recent_Posts_Widget');

}