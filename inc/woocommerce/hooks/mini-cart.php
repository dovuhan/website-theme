<?php
/**
 * Iori Hooks
 *
 * @package  Iori
 */
/**
 * Mini cart hooks.
 * 
 * @package Iori
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'iori_woocommerce_cart_link_fragment' );
