<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}
ob_start();
woocommerce_catalog_ordering();
$catalog = ob_get_contents();
ob_end_clean();


$search =  get_product_search_form(false);


?>
   <div class="top__bar">
        <div class="top__bar-in row">
            <div class="top__bar-sort col-sm-4">
                <?php echo $catalog ?>
            </div>
            <div class="top__bar-search col-sm-8">
                <?php echo $search ?>
                <div class="box__toggle" id="box-toggle">
                    <div class="tale__out">
                        <span class="tale tale__box"></span>
                        <span class="tale tale__line"></span>
                    </div>
                    <div class="tale__out">
                        <span class="tale tale__box"></span>
                        <span class="tale tale__line"></span>
                    </div>
                </div>
            </div>
        </div>
   </div>