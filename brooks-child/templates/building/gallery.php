<section class="theme__section text-center">
    <div class="container">
        <?php if(!empty($gallery_info = rwmb_meta('gallery_info'))) :?>
            <div class="space__offset__sm__30"></div>
            <header>
                <?php echo $gallery_info;  ?>
            </header>
            <div class="space__offset__sm__20"></div>
        <?php endif;?>
    </div>

    <?php if(!empty($images = rwmb_meta('gallery_image'))):?>
    <?php brooks_enqueue_custom('grid');?>
    <?php brooks_enqueue_custom('gallery');?>

    <div class="theme__grid__wrap">
        <div class="theme__grid theme__media__gallery grid__type__simple grid__columns__6">
<!--            TODO: columns option-->

        <?php foreach(reset($images) as $img):?>
        <div class="grid__item item__width__1 item__height__1">
            <div class="grid__item__content__wrap">
                <div class="grid__item__content">
                    <a class="gallery__item" href="<?php echo wp_get_attachment_image_url($img, 'large')?>">
                        <div class="gallery__item__description">
                            <i class="icon bicon bi-zoom-in"></i>
                        </div>
                        <div class="blog__grid__image -image__fill" style="background-image: url(<?php echo wp_get_attachment_image_url($img, 'medium_large')?>);"></div>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach;?>

    </div>
    <?php endif;?>

</section>