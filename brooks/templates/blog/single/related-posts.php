<?php
$query = brooks_get_related_posts();

global $brooks_blog_settings;
$brooks_blog_settings = array(
    'blog_grid' => 'simple',
    'grid_item_simple' => true
);
?>

<?php if( $query->have_posts() ): ?>
<div class="single__post__related">
    <h3 class="margin-bottom-30"><?php echo esc_html__('More articles', 'brooks')?></h3>
    <?php brooks_enqueue_custom('grid'); ?>

    <div class="row -gap__15">

        <div class="theme__grid grid__columns__4 blog__list__simple">
        <?php while ($query->have_posts()) : $query->the_post();?>

            <?php get_template_part( 'templates/blog/loop-grid/format', brooks_get_post_format() );?>

        <?php endwhile;?>
        </div>

    </div>
</div>
<?php endif;?>

<?php wp_reset_postdata(); ?>

<div class="space__offset__xs__30"></div>