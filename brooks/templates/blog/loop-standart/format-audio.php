<?php
/**
 * The template for displaying posts in the Standard post format.
 */
$src = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
$self_audio = Brooks_Meta_Options::getData('audio_file', get_the_ID());
$embeded_audio = Brooks_Meta_Options::getData('audio_embeded', get_the_ID());
?>
<article class="<?php echo join( ' ', get_post_class() );?> blog__article__list__item blog__article__audio__post <?php echo (empty($src) || $embeded_audio)?'-no__image':'';?>">
    <div class="blog__article__list__item__wrap">
        <?php if($embeded_audio):?>
            <?php echo str_replace('visual=true', 'visual=false&amp;color='.substr(Brooks_Theme_Options::getData('theme_color'),1) , wp_oembed_get($embeded_audio, array('width' => '1100', 'height' => '160')));?>
        <?php else: ?>

            <?php if(!empty($src)):?>
            <div class="blog__article__list__item__wrap__image">
                <div class="article__image theme__block__height__40" style="background-image: url(<?php echo $src ?>)"></div>
            </div>
            <?php endif;?>

        <?php endif;?>

        <header>
            <?php if(!empty($self_audio) && !$embeded_audio):
                $meta = wp_get_attachment_metadata($self_audio);
                brooks_enqueue_custom( 'audio' );
            ?>

                <div class="theme__audio__player">
                    <audio class="" preload="metadata">
                        <source type="<?php echo $meta['mime_type']?>" src="<?php echo wp_get_attachment_url($self_audio);?>">
                    </audio>

                    <div class="blog__item__title">
                        <button class="play__btn waves-effect waves-light"></button>
                        <div class="blog__item__title__inner">
                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
                            <div class="load__bar_wrap">
                                <div class="load__bar"></div>
                            </div>
                        </div>
                        <button class="volume__btn">
                            <span class="volume__wave">
                                <span class="wave__lvl wave__low"></span>
                                <span class="wave__lvl wave__middle"></span>
                                <span class="wave__lvl wave__hight"></span>
                            </span>
                        </button>
                    </div>
                </div>

            <?php else:?>
            <h3 class="blog__item__title embeded__audio"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
            <?php endif;?>

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