<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package iori
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function iori_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 300,
			'single_image_width'    => 600,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}


/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function iori_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	$is_ajax = iori_theme_option( 'iori_shop_ajax' );
	if ( $is_ajax == true ) {
		$classes[] = 'iori-ajax-shop-on';
	}

	$iori_sorting = iori_theme_option( 'iori_sorting' );
	if ( $iori_sorting == 'button' ) {
		$classes[] = 'iori-button-filter';
	}

	if ( iori_is_woo_active() && is_product() ) {
		$classes[] = 'catalog-product-view';
	}

	/**
	 * Variation swatcher 
	 */
	$product_attr_checkbox = get_post_meta( get_the_ID(), '_iori_product_settings', true );
	$product_attr_checkbox = isset( $product_attr_checkbox['product_attr_checkbox'] ) ? $product_attr_checkbox['product_attr_checkbox'] : '';

	if ( $product_attr_checkbox == true ) {
		$classes[] = 'iori-product-single-variation';
	}

	// shop page
	$args                = array();
	$args['layout_name'] = iori_get_shop_layout();

	if ( ( iori_is_woo_active() && isset( $args['layout_name'] ) ) && is_shop() || is_product_category() ) {
		if ( $args['layout_name'] == 'full_width' ) {
			$classes[] = 'shop-full-width';
		} elseif ( $args['layout_name'] == 'right_sidebar' ) {
			$classes[] = 'shop-right-sidebar-active';
		} elseif ( $args['layout_name'] == 'left_sidebar' ) {
			$classes[] = 'shop-left-sidebar-active';
		}
	}


	return $classes;
}

