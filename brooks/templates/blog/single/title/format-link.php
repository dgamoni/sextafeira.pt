<?php $link = Brooks_Meta_Options::getData('post_link', get_the_ID());?>
<?php if(!empty($link)):?>
    <a href="<?php echo esc_url($link);?>">
        <i class="single__post__icon bicon bi-link-fill"></i>
    </a>
<?php endif;?>
<h1>
    <?php the_title();?>
</h1>