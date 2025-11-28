<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package iori
 */

get_header();
?>
<?php do_action( 'iori_before_blog_page' ); ?>
<div class="section mt-35">
	<div class="container">
		<div class="breadcrumbs wow animate__animated animate__fadeIn" data-wow-delay=".0s">
			<?php iori_breadcrumbs(); ?>
		</div>
	</div>
</div>
<div class="container">
	<div class="site">
		<main id="primary" class="site-main">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'single' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
		</main><!-- #main -->
		<?php iori_sidebar(); ?>
	</div>
</div>
<?php do_action( 'iori_before_footer' ); ?>

<?php
get_footer();
