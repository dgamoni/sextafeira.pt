<?php
$page_type = brooks_get_page_type();

if($page_type == 'front' || ($page_type !== 'archive_product' && strpos($page_type, 'archive')))
    $page_type = 'archive_post';

$form = Brooks_Theme_Options::getData('subscribe_form_'.$page_type);

if (!$form)
    return;

$image = Brooks_Theme_Options::getData('subscribe_attach_img', true);
$style = Brooks_Theme_Options::getData('subscribe_attach_bg_style');
$overlay = Brooks_Theme_Options::getData('subscribe_attach_bg_overlay');
$grad =  Brooks_Theme_Options::getData('subscribe_attach_bg_color_grad');
$color =  Brooks_Theme_Options::getData('subscribe_attach_color_text');

?>
<section class="theme__section theme__subscribe__section text-center -<?php echo $style;?>">
    <div class="container">
        <div class="space__offset__xs__30"></div>
        <h2 class="title__underline -underline-center"> <?php echo get_the_title($form);?> </h2>
        <div class="space__offset__xs__10"></div>
        <div class=" inline-form">
            
            <?php echo do_shortcode('[contact-form-7 id="'.$form.'"]'); ?>

        </div>
        <div class="space__offset__xs__50"></div>
    </div>
        <?php brooks_section_background( $image, $style, $overlay, $grad);?>
</section>