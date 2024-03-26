<?php
$meta_boxes = array();

$meta_boxes[] = array(
    'title'      => esc_html__( 'Building Layout', 'brooks' ),
    'post_types' => 'building',
    'context'    => 'side',
    'priority'   => 'low',
    'fields'     => array(
        array(
            'id'   => 'building_layout',
            'type' => 'image_select',
            'std'  => 'left',
            'multiple' => false,
            'options' => array(
                'left' => BROOKS_IMAGES . '/metabox_params/building_layout_left.png',
                'center' => BROOKS_IMAGES . '/metabox_params/building_layout_center.png',
            )
        ),
        array(
            'id'   => 'building_layout_image',
            'type' => 'image_advanced',
            'max_file_uploads' => 1,
            'max_status'    =>  false,
            'name'             => esc_html__( 'Layout Background Image', 'brooks' ),
            'tooltip'          => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'Image will displayed in background in right part of the page', 'brooks' ),
                'position' => 'bottom',
            ),
        )
    ),
);

$meta_boxes[] = array(
    'post_types' => 'building',
    'context'    => 'normal',
    'title'     => esc_html__( 'Building Details', 'brooks' ),
    'tabs'      => array(
        'features' => array(
            'label' => esc_html__( 'Building Features', 'brooks' ),
            'icon'  => 'dashicons-admin-settings',
        ),
        'props'  => array(
            'label' => esc_html__( 'Building Properties Table', 'brooks' ),
            'icon'  => 'dashicons-media-spreadsheet',
        ),
        'location'  => array(
            'label' => esc_html__( 'Building Location', 'brooks' ),
            'icon'  => 'dashicons-location-alt',
        ),
        'contact' => array(
            'label' => esc_html__( 'Contact Info', 'brooks' ),
            'icon'  => 'dashicons-info',
        ),
    ),

    'tab_style' => 'box',
    'tab_wrapper' => false,
    'fields' => array(
        array(
            'id'     => 'building_features',
            'type'   => 'group',
            'tab'    => 'features',
            'clone'  => true,
            'sort_clone' => true,
            'fields' => array(
                array(
                    'id'               => 'image',
                    'name'             => esc_html__( 'Feature Image', 'brooks' ),
                    'type'             => 'image_advanced',
                    'max_file_uploads' => 1,
                    'max_status'    =>  false,
                    'columns'          => 3,
                    'clone'            => false,
                ),
                array(
                    'name'        => esc_html__( 'Feature title', 'brooks' ),
                    'id'          => 'title',
                    'type'        => 'textarea',
                    'placeholder' => esc_html__( 'Ex: over 100 rooms', 'brooks' ),
                    'rows'        => 3,
                    'cols'        => 5,
                    'columns'     => 5,
                    'tooltip'     => array(
                        'icon'     => 'help',
                        'content'  => esc_html__( 'Type feature title, all numbers will use increased font size. You can use following html tags for text formating: <strong>, <br>, <sup>, <sub>', 'brooks' ),
                        'position' => 'right',
                    ),
                ),
                array(
                    'name'        => esc_html__( 'Feature subtitle', 'brooks' ),
                    'id'          => 'subtitle',
                    'type'        => 'textarea',
                    'placeholder' => esc_html__( 'Ex: RENTAL SPACE', 'brooks' ),
                    'rows'        => 3,
                    'cols'        => 5,
                    'columns'     => 4,
                    'tooltip'     => array(
                        'icon'     => 'help',
                        'content'  => esc_html__( 'Type feature subtitle, this text will be displayed below the title. You can use following html tags for text formating: <strong>, <br>, <sup>, <sub>', 'brooks' ),
                        'position' => 'right',
                    ),
                ),
            ),
        ),
        array(
            'name'        => esc_html__( 'Properties info', 'brooks' ),
            'id'          => 'prop_info',
            'type'        => 'wysiwyg',
            'tab'         => 'props',
            'columns'     => 12,
        ),
        array(
            'id'     => 'building_props',
            'type'   => 'group',
            'tab'    => 'props',
            'clone'  => true,
            'sort_clone' => true,
            'fields' => array(
                array(
                    'name'        => esc_html__( 'Property', 'brooks' ),
                    'id'          => 'property',
                    'type'        => 'textarea',
                    'placeholder' => esc_html__( 'Ex: Planning Type', 'brooks' ),
                    'rows'        => 2,
                    'cols'        => 5,
                    'columns'     => 6,
                    'tooltip'     => array(
                        'icon'     => 'help',
                        'content'  => esc_html__( 'Type building property name. You can use following html tags for text formating: <strong>, <br>, <sup>, <sub>', 'brooks' ),
                        'position' => 'right',
                    ),
                ),
                array(
                    'name'        => esc_html__( 'Value', 'brooks' ),
                    'id'          => 'value',
                    'type'        => 'textarea',
                    'placeholder' => esc_html__( 'Ex: Open', 'brooks' ),
                    'rows'        => 2,
                    'cols'        => 5,
                    'columns'     => 6,
                    'tooltip'     => array(
                        'icon'     => 'help',
                        'content'  => esc_html__( 'Type buiding property value. You can use following html tags for text formating: <strong>, <br>, <sup>, <sub>', 'brooks' ),
                        'position' => 'right',
                    ),
                ),
            ),
        ),
        array(
            'id'        => 'address',
            'name'      => esc_html__( 'Address', 'brooks' ),
            'type'      => 'text',
            'tab'       => 'location',
            'std'       => esc_html__( 'San Francisco, USA', 'brooks' ),
            'tooltip'     => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'Type address to find it on the map.', 'brooks' ),
                'position' => 'right',
            ),
        ),
        array(
            'id'            => 'map',
            'name'          => esc_html__( 'Location', 'brooks' ),
            'type'          => 'map',
            'tab'           => 'location',
            'columns'       => 12,
            'std'           => '-6.233406,-35.049906,15',
            'address_field' => 'address',
        ),

        array(
            'id'        => 'phone',
            'name'      => esc_html__( 'Phone Number', 'brooks' ),
            'type'      => 'text',
            'tab'       => 'contact',
        ),
        array(
            'id'        => 'email',
            'name'      => esc_html__( 'Email address', 'brooks' ),
            'type'      => 'text',
            'tab'       => 'contact',
        ),
    ),
);

$meta_boxes[] = array(
    'post_types' => 'building',
    'context'    => 'normal',
    'title'     => esc_html__( 'Building Attachments', 'brooks' ),
    'tabs'      => array(
        'attachment_data'  => array(
            'label' => esc_html__( 'Attachment Info', 'brooks' ),
            'icon'  => 'dashicons-sticky',
        ),
        'attachment_appearance'  => array(
            'label' => esc_html__( 'Design Info', 'brooks' ),
            'icon'  => 'dashicons-admin-customizer',
        ),
    ),

    'tab_style' => 'box',
    'tab_wrapper' => false,
    'fields' => array(
        array(
            'name'        => esc_html__( 'Attachments info', 'brooks' ),
            'id'          => 'attach_info',
            'type'        => 'wysiwyg',
            'tab'         => 'attachment_data',
            'placeholder' => esc_html__( 'Ex: You can download plans of our building', 'brooks' ),
            'columns'     => 8,
            'options' => array(
                'textarea_rows' => 5,
                'teeny'         => false,
                'media_buttons' => false,
            ),
            'tooltip'     => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'This text will appear on the left side of the attachment block.', 'brooks' ),
                'position' => 'right',
            ),
        ),
        array(
            'id'     => 'attach_files',
            'type'   => 'group',
            'tab'    => 'attachment_data',
            'columns'     => 4,
            'fields' => array(
                array(
                    'id'               => 'attach_file',
                    'name'             => esc_html__( 'Attachment File', 'brooks' ),
                    'type'             => 'file_advanced',
                    'max_file_uploads' => 1,
                    'max_status'    =>  false,
                    'tooltip'          => array(
                        'icon'     => 'help',
                        'content'  => esc_html__( 'Choose file for downloading', 'brooks' ),
                        'position' => 'top',
                    ),
                ),
                array(
                    'name'        => esc_html__( 'Download Link Text', 'brooks' ),
                    'id'          => 'attach_file_text',
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Ex: Download Plans', 'brooks' ),
                )
            ),
        ),
        array(
            'id'               => 'attach_image',
            'name'             => esc_html__( 'Background Image', 'brooks' ),
            'type'             => 'image_advanced',
            'tab'              => 'attachment_appearance',
            'max_file_uploads' => 1,
            'max_status'    =>  false,
            'tooltip'          => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'Choose image for attachment block background, leave it empty for white background. text will change color to dark', 'brooks' ),
                'position' => 'bottom',
            ),
        ),
        array(
            'id'               => 'attach_bg_style',
            'name'             => esc_html__( 'Background Style', 'brooks' ),
            'type'             => 'select',
            'tab'              => 'attachment_appearance',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'options' => array(
                'parallax' => esc_html__( 'Background Parallax', 'brooks' ),
                'scale' => esc_html__( 'Scale Effect', 'brooks' ),
            ),
        ),
        array(
            'id'               => 'attach_bg_overlay',
            'name'             => esc_html__( 'Background Overlay', 'brooks' ),
            'type'             => 'select',
            'std'              => 'none',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'tab'              => 'attachment_appearance',
            'options' => array(
                'light' => esc_html__( 'Light Overlay', 'brooks' ),
                'dark' => esc_html__( 'Dark Overlay', 'brooks' ),
                'theme' => esc_html__( 'Theme Color Overlay', 'brooks' ),
            ),
        ),
        array(
            'name' => esc_html__( 'Use Gradient Color?', 'brooks' ),
            'id'   => 'attach_bg_color_grad',
            'type' => 'checkbox',
            'tab'  => 'attachment_appearance',
        ),

    )
);

$meta_boxes[] = array(
    'title'      => esc_html__( 'Building Pricing', 'brooks' ),
    'post_types' => 'building',
    'context'    => 'normal',
    'tabs'      => array(
        'pricing_appearance'  => array(
            'label' => esc_html__( 'Design Info', 'brooks' ),
            'icon'  => 'dashicons-admin-customizer',
        ),
        'pricing_data'  => array(
            'label' => esc_html__( 'Pricing List', 'brooks' ),
            'icon'  => 'dashicons-list-view',
        ),
    ),
    'tab_style'   => 'box',
    'tab_wrapper' => false,
    'fields'      => array(
        array(
            'name'        => esc_html__( 'Pricing info', 'brooks' ),
            'id'          => 'pricing_info',
            'type'        => 'wysiwyg',
            'tab'         => 'pricing_appearance',
            'options'     => array(
                'textarea_rows' => 5,
                'teeny'         => false,
                'media_buttons' => false,
            ),
        ),
        array(
            'id'     => 'building_pricing',
            'type'   => 'group',
            'clone'  => true,
            'tab'    => 'pricing_data',
            'sort_clone' => true,
            'fields' => array(
                array(
                    'id'   => 'pricing_bg_image',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'max_status'    =>  false,
                    'name' => esc_html__( 'Pricing Background Image', 'brooks' ),
                ),
                array(
                    'type' => 'divider',
                ),
                array(
                    'id'   => 'pricing_text',
                    'type' => 'wysiwyg',
                    'options' => array(
                        'textarea_rows' => 10,
                        'teeny'         => false,
                        'media_buttons' => true,
                    ),
                    'name' => esc_html__( 'Pricing Description', 'brooks' ),
                    'placeholder' => esc_html__( 'Ex: NICE ROOM UNDER 20 PEOPLE', 'brooks' ),
                ),
                array(
                    'type' => 'divider',
                ),
                array(
                    'id'   => 'pricing_btn_text',
                    'type' => 'text',
                    'name' => esc_html__( 'Button Text', 'brooks' ),
                    'placeholder' => esc_html__( 'Ex: CHOOSE PLAN', 'brooks' ),
                    'columns'     => 4,
                ),
                array(
                    'name' => esc_html__( 'Use Modal Box With Contact Form?', 'brooks' ),
                    'id'   => 'pricing_use_cf',
                    'type' => 'checkbox',
                    'columns'     => 4,
                ),
                array(
                    'id'   => 'pricing_btn_action',
                    'type' => 'group',
                    'columns'     => 4,
                    'clone'  => false,
                    'fields' => array(
                        array(
                            'name' => esc_html__( 'URL', 'brooks' ),
                            'id'   => 'pricing_url',
                            'type' => 'url',
                            'placeholder'  => 'http://example.com',
                            'hidden' => array( 'pricing_use_cf', '!=', '' )
                        ),
                        array(
                            'id'               => 'pricing_form',
                            'name'             => esc_html__( 'Choose Contact Form', 'brooks' ),
                            'hidden' => array( 'pricing_use_cf', '=', '' ),
                            'type' => 'post',
                            'field_type'    => 'select',
                            'multiple' => false,
                            'post_type' => 'wpcf7_contact_form'
                        ),
                    )
                ),
            )
        ),
        array(
            'id'               => 'pricing_image',
            'name'             => esc_html__( 'Background Image', 'brooks' ),
            'type'             => 'image_advanced',
            'tab'              => 'pricing_appearance',
            'max_file_uploads' => 1,
            'max_status'    =>  false,
            'tooltip'          => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'Choose image for attachment block background, leave it empty for white background. text will change color to dark', 'brooks' ),
                'position' => 'bottom',
            ),
        ),
        array(
            'id'               => 'pricing_bg_style',
            'name'             => esc_html__( 'Background Style', 'brooks' ),
            'type'             => 'select',
            'tab'              => 'pricing_appearance',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'options' => array(
                'parallax' => esc_html__( 'Background Parallax', 'brooks' ),
                'scale' => esc_html__( 'Scale Effect', 'brooks' ),
            ),
        ),
        array(
            'id'               => 'pricing_bg_overlay',
            'name'             => esc_html__( 'Background Overlay', 'brooks' ),
            'type'             => 'select',
            'std'              => 'none',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'tab'              => 'pricing_appearance',
            'options' => array(
                'light' => esc_html__( 'Light Overlay', 'brooks' ),
                'dark' => esc_html__( 'Dark Overlay', 'brooks' ),
                'theme' => esc_html__( 'Theme Color Overlay', 'brooks' ),
            ),
        ),
        array(
            'name' => esc_html__( 'Use Gradient Color?', 'brooks' ),
            'id'   => 'pricing_bg_color_grad',
            'type' => 'checkbox',
            'tab'  => 'pricing_appearance',
        ),
    ),
);

$meta_boxes[] = array(
    'title'      => esc_html__( 'Building Gallery', 'brooks' ),
    'post_types' => 'building',
    'context'    => 'normal',
    'fields'      => array(
        array(
            'name'        => esc_html__( 'Gallery info', 'brooks' ),
            'id'          => 'gallery_info',
            'type'        => 'wysiwyg',
            'tab'         => 'pricing_appearance',
            'options'     => array(
                'textarea_rows' => 5,
                'teeny'         => false,
                'media_buttons' => false,
            ),
        ),
        array(
            'id'   => 'gallery_image',
            'type' => 'image_advanced',
            'max_file_uploads' => 24,
            'clone'  => true,
            'sort_clone' => true,
            'name' => esc_html__( 'Gallery Images', 'brooks' ),
        ),
    ),
);

/** Building Terms Meta Boxes**/
$meta_boxes[] = array(
    'title'      => 'additional Info',
    'taxonomies' => array('location', 'types'),
    'fields'     => array(
        array(
            'name' => esc_html__( 'Featured Image', 'brooks' ),
            'id'   => 'featured_image',
            'type' => 'image_advanced',
        ),
    )
);

/** Default page options */
$meta_boxes[] = array(
    'title'      => esc_html__( 'Page Sidebar', 'brooks' ),
    'post_types' => 'page',
    'context'    => 'side',
    'priority'   => 'high',
    'exclude'    => array(
        'template'        => array( 'homepage.php' ),
    ),
    'hide'   => array(
        'template'        => array( 'homepage.php' ),
    ),
    'fields'      => array(
        array(
            'name' => esc_html__( 'Page Width', 'brooks' ),
            'id'   => 'page_width',
            'type' => 'image_select',
            'std'  => 'theme__container',
            'multiple' => false,
            'options' => array(
                'theme__container' => BROOKS_IMAGES . '/metabox_params/container.png',
                'theme__container__full' => BROOKS_IMAGES . '/metabox_params/fluid_container.png'
            )
        ),
        array(
            'type' => 'divider',
        ),
        array(
            'name' => esc_html__( 'Sidebar Position', 'brooks' ),
            'id'   => 'sidebar',
            'type' => 'radio',
            'std'  => 0,
            'multiple' => false,
            'options' => array(
                0 => esc_html__( 'No Sidebar', 'brooks' ),
                'sidebar__left' => esc_html__( 'Sidebar Left', 'brooks' ),
                'sidebar__right' => esc_html__( 'Sidebar Right', 'brooks' ),
            )
        )
    )
);

$meta_boxes[] = array(
    'title'      => esc_html__( 'Page Footer', 'brooks' ),
    'post_types' => 'page',
    'context'    => 'side',
    'priority'   => 'high',
    'fields'      => array(
        array(
            'name' => esc_html__( 'Hide footer on this page?', 'brooks' ),
            'id'   => 'page_footer',
            'type' => 'checkbox',
        )
    )
);


/** Blog Page Meta Boxes **/
$meta_boxes[] = array(
    'title'      => esc_html__( 'Blog Layout', 'brooks' ),
    'post_types' => 'page',
    'context'    => 'normal',
    'priority'   => 'high',
    'include'    => array(
        'template'        => array( 'blog.php' ),
        'ID'              => get_option( 'page_for_posts' )
    ),
    'show'   => array(
        'template'      => array( 'blog.php' ),
        'input_value'   => array(
            '#post_ID'=> get_option( 'page_for_posts' ),
        ),
    ),
    'fields'      => array(
        array(
            'name' => esc_html__( 'Blog Grid Type', 'brooks' ),
            'id'   => 'blog_grid',
            'type' => 'image_select',
            'std'  => 'masonry',
            'multiple' => false,
            'options' => array(
                'standart' => BROOKS_IMAGES . '/metabox_params/standart.png',
                'metro'    => BROOKS_IMAGES . '/metabox_params/complex.png',
                'masonry'  => BROOKS_IMAGES . '/metabox_params/masonry.png',
                'simple'   => BROOKS_IMAGES . '/metabox_params/simple.png'
            )
        ),
        array(
            'name' => esc_html__( 'Grid Columns', 'brooks' ),
            'id'   => 'blog_columns',
            'type' => 'radio',
            'std'  => 4,
            'multiple' => false,
            'visible' => array('blog_grid', '!=', 'standart'),
            'options' => array(
                2  => esc_html__( '2 columns', 'brooks' ),
                3  => esc_html__( '3 columns', 'brooks' ),
                4  => esc_html__( '4 columns', 'brooks' ),
                5  => esc_html__( '5 columns', 'brooks' ),
                6  => esc_html__( '6 columns', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Grid Gap', 'brooks' ),
            'id'   => 'blog_gap',
            'type' => 'radio',
            'std'  => 15,
            'multiple' => false,
            'visible' => array('blog_grid', '!=', 'standart'),
            'options' => array(
                0  => esc_html__( 'No', 'brooks' ),
                15  => esc_html__( 'Small Gap', 'brooks' ),
                30  => esc_html__( 'Large Gap', 'brooks' ),
            )
        ),
    )
);

$meta_boxes[] = array(
    'title'      => esc_html__( 'Blog Data Settings', 'brooks' ),
    'post_types' => 'page',
    'context'    => 'normal',
    'priority'   => 'high',
    'include'    => array(
        'template'        => array( 'blog.php' ),
        'ID'              => get_option( 'page_for_posts' )
    ),
    'show'   => array(
        'template'      => array( 'blog.php' ),
        'input_value'   => array(
            '#post_ID'=> get_option( 'page_for_posts' ),
        ),
    ),
    'fields'      => array(
        array(
            'id'              => 'blog_post_per_page',
            'name'            => esc_html__( 'Posts per Page', 'brooks' ),
            'type'            => 'number',
            'min'             => 1,
            'step'            => 1,
            'std'             => 10,
            'columns'         => 4,
        ),
        array(
            'name' => esc_html__( 'Posts Order', 'brooks' ),
            'id'   => 'blog_order',
            'type' => 'radio',
            'std'  => 'ASC',
            'multiple' => false,
            'columns'         => 4,
            'options' => array(
                'ASC'  => esc_html__( 'ASC', 'brooks' ),
                'DESC'  => esc_html__( 'DESC', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Order Posts By', 'brooks' ),
            'id'   => 'blog_orderby',
            'type' => 'select',
            'columns'         => 4,
            'std'  => 'none',
            'multiple' => false,
            'options' => array(
                'none' => esc_html__('Default', 'brooks'),
                'name' => esc_html__('Name', 'brooks'),
                'date' => esc_html__('Date', 'brooks'),
                'author' => esc_html__('Author', 'brooks'),
                'title' => esc_html__('Title', 'brooks'),
                'modified' => esc_html__('Modified', 'brooks'),
                'rand' => esc_html__('Random', 'brooks'),
                'comment_count' => esc_html__('Comment count', 'brooks'),
                'menu_order' => esc_html__('Menu order', 'brooks')
            )
        ),

        array(
            'type' => 'divider',
        ),

        array(
            'name' => esc_html__( 'Individual Posts', 'brooks' ),
            'id'   => 'blog_individual',
            'type' => 'post',
            'multiple' => true,
            'post_type' => 'post'
        ),

        array(
            'type' => 'divider',
            'visible' => array('blog_individual', '=', '')
        ),

        array(
            'name' => esc_html__( 'Blog Categories', 'brooks' ),
            'id'   => 'blog_categories',
            'type' => 'taxonomy_advanced',
            'multiple' => true,
            'visible' => array('blog_individual', '=', '')
        ),
        array(
            'id'               => 'blog_categories_relation',
            'name'             => esc_html__( 'Blog Categories Relation', 'brooks' ),
            'type'             => 'radio',
            'std'  => 'IN',
            'visible' => array(
                array('blog_categories', 'match', '[0-9]+[\D]+[0-9]+'),
                array('blog_individual', '=', '')
            ),
            'options' => array(
                'IN' => esc_html__( 'IN', 'brooks' ),
                'AND' => esc_html__( 'AND', 'brooks' ),
                'NOT IN' => esc_html__( 'NOT IN', 'brooks' ),
            ),

        ),

        array(
            'type' => 'divider',
            'visible' => array('blog_individual', '=', '')
        ),

        array(
            'name' => esc_html__( 'Blog Tags', 'brooks' ),
            'id'   => 'blog_tags',
            'type' => 'taxonomy_advanced',
            'multiple' => true,
            'visible' => array('blog_individual', '=', ''),
            'taxonomy'  => 'post_tag'
        ),
        array(
            'id'               => 'blog_tags_relation',
            'name'             => esc_html__( 'Blog Tags Relation', 'brooks' ),
            'type'             => 'radio',
            'std'  => 'IN',
            'visible' => array(
                array('blog_tags', 'match', '[0-9]+[\D]+[0-9]+'),
                array('blog_individual', '=', '')
            ),
            'options' => array(
                'IN' => esc_html__( 'IN', 'brooks' ),
                'AND' => esc_html__( 'AND', 'brooks' ),
                'NOT IN' => esc_html__( 'NOT IN', 'brooks' ),
            ),

        ),

        array(
            'type' => 'divider',
            'visible' => array('blog_individual', '=', '')
        ),

        array(
            'id'               => 'blog_tax_relation',
            'name'             => esc_html__( 'Blog Tags & Categories Relation', 'brooks' ),
            'type'             => 'radio',
            'std'  => 'OR',
            'visible' => array(
                array('blog_categories', '!=', ''),
                array('blog_tags', '!=', ''),
                array('blog_individual', '=', '')
            ),
            'options' => array(
                'OR' => esc_html__( 'OR', 'brooks' ),
                'AND' => esc_html__( 'AND', 'brooks' )
            ),

        ),

        array(
            'name' => esc_html__( 'Include sticky post?', 'brooks' ),
            'id'   => 'blog_include_sticky',
            'type' => 'checkbox',
            'visible' => array('blog_individual', '=', '')
        ),
    )
);


/** Post Meta Boxes **/
$meta_boxes[] = array(
    'title'      => esc_html__( 'Post Counter', 'brooks' ),
    'post_types' => array('post', 'portfolio'),
    'context'    => 'side',
    'fields'      => array(
        array(
            'name' => esc_html__( 'Post view counter', 'brooks' ),
            'id'   => 'post_viewed',
            'type' => 'text',
            'std'  => 0,
            'desc'  => esc_html__( 'Information about amount of post view, please DO NOT change it. It will collect analytics info', 'brooks' ),
        ),
        array(
            'name' => esc_html__( 'Post like counter', 'brooks' ),
            'id'   => 'post_liked',
            'type' => 'text',
            'std'  => 0,
            'desc'  => esc_html__( 'Information about amount of post likes, please DO NOT change it. It will collect analytics info', 'brooks' ),
        ),
    )
);


/** Blog Post Meta Boxes **/
$meta_boxes[] = array(
    'title'      => esc_html__( 'Post Layout', 'brooks' ),
    'post_types' => array('post', 'portfolio'),
    'context'    => 'normal',
    'priority'   => 'high',
    'fields'      => array(
        array(
            'name' => esc_html__( 'Posts Loop Layout Format', 'brooks' ),
            'id'   => 'post_loop_format',
            'type' => 'radio',
            'std'  => '1__1',
            'columns'   => 6,
            'multiple' => false,
            'options'   => array(
                '2__1'      => esc_html__( 'Horizontal', 'brooks' ),
                '1__1'      => esc_html__( 'Square', 'brooks' ),
                '1__2'      => esc_html__( 'Vertical', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Make Post as Featured?', 'brooks' ),
            'id'   => 'post_featured',
            'type' => 'checkbox',
            'columns'   => 6,
            'tooltip'          => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'In posts grid featured post will be stood out', 'brooks' ),
                'position' => 'bottom',
            ),
        ),
    )
);


/** Blog Post Meta Boxes(Audio Post Format) **/
$meta_boxes[] = array(
    'title'      => esc_html__( 'Audio Post Format', 'brooks' ),
    'post_types' => 'post',
    'context'    => 'normal',
    'priority'   => 'high',
    'tabs'      => array(
        'self' => array(
            'label' => esc_html__( 'Self Hosted Audio', 'brooks' ),
            'icon'  => 'fa fa-file-audio-o',
        ),
        'embeded'  => array(
            'label' => esc_html__( 'Embeded Audio', 'brooks' ),
            'icon'  => 'fa fa-soundcloud',
        )
    ),
    'tab_style' => 'box',
    'tab_wrapper' => false,
    'show'   => array(
        'post_format'   => array('Audio')
    ),
    'fields'      => array(
        array(
            'name'  => esc_html__( 'Audio File from Media Library', 'brooks' ),
            'id'    => 'audio_file',
            'type'  => 'file_advanced',
            'mime_type' => 'audio',
            'max_file_uploads'  => 1,
            'max_status'    =>  false,
            'tab'       => 'self',
        ),
        array(
            'id'    => 'audio_embeded',
            'name'  => esc_html__( 'Embeded Link', 'brooks' ),
            'desc'  => esc_html__( 'You can use Soundcloud or Mixcloud services by default to embed audio. For more services required implementing plugins', 'brooks' ),
            'type'  => 'oembed',
            'tab'   => 'embeded',
        )
    )
);


/** Blog Post Meta Boxes(Gallery Post Format) **/
$meta_boxes[] = array(
    'title'      => esc_html__( 'Gallery Post Format', 'brooks' ),
    'post_types' => 'post',
    'context'    => 'normal',
    'priority'   => 'high',
    'show'   => array(
        'post_format'   => array('Gallery')
    ),
    'fields'      => array(
        array(
            'name' => esc_html__( 'Image Grid Layout', 'brooks' ),
            'id'   => 'gallery_grid',
            'type' => 'image_select',
            'std'  => 'masonry',
            'multiple' => false,
            'options' => array(
                'metro'  => BROOKS_IMAGES . '/metabox_params/complex.png',
                'masonry'  => BROOKS_IMAGES . '/metabox_params/masonry.png',
                'simple'   => BROOKS_IMAGES . '/metabox_params/simple.png'
            )
        ),
        array(
            'name' => esc_html__( 'Image Grid Gap', 'brooks' ),
            'id'   => 'gallery_gap',
            'type' => 'radio',
            'std'  => 30,
            'multiple' => false,
            'options' => array(
                0  => esc_html__( 'No', 'brooks' ),
                15  => esc_html__( 'Small Gap', 'brooks' ),
                30  => esc_html__( 'Large Gap', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Gallery Layout Width', 'brooks' ),
            'id'   => 'gallery_width',
            'type' => 'radio',
            'std'  => 'theme__container',
            'multiple'  => false,
            'options'   => array(
                'theme__container'          => esc_html__( 'In Container', 'brooks' ),
                'theme__container__full'    => esc_html__( 'Full Width', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Image Grid Columns', 'brooks' ),
            'id'   => 'gallery_columns',
            'type' => 'radio',
            'std'  => 4,
            'multiple' => false,
//            'visible' => array('gallery_type', '=', 'grid'),
            'options' => array(
                2  => esc_html__( '2 columns', 'brooks' ),
                3  => esc_html__( '3 columns', 'brooks' ),
                4  => esc_html__( '4 columns', 'brooks' ),
                5  => esc_html__( '5 columns', 'brooks' ),
                6  => esc_html__( '6 columns', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Images', 'brooks' ),
            'id'   => 'gallery_images',
            'type' => 'image_advanced',
            'multiple' => true,
            'mime_type' => 'image'
        )
    )
);


/** Blog Post Meta Boxes(Link Post Format) **/
$meta_boxes[] = array(
    'title'      => esc_html__( 'Link Post Format', 'brooks' ),
    'post_types' => 'post',
    'context'    => 'normal',
    'priority'   => 'high',
    'show'   => array(
        'post_format'   => array('Link')
    ),
    'fields'      => array(
        array(
            'id'        => 'post_link',
            'name'      => esc_html__( 'Link', 'brooks' ),
            'type'      => 'text',
            'placeholder'=> esc_html__( 'http://example.com', 'brooks' ),
        ),
    )
);


/** Blog Post Meta Boxes(Quote Post Format) **/
$meta_boxes[] = array(
    'title'      => esc_html__( 'Quote Post Format', 'brooks' ),
    'post_types' => 'post',
    'context'    => 'normal',
    'priority'   => 'high',
    'show'   => array(
        'post_format'   => array('Quote')
    ),
    'fields'      => array(
        array(
            'id'        => 'author',
            'name'      => esc_html__( 'Quote Author', 'brooks' ),
            'type'      => 'text',
        ),
        array(
            'name'        => esc_html__( 'Quote Text', 'brooks' ),
            'id'          => 'quote',
            'type'        => 'wysiwyg',
            'options' => array(
                'textarea_rows' => 4,
                'teeny'         => false,
                'media_buttons' => false,
            ),
        ),
    )
);


/** Blog Post Meta Boxes(Video Post Format) **/
$meta_boxes[] = array(
    'title'      => esc_html__( 'Video Post Format', 'brooks' ),
    'post_types' => 'post',
    'context'    => 'normal',
    'priority'   => 'high',
    'tabs'      => array(
        'self' => array(
            'label' => esc_html__( 'Self Hosted Video', 'brooks' ),
            'icon'  => 'fa fa-file-movie-o',
        ),
        'embeded'  => array(
            'label' => esc_html__( 'Embeded Video', 'brooks' ),
            'icon'  => 'fa fa-youtube',
        )
    ),
    'tab_style' => 'box',
    'tab_wrapper' => false,
    'show'   => array(
        'post_format'   => array('Video')
    ),
    'fields'      => array(
        array(
            'name'  => esc_html__( 'Video File from Media Library', 'brooks' ),
            'id'    => 'video_file',
            'type'  => 'file_advanced',
            'mime_type' => 'video',
            'max_file_uploads'  => 1,
            'max_status'    =>  false,
            'tab'       => 'self',
        ),
        array(
            'id'    => 'video_embeded',
            'name'  => esc_html__( 'Embeded Link', 'brooks' ),
            'desc'  => esc_html__( 'You can use Youtube, Vimeo, Vine etc.', 'brooks' ),
            'type'  => 'oembed',
            'tab'   => 'embeded',
        )
    )
);

$meta_boxes[] = array(
    'title'      => esc_html__( 'Portfolio Info', 'brooks' ),
    'post_types' => 'portfolio',
    'context'    => 'normal',
    'fields'      => array(
        array(
            'id'        => 'portfolio_client',
            'name'      => esc_html__( 'Client Name', 'brooks' ),
            'type'      => 'text'
        ),
        array(
            'name'        => esc_html__( 'Portofolio Link Text', 'brooks' ),
            'id'          => 'portfolio_link_text',
            'type'        => 'text',
            'placeholder' => esc_html__( 'Ex: Visit Website', 'brooks' ),
        ),
        array(
            'name'        => esc_html__( 'Portofolio Link', 'brooks' ),
            'id'          => 'portfolio_link',
            'type'        => 'text',
            'placeholder' => esc_html__( 'Ex: example.com', 'brooks' ),
        )
    ),
);

$meta_boxes[] = array(
    'title'      => esc_html__( 'Portfolio Gallery', 'brooks' ),
    'post_types' => 'portfolio',
    'context'    => 'normal',
    'fields'      => array(
        array(
            'name' => esc_html__( 'Image Grid Layout', 'brooks' ),
            'id'   => 'portfolio_grid',
            'type' => 'image_select',
            'std'  => 'simple',
            'multiple' => false,
            'options' => array(
                'metro'  => BROOKS_IMAGES . '/metabox_params/complex.png',
                'masonry'  => BROOKS_IMAGES . '/metabox_params/masonry.png',
                'simple'   => BROOKS_IMAGES . '/metabox_params/simple.png'
            )
        ),
        array(
            'name' => esc_html__( 'Image Grid Gap', 'brooks' ),
            'id'   => 'portfolio_gap',
            'type' => 'radio',
            'std'  => 30,
            'multiple' => false,
            'options' => array(
                0  => esc_html__( 'No', 'brooks' ),
                15  => esc_html__( 'Small Gap', 'brooks' ),
                30  => esc_html__( 'Large Gap', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Gallery Layout Width', 'brooks' ),
            'id'   => 'portfolio_width',
            'type' => 'radio',
            'std'  => 'theme__container',
            'multiple'  => false,
            'options'   => array(
                'theme__container'          => esc_html__( 'In Container', 'brooks' ),
                'theme__container__full'    => esc_html__( 'Full Width', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Image Grid Columns', 'brooks' ),
            'id'   => 'portfolio_columns',
            'type' => 'radio',
            'std'  => 4,
            'multiple' => false,
            'options' => array(
                2  => esc_html__( '2 columns', 'brooks' ),
                3  => esc_html__( '3 columns', 'brooks' ),
                4  => esc_html__( '4 columns', 'brooks' ),
                5  => esc_html__( '5 columns', 'brooks' ),
                6  => esc_html__( '6 columns', 'brooks' ),
            )
        ),
        array(
            'id'   => 'portfolio_images',
            'type' => 'image_advanced',
            'multiple' => true,
            'mime_type' => 'image',
            'name' => esc_html__( 'Portfolio Images', 'brooks' )
        ),
    ),
);

$meta_boxes[] = array(
    'title'      => esc_html__( 'Member Personal Info', 'brooks' ),
    'post_types' => 'team',
    'context'    => 'normal',
    'priority'   => 'low',
    'fields'     => array(
        array(
            'id'    => 'member_position',
            'type'  => 'text',
            'name'  => esc_html__( 'Member Position', 'brooks' )
        ),
        array(
            'type' => 'divider',
        ),
        array(
            'id'     => 'member_social',
            'type'   => 'group',
            'clone'  => true,
            'sort_clone' => true,
            'fields' => array(
                array(
                    'id'        => 'social',
                    'name'      => esc_html__( 'Choose Social Network', 'brooks' ),
                    'type'      => 'select',
                    'columns'   => 6,
                    'options'          => array(
//                        'rss'              => esc_html__('RSS', 'brooks'),
                        'facebook'         => esc_html__('Facebook', 'brooks'),
                        'twitter'          => esc_html__('Twitter', 'brooks'),
                        'flickr'           => esc_html__('Flickr', 'brooks'),
                        'googleplus'      => esc_html__('Google+', 'brooks'),
                        'dribbble'         => esc_html__('Dribbble', 'brooks'),
                        'pinterest'        => esc_html__('Pinterest', 'brooks'),
                        'linkedin'         => esc_html__('Linkedin', 'brooks'),
//                        'skype'            => esc_html__('Skype', 'brooks'),
//                        'github-alt'       => esc_html__('Github', 'brooks'),
                        'youtube'          => esc_html__('Youtube', 'brooks'),
                        'vimeo'     => esc_html__('Vimeo', 'brooks'),
//                        'vine'             => esc_html__('Vine', 'brooks'),
                        'instagram'        => esc_html__('Instagram', 'brooks'),
                        'tumblr'           => esc_html__('Tumblr', 'brooks'),
                        'behance'          => esc_html__('Behance', 'brooks'),
//                        'vk'               => esc_html__('VK', 'brooks'),
//                        'xing'             => esc_html__('XING', 'brooks'),
                        'soundcloud'       => esc_html__('Soundcloud', 'brooks'),
//                        'codepen'          => esc_html__('Codepen', 'brooks'),
//                        'yelp'             => esc_html__('Yelp', 'brooks'),
                        'playstation'       => esc_html__('PlayStation Network', 'brooks'),
                        'reddit'       => esc_html__('Reddit', 'brooks'),
                        'qzone'       => esc_html__('QZone', 'brooks'),
                        'discuss'       => esc_html__('Discuss', 'brooks'),
                    )
                ),
                array(
                    'name'      => esc_html__( 'URL', 'brooks' ),
                    'id'        => 'url',
                    'columns'   => 6,
                    'type'      => 'text',
                    'placeholder'  => 'http://example.com'
                )
            )
        )
    ),
);

new Brooks_Meta_Options($meta_boxes);