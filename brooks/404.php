<?php
/**
 * The template for displaying 404 pages (Not Found)
 **/
?>
<?php
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
$text_404 = Brooks_Theme_Options::getData('not_found_text');

get_header();
?>
    <section class="text-center theme__section theme__section__404">
        <div class="space__offset__sm__90 space__offset__md__180"></div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="theme-section-heading text-white">
                        <h1> <?php echo  esc_html( $text_404 ); ?> </h1>
                    </div>
                    <div class="pic__404">
                        <img src="<?php echo BROOKS_IMAGES; ?>/BH-404.svg" alt="">
                    </div>
                    <div class="space__offset__xs__15 space__offset__md__25"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <a href="<?php echo esc_url($previous); ?>" class="btn btn-white btn-block"><?php echo esc_html__('Go Back', 'brooks'); ?></a>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
        <?php echo brooks_get_section_background('', '', esc_html('theme'), true); ?>
    </section>

</div>
<?php
wp_footer(); ?>
</body>
</html>