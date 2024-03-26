<?php global $brooks_blog_settings;?>

<section class="theme__section blog__page">
    <div class="<?php echo $brooks_blog_settings['page_width'];?> <?php echo $brooks_blog_settings['sidebar'];?>">
        <?php get_template_part( 'templates/blog/content-loop' );?>

        <?php if($brooks_blog_settings['sidebar']):?>
            <?php get_sidebar(); ?>
        <?php endif;?>
    </div>
</section>