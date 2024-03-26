<?php

if ( class_exists( 'RWMB_Field' ) )
{
    class RWMB_Google_Fonts_Field extends RWMB_Field
    {
        static $select_font_field = array();
        static $select_font_variants_field = array();
        static $google_array = array();
        static $select_font_array = array();


        /**
         * Normalize parameters for field
         *
         * @param array $field
         *
         * @return array
         */
        public static function normalize( $field )
        {
            $select_font_array = self::get_select_font_array( $field );

            self::$select_font_field = RWMB_Field::call( 'normalize', array(
                'type'             => 'select_advanced',
                'multiple'         => false,
                'options' => $select_font_array
            ) );

            self::$select_font_variants_field = RWMB_Field::call( 'normalize', array(
                'type'             => 'select',
                'multiple'         => false,
                'placeholder'      => esc_html__('Choose Font Style', 'brooks_core'),
                'options'          => array(
                    '400'   =>  esc_html__('Normal 400', 'brooks_core'),
                    '400italic'   =>  esc_html__('Normal 400 Italic', 'brooks_core'),
                    '700'   =>  esc_html__('Bold 700', 'brooks_core'),
                    '700italic'   =>  esc_html__('Bold 700 Italic', 'brooks_core'),
                )
            ) );

            return parent::normalize($field);
        }

        /**
         * Enqueue scripts and styles
         */
        public static function admin_enqueue_scripts()
        {
            wp_enqueue_script( 'webfont', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js', '', '1', true );
            wp_enqueue_script( 'brooks-core-google-font', plugins_url( 'font.js', __FILE__ ), array( 'jquery' ), '1', true );
            wp_localize_script('brooks-core-google-font', 'BrooksCoreFonts', self::get_google_array());

            RWMB_Select_Advanced_Field::admin_enqueue_scripts();
        }

        static public function esc_meta($meta) {
            return json_decode( $meta, true );
        }

        static public function html( $meta, $field )
        {
            $font_meta = !empty( $meta['font'] )?$meta['font']:null;
            $style_meta = !empty( $meta['style'] )?$meta['style']:null;

            $output = '';

            $select_font_field = self::$select_font_field;
            $select_font_field['id'] = $field['id'].'_'.'google_fonts';

            $select_font_html = self::call( $select_font_field, 'html', $font_meta );
            $select_font_html = self::filter( 'html', $select_font_html, $select_font_field, $font_meta );


            $select_font_variants_field = self::$select_font_variants_field;
            $select_font_variants_field['id'] = $field['id'].'_'.'fonts_variants';
            if(!empty($font_meta)) {
                $fonts = self::get_google_array();
                if(!empty($fonts[$font_meta])) {
                    $select_font_variants_field['options'] = array();
                    foreach ($fonts[$font_meta]['variants'] as $variant) {
                        $select_font_variants_field['options'][$variant['id']] = $variant['name'];
                    }
                }
            }

            $select_font_variants_html = self::call( $select_font_variants_field, 'html', $style_meta );
            $select_font_variants_html = self::filter( 'html', $select_font_variants_html, $select_font_variants_field, $style_meta );


            $output .= '<div class="brooks-rwmb-google-font rwmb-row">';
            $output .= '    <div class="rwmb-column rwmb-column-6">';
            $output .= '        <div class="rwmb-field font-family-select"><p class="description">'.esc_html__('Font Family', 'brooks_core').'</p>' . $select_font_html . '</div>';
            $output .= '        <div class="rwmb-field font-style-select"><p class="description">'.esc_html__('Font Weight & Style', 'brooks_core').'</p>' . $select_font_variants_html . '</div>';
            $output .= '    </div>';
            $output .= '    <div class="rwmb-field font-preview-holder rwmb-column rwmb-column-6"><p class="description">'.esc_html__('Font Preview', 'brooks_core').'</p><textarea rows="5" style="resize: none;width: 100%;font-size:30px;max-height:130px">1 2 3 4 5 6 7 8 9 0 A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r s t u v w x y z</textarea></div>';
            $output .= '    <input class="font-total-input" type="hidden" name="'.$field['id'].'" id="'.$field['id'].'" value="'. ($meta?esc_attr( wp_json_encode( $meta ) ):'') . '">';
            $output .= '</div>';

            return $output;
        }


        static public function get_select_font_array( $field ) {
            if(!empty(self::$select_font_array))
                return self::$select_font_array;

            foreach (self::get_google_array( $field ) as $key => $font)
                self::$select_font_array[$key] = $font['name'];

            return self::$select_font_array;
        }


        static public function get_google_array( $field = null ) {
            if(!empty(self::$google_array))
                return self::$google_array;

            $gFile = dirname( __FILE__ ) . '/googlefonts.php';

            if ( file_exists( $gFile ) && !empty($field['api_key']) ) {
                // Keep the fonts updated weekly
                $weekback     = strtotime( date( 'jS F Y', time() + ( 60 * 60 * 24 * - 7 ) ) );
                $last_updated = filemtime( $gFile );
                if ( $last_updated < $weekback ) {
                    unlink( $gFile );
                }
            }


            if ( ! file_exists( $gFile ) ) {

                if(!empty($field['api_key'])) {
                    $result = @wp_remote_get(apply_filters('redux-google-fonts-api-url', 'https://www.googleapis.com/webfonts/v1/webfonts?key=') . $field['api_key'], array('sslverify' => false));

                    if (!is_wp_error($result) && $result['response']['code'] == 200) {
                        $result = json_decode($result['body']);
                        foreach ($result->items as $font) {
                            $slug = trim( strtolower( preg_replace('/[^\w]+/', '_', $font->family) ) );

                            self::$google_array[ $slug ] = array(
                                'name'      => $font->family,
                                'variants' => self::get_variants($font->variants),
                                'subsets' => self::get_subsets($font->subsets)
                            );
                        }

                        if (!empty(self::$google_array))
                            file_put_contents($gFile, array('content' => "<?php return json_decode( '" . json_encode(self::$google_array) . "', true );"));

                    }
                }
            }

            if ( ! file_exists( $gFile ) )
                return false;


            $fonts = include $gFile;

            if ( $fonts === true )
                return false;

            if ( isset( $fonts ) && ! empty( $fonts ) && is_array( $fonts ) && $fonts != false ) {
                self::$google_array = $fonts;
            }

            return self::$google_array;
        }

        static public function get_subsets( $var ) {
            $result = array();

            foreach ( $var as $v ) {
                if ( strpos( $v, "-ext" ) ) {
                    $name = ucfirst( str_replace( "-ext", " Extended", $v ) );
                } else {
                    $name = ucfirst( $v );
                }

                array_push( $result, array(
                    'id'   => $v,
                    'name' => $name
                ) );
            }

            return array_filter( $result );
        }

        static public function get_variants( $var ) {
            $result = array();
            $italic = array();

            foreach ( $var as $v ) {
                $name = "";
                if ( $v[0] == 1 ) {
                    $name = 'Ultra-Light 100';
                } else if ( $v[0] == 2 ) {
                    $name = 'Light 200';
                } else if ( $v[0] == 3 ) {
                    $name = 'Book 300';
                } else if ( $v[0] == 4 || $v[0] == "r" || $v[0] == "i" ) {
                    $name = 'Normal 400';
                } else if ( $v[0] == 5 ) {
                    $name = 'Medium 500';
                } else if ( $v[0] == 6 ) {
                    $name = 'Semi-Bold 600';
                } else if ( $v[0] == 7 ) {
                    $name = 'Bold 700';
                } else if ( $v[0] == 8 ) {
                    $name = 'Extra-Bold 800';
                } else if ( $v[0] == 9 ) {
                    $name = 'Ultra-Bold 900';
                }

                if ( $v == "regular" ) {
                    $v = "400";
                }

                if ( strpos( $v, "italic" ) || $v == "italic" ) {
                    $name .= " Italic";
                    $name = trim( $name );
                    if ( $v == "italic" ) {
                        $v = "400italic";
                    }
                    $italic[] = array(
                        'id'   => $v,
                        'name' => $name
                    );
                } else {
                    $result[] = array(
                        'id'   => $v,
                        'name' => $name
                    );
                }
            }

            foreach ( $italic as $item ) {
                $result[] = $item;
            }

            return array_filter( $result );
        }
    }
}