<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>

        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">

        <!-- mobile meta tag -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
        <script type="text/javascript">
		jQuery(document).ready(function(e) {
            jQuery(".product_cat-phone-case .brooks-selector input.select-dropdown").closest("ul li:first-child span").text("Select Case");
			jQuery(".product_cat-phone-case .brooks-selector input.select-dropdown").closest("select option:first-child").text("Select Case");
        });
		</script>
        
        <?php wp_head(); ?>
    </head>

<body <?php body_class(Brooks_Theme_Options::getData('menu_style')); ?>>

	<?php get_template_part( 'templates/template-part', 'header' ); ?>

    <div class="main__theme__wrap">
