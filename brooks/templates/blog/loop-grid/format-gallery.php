<?php
/**
 * The template for displaying posts in the Gallery post format.
 */
$src = get_post_thumbnail_id();
$images = Brooks_Meta_Options::getData('gallery_images', get_the_ID(), array('multiple' => true));

if(empty($images))
    $images = empty($src)?array():array($src);

$featured = null;
$format = '1__1';

global $brooks_blog_settings;

$cat = wp_get_post_terms(get_the_ID(), 'category');
$cat = array_shift($cat);

if($brooks_blog_settings['blog_grid'] == 'metro' || $brooks_blog_settings['blog_grid'] == 'masonry')
    $format = Brooks_Meta_Options::getData('post_loop_format', get_the_ID());
if($brooks_blog_settings['blog_grid'] == 'metro' || $brooks_blog_settings['blog_grid'] == 'simple')
    $featured = Brooks_Meta_Options::getData('post_featured', get_the_ID());

$format_masonry = $format;
$format_masonry = str_replace('2', '3', $format_masonry);
$format_masonry = str_replace('1', '2', $format_masonry);

$format = explode('__', $format);

if($featured && !isset($brooks_blog_settings['grid_item_simple'])) {
    /**
     * TODO: Theme option "Show featured Posts"
     */
    $format[0] = $format[0] + 1;
    $format[1] = $format[1] + 1;
}

$format = 'item__width__' . $format[0] . ' item__height__' . $format[1];

if($brooks_blog_settings['blog_grid'] == 'masonry')
    $format = null;
?>

<div class="<?php echo join( ' ', get_post_class() );?> grid__item  <?php echo $format; ?>">
    <div class="blog__grid__item <?php echo !empty($brooks_blog_settings['animation'])?'theme__animation -fadeInDown':'';?> gallery__post__item">
        <?php if(!empty($images)):?>

            <?php brooks_enqueue_custom('slider');?>

            <div class="theme__slider__block" data-autoplay="5000">
                <div class="swiper-wrapper">
                    <?php foreach($images as $image):?>
                        <div class="swiper-slide">
                            <div class="figure__holder__<?php echo $format_masonry;?> blog__grid__image" style="background-image: url(<?php echo wp_get_attachment_image_url( $image, 'medium_large' )?>);"></div>
                        </div>
                    <?php endforeach;?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        <?php else:?>
            <div class="<?php echo !$format?'figure__holder__1__1':'blog__grid__image'?> theme__no__image__pattern"></div>
        <?php endif; ?>
        <div class="blog__grid__item__wrap standart__post">
            <div class="blog__grid__item__wrap__inner  waves-effect waves-light">
                <a class="blog__item__link" href="<?php the_permalink();?>"></a>
                <div class="blog__item__cat"><a href="<?php echo esc_url( get_category_link($cat->term_id) );?>"><?php echo $cat->name;?></a></div>
                <div class="blog__item__date"><?php echo get_the_date(get_option( 'date_format' )); ?></div>
                <h3 class="blog__item__title"><?php the_title();?></h3>
            </div>
        </div>
    </div>
</div>