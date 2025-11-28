<?php
/**
 * Theme options themes callback functions.
 *
 * @since 1.0
 * @package iori
 */

/**
 * Blog Layout.
 */
if ( ! function_exists( 'iori_get_theme_blog_layout' ) ) {
	function iori_get_theme_blog_layout( $layout ) {
		/**
		* Blog page layout structure.
		*/
		$layout = iori_theme_option( 'blog_layout' );
		$layout = ( isset( $layout ) ) ? $layout : 'full_width';
		return $layout;
	}
}

 /**
  * Grid or List View.
  */
if ( ! function_exists( 'iori_get_theme_blog_grid_list' ) ) {
	function iori_get_theme_blog_grid_list( $grid_list ) {
		/**
		* Blog page grid_list structure.
		*/
		$grid_list = iori_theme_option( 'iori_grid_list', true );
		
		return $grid_list;
	}
}

/**
 * Grid view counter.
 */
if ( ! function_exists( 'iori_get_theme_blog_grid_count' ) ) {
	function iori_get_theme_blog_grid_count( $count ) {
		/**
		* Shop page layout structure.
		*/
		$count = iori_theme_option( 'iori_grid_column', 'col-md-6' );
		
		return $count;
	}
}
