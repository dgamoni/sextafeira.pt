<?php $brooks_blog_settings = brooks_get_blog_settings();?>
<section class="theme__section -parallax">
    <div class="container">
        <div class="blog__main">
            <div class="space__offset__xs__90 space__offset__md__180"></div>
            <h1 class="text-white">
                <?php echo $brooks_blog_settings['title'];?>
            </h1>
            <div class="space__offset__xs__90 space__offset__md__180"></div>
        </div>
    </div>
    <?php echo $brooks_blog_settings['header_bg'];?>
</section>