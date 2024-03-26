<div class="blog__nav">
    <?php if($prev = get_previous_post_link( '%link', esc_html__('Previous Post', 'brooks') )):?>
    <button class="btn btn-color waves-effect waves-light pull-left _animation_left">
        <i class="bicon bi-arrow-left hidden-xs"></i>
        <?php echo $prev; ?>
    </button>
    <?php endif;?>

    <?php if($next = get_next_post_link( '%link', esc_html__('Next Post', 'brooks') )):?>
    <button class="btn btn-color waves-effect waves-light pull-right _animation_right">
        <?php echo $next; ?>
        <i class="bicon bi-arrow-right hidden-xs"></i>
    </button>
    <?php endif;?>

    <?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
</div>

<div class="space__offset__xs__30 space__offset__md__50"></div>