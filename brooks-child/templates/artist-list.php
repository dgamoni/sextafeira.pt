<?php
/**
 * Template Name: Artist Listing Template
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="artist-list">
<div class="vc_row wpb_row vc_inner vc_row-fluid theme__container">

  <div class="title-artist title-artist-list">
     <?php /*?>   <span class="colour"><?php printf( __( "%s's Dashboard", 'wpuf' ), $userdata->user_login ); ?></span><?php */?>
  </div>
  <div class="title-artist title-artist-list">
    <?php echo get_artist_avatar($_GET['author_id']); ?>
     <?php
      if (have_posts()) :
         while (have_posts()) :
            the_post();
               //the_title(); 
         endwhile;
      endif;
     ?>
  </div>
<?php $id = $_GET['author_id']; ?>

<div class="title-artist title-artist-list"><?php echo get_the_author_meta('display_name',$id); ?></div>
<p><?php echo nl2br(get_the_author_meta('description',$id)); ?></p>




<div class="products">
 <?php 
 $args = array(
    'author'     =>  $id,
    'post_type'  => 'product',
    'suppress_filters' => false //wpml support
);

$author_posts = get_posts( $args ); 
 foreach ( $author_posts as $post ) : setup_postdata( $post ); global $product;?>
	<div class="artist-grid-list theme__product__item theme__product__item--col__3 post-7204 product type-product status-publish has-post-thumbnail product_tag-art-object  instock shipping-taxable product-type-grouped">
                	
                    <div class="product-image">
                    <a href="<?php the_permalink(); ?>"><?php 
					if ( has_post_thumbnail() ) {
                                    the_post_thumbnail('large');
                                } 
					?>
                    </a>
                    </div>
                    <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    <div class="artist-price"><?php echo $product->get_price_html(); ?></div>

     
     <a rel="nofollow" href="<?php the_permalink(); ?>" data-quantity="1" data-product_id="<?php echo $product->id ?>" data-product_sku="" class="button product_type_grouped btn btn-block btn-sm">View products</a>
     
	</div>
<?php endforeach; 
wp_reset_postdata();?>
 
 </div> 
</div>
</div>
<?php
get_footer();