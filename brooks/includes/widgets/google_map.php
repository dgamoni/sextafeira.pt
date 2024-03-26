<?php
/**
 *  Display google map in footer sidebar
 */
class Brooks_Google_Map_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'description' => esc_html__('Add a Google map.', 'brooks') );
        parent::__construct( 'brooks_google_map', esc_html__('[Brooks] Google Map', 'brooks'), $widget_ops );
    }

    public function widget($args, $instance) {
        $pin_title = apply_filters( 'widget_title', $instance['title'] );
        $pin_desc = wp_kses($instance['desc'], 'default');
        $latitude = (float) $instance['latitude'];
        $longitude = (float) $instance['longitude'];

        $map_id = 'map_block_'.brooks_get_unique_id();
        $map_preloader_id = 'map_block_'.brooks_get_unique_id();

        $map_mode = '-'.'normal';
        $map_bw = false;
        $map_bw = $map_bw?'-mono':'';

        $map_settings = array(
            'center'    => array(
                'latitude'  => $latitude,
                'longitude' => $longitude
            ),
            'markerImage'       => BROOKS_IMAGES . '/40x40.png',
            'clusterImage'      => BROOKS_IMAGES . '/40x40.png',
            'preloader'            => $map_preloader_id,
            'markers' => array(
                array(
                    'latitude'  => $latitude,
                    'longitude' => $longitude,
                    'markup'    => '<div class="simple-marker"><i class="bicon bi-pin-fill"></i></div>',
                    'content'   => array(
                        'template'  => 'simple_marker_content',
                        'data'      => array(
                            'title'     => $pin_title,
                            'desc'      => $pin_desc,
                        ),
                        'size'      => array(
                            'width'     => 160,
                            'height'    => 100,
                        )
                    )
                )
            )
        );

        brooks_add_frontend_data( array('Data', 'Map', 'templates'), array( 'simple_marker_content' => include BROOKS_TEMPLATES . '/map/marker-simple-content.php') );
        brooks_add_frontend_data( array('Data', 'Map', $map_id), $map_settings );

        brooks_enqueue_custom('map');
        brooks_enqueue_custom('data-actions');

    ?>
        <div class="theme__google__map__block <?php echo $map_mode;?> <?php echo $map_bw;?>" id="<?php echo $map_id; ?>"></div>
        <div class="theme__google__map__preloader" id="<?php echo $map_preloader_id; ?>">
            <div class="preloader-wrapper active">
                <div class="spinner-layer">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $old_instance['title'] = strip_tags( $new_instance['title'] );
        $old_instance['desc'] = strip_tags( $new_instance['desc'] );
        $old_instance['latitude'] = strip_tags( $new_instance['latitude'] );
        $old_instance['longitude'] = strip_tags( $new_instance['longitude'] );

        return $old_instance;
    }

    public function form( $instance ) {
        $instance['title'] = isset($instance['title'])?$instance['title']:'';
        $instance['desc'] = isset($instance['desc'])?$instance['desc']:'';
        $instance['latitude'] = isset($instance['latitude'])?$instance['latitude']:'';
        $instance['longitude'] = isset($instance['longitude'])?$instance['longitude']:'';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Pin Title:', 'brooks') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('desc'); ?>"><?php esc_html_e('Pin Description:', 'brooks') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" value="<?php echo esc_attr( $instance['desc'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('latitude'); ?>"><?php esc_html_e('Location Latitude:', 'brooks') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('latitude'); ?>" name="<?php echo $this->get_field_name('latitude'); ?>" value="<?php echo esc_attr( $instance['latitude'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('longitude'); ?>"><?php esc_html_e('Location Longitude:', 'brooks') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('longitude'); ?>" name="<?php echo $this->get_field_name('longitude'); ?>" value="<?php echo esc_attr( $instance['longitude'] ); ?>" />
        </p>
    <?php
    }
}

// Register widget
add_action('widgets_init', 'init_brooks_google_map_widget');

function init_brooks_google_map_widget(){

    register_widget('Brooks_Google_Map_Widget');

}