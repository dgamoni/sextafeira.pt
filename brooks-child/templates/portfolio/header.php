<?php
$bg_image = Brooks_Theme_Options::getData('single_portfolio_header_image', true);
$bg_style = Brooks_Theme_Options::getData('single_portfolio_bg_style');
$bg_overlay = Brooks_Theme_Options::getData('single_portfolio_bg_overlay');
$bg_color_grad = Brooks_Theme_Options::getData('single_portfolio_bg_color_grad');
?>
<section class="theme__section -<?php echo $bg_style;?>">
    <div class="space__offset__sm__90 space__offset__md__180"></div>
    <?php brooks_section_background($bg_image, $bg_style, $bg_overlay, $bg_color_grad);?>
</section>