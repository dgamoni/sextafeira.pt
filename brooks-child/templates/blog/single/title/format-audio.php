<?php
$self_audio = Brooks_Meta_Options::getData('audio_file', get_the_ID());
?>
<h1>
    <?php the_title();?>
</h1>

<?php if(!empty($self_audio)):
    $meta = wp_get_attachment_metadata($self_audio);
    brooks_enqueue_custom( 'audio' );
    ?>

    <div class="theme__audio__player theme__audio__block">
        <audio class="" preload="metadata">
            <source type="<?php echo $meta['mime_type']?>" src="<?php echo wp_get_attachment_url($self_audio);?>">
        </audio>

        <button class="play__btn waves-effect waves-light"></button>
        <div class="load__bar_wrap">
            <div class="load__bar"></div>
        </div>

        <button class="volume__btn">
            <span class="volume__wave">
                <span class="wave__lvl wave__low"></span>
                <span class="wave__lvl wave__middle"></span>
                <span class="wave__lvl wave__hight"></span>
            </span>
        </button>

    </div>

<?php endif;?>