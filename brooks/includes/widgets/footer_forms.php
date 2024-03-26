<?php
/**
 *  Display menu in footer sidebar
 */
class Brooks_Footer_Forms_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'description' => esc_html__('Add a contact form to your footer.', 'brooks') );
        parent::__construct( 'brooks_footer_forms', esc_html__('[Brooks] Footer Form', 'brooks'), $widget_ops );
    }

    public function widget($args, $instance) {
        $title = ! empty( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $contact_form = ! empty( $instance['contact_form'] ) ? $instance['contact_form'] : false;

        if ( !$contact_form )
            return;

        brooks_enqueue_custom('form');

        echo $args['before_widget'];

        if ( !empty($title)):
             echo $args['before_title'] . $title . $args['after_title'];
         endif;

         brooks_clear_contact_form($contact_form);

         echo $args['after_widget'];

    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        }
        if ( ! empty( $new_instance['contact_form'] ) ) {
            $instance['contact_form'] = (int) $new_instance['contact_form'];
        }
        return $instance;
    }

    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $contact_form = isset( $instance['contact_form'] ) ? $instance['contact_form'] : '';

        // Get menus
        $cf = brooks_get_posts_list( array('post_type' => 'wpcf7_contact_form', 'numberposts' => -1) );

        // If no menus exists, direct the user to go and create some.
        if ( !$cf ) {
            echo '<p>'. esc_html__('No forms have been created yet. Create some.', 'brooks') .'</p>';
            return;
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'brooks') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('contact_form'); ?>"><?php esc_html_e('Select Menu:', 'brooks'); ?></label>
            <select id="<?php echo $this->get_field_id('contact_form'); ?>" name="<?php echo $this->get_field_name('contact_form'); ?>">
                <option value="0"><?php esc_html_e( '&mdash; Select &mdash;', 'brooks' ) ?></option>
                <?php
                foreach ( $cf as $name => $id ) {
                    echo '<option value="' . $id . '"'
                        . selected( $contact_form, $id, false )
                        . '>'. esc_html( $name ). '</option>';
                }
                ?>
            </select>
        </p>
    <?php
    }
}

// Register widget
add_action('widgets_init', 'init_brooks_footer_forms_widget');

function init_brooks_footer_forms_widget(){

    register_widget('Brooks_Footer_Forms_Widget');

}