<?php
/**
 * Iori Hooks
 *
 * @package  Iori
 */
add_action( 'wp_ajax_iori_load_html_dropdowns', 'iori_load_extra_blocks_dropdowns_action' );
add_action( 'wp_ajax_nopriv_iori_load_html_dropdowns', 'iori_load_extra_blocks_dropdowns_action' );
