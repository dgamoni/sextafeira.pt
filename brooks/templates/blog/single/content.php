<?php the_post();?>

<div class="theme__section blog__page blog__page__post">
    <div class="space__offset__xs__30 space__offset__sm__70"></div>

    <div class="theme__container <?php echo Brooks_Theme_Options::getData('single_post_sidebar');?>">

        <div class="theme__content -content__narrow single__post__content">

            <?php if(brooks_get_post_format() != 'gallery'):?>
                <?php get_template_part( 'templates/blog/single/header/format', brooks_get_post_format() );?>
            <?php endif;?>

            <div class="single__post__meta">
                <div class="author__meta">
                    <?php echo get_avatar( get_post_field('post_author') , 50, '', '', array('class' => 'img-circle') );?>
                    <h4 class="author__name"><?php the_author_posts_link(); ?></h4>
                    <div class="date__meta"><?php echo get_the_date(get_option( 'date_format' )); ?></div>
                    <div class="categories__meta"><?php the_category( ' | ' ); ?></div>
                </div>
                <div class="view__meta">
                    <?php get_template_part('templates/template-part', 'share');?>
                    <div class="blog__item__share">
                        <div class="see__post">
                            <i class="bicon bi-view"></i>
                            <span><?php echo Brooks_Meta_Options::getData('post_viewed', get_the_ID());?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix">
            <?php the_content()?>
            </div>

            <div class="space__offset__xs__30"></div>

            <?php $tags = get_the_tags();?>
            <?php if(!empty($tags)):?>

            <div class="tagcloud">
                <?php foreach($tags as $tag):?>
                    <a class="" href="<?php echo esc_url( get_tag_link($tag->term_id) );?>"><?php echo $tag->name;?></a>
                <?php endforeach;?>
            </div>
            <div class="space__offset__xs__30"></div>
            <?php endif;?>

<!--            TODO: Replace STANDART to STANDARD-->
            <?php if(Brooks_Theme_Options::getData('single_post_sidebar')):?>

                <?php get_template_part( 'templates/blog/single/related-posts' );?>

                <?php get_template_part( 'templates/blog/single/pagination' );?>

                <?php comments_template(); ?>
            <?php endif;?>
        </div>

        <?php if(!Brooks_Theme_Options::getData('single_post_sidebar')):?>

            <div class="theme__content">
            <?php get_template_part( 'templates/blog/single/related-posts' );?>
            <?php get_template_part( 'templates/blog/single/pagination' );?>
            </div>

            <div class="theme__content -content__narrow">
            <?php comments_template(); ?>
            </div>
        <?php endif;?>

        <?php if(Brooks_Theme_Options::getData('single_post_sidebar')):?>
            <?php get_sidebar(); ?>
        <?php endif;?>

    </div>
</div>