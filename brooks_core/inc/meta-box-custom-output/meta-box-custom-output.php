<?php

if ( class_exists( 'RWMB_Field' ) )
{
    class RWMB_Custom_Output_Field extends RWMB_Field
    {

        static public function html($meta, $field)
        {
            $output = '';
            if(function_exists($field['output']))
                $output = call_user_func($field['output']);

            return $output;
        }

    }
}