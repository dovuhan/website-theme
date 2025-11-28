<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package iori
 */

get_header();
$iori_current_blog_view = iori_get_blog_view();
?>

<?php do_action( 'iori_after_header' ); ?>
<?php do_action( 'iori_before_blog_page' ); ?>

<div class="container">
	<div class="site">
		<main id="primary" class="site-main">
			<div class="box-list-blogs <?php echo iori_blog_view(); ?>">
				<div class="col-lg-12 text-center mb-80 mt-80">
				<h2 class="color-brand-1 mb-20 wow animate__ animate__fadeIn animated" data-wow-delay=".0s" style="visibility: visible; animation-delay: 0s; animation-name: fadeIn;"><?php echo esc_html__( 'Lastest Articles', 'iori' ); ?></h2>
				</div>
				<div class="row">
					<?php
					if ( have_posts() ) :

						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/**
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_type() );

						endwhile;

					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
					?>
				</div>
				<?php iori_paging_nav(); ?>
			</div>
		</main><!-- #main -->
		<?php iori_sidebar(); ?>
	</div>
</div>

<?php
/**
 * ajax ending
 */
if ( iori_is_ajax() ) {
	die();
}
?>
<?php do_action( 'iori_before_footer' ); ?>

<?php do_action( 'iori_footer_start' ); ?>
<?php get_footer(); ?>
