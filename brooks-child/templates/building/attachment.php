<?php wp_enqueue_script('brooks-theme-waves-effect');?>

<section class="theme__section text-left section-text-white -<?php echo rwmb_meta('attach_bg_style');?>">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <?php if(!empty($attach_info = rwmb_meta('attach_info'))):?>
                    <div class="space__offset__sm__50"></div>
                    <?php echo $attach_info;?>
                <?php endif;?>
            </div>
            <div class="col-md-5 text-center">

                <?php if(!empty($attach_files = rwmb_meta('attach_files')) && !empty($attach_files['attach_file']) && !empty($attach_files['attach_file_text'])):?>
                    <div class="space__offset__sm__25 space__offset__md__150"></div>
                    <a href="<?php echo wp_get_attachment_url($attach_files['attach_file'][0]);?>" class="btn btn-white waves-effect waves-white" target="_blank">
                        <?php echo $attach_files['attach_file_text'];?><i class="bicon bi-download margin-left-15"></i>
                    </a>
                <?php endif;?>

            </div>
        </div>
        <?php if(!empty($attach_info) || !empty($attach_files['attach_file_text'])):?>
        <div class="space__offset__xs__50"></div>
        <?php endif;?>
    </div>

    <?php brooks_section_background( rwmb_meta('attach_image'), rwmb_meta('attach_bg_style'),  rwmb_meta('attach_bg_overlay'), rwmb_meta('attach_bg_color_grad'));?>
</section>