<section class="theme__section">
    <div class="build__section">
        <div class="theme__container__left">
            <div class="single__building__content">
                <div class="col-xs-12 col-sm-6">
                    <div class="space__offset__sm__30"></div>
                    <div class="build__section__col">

                        <h2 class="text-uppercase"><?php the_title();?></h2>

                        <?php if(!empty($address = rwmb_meta( 'address' ))): ?>
                            <h6 class="build__addres"><i class="icon bicon bi-pin-fill"></i><?php echo esc_html($address); ?></h6>
                        <?php endif;?>

                        <?php if(!empty($phone = rwmb_meta( 'phone' ))): ?>
                            <h6 class="build__addres"><i class="icon bicon bi-phone"></i><?php echo esc_html($phone); ?></h6>
                        <?php endif;?>

                        <?php if(!empty($email = rwmb_meta( 'email' ))): ?>
                            <h6 class="build__addres"><i class="icon bicon bi-mail"></i><?php echo esc_html($email); ?></h6>
                        <?php endif;?>

                        <?php the_content();?>

                        <?php if(!empty($features = rwmb_meta( 'building_features' ))):?>
                            <div class="space__offset__sm__20"></div>
                            <div class="build__icons__grid">
                            <?php foreach($features as $one):?>
                                <?php if(!empty($one['title']) || !empty($one['image'])):?>
                                    <div class="build__icon">
                                        <div class="build__icon__image">

                                            <?php if(!empty($one['image']) && !empty($src = wp_get_attachment_image_url($one['image'][0], 'medium'))):?>
                                            <img src="<?php echo $src;?>"  alt="<?php echo get_post_meta($one['image'][0], '_wp_attachment_image_alt', true);?>">
                                            <?php endif;?>

                                        </div>
                                        <div class="build__icon__value"><?php echo wp_kses($one['title'], brooks_allowed_html());?></div>
                                        <div class="build__icon__name"><?php echo wp_kses($one['subtitle'], brooks_allowed_html());?></div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <?php if(!empty($bg_src = wp_get_attachment_image_url(rwmb_meta('building_layout_image'), 'full'))):?>
                        <div class="build__section__col build__image__right" style="background-image: url(<?php echo $bg_src;?>);"></div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="theme__section">
    <div class="container">
        <div class="space__offset__sm__30"></div>
        <?php echo rwmb_meta('prop_info');?>

        <?php if(!empty($props = rwmb_meta( 'building_props' )) && !empty(current($props)['property'])):?>
            <div class="row">
                <?php foreach($props as $one):?>
                    <div class="col-xs-6">
                        <div class="tech__row">
                            <div class="tech__col__left"><?php echo wp_kses($one['property'], brooks_allowed_html());?></div>
                            <div class="tech__col__right"><?php echo wp_kses($one['value'], brooks_allowed_html());?></div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="space__offset__sm__50"></div>
        <?php endif;?>
    </div>
</section>