<?php
/**
 * The template for displaying posts in the Link post format.
 */

$link = Brooks_Meta_Options::getData('post_link', get_the_ID());
$src = wp_get_attachment_image_url( get_post_thumbnail_id(), 'medium_large' );
$ratio = $featured = null;
$format = '1__1';

if($src){
    $image_meta = wp_get_attachment_metadata(get_post_thumbnail_id());
    $ratio = $image_meta['width'] / $image_meta['height'];
}

global $brooks_blog_settings;

$cat = wp_get_post_terms(get_the_ID(), 'category');
$cat = array_shift($cat);

if($brooks_blog_settings['blog_grid'] == 'metro')
    $format = Brooks_Meta_Options::getData('post_loop_format', get_the_ID());
if($brooks_blog_settings['blog_grid'] == 'metro' || $brooks_blog_settings['blog_grid'] == 'simple')
    $featured = Brooks_Meta_Options::getData('post_featured', get_the_ID());

$format = explode('__', $format);

if($featured && !isset($brooks_blog_settings['grid_item_simple'])) {
    $format[0] = $format[0] + 1;
    $format[1] = $format[1] + 1;
}

$format = 'item__width__' . $format[0] . ' item__height__' . $format[1];

if($brooks_blog_settings['blog_grid'] == 'masonry')
    $format = null;
?>

<div class="<?php echo join( ' ', get_post_class() );?> grid__item  <?php echo $format; ?>">
    <div class="blog__grid__item <?php echo !empty($brooks_blog_settings['animation'])?'theme__animation -fadeInDown':'';?>">
        <?php if($src):?>
            <?php if($brooks_blog_settings['blog_grid'] == 'masonry'):?>
                <?php if($ratio > 2):?>
                    <div class="figure__holder__3__2 blog__grid__image" style="background-image: url(<?php echo $src; ?>)"></div>
                <?php else: ?>
                    <img class="img-responsive" src="<?php echo $src;?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>">
                <?php endif; ?>
            <?php else:?>
                <div class="blog__grid__image -image__fill" style="background-image: url(<?php echo $src; ?>)"></div>
            <?php endif;?>

        <?php else:?>
            <div class="<?php echo !$format?'figure__holder__1__1':'blog__grid__image'?> theme__no__image__pattern"></div>
        <?php endif; ?>
        <div class="blog__grid__item__wrap link__post">
            <div class="blog__grid__item__wrap__inner  waves-effect waves-light">
                <a class="blog__item__link" href="<?php the_permalink();?>"></a>
                <div class="blog__item__cat"><a href="<?php echo esc_url(get_category_link($cat->term_id));?>"><?php echo $cat->name;?></a></div>
                <div class="blog__item__date"><?php echo get_the_date(get_option( 'date_format' )); ?></div>
                <a href="<?php echo esc_url($link);?>" class="blog__item__icon">
                    <i class="bicon bi-link-fill"></i>
                </a>
                <h3 class="blog__item__title"><?php the_title();?></h3>
            </div>
        </div>
    </div>
</div>