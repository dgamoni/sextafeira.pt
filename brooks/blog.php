<?php
/**
 *  Template Name: Blog
 */
?>

<?php get_header();?>

<?php
global $brooks_blog_settings;
$brooks_blog_settings = brooks_get_blog_settings();
?>

<?php get_template_part( 'templates/blog/header' );?>

<?php get_template_part( 'templates/blog/content' );?>

<?php get_template_part( 'templates/template-part', 'subscription' );?>

<?php get_footer(); ?>