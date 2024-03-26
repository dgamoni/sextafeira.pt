    </div>
    
<?php
    get_template_part( 'templates/template-part', 'footer' );
?>
<?php
    $current_user = wp_get_current_user();
?>
<?php
    wp_footer(); ?>
    
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery-ui.js" type="text/javascript"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    	jQuery(document).ready(function(){
		  jQuery('.social__widget a').attr('target', '_blank');		  
		  jQuery(".wpuf-form-add ul.wpuf-form li.artist_name .wpuf-fields input#artist_name").val('<?php echo $current_user->user_login; ?>');
		  jQuery(".wpuf-form-add ul.wpuf-form li.artist_name .wpuf-fields input#artist_name").attr("disabled","disabled");
		
		
	<?php /*?> jQuery('.logout').on('click', function(e){
            if(confirm("Are you sure you want to logout?"))
                window.location.href = "http://webprojectdevelopment.website/sextafeira/";

            return false;
        });
<?php */?>
		
		});
    </script>
</body>
</html>