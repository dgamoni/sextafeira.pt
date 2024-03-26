<section class="theme__section">
    <?php if(!empty($images = Brooks_Meta_Options::getData('portfolio_images', get_the_ID(), array('multiple' => true)))):?>
    <?php brooks_enqueue_custom('grid');?>
    <?php brooks_enqueue_custom('gallery');?>

    <?php
    $width = Brooks_Meta_Options::getData('portfolio_width', get_the_ID());
    $type = Brooks_Meta_Options::getData('portfolio_grid', get_the_ID());
    $cols = Brooks_Meta_Options::getData('portfolio_columns', get_the_ID());
    $gap = Brooks_Meta_Options::getData('portfolio_gap', get_the_ID());
    $img_size = $cols <= 6?'medium_large':'medium';
    ?>

    <div class="<?php echo $width;?>">
        <div class="portfolio__item__gallery">

            <div class="theme__content theme__grid__wrap -gap__<?php echo $gap;?>">
                <div class="theme__grid theme__media__gallery grid__type__<?php echo $type;?> grid__columns__<?php echo $cols;?>">

                    <?php foreach($images as $img):
                        $w = $h = 1;
                        $class = '';

                        if($type == 'metro') {
                            $image = image_downsize($img);

                            $ratio = $image[1] / $image[2];
                            $schema = explode('__', brooks_get_image_ratio($ratio));

                            $w = $schema[0];
                            $h = $schema[1];

                            if($w > 1 || $h > 1)
                                $img_size = 'medium_large';
                        }

                        $class .= ' item__width__'.$w;
                        $class .= ' item__height__'.$h;

                        if($type == 'masonry'):?>
                            <div class="grid__item">
                                <div class="grid__item__content__wrap">
                                    <div class="grid__item__content">
                                        <a class="gallery__item" href="<?php echo wp_get_attachment_image_url($img, 'large');?>">
                                            <div class="gallery__item__description">
                                                <i class="icon bicon bi-search"></i>
                                            </div>
                                            <img src="<?php echo wp_get_attachment_image_url($img, $img_size);?>" alt="" class="img-responsive">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php else:?>
                            <div class="grid__item <?php echo $class;?>">
                                <div class="grid__item__content__wrap">
                                    <div class="grid__item__content">
                                        <a class="gallery__item" href="<?php echo wp_get_attachment_image_url($img, 'large');?>">
                                            <div class="gallery__item__description">
                                                <i class="icon bicon bi-search"></i>
                                            </div>
                                            <div class="blog__grid__image -image__fill" style="background-image: url(<?php echo wp_get_attachment_image_url($img, $img_size);?>);"></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>

                </div>
                <div class="space__offset__sm__<?php echo $gap;?>"></div>
                <?php endif;?>
            </div>
        </div>
        
        <!-- Next / Previous Portfolio Link English Version -->
        <?php if(ICL_LANGUAGE_CODE=='en'){ ?>
        <div class="next-prev-links">
            <div class="alignleft prev-portfolio prev-next-post-nav"><?php previous_post_link( '%link', 'Previous Project' ) ?></div>
            <div class="alignright next-portfolio prev-next-post-nav"><?php next_post_link( '%link', 'Next Project' ) ?></div>
        </div>
        <?php } ?>
        
        <!-- Next / Previous Portfolio Link PT Version -->
        <?php if(ICL_LANGUAGE_CODE=='pt-pt'){ ?>
        <div class="next-prev-links pt-next-prev">
            <div class="alignleft prev-portfolio prev-next-post-nav"><?php previous_post_link( '%link', 'Projeto anterior' ) ?></div>
            <div class="alignright next-portfolio prev-next-post-nav"><?php next_post_link( '%link', 'Próximo projeto' ) ?></div>
        </div>
        <?php } ?>
        
    </div>
</section>