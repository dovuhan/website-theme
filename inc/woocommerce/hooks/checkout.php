<?php
/**
 * Iori Hooks
 *
 * @package  Iori
 */
/**
 * Hook 
 */
add_action( 'woocommerce_checkout_before_customer_details', 'iori_woocommerce_checkout_before_customer_details', 5 );
add_action( 'woocommerce_checkout_after_customer_details', 'iori_woocommerce_checkout_after_customer_details', 55 );
add_action( 'woocommerce_checkout_before_order_review_heading', 'iori_woocommerce_checkout_before_order_review_heading', 5 );
add_action( 'woocommerce_checkout_after_order_review', 'iori_woocommerce_checkout_after_order_review', 55 );

add_action( 'woocommerce_checkout_order_review', 'iori_before_woocommerce_checkout_payment', 15 );
add_action( 'woocommerce_checkout_order_review', 'iori_after_woocommerce_checkout_payment', 25 );
