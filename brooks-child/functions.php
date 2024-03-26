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

function get_artist_avatar($id) {
	$size = array(200, 200);
	$avatar = get_avatar( $id, 200);
	$out = '';
	$attachment_upload_url = esc_url( get_the_author_meta( 'cupp_upload_meta', $id ) );
	 
  	if ( $attachment_upload_url ) {
    	$attachment_id = attachment_url_to_postid( $attachment_upload_url );
    	$image_thumb = wp_get_attachment_image_src( $attachment_id, $size );
  	}

	if($avatar) { 
		 $out = $avatar; 
	 } else if ($image_thumb) { 
	     $out = '<img src="'.$image_thumb[0].'" alt="" />';
	 } 
return $out;
}