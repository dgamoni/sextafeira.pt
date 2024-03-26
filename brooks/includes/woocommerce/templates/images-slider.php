<?php

global $product, $post;
wp_enqueue_style( 'brooks-theme-slick' );
wp_enqueue_style( 'brooks-theme-slick-theme' );
wp_enqueue_script('brooks-theme-custom-product-slider');

if ( ! ( $product_images_ids = $product->get_gallery_attachment_ids() ) )
	return;
$post_thumbnail_id = get_post_thumbnail_id();

if ($post_thumbnail_id != '' )
	array_unshift( $product_images_ids, $post_thumbnail_id );


 brooks_woocommerce_show_product_new_flash();
 woocommerce_show_product_sale_flash(); ?>
	<div class="slick-container-nav">
		<?php
		foreach ( $product_images_ids as $image_id ):

			if ( ! ( $image_link = wp_get_attachment_link( $image_id ) ) )
				continue;
			$image_title 	= esc_attr( get_the_title( $image_id ) );
			$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $image_id ) );

			$image = wp_get_attachment_image( $image_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), 0, $attr = array(
				'title'	=> $image_title,
				'alt'	=> $image_title
			) );

			?>

			<div class="slider-item">
				<?php echo $image ?>
			</div>

		<?php endforeach ?>
	</div>

	<div class="slick-container-for" style="width:80px" >
		<?php
		foreach ( $product_images_ids as $image_id ):
			if ( ! ( $image_link = wp_get_attachment_link( $image_id ) ) )
				continue;

			$image_title 	= esc_attr( get_the_title( $image_id ) );
			$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $image_id ) );

			$image = wp_get_attachment_image( $image_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
				'title'	=> $image_title,
				'alt'	=> $image_title
			) );
		?>

			<div class="slider-item">
				<?php echo $image ?>
			</div>
		<?php endforeach ?>
	</div>
