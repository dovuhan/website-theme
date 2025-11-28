<?php
/**
 * The shop psge sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iori
 */

if ( ! is_active_sidebar( 'shop-1' ) ) {
	return;
}
?>

<aside id="secondary" class="sidebar shop-sidebar widget-area">
	<?php dynamic_sidebar( 'shop-1' ); ?>
</aside><!-- #secondary -->
