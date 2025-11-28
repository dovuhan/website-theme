<?php
/**
 * Iori Hooks
 *
 * @package  Iori
 */
add_action( 'wp_enqueue_scripts', 'iori_enqueue', 10 );
add_action( 'admin_enqueue_scripts', 'iori_admin_enqueue' );
