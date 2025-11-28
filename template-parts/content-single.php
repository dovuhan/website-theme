<?php

/**
 * Template part for displaying posts single
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package iori
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container">
		<div class="row">
			<div class="col-xl-9 col-lg-8">
				<div class="guten-container blog-item row">
					<div class="blog-item-details">
						<header class="entry-header page-detail-wrapper page-detail mt-40">
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

													<?php if ( has_post_thumbnail() ) { ?>
								<div class="blog-item-photo">
														<?php iori_post_thumbnail(); ?>
								</div>
							<?php } ?>

						<div class="blog-item-description fs_16">
							<div class="entry-content">
								<?php
								the_content(
									sprintf(
										wp_kses(
											/* translators: %s: Name of current post. Only visible to screen readers */
											__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'iori' ),
											array(
												'span' => array(
													'class' => array(),
												),
											)
										),
										wp_kses_post( get_the_title() )
									)
								);

								wp_link_pages(
									array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'iori' ),
										'after'  => '</div>',
									)
								);
								?>
							</div><!-- .entry-content -->
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-4">
				<div class="sidebar-author">
					<div class="box-author">
						<div class="author-info">
						<?php iori_post_author(); ?>
						</div>
					</div>
					<div class="mt-25">
							<div class="blog-item-category">
								<?php iori_entry_header(); ?>
							</div>
					</div>
					<div class="mt-50">
						<?php 
						if ( shortcode_exists( 'TOC' ) ) {
							echo do_shortcode( '[TOC]' );
						}
						?>
					</div>
					<div class="mt-50 d-flex align-item-center"> <strong class="font-xs-bold color-brand-1 mr-20"><?php echo esc_html__( 'Share', 'iori' ); ?></strong>
						<div class="list-socials mt-0 d-inline-block"> 
							<?php iori_social_share(); ?>
						</div>
					</div>
					<?php iori_sidebar(); ?>

				</div>
			</div>
		</div>


		<footer class="entry-footer container mg-top-60 mt-30">
			<div class="row justify-content-center mg-top-20 mg-bottom-50">
				<div class="col-lg-8 col-md-10 col-sm-12 col-12">
					<?php iori_entry_footer(); ?>
					
					<div class="blog-detail-next-prev mt-20">
						<?php
						the_post_navigation(
							array(
								'prev_text' => '<span class="move-link prev-blog nav-subtitle"><svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
							  </svg> %title',
								'next_text' => '<span class="move-link next-blog nav-subtitle">%title <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                              </svg></span></span>',
							)
						);
						?>

					</div>
				</div>

			</div>

		</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
