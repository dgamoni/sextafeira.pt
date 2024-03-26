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

function custom_js_child () { 
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($){

		 });// end ready
	</script>
	<style>
		.gender [type="radio"]:not(:checked)+label, .gender [type="radio"]:checked+label  {
			font-size: 15px;
		    color: #969396;
		    font-weight: 300;
		    text-transform: capitalize;
		}
		.tml-user-role-wrap {
			display: none;
		}
	</style>
<?php
} 
add_action( 'wp_footer', 'custom_js_child', 50 );


add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}


add_action('wp_logout','go_home');
function go_home(){
 wp_redirect( home_url() );
 exit();
}