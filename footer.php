<?php

/**
 * The template for displaying the footer
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iori
 */

$copyrights = iori_theme_option( 'copyrights' );
?>

<footer class="footer">
	<div class="footer-1">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 width-20 footer-content">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
				<div class="col-lg-3 width-16 mb-30 footer-content">
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</div>
				<div class="col-lg-3 width-16 mb-30 footer-content">
					<?php dynamic_sidebar( 'footer-3' ); ?>
				</div>
				<div class="col-lg-3 width-16 mb-30 footer-content">
					<?php dynamic_sidebar( 'footer-4' ); ?>
				</div>
				<div class="col-lg-3 width-23 footer-content">
					<?php dynamic_sidebar( 'footer-5' ); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-2">
		<div class="container">
			<div class="footer-bottom">
				<div class="row">
					<div class="col-lg-6 col-md-12 text-center text-lg-start">
						<div class="footer-nav-menu menu-bottom color-grey-300">
						<?php 
						if ( has_nav_menu( 'iori-menu-footer' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'iori-menu-footer',
									'depth'          => 0,
								)
							);
						}
						?>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 text-center text-lg-end">
						<?php if ( ! empty( $copyrights ) ) { ?>
							<span class="color-grey-300 font-md"><?php echo wp_kses_post( $copyrights ); ?></span>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>


<?php wp_footer(); ?>

</body>

</html>
