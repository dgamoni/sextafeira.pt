<?php
class Brooks_Theme_Options {
    private $settingsData = array();
    private $settingsTabs = array();
    private $initialData = array();
    private $frontData = array();

    private static $_instance = null;

    static public function getInstance() {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct($settingsTabs = null, $settingsData = null){
        self::$_instance = $this;

        if(empty($settingsTabs) || !is_array($settingsTabs) || empty($settingsData) || !is_array($settingsData))
            return;
        $this->settingsTabs = $settingsTabs;
        $this->settingsData = $settingsData;
        
        if(is_admin()) {
            add_filter('mb_settings_pages', array(&$this, 'initSettingsPage'));
            add_filter('rwmb_meta_boxes', array(&$this, 'initSettingsMeta'));
        }

        $this->initData();
    }

    public static function getData($slug = null, $single = false) {
        $themeOptions = self::getInstance();

        if(!$slug)
            return $themeOptions->frontData;

        if(empty($themeOptions->frontData[$slug])){
            if(empty($themeOptions->initialData[$slug]))
                return null;
            else
                return $themeOptions->initialData[$slug];
        }

        if(is_array($themeOptions->frontData[$slug]) && $single)
            return reset($themeOptions->frontData[$slug]);

        return $themeOptions->frontData[$slug];
    }

    public static function setData($slug = null, $value = null) {
        if(!$slug || (!$value && $value !== '0') )
            return false;

        $themeOptions = self::getInstance();

        $themeOptions->frontData[$slug] = $value;
        return true;
    }

    public static function getInitialData($slug, $single = false) {
        $themeOptions = self::getInstance();
        if(empty($themeOptions->initialData[$slug]))
            return null;

        if(is_array($themeOptions->initialData[$slug]) && $single)
            return reset($themeOptions->initialData[$slug]);

        return $themeOptions->initialData[$slug];
    }

    private function initData(){
        function fill_data($fields) {
            $out = array();

            foreach($fields as $field){
                if(empty($field['id']))
                    continue;

                $out[$field['id']] = array();

                if(!empty($field['fields']))
                    $out[$field['id']] = fill_data($field['fields']);
                else
                    $out[$field['id']] = isset($field['std']) && $field['type'] !== 'checkbox'?$field['std']:null;
            }

            return $out;
        }

        foreach($this->settingsData as $tab) {
            if(!isset($tab['fields']))
                continue;

            $this->initialData = array_merge($this->initialData, fill_data($tab['fields']));
        }

        if(!get_option(BROOKS_THEMENAME . '_theme_data')) {
            update_option(BROOKS_THEMENAME . '_theme_data', $this->initialData);
            $this->frontData = $this->initialData;
            return;
        }

        $this->frontData = array_merge( $this->initialData, get_option(BROOKS_THEMENAME . '_theme_data') );
    }

    public function initSettingsPage( $settings_pages ) {
        $settings_pages[] = array(
            'id'          => 'theme-options',
            'option_name' => BROOKS_THEMENAME . '_theme_data',
            'menu_title'  => esc_html__( 'Theme Options', 'brooks' ),
            'icon_url'    => 'dashicons-admin-generic',
            'style'       => 'boxes',
            'columns'     => 1,
            'tabs'        => $this->settingsTabs
        );
        return $settings_pages;
    }
    
    public function initSettingsMeta( $meta_boxes ) {
        return array_merge( $meta_boxes, $this->settingsData );
    }
}
