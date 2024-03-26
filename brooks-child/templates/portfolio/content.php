<?php
$client = Brooks_Meta_Options::getData('portfolio_client', get_the_ID());
$link_text = Brooks_Meta_Options::getData('portfolio_link_text', get_the_ID());
$link = Brooks_Meta_Options::getData('portfolio_link', get_the_ID());
$cats = wp_get_post_terms(get_the_ID(), 'portfolio_category');
brooks_enqueue_custom('post-counter');

$cats = array_map(function($cat){
    return $cat->name;
}, $cats);
$cats = implode(',', $cats);
?>
<section class="theme__section">
    <div class="space__offset__xs__30 space__offset__md__60"></div>
    <div class="theme__container">
        <div class="col-sm-9 single__portfolio__content">
            <h1 class="title__underline"><?php the_title();?></h1>

            <?php the_content();?>
        </div>
        <div class="col-sm-3 single__portfolio__info">
            <a class="theme__like__post" data-post-id="<?php echo get_the_ID();?>" href="#!">
            <?php if(empty($_COOKIE['brooks_post_' . get_the_ID() . '_liked'])):?>
                <i class="post__unliked bicon bi-heart"></i><i class="post__liked hidden bicon bi-heart-fill"></i>
            <?php else:?>
                <i class="post__unliked hidden bicon bi-heart"></i><i class="post__liked bicon bi-heart-fill"></i>
            <?php endif;?>
                <span class="like__number"><?php echo Brooks_Meta_Options::getData('post_liked', get_the_ID());?></span>
            </a>

            <?php get_template_part( 'templates/template-part', 'share');?>

            <div>
                <strong class="text-uppercase"><?php echo esc_html__('Date:', 'brooks');?></strong>
                <span class="text-light">
                    <?php echo get_the_date(get_option( 'date_format' )); ?>
                </span>
            </div>
            <div>
                <strong class="text-uppercase"><?php echo esc_html__('Client:', 'brooks');?></strong>
                <span class="text-light">
                    <?php echo esc_html($client); ?>
                </span>
            </div>
            <div>
                <?php if(!empty($cats)):?>
                <strong class="text-uppercase"><?php echo esc_html__('Category:', 'brooks');?></strong>
                <span class="text-light">
                    <?php echo $cats; ?>
                </span>
                <?php endif;?>
            </div>
            <?php if($link && $link_text):?>
                <a href="<?php echo esc_url($link);?>" class="btn btn-color btn-sm"><?php echo esc_html($link_text);?></a>
            <?php endif;?>
        </div>
    </div>
    <div class="space__offset__xs__30 space__offset__md__60"></div>
</section>