<?php
/**
 * Theme options woocommerce callback functions.
 *
 * @since 1.0
 * @package iori
 */

if ( ! function_exists( 'iori_get_theme_shop_layout' ) ) {
	function iori_get_theme_shop_layout( $layout ) {
		/**
		* Shop page layout structure.
		*/
		$layout = iori_theme_option( 'shop_layout' );
		
		return $layout;
	}
}

/**
 * Shop page slider option.
 */
if ( ! function_exists( 'iori_get_theme_shop_slider' ) ) {
	function iori_get_theme_shop_slider( $slider ) {
		/**
		* Shop page slider structure.
		*/
		$slider = iori_theme_option( 'iori_shop_slider_section' );
		
		return $slider;
	}
}

/**
 * Shop Product view    grid|list.
 */
if ( ! function_exists( 'iori_get_theme_shop_view' ) ) {
	function iori_get_theme_shop_view( $view ) {
		$iori_shop_view = 'grid'; // default
		$iori_shop_view = iori_theme_option( 'iori_shop_view' );
		$current_view   = iori_loop_prop( 'products_view' );
		if ( $iori_shop_view == 'grid' || $iori_shop_view == 'list' ) {
			$view = ( is_shop() || is_product_category() ) ? $iori_shop_view = $current_view : $iori_shop_view;
		} 

		return $view;
	}
}

if ( ! function_exists( 'iori_get_theme_product_display' ) ) {
	function iori_get_theme_product_display( $count ) {
		$grid_product_count = iori_theme_option( 'iori_shop_grid_products_per_row' );
		$list_product_count = iori_theme_option( 'iori_shop_list_products_per_row' );
		$iori_shop_view     = iori_get_product_view();
		
		if ( $iori_shop_view == 'grid' && isset( $grid_product_count ) ) {
			$count = $grid_product_count;
		} elseif ( $iori_shop_view == 'list' && isset( $list_product_count ) ) {
			$count = $list_product_count;
		} 
		return $count;
	}
}

/**
 * Quick View
 */
if ( ! function_exists( 'iori_get_theme_shop_quick_view' ) ) {
	function iori_get_theme_shop_quick_view( $quick_view ) {
		$quick_view = iori_theme_option( 'iori_shop_quick_view' );
	
		return $quick_view;
	}
}

/**
 * Wishlist.
 */
if ( ! function_exists( 'iori_get_theme_shop_wishlist_view' ) ) {
	function iori_get_theme_shop_wishlist_view( $wishlist_view ) {
		$wishlist_view = iori_theme_option( 'iori_shop_wishlist_view' );
	
		return $wishlist_view;
	}
}

/**
 * Shop bottom section.
 * Recent post, feature post, sales section.
 */
if ( ! function_exists( 'iori_get_theme_shop_bottom_section' ) ) {
	function iori_get_theme_shop_bottom_section( $iori_featured_product ) {
		$iori_featured_product = iori_theme_option( 'iori_featured_product' );
	
		return $iori_featured_product;
	}
}
