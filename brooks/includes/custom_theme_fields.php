<?php
$settingsTabs = array(
    'general'      => esc_html__( 'General', 'brooks' ),
    'typography'   => esc_html__( 'Typography', 'brooks' ),
    'styling'      => esc_html__( 'Styling', 'brooks' ),
    'header'       => esc_html__( 'Header', 'brooks' ),
    'footer'       => esc_html__( 'Footer', 'brooks' ),
    'blog'         => esc_html__( 'Blog', 'brooks' ),
    'portfolio'    => esc_html__( 'Portfolio', 'brooks' ),
    'social'       => esc_html__( 'Social', 'brooks' ),
    'woocommerce'  => esc_html__( 'Woocommerce', 'brooks' ),
    'subscription' => esc_html__( 'Subscription', 'brooks' ),
    'not_found' => esc_html__( '404 Page', 'brooks' ),
    'api' => esc_html__( 'API', 'brooks' ),
);
$settingsData = array();


$settingsData[] = array(
    'id'             => 'general_import',
    'title'          => esc_html__( 'Import Demo Content', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'general',
    'fields' => array(
        array(
            'name' => esc_html__( 'CHOOSE ONE OF THE DEMO', 'brooks' ),
            'columns'   => 12,
            'id'   => 'start_import',
            'type' => 'custom_output',
            'output' => 'brooks_render_import',
            'desc' => esc_html__('The import process may take some time( up to 20 minutes ). Please be patient.', 'brooks' ),
        )
    )
);


$settingsData[] = array(
    'id'             => 'typography',
    'title'          => esc_html__( 'General Font Styling', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'typography',
    'fields' => array(
        array(
            'name' => esc_html__( 'General Font', 'brooks' ),
            'desc' => esc_html__( 'Set general font family and style.', 'brooks' ),
            'id'   => 'general_font',
            'type' => 'google_fonts'
        ),
        array(
            'name' => esc_html__( 'General Font Size', 'brooks' ),
            'desc' => esc_html__( 'Set general font size(px).', 'brooks' ),
            'id'   => 'general_font_size',
            'type' => 'number',
            'min'  => 6
        )
    )
);


$settingsData[] = array(
    'id'             => 'typography_menu',
    'title'          => esc_html__( 'Menu Font Styling', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'typography',
    'fields' => array(
        array(
            'name' => esc_html__( 'Menu Font', 'brooks' ),
            'desc' => esc_html__( 'Set menu font family and style.', 'brooks' ),
            'id'   => 'menu_font',
            'type' => 'google_fonts'
        ),
        array(
            'name' => esc_html__( 'Menu Font Size', 'brooks' ),
            'desc' => esc_html__( 'Set menu font size(px).', 'brooks' ),
            'id'   => 'menu_font_size',
            'type' => 'number',
            'min'  => 6
        )
    )
);


$settingsData[] = array(
    'id'             => 'typography_h1',
    'title'          => esc_html__( 'Heading 1 Font Styling', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'typography',
    'fields' => array(
        array(
            'name' => esc_html__( 'Heading Font - H1', 'brooks' ),
            'desc' => esc_html__( 'Set H1 font family and style.', 'brooks' ),
            'id'   => 'h1_font',
            'type' => 'google_fonts'
        ),
        array(
            'name' => esc_html__( 'H1 Font Size', 'brooks' ),
            'desc' => esc_html__( 'Set H1 font size(px).', 'brooks' ),
            'id'   => 'h1_font_size',
            'type' => 'number',
            'min'  => 6
        )
    )
);

$settingsData[] = array(
    'id'             => 'typography_h2',
    'title'          => esc_html__( 'Heading 2 Font Styling', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'typography',
    'fields' => array(
        array(
            'name' => esc_html__( 'Heading Font - H2', 'brooks' ),
            'desc' => esc_html__( 'Set H2 font family and style.', 'brooks' ),
            'id'   => 'h2_font',
            'type' => 'google_fonts'
        ),
        array(
            'name' => esc_html__( 'H2 Font Size', 'brooks' ),
            'desc' => esc_html__( 'Set H2 font size(px).', 'brooks' ),
            'id'   => 'h2_font_size',
            'type' => 'number',
            'min'  => 6
        )
    )
);

$settingsData[] = array(
    'id'             => 'typography_h3',
    'title'          => esc_html__( 'Heading 3 Font Styling', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'typography',
    'fields' => array(
        array(
            'name' => esc_html__( 'Heading Font - H3', 'brooks' ),
            'desc' => esc_html__( 'Set H3 font family and style.', 'brooks' ),
            'id'   => 'h3_font',
            'type' => 'google_fonts'
        ),
        array(
            'name' => esc_html__( 'H3 Font Size', 'brooks' ),
            'desc' => esc_html__( 'Set H3 font size(px).', 'brooks' ),
            'id'   => 'h3_font_size',
            'type' => 'number',
            'min'  => 6
        ),
    )
);

$settingsData[] = array(
    'id'             => 'typography_h4',
    'title'          => esc_html__( 'Heading 4 Font Styling', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'typography',
    'fields' => array(
        array(
            'name' => esc_html__( 'Heading Font - H4', 'brooks' ),
            'desc' => esc_html__( 'Set H4 font family and style.', 'brooks' ),
            'id'   => 'h4_font',
            'type' => 'google_fonts'
        ),
        array(
            'name' => esc_html__( 'H4 Font Size', 'brooks' ),
            'desc' => esc_html__( 'Set H4 font size(px).', 'brooks' ),
            'id'   => 'h4_font_size',
            'type' => 'number',
            'min'  => 6
        ),

    )
);

$settingsData[] = array(
    'id'             => 'typography_h5',
    'title'          => esc_html__( 'Heading 5 Font Styling', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'typography',
    'fields' => array(
        array(
            'name' => esc_html__( 'Heading Font - H5', 'brooks' ),
            'desc' => esc_html__( 'Set H5 font family and style.', 'brooks' ),
            'id'   => 'h5_font',
            'type' => 'google_fonts'
        ),
        array(
            'name' => esc_html__( 'H5 Font Size', 'brooks' ),
            'desc' => esc_html__( 'Set H5 font size(px).', 'brooks' ),
            'id'   => 'h5_font_size',
            'type' => 'number',
            'min'  => 6
        ),
    )
);

$settingsData[] = array(
    'id'             => 'typography_h6',
    'title'          => esc_html__( 'Heading 6 Font Styling', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'typography',
    'fields' => array(
        array(
            'name' => esc_html__( 'Heading Font - H6', 'brooks' ),
            'desc' => esc_html__( 'Set H6 font family and style.', 'brooks' ),
            'id'   => 'h6_font',
            'type' => 'google_fonts'
        ),
        array(
            'name' => esc_html__( 'H6 Font Size', 'brooks' ),
            'desc' => esc_html__( 'Set H6 font size(px).', 'brooks' ),
            'id'   => 'h6_font_size',
            'type' => 'number',
            'min'  => 6
        )
    )
);

$settingsData[] = array(
    'id'             => 'styling',
    'title'          => esc_html__( 'Styling', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'styling',
    'fields' => array(
        array(
            'name' => esc_html__( 'Define a Color Scheme', 'brooks' ),
            'desc' => esc_html__( 'Choose from predefined color schemes.', 'brooks' ),
            'id'   => 'theme_color',
            'type' => 'image_select',
            'std'  => '#383838',
            'multiple' => false,
            'options' => array(
                '#383838' => BROOKS_IMAGES . '/metabox_params/2E2E2E.png',
                '#056FDC' => BROOKS_IMAGES . '/metabox_params/056FDC.png',
                '#CDB389' => BROOKS_IMAGES . '/metabox_params/CDB389.png',
                '#E7C31F' => BROOKS_IMAGES . '/metabox_params/E7C31F.png',
                '#EE3F54' => BROOKS_IMAGES . '/metabox_params/EE3F54.png',
                '#70CEB9' => BROOKS_IMAGES . '/metabox_params/70CEB9.png',
                '#97C268' => BROOKS_IMAGES . '/metabox_params/97C268.png',
                '#9773B7' => BROOKS_IMAGES . '/metabox_params/9773B7.png',
                '#36658F' => BROOKS_IMAGES . '/metabox_params/36658F.png',
                '#FFBD51' => BROOKS_IMAGES . '/metabox_params/FFBD51.png'
            )
        ),
        array(
            'name' => esc_html__( 'Define a Custom Color Scheme', 'brooks' ),
            'desc' => esc_html__( 'You can define a new custom color for the theme scheme.', 'brooks' ),
            'id'   => 'theme_custom_color',
            'type' => 'color',
            'hidden'
        ),

        array(
            'type'  => 'divider'
        ),

        array(
            'name'    => esc_html__( 'Enable/Disable Preloader', 'brooks' ),
            'desc'    => esc_html__( 'You can enable/disable the website`s spinning wheel preloader.', 'brooks' ),
            'id'      => 'enable_preloader',
            'type'    => 'checkbox',
            'std'     => 1
        ),

        array( 'type'  => 'divider' ),

        array(
            'name'    => esc_html__( 'Google Map color scheme', 'brooks' ),
            'id'      => 'map_mode',
            'type'    => 'radio',
            'options' => array(
                'light' => esc_html__('Light', 'brooks'),
                'normal' => esc_html__('Normal', 'brooks'),
                'dark' => esc_html__('Dark', 'brooks')
            ),
            'std'     => 'normal'
        ),
        array(
            'name'    => esc_html__( 'Google Map grey color scheme', 'brooks' ),
            'id'      => 'map_grey',
            'type'    => 'checkbox',
        )
    ),
);


$settingsData[] = array(
    'id'             => 'header_logo',
    'title'          => esc_html__( 'Site Logo', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'header',
    'fields' => array(
        array(
            'name' => esc_html__( 'Main Logo', 'brooks' ),
            'desc' => esc_html__( 'Upload an image that will represent your website`s logo.', 'brooks' ),
            'id'   => 'logo',
            'type' => 'image_advanced',
            'max_file_uploads' => 1,
            'max_status'    => false,
            'mime_type'        => 'image',
        ),
        array(
            'name' => esc_html__( 'Alternative Logo', 'brooks' ),
            'desc' => esc_html__( 'Upload an image that will represent your website`s logo, when menu is scrolled.', 'brooks' ),
            'id'   => 'alt_logo',
            'type' => 'image_advanced',
            'max_file_uploads' => 1,
            'max_status'    => false,
            'mime_type'        => 'image',
        ),
        array(
            'name'    => esc_html__( 'Logo height', 'brooks' ),
            'desc'    => esc_html__( 'Set the height of logo image', 'brooks' ),
            'id'      => 'logo_height',
            'std'     => 50,
            'min'     => 0,
            'type'    => 'number',
        ),
    ),
);

$settingsData[] = array(
    'id'             => 'header_menu_type',
    'title'          => esc_html__( 'Header Menu Type', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'header',
    'fields' => array(

        array(
            'name' => esc_html__( 'Choose menu type', 'brooks' ),
            'id'   => 'menu_style',
            'type' => 'image_select',
            'std'  => 'normal__menu',
            'multiple' => false,
            'options' => array(
                'normal__menu' => BROOKS_IMAGES . '/metabox_params/normal.png',
                'aside__menu' => BROOKS_IMAGES . '/metabox_params/mobile_menu.png',
                'center__logo__menu' => BROOKS_IMAGES . '/metabox_params/center_menu.png',
                'side__bar__menu__left' => BROOKS_IMAGES . '/metabox_params/menu_left.png',
                'side__bar__menu__right' => BROOKS_IMAGES . '/metabox_params/menu_right.png',

            )
        ),

        array(
            'type'  => 'divider',
            'visible' => array('menu_style', '=', 'aside__menu'),
        ),

//        array(
//            'name'    => esc_html__( 'Menu Appearance Type', 'brooks' ),
//            'desc'    => esc_html__( 'Choose menu appearance type.', 'brooks' ),
//            'id'      => 'menu_appearance',
//            'type'    => 'radio',
//            'std'     => 'menu__list__fullscreen',
//            'options' => array(
//                'menu__list__fade' => esc_html__( 'Menu Items Faded', 'brooks' ),
//                'menu__list__aside' => esc_html__( 'Aside Menu', 'brooks' ),
//                'menu__list__fullscreen' => esc_html__( 'Full Screen Menu', 'brooks' ),
//            ),
//            'visible' => array('menu_style', '=', 'aside__menu'),
//        ),
        array(
            'name'    => esc_html__( 'Use Secondary Menu', 'brooks' ),
            'desc'    => esc_html__( 'Enable/disable secondary menu.', 'brooks' ),
            'id'      => 'secondary_menu',
            'type'    => 'checkbox',
            'visible' => array(
                array('menu_style', '=', 'aside__menu'),
                array('menu_appearance', '!=', 'menu__list__fade')
            )
        ),

        array(
            'type'  => 'divider',
            'visible' => array('menu_style', 'in', array('normal__menu', 'center__logo__menu', 'aside__menu'))
        ),

        array(
            'name'    => esc_html__( 'Menu Width', 'brooks' ),
            'desc'    => esc_html__( 'Choose menu layout width.', 'brooks' ),
            'id'      => 'menu_width',
            'type'    => 'radio',
            'std'     => 'boxed',
            'options' => array(
                'boxed' => esc_html__( 'Boxed', 'brooks' ),
                'full__width' => esc_html__( 'Full Width', 'brooks' ),
            ),
            'visible' => array('menu_style', 'in', array('normal__menu', 'center__logo__menu', 'aside__menu'))
        ),
        array(
            'name'    => esc_html__( 'Menu Scroll Mode', 'brooks' ),
            'desc'    => esc_html__( 'Set static or scrolled mode for menu.', 'brooks' ),
            'id'      => 'menu_scroll',
            'type'    => 'radio',
            'std'     => 'scroll',
            'options' => array(
                'scroll' => esc_html__( 'Scrolling', 'brooks' ),
                'static' => esc_html__( 'Static', 'brooks' ),
            ),
            'visible' => array('menu_style', 'in', array('normal__menu', 'center__logo__menu', 'aside__menu'))
        ),

        array(
            'type'  => 'divider',
            'columns'   => 12,
        ),

        array(
            'name'    => esc_html__( 'Header Content Alignment', 'brooks' ),
            'desc'    => esc_html__( 'Set alignment for header content.', 'brooks' ),
            'id'      => 'header_align',
            'type'    => 'radio',
            'columns'   => 4,
            'std'     => 'header__content__right',
            'options' => array(
                'header__content__left' => esc_html__( 'Right', 'brooks' ),
                'header__content__center' => esc_html__( 'Center', 'brooks' ),
                'header__content__right' => esc_html__( 'Left', 'brooks' ),
            )
        ),
        array(
            'name'    => esc_html__( 'Menu List Alignment', 'brooks' ),
            'desc'    => esc_html__( 'Set alignment for menu list.', 'brooks' ),
            'id'      => 'menu_align',
            'type'    => 'radio',
            'columns'   => 4,
            'std'     => 'menu__list__right',
            'visible' => array('menu_style', 'in', array('normal__menu', 'side__bar__menu__left', 'side__bar__menu__right')),
            'options' => array(
                'menu__list__left' => esc_html__( 'Left', 'brooks' ),
                'menu__list__center' => esc_html__( 'Center', 'brooks' ),
                'menu__list__right' => esc_html__( 'Right', 'brooks' ),
            )
        ),
        array(
            'name'    => esc_html__( 'Logo Alignment', 'brooks' ),
            'desc'    => esc_html__( 'Set logo alignment for side menu.', 'brooks' ),
            'id'      => 'logo_align',
            'type'    => 'radio',
            'std'     => 'logo__center',
            'columns'   => 4,
            'options' => array(
                'logo__left' => esc_html__( 'Left', 'brooks' ),
                'logo__center' => esc_html__( 'Center', 'brooks' ),
                'logo__right' => esc_html__( 'Right', 'brooks' ),
            ),
            'visible' => array('menu_style', 'in', array('side__bar__menu__left', 'side__bar__menu__right'))
        ),
        array(
            'name' => esc_html__( 'Header Background Color', 'brooks' ),
            'desc' => esc_html__( 'You can define a custom color for header menu in default position.', 'brooks' ),
            'id'   => 'header_general_color',
            'type' => 'alpha_color',
            'std'  => 'rgba(0,0,0,0)',
        ),
        array(
            'name' => esc_html__( 'Background Color Of Opened Menu', 'brooks' ),
            'desc' => esc_html__( 'You can define a custom color for header menu in opened position.', 'brooks' ),
            'id'   => 'header_general_color_aside_opened',
            'type' => 'alpha_color',
            'std'  => 'rgba(0,0,0,0)',
            'visible' => array('menu_style', 'in', array('aside__menu'))
        ),
    ),
);


$settingsData[] = array(
    'id'             => 'header_menu_initial',
    'title'          => esc_html__( 'Header Menu Initial', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'header',
    'fields' => array(
        array(
            'name'    => esc_html__( 'Top Offset', 'brooks' ),
            'desc'    => esc_html__( 'Set top offset for header menu in default position.', 'brooks' ),
            'id'      => 'top_offset',
            'std'     => 50,
            'min'     => 0,
            'type'    => 'number',
            'visible' => array('menu_style', 'in', array('normal__menu','center__logo__menu'))
        ),
//        array(
//            'name'    => esc_html__( 'Spacing Top', 'brooks' ),
//            'desc'    => esc_html__( 'Set top spacing for header menu in default position.', 'brooks' ),
//            'id'      => 'top_spacing',
//            'std'     => 0,
//            'min'     => 0,
//            'type'    => 'number',
//        ),
//        array(
//            'name'    => esc_html__( 'Spacing Bottom', 'brooks' ),
//            'desc'    => esc_html__( 'Set bottom spacing for header menu in default position.', 'brooks' ),
//            'id'      => 'bottom_spacing',
//            'std'     => 0,
//            'min'     => 0,
//            'type'    => 'number',
//        ),
        array(
            'name' => esc_html__( 'Header Nav List Background Color', 'brooks' ),
            'desc' => esc_html__( 'You can define a custom color for header menu in default position.', 'brooks' ),
            'id'   => 'header_color',
            'type' => 'alpha_color',
            'std'  => '#2F2E2F',
            'visible' => array('menu_style', '!=','aside__menu'),
        ),
        array(
            'name' => esc_html__( 'Header Text Color', 'brooks' ),
            'desc' => esc_html__( 'You can define a custom text color for header menu in default position.', 'brooks' ),
            'id'   => 'header_text_color',
            'type' => 'color',
            'std'  => '#FFF',
        )
    )
);


$settingsData[] = array(
    'id'             => 'header_menu_scroll',
    'title'          => esc_html__( 'Header Menu Scrolled', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'header',
    'fields' => array(
        array(
            'name'    => esc_html__( 'Top Offset', 'brooks' ),
            'desc'    => esc_html__( 'Set top offset for header menu in scrolled position.', 'brooks' ),
            'id'      => 'top_offset_scrolled',
            'std'     => 0,
            'min'     => 0,
            'type'    => 'number',
            'visible' => array('menu_style', '!=','aside__menu'),
        ),
//        array(
//            'name'    => esc_html__( 'Spacing Top', 'brooks' ),
//            'desc'    => esc_html__( 'Set top spacing for header menu in scrolled position.', 'brooks' ),
//            'id'      => 'top_spacing_scrolled',
//            'std'     => 0,
//            'min'     => 0,
//            'type'    => 'number',
//        ),
//        array(
//            'name'    => esc_html__( 'Spacing Bottom', 'brooks' ),
//            'desc'    => esc_html__( 'Set bottom spacing for header menu in scrolled position.', 'brooks' ),
//            'id'      => 'bottom_spacing_scrolled',
//            'std'     => 0,
//            'min'     => 0,
//            'type'    => 'number',
//        ),
        array(
            'name' => esc_html__( 'Header Nav List Background Color on Scroll or Mobile Menu', 'brooks' ),
            'id'   => 'header_color_scroll',
            'desc' => esc_html__( 'You can define a custom color for header menu in scrolled position.', 'brooks' ),
            'type' => 'alpha_color',
            'std'  => '#2F2E2F',
            'visible' => array('menu_style', '!=','aside__menu'),
        ),
        array(
            'name' => esc_html__( 'Header Text Color on Scroll or Mobile Menu', 'brooks' ),
            'desc' => esc_html__( 'You can define a custom text color for header menu in scroll position.', 'brooks' ),
            'id'   => 'header_text_color_scroll',
            'type' => 'color',
            'std'  => '#FFF',
            'visible' => array('menu_style', '!=','aside__menu'),
        ),
    )
);


$settingsData[] = array(
    'id'             => 'header_menu_dropdown',
    'title'          => esc_html__( 'Header Menu Dropdown', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'header',
    'fields' => array(
        array(
            'name' => esc_html__( 'Header Dropdown Background Color', 'brooks' ),
            'desc' => esc_html__( 'You can define a custom color for dropdown submenu background.', 'brooks' ),
            'id'   => 'header_dropdown_color',
            'type' => 'alpha_color',
            'std'  => '#2F2E2F',
            'visible' => array('menu_style', '!=','aside__menu'),
        ),
        array(
            'name' => esc_html__( 'Dropdown Text Color', 'brooks' ),
            'desc' => esc_html__( 'You can define a custom text color for dropdown submenu.', 'brooks' ),
            'id'   => 'header_dropdown_text_color',
            'type' => 'color',
            'std'  => '#FFFFFF',
        ),
//        array(
//            'name'    => esc_html__( 'Dropdown Type', 'brooks' ),
//            'desc'    => esc_html__( 'Set dropdown type for side menu.', 'brooks' ),
//            'id'      => 'dropdown_type',
//            'type'    => 'radio',
//            'std'     => 'outside__dropdown',
//            'options' => array(
//                'outside__dropdown' => esc_html__( 'Submenu List Outside', 'brooks' ),
//                'expand__dropdown' => esc_html__( 'Submenu List Expand', 'brooks' ),
//            ),
//            'visible' => array('menu_style', 'in', array('side__bar__menu__left', 'side__bar__menu__right')),
//        ),
    )
);


$settingsData[] = array(
    'id'             => 'footer',
    'title'          => esc_html__( 'Footer', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'footer',
    'fields' => array(
        array(
            'name'    => esc_html__( 'Footer Layout Columns', 'brooks' ),
            'desc'    => esc_html__( 'Set number of columns in the footer:', 'brooks' ),
            'id'      => 'footer_cols',
            'std'     => 3,
            'type'    => 'radio',
            'options' => array(
                1 => esc_html__('1 Column', 'brooks'),
                2 => esc_html__('2 Columns', 'brooks'),
                3 => esc_html__('3 Columns', 'brooks'),
                4 => esc_html__('4 Columns', 'brooks')
            ),
        ),

        array(
            'name' => esc_html__( 'Footer Layout View', 'brooks' ),
            'id'   => 'footer_view',
            'type' => 'image_select',
            'std'  => 'theme__container__left',
            'multiple' => false,
            'options' => array(
                'theme__container' => BROOKS_IMAGES . '/metabox_params/container.png',
                'theme__container__full' => BROOKS_IMAGES . '/metabox_params/fluid_container.png',
                'theme__container__right' => BROOKS_IMAGES . '/metabox_params/right_container.png',
                'theme__container__left' => BROOKS_IMAGES . '/metabox_params/left_container.png',
            )
        ),

        array(
            'name' => esc_html__('Background Color','brooks'),
            'id'   => 'footer_bg_color',
            'type' => 'color',
            'std'  => '#FFFFFF',
        ),
        array(
            'name' => esc_html__('Text Color','brooks'),
            'id'   => 'footer_text_color',
            'type' => 'color',
            'std'  => '#2F2E2F',
        ),
        array(
            'name' => esc_html__('Heading underline color similar to text color?','brooks'),
            'id'   => 'footer_text_underline_color',
            'type' => 'checkbox',
        ),
    ),
);

$settingsData[] = array(
    'id'             => 'footer_bottom',
    'title'          => esc_html__( 'Footer Bottom Section', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'footer',
    'fields' => array(
        array(
            'name' => esc_html__('Background Color','brooks'),
            'id'   => 'footer_bottom_bg_color',
            'type' => 'color',
            'std'  => '#2F2E2F'
        ),
        array(
            'name' => esc_html__('Text Color','brooks'),
            'id'   => 'footer_bottom_text_color',
            'type' => 'color',
            'std'  => '#FFFFFF'
        ),
    ),
);

$settingsData[] = array(
    'id'             => 'blog_lists',
    'title'          => esc_html__( 'Blog Lists', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'blog',
    'fields' => array(
        array(
            'name' => esc_html__( 'Archive Page Width', 'brooks' ),
            'id'   => 'archive_post_page_width',
            'type' => 'image_select',
            'std'  => 'theme__container',
            'multiple' => false,
            'options' => array(
                'theme__container' => BROOKS_IMAGES . '/metabox_params/container.png',
                'theme__container__full' => BROOKS_IMAGES . '/metabox_params/fluid_container.png'
            )
        ),
        array(
            'name' => esc_html__( 'Archive and Category Sidebar', 'brooks' ),
            'id'   => 'archive_post_sidebar',
            'type' => 'radio',
            'std'  => 0,
            'multiple' => false,
            'options' => array(
                0 => esc_html__( 'No Sidebar', 'brooks' ),
                'sidebar__left' => esc_html__( 'Sidebar Left', 'brooks' ),
                'sidebar__right' => esc_html__( 'Sidebar Right', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Posts Layout for Archive Pages', 'brooks' ),
            'id'   => 'archive_post_blog_grid',
            'type' => 'image_select',
            'std'  => 'standart',
            'multiple' => false,
            'options' => array(
                'standart' => BROOKS_IMAGES . '/metabox_params/standart.png',
                'metro'  => BROOKS_IMAGES . '/metabox_params/complex.png',
                'masonry'  => BROOKS_IMAGES . '/metabox_params/masonry.png',
                'simple'   => BROOKS_IMAGES . '/metabox_params/simple.png'
            )
        ),
        array(
            'name' => esc_html__( 'Grid Columns', 'brooks' ),
            'id'   => 'archive_post_blog_columns',
            'type' => 'radio',
            'std'  => 4,
            'multiple' => false,
            'visible' => array('archive_post_blog_grid', '!=', 'standart'),
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
            'id'   => 'archive_post_blog_gap',
            'type' => 'radio',
            'std'  => 15,
            'multiple' => false,
            'visible' => array('archive_post_blog_grid', '!=', 'standart'),
            'options' => array(
                0  => esc_html__( 'No', 'brooks' ),
                15  => esc_html__( 'Small Gap', 'brooks' ),
                30  => esc_html__( 'Large Gap', 'brooks' ),
            )
        ),

        array(
            'type'  => 'divider'
        ),

        array(
            'name' => esc_html__( 'Search Page Width', 'brooks' ),
            'id'   => 'search_page_width',
            'type' => 'image_select',
            'std'  => 'theme__container',
            'multiple' => false,
            'options' => array(
                'theme__container' => BROOKS_IMAGES . '/metabox_params/container.png',
                'theme__container__full' => BROOKS_IMAGES . '/metabox_params/fluid_container.png'
            )
        ),
        array(
            'name' => esc_html__( 'Search Page Sidebar', 'brooks' ),
            'id'   => 'search_sidebar',
            'type' => 'radio',
            'std'  => 0,
            'multiple' => false,
            'options' => array(
                0 => esc_html__( 'No Sidebar', 'brooks' ),
                'sidebar__left' => esc_html__( 'Sidebar Left', 'brooks' ),
                'sidebar__right' => esc_html__( 'Sidebar Right', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Posts Layout for Search Pages', 'brooks' ),
            'id'   => 'search_blog_grid',
            'type' => 'image_select',
            'std'  => 'standart',
            'multiple' => false,
            'options' => array(
                'standart' => BROOKS_IMAGES . '/metabox_params/standart.png',
                'metro'  => BROOKS_IMAGES . '/metabox_params/complex.png',
                'masonry'  => BROOKS_IMAGES . '/metabox_params/masonry.png',
                'simple'   => BROOKS_IMAGES . '/metabox_params/simple.png'
            )
        ),
        array(
            'name' => esc_html__( 'Grid Columns', 'brooks' ),
            'id'   => 'search_blog_columns',
            'type' => 'radio',
            'std'  => 4,
            'multiple' => false,
            'visible' => array('search_blog_grid', '!=', 'standart'),
            'options' => array(
                2  => esc_html__( '2 columns', 'brooks' ),
                3  => esc_html__( '3 columns', 'brooks' ),
                4  => esc_html__( '4 columns', 'brooks' ),
            )
        ),
        array(
            'name' => esc_html__( 'Grid Gap', 'brooks' ),
            'id'   => 'search_blog_gap',
            'type' => 'radio',
            'std'  => 15,
            'multiple' => false,
            'visible' => array('search_blog_grid', '!=', 'standart'),
            'options' => array(
                0  => esc_html__( 'No', 'brooks' ),
                15  => esc_html__( 'Small Gap', 'brooks' ),
                30  => esc_html__( 'Large Gap', 'brooks' ),
            )
        ),

        array(
            'type'  => 'divider'
        ),

        array(
            'id'               => 'blog_other_header_image',
            'name'             => esc_html__( 'Header Background Image', 'brooks' ),
            'type'             => 'image_advanced',
            'tab'              => 'blog',
            'max_file_uploads' => 1,
            'max_status'    =>  false,
            'tooltip'          => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'Choose image for attachment block background, leave it empty for white background.', 'brooks' ),
                'position' => 'bottom',
            )
        ),
        array(
            'id'               => 'blog_other_bg_style',
            'name'             => esc_html__( 'Header Background Style', 'brooks' ),
            'type'             => 'select',
            'tab'              => 'blog',

            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'options' => array(
                'parallax' => esc_html__( 'Background Parallax', 'brooks' ),
                'scale' => esc_html__( 'Scale Effect', 'brooks' ),
            ),
        ),
        array(
            'id'               => 'blog_other_bg_overlay',
            'name'             => esc_html__( 'Header Background Overlay', 'brooks' ),
            'type'             => 'select',
            'std'              => '',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'tab'              => 'blog',
            'options' => array(
                'light' => esc_html__( 'Light Overlay', 'brooks' ),
                'dark' => esc_html__( 'Dark Overlay', 'brooks' ),
                'theme' => esc_html__( 'Theme Color Overlay', 'brooks' ),
            ),
        ),
        array(
            'name' => esc_html__( 'Use Gradient Color?', 'brooks' ),
            'id'   => 'blog_other_bg_color_grad',
            'type' => 'checkbox',
            'tab'  => 'shop',
        ),
        array(
            'name' => esc_html__('Header Text Color','brooks'),
            'id'   => 'blog_other_color_text',
            'type' => 'color',
            'tab'  => 'shop',
            'std'  => '#ffffff'
        ),
        /**
         * TODO: Pagination, Load more, Lazy loading
         */
    )
);

$settingsData[] = array(
    'id'             => 'blog_single',
    'title'          => esc_html__( 'Blog Single', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'blog',
    'fields' => array(
        array(
            'name' => esc_html__( 'Sidebar Layout', 'brooks' ),
            'id'   => 'single_post_sidebar',
            'type' => 'radio',
            'std'  => 0,
            'multiple' => false,
            'options' => array(
                0 => esc_html__( 'No Sidebar', 'brooks' ),
                'sidebar__left' => esc_html__( 'Sidebar Left', 'brooks' ),
                'sidebar__right' => esc_html__( 'Sidebar Right', 'brooks' ),
            )
        ),
        array(
            'id'               => 'single_post_bg_style',
            'name'             => esc_html__( 'Header Background Style', 'brooks' ),
            'type'             => 'select',
            'tab'              => 'blog',

            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'options' => array(
                'parallax' => esc_html__( 'Background Parallax', 'brooks' ),
                'scale' => esc_html__( 'Scale Effect', 'brooks' ),
            ),
        ),
        array(
            'id'               => 'single_post_bg_overlay',
            'name'             => esc_html__( 'Header Background Overlay', 'brooks' ),
            'type'             => 'select',
            'std'              => '',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'options' => array(
                'light' => esc_html__( 'Light Overlay', 'brooks' ),
                'dark' => esc_html__( 'Dark Overlay', 'brooks' ),
                'theme' => esc_html__( 'Theme Color Overlay', 'brooks' ),
            ),
        ),
        array(
            'name' => esc_html__( 'Use Gradient Color?', 'brooks' ),
            'id'   => 'single_post_bg_color_grad',
            'type' => 'checkbox',
        ),
        array(
            'name' => esc_html__('Header Text Color','brooks'),
            'id'   => 'single_post_color_text',
            'type' => 'color',
            'std'  => '#ffffff'
        ),
    )
);


$settingsData[] = array(
    'id'             => 'portfolio_single',
    'title'          => esc_html__( 'Portfolio Single', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'portfolio',
    'fields' => array(
        array(
            'id'               => 'single_portfolio_header_image',
            'name'             => esc_html__( 'Header Background Image', 'brooks' ),
            'type'             => 'image_advanced',
            'max_file_uploads' => 1,
            'max_status'    =>  false,
            'tooltip'          => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'Choose image for attachment block background, leave it empty for white background.', 'brooks' ),
                'position' => 'bottom',
            )
        ),
        array(
            'id'               => 'single_portfolio_bg_style',
            'name'             => esc_html__( 'Header Background Style', 'brooks' ),
            'type'             => 'select',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'options' => array(
                'parallax' => esc_html__( 'Background Parallax', 'brooks' ),
                'scale' => esc_html__( 'Scale Effect', 'brooks' ),
            ),
        ),
        array(
            'id'               => 'single_portfolio_bg_overlay',
            'name'             => esc_html__( 'Header Background Overlay', 'brooks' ),
            'type'             => 'select',
            'std'              => '',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'options' => array(
                'light' => esc_html__( 'Light Overlay', 'brooks' ),
                'dark' => esc_html__( 'Dark Overlay', 'brooks' ),
                'theme' => esc_html__( 'Theme Color Overlay', 'brooks' ),
            ),
        ),
        array(
            'name' => esc_html__( 'Use Gradient Color?', 'brooks' ),
            'id'   => 'single_portfolio_bg_color_grad',
            'type' => 'checkbox',
        )
    )
);


$settingsData[] = array(
    'id'             => 'social',
    'title'          => esc_html__( 'Social', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'social',
    'fields' => array(
        // Group
        array(
            'name' => 'Social Networks',
            'id' => 'social_networks',
            'type' => 'group',
            'fields' => array(
                array(
                    'id'        => 'rss',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your RSS Feed address', 'brooks'),
                    'std'   => 'http://feeds.feedburner.com/EnvatoNotes'
                ),
                array(
                    'id'        => 'facebook',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Facebook page/brooksle URL', 'brooks'),
                    'std'   => 'http://www.facebook.com/envato'
                ),
                array(
                    'id'        => 'twitter',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Twitter URL', 'brooks'),
                    'std'   => 'http://twitter.com/envato'
                ),
                array(
                    'id'        => 'flickr',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Flickr Page URL', 'brooks'),
                ),
                array(
                    'id'        => 'google-plus',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Google Plus Page URL', 'brooks'),
                ),
                array(
                    'id'        => 'dribbble',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Dribbble Profile URL', 'brooks'),
                ),
                array(
                    'id'        => 'pinterest',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Pinterest URL', 'brooks'),
                ),
                array(
                    'id'        => 'linkedin',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your LinkedIn Profile URL', 'brooks'),
                ),
                array(
                    'id'        => 'skype',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Skype Userdesc', 'brooks'),
                ),
                array(
                    'id'        => 'github-alt',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Github URL', 'brooks'),
                ),
                array(
                    'id'        => 'youtube',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your YouTube URL', 'brooks'),
                ),
                array(
                    'id'        => 'vimeo-square',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Vimeo Page URL', 'brooks'),
                ),
                array(
                    'id'        => 'vine',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Vine page/brooksle URL', 'brooks'),
                    'std'   => ''
                ),
                array(
                    'id'        => 'instagram',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Instagram Profile URL', 'brooks'),
                ),

                array(
                    'id'        => 'tumblr',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Tumblr URL', 'brooks'),
                ),

                array(
                    'id'        => 'behance',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Behance Profile URL', 'brooks'),
                ),

                array(
                    'id'        => 'vk',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your VK URL', 'brooks'),
                ),

                array(
                    'id'        => 'xing',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Xing URL', 'brooks'),
                ),
                array(
                    'id'        => 'soundcloud',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your SoundCloud URL', 'brooks'),
                ),
                array(
                    'id'        => 'codepen',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Codepen URL', 'brooks'),
                ),
                array(
                    'id'        => 'yelp',
                    'columns'   => 4,
                    'type'      => 'text',
                    'desc'     => esc_html__('Your Yelp URL', 'brooks'),
                ),
            ),
        ),
    ),
);
$settingsData[] = array(
    'id'             => 'woocommerce',
    'title'          => esc_html__( 'Woocommerce', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'woocommerce',
    'tabs'      => array(
        'shop'  => array(
            'label' => esc_html__( 'Shop Page', 'brooks' ),
            'icon'  => 'dashicons-admin-settings',
        ),
        'product'  => array(
            'label' => esc_html__( 'Product Page', 'brooks' ),
            'icon'  => 'dashicons-index-card',
        ),
    ),
    'fields' => array(
        array(
            'name'    => esc_html__( 'Products per page', 'brooks' ),
            'desc'    => esc_html__( 'Set the number products per page', 'brooks' ),
            'id'      => 'page_number_product',
            'std'     => 10,
            'type'    => 'number',
            'tab'     => 'shop',
        ),
        array(
            'name'    => esc_html__( 'Columns', 'brooks' ),
            'desc'    => esc_html__( 'Set the number of columns in the shop', 'brooks' ),
            'id'      => 'product_columns',
            'std'     => 3,
            'type'    => 'number',
            'tab'     => 'shop',
        ),
        array(
            'name' => esc_html__( 'Sidebar Position', 'brooks' ),
            'id'   => 'shop_sidebar',
            'type' => 'radio',
            'tab'  => 'shop',
            'multiple' => false,
            'options' => array(
                0 => esc_html__( 'No Sidebar', 'brooks' ),
                'sidebar__left' => esc_html__( 'Sidebar Left', 'brooks' ),
                'sidebar__right' => esc_html__( 'Sidebar Right', 'brooks' ),
            ),
            'std' => 'sidebar__right'
        ),
        array(
            'type'  => 'divider',
            'tab'   => 'shop',
        ),

        array(
            'id'               => 'shop_attach_image',
            'name'             => esc_html__( 'Shop Background Image', 'brooks' ),
            'type'             => 'image_advanced',
            'tab'              => 'shop',
            'max_file_uploads' => 1,
            'max_status'    =>  false,
            'tooltip'          => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'Choose image for attachment block background, leave it empty for white background. text will change color to dark', 'brooks' ),
                'position' => 'bottom',
            )
        ),
        array(
            'id'               => 'shop_attach_bg_style',
            'name'             => esc_html__( 'Shop Background Style', 'brooks' ),
            'type'             => 'select',
            'tab'              => 'shop',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'options' => array(
                'parallax' => esc_html__( 'Background Parallax', 'brooks' ),
                'scale' => esc_html__( 'Scale Effect', 'brooks' ),
            ),
        ),
        array(
            'id'               => 'shop_attach_bg_overlay',
            'name'             => esc_html__( 'Shop Background Overlay', 'brooks' ),
            'type'             => 'select',
            'std'              => '',
            'tab'              => 'shop',
            'options' => array(
                0   => esc_html__('None', 'brooks'),
                'light' => esc_html__( 'Light Overlay', 'brooks' ),
                'dark' => esc_html__( 'Dark Overlay', 'brooks' ),
                'theme' => esc_html__( 'Theme Color Overlay', 'brooks' ),
            ),
        ),
        array(
            'name' => esc_html__( 'Use Gradient Color?', 'brooks' ),
            'id'   => 'shop_attach_bg_color_grad',
            'visible' => array('shop_attach_bg_overlay', '!=', ''),
            'type' => 'checkbox',
            'tab'  => 'shop',
        ),
        array(
            'name' => esc_html__('Header Text Color','brooks'),
            'id'   => 'shop_attach_color_text',
            'type' => 'color',
            'tab'  => 'shop',
            'std'  => '#ffffff'
        ),

        array(
            'type'  => 'divider',
            'tab'   => 'shop',
        ),

        array(
            'name' => esc_html__( 'Active Label "NEW" ', 'brooks' ),
            'id'   => 'new_label_product_checker',
            'desc'    => esc_html__( 'Active label "NEW" on the thumbnail product picture', 'brooks' ),
            'type'    => 'checkbox',
            'tab'  => 'shop',
        ),
        array(
            'name' => esc_html__( 'Number of days', 'brooks' ),
            'id'      => 'new_label_product_day',
            'std'     => 10,
            'desc'    => esc_html__( 'Number of days what label is showed from post creating day.', 'brooks' ),
            'type'    => 'number',
            'tab'  => 'shop',
            'visible' => array('new_label_product_checker', '!=', 0),
        ),
        array(
            'name'    => esc_html__( 'Show Related Products', 'brooks' ),
            'desc'    => esc_html__( 'You can enable/disable the showing related products.', 'brooks' ),
            'id'      => 'enable_related_product',
            'type'    => 'checkbox',
            'std'     => 1,
            'tab'     => 'product',
        ),
        array(
            'name'    => esc_html__( 'Number Of Related Products', 'brooks' ),
            'desc'    => esc_html__( 'Set the number Of related products', 'brooks' ),
            'id'      => 'rel_number_product',
            'std'     => 4,
            'type'    => 'number',
            'tab'     => 'product',
        ),
        array(
            'name'    => esc_html__( 'Enable social sharing', 'brooks' ),
            'desc'    => esc_html__( 'You can enable/disable the showing social sharing in the product page.', 'brooks' ),
            'id'      => 'enable_social_sharing',
            'type'    => 'checkbox',
            'tab'     => 'product',
            'std'     => 1
        ),

        array(
            'type'  => 'divider',
            'tab'   => 'product',
        ),

        array(
            'id'               => 'product_attach_image',
            'name'             => esc_html__( 'Product Background Image', 'brooks' ),
            'type'             => 'image_advanced',
            'tab'              => 'product',
            'max_file_uploads' => 1,
            'max_status'    =>  false,
            'tooltip'          => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'Choose image for attachment block background, leave it empty for white background. text will change color to dark', 'brooks' ),
                'position' => 'bottom',
            )
        ),
        array(
            'id'               => 'product_attach_bg_style',
            'name'             => esc_html__( 'Shop Background Style', 'brooks' ),
            'type'             => 'select',
            'tab'              => 'product',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'options' => array(
                'parallax' => esc_html__( 'Background Parallax', 'brooks' ),
                'scale' => esc_html__( 'Scale Effect', 'brooks' ),
            ),
        ),
        array(
            'id'               => 'product_attach_bg_overlay',
            'name'             => esc_html__( 'Shop Background Overlay', 'brooks' ),
            'type'             => 'select',
            'std'              => '',
            'tab'              => 'product',
            'options' => array(
                0   => esc_html__('None', 'brooks'),
                'light' => esc_html__( 'Light Overlay', 'brooks' ),
                'dark' => esc_html__( 'Dark Overlay', 'brooks' ),
                'theme' => esc_html__( 'Theme Color Overlay', 'brooks' ),
            ),
        ),
        array(
            'name' => esc_html__( 'Use Gradient Color?', 'brooks' ),
            'id'   => 'product_attach_bg_color_grad',
            'visible' => array('shop_attach_bg_overlay', '!=', ''),
            'type' => 'checkbox',
            'tab'  => 'product',
        ),
        array(
            'name' => esc_html__('Header Text Color','brooks'),
            'id'   => 'product_attach_color_text',
            'type' => 'color',
            'tab'  => 'product',
            'std'  => '#ffffff'
        )
    )
);

$settingsData[] = array(
    'id'             => 'subscription',
    'title'          => esc_html__( 'Subscription', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'subscription',
    'fields' => array(
        array(
            'id'               => 'subscribe_form_page_default',
            'name'             => esc_html__( 'Choose Contact Form for Default Page Template', 'brooks' ),
            'type' => 'post',
            'multiple' => false,
            'post_type' => 'wpcf7_contact_form',
            'field_type'    => 'select',
        ),
        array(
            'id'               => 'subscribe_form_single_post',
            'name'             => esc_html__( 'Choose Contact Form for Single Post Page', 'brooks' ),
            'type' => 'post',
            'multiple' => false,
            'post_type' => 'wpcf7_contact_form',
            'field_type'    => 'select',
        ),
        array(
            'id'               => 'subscribe_form_single_building',
            'name'             => esc_html__( 'Choose Contact Form for Building Page', 'brooks' ),
            'type' => 'post',
            'multiple' => false,
            'post_type' => 'wpcf7_contact_form',
            'field_type'    => 'select',
        ),
        array(
            'id'               => 'subscribe_form_single_portfolio',
            'name'             => esc_html__( 'Choose Contact Form for Portfolio Page', 'brooks' ),
            'type' => 'post',
            'multiple' => false,
            'post_type' => 'wpcf7_contact_form',
            'field_type'    => 'select',
        ),
        array(
            'id'               => 'subscribe_form_archive_post',
            'name'             => esc_html__( 'Choose Contact Form for Archive Page', 'brooks' ),
            'type' => 'post',
            'multiple' => false,
            'post_type' => 'wpcf7_contact_form',
            'field_type'    => 'select',
        ),
        array(
            'id'               => 'subscribe_form_search',
            'name'             => esc_html__( 'Choose Contact Form for Search Page', 'brooks' ),
            'type' => 'post',
            'multiple' => false,
            'post_type' => 'wpcf7_contact_form',
            'field_type'    => 'select',
        ),
        array(
            'id'               => 'subscribe_form_page_blog',
            'name'             => esc_html__( 'Choose Contact Form for Blog Page', 'brooks' ),
            'type' => 'post',
            'multiple' => false,
            'post_type' => 'wpcf7_contact_form',
            'field_type'    => 'select',
        ),
        array(
            'id'               => 'subscribe_form_shop',
            'name'             => esc_html__( 'Choose Contact Form for Shop Page', 'brooks' ),
            'type' => 'post',
            'multiple' => false,
            'post_type' => 'wpcf7_contact_form',
            'field_type'    => 'select',
        ),
        array(
            'id'               => 'subscribe_form_single_product',
            'name'             => esc_html__( 'Choose Contact Form for Product Page', 'brooks' ),
            'type' => 'post',
            'multiple' => false,
            'post_type' => 'wpcf7_contact_form',
            'field_type'    => 'select',
        ),

        array(
            'id'               => 'subscribe_form_archive_product',
            'name'             => esc_html__( 'Choose Contact Form for Shop Category Page', 'brooks' ),
            'type' => 'post',
            'multiple' => false,
            'post_type' => 'wpcf7_contact_form',
            'field_type'    => 'select',
        ),
        array(
            'type'  => 'divider'
        ),
        array(
            'id'               => 'subscribe_attach_img',
            'name'             => esc_html__( 'Background Image', 'brooks' ),
            'type'             => 'image_advanced',
            'max_file_uploads' => 1,
            'max_status'    =>  false,
            'tooltip'          => array(
                'icon'     => 'help',
                'content'  => esc_html__( 'Choose image for attachment block background, leave it empty for white background. text will change color to dark', 'brooks' ),
                'position' => 'bottom',
            )
        ),
        array(
            'id'               => 'subscribe_attach_bg_style',
            'name'             => esc_html__( 'Background Style', 'brooks' ),
            'type'             => 'select',
            'placeholder'      => esc_html__( 'None', 'brooks' ),
            'options' => array(
                'parallax' => esc_html__( 'Background Parallax', 'brooks' ),
                'scale' => esc_html__( 'Scale Effect', 'brooks' ),
            ),
        ),
        array(
            'id'               => 'subscribe_attach_bg_overlay',
            'name'             => esc_html__( 'Background Overlay', 'brooks' ),
            'type'             => 'select',
            'std'              => '',
            'options' => array(
                0   => esc_html__('None', 'brooks'),
                'light' => esc_html__( 'Light Overlay', 'brooks' ),
                'dark' => esc_html__( 'Dark Overlay', 'brooks' ),
                'theme' => esc_html__( 'Theme Color Overlay', 'brooks' ),
            ),
        ),
        array(
            'name' => esc_html__( 'Use Gradient Color?', 'brooks' ),
            'id'   => 'subscribe_attach_bg_color_grad',
            'visible' => array('shop_attach_bg_overlay', '!=', ''),
            'type' => 'checkbox',
        ),
        array(
            'name' => esc_html__('Title Text Color','brooks'),
            'id'   => 'subscribe_attach_color_text',
            'type' => 'color',
            'std'  => '#ffffff',
        ),
    )
);

$settingsData[] = array(
    'id'             => 'not_found',
    'title'          => esc_html__( 'Page Content', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'not_found',
    'fields' => array(
        array(
            'name'    => esc_html__( 'Page text', 'brooks' ),
            'desc'    =>  '',
            'id'      => 'not_found_text',
            'type'    => 'text',
            'std'     => esc_html__('THERE\'S NOTHING BUILD YET.', 'brooks')
        ),
    ),
);

$settingsData[] = array(
    'id'             => 'api',
    'title'          => esc_html__( 'Google API', 'brooks' ),
    'settings_pages' => 'theme-options',
    'tab'            => 'api',
    'fields' => array(
        array(
            'name'    => esc_html__( 'Browser Key', 'brooks' ),
            'desc'    => esc_html__( 'Key for browser applications like maps', 'brooks' ),
            'id'      => 'browser_key',
            'type'    => 'text',
        ),
    ),
);

new Brooks_Theme_Options($settingsTabs, $settingsData);