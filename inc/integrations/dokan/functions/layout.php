<?php
/**
 * Iori Dokan callback function.
 *
 * @package  Iori
 */
/**
 * Start wrap
 */
if ( ! function_exists( 'iori_dokan_edit_product_wrap_start' ) ) {
	function iori_dokan_edit_product_wrap_start() {
		echo '<div class="site-content col-12" role="main">';
	}
}


/**
 * End wrap
 */
if ( ! function_exists( 'iori_dokan_edit_product_wrap_end' ) ) {
	function iori_dokan_edit_product_wrap_end() {
		echo '</div>';
	}
}
