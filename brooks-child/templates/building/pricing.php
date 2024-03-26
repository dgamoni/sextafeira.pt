<section class="theme__section text-center -<?php echo rwmb_meta('pricing_bg_style');?>">
    <div class="container">
        <?php if(!empty($pricing_info = rwmb_meta('pricing_info'))):?>
        <div class="space__offset__sm__30"></div>
        <header>
            <?php echo $pricing_info;?>
        </header>
        <div class="space__offset__sm__20"></div>
        <?php endif;?>
    </div>
    <div class="container">
        <?php if(!empty($pricing = rwmb_meta( 'building_pricing' )) && !empty(current($pricing)['pricing_text'])):?>
            <?php foreach($pricing as $one):?>

                <?php if(!empty($one['pricing_bg_image'])):?>
                <div class="pricing__item -popular_pricing" style="background-image:url(<?php echo wp_get_attachment_image_url(reset($one['pricing_bg_image']), 'medium_large');?>)">
                <?php else:?>
                <div class="pricing__item">
                <?php endif;?>

                    <div class="pricing__item__wrap">
                        <?php echo $one['pricing_text'];?>
                        <div class="line__lg"></div>

                        <?php if(!empty($one['pricing_btn_text'])):?>

                            <?php  if(!empty($one['pricing_use_cf']) && isset($one['pricing_btn_action']) && isset($one['pricing_btn_action']['pricing_form'])):
                                $href = '#';
                                $cf_id = $one['pricing_btn_action']['pricing_form'];
                                $modal_id = 'modal-' . brooks_get_unique_id();
                                $modal_content = '<h4 class="text-center">'. get_the_title($cf_id) .'</h4>' . do_shortcode('[contact-form-7 id="'. $cf_id .'"]');


                                brooks_get_modal_form( $modal_content, $modal_id);
                            ?>
                                <a href="#<?php echo $modal_id;?>" class="btn waves-effect waves-white modal-trigger <?php echo ((!empty($one['pricing_bg_image'])) ? 'btn-white' : 'btn-color btn-inverse'); ?> "><?php echo wp_kses($one['pricing_btn_text'], brooks_allowed_html());?></a>
                            <?php elseif( isset($one['pricing_btn_action']['pricing_url']) ):?>
                                <a href="<?php echo $one['pricing_btn_action']['pricing_url'];?>" class="btn  waves-effect <?php echo ((!empty($one['pricing_bg_image'])) ? 'btn-white' : 'btn-color btn-inverse'); ?> "><?php echo wp_kses($one['pricing_btn_text'], brooks_allowed_html());?></a>
                            <?php endif;?>

                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach;?>

            <div class="space__offset__sm__50"></div>
        <?php endif;?>
    </div>
    <?php brooks_section_background( rwmb_meta('pricing_image'), rwmb_meta('pricing_bg_style'),  rwmb_meta('pricing_bg_overlay'), rwmb_meta('pricing_bg_color_grad'));?>
</section>