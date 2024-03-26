<?php

/**

 * Template Name: Artist Dashboard Template

 *

 * @package WordPress

 * @subpackage Twenty_Fourteen

 * @since Twenty Fourteen 1.0

 */



get_header(); ?>





<?php 



function wp_delete_post_link($link = 'Delete This', $before = '', $after = '')

{

global $post;

if ( $post->post_type == 'product' ) {

if ( !current_user_can( 'edit_page', $post->ID ) )

return;

} else {

if ( !current_user_can( 'edit_post', $post->ID ) )

return;

}

$link = "<a href='" . wp_nonce_url( get_bloginfo('url') . "/wp-admin/post.php?action=delete&amp;post=" . $post->ID, 'delete-post_' . $post->ID) . "'>".$link."</a>";

echo $before . $link . $after;

}

?>              

<div id="artist-list">





<div class="vc_row wpb_row vc_inner vc_row-fluid theme__container">



<div class="page-header-info">

    <div class="title-artist">

     <?php /*?>   <span class="colour"><?php printf( __( "%s's Dashboard", 'wpuf' ), $userdata->user_login ); ?></span><?php */?>

   <?php

   if (have_posts()) :

   while (have_posts()) :

      the_post();

         the_title();

   endwhile;

endif;

   ?>

    </div>


</div>



<div class="artist-names">

	<?php

if(isset($_REQUEST['author_id'])){

$id = $_REQUEST['author_id'];

}else{

$current_user = wp_get_current_user();

$id = $current_user->id;

}

?>





<?php

	$args2 = array(

	 'role' => 'artists',

	 'orderby' => 'user_nicename',

	 'order' => 'ASC'

	);

	 $authors = get_users($args2);

	echo '<ul>';

	 foreach ($authors as $user) {
		if ( get_user_meta( $user->id, 'wp-approve-user', true ) ) :
		 ?>
         	<li><a href="<?php bloginfo('url');?>/artist-list/<?php echo "?author_id=".$user->id; ?>"><?php  echo $user->display_name/*.'['.$user->user_email . ']'*/; ?></a><br /></li>
         <?php
         endif;
		 

	 //echo '<li>' . $user->display_name.'['.$user->user_email . ']</li>';

	 }

	echo '</ul>';



?>

</div>







    

 

 </div>

</div>





<?php

get_footer();



