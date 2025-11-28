<?php
/**
 * Theme's helper functions
 * 
 * @package iori
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}


if ( ! function_exists( 'iori_get_blog_layout' ) ) {
	/**
	 * Get blog page layout options.
	 */
	function iori_get_blog_layout() {
		return apply_filters( 'iori_blog_layout', 'full_width' );
	}
}

if ( ! function_exists( 'iori_get_blog_grid_list' ) ) {
	/**
	 * Blog List Grid.
	 */
	function iori_get_blog_grid_list() {
		return apply_filters( 'iori_blog_grid_list', true );
	}
}


if ( ! function_exists( 'iori_get_blog_grid_count' ) ) {
	/**
	 * Get blog page grid count options.
	 */
	function iori_get_blog_grid_count() {
		return apply_filters( 'iori_blog_grid_count', 'col-md-6' );
	}
}

/**
 * Creates continue reading text.
 */
function iori_continue_reading_text() {
	$continue_reading = sprintf(
		/* translators: %s: Name of current post. */
		esc_html__( 'Continue reading %s', 'iori' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	);

	return $continue_reading;
}


if ( ! function_exists( 'iori_get_page_id_by_template_name' ) ) {
	/**
	 * Get page ID by it's template name
	 * 
	 * @param string $template_name Template name.
	 */
	function iori_get_page_id_by_template_name( $template_name = '' ) {
		$pages = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => $template_name,
			)
		);
		foreach ( $pages as $page ) {
			return $page->ID;
		}
	}
}

/**
 * Get post counter according to page number.
 */
function iori_paged_post_counter() {
	global $wp_query;
	// phpcs:disable WordPress.Security
	$total    = wp_count_posts( 'post' )->publish;
	$current  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$per_page = $wp_query->get( 'posts_per_page' );
	
	if ( 1 === intval( $total ) ) {
		_e( 'Showing the single result', 'iori' );
	} elseif ( $total <= $per_page || -1 === $per_page ) {
		/* translators: %d: total results */
		printf( _n( 'Showing all %d result', 'Showing all %d results', $total, 'iori' ), $total );
	} else {
		$first = ( $per_page * $current ) - $per_page + 1;
		$last  = min( $total, $per_page * $current );
		/* translators: 1: first result 2: last result 3: total results */
		printf( _nx( 'Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'iori' ), $first, $last, $total );
	}
	// phpcs:enable WordPress.Security
}
