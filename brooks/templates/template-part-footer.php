<?php
$n_cols = Brooks_Theme_Options::getData('footer_cols');
$col_class = brooks_get_responsive_class($n_cols);

if(Brooks_Meta_Options::getData('page_footer', get_the_ID()))
    return;
?>
<!-- footer -->
<footer class="main__footer">
    <div class="<?php echo Brooks_Theme_Options::getData('footer_view');?>">
        <div class="footer__row">
            <?php for ($i = 1; $i <= $n_cols; $i++):?>
                <div class="<?php echo $col_class ?> footer__col">
                    <?php dynamic_sidebar( 'footer-sidebar-'.$i ); ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <div class="footer__copyright">
        <div class="<?php echo Brooks_Theme_Options::getData('footer_view');?>">
            <div class="col-xs-12">
                <?php dynamic_sidebar( 'footer-bottom-sidebar' );?>
            </div>
        </div>
    </div>
</footer>

<!-- footer end -->