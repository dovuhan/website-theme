<?php
/**
 * Iori Hooks
 *
 * @package  Iori
 */
add_action( 'wp_head', 'iori_pingback_header' );
add_action( 'after_setup_theme', 'iori_setup', 10 );

// filter
add_filter( 'body_class', 'iori_body_classes' );
add_filter( 'upload_mimes', 'iori_allow_upload_mimes' );
