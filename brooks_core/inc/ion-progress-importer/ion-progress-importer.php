<?php
if( !class_exists('ION_Progress_Importer') ) {

    class ION_Progress_Importer
    {
        protected static $prefix_slug = 'ionpi_';
        protected $prefix = '';
        protected $content_file;
        protected $time;
        protected $step;
        protected $wp_import;
        protected $message;
        protected $import_entities = array( 'categories', 'tags', 'terms', 'posts' );
        protected $content_progress = array();
        protected $defaults = array();
        protected $settings = array(
            'step'  => array(
                'categories'    => 100,
                'tags'    => 100,
                'terms'    => 100,
                'posts'    => 100,
            ),
            'process_step'  => 3,
            'backfill_step'  => 20
        );

        private static $_instances = array();

        static public function getInstance($slug = null, $args = array()) {
            if(empty($slug))
                return null;

            $slug = self::$prefix_slug . sanitize_title( $slug );

            if(empty(self::$_instances[$slug]))
            {
                self::$_instances[$slug] = new self( $slug, $args );
            }
            return self::$_instances[$slug];
        }

        public function __construct($slug = null, $args)
        {
            $this->prefix = $slug;
            $this->defaults = array(
                'heading'   => esc_html__( 'Import Demo Content', 'ion-progress-importer' ),
                'content_file'  => null,
            );

            $this->defaults = wp_parse_args($args, $this->defaults);

            $this->time = microtime(true);
            if ( defined('WP_LOAD_IMPORTERS') )
                return false;

            $this->load_importer();

            $this->content_file = !empty($this->defaults['content_file']) && file_exists($this->defaults['content_file'])?$this->defaults['content_file']:false;

            if(!$this->content_file)
                return false;

            $this->init_actions();
        }


        public function admin_enqueue_scripts() {
            wp_enqueue_style( 'ion-progress-importer', plugins_url( 'css/ion-progress-importer.css', __FILE__ ) );
            wp_enqueue_script( 'ion-progress-importer', plugins_url( 'js/ion-progress-importer.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
        }


        public function render() {
            $this->init_import_content();

            $output = '';
            $progress = $this->get_progress();

            $output .= '<div class="ion-progress-importer" data-ajax-action-process="'.esc_attr($this->prefix.'_process_import').'" id="'.$this->prefix.'" data-ajax-action-reset="'.esc_attr($this->prefix.'_reset_import').'">';
            $output .= '    <h3>' . $this->defaults['heading'] .'</h3>';
            $output .= '    <p>';
            $output .= '        <input type="checkbox" value="1" name="fetch_attachments" id="import-attachments" '.($this->content_progress['meta']['fetch_attachments']?'checked="checked"':'').' '.($progress > 0?'disabled="disabled"':'').' />';
            $output .= '        <label for="import-attachments">'. esc_html__( 'Download and import file attachments', 'ion-progress-importer' ) .'</label>';
            $output .= '    </p>';
            $output .= '    <p>';
            $output .= '        <input type="checkbox" value="1" name="force_update" id="force-update" '.($this->content_progress['meta']['force_update']?'checked="checked"':'').' '.($progress > 0?'disabled="disabled"':'').'/>';
            $output .= '        <label for="force-update">'. esc_html__( 'Force imported data to replace existed(IMPORTANT: your existed data will be replaced)', 'ion-progress-importer' ) .'</label>';
            $output .= '    </p>';
            $output .= '    <p class="info-message">' . esc_html__('The import process may take some time( up to 20 minutes ). Please be patient.', 'ion-progress-importer' ) .'</p>';
            $output .= '    <div class="progress-bar-wrapper html5-progress-bar">';
            $output .= '        <div class="progress-bar">';
            $output .= '            <div class="progress" style="width:'.$progress.'%"></div>';
            $output .= '        </div>';
            $output .= '        <div class="progress-value">'.intval($progress).'%</div>';
            $output .= '        <div class="start-import"><button class="button button-primary" data-pause-title="'.esc_html__('Pause Import', 'ion-progress-importer').'" data-start-title="'.esc_html__('Start Import', 'ion-progress-importer').'">'.esc_html__('Start Import', 'ion-progress-importer').'</button></div>';
            $output .= '        <div class="progress-bar-message"></div>';
            $output .= '    </div>';
            $output .= '</div>';

            return $output;
        }


        public function reset_import() {
            $this->init_import_content( true );

            wp_send_json_success( array('state'  => $this->content_progress['meta']['done'], 'progress' => $this->get_progress()) );
        }


        public function process_import() {
            $this->init_import_content();

            if( $this->content_progress['meta']['done'] === 1 )
                wp_send_json_success( array('state'  => $this->content_progress['meta']['done'], 'progress' => $this->get_progress(), 'message'  => esc_html__('Demo content imported successfully.', 'ion-progress-importer') . '<br>') );

            $step = 0;

            if(empty($this->content_progress['data'])) {
                $this->end_wp_import();

                update_option($this->prefix . 'content_progress', $this->content_progress);

                if($this->content_progress['meta']['done'] === 1)
                    wp_send_json_success( array('state'  => $this->content_progress['meta']['done'], 'progress' => $this->get_progress(),  'message'  => esc_html__('Demo content imported successfully.', 'ion-progress-importer') . '<br>' ));

                wp_send_json_success( array('state'  => $this->content_progress['meta']['done'], 'progress' => $this->get_progress(), 'message'   => esc_html__('Updating incorrect/missing information in the Database.', 'ion-progress-importer') . '<br>', 'data' => $this->content_progress['mapping']) );
            }


            while ($step < $this->settings['process_step']) {

                if(empty($this->content_progress['data']))
                    break;

                $entity_data = reset($this->content_progress['data']);

                if(!empty($entity_data)) {
                    $entity = key($this->content_progress['data']);
                    $entity_data = &$this->content_progress['data'][$entity];

                    array_push($this->wp_import->{$entity}, array_shift($entity_data));
                    $this->content_progress['meta']['current'][$entity]++;
                }

                if(empty($entity_data))
                    array_shift($this->content_progress['data']);

                $step++;
            }

            $this->process_wp_import();

            $this->update_import_content();
            update_option($this->prefix . 'content_progress', $this->content_progress);

            if(empty($this->content_progress['data'])){
                $this->content_progress['meta']['done'] = 0;
                wp_send_json_success( array('state'  => $this->content_progress['meta']['done'], 'progress' => $this->get_progress(), 'message'   => esc_html__('Updating incorrect/missing information in the Database.', 'ion-progress-importer') . '<br>') );
            }

            wp_send_json_success( array('state'  => $this->content_progress['meta']['done'], 'progress' => $this->get_progress(), 'message'   => $this->message, 'data' => $this->content_progress['mapping']) );
        }


        protected function end_wp_import(){
            wp_defer_term_counting( true );
            wp_defer_comment_counting( true );

            $this->content_progress['meta']['done'] = 1;

            $this->wp_import->processed_terms = $this->content_progress['mapping']['processed_terms'];
            $this->wp_import->processed_posts = $this->content_progress['mapping']['processed_posts'];
            $this->wp_import->processed_menu_items = $this->content_progress['mapping']['processed_menu_items'];

            ob_start();
            try {
                $this->backfill_parents();
                $this->backfill_attachment_urls();
                $this->remap_featured_images();
            } catch (Exception $e) {}
            $this->message = ob_get_contents();
            ob_clean();

            $this->content_progress['mapping']['processed_menu_items'] = $this->wp_import->processed_menu_items;

            wp_cache_flush();
            foreach ( get_taxonomies() as $tax ) {
                delete_option( "{$tax}_children" );
                _get_term_hierarchy( $tax );
            }

            wp_defer_term_counting( false );
            wp_defer_comment_counting( false );
        }


        protected function process_wp_import(){
            foreach ($this->content_progress['mapping'] as $key => $value) {
                $this->wp_import->{$key} = $value;
            }

            wp_defer_term_counting( true );
            wp_defer_comment_counting( true );

            wp_suspend_cache_invalidation( false );

            ob_start();
            try {
                $this->wp_import->process_categories();
                $this->wp_import->process_tags();
                $this->wp_import->process_terms();
                $this->wp_import->process_posts();
            } catch (Exception $e) {
            }

            $this->message = ob_get_contents();
            ob_clean();

            wp_suspend_cache_invalidation( false );


            foreach ($this->content_progress['mapping'] as $key => $value) {
                $this->content_progress['mapping'][$key] = $this->wp_import->{$key};
            }


            wp_defer_term_counting( false );
            wp_defer_comment_counting( false );
        }


        protected function get_progress() {
            $progress = 0;
            $total = 0;
            $meta = $this->content_progress['meta'];

            foreach ($this->import_entities as $entity) {
                if(!isset($meta['current'][$entity]) || !isset($meta['total'][$entity]))
                    continue;
                $progress += $meta['current'][$entity];
                $total += $meta['total'][$entity];
            }

            $progress = $progress/$total * 100;

            return $progress;
        }


        protected function load_importer() {
            try {

                if ( !class_exists( 'ION_WP_Import' ) ) {
                    include dirname( __FILE__ ) ."/ion-wordpress-importer.php";
                }

            } catch(Exception $e) {
                throw $e;
            }
        }


        protected function init_actions() {
            if(!empty($_POST['action']) && $_POST['action'] == $this->prefix.'_process_import') {
                require_once( ABSPATH . 'wp-admin/includes/admin.php' );
                $this->process_import();
            } elseif(!empty($_POST['action']) && $_POST['action'] == $this->prefix.'_reset_import') {
                require_once( ABSPATH . 'wp-admin/includes/admin.php' );
                $this->reset_import();
            }

            add_action('wp_ajax_'.$this->prefix.'_process_import', array($this, 'process_import'));
            add_action('wp_ajax_nopriv_'.$this->prefix.'_process_import', array($this, 'process_import'));

            add_action('wp_ajax_'.$this->prefix.'_reset_import', array($this, 'reset_import'));
            add_action('wp_ajax_nopriv_'.$this->prefix.'_reset_import', array($this, 'reset_import'));

            add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        }


        protected function update_import_content() {
            if(empty($this->content_progress['data'])) {
                $import_data = $this->wp_import->parse( $this->content_file );

                if ( is_wp_error( $import_data ) )
                    return false;

                foreach ($this->import_entities as $entity) {
                    if(empty( $import_data[$entity] ) || !is_array( $import_data[$entity] ))
                        continue;

                    if($this->content_progress['meta']['current'][$entity] == $this->content_progress['meta']['total'][$entity])
                        continue;

                    if(!isset($import_data[$entity][$this->content_progress['meta']['offset'][$entity]]))
                        continue;

                    $this->content_progress['data'][$entity] = array_slice( $import_data[$entity], $this->content_progress['meta']['offset'][$entity], $this->settings['step'][$entity] );
                    $this->content_progress['meta']['offset'][$entity] += count($this->content_progress['data'][$entity]);

                }
            }
        }


        protected function backfill_parents() {
            global $wpdb;

            // find parents for post orphans
            foreach ( $this->content_progress['mapping']['post_orphans'] as $child_id => $parent_id ) {
                $this->content_progress['meta']['done'] = 0;

                $local_child_id = $local_parent_id = false;
                if ( isset( $this->content_progress['mapping']['processed_posts'][$child_id] ) )
                    $local_child_id = $this->content_progress['mapping']['processed_posts'][$child_id];
                if ( isset( $this->content_progress['mapping']['processed_posts'][$parent_id] ) )
                    $local_parent_id = $this->content_progress['mapping']['processed_posts'][$parent_id];

                if ( $local_child_id && $local_parent_id ) {
                    $wpdb->update( $wpdb->posts, array( 'post_parent' => $local_parent_id ), array( 'ID' => $local_child_id ), '%d', '%d' );
                }

                unset($this->content_progress['mapping']['post_orphans'][$child_id]);

                $this->step++;
                if($this->step == $this->settings['backfill_step'])
                    return;
            }

            // all other posts/terms are imported, retry menu items with missing associated object
            foreach ( $this->content_progress['mapping']['missing_menu_items'] as $key => $item ) {
                $this->content_progress['meta']['done'] = 0;

                if($this->wp_import->process_menu_item($item, true)) {
                    unset($this->content_progress['mapping']['missing_menu_items'][$key]);
                    $this->step++;
                }

                if($this->step == $this->settings['backfill_step'])
                    return;
            }

            // find parents for menu item orphans
            foreach ( $this->content_progress['mapping']['menu_item_orphans'] as $child_id => $parent_id ) {
                $this->content_progress['meta']['done'] = 0;

                $local_child_id = $local_parent_id = 0;
                if ( isset( $this->content_progress['mapping']['processed_menu_items'][$child_id] ) )
                    $local_child_id = $this->content_progress['mapping']['processed_menu_items'][$child_id];
                if ( isset( $this->content_progress['mapping']['processed_menu_items'][$parent_id] ) )
                    $local_parent_id = $this->content_progress['mapping']['processed_menu_items'][$parent_id];

                if ( $local_child_id && $local_parent_id ) {
                    update_post_meta( $local_child_id, '_menu_item_menu_item_parent', (int) $local_parent_id );
                    unset($this->content_progress['mapping']['menu_item_orphans'][$child_id]);
                    $this->step++;
                }

                if($this->step == $this->settings['backfill_step'])
                    return;
            }
        }

        function backfill_attachment_urls() {
            global $wpdb;
            // make sure we do the longest urls first, in case one is a substring of another
            uksort( $this->content_progress['mapping']['url_remap'], array(&$this->wp_import, 'cmpr_strlen') );

            foreach ( $this->content_progress['mapping']['url_remap'] as $from_url => $to_url ) {
                $this->content_progress['meta']['done'] = 0;

                // remap urls in post_content
                $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url) );
                // remap enclosure urls
                $result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url) );

                unset($this->content_progress['mapping']['url_remap'][$from_url]);

                $this->step++;
                if($this->step == $this->settings['backfill_step'])
                    return;
            }
        }

        function remap_featured_images() {
            // cycle through posts that have a featured image
            foreach ( $this->content_progress['mapping']['featured_images'] as $post_id => $value ) {
                $this->content_progress['meta']['done'] = 0;

                if ( isset( $this->content_progress['mapping']['processed_posts'][$value] ) ) {
                    $new_id = $this->content_progress['mapping']['processed_posts'][$value];
                    // only update if there's a difference
                    if ( $new_id != $value )
                        update_post_meta( $post_id, '_thumbnail_id', $new_id );
                }

                unset($this->content_progress['mapping']['featured_images'][$post_id]);

                $this->step++;
                if($this->step == $this->settings['backfill_step'])
                    return;
            }
        }


        protected function init_import_content($reset = false) {
            $this->wp_import = new ION_WP_Import();
            $this->content_progress = get_option($this->prefix . 'content_progress');

            if($reset || empty($this->content_progress)) {
                $import_data = $this->wp_import->parse( $this->content_file );

                if ( is_wp_error( $import_data ) )
                    return false;

                $this->content_progress = array(
                    'meta'  => array(
                        'offset'    => array(),
                        'current'   => array(),
                        'done'      => -1,
                        'fetch_attachments' => true,
                        'force_update' => true
                    ),
                    'mapping'   => array(
                        'processed_authors' => array(),
                        'author_mapping' => array(),
                        'processed_terms' => array(),
                        'processed_posts' => array(),
                        'post_orphans' => array(),
                        'processed_menu_items' => array(),
                        'menu_item_orphans' => array(),
                        'missing_menu_items' => array(),

                        'url_remap' => array(),
                        'featured_images' => array()
                    ),
                    'data'  => array()
                );

                $this->content_progress['meta']['version'] = $import_data['version'];

                $this->wp_import->get_authors_from_import($import_data);
                $this->content_progress['meta']['authors'] = $this->wp_import->authors;

                $this->content_progress['meta']['base_url'] = esc_url( $import_data['base_url'] );

                foreach ($this->import_entities as $entity) {
                    if(empty( $import_data[$entity] ) || !is_array( $import_data[$entity] ))
                        continue;

                    $this->content_progress['meta']['current'][$entity] = 0;
                    $this->content_progress['meta']['offset'][$entity] = 0;
                    $this->content_progress['meta']['total'][$entity] = count( $import_data[$entity] );



                    $this->content_progress['data'][$entity] = array_slice( $import_data[$entity], $this->content_progress['meta']['offset'][$entity], $this->settings['step'][$entity] );
                    $this->content_progress['meta']['offset'][$entity] += count($this->content_progress['data'][$entity]);
                }

                update_option($this->prefix . 'content_progress', $this->content_progress);
            }

            if(isset($_POST['fetch_attachments']))
                $this->content_progress['meta']['fetch_attachments'] = $_POST['fetch_attachments'] == '1'?true:false;
            if(isset($_POST['force_update']))
                $this->content_progress['meta']['force_update'] = $_POST['force_update'] == '1'?true:false;

            $this->wp_import->fetch_attachments = $this->content_progress['meta']['fetch_attachments'];
            $this->wp_import->force_update = $this->content_progress['meta']['force_update'];
        }
    }
}