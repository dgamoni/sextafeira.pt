<?php
//Page Slug Body Class
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
	$classes[] = $post->post_type . '-' . $post->post_name;
	}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

function brooks_woocommerce_single_size( $args ) {
	return array(
		'width'  => 300,
		'height' => 400,
		'crop'   => true
	);
}


// function my_child_theme_setup() {
// 	remove_filter( 'woocommerce_get_image_size_shop_single', 'brooks_woocommerce_single_size' );
// 	add_filter( 'woocommerce_get_image_size_shop_single', 'brooks_woocommerce_single_size_' );
// }
// add_action( 'after_setup_theme', 'my_child_theme_setup' );

// remove_filter( 'woocommerce_get_image_size_shop_single', 'brooks_woocommerce_single_size' );
//add_filter( 'woocommerce_get_image_size_shop_single', 'brooks_woocommerce_single_size_' );



// add_action( 'init', '_yourtheme_woocommerce_image_dimensions', 1 );
// function _yourtheme_woocommerce_image_dimensions() {

// 	$single = array(
// 		'width' 	=> '300',	// px
// 		'height'	=> '400',	// px
// 		'crop'		=> 0 		// true
// 	);

// 	//update_option( 'shop_single_image_size', $single ); 		// Single product image
// 	update_option( 'brooks_woocommerce_single_size', $single ); 		// Single product image
// }

