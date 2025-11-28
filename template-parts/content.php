<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package iori
 */
// $col = '';

$iori_grid_view    = iori_get_blog_grid_list();
$iori_current_view = iori_loop_prop( 'blogs_view' );

if ( 1 == $iori_grid_view || 0 == $iori_grid_view ) {
	$iori_grid_view = $iori_current_view;
}

if ( 1 == $iori_current_view ) {
	$iori_grid_view = true;
}
if ( 0 == $iori_current_view ) {
	$iori_grid_view = false;
}


$col[] = 'col-lg-6 col-md-6 mb-20';


?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $col ); ?>>

	<div class="card-blog-grid card-blog-grid-3 hover-up">
		<?php if ( has_post_thumbnail() ) { ?>
		<div class="card-image">
			<?php iori_post_thumbnail(); ?>
			<div class="position-absolute top-0 end-0 pt-10">
				<?php iori_entry_header(); ?>
			</div>
		</div>
		
		<?php } ?>

		<div class="card-info">
			<a href="<?php echo the_permalink(); ?>">
				<h2 class="entry-title color-brand-1 mt-0 mb-0"><?php echo the_title(); ?></h2>
			</a>
			<div class="mb-25 mt-10"><span class="font-xs color-grey-500"><?php iori_posted_on(); ?></span><span class="font-xs color-grey-500 icon-read"><?php echo iori_reading_time(); ?></span></div>
			<p class="font-sm color-grey-500 mt-20">
				<?php
				// blog excerpt
				$iori_blog_excerpt_list = iori_theme_option( 'iori_blog_excerpt_list' );
				$limit                  = $iori_blog_excerpt_list;
				echo iori_excerpt( $limit );

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'iori' ),
						'after'  => '</div>',
					)
				);
				?>
			</p>
			<?php if ( ! has_post_thumbnail() ) { ?>
				<div class="category-without-fimg">
					<?php iori_entry_header(); ?>
				</div>
			<?php } ?>
		</div>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
