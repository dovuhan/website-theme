<?php
/**
 * Iori Hooks | woocommerce
 *
 * @package  Iori
 */
add_action( 'after_setup_theme', 'iori_woocommerce_setup' );

// filters
add_filter( 'body_class', 'iori_woocommerce_active_body_class' );
