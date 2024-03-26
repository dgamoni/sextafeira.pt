<?php global $brooks_blog_settings;?>

<?php if($brooks_blog_settings['type'] == 'page_blog'): brooks_get_blog_query(); endif;?>

<?php if (have_posts()): ?>
<div class="theme__content <?php echo $brooks_blog_settings['blog_grid'] == 'standart'?'':('-gap__'.$brooks_blog_settings['blog_gap']);?>">

    <div class="blog__list__<?php echo $brooks_blog_settings['blog_grid'];?> <?php echo ($brooks_blog_settings['blog_grid'] != 'standart'?('theme__grid grid__columns__' . $brooks_blog_settings['blog_columns']):''); ?>">
        <?php while (have_posts()) : the_post();?>

            <?php if($brooks_blog_settings['blog_grid'] == 'standart'): ?>
                <?php get_template_part( 'templates/blog/loop-standart/format', brooks_get_post_format() );?>
            <?php else:?>
                <?php brooks_enqueue_custom('grid'); ?>
                <?php brooks_enqueue_custom('css-animation');?>
                <?php get_template_part( 'templates/blog/loop-grid/format', brooks_get_post_format() );?>
            <?php endif;?>

        <?php endwhile;?>
    </div>

    <?php get_template_part( 'templates/blog/pagination-loop' );?>
</div>
<?php else:?>
    <div class="col-xs-12">
        <?php get_template_part( 'templates/blog/content', 'none' );?>
    </div>
<?php endif;?>

<?php if($brooks_blog_settings['type'] == 'page_blog'): wp_reset_query(); endif;?>

<?php unset($brooks_blog_settings);?>