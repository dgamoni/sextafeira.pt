<?php
/**
 * The template for displaying posts in the Gallery post format.
 */
$src = get_post_thumbnail_id();
$images = Brooks_Meta_Options::getData('gallery_images', get_the_ID(), array('multiple' => true));

if(empty($images))
    $images = empty($src)?array():array($src);
?>

<article class="<?php echo join( ' ', get_post_class() );?> blog__article__list__item blog__article__list__slider__post">
    <div class="blog__article__list__item__wrap">

        <?php if(!empty($images)):?>

        <?php brooks_enqueue_custom('slider');?>

        <div class="blog__article__list__slider theme__slider__block">
            <div class="swiper-wrapper">
                <?php foreach($images as $image):?>
                <div class="swiper-slide">
                    <div class="figure__holder__2__1 article__image" style="background-image: url(<?php echo wp_get_attachment_image_url( $image, 'large' )?>)"></div>
                </div>
                <?php endforeach;?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
        <?php endif;?>

        <header>
            <h3 class="blog__item__title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
            <div class="blog__item__user"><?php the_author_posts_link(); ?></div>
            <div class="blog__item__date"><?php echo get_the_date(get_option( 'date_format' )); ?></div>
            <div class="blog__item__share">
                <div class="see__post">
                    <i class="bicon bi-view"></i>
                    <span><?php echo Brooks_Meta_Options::getData('post_viewed', get_the_ID());?></span>
                </div>
                <div class="like__post">
                    <i class="bicon bi-comment"></i>
                    <span><?php echo get_comments_number();?></span>
                </div>
            </div>
        </header>
    </div>
    <div class="blog__item__description">
        <?php has_excerpt()?the_excerpt():null; ?>
    </div>
</article>