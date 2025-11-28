<?php
/**
 * Iori Dokan multivendor hooks
 *
 * @package  Iori
 */

add_action( 'dokan_dashboard_wrap_before', 'iori_dokan_edit_product_wrap_start', 10 );
add_action( 'dokan_dashboard_wrap_after', 'iori_dokan_edit_product_wrap_end', 10 );
