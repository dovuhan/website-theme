<?php
/**
 * Theme options hooks.
 *
 * @since 1.0
 * @package iori
 */

add_filter( 'iori_blog_layout', 'iori_get_theme_blog_layout', 10 );
add_filter( 'iori_blog_grid_list', 'iori_get_theme_blog_grid_list', 10 );
add_filter( 'iori_blog_grid_count', 'iori_get_theme_blog_grid_count', 10 );
