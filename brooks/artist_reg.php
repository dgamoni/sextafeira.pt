<?php
/**
 *  Template Name: Artist Login
 */
?>
<?php get_header(); ?>

<?php 
$user = new WP_User(get_current_user_id());

//if ($user->roles[0] ==""){
echo $user."dsfs";
 ?>

<?php if( have_posts() ) : the_post(); ?>
    <section class="theme__section">
        <div class="space__offset__sm__60 space__offset__md__170"></div>
            <?php brooks_section_background( get_post_thumbnail_id(), Brooks_Theme_Options::getData('blog_other_bg_style'), Brooks_Theme_Options::getData('blog_other_bg_overlay'), Brooks_Theme_Options::getData('blog_other_bg_color_grad'), get_header_image() );?>
    </section>
    <section class="theme__section">
        <div class="<?php echo Brooks_Meta_Options::getData('page_width', get_the_ID());?> <?php echo Brooks_Meta_Options::getData('sidebar', get_the_ID());?>">
            <div class="theme__content">
                <div class="space__offset__sm__20"></div>
                <h1 class="title__underline"><?php the_title();?></h1>

                <?php the_content(); ?>

                <div class="space__offset__sm__30"></div>

                <?php comments_template(); ?>
            </div>

            <?php if( Brooks_Meta_Options::getData('sidebar', get_the_ID()) ):?>
                <?php get_sidebar(); ?>
            <?php endif;?>
        </div>
    </section>

    <?php get_template_part( 'templates/template-part', 'subscription');?>

    <?php endif; ?>
<?php
//}else{
	//wp_redirect( home_url()."/dashboard" ); exit;
	//echo $user."dsfs";
//}
?>

<?php get_footer(); ?>