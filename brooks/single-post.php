<?php
/**
 * The template for displaying all single blog posts.
 */
?>

<?php get_header(); ?>

<?php get_template_part( 'templates/blog/single/header');?>

<?php get_template_part( 'templates/blog/single/content');?>

<?php get_template_part( 'templates/template-part', 'subscription');?>

<?php get_footer(); ?>