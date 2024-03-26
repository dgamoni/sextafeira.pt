<?php

defined( 'ABSPATH' ) or die();


if ( class_exists( 'WooCommerce' ) ):




	/**
	 * Register custom image sizes for WooCommerce
	 */

	add_filter( 'woocommerce_get_image_size_shop_thumbnail', 'brooks_woocommerce_thumbnail_size' );

	add_filter( 'woocommerce_get_image_size_shop_catalog', 'brooks_woocommerce_catalog_size' );

	add_filter( 'woocommerce_get_image_size_shop_single', 'brooks_woocommerce_single_size' );



	/**
	* Remove the built-in woocommerce actions
	*/
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

	/**
	* Remove the default pagination
	*/
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

	/**
	* Disable woocommerce style
	*/


	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	add_filter( 'woocommerce_show_page_title', '__return_false' );

	add_filter('woocommerce_product_additional_information_heading', '__return_false' );
	add_filter('woocommerce_product_description_heading', '__return_false' );



	add_action( 'after_setup_theme', 'brooks_woocommerce_setup' );





	add_filter( 'woocommerce_related_products_args', 'brooks_woocommerce_related_products_args' );

	add_filter( 'woocommerce_output_related_products_args', 'brooks_woocommerce_output_related_products_args' );

	//Overide Product List Loop Title
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	add_action( 'woocommerce_shop_loop_item_title', 'brooks_woocommerce_template_loop_product_title', 10 );




	add_filter( 'add_to_cart_fragments', 'brooks_woocommerce_cart_fragments' );




	//List Product override rating position
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
	add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 9);

	//List Product override link position
	remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

	//Single Product Title template override
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

	//Single product add social share (default woocommerce_share)
	add_action( 'woocommerce_single_product_summary', 'brooks_woocommerce_share', 15);

	//Sale flash template override
	add_filter( 'woocommerce_sale_flash', 'brooks_woocommerce_sale_flash');


	//Single product add additional html around single product info

	add_action( 'woocommerce_before_single_product_summary', 'brooks_single_product_additional_tag_before', 30);
	add_action( 'woocommerce_after_single_product_summary', 'brooks_single_product_additional_tag_after', 5);

	//Reformat review

	remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10 );
	add_action( 'woocommerce_review_meta', 'woocommerce_review_display_rating', 20 );

	remove_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta', 10 );
	add_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_meta', 10 );



	add_filter('loop_shop_columns', 'brooks_custom_loop_columns');
	//Single product add additional html around single product info



	add_filter( 'loop_shop_per_page', 'brooks_woocommerce_products_per_page' );






	add_filter('body_class', 'brooks_woocommerce_columns_class');


	add_filter( 'body_class', 'brooks_woocommerce_body_classes' );


	add_action( 'woocommerce_before_add_to_cart_form', 'brooks_add_to_product_the_wishlist', 10, 0 );



	add_filter('woocommerce_loop_add_to_cart_args','brooks_filter_woocommerce_loop_add_to_cart_args', 10, 2 );






	add_action('woocommerce_after_cart', 'brooks_add_woocommerce_script');




	// remove cross sells on the cart page
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

	add_action( 'wp_ajax_woocommerce_update_shipping_method', 'brooks_update_shipping_method' );
	add_action( 'wp_ajax_nopriv_woocommerce_shipping_method', 'brooks_update_shipping_method' );


	// single product page
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	//check out page
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	add_action( 'woocommerce_before_checkout_form_coupon', 'woocommerce_checkout_coupon_form', 10 );
	add_action( 'woocommerce_before_checkout_form_login', 'woocommerce_checkout_login_form', 10 );




endif;