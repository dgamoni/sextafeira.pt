<?php
/**
 * Register Custom Post Types
 */

class Profi_Post_Types {

    public function __construct()
    {
        $this->register_post_types();
        $this->register_taxonomies();
    }

    public function post_types()
    {
        $args = array();

        // Buildings
        $args['building'] = array(
            'labels' => array(
                'name' => esc_html__( 'Buildings', 'brooks' ),
                'singular_name' => esc_html__( 'Building', 'brooks' ),
                'add_new' => esc_html__( 'Add New', 'brooks' ),
                'add_new_item' => esc_html__( 'Add New Building', 'brooks' ),
                'edit_item' => esc_html__( 'Edit Building', 'brooks' ),
                'new_item' => esc_html__( 'New Building', 'brooks' ),
                'view_item' => esc_html__( 'View Building', 'brooks' ),
                'search_items' => esc_html__( 'Search Buildings', 'brooks' ),
                'not_found' => esc_html__( 'No buildings found', 'brooks' ),
                'not_found_in_trash' => esc_html__( 'No buildings found in Trash', 'brooks' ),
                'parent_item_colon' => esc_html__( 'Parent building:', 'brooks' ),
            ),
            'hierarchical' => false,
            'description' => esc_html__( 'Add Your Building Items', 'brooks' ),
            'supports' => array( 'title', 'thumbnail', 'editor' ),
            'menu_icon' =>  'dashicons-admin-home',
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'query_var' => true,
            'rewrite' => true
        );

        // Portfolio
        $args['portfolio'] = array(
            'labels' => array(
                'name' => esc_html__( 'Portfolio', 'brooks' ),
                'singular_name' => esc_html__( 'Portfolio', 'brooks' ),
                'add_new' => esc_html__( 'Add New', 'brooks' ),
                'add_new_item' => esc_html__( 'Add New Portfolio', 'brooks' ),
                'edit_item' => esc_html__( 'Edit Portfolio', 'brooks' ),
                'new_item' => esc_html__( 'New Portfolio', 'brooks' ),
                'view_item' => esc_html__( 'View Portfolio', 'brooks' ),
                'search_items' => esc_html__( 'Search Portfolio', 'brooks' ),
                'not_found' => esc_html__( 'No buildings found', 'brooks' ),
                'not_found_in_trash' => esc_html__( 'No buildings found in Trash', 'brooks' ),
                'parent_item_colon' => esc_html__( 'Parent building:', 'brooks' ),
            ),
            'hierarchical' => false,
            'description' => esc_html__( 'Add Your Portfolio Items', 'brooks' ),
            'supports' => array( 'title', 'thumbnail', 'editor' ),
            'menu_icon' =>  'dashicons-admin-appearance',
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'query_var' => true,
            'rewrite' => true
        );

        // Portfolio
        $args['team'] = array(
            'labels' => array(
                'name' => esc_html__( 'Team', 'brooks' ),
                'singular_name' => esc_html__( 'Team Member', 'brooks' ),
                'add_new' => esc_html__( 'Add New', 'brooks' ),
                'add_new_item' => esc_html__( 'Add New Member', 'brooks' ),
                'edit_item' => esc_html__( 'Edit Member', 'brooks' ),
                'new_item' => esc_html__( 'New Member', 'brooks' ),
                'view_item' => esc_html__( 'View Member', 'brooks' ),
                'search_items' => esc_html__( 'Search Member', 'brooks' ),
                'not_found' => esc_html__( 'No team members found', 'brooks' ),
                'not_found_in_trash' => esc_html__( 'No team members found in Trash', 'brooks' ),
                'parent_item_colon' => esc_html__( 'Parent member:', 'brooks' ),
            ),
            'hierarchical' => false,
            'description' => esc_html__( 'Add Your Team Members', 'brooks' ),
            'supports' => array( 'title', 'thumbnail', 'editor' ),
            'menu_icon' =>  'dashicons-groups',
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'query_var' => true,
            'rewrite' => true
        );

//        Testimonials
        $args['testimonials'] = array(
            'labels' => array(
                'name' => esc_html__( 'Testimonials', 'brooks' ),
                'singular_name' => esc_html__( 'Testimonial', 'brooks' ),
                'add_new' => esc_html__( 'Add New', 'brooks' ),
                'add_new_item' => esc_html__( 'Add New Testimonial', 'brooks' ),
                'edit_item' => esc_html__( 'Edit Testimonial', 'brooks' ),
                'new_item' => esc_html__( 'New Testimonial', 'brooks' ),
                'view_item' => esc_html__( 'View Testimonial', 'brooks' ),
                'search_items' => esc_html__( 'Search Through Testimonials', 'brooks' ),
                'not_found' => esc_html__( 'No testimonials found', 'brooks' ),
                'not_found_in_trash' => esc_html__( 'No testimonials found in Trash', 'brooks' ),
                'parent_item_colon' => esc_html__( 'Parent Testimonial:', 'brooks' ),
                'menu_name' => esc_html__( 'Testimonials', 'brooks' ),

            ),
            'hierarchical' => false,
            'description' => esc_html__( 'Add a Testimonial', 'brooks' ),
            'supports' => array( 'title', 'thumbnail', 'editor'),
            'menu_icon' =>  'dashicons-testimonial',
            'public' => true,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => true
        );


        return $args;
    }

    public function register_taxonomies() {
        $post_taxonomies = $this->taxonomies();

        foreach($post_taxonomies as $post_type => $taxonomies) {
            foreach($taxonomies as $slug => $settings) {
                register_taxonomy($slug, array($post_type), $settings);
                register_taxonomy_for_object_type($slug, $post_type);
            }
        }
    }

    public function register_post_types() {
        $post_types = $this->post_types();

        foreach($post_types as $post_type => $settings) {
            register_post_type($post_type, $settings);
        }
    }

    private function taxonomies() {
        $taxonomies = array();
        $taxonomies['building'] = array();

        $taxonomies['building']['building_category'] = array(
            'labels' => array(
                'name' => esc_html__( 'Category', 'brooks' ),
                'singular_name' => esc_html__( 'Category', 'brooks' ),
                'search_items' =>  esc_html__( 'Search Categories', 'brooks' ),
                'all_items' => esc_html__( 'All Categories', 'brooks' ),
                'parent_item' => esc_html__( 'Parent Category', 'brooks' ),
                'parent_item_colon' => esc_html__( 'Parent Category:', 'brooks' ),
                'edit_item' => esc_html__( 'Edit Category', 'brooks' ),
                'update_item' => esc_html__( 'Update Category', 'brooks' ),
                'add_new_item' => esc_html__( 'Add New Category', 'brooks' ),
                'new_item_name' => esc_html__( 'New Category Name', 'brooks' ),
                'choose_from_most_used'	=> esc_html__( 'Choose from the most used categories', 'brooks' )
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => true,
        );

        $taxonomies['building']['location'] = array(
            'labels' => array(
                'name' => esc_html__( 'Location', 'brooks' ),
                'singular_name' => esc_html__( 'Location', 'brooks' ),
                'search_items' =>  esc_html__( 'Search Locations', 'brooks' ),
                'all_items' => esc_html__( 'All Locations', 'brooks' ),
                'parent_item' => esc_html__( 'Parent Country', 'brooks' ),
                'parent_item_colon' => esc_html__( 'Parent Country:', 'brooks' ),
                'edit_item' => esc_html__( 'Edit Location', 'brooks' ),
                'update_item' => esc_html__( 'Update Location', 'brooks' ),
                'add_new_item' => esc_html__( 'Add New Location', 'brooks' ),
                'new_item_name' => esc_html__( 'New Location Name', 'brooks' ),
                'choose_from_most_used'	=> esc_html__( 'Choose from the most used locations', 'brooks' )
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => true,
        );

        $taxonomies['building']['types'] = array(
            'labels' => array(
                'name' => esc_html__( 'Building Types', 'brooks' ),
                'singular_name' => esc_html__( 'Building Type', 'brooks' ),
                'search_items' =>  esc_html__( 'Search Building Types', 'brooks' ),
                'all_items' => esc_html__( 'All Building Types', 'brooks' ),
                'parent_item' => esc_html__( 'Parent Building Type', 'brooks' ),
                'parent_item_colon' => esc_html__( 'Parent Building Type:', 'brooks' ),
                'edit_item' => esc_html__( 'Edit Building Type', 'brooks' ),
                'update_item' => esc_html__( 'Update Building Type', 'brooks' ),
                'add_new_item' => esc_html__( 'Add New Building Type', 'brooks' ),
                'new_item_name' => esc_html__( 'New Building Type Name', 'brooks' ),
                'choose_from_most_used'	=> esc_html__( 'Choose from the most used building types', 'brooks' )
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => true,
        );

        $taxonomies['portfolio']['portfolio_category'] = array(
            'labels' => array(
                'name' => esc_html__( 'Category', 'brooks' ),
                'singular_name' => esc_html__( 'Category', 'brooks' ),
                'search_items' =>  esc_html__( 'Search Categories', 'brooks' ),
                'all_items' => esc_html__( 'All Categories', 'brooks' ),
                'parent_item' => esc_html__( 'Parent Category', 'brooks' ),
                'parent_item_colon' => esc_html__( 'Parent Category:', 'brooks' ),
                'edit_item' => esc_html__( 'Edit Category', 'brooks' ),
                'update_item' => esc_html__( 'Update Category', 'brooks' ),
                'add_new_item' => esc_html__( 'Add New Category', 'brooks' ),
                'new_item_name' => esc_html__( 'New Category Name', 'brooks' ),
                'choose_from_most_used'	=> esc_html__( 'Choose from the most used categories', 'brooks' )
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => true,
        );

        return $taxonomies;
    }

}