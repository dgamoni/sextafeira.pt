<?php
/*
Plugin Name: Brooks Core
Plugin URI: http://www.iondigi.com
Description: Core Plugin for Brooks Theme
Version: 1.1.2
Author: ION Digital
Author URI: http://www.iondigi.com
*/

if( !class_exists( 'Brooks_Core' ) ) {

	class Brooks_Core {

	     /**
	     * Plugin version, used for cache-busting of style and script file references.
	     *
	     * @since   1.0.0
	     *
	     * @var     string
	     */
	    protected $version = '1.1.2';

	    /**
	     * Unique identifier for your plugin.
	     *
	     * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	     * match the Text Domain file header in the main plugin file.
	     *
	     * @since    1.0.0
	     *
	     * @var      string
	     */
	    protected $plugin_slug = 'brooks-core';

	    /**
	     * Instance of this class.
	     *
	     * @since    1.0.0
	     *
	     * @var      object
	     */
	    protected static $instance = null;

		/**
		 * This method adds other methods to specific hooks within WordPress.
		 *
		 * @since     1.0.0
		 */
		public function __construct() {
			$this->init();
		}

		/**
		 * Initialize the plugin by setting localization and loading public scripts
		 *
		 * @since     1.0.0
		 */
		function init() {

            /**
             * Register metaboxes
             */
            if( !class_exists('RWMB_Autoloader') )
                include_once( 'inc/meta-box/meta-box.php' );

            include_once( 'inc/meta-box-group/meta-box-group.php' );
            include_once( 'inc/meta-box-tooltip/meta-box-tooltip.php' );
            include_once( 'inc/meta-box-columns/meta-box-columns.php' );
            include_once( 'inc/meta-box-tabs/meta-box-tabs.php' );
            include_once( 'inc/meta-box-include-exclude/meta-box-include-exclude.php' );
            include_once( 'inc/meta-box-show-hide/meta-box-show-hide.php' );
            include_once( 'inc/meta-box-conditional-logic/meta-box-conditional-logic.php' );
            include_once( 'inc/meta-box-settings-page/meta-box-settings-page.php' );
            include_once( 'inc/meta-term/mb-term-meta.php' );
            include_once( 'inc/meta-box-google-fonts/meta-box-google-fonts.php' );
            include_once( 'inc/meta-box-custom-output/meta-box-custom-output.php' );
            include_once( 'inc/meta-box-alpha-color/meta-box-alpha-color.php' );
            include_once( 'inc/ion-progress-importer/ion-progress-importer.php' );

        	add_action( 'init', array($this, 'register_post_types') );

        	$plugin_dir = plugin_dir_path(__FILE__);

            /** CPT **/
            include_once $plugin_dir. '/inc/profi-cpt.php';


            $this->extend_vc();

		}

	    /**
	     * Return an instance of this class.
	     *
	     * @since     1.0.0
	     *
	     * @return    object    A single instance of this class.
	     */
	    public static function get_instance() {

		    // If the single instance hasn't been set, set it now.
		    if ( null == self::$instance ) {
			    self::$instance = new self;
		    }

		    return self::$instance;
	    }

	    /**
		 * Register custom post types
		 *
		 * @since     1.0.0
		 */
		function register_post_types() {
            new Profi_Post_Types();
		}


        function extend_vc() {
            function get_font_id($variant){
                return str_replace( '400', 'regular', str_replace('400italic','italic',$variant['id']) );
            }

            function get_font_type($id){
                static $types = array(
                    '100'   => '100 light regular:100:normal',
                    '100italic' => '100 light italic:100:italic',
                    '200'   => '200 light regular:200:normal',
                    '200italic' => '200 light italic:200:italic',
                    '300'   => '300 light regular',
                    '300italic'   => '300 light italic:300:italic',
                    'regular' => '400 regular:400:normal',
                    'italic' => '400 italic:400:italic',
                    '500'   => '500 bold regular',
                    '500italic'   => '300 light italic:300:italic',
                    '600'   => '600 bold regular:600:normal',
                    '600italic'   => '600 bold italic:600:italic',
                    '700'   => '700 bold regular:700:normal',
                    '700italic' => '700 bold italic:700:italic',
                    '800'   => '800 bold regular:800:normal',
                    '800italic' => '800 bold italic:800:italic',
                    '900'   => '900 bold regular:900:normal',
                    '900italic' => '900 bold italic:900:italic'
                );

                return $types[$id];
            }

            function update_fonts($fonts){
                $fonts = array();
                $google_fonts = RWMB_Google_Fonts_Field::get_google_array();

                foreach($google_fonts as $font) {
                    $fontObj = new stdClass();
                    $fontObj->font_family = $font['name'];
                    $variants = array_map('get_font_id', $font['variants']);

                    $fontObj->font_styles = implode( ',', $variants );
                    $fontObj->font_types = implode( ',', array_map('get_font_type', $variants) );

                    $fonts[] = $fontObj;
                }

                return $fonts;
            }

            add_filter( 'vc_google_fonts_get_fonts_filter', 'update_fonts' );
        }
	}

    // Instantiate the class
    $profi_core = new Brooks_Core();

}