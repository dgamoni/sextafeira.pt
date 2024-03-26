<?php
abstract class Brooks_Widget extends WP_Widget {

    protected $params;

    abstract protected function setParams();


    public function form($instance) {
        if(is_array($this->params) && count($this->params)) {
            foreach($this->params as $param_array) {
                $param_name    = $param_array['name'];
                ${$param_name} = isset($instance[$param_name]) ? esc_attr($instance[$param_name]) : '';
            }

            foreach($this->params as $param) {
                switch($param['type']) {
                    case 'textfield':
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($this->get_field_id($param['name'])); ?>"><?php echo
                                esc_html($param['title']); ?>:</label>
                            <input class="widefat" id="<?php echo esc_attr($this->get_field_id($param['name'])); ?>" name="<?php echo esc_attr($this->get_field_name($param['name'])); ?>" type="text" value="<?php echo esc_attr(${$param['name']}); ?>"/>
                        </p>
                        <?php
                        break;
                    case 'dropdown':
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($this->get_field_id($param['name'])); ?>"><?php echo
                                esc_html($param['title']); ?>:</label>
                            <?php if(isset($param['options']) && is_array($param['options']) && count($param['options'])) { ?>
                                <select class="widefat" name="<?php echo esc_attr($this->get_field_name($param['name'])); ?>" id="<?php echo esc_attr($this->get_field_id($param['name'])); ?>">
                                    <?php foreach($param['options'] as $param_option_key => $param_option_val) {
                                        $option_selected = '';
                                        if(${$param['name']} == $param_option_key) {
                                            $option_selected = 'selected';
                                        }
                                        ?>
                                        <option <?php echo esc_attr($option_selected); ?> value="<?php echo esc_attr($param_option_key); ?>"><?php echo esc_attr($param_option_val); ?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        </p>

                        <?php
                        break;
                }
            }
        } else { ?>
            <p><?php esc_html_e('There are no options for this widget.', 'brooks'); ?></p>
        <?php }
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        foreach($this->params as $param) {
            $param_name = $param['name'];

            $instance[$param_name] = sanitize_text_field($new_instance[$param_name]);
        }

        return $instance;
    }
}
?>