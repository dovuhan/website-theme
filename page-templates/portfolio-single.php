<?php

/**
 * Template Name: Portfolio single
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
	<main id="primary" class="site-main">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'portfolio' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
	</main><!-- #main -->

	<?php do_action( 'iori_before_footer' ); ?>

<?php
get_footer();
