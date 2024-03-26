<?php $image_src = get_post_thumbnail_id(); ?>

<?php if(!empty($image_src)):?>

    <section class="theme__section -scale">
        <div class="container">
            <div class="buil__main">
            </div>
        </div>
        <?php brooks_section_background( $image_src, 'scale' );?>
    </section>

<?php else:?>
    <div class="space__offset__xs__40"></div>
<?php endif;?>