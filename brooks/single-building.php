<?php
/**
 * The template for displaying all single buildings.
 */
?>
<?php get_header(); ?>

<?php if (have_posts()) :  the_post();?>

    <?php get_template_part( 'templates/building/header' );?>

    <?php get_template_part( 'templates/building/main-layout', rwmb_meta( 'building_layout' ) ); ?>

    <?php get_template_part( 'templates/building/map' );?>

    <?php get_template_part( 'templates/building/attachment' );?>

    <?php get_template_part( 'templates/building/pricing' );?>

    <?php get_template_part( 'templates/building/gallery' );?>

    <?php get_template_part( 'templates/template-part', 'subscription');?>

<?php endif; ?>

<?php get_footer(); ?>