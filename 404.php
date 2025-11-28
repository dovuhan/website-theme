<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package iori
 */

get_header();
?>

<main id="primary" class="main">

	<section class="section box-404">
		<div class="container">
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-10">
					<div class="row align-items-center">
						<div class="col-md-5 col-sm-12 mb-30 text-center text-md-start">
							<?php
							$error_404_image = iori_theme_option( '404_image' );
							?>
							<img src="<?php echo esc_url( $error_404_image ? $error_404_image : IORI_ASSETS . '/imgs/page/404/404.png' ); ?>" alt="404 Error Image">
						</div>
						<div class="col-md-7 col-sm-12 text-center text-md-start">
							<h1 class="color-brand-1 font-84 mb-10 wow animate__animated animate__fadeIn" data-wow-delay=".0s"><?php echo esc_html( iori_theme_option( '404_page_top_title' ) ); ?></h1>
							<h3 class="color-brand-1 mb-25 wow animate__animated animate__fadeIn" data-wow-delay=".1s"><?php echo esc_html( iori_theme_option( '404_page_title' ) ); ?></h3>
							<p class="font-md color-grey-500 wow animate__animated animate__fadeIn" data-wow-delay=".2s"><?php echo esc_html( iori_theme_option( '404_page_desc' ) ); ?></p>
							<div class="mt-50 wow animate__animated animate__fadeIn" data-wow-delay=".3s"><a class="btn btn-default color-grey-900 pl-0" href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<svg class="w-6 h-6 icon-16 mr-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
									</svg><?php esc_html_e( 'Back to Homepage', 'iori' ); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="border-bottom bd-grey-80 mt-110 mb-0"></div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();
