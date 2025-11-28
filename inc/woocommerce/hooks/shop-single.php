<?php
/**
 * Shop sinlge Hooks
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// filters
add_filter( 'woocommerce_output_related_products_args', 'iori_woocommerce_related_products_args' );


// actions
add_action( 'woocommerce_before_single_product', 'iori_before_wrap_single_product', 1 );
add_action( 'woocommerce_before_single_product', 'iori_after_wrap_single_product', 12 );
add_action( 'woocommerce_before_single_product_summary', 'iori_before_single_product_summary', 5 );
add_action( 'woocommerce_after_single_product_summary', 'iori_after_single_product_summary', 5 );

add_action( 'woocommerce_before_single_product_summary', 'iori_before_single_product_image', 5 );
add_action( 'woocommerce_before_single_product_summary', 'iori_after_single_product_image', 25 );

add_action( 'woocommerce_single_product_summary', 'iori_before_single_single_add_to_cart', 25 );
add_action( 'woocommerce_single_product_summary', 'iori_after_single_single_add_to_cart', 35 );

// quantity plus
add_action( 'woocommerce_before_add_to_cart_quantity', 'iori_before_quantity', 5 );
add_action( 'woocommerce_after_add_to_cart_button', 'iori_after_quantity', 100 );

// tab
add_action( 'woocommerce_after_single_product_summary', 'iori_woocommerce_before_tabs', 5 );
add_action( 'woocommerce_after_single_product_summary', 'iori_woocommerce_after_tabs', 17 );

// related product
add_action( 'woocommerce_after_single_product_summary', 'iori_woocommerce_before_related', 18 );
add_action( 'woocommerce_after_single_product_summary', 'iori_woocommerce_after_related', 21 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_after_single_product_summary', 'iori_product_description_and_reviews', 10 );
