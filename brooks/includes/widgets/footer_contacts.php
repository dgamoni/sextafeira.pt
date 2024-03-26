<?php
/**
 *  Display contacts block in footer sidebar
 */
class Brooks_Footer_Contacts_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'description' => esc_html__('Add a contacts info to your footer.', 'brooks') );
        parent::__construct( 'brooks_footer_contacts', esc_html__('[Brooks] Footer Contacts', 'brooks'), $widget_ops );
    }

    public function widget($args, $instance) {
        $title = apply_filters( 'widget_title', $instance['title'] ); ?>

        <?php echo $args['before_widget'];?>

        <?php if ( !empty($title) ):?>
            <?php echo $args['before_title'] . $title . $args['after_title'];?>
        <?php endif;?>

        <address>
            <div class="footer-address"><i class="bicon bi-build" aria-hidden="true"></i><?php echo wp_kses($instance['address'], brooks_allowed_html());?></div>
            <?php if(!empty($instance['address1'])):?><div class="footer-address"><?php echo wp_kses($instance['address1'], brooks_allowed_html());?></div><?php endif;?>
            <?php if(!empty($instance['address2'])):?><div class="footer-address"><?php echo wp_kses($instance['address2'], brooks_allowed_html());?></div><?php endif;?>
            <div><a class="footer-tell" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $instance['phone']));?>"><i class="bicon bi-phone" aria-hidden="true"></i><?php echo esc_html($instance['phone']);?></a></div>
            <?php if(!empty($instance['phone1'])):?>  <div><a class="footer-tell" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $instance['phone1']));?>"><?php echo esc_html($instance['phone1']);?></a></div><?php endif;?>
            <?php if(!empty($instance['phone2'])):?>  <div><a class="footer-tell" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $instance['phone2']));?>"><?php echo esc_html($instance['phone2']);?></a></div><?php endif;?>
            <div><a class="footer-mail" href="mailto:<?php echo esc_attr($instance['email']);?>"><i class="bicon bi-mail" aria-hidden="true"></i><?php echo esc_html($instance['email']);?></a></div>
        </address>

        <?php echo $args['after_widget'];?>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $old_instance['title'] = strip_tags( $new_instance['title'] );
        $old_instance['address'] = strip_tags( $new_instance['address'] );
        $old_instance['address1'] = strip_tags( $new_instance['address1'] );
        $old_instance['address2'] = strip_tags( $new_instance['address2'] );
        $old_instance['phone'] = strip_tags( $new_instance['phone'] );
        $old_instance['phone1'] = strip_tags( $new_instance['phone1'] );
        $old_instance['phone2'] = strip_tags( $new_instance['phone2'] );
        $old_instance['email'] = strip_tags( $new_instance['email'] );

        return $old_instance;
    }

    public function form( $instance ) {

        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'brooks') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( isset($instance['title'])?$instance['title']:''); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('address'); ?>"><?php esc_html_e('Address:', 'brooks') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" value="<?php echo esc_attr( isset($instance['address'])?$instance['address']:''); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('address1'); ?>"><?php esc_html_e('Address(optional):', 'brooks') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('address1'); ?>" name="<?php echo $this->get_field_name('address1'); ?>" value="<?php echo esc_attr( isset($instance['address1'])?$instance['address1']:''); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('address2'); ?>"><?php esc_html_e('Address(optional):', 'brooks') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('address2'); ?>" name="<?php echo $this->get_field_name('address2'); ?>" value="<?php echo esc_attr( isset($instance['address2'])?$instance['address2']:''); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('phone'); ?>"><?php esc_html_e('Phone number:', 'brooks') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo esc_attr( isset($instance['phone'])?$instance['phone']:''); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('phone1'); ?>"><?php esc_html_e('Phone number(optional):', 'brooks') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('phone1'); ?>" name="<?php echo $this->get_field_name('phone1'); ?>" value="<?php echo esc_attr( isset($instance['phone1'])?$instance['phone1']:''); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('phone2'); ?>"><?php esc_html_e('Phone number(optional):', 'brooks') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('phone2'); ?>" name="<?php echo $this->get_field_name('phone2'); ?>" value="<?php echo esc_attr( isset($instance['phone2'])?$instance['phone2']:''); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('email'); ?>"><?php esc_html_e('Email:', 'brooks') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo esc_attr( isset($instance['email'])?$instance['email']:''); ?>" />
            </p>
    <?php
    }
}

// Register widget
add_action('widgets_init', 'init_brooks_footer_contacts_widget');

function init_brooks_footer_contacts_widget(){

    register_widget('Brooks_Footer_Contacts_Widget');

}