<?php

class Brooks_Post_Listing {
    protected $defaults = array(
        'post_type'             => 'post',
        'template_cb'           => array('Brooks_Post_Listing', 'get_post_template'), //valid function/class method returned single item html
        'posts_per_page'        => 12,
        'paged'                 => 1,
        'list_type'             => 'simple', // grid, masonry, metro, simple list
        'pagination_type'       => 'load_more',
        'order'                 => 'ASC',
        'orderby'               => 'date',
        'ignore_sticky_posts'   => false,
        'wp_query'              => false,
        'ajax_separated'        => true,
        'offset'                => 0,
        'tax_query'            => array(),
    );

    protected $setings = array();
    protected $request = array();

    protected $query;
    protected $items = array();
    protected $items_number = 0;

    protected static $ajax_registred = false;


    public function __construct($args = array()) {
        $this->settings = wp_parse_args( $args, $this->defaults );
        $this->get_request();

        self::register_ajax();

        $this->get_query();
    }


    public static function register_ajax() {
        if(self::$ajax_registred)
            return;

        brooks_register_ajax(array(
            'brooks_get_posts'  => 'ajax_response'
        ), 'Brooks_Post_Listing');

        self::$ajax_registred = true;
    }


    public static function ajax_response() {
        $instance = new Brooks_Post_Listing();

        wp_send_json_success($instance->get_ajax_response());
    }


    public static function get_post_template() {?>
        <div>

        </div>
    <?php }


    public function process_loop() {
        add_action('brooks_post_listing_get_item_html', $this->settings['template_cb']);

        while ($this->query->have_posts()) : $this->query->the_post();

            array_push( $this->items, array(
                'html'          => $this->get_item_html(),
                'id'            => get_the_ID(),
                'post_type'     => get_post_type()
            ));

        endwhile;
    }


    public function render() {
        $this->process_loop();
        $output = '';

        $output .= $this->get_html();

        return $output;
    }


    protected function get_item_html() {
        ob_start();
        do_action('brooks_post_listing_get_item_html');
        $html = ob_get_contents();
        ob_clean();

        return $html;
    }


    protected function get_ajax_response() {
        $response = array(
            'items_number' => $this->items_number,
            'html'    => array()
        );

        if($this->request['ajax_separated'])
            $response['html'] = $this->get_html();
        else
            $response['items'] = $this->items;

        return $response;
    }


    protected function get_query() {
        if($this->settings['wp_query']) {
            global $wp_query;
            $this->query = $wp_query;
            return;
        }

        $args = array(
            'post_type'             => post_type_exists( $this->settings['post_type'] )?$this->settings['post_type']:$this->defaults['post_type'],
            'posts_per_page'        => $this->settings['posts_per_page'],
            'paged'                 => $this->settings['paged'],
            'orderby'               => $this->settings['orderby'],
            'order'                 => $this->settings['order'],
            'ignore_sticky_posts'   => $this->settings['ignore_sticky_posts'],
        );

        if(!empty( $this->settings['tax_query'] ))
            $args['tax_query'] = $this->settings['tax_query'];

        $this->query = new WP_Query( $args );
    }


    protected function get_request() {
        if($_SERVER['REQUEST_METHOD'] === 'GET')
            $this->request = wp_parse_args( $_GET, $this->settings );
        else
            $this->request = wp_parse_args( $_POST, $this->settings );
    }


    protected function get_html() {
        $output = '';

        foreach($this->items as $item) {
            $output .= $item['html'];
        }
        return $output;
    }
}