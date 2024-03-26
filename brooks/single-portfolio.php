<?php
/**
 * The template for displaying all single portfolio posts.
 */
?>
<?php
brooks_register_ajax(array(
    'brooks_like_post' => 'brooks_like_post'
));
?>

<?php get_header(); ?>

<?php if (have_posts()) :  the_post();?>

    <?php get_template_part( 'templates/portfolio/header');?>

    <?php get_template_part( 'templates/portfolio/content-header');?>

    <?php get_template_part( 'templates/portfolio/content');?>

    <?php get_template_part( 'templates/portfolio/content-additional');?>

    <?php get_template_part( 'templates/template-part', 'subscription');?>

<?php endif; ?>

<?php get_footer(); ?>