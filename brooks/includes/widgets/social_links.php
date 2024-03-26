<?php
/**
 *  Display social links
 */
class Brooks_Social_Links_Widget extends WP_Widget {
    private $social_array = array();

    public function __construct() {
        $widget_ops = array( 'description' => esc_html__('Add a social links block.', 'brooks') );
        parent::__construct( 'brooks_social_links', esc_html__('[Brooks] Social Links', 'brooks'), $widget_ops );
    }

    public function widget($args, $instance) { ?>

        <?php echo $args['before_widget'];?>
        <?php
            $title = apply_filters( 'widget_title', $instance['title'] );
            $theme_socials = Brooks_Theme_Options::getData('social_networks');

            if ( !empty($title)):?>
                <?php echo $args['before_title'] . $title . $args['after_title'];?>
            <?php endif;?>

            <div class="social__widget">
            <?php if(isset($instance['socials'])):?>

                <?php foreach($instance['socials'] as $soc => $val):?>

                    <?php if(isset($theme_socials[$soc])):?>
                        <a href="<?php echo esc_url($theme_socials[$soc]);?>"><span class="fa fa-<?php echo $soc;?>"></span></a>
                    <?php endif;?>

                <?php endforeach;?>
            <?php endif;?>
            </div>

        <?php echo $args['after_widget'];?>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    public function form( $instance ) {
        $this->social_array = array_keys(Brooks_Theme_Options::getInitialData('social_networks'));

        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        wp_enqueue_style('brooks-font-awesome');?>

        <p><?php echo esc_html__('Check social networks that you want to display in widget(based on "Theme Options > Social".)', 'brooks')?></p>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'brooks') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
        <?php foreach($this->social_array as $soc):?>
            <span style="margin-right: 10px;margin-bottom: 5px;display: inline-block;border-right:1px solid #E5E5E5;">
                <i class="fa fa-<?php echo $soc;?>"></i>
                <span style="margin: 0 5px;"><?php echo $soc;?></span>
                <input type="checkbox" class="widefat" name="<?php echo $this->get_field_name("socials[$soc]"); ?>" <?php echo (isset($instance['socials'][$soc]) && !empty($instance['socials'][$soc]))?'checked="checked"':''; ?>/>
            </span>
        <?php endforeach;?>
        </p>


    <?php
    }
}

// Register widget
add_action('widgets_init', 'init_brooks_social_links_widget');

function init_brooks_social_links_widget(){

    register_widget('Brooks_Social_Links_Widget');

}