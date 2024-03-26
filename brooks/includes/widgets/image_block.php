<?php
/**
 * Widget adds image type
 */
class Brooks_Image_Block_Widget extends Brooks_Widget {

    public function __construct() {
        parent::__construct(
            'edgtf_image_widget',
            esc_html__('[Brooks] Image Block', 'brooks')
        );

        $this->setParams();
    }

    protected function setParams() {
        $this->params = array(
            array(
                'type' => 'textfield',
                'title' => esc_html__('Widget Title', 'brooks'),
                'name' => 'title'
            ),
            array(
                'type' => 'textfield',
                'title' => esc_html__('Image Source', 'brooks'),
                'name' => 'src'
            ),
            array(
                'type' => 'textfield',
                'title' => esc_html__('Image Width', 'brooks'),
                'name' => 'width'
            ),
            array(
                'type' => 'dropdown',
                'title' => esc_html__('Image Alignment', 'brooks'),
                'name' => 'align',
                'options' => array(
                    'left'  => esc_html__('Left', 'brooks'),
                    'center' => esc_html__('Center', 'brooks'),
                    'right'  => esc_html__('Right', 'brooks'),
                    'stretch'  => esc_html__('Stretch', 'brooks'),
                )
            ),
            array(
                'type' => 'dropdown',
                'title' => esc_html__('Image Style', 'brooks'),
                'name' => 'style',
                'options' => array(
                    0  => esc_html__('Default', 'brooks'),
                    'rounded' => esc_html__('Rounded', 'brooks'),
                    'circle'  => esc_html__('Circle', 'brooks'),
                )
            ),
            array(
                'type' => 'textfield',
                'title' => esc_html__('Link', 'brooks'),
                'name' => 'link'
            )
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        $src = esc_url($instance['src']);
        $link = esc_url($instance['link']);

        $width = intval($instance['width']);
        $width = $width?($width . 'px'):'';

        if(!$src)
            return;

        $class = 'image-fill ' . 'img-' . $instance['style'] . '';
        if($instance['align'] == 'stretch') {
            $width = '';
            $class .= ' img-responsive';
        }

        $image = $instance['style'] == 'circle'?('<canvas width="1" height="1" class="' . $class . '" style="background-image:url('.$src.');width:'.$width.'">'):('<img src="'.$src.'" class="' . $class . '" style="width:'.$width.'" alt="">');

        if (!empty($link))
            $image = '<a href="' . esc_url($link) . '">' . $image . '</a>';
        ?>

        <?php echo $args['before_widget'];?>

        <?php if ( !empty($title) ):?>
            <?php echo $args['before_title'] . $title . $args['after_title'];?>
        <?php endif;?>

        <div class="text-<?php echo $instance['align'];?>">
            <?php echo $image; ?>
        </div>

        <?php echo $args['after_widget'];?>

    <?php
    }
}

// Register widget
add_action('widgets_init', 'init_brooks_image_block_widget');

function init_brooks_image_block_widget(){

    register_widget('Brooks_Image_Block_Widget');

}