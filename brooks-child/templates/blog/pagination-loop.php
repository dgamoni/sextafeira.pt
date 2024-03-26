<div class="text-center">
    <?php if(function_exists('brooks_post_navigation')) {
        brooks_post_navigation();
    } else { ?>

        <div class="pagination">
            <?php previous_posts_link('<span class="bicon bi-carret-left" aria-hidden="true"></span>'); ?>

            <span>&bull;</span>

            <?php next_posts_link('<span class="bicon bi-carret-right" aria-hidden="true"></span>');?>
        </div>
    <?php } ?>
</div>