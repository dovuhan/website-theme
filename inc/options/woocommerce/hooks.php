<?php
/**
 * Theme options woocommerce hooks.
 *
 * @since 1.0
 * @package iori
 */
// shop page
add_filter( 'iori_shop_layout', 'iori_get_theme_shop_layout', 10 );
add_filter( 'iori_shop_slider', 'iori_get_theme_shop_slider', 10 );
add_filter( 'iori_product_view', 'iori_get_theme_shop_view', 10 );
add_filter( 'iori_product_count', 'iori_get_theme_product_display', 10 );
add_filter( 'iori_quick_view', 'iori_get_theme_shop_quick_view', 10 );
add_filter( 'iori_wishlist_view', 'iori_get_theme_shop_wishlist_view', 10 );
add_filter( 'iori_shop_bottom', 'iori_get_theme_shop_bottom_section', 10 );
