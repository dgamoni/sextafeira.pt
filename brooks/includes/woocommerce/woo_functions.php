<?php

defined( 'ABSPATH' ) or die();



if ( class_exists( 'WooCommerce' ) ):



	/**

	 * Register custom image sizes for WooCommerce

	 */

	if ( ! function_exists( 'brooks_woocommerce_thumbnail_size' ) ) {

		function brooks_woocommerce_thumbnail_size( $args ) {



			return array(

				'width'  => 100,

				'height' => 100,

				'crop'   => false

			);

		}

	}







	if ( ! function_exists( 'brooks_woocommerce_catalog_size' ) ) {

		function brooks_woocommerce_catalog_size( $args ) {

			return array(

				'width'  => 300,

				'height' => 300,

				'crop'   => false

			);

		}

	}





	if ( ! function_exists( 'brooks_woocommerce_single_size' ) ) {

		function brooks_woocommerce_single_size( $args ) {

			return array(

				'width'  => 500,

				'height' => 500,

				'crop'   => false

			);

		}

	}



	if ( ! function_exists( 'brooks_woocommerce_setup' ) ) {

		function brooks_woocommerce_setup() {

			add_theme_support( 'woocommerce' );

		}

	}











	/**

	 * Remove the default product images

	 */

	add_action( 'wp', function() {

		if ( function_exists( 'is_product' ) && is_product() && ! defined('DOING_AJAX') ) {

			remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );



			// Add filter to disable original product image

			add_action( 'woocommerce_product_thumbnails', 'brooks_woocommerce_product_images_slider', 20 );

		}

	} );





	/**

	 * Return custom arguments to turn on/off related

	 * products section

	 *

	 * @param   array  $args  Arguments

	 * @return  array

	 */

	function brooks_woocommerce_related_products_args( $args ) {

		if( !Brooks_Theme_Options::getData('enable_related_product') )

			return array();

		return $args;

	}

		add_filter( 'woocommerce_related_products_args', 'brooks_woocommerce_related_products_args' );



	/**

	 * Modify the number of products that will be appeared

	 * in related products section

	 *

	 * @param   array  $args  Arguments

	 * @return  array

	 */

	function brooks_woocommerce_output_related_products_args( $args ) {

		$args['posts_per_page'] = Brooks_Theme_Options::getData('rel_number_product');

		$args['columns'] = 8;  // HARD CODE -- DESIGN RESTRICTION | don't ask why eight!! mayby apply(output_related_products, 8)



		return $args;

	}





	/**

	 * Function for overriding product title template in Product List Loop

	 */

	function brooks_woocommerce_template_loop_product_title() {



		$tag = 'h5';

		the_title('<' . $tag . ' class="brooks-product-list-product-title"><a href="'.get_the_permalink().'">', '</a></' . $tag . '>');

	}



	/**

	 * Register fragment markup that will respond in ajax request when add

	 * a product to cart

	 *

	 * @param   array  $fragments  Fragments content

	 * @return  array

	 */

	function brooks_woocommerce_cart_fragments( $fragments ) {

		$cart_items = WooCommerce::instance()->cart->get_cart_contents_count();



		if ( $cart_items > 0 ) {

			$fragments['.menu__item .menu__item__shop .shopping-cart-items-count'] = sprintf(

				'<span class="shopping-cart-items-count">%d</span>', $cart_items );

		}

		else {

			$fragments['.menu__item .menu__item__shop .shopping-cart-items-count'] = '<span class="shopping-cart-items-count no-items"></span>';

		}



		return $fragments;

	}







	function brooks_woocommerce_product_images_slider() {

		get_template_part('includes/woocommerce/templates/images-slider' );

	}





	//Single product add additional html around single product info

	function brooks_custom_loop_columns() {

		return 6; // 3 products per row

	}



	function brooks_single_product_additional_tag_after() {



		print '</div>';



	}





	function brooks_single_product_additional_tag_before() {



		print '<div class="single-product-summary">';



	}



	function brooks_woocommerce_sale_flash() {



		return '<span class="onsale">' . esc_html__('SALE', 'brooks') . '</span>';

	}



	/**

	 * Function that social share for product page

	 * Return array array of WooCommerce pages

	 */

	function brooks_woocommerce_share() {



		if ( Brooks_Theme_Options::getData('enable_social_sharing') ) :

            get_template_part( 'templates/template-part', 'share' );

		endif;



	}







	if ( ! function_exists( 'brooks_woocommerce_products_per_page' ) ) {

		function brooks_woocommerce_products_per_page( $value ) {

			$value = Brooks_Theme_Options::getData('page_number_product');

			return  $value;

		}

	}





	if(!function_exists('brooks_woocommerce_columns_class')) {

		/**

		 * Function that adds number of columns class to header tag

		 *

		 * @param array array of classes from main filter

		 *

		 * @return array array of classes with added bottom header appearance class

		 */

		function brooks_woocommerce_columns_class($classes) {



			if(in_array('woocommerce', $classes)) {



				$products_list_number = Brooks_Theme_Options::getData('product_columns');

				$classes[] = 'columns-' . $products_list_number;



			}



			return $classes;

		}





	}







	if ( ! function_exists( 'brooks_woocommerce_body_classes' ) ) {

		function brooks_woocommerce_body_classes( $classes ) {

			if ( is_woocommerce() ) {

				if ( is_product() )

					$classes[] = "single-product-page ";

				else

					$classes[] = "woocommerce-page";

			}



			return $classes;

		}

	}

	if( ! function_exists('brooks_add_to_product_loop_the_wishlist') ){



		function brooks_add_to_product_the_wishlist(){

            if(shortcode_exists('yith_wcwl_add_to_wishlist'))

			    echo do_shortcode('[yith_wcwl_add_to_wishlist link_classes = "btn btn-sm btn-gray btn-inverse"]');

		}



	}





	if(!function_exists('brooks_is_woocommerce_page')) {

		/**

		 * Function that checks if current page is woocommerce shop, product or product taxonomy

		 * @return bool

		 *

		 * @see is_woocommerce()

		 */

		function brooks_is_woocommerce_page() {

			if (function_exists('is_woocommerce') && is_woocommerce()) {

				return is_woocommerce();

			} elseif (function_exists('is_cart') && is_cart()) {

				return is_cart();

			} elseif (function_exists('is_checkout') && is_checkout()) {

				return is_checkout();

			} elseif (function_exists('is_account_page') && is_account_page()) {

				return is_account_page();

			}

		}

	}





		if ( ! function_exists( 'brooks_topbar' ) ) {



			function brooks_topbar() {

				get_template_part('includes/woocommerce/templates/topbar' );

			}

		}

	if ( ! function_exists( 'brooks_pagination' ) ) {

		function brooks_pagination( $query = null ) {

			if ( ! ( $query instanceOf WP_Query ) )

				$query = $GLOBALS['wp_query'];



			// Don't print empty markup if there's only one page.

			if ( $query->max_num_pages < 2 ) return;



			$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

			$paging_style = 'pager-numeric';









			// Set up paginated links.

			$links = paginate_links( apply_filters( 'theme/paginate-args', array(

				'total'     => $query->max_num_pages,

				'current'   => $paged,

				'mid_size'  => 1,

				'prev_text' => esc_html__( '&larr; Previous', 'brooks' ),

				'next_text' => esc_html__( 'Next &rarr;', 'brooks' ),

				'prev_next' => $paging_style == 'pager-numeric'

			) ) );



			$next_link    = get_next_posts_link( esc_html__( 'Next &rarr;', 'brooks' ), $query->max_num_pages );

			$prev_link    = get_previous_posts_link( esc_html__( '&larr; Previous', 'brooks' ) );

			$more_link    = get_next_posts_link( esc_html__( 'Load More', 'brooks' ), $query->max_num_pages );



			if ( $paging_style == 'pager' && ! ( empty( $next_link ) && empty( $prev_link ) ) ) {

				printf( '<nav class="navigation paging-navigation pager" role="navigation">

				<div class="pagination loop-pagination">%s %s</div>

			</nav>', $prev_link, $next_link );

			}

			elseif ( $paging_style == 'numeric' && ! empty( $links ) ) {

				printf( '<nav class="navigation paging-navigation numeric" role="navigation">

				<div class="pagination loop-pagination">%s</div>

			</nav>', $links );

			}

			elseif ( $paging_style == 'loadmore' && ! empty( $next_link ) ) {

				printf( '<nav class="navigation paging-navigation loadmore" role="navigation">

				<div class="pagination loop-pagination">%s</div>

			</nav>', $more_link );

			}

			elseif ( ! empty( $links ) ) {

				printf( '<nav class="navigation paging-navigation pager-numeric" role="navigation">

				<div class="pagination loop-pagination">%s</div>

			</nav>', $links );

			}

		}

	}







	if( ! function_exists('brooks_filter_woocommerce_loop_add_to_cart_args') ){



		function brooks_filter_woocommerce_loop_add_to_cart_args( $out ){



			$out['class'].= ' btn btn-block btn-sm';

			return $out;

		}



	}









	if( ! function_exists('brooks_add_to_product_loop_the_preview') ){



		function brooks_add_to_product_loop_the_preview(){

			global $product;

			$uid = 'modal-' . brooks_get_unique_id();



			ob_start();

			brooks_include_template( BROOKS_INCLUDES . '/woocommerce/templates/preview.php', array(

				'title' => $product->post->post_title,

				'id' => $product->id

			) );

			$content = ob_get_contents();

			ob_get_clean();



			brooks_get_modal_form($content, $uid);

			echo '<div class="product-preview" ><a class="waves-effect waves-light  btn btn-sm btn-white btn-inverse modal-trigger" href="#' . $uid .'">' .

				esc_html__( 'PREVIEW' ,'brooks')

				. '</a></div>';



		}



	}







	if( ! function_exists('brooks_add_woocommerce_script') ){



		function brooks_add_woocommerce_script(){

			brooks_enqueue_custom( 'woocommerce' );

		}

	}









	function brooks_update_shipping_method(){

		brooks_enqueue_custom( 'form' );

	}







	// "new" flash



	if(! function_exists('brooks_woocommerce_show_product_new_flash')) {

		function brooks_woocommerce_show_product_new_flash(){

			$new_label = Brooks_Theme_Options::getData('new_label_product_checker');

			$new_days = Brooks_Theme_Options::getData('new_label_product_day');

			$new_position = Brooks_Theme_Options::getData('new_label_product_position');

			if($new_label){



				$gmt_timestamp = get_post_time( 'F j, Y', TRUE);

				$formated_post_data = new DateTime($gmt_timestamp);

				$not_expired = $formated_post_data->diff(new DateTime('now'))->format('%a') < $new_days ;

				if($not_expired){

					echo '<span class="new new__label__position' . $new_position . '">' . esc_html__( 'NEW', 'brooks' ) . '</span>';

				}

			}

		}

	}



	if(! function_exists('brooks_content_product')){



		function brooks_content_product($args){



			$default = array(

				'description' => false,

				'native_image' => false,

				'stretch_content' => false,

				'image_format' => '',

				'show_title' => true

			);

			$opt = array_merge($default ,$args);

			if ($opt['native_image']) {

				remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

			}

			// add "new" flash

			brooks_woocommerce_show_product_new_flash();

			/**

			 * woocommerce_before_shop_loop_item hook.

			 *

			 * @hooked woocommerce_template_loop_product_link_open - 10

			 *

			 */



			do_action( 'woocommerce_before_shop_loop_item' );



			/**

			 * woocommerce_before_shop_loop_item_title hook.

			 *

			 * @hooked woocommerce_show_product_loop_sale_flash - 10

			 * @hooked woocommerce_template_loop_product_thumbnail - 10

			 */



			do_action( 'woocommerce_before_shop_loop_item_title' );





			if ($opt['native_image']) :



				if ($opt['stretch_content']) : ?>

					<div class="1 <?php echo ($opt['image_format'] ? ('figure__holder__' . $opt['image_format']) :'')?>  blog__grid__image" style="background-image: url(<?php echo wp_get_attachment_image_url( get_post_thumbnail_id() , 'large');?>)"></div>

				<?php	else: ?>

					<img class="2 img-responsive"  src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id() , 'large');?>)" alt=""/>

				<?php	endif; ?>

			<?php endif;

			/**

			 * woocommerce_shop_loop_item_title hook.

			 *

			 * @hooked woocommerce_template_loop_product_title - 10

			 */

			remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 9);



			if ($opt['show_title']) :



				do_action( 'woocommerce_shop_loop_item_title' );



			endif;



			/**

			 * woocommerce_after_shop_loop_item_title hook.

			 *

			 * @hooked woocommerce_template_loop_rating - 5

			 * @hooked woocommerce_template_loop_price - 10





			 */



			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating');

			if ($opt['show_title']) :

				 global $product;

			

				  if ( $product->product_type == 'variable' || $product->product_type == 'grouped') :

					  echo '<span class="price">'. esc_html__( 'From ', 'brooks' ) . wc_price($product->get_display_price()) . '</span>';

				  else :

						do_action( 'woocommerce_after_shop_loop_item_title' );

				  endif;

			endif;

			?>



			<div class="product-info-holder">

				<?php

				/**

				 * woocommerce_shop_loop_item_title hook

				 *

				 * @hooked woocommerce_template_loop_product_title - 10

				 */

				do_action( 'woocommerce_shop_loop_item_title' ); ?>

				<a class="product-over_tile" href="<?php the_permalink(); ?>"></a>

				<?php

				/**

				 * woocommerce_after_shop_loop_item_title hook

				 *

				 * @hooked woocommerce_template_loop_rating - 5

				 * @hooked woocommerce_template_loop_price - 10

				 */

				woocommerce_template_loop_rating();

				if($opt['description']){

					?> <div class="list__desc" ><?php  echo  woocommerce_template_single_excerpt(); ?></div>

					<?php

				}

				global $product;

				if ( $product->product_type == 'variable' || $product->product_type == 'grouped') :

					echo '<span class="price">'. esc_html__( 'From ', 'brooks' ) . wc_price($product->get_display_price()) . '</span>';

				else:

					do_action( 'woocommerce_after_shop_loop_item_title' );

				endif;

				?>

				<div class="product-info-upper-button ">

					<?php

					/**

					 * preview and wishes list

					 *

					 *

					 */

					brooks_add_to_product_the_wishlist();

					brooks_add_to_product_loop_the_preview();



					?>

					<?php

					/**

					 * woocommerce_after_shop_loop_item hook.

					 *

					 * @hooked woocommerce_template_loop_product_link_close - 5

					 * @hooked woocommerce_template_loop_add_to_cart - 10

					 */

					do_action( 'woocommerce_after_shop_loop_item' );

					?>

				</div>

			</div>

			<?php

		}



	}



	if(! function_exists('brooks_woocommerce_category_image')){

 

		function brooks_woocommerce_category_image_id() {

			if ( is_product_category() ){

				global $wp_query;

				$cat = $wp_query->get_queried_object();

				$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );

				return $thumbnail_id;

			}

		}

	}





endif;