<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>

        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">

        <!-- mobile meta tag -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/ui-css/jquery-ui.css" type="text/css">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/ui-css/jquery-ui.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/ui-css/jquery-ui.structure.css" type="text/css">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/ui-css/jquery-ui.structure.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/ui-css/jquery-ui.theme.css" type="text/css">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/ui-css/jquery-ui.theme.min.css" type="text/css">

        <?php wp_head(); ?>
    </head>

<body <?php body_class(Brooks_Theme_Options::getData('menu_style')); ?>>

	<?php get_template_part( 'templates/template-part', 'header' ); ?>

    <div class="main__theme__wrap">
