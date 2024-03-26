<?php
$video_embeded = Brooks_Meta_Options::getData('video_embeded', get_the_ID());
$video_file = Brooks_Meta_Options::getData('video_file', get_the_ID());
?>
<div class="single__post__embeded">
    <?php if($video_embeded):?>
            <?php echo wp_oembed_get($video_embeded, array('width' => 1170));?>
        <div class="space__offset__xs__30 space__offset__sm__70"></div>
    <?php elseif($video_file):?>
        <?php echo wp_video_shortcode(array(
            'src'   => wp_get_attachment_url($video_file),
            'width' => 1170,
            'poster' => wp_get_attachment_image_url( get_post_thumbnail_id(get_the_ID()), 'medium_large' ),
        )); ?>
        <div class="space__offset__xs__30 space__offset__sm__70"></div>
    <?php endif;?>
</div>
