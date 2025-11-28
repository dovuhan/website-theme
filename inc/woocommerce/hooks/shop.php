<?php
/**
 * Woocommerce Hooks | Shop Page
 */
/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_before_shop_loop' );

/**
 * Filters
 */
add_filter( 'loop_shop_columns', 'iori_loop_columns' );

/**
 * Actions
 */
add_action( 'woocommerce_before_main_content', 'iori_woocommerce_wrapper_before', 8 );
add_action( 'woocommerce_before_shop_loop', 'iori_woocommerce_after_breadcrumb', 5 );
add_action( 'woocommerce_before_shop_loop', 'iori_woocommerce_before_product_header', 9 );
add_action( 'woocommerce_before_shop_loop', 'iori_woocommerce_after_product_header', 40 );

add_action( 'woocommerce_before_shop_loop', 'iori_woocommerce_before_product_section', 45 );
add_action( 'woocommerce_after_shop_loop', 'iori_woocommerce_after_product_section', 5 );

add_action( 'woocommerce_before_shop_loop_item', 'iori_woocommerce_before_product_item', 5 );
add_action( 'woocommerce_after_shop_loop_item', 'iori_woocommerce_after_product_item', 15 );

add_action( 'woocommerce_before_shop_loop_item', 'iori_woocommerce_before_shop_loop_item', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );
add_action( 'woocommerce_before_shop_loop_item_title', 'iori_woocommerce_after_shop_loop_item', 20 );

add_action( 'woocommerce_shop_loop_item_title', 'iori_woocommerce_before_shop_loop_item_title', 5 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 6 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 8 );
add_action( 'woocommerce_after_shop_loop_item_title', 'iori_woocommerce_after_shop_loop_item_title', 15 );
add_action( 'woocommerce_after_shop_loop_item', 'iori_woocommerce_before_cart', 1 );
add_action( 'woocommerce_after_shop_loop_item', 'iori_woocommerce_after_cart', 30 );

add_action( 'woocommerce_after_main_content', 'iori_woocommerce_wrapper_after', 12 );
