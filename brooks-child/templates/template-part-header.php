<!-- preloader -->
<?php brooks_enqueue_custom('loader'); ?>

<?php if(Brooks_Theme_Options::getData('enable_preloader')): ?>

    <?php get_template_part( 'templates/template-part', 'preloader' ); ?>

<?php endif; ?>
<!-- preloader end -->

<?php brooks_enqueue_custom('data-actions');?>

<?php
$logo_src = (Brooks_Theme_Options::getData('logo')?wp_get_attachment_image_url(Brooks_Theme_Options::getData('logo', true), 'full'):BROOKS_IMAGES.'/logo.png');
$classes = array(
    '-' . Brooks_Theme_Options::getData('menu_style'),
    'main__menu--' . Brooks_Theme_Options::getData('menu_width'),
    'main__menu--' . Brooks_Theme_Options::getData('menu_scroll'),
    '--menu__list__fullscreen',
    'main__menu--outside__dropdown',
    '--' . Brooks_Theme_Options::getData('header_align'),
    '--' . Brooks_Theme_Options::getData('menu_align'),
    '--' . Brooks_Theme_Options::getData('logo_align')
);
?>

<div id="top_header">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-lg-12 float_left">
        <ul class="top_header_ul">
         <li class="email_top_header"> <a class="fb" href="mailto:geral@sextafeira.pt"> <i class="fa fa-envelope" aria-hidden="true"></i>
            geral@sextafeira.pt </a> </li>
           <li class="contact_top_header last-child"> <a class="fb" href="tel:+351 234 607 520"> <i class="fa fa-mobile" aria-hidden="true"></i>
            +351 234 607 520 </a> </li> 
                  </ul>
      </div>
    </div>
  </div>
</div>
<header class="main__header">
    <!-- main menu -->
    <nav class="main__menu <?php echo implode(' ', $classes);?>">
        <div class="main__menu__inner__wrap">
            <a class="main__menu__logo main__menu__inner" href="<?php echo esc_url( home_url('/') ); ?>">
                <img src="<?php echo $logo_src; ?>" alt="<?php bloginfo( 'name' ) ?>">
                <?php if(Brooks_Theme_Options::getData('alt_logo'))
                    $logo_src = wp_get_attachment_image_url(Brooks_Theme_Options::getData('alt_logo', true), 'full');
                ?>
                <img class="alt__logo" src="<?php echo $logo_src; ?>" alt="<?php bloginfo( 'name' ) ?>">
            </a>
            <?php if(Brooks_Theme_Options::getData('menu_style') == 'aside__menu' && Brooks_Theme_Options::getData('menu_appearance') != 'menu__list__fade' && Brooks_Theme_Options::getData('secondary_menu') ):?>
            <div class="main__menu__inner secondary__menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'secondary_menu',
                    'menu_id' => 'secondary-menu-nav',
                    'menu_class' => 'secondary__menu__navbar',
                    'sort_column' => 'menu_order',
                    'container' => false,
                    'fallback_cb' => '',
                    'walker' => new Brooks_Walker_Nav_Menu()
                ));
                ?>
            </div>
            <?php endif;?>
            <div class="open__menu__btn--wrapper">
                <div class="open__menu__btn main__menu__inner" data-toggle="class" data-class="-menu_is_open" data-target=".main__menu, .main__theme__wrap" data-target-class="-menu_is_open">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="main__menu__wrap main__menu__inner">
                <?php if(Brooks_Theme_Options::getData('menu_style') == 'side__bar__menu__left' || Brooks_Theme_Options::getData('menu_style') == 'side__bar__menu__right'):?>
                    <a class="main__menu__logo main__menu__inner" href="<?php echo esc_url( home_url('/') ); ?>">
                        <img src="<?php echo $logo_src; ?>" alt="<?php bloginfo( 'name' ) ?>">
                    </a>
                <?php endif;?>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'main_menu',
                    'menu_id' => 'main-menu-nav',
                    'menu_class' => 'main__menu__navbar',
                    'sort_column' => 'menu_order',
                    'container' => false,
                    'center_logo' => Brooks_Theme_Options::getData('menu_style') == 'center__logo__menu',
                    'fallback_cb' => '',
                    'walker' => new Brooks_Walker_Nav_Menu()
                ));
                get_sidebar('header-right');
                ?>

            </div>
        </div>
    </nav>
    <!-- main menu -->
</header>
