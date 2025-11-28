<?php
/**
 * Iori Hooks
 *
 * @package  Iori
 */
/**
 * Flash sale.
 * 
 * @return discount
 * @return sale badge
 * @return hot badge
 */
add_filter( 'woocommerce_sale_flash', 'iori_extend_sale_badge', 10, 3 );
