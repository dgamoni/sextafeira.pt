<?php $post_format = brooks_get_post_format();?>

<section class="theme__section -scale">
    <div class="container">
        <div class="blog__main">
            <div class="space__offset__xs__70 space__offset__sm__90 space__offset__md__180"></div>

            <div class="single__post__heading post__<?php echo $post_format; ?>__heading">
                <?php get_template_part( 'templates/blog/single/title/format', $post_format );?>
            </div>

            <div class="space__offset__xs__50 space__offset__sm__90 space__offset__md__180"></div>
        </div>
    </div>
    <?php echo brooks_get_section_background(get_post_thumbnail_id(get_the_ID()), Brooks_Theme_Options::getData('single_post_bg_style'), Brooks_Theme_Options::getData('single_post_bg_overlay'), Brooks_Theme_Options::getData('single_post_bg_color_grad'));?>
</section>

<section class="theme__section">
    <?php if($post_format == 'gallery'):?>
        <?php get_template_part( 'templates/blog/single/header/format', $post_format );?>
    <?php endif;?>
</section>