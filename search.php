<?php

/**
 * The search template file.
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
		<main id="primary" class="site-main search-main">

			<div class="box-list-blogs <?php echo iori_blog_view(); ?>">
				<div class="pt-50 mb-30">
					<h3 class="color-brand-1"><?php single_post_title(); ?></h3>
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
							get_template_part( 'template-parts/content', 'search' );

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
