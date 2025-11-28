<?php
/**
 * Fiter woocommerce add to cart with iori class.
 *
 * @since 1.0
 * @package iori
 */
add_filter( 'woocommerce_loop_add_to_cart_link', 'iori_wrap_add_to_cart_link', 90, 2 );
