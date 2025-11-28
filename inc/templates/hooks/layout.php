<?php
/**
 * Iori Hooks
 *
 * @package  Iori
 */

/**
 * Themes layout hooks.
 */
add_action( 'iori_after_header', 'iori_page_wrapper_start', 10 );
add_action( 'iori_after_header', 'iori_page_title', 15 );
add_action( 'iori_before_footer', 'iori_subscription', 5 );
add_action( 'iori_before_footer', 'iori_quick_sales_services', 20 );
add_action( 'iori_footer_start', 'iori_page_wrapper_end', 99 );
