<?php
$audio_embeded = Brooks_Meta_Options::getData('audio_embeded', get_the_ID());
?>
<div class="single__post__embeded">
    <?php if($audio_embeded):?>
        <?php echo str_replace('visual=true', 'visual=false&amp;color='.substr(Brooks_Theme_Options::getData('theme_color'),1) , wp_oembed_get($audio_embeded, array('width' => 1170, 'height' => 160)));?>
        <div class="space__offset__xs__30 space__offset__sm__70"></div>
    <?php endif;?>
</div>