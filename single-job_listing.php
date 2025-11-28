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

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'job-listing' );

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
