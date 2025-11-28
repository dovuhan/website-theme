<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package iori
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php iori_post_thumbnail(); ?>
	<div class="container">
		<div class="blog-item row">
			<div class="blog-item-details">
				<header class="entry-header page-detail-wrapper page-detail mt-40">
					<div class="blog-item-category">
						<?php iori_entry_header(); ?>
					</div>
					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title page-heading playfair-display">', '</h1>' );
					else :
						the_title( '<h2 class="entry-title blog-item-name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif;

					if ( 'post' === get_post_type() ) :
						?>
						<div class="blog-item-author entry-meta">
							<?php
							iori_posted_by();
							?>
						</div><!-- .entry-meta -->
					<?php endif; ?>
				</header><!-- .entry-header -->

				<div class="entry-content fs_16 clearfix">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'iori' ),
							'after'  => '</div>',
						)
					);
					?>
				</div><!-- .entry-content -->

				<?php if ( get_edit_post_link() ) : ?>
					<footer class="entry-footer">
						<?php
						edit_post_link(
							sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Edit <span class="screen-reader-text">%s</span>', 'iori' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								wp_kses_post( get_the_title() )
							),
							'<span class="edit-link">',
							'</span>'
						);
						?>
					</footer><!-- .entry-footer -->
				<?php endif; ?>
			</div>
		</div>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
