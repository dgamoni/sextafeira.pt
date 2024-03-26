<?php
/**
 * The template for displaying posts in the Video post format.
 */
$src = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
?>
<article class="<?php echo join( ' ', get_post_class() );?> blog__article__list__item <?php echo empty($src)?'-no__image':'blog__article__video__post';?>">
    <div class="blog__article__list__item__wrap">

        <?php if(!empty($src)):?>
        <div class="blog__article__list__item__wrap__image">
            <div class="article__image theme__block__height__50" style="background-image: url(<?php echo $src ?>)"></div>
        </div>
        <a href="<?php the_permalink();?>">
            <i class="blog__item__icon bicon bi-play-fill"></i>
        </a>
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