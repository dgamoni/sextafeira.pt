<?php

if ( class_exists( 'RWMB_Field' ) ) {

    /**
     * Color field class.
     */
    class RWMB_Alpha_Color_Field extends RWMB_Text_Field
    {
        /**
         * Enqueue scripts and styles
         */
        static function admin_enqueue_scripts()
        {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_style( 'cs-wp-color-picker', plugins_url( 'css/cs-wp-color-picker.min.css', __FILE__ ), array( 'wp-color-picker' ), '1.0.0', 'all' );

            // enqueue scripts
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script( 'cs-wp-color-picker', plugins_url( 'js/cs-wp-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), '1.0.0', true );
        }

        /**
         * Normalize parameters for field.
         *
         * @param array $field
         * @return array
         */
        static function normalize($field)
        {

            $field = wp_parse_args($field, array(
                'js_options' => array(),
            ));

            $field['js_options'] = wp_parse_args($field['js_options'], array(
                'defaultColor' => false,
                'hide' => true,
                'palettes' => true,
            ));

            $field = parent::normalize($field);

            return $field;
        }

        /**
         * Get the attributes for a field
         *
         * @param array $field
         * @param mixed $value
         * @return array
         */
        static function get_attributes($field, $value = null)
        {
            $attributes = parent::get_attributes($field, $value);
            $attributes = wp_parse_args($attributes, array(
                'data-options' => wp_json_encode($field['js_options']),
            ));
            $attributes['type'] = 'text';
            $attributes['class'] .= ' cs-wp-color-picker';


            return $attributes;
        }
    }
}
