<?php $img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' ); ?>
<section class="theme__section">
    <div class="container">
    <?php if($img):?>
        <div class="space__offset__xs__90 space__offset__sm__30 space__offset__md__60"></div>
        <div class="figure__holder__4__3 image-fill" style="background-image:  url(<?php echo $img;?>);"></div>
    <?php endif;?>
    </div>
</section>