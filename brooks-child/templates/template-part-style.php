<?php
$theme_color = $theme_custom_color ? $theme_custom_color : $theme_color;
?>
<style type="text/css">
    @charset "UTF-8";
    /* -------- TYPOGRAPHY ----- */
    <?php if(!empty($general_font)):?>
    body, p {
        font-family: "<?php echo $general_font['family']?>", sans-serif;
        font-weight: <?php echo !empty($general_font['style'])?str_replace('italic', '', $general_font['style']):'400';?>;
        font-style: <?php echo strpos($general_font['style'], 'italic')?'italic':'normal';?>;
    }
    <?php endif;?>

    <?php if(!empty($general_font_size)):?>
    body, p {
        font-size: <?php echo $general_font_size;?>px;
    }

    <?php for ($i = 1;$i <= 6;$i++):?>
    body .font-<?php echo str_replace('.', '_', $i / 2);?>x {
        font-size: <?php echo $i / 2 * $general_font_size;?>px;
    }
    .font-<?php echo str_replace('.', '_', $i / 2);?>x p {
        font-size: <?php echo $i / 2 * $general_font_size;?>px;
    }
    <?php endfor;?>

    <?php endif;?>


    <?php if(!empty($h1_font)):?>
    h1 {
        font-family: "<?php echo $h1_font['family']?>", sans-serif;
        font-weight: <?php echo !empty($h1_font['style'])?str_replace('italic', '', $h1_font['style']):'400';?>;
        font-style: <?php echo !empty($h1_font['style']) && strpos($h1_font['style'], 'italic')?'italic':'normal';?>;
    }
    <?php endif;?>

    <?php if(!empty($h1_font_size)):?>
    h1 {
        font-size: <?php echo $h1_font_size;?>px;
    }

    <?php for ($i = 1;$i <= 6;$i++):?>
    .font-<?php echo str_replace('.', '_', $i / 2);?>x h1 {
        font-size: <?php echo $i / 2 * $h1_font_size;?>px;
    }
    <?php endfor;?>

    <?php endif;?>

    <?php if(!empty($h2_font)):?>
    h2 {
        font-family: "<?php echo $h2_font['family']?>", sans-serif;
        font-weight: <?php echo !empty($h2_font['style'])?str_replace('italic', '', $h2_font['style']):'400';?>;
        font-style: <?php echo !empty($h2_font['style']) && strpos($h2_font['style'], 'italic')?'italic':'normal';?>;
    }
    <?php endif;?>

    <?php if(!empty($h2_font_size)):?>
    h2 {
        font-size: <?php echo $h2_font_size;?>px;
    }

    <?php for ($i = 1;$i <= 6;$i++):?>
    .font-<?php echo str_replace('.', '_', $i / 2);?>x h2 {
        font-size: <?php echo $i / 2 * $h2_font_size;?>px;
    }
    <?php endfor;?>

    <?php endif;?>

    <?php if(!empty($h3_font)):?>
    h3 {
        font-family: "<?php echo $h3_font['family']?>", sans-serif;
        font-weight: <?php echo !empty($h3_font['style'])?str_replace('italic', '', $h3_font['style']):'400';?>;
        font-style: <?php echo !empty($h3_font['style']) && strpos($h3_font['style'], 'italic')?'italic':'normal';?>;
    }
    <?php endif;?>

    <?php if(!empty($h3_font_size)):?>
    h3 {
        font-size: <?php echo $h3_font_size;?>px;
    }
    <?php for ($i = 1;$i <= 6;$i++):?>

    .font-<?php echo str_replace('.', '_', $i / 2);?>x h3 {
        font-size: <?php echo $i / 2 * $h3_font_size;?>px;
    }
    <?php endfor;?>

    <?php endif;?>

    <?php if(!empty($h4_font)):?>
    h4 {
        font-family: "<?php echo $h4_font['family']?>", sans-serif;
        font-weight: <?php echo !empty($h4_font['style'])?str_replace('italic', '', $h4_font['style']):'400';?>;
        font-style: <?php echo !empty($h4_font['style']) && strpos($h4_font['style'], 'italic')?'italic':'normal';?>;
    }
    <?php endif;?>
    <?php if(!empty($h4_font_size)):?>
    h4 {
        font-size: <?php echo $h4_font_size;?>px;
    }
    <?php for ($i = 1;$i <= 6;$i++):?>
    .font-<?php echo str_replace('.', '_', $i / 2);?>x h4 {
        font-size: <?php echo $i / 2 * $h4_font_size;?>px;
    }
    <?php endfor;?>

    <?php endif;?>

    <?php if(!empty($h5_font)):?>
    h5 {
        font-family: "<?php echo $h5_font['family']?>", sans-serif;
        font-weight: <?php echo !empty($h5_font['style'])?str_replace('italic', '', $h5_font['style']):'400';?>;
        font-style: <?php echo !empty($h5_font['style']) && strpos($h5_font['style'], 'italic')?'italic':'normal';?>;
    }
    <?php endif;?>
    <?php if(!empty($h5_font_size)):?>
    h5 {
        font-size: <?php echo $h5_font_size;?>px;
    }
    <?php for ($i = 1;$i <= 6;$i++):?>
    .font-<?php echo str_replace('.', '_', $i / 2);?>x h5 {
        font-size: <?php echo $i / 2 * $h5_font_size;?>px;
    }
    <?php endfor;?>

    <?php endif;?>

    <?php if(!empty($h6_font)):?>
    h6 {
        font-family: "<?php echo $h6_font['family']?>", sans-serif;
        font-weight: <?php echo !empty($h6_font['style'])?str_replace('italic', '', $h6_font['style']):'400';?>;
        font-style: <?php echo !empty($h6_font['style']) && strpos($h6_font['style'], 'italic')?'italic':'normal';?>;
    }
    <?php endif;?>
    <?php if(!empty($h6_font_size)):?>
    h6 {
        font-size: <?php echo $h6_font_size;?>px;
    }
    <?php for ($i = 1;$i <= 6;$i++):?>
    .font-<?php echo str_replace('.', '_', $i / 2);?>x h6 {
        font-size: <?php echo $i / 2 * $h6_font_size;?>px;
    }
    <?php endfor;?>

    <?php endif;?>




    /* -------- COLORS ----- */


    /* <?php echo $theme_color ?> */
    /* <?php echo brooks_rgba($theme_color, 0.45) ?> */
    /* <?php echo brooks_color_lighten( $theme_color, 20) ?> */

    body ::-moz-selection {
        background: <?php echo brooks_rgba($theme_color, 0.6) ?>
    }
    body ::selection {
        background: <?php echo brooks_rgba($theme_color, 0.6) ?>
    }

    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* main menu */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */

    /* logo height */

    <?php if(!empty($menu_font)):?>
    .main__menu .main__menu__navbar {
        font-family: "<?php echo $menu_font['family']?>", sans-serif;
        font-weight: <?php echo !empty($menu_font['style'])?str_replace('italic', '', $menu_font['style']):'400';?>;
        font-style: <?php echo strpos($menu_font['style'], 'italic')?'italic':'normal';?>;
    }
    .main__menu .main__menu__navbar li a,
    .main__menu .main__menu__navbar .dropdown__content li a {
        font-weight: <?php echo !empty($menu_font['style'])?str_replace('italic', '', $menu_font['style']):'400';?>;
        font-style: <?php echo strpos($menu_font['style'], 'italic')?'italic':'normal';?>;
    }
    <?php endif;?>

    <?php if(!empty($menu_font_size)):?>
    .main__menu .main__menu__navbar {
        font-size: <?php echo $menu_font_size;?>px;
    }
    .main__menu .main__menu__navbar li a,
    .main__menu .main__menu__navbar .dropdown__content li a {
        font-size: <?php echo $menu_font_size;?>px;
    }
    <?php endif;?>

    .main__menu .main__menu__navbar .dropdown__content li a {
        line-height: 1.4em;
    }


    .main__menu .main__menu__logo svg,
    .main__menu .main__menu__logo img,
    .main__menu .main-logo svg,
    .main__menu .main-logo img {
        height: <?php echo $logo_height ?>px;
    }

    .main__menu .main__menu__navbar {
        background-color: <?php echo $header_color ?>;
    }








    .main__menu .main__menu__navbar > li {
        color: <?php echo $header_text_color ?>;
    }

    .main__menu.-normal__menu.main__menu--scroll .main__menu__navbar > li,
    .main__menu.-normal__menu.main__menu--scroll .menu.menu__extra .menu__item > div > a i {
        color: <?php echo $header_text_color_scroll ?>;
    }

    /* active */
    .main__menu .main__menu__navbar > li a:before {
        background-color: <?php echo $header_text_color ?>
    }
    .main__menu .main__menu__navbar .dropdown__content > li a:before {
        background-color: <?php echo $header_dropdown_text_color ?>;
    }


    /* dropdown */
    .main__menu .main__menu__navbar li > .dropdown__content {
        background-color: <?php echo $header_dropdown_color ?>;
    }
    .main__menu .main__menu__navbar .dropdown__content li {
        color: <?php echo $header_dropdown_text_color ?>;
    }

    .open__menu__btn span {
        background-color: <?php echo $header_text_color ?>;
    }

    @media (min-width: 1025px) {


        .main__menu.-normal__menu,
        .main__menu.-center__logo__menu,
        .main__menu.-aside__menu.main__menu .main__menu__inner__wrap .main__menu__wrap,
        .main__menu.-aside__menu.main__menu{
            background-color: <?php echo $header_general_color ?>;
        }
        .main__menu.-aside__menu [class*="depth"]:after,
        .main__menu.-aside__menu [class*="depth"]:before{
            background: <?php echo $header_text_color ?>;
        }
        /* menu scroll */
        .main__menu.-normal__menu.main__menu--scroll,
        .main__menu.-center__logo__menu.main__menu--scroll {
            background-color: <?php echo $header_color_scroll ?> ;
        }
        .main__menu.-normal__menu.main__menu--scroll .menu.menu__extra .menu__item__shop > a .shopping-cart-items-count,
        .main__menu.-center__logo__menu.main__menu--scroll .menu.menu__extra .menu__item__shop > a .shopping-cart-items-count {
            color: <?php echo $header_text_color_scroll ?>;
            border-color: <?php echo $header_text_color_scroll ?>;
        }
        .main__menu.-normal__menu.main__menu--scroll  .main__menu__navbar > li a:before,
        .main__menu.-center__logo__menu.main__menu--scroll  .main__menu__navbar > li a:before {
            background-color: <?php echo $header_text_color_scroll ?>;
        }
        .main__header .-aside__menu.--menu__list__fullscreen.-menu_is_open,
        .main__header .main__menu.-aside__menu.--menu__list__fullscreen.-menu_is_open .main__menu__wrap{
            background-color: <?php echo $header_general_color_aside_opened ?>;
        }

        /* offset */
        .main__menu.-normal__menu,
        .main__menu.-center__logo__menu {
            -webkit-transform: translate(0, <?php echo $top_offset ?>px );
            -moz-transform: translate(0, <?php echo $top_offset ?>px );
            -ms-transform: translate(0, <?php echo $top_offset ?>px );
            -o-transform: translate(0, <?php echo $top_offset ?>px );
            transform: translate(0, <?php echo $top_offset ?>px );
        }
        /* offset  scroll */
        .main__menu.-normal__menu.main__menu--scroll ,
        .main__menu.-center__logo__menu.main__menu--scroll {
            -webkit-transform: translate(0, <?php echo $top_offset_scrolled ?>px );
            -moz-transform: translate(0, <?php echo $top_offset_scrolled ?>px );
            -ms-transform: translate(0, <?php echo $top_offset_scrolled ?>px );
            -o-transform: translate(0, <?php echo $top_offset_scrolled ?>px );
            transform: translate(0, <?php echo $top_offset_scrolled ?>px );
        }


        .main__menu.-normal__menu .main__menu__navbar>li.brooks__wide>.dropdown__content>li,
        .main__menu.-center__logo__menu .main__menu__navbar>li.brooks__wide>.dropdown__content>li,
        .main__menu.-side__bar__menu__left.main__menu--outside__dropdown .main__menu__navbar>li.brooks__wide>.dropdown__content>li,
        .main__menu.-side__bar__menu__right.main__menu--outside__dropdown .main__menu__navbar>li.brooks__wide>.dropdown__content>li {
            border-color: <?php echo brooks_rgba($header_dropdown_text_color, 0.3) ?>;
        }
    }



    /* extra menu */
    .main__menu .menu.menu__extra .menu__item h4,
    .main__menu .menu.menu__extra .menu__item .textwidget {
        color: <?php echo $header_text_color_scroll ?>;
    }
    .main__menu .menu.menu__extra .menu__item .input-field input:not([type]),
    .main__menu .menu.menu__extra .menu__item .input-field input[type=text],
    .main__menu .menu.menu__extra .menu__item .input-field input[type=password],
    .main__menu .menu.menu__extra .menu__item .input-field input[type=email],
    .main__menu .menu.menu__extra .menu__item .input-field input[type=url],
    .main__menu .menu.menu__extra .menu__item .input-field input[type=time],
    .main__menu .menu.menu__extra .menu__item .input-field input[type=date],
    .main__menu .menu.menu__extra .menu__item .input-field input[type=datetime-local],
    .main__menu .menu.menu__extra .menu__item .input-field input[type=tel],
    .main__menu .menu.menu__extra .menu__item .input-field input[type=number],
    .main__menu .menu.menu__extra .menu__item .input-field input[type=search],
    .main__menu .menu.menu__extra .menu__item .input-field textarea.materialize-textarea {
        border-color: <?php echo $header_text_color_scroll ?>;
    }
    .main__menu .menu.menu__extra .menu__item .input-field label {
        color: <?php echo $header_text_color_scroll ?>;
    }
    .main__menu .menu.menu__extra .menu__item .tagcloud a,
    .main__menu .menu.menu__extra .menu__item ul li.recentcomments {
        color: <?php echo $header_text_color_scroll ?>;
        border-color: <?php echo $header_text_color_scroll ?>;
    }





    .menu__badge {
        color: <?php echo $header_dropdown_color ?>;
        background-color: <?php echo $header_dropdown_text_color ?>;
    }

    /* menu widget styles */
    .main__menu .menu.menu__extra {
        background-color: <?php echo $header_color ?>;
    }
    .main__menu .menu.menu__extra .menu__item > div > a i {
        color: <?php echo $header_text_color ?>;
    }

    /* menu cart styles */
    .main__menu .menu.menu__extra .menu__item__shop > a .shopping-cart-items-count {
        color: <?php echo $header_text_color ?>;
        border-color: <?php echo $header_text_color ?>;
    }
    .main__menu .menu.menu__extra .menu__item__shop .submenu .mini_cart_item .quantity {
        color: <?php echo $theme_color ?>;
    }
    .main__menu .menu.menu__extra .menu__item__shop .submenu .mini_cart_item .remove {
        color: <?php echo $theme_color ?>;
    }
    .main__menu .menu.menu__extra .menu__item__shop .submenu .total span {
        color: <?php echo $theme_color ?>;
    }


    /* aside menu left and right */
    @media (min-width: 1025px) {
        .main__menu.-side__bar__menu__left .main__menu__wrap,
        .main__menu.-side__bar__menu__right .main__menu__wrap {
            background-color: <?php echo preg_replace('#[.0-9]+\)#', '1)', $header_color) ?>;
        }
        .main__menu.-side__bar__menu__left.main__menu--expand__dropdown .menu__badge,
        .main__menu.-side__bar__menu__right.main__menu--expand__dropdown .menu__badge {
            color: <?php echo preg_replace('#[.0-9]+\)#', '1)', $header_color) ?>;
        }
    }


    /* RESPONSIVE mobile menu */
    @media (max-width: 1024px) {

        /* header background color */
        .main__menu {
            background-color: <?php echo preg_replace('#[.0-9]+\)#', '1)', $header_color_scroll) ?>;
        }

        /* burger btn color */
        .main__menu .open__menu__btn span {
            background-color: <?php echo $header_text_color_scroll ?> ;
        }

        /* bage color */
        .main__menu .menu__badge {
            color: <?php echo preg_replace('#[.0-9]+\)#', '1)', $header_dropdown_color) ?>;
            background-color: <?php echo $header_dropdown_text_color ?>;
        }

        /* active item color */
        .main__menu .main__menu__inner__wrap .main__menu__wrap .main__menu__navbar > li a:before,
        .main__menu .main__menu__inner__wrap .main__menu__wrap .main__menu__navbar .dropdown__content > li a:before {
            background-color: <?php echo $header_dropdown_text_color ?>;
        }
        
        /* menu bakground */
        .main__menu .main__menu__inner__wrap .main__menu__wrap {
            background-color: <?php echo preg_replace('#[.0-9]+\)#', '1)', $header_dropdown_color) ?> ;
        }
        /* links color */
        .main__menu .main__menu__inner__wrap .main__menu__wrap .main__menu__navbar > li,
        .main__menu .main__menu__inner__wrap .main__menu__wrap .main__menu__navbar li .dropdown__content li {
            color: <?php echo $header_dropdown_text_color ?>;
        }



        /* menu widgets */
        .main__menu .main__menu__inner__wrap .main__menu__wrap .menu.menu__extra .menu__item > div > a i {
            color: <?php echo $header_dropdown_text_color ?>;
        }
        .main__menu .main__menu__inner__wrap .main__menu__wrap .menu.menu__extra .menu__item__shop > a .shopping-cart-items-count {
            color: <?php echo $header_dropdown_text_color ?>;
            border-color: <?php echo $header_dropdown_text_color ?>;
        }
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */


    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */





    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* layouts */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .preloader__wrap__item svg polygon {
        fill: <?php echo brooks_rgba($theme_color, 0.8) ?> ;
    }

    .theme__section .theme__section__overlay.-overlay_theme {
        background-color: <?php echo $theme_color ?>;
    }
    .theme__section .theme__section__overlay.-overlay_theme.-pattern {
        background-color: <?php echo $theme_color ?>;
        background-image: -webkit-repeating-radial-gradient(center center, <?php echo $theme_color ?>, <?php echo $theme_color ?> 1px, transparent 1px, transparent 100%);
        background-image: -moz-repeating-radial-gradient(center center, <?php echo $theme_color ?>, <?php echo $theme_color ?> 1px, transparent 1px, transparent 100%);
        background-image: -ms-repeating-radial-gradient(center center, <?php echo $theme_color ?>, <?php echo $theme_color ?> 1px, transparent 1px, transparent 100%);
        background-image: repeating-radial-gradient(center center, <?php echo $theme_color ?>, <?php echo $theme_color ?> 1px, transparent 1px, transparent 100%);
    }

    blockquote {
        color:<?php echo $theme_color ?>;
    }
    pre {
        border-left-color: <?php echo $theme_color ?>;
    }

    .title__underline:after {
        background-color: <?php echo $theme_color ?>;
    }

    .line__md:after {
        background-color: <?php echo $theme_color ?>;
    }

    .theme__subscribe__section h2 {
        color: <?php echo $subscribe_attach_color_text ?>;
    }

    /*.theme__subscribe__section h2:after {
        background-color: <?php echo $subscribe_attach_color_text ?>;
    }*/


    .theme__like__post i {
        color:<?php echo $theme_color ?>;
    }

    .blog__item__share i {
        color: <?php echo $theme_color ?>;
    }

    #wp-calendar #today {
        color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */


    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* preloader */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .circle-clipper .circle {
        border-color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */

    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* progress par */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .progress .indeterminate {
        background-color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */


    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* forms */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .wpcf7-form .theme__form__box__style {
        border-right:1px solid <?php echo $theme_color ?>;
    }
    input:not([type]):focus:not([readonly]),
    input[type=text]:focus:not([readonly]),
    input[type=password]:focus:not([readonly]),
    input[type=email]:focus:not([readonly]),
    input[type=url]:focus:not([readonly]),
    input[type=time]:focus:not([readonly]),
    input[type=date]:focus:not([readonly]),
    input[type=datetime-local]:focus:not([readonly]),
    input[type=tel]:focus:not([readonly]),
    input[type=number]:focus:not([readonly]),
    input[type=search]:focus:not([readonly]),
    textarea.materialize-textarea:focus:not([readonly]) {
        border-bottom: 1px solid <?php echo $theme_color ?> !important;
        box-shadow: 0 1px 0 0 <?php echo $theme_color ?> !important;
    }
    input:not([type]):focus:not([readonly]) + label,
    input[type=text]:focus:not([readonly]) + label,
    input[type=password]:focus:not([readonly]) + label,
    input[type=email]:focus:not([readonly]) + label,
    input[type=url]:focus:not([readonly]) + label,
    input[type=time]:focus:not([readonly]) + label,
    input[type=date]:focus:not([readonly]) + label,
    input[type=datetime-local]:focus:not([readonly]) + label,
    input[type=tel]:focus:not([readonly]) + label,
    input[type=number]:focus:not([readonly]) + label,
    input[type=search]:focus:not([readonly]) + label,
    textarea.materialize-textarea:focus:not([readonly]) + label {
        color: <?php echo $theme_color ?> !important;
    }
    [type="radio"]:checked + label:after {
        border: 2px solid <?php echo $theme_color ?>;
        background-color: <?php echo $theme_color ?>;
    }
    [type="radio"]:not(:checked) + label:before {
        border: 2px solid <?php echo $theme_color ?>;
    }
    .select-wrapper span.caret {
        border-right: 1px solid <?php echo $theme_color ?>;
        border-bottom: 1px solid <?php echo $theme_color ?>;
    }

    [type="checkbox"] + label:before {
        border: 2px solid <?php echo $theme_color ?>;
    }
    [type="checkbox"]:checked + label:before {
        border-right: 2px solid <?php echo $theme_color ?>;
        border-bottom: 2px solid <?php echo $theme_color ?>;
    }

    .picker__weekday-display {
        background-color: <?php echo $theme_color ?>;
    }
    .picker__select--month:focus,
    .picker__select--year:focus {
        border-color: <?php echo $theme_color ?>;
    }
    .picker__date-display {
        background-color: <?php echo $theme_color ?>;
    }
    .picker__day.picker__day--today {
        color: <?php echo $theme_color ?>;
    }
    .picker__day--selected,
    .picker__day--selected:hover,
    .picker--focused .picker__day--selected {
        background-color: <?php echo $theme_color ?>;
    }
    .picker__nav--next:hover:before {
        border-left-color: <?php echo $theme_color ?>;
    }
    .picker__nav--prev:hover:before {
        border-right-color: <?php echo $theme_color ?>;
    }
    .picker__clear, .picker__close, .picker__today {
        color: <?php echo $theme_color ?>;

    }
    button.picker__today:hover,
    button.picker__today:focus,
    button.picker__clear:hover,
    button.picker__clear:focus,
    button.picker__close:hover,
    button.picker__close:focus {
        background-color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */


    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* buttons */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .btn-color {
        color: #fff;
        border-color: <?php echo $theme_color ?>;
        background-color: <?php echo $theme_color ?>;
    }
    .btn-color:hover,
    .btn-color:focus,
    .btn-color.active,
    .btn-color.active.focus,
    .btn-color.active:focus,
    .btn-color.active:hover,
    .btn-color:active,
    .btn-color:active.focus,
    .btn-color:active:focus,
    .btn-color:active:hover {
        color: <?php echo $theme_color ?>;
        background-color: transparent;
    }

    .btn-color.btn-inverse {
        color: <?php echo $theme_color ?>;
        background: transparent;
        border-color: <?php echo $theme_color ?>;
    }

    .btn-color.btn-inverse:hover,
    .btn-color.btn-inverse:focus,
    .btn-color.btn-inverse.active,
    .btn-color.btn-inverse.active.focus,
    .btn-color.btn-inverse.active:focus,
    .btn-color.btn-inverse.active:hover,
    .btn-color.btn-inverse:active,
    .btn-color.btn-inverse:active.focus,
    .btn-color.btn-inverse:active:focus,
    .btn-color.btn-inverse:active:hover {
        color: #fff;
        border-color: <?php echo $theme_color ?>;
        background-color: <?php echo $theme_color ?>;
    }

    .btn-color[disabled],
    .btn-color.btn-disabled {
        border-color: <?php echo $theme_color ?> !important;
        background-color: <?php echo $theme_color ?> !important;
    }

    .btn-white {
        color: <?php echo $theme_color ?>;
        background-color: #fff;
        border-color: #fff;
    }
    .btn-white:hover,
    .btn-white:focus,
    .btn-white.active,
    .btn-white.active.focus,
    .btn-white.active:focus,
    .btn-white.active:hover,
    .btn-white:active,
    .btn-white:active.focus,
    .btn-white:active:focus,
    .btn-white:active:hover {
        color: #fff;
        background-color: transparent;
        border-color: #fff;
    }

    .btn-white.btn-inverse {
        color: #fff;
        background: transparent;
    }
    .btn-white.btn-inverse:hover,
    .btn-white.btn-inverse:focus,
    .btn-white.btn-inverse.active,
    .btn-white.btn-inverse.active.focus,
    .btn-white.btn-inverse.active:focus,
    .btn-white.btn-inverse.active:hover,
    .btn-white.btn-inverse:active,
    .btn-white.btn-inverse:active.focus,
    .btn-white.btn-inverse:active:focus,
    .btn-white.btn-inverse:active:hover {
        color: <?php echo $theme_color ?>;
        background-color: #fff;
        border-color: #fff;
    }
    .btn-white[disabled],
    .btn-white.btn-disabled {
        color: <?php echo $theme_color ?> !important;
    }

    .btn-white .waves-ripple {
        background-color: <?php echo brooks_rgba($theme_color, 0.45) ?> !important;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */






    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* portfolio */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* portfolio__item__standard */
    @media (max-width: 1024px) {
        .portfolio__grid__item.portfolio__item__standard .portfolio__standard__cover .content__holder .theme__like__post i {
            color: <?php echo $theme_color ?>;
        }
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */

    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* customers */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .customers__container .customers__tab__list__item:hover .customers__tab__list__item-in,
    .customers__container .customers__tab__list__item.slick-current .customers__tab__list__item-in {
        border-color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */


    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* rent */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .rent__list .rent__list__item .input-field {
        border-right: 1px solid <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */




    /* SHOP */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .star-rating:before,
    .star-rating span:before {
        color: <?php echo $theme_color ?>;
    }
    div.product .new,
    div.product .onsale {
        background-color: <?php echo $theme_color ?>;
    }
    .theme__product__item .new,
    .theme__product__item .onsale {
        background-color: <?php echo $theme_color ?>;
    }
    div.product div.images .slick-container-for .slick-slide:after {
        background-color: <?php echo $theme_color ?>;
    }
    .upsells h2:after,
    .related h2:after {
        background-color: <?php echo $theme_color ?>;
    }
    .wishlist-title h2:after {
        background-color: <?php echo $theme_color ?>;
    }
    div.product #reviews .comment-reply-title:after {
        background-color: <?php echo $theme_color ?>;
    }

    .woocommerce p.stars a {
        color: <?php echo $theme_color ?>;
    }
    .woocommerce-breadcrumb a{
        color: <?php echo $shop_attach_color_text ?>;
    }
    .woocommerce-breadcrumb{
        color: <?php echo $shop_attach_color_text ?>;
    }
    .quantity-buttons .quantity-minus,
    .quantity-buttons .quantity-plus {
        border-color: <?php echo $theme_color ?>;
    }
    @media (max-width: 767px) {
        .cart.shop_table .quantity-buttons .qty {
            border-color: <?php echo $theme_color ?>;
        }
    }
    .quantity-buttons .quantity-minus:after {
        background-color: <?php echo $theme_color ?>;
    }
    .quantity-buttons .quantity-plus:before,
    .quantity-buttons .quantity-plus:after {
        background-color: <?php echo $theme_color ?>;
    }


    div.product div.single-product-summary .single_add_to_cart_button {
        color: #fff;
        border: 1px solid <?php echo $theme_color ?>;
        background-color: <?php echo $theme_color ?>;
    }
    div.product div.single-product-summary .single_add_to_cart_button:hover {
        color: <?php echo $theme_color ?>;
        border-color: <?php echo $theme_color ?>;
        background-color: #fff;
    }

    .theme__product__item .product-info-holder .product-info-upper-button .yith-wcwl-add-to-wishlist a:hover {
        color: <?php echo $theme_color ?>;
        background-color: #fff;
    }

    .theme__product__item .product-info-holder .product-info-upper-button .button,
    .theme__product__item .product-info-holder .product-info-upper-button .added_to_cart {
        background-color: <?php echo $theme_color ?>;
        border-color: <?php echo $theme_color ?>;
        color: #fff;
    }

    .theme__product__item .product-info-holder .product-info-upper-button .button:hover,
    .theme__product__item .product-info-holder .product-info-upper-button .added_to_cart:hover {
        background-color: #fff;
        border-color: #fff;
        color: <?php echo $theme_color ?>;
    }

    .details__out .details__cart .button,
    .details__out .details__cart .added_to_cart {
        background-color: <?php echo $theme_color ?>;
        border-color: <?php echo $theme_color ?>;
        color: #fff;
    }
    .details__out .details__cart .button:hover,
    .details__out .details__cart .added_to_cart:hover {
        background-color: #fff;
        border-color: <?php echo $theme_color ?>;
        color: <?php echo $theme_color ?>;
    }

    .theme__product__item--list .product-info-holder .product-info-upper-button .added_to_cart,
    .theme__product__item--list .product-info-holder .product-info-upper-button .ajax_add_to_cart,
    .theme__product__item--list .product-info-holder .product-info-upper-button .add_to_cart_button,
    .theme__product__item--list .product-info-holder .product-info-upper-button .product_type_grouped,
    .theme__product__item--list .product-info-holder .product-info-upper-button .product_type_variable  {
        border-color: <?php echo $theme_color ?>;
        background-color: <?php echo $theme_color ?>;
        color: #fff;
    }
    .theme__product__item--list .product-info-holder .product-info-upper-button .added_to_cart:hover,
    .theme__product__item--list .product-info-holder .product-info-upper-button .ajax_add_to_cart:hover,
    .theme__product__item--list .product-info-holder .product-info-upper-button .add_to_cart_button:hover,
    .theme__product__item--list .product-info-holder .product-info-upper-button .product_type_grouped:hover,
    .theme__product__item--list .product-info-holder .product-info-upper-button .product_type_variable:hover  {
        color: <?php echo $theme_color ?>;
        border-color: <?php echo $theme_color ?>;
        background-color: #fff;
    }
    .theme__product__item--list .product-info-holder .star-rating:before,
    .theme__product__item--list .product-info-holder .star-rating span:before {
        color: <?php echo $theme_color ?>;
    }


    form.woocommerce-checkout h3 {
        color: <?php echo $theme_color ?>;
    }
    .woocommerce-shipping-fields h3 label.checkbox {
        color: <?php echo $theme_color ?>;
    }
    .woocommerce-info a:not(.button),
    .woocommerce-error a:not(.button),
    .woocommerce-message a:not(.button) {
        color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */



    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* blog page */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .single__post__meta .author__meta .author__name,
    .single__post__meta .author__meta .author__name a {
        color: <?php echo $theme_color ?>;
    }
    .comments .comments__list li .comments__list__inner .comments__list__head .user__info .comments__autor__name {
        color: <?php echo $theme_color ?>;
    }
    .comments .comments__list li .comments__list__inner .comments__list__head .comment-reply-link {
        background-color: <?php echo $theme_color ?>;
    }
    .blog__list__standart .blog__article__list__item.blog__article__quote__post .blog__item__icon i {
        color: <?php echo $theme_color ?>;
    }

    .blog__list__standart .blog__item__title:before {
        background-color: <?php echo $theme_color ?>;
    }

    .blog__list__standart .blog__article__list__item.-no__image .blog__article__list__item__wrap header .blog__item__title:before,
    .blog__list__standart .blog__article__list__item.blog__article__list__slider__post .blog__article__list__item__wrap header .blog__item__title:before {
        background-color: <?php echo $theme_color ?>;
    }
    .blog__list__standart .blog__article__list__item.blog__article__audio__post.-no__image .blog__item__title.embeded__audio:after {
        background-color: <?php echo $theme_color ?>;
    }


    .blog__list__standart .blog__article__list__item.-no__image .blog__article__list__item__wrap header .blog__item__share .see__post i,
    .blog__list__standart .blog__article__list__item.-no__image .blog__article__list__item__wrap header .blog__item__share .like__post i,
    .blog__list__standart .blog__article__list__item.blog__article__list__slider__post .blog__article__list__item__wrap header .blog__item__share .see__post i,
    .blog__list__standart .blog__article__list__item.blog__article__list__slider__post .blog__article__list__item__wrap header .blog__item__share .like__post i {
        color:<?php echo $theme_color ?>;
    }
    .blog__list__standart .blog__article__list__item.-no__image .blog__article__list__item__wrap header .blog__item__icon,
    .blog__list__standart .blog__article__list__item.blog__article__list__slider__post .blog__article__list__item__wrap header .blog__item__icon {
        color: <?php echo $theme_color ?>;
    }

    .blog__list__standart .blog__article__list__item.blog__article__audio__post .play__btn:hover:before {
        border-left-color: <?php echo $theme_color ?>;
    }
    .blog__list__standart .blog__article__list__item.blog__article__audio__post .-is_play .play__btn:hover:before {
        border-top-color: <?php echo $theme_color ?>;
        border-left-color: <?php echo $theme_color ?>;
        border-bottom-color: <?php echo $theme_color ?>;
    }
    .blog__list__standart .blog__article__list__item.blog__article__audio__post .-is_play .play__btn:hover:after {
        background-color: <?php echo $theme_color ?>;
    }
    .blog__list__standart .blog__article__list__item.blog__article__audio__post .blog__item__title .load__bar {
        background-color: <?php echo brooks_rgba($theme_color, 0.5) ?>;
    }
    .blog__list__standart .blog__article__list__item.blog__article__audio__post .volume__btn {
        border: 1px solid <?php echo $theme_color ?>;
        background-color: <?php echo $theme_color ?>;
    }

    .theme__audio__block .play__btn:hover:before {
        border-left-color: <?php echo $theme_color ?>;
    }
    .theme__audio__block.-is_play .play__btn:hover:before {
        border-top-color: <?php echo $theme_color ?>;
        border-left-color: <?php echo $theme_color ?>;
        border-bottom-color: <?php echo $theme_color ?>;
    }
    .theme__audio__block.-is_play .play__btn:hover:after {
        background-color: <?php echo $theme_color ?>;
    }
    .theme__audio__block .volume__btn {
        border: 1px solid <?php echo $theme_color ?>;
        background-color: <?php echo $theme_color ?>;
    }
    .theme__audio__block .load__bar_wrap {
        background-color: <?php echo brooks_rgba($theme_color, 0.5) ?>;
    }
    .theme__audio__block .load__bar_wrap .load__bar {
        background-color: <?php echo $theme_color ?>;
    }
    .audio__post .blog__grid__item__wrap__inner .load__bar .load__bar__line {
        background-color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */



    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* build page */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .build__section .build__addres i.icon {
        color: <?php echo $theme_color ?>;
    }
    .build__icon .build__icon__value {
        color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */



    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* pricing  */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* theme pricing */
    .theme__pricing__item__title__price {
        background-color: <?php echo $theme_color ?>;
    }
    .theme__pricing__item__wrap ol li:after,
    .theme__pricing__item__wrap ul li:after {
        background-color: <?php echo $theme_color ?>;
    }

    /* bilding pricing */
    .pricing__item .pricing__item__wrap h3 {
        color: <?php echo $theme_color ?>;
    }
    .pricing__item.-popular_pricing:after {
        background-color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */



    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /*  theme widget */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .theme__widget .price_slider_wrapper .price_slider .ui-slider-range {
        background-color: <?php echo $theme_color ?>;
    }
    .theme__widget .price_slider_wrapper .price_slider_amount .button {
        border-color: <?php echo $theme_color ?>;
        background-color: <?php echo $theme_color ?>;
    }
    .theme__widget .price_slider_wrapper .price_slider_amount .button:hover {
        color: <?php echo $theme_color ?>;
        background-color: #fff;
    }

    .theme__widget ul:not(.product_list_widget) li:hover > a,
    .theme__widget ul:not(.product_list_widget) li.active > a {
        color: <?php echo $theme_color ?>;
        border-color: <?php echo $theme_color ?>;
    }
    .theme__widget .social__widget a:hover {
        color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */


    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* pagination */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .pagination > a,
    .pagination > span {
        color: <?php echo $theme_color ?>;
        border-color: <?php echo $theme_color ?>;
        background-color: #fff;
    }
    .pagination > span,
    .pagination a:hover {
        color: #fff;
        background-color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */



    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* theme__share-module */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .theme__share-module .share-in {
        color: <?php echo $theme_color ?>;
    }
    .theme__share-module .share-links li a {
        color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */



    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* map  */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .simple-marker i {
        color: <?php echo $theme_color ?>;
    }
    .cluster,
    .simple-marker {
        color: <?php echo $theme_color ?> !important;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12), 0 0 0 2px <?php echo $theme_color ?> inset;
    }
    .cluster:hover,
    .simple-marker:hover {
        color: <?php echo $theme_color ?> !important;
        box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.15), 0 0 0 0px <?php echo $theme_color ?> inset;
    }
    .theme__map__infobox.-simple__infobox h6 {
        background-color: <?php echo $theme_color ?>;
    }
    .theme__map__infobox.-post__infobox .infobox__inner .infobox__cover {
        background-color: <?php echo brooks_rgba($theme_color, 0.9) ?> ;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */


    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    .woocommerce-MyAccount-content a {
        color: <?php echo $theme_color ?>;
    }
    .woocommerce-MyAccount-content .woocommerce-EditAccountForm .button {
        color: #fff;
        background-color: <?php echo $theme_color ?>;
        border-color: <?php echo $theme_color ?>;
    }
    .woocommerce-MyAccount-content .woocommerce-EditAccountForm .button:hover {
        color: <?php echo $theme_color ?>;
        background-color: #fff;
        border-color: <?php echo $theme_color ?>;
    }
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */

    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */
    /* FOOTER */
    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */


    footer.main__footer {
        background-color: <?php echo $footer_bg_color ?>;
    }

    footer.main__footer .footer__col .theme__widget:first-child h4:after {
        background-color: <?php echo $theme_color ?>;
    }

    <?php if (!empty($footer_text_underline_color)) :  ?>
    footer.main__footer .footer__col .theme__widget:first-child h4:after {
        background-color: <?php echo $footer_text_color ?> ;
    }
    <?php endif; ?>

    footer.main__footer .footer__col {
        color: <?php echo $footer_text_color?> ;
    }
    footer.main__footer .tagcloud a {
        color: <?php echo $footer_text_color?> ;
        border-color: <?php echo $footer_text_color?>;
    }
    footer.main__footer .tagcloud a:hover {
        color: <?php echo $footer_bg_color?>;
        border-color: <?php echo $footer_text_color?> ;
        background-color: <?php echo $footer_text_color?> ;
    }
    footer.main__footer .select-wrapper,
    footer.main__footer input:not([type]),
    footer.main__footer input[type=text],
    footer.main__footer input[type=password],
    footer.main__footer input[type=email],
    footer.main__footer input[type=url],
    footer.main__footer input[type=time],
    footer.main__footer input[type=date],
    footer.main__footer input[type=datetime-local],
    footer.main__footer input[type=tel],
    footer.main__footer input[type=number],
    footer.main__footer input[type=search],
    footer.main__footer textarea.materialize-textarea {
        border-color: <?php echo $footer_text_color?>;
    }

    footer.main__footer [type="radio"]:not(:checked) + label:before {
        border: 2px solid <?php echo $footer_text_color?>;
    }
    footer.main__footer [type="radio"]:checked + label:after {
        border: 2px solid <?php echo $footer_text_color?>;
        background-color: <?php echo $footer_text_color?>;
    }

    footer.main__footer .select-wrapper span.caret {
        border-right: 1px solid <?php echo $footer_text_color?>;
        border-bottom: 1px solid <?php echo $footer_text_color?>;
    }
    footer.main__footer .footer__col .theme__widget ul:not(.product_list_widget) li a {
        border-color: <?php echo $footer_text_color?>;
    }




    footer.main__footer .footer__copyright {
        background-color: <?php echo $footer_bottom_bg_color?> ;
        color: <?php echo $footer_bottom_text_color ?>;
    }
    footer.main__footer .footer__copyright .theme__widget {
        color: <?php echo $footer_bottom_text_color ?>;
    }
    .theme__map__infobox {
        color: black;
    }
    .blog__main .text-white{
        color: <?php echo $blog_other_color_text ?> !important;
    }

    /* ---------------- ---------------- ---------------- ---------------- ---------------- ---------------- */


</style>
