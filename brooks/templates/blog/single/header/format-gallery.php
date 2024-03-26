<?php
$images = Brooks_Meta_Options::getData('gallery_images', get_the_ID(), array('multiple' => true));
$layout_width = Brooks_Meta_Options::getData('gallery_width', get_the_ID());
?>

<?php if(!empty($images)):?>

<!--    --><?php //if(Brooks_Meta_Options::getData('gallery_type', get_the_ID()) == 'grid'):?>
        <div class="<?php echo $layout_width;?>">

            <?php
            $type = Brooks_Meta_Options::getData('gallery_grid', get_the_ID());
            $cols = Brooks_Meta_Options::getData('gallery_columns', get_the_ID());
            $gap = Brooks_Meta_Options::getData('gallery_gap', get_the_ID());
            $img_size = $cols <= 6?'medium_large':'medium';
            ?>

            <div class="<?php echo $gap?'col-xs-12':''?>">

            <?php brooks_enqueue_custom('grid');?>
            <?php brooks_enqueue_custom('gallery');?>

                <div class="space__offset__sm__<?php echo $gap;?>"></div>

                <div class="-gap__<?php echo $gap;?> theme__grid__wrap">
                    <div class="theme__grid theme__media__gallery grid__type__<?php echo $type;?> grid__columns__<?php echo $cols?>">
                        <?php foreach($images as $img):?>
                            <?php
                            $w = $h = 1;
                            $class = '';

                            if($type == 'metro') {
                                $image_meta = wp_get_attachment_metadata($img);
                                $ratio = $image_meta['width'] / $image_meta['height'];
                                $schema = explode('__', brooks_get_image_ratio($ratio));

                                $w = $schema[0];
                                $h = $schema[1];

                                if($w > 1 || $h > 1)
                                    $img_size = 'medium_large';
                            }

                            $class .= ' item__width__'.$w;
                            $class .= ' item__height__'.$h;
                            ?>
                            <?php if($type == 'masonry'): ?>
                                <div class="grid__item">
                                    <div class="grid__item__content__wrap">
                                        <div class="grid__item__content">
                                            <a class="gallery__item" href="<?php echo wp_get_attachment_image_url($img, 'large')?>">
                                                <div class="gallery__item__description">
                                                    <i class="icon bicon bi-search"></i>
                                                </div>
                                                <img src="<?php echo wp_get_attachment_image_url($img, $img_size)?>" class="img-responsive" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="grid__item <?php echo $class;?>">
                                    <div class="grid__item__content__wrap">
                                        <div class="grid__item__content">
                                            <a class="gallery__item" href="<?php echo wp_get_attachment_image_url($img, 'large')?>">
                                                <div class="gallery__item__description">
                                                    <i class="icon bicon bi-search"></i>
                                                </div>
                                                <div class="blog__grid__image -image__fill" style="background-image: url(<?php echo wp_get_attachment_image_url($img, $img_size)?>);"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>

                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
<!--    --><?php //else:?>

<!--    --><?php //endif;?>

<?php endif;?>