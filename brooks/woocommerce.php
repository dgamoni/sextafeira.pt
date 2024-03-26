<?php
/*
Template Name: WooCommerce
*/
defined( 'ABSPATH' ) or die();

/**
 * Load the theme header
 */

$title = get_the_title( wc_get_page_id( 'shop' ) );
$imageshop = Brooks_Theme_Options::getData('shop_attach_image', true);
$imageProduct = Brooks_Theme_Options::getData('product_attach_image', true);
$imagecategory = brooks_woocommerce_category_image_id();

$styleShop = Brooks_Theme_Options::getData('shop_attach_bg_style');
$styleProduct = Brooks_Theme_Options::getData('product_attach_bg_style');



$overlayShop = Brooks_Theme_Options::getData('shop_attach_bg_overlay');
$overlayProduct = Brooks_Theme_Options::getData('product_attach_bg_overlay');


$gradShop =  Brooks_Theme_Options::getData('shop_attach_bg_color_grad');
$gradProduct =  Brooks_Theme_Options::getData('product_attach_bg_color_grad');


$color_text_shop =  Brooks_Theme_Options::getData('shop_attach_color_text');
$color_text_product =  Brooks_Theme_Options::getData('product_attach_color_text');


$sidebar =  Brooks_Theme_Options::getData('shop_sidebar');

ob_start();
woocommerce_breadcrumb();
$breadcrumb = ob_get_contents();
ob_clean();

global $product;

get_header();

?>
<?php if(is_shop() || is_product_category()): ?>
    <section class="theme__section -parallax">
        <div class="container">
            <div class="shop__main">
                <div class="space__offset__sm__90 space__offset__md__180"></div>
                <h1 class="text-shop " style="color:<?php echo $color_text_shop ?>"> <!-- TODO: move to custome styles -->
                    <?php echo is_shop() ? $title : single_cat_title( '', false );?>
                </h1>
                <div class="theme__breadcrumb"> <?php echo $breadcrumb; ?></div>
            </div>
        </div>
        <?php echo is_shop() ?  brooks_get_section_background((string) $imageshop, $styleShop, $overlayShop, $gradShop)
        :   brooks_get_section_background((string) $imagecategory, $styleShop, $overlayShop, $gradShop); ?>
    </section>

    <section class="theme__section">
        <div class="theme__container <?php echo $sidebar ?>">
            <div class="space__offset__sm__30 space__offset__md__60"></div>
            <div class="theme__content">

                    <?php

                    if (is_shop() || is_product_category() )
                        brooks_topbar();

                    woocommerce_content();

                    brooks_pagination();

                    ?>
             </div>
            <?php if($sidebar):
                get_sidebar( 'shop' );
            endif;?>

        </div>
    </section>

    <?php get_template_part( 'templates/template-part', 'subscription' );?>
<?php else: ?>
    <section class="theme__section -parallax">
        <div class="container">
            <div class="shop__main">
                <div class="space__offset__xs__90 space__offset__md__150"></div>
                <div style="color:<?php echo $color_text_product ?>" class="theme__breadcrumb"> <?php echo $breadcrumb;?></div>
            </div>
        </div>
        <?php echo   brooks_get_section_background((string) $imageProduct, $styleProduct, $overlayProduct, $gradProduct); ?>
    </section>
    <section class="theme__section ">
        <div class="container ">
            <div class="space__offset__xs__30 space__offset__md__60"></div>
            <div  class="row">
                <div class="col-sm-12">
                    <?php
                    if (is_shop())
                        brooks_topbar();

                    woocommerce_content();

                    brooks_pagination();
                    ?>

                </div>
            </div>
        </div>
    </section>
    <?php get_template_part( 'templates/template-part', 'subscription' );?>


<?php endif; ?>

<?php brooks_enqueue_custom( 'woocommerce' ); ?>

<?php
/**
 * Load the theme footer
 */
get_footer();
?>