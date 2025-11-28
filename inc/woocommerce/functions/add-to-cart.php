<?php
/**
 * Add to cart.
 *
 * @since 1.0
 * @package iori
 */

if ( ! function_exists( 'iori_wrap_add_to_cart_link' ) ) {
	function iori_wrap_add_to_cart_link( $add_to_cart_link, $product ) {
		$tooltip                = apply_filters( 'iori_add_to_cart_tooltip', $product->add_to_cart_text(), $product );
		$add_to_cart_wrap_class = 'add-to-cart-wrap btn btn-submit';
		

		return sprintf(
			'<div class="%s" title="%s">%s</div>', 
			$add_to_cart_wrap_class,
			esc_attr( $tooltip ),
			$add_to_cart_link . $style
		);
	}
}
