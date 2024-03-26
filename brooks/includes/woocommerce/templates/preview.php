<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}
//var_dump($product);
global $post, $product;
?>
<div class="product__preview">
    <div class="cover__bg" style=" background:  url('<?php echo wp_get_attachment_image_url(get_post_thumbnail_id($id) , array('500','1000')); ?>')  center/cover  no-repeat #FFF">
        <div></div>
    </div>
    <div class="details__out">
        <h4 class="details__title" ><?php echo $title  ?> </h4>

        <div class="details__social" >
            <div class="details__social-in details__social-rating"><?php woocommerce_template_single_rating(); ?></div>
            <div class="details__social-in details__social-share">
                <?php get_template_part( 'templates/template-part', 'share' );?>
            </div>
        </div>
        
        <div class="details__tags"> <?php woocommerce_template_single_meta(); ?></div>
        <div class="details__desc" ><?php woocommerce_template_single_excerpt(); ?></div>
        <div class="details__price" ><?php woocommerce_template_single_price(); ?></div>
        <div class="details__details" ><a class="waves-effect waves-light  btn btn-sm btn-gray btn-inverse" href="<?php the_permalink($post); ?>" >VIEW DETAILS</a></div>
        <?php if($product->is_in_stock()):  ?>
        <div class="details__cart" ><?php do_action( 'woocommerce_after_shop_loop_item'); ?></div>
        <?php endif; ?>
    </div>
</div>