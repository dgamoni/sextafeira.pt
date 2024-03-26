<?php
/**
 * Template Name: Login Template
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
<?php $upload_dir = wp_upload_dir();
$path = $upload_dir['baseurl']."/2016/09/background.jpg-3.jpg"; ?>
<?php $bgimage = get_field('backgroud__image'); ?>
<div id="main-page-content" class="front-page login-page-page-only" style="background-image: url(<?php if(!empty($bgimage)){ echo $bgimage; }else{ echo $path; }?>);">
  <div class="container">
    <div class="row">
      <div class="span8 login-page-left">
        <div class="loginbox">
        	<?php
			$activation = $_GET['activation'];
			if($activation == 'complete'){?>
            <p class="message msg_css">
            Your account has been activated successfully. You can login to Baubible with your login details.
            <br>
            </p>
			<?php
            }
			?>

          <?php theme_my_login( array( 'default_action' => 'login') ); ?>
        </div>
        <div class="forgotpsw">
          <?php theme_my_login( array( 'default_action' => 'lostpassword' ) ); ?>
        </div>
        <div class="registerbox">
        	<?php
			$pending = $_GET['pending'];
			if($pending == 'activation'){?>
            <p class="message msg_css">
            Thank you for registering with us. To activate your account, You will receive an email with your login details.
            <br>
            </p>
            <?php
			}
			?>
          <?php theme_my_login( array( 'default_action' => 'register' ) ); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
get_footer();

