<?php
class Brooks_Meta_Options {
    private $settingsData = array();
    private $initialData = array();

    private static $_instance = null;

    static public function getInstance() {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct($args = null){
        self::$_instance = $this;

        if(empty($args) || !is_array($args))
            return;

        $this->settingsData = $args;
        $this->initData();

        if(is_admin()) {
            add_filter('rwmb_meta_boxes', array(&$this, 'initSettingsMeta'));
        }
    }

    public static function setData($slug = null, $value = null, $post_id = null) {
        if(!$slug || !$value || !$post_id || !class_exists('Brooks_Core'))
            return false;

        update_post_meta($post_id, $slug, $value);
    }

    public static function getData($slug = null, $post_id = null, $args = array()) {
        $metaOptions = self::getInstance();
        $result = null;

        if(!$post_id)
            return $metaOptions->getInitialData($slug);

        if(function_exists('rwmb_meta'))
            $result = rwmb_meta( $slug, $args, $post_id );

        if($result == '')
            $result = $metaOptions->getInitialData($slug);

        return $result;
    }

    public function getInitialData($slug) {

        if(!isset($this->initialData[$slug]) || $this->initialData[$slug] === ''){
            return null;
        }

        return $this->initialData[$slug];
    }

    private function initData(){
        foreach($this->settingsData as $tab) {
            if(!isset($tab['fields']))
                continue;

            $this->initialData = array_merge($this->initialData, $this->fill_data($tab['fields']));

        }
    }

    private function fill_data($fields) {
        $out = array();

        foreach($fields as $field){
            if(empty($field['id']))
                continue;

            if(!empty($field['fields']))
                $out[$field['id']] = $this->fill_data($field['fields']);
            elseif(isset($field['std']))
                $out[$field['id']] = $field['std'];
        }

        return $out;
    }

    public function initSettingsMeta( $meta_boxes ) {
        return array_merge( $meta_boxes, $this->settingsData );
    }
}
