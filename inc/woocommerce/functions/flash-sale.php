<?php

/**
 * Filter `woocommerce_sale_flash`.
 *
 * @since 1.0
 * @package iori
 */
function iori_extend_sale_badge( $html, $post, $product ) {
	$sales_badge_percentage = iori_theme_option( 'sales_badge_percentage' );

	if ( $sales_badge_percentage == true && ! $product->is_type( 'grouped' ) ) {
		if ( $product->is_type( 'variable' ) ) {
			$percentages = array();

			// Get all variation prices
			$prices = $product->get_variation_prices();

			// Loop through variation prices
			foreach ( $prices['price'] as $key => $price ) {
				// Only on sale variations
				if ( $prices['regular_price'][ $key ] !== $price ) {
					// Calculate and set in the array the percentage for each variation on sale
					$percentages[] = round( 100 - ( $prices['sale_price'][ $key ] / $prices['regular_price'][ $key ] * 100 ) );
				}
			}
			$percentage = max( $percentages ) . '%';
		} else {
			$regular_price = (float) $product->get_regular_price();
			$sale_price    = (float) $product->get_sale_price();

			$percentage = round( 100 - ( $sale_price / $regular_price * 100 ) ) . '%';
		}
	} else {
		$percentage = '';
	}
	$sales_badge = iori_theme_option( 'sales_badge' ) ? iori_theme_option( 'sales_badge' ) : 'Sale!';

	$product_meta_data = get_post_meta( get_the_ID(), '_iori_product_settings', true );
	$product_badge     = isset( $product_meta_data ) && ! empty( $product_meta_data['product_badge'] ) ? '<span class="extra-badge product-label hot-label">' . $product_meta_data['product_badge'] . '</span>' : '';

	return '<span class="onsale product-label sale-label text">' . esc_html( $sales_badge ) . ' ' . $percentage . '</span>' . $product_badge;
}
