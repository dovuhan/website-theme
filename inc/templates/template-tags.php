<?php

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package iori
 */

// ! Breacdrumbs function
// ! Snippet from http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
/**********************************************************************/

if ( ! function_exists( 'iori_breadcrumbs' ) ) :
	function iori_breadcrumbs() { 
		/* === OPTIONS === */
		$text['home']     = esc_html__( 'Home', 'iori' ); // text for the 'Home' link
		$text['category'] = esc_html__( 'Archive by Category "%s"', 'iori' ); // text for a category page
		$text['search']   = esc_html__( 'Search Results for "%s" Query', 'iori' ); // text for a search results page
		$text['tag']      = esc_html__( 'Posts Tagged "%s"', 'iori' ); // text for a tag page
		$text['author']   = esc_html__( 'Articles Posted by %s', 'iori' ); // text for an author page
		$text['404']      = esc_html__( 'Error 404', 'iori' ); // text for the 404 page

		$show_current_post = 0; // 1 - show current post
		$show_current      = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
		$show_on_home      = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$show_home_link    = 1; // 1 - show the 'Home' link, 0 - don't show
		$show_title        = 1; // 1 - show the title for the links, 0 - don't show
		$delimiter         = ' '; // delimiter between crumbs
		$before            = '<li class="current">'; // tag before the current crumb
		$after             = '</li>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post;

		$home_link    = home_url( '/' );
		$link_before  = '<li typeof="v:Breadcrumb">';
		$link_after   = '</li>';
		$link_attr    = ' rel="v:url" property="v:title"';
		$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
		$parent_id    = $parent_id_2 = ( ! empty( $post ) && is_a( $post, 'WP_Post' ) ) ? $post->post_parent : 0;
		$frontpage_id = get_option( 'page_on_front' );

		if ( is_home() || is_front_page() ) {

			if ( $show_on_home == 1 ) {
				echo '<ul class="breadcrumbs p-0"><a href="' . $home_link . '"><svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
			  </svg>' . $text['home'] . '</a></ul>';
			}
		} else {

			echo '<ul class="breadcrumbs p-0" xmlns:v="http://rdf.data-vocabulary.org/#">';
			if ( $show_home_link == 1 ) {
				echo '<li><a href="' . esc_url( $home_link ) . '" rel="v:url" property="v:title"><svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
			  </svg>' . $text['home'] . '</a></li>';
				if ( $frontpage_id == 0 || $parent_id != $frontpage_id ) {
					echo esc_html( $delimiter );
				}
			}

			if ( is_category() ) {
				$this_cat = get_category( get_query_var( 'cat' ), false );
				if ( $this_cat->parent != 0 ) {
					$cats = get_category_parents( $this_cat->parent, true, $delimiter );
					if ( $show_current == 0 ) {
						$cats = preg_replace( "#^(.+)$delimiter$#", '$1', $cats );
					}
					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );
					if ( $show_title == 0 ) {
						$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					}
					echo wp_kses_post( $cats );
				}
				if ( $show_current == 1 ) {
					echo wp_kses_post( $before ) . sprintf( $text['category'], single_cat_title( '', false ) ) . wp_kses_post( $after );
				}
			} elseif ( is_search() ) {
				echo wp_kses_post( $before ) . sprintf( $text['search'], get_search_query() ) . wp_kses_post( $after );
			} elseif ( is_day() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
				echo wp_kses_post( $before ) . get_the_time( 'd' ) . wp_kses_post( $after );
			} elseif ( is_month() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo wp_kses_post( $before ) . get_the_time( 'F' ) . wp_kses_post( $after );
			} elseif ( is_year() ) {
				echo wp_kses_post( $before ) . get_the_time( 'Y' ) . wp_kses_post( $after );
			} elseif ( is_single() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;
					$slug      = ( isset( $slug['slug'] ) ) ? $slug['slug'] : '';
					printf( $link, $home_link . $slug . '/', $post_type->labels->singular_name );
					if ( $show_current == 1 ) {
						echo esc_html( $delimiter ) . $before . get_the_title() . $after;
					}
				} else {
					$cat = get_the_category();
					if ( $cat && isset( $cat[0] ) ) {
						$cat  = $cat[0];
						$cats = get_category_parents( $cat, true, $delimiter );
						if ( $show_current == 0 ) {
							$cats = preg_replace( "#^(.+)$delimiter$#", '$1', $cats );
						}
						$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
						$cats = str_replace( '</a>', '</a>' . $link_after, $cats );
						if ( $show_title == 0 ) {
							$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
						}
						echo wp_kses_post( $cats );
						echo wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
					}
				}
			} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
				$post_type = get_post_type_object( get_post_type() );
				if ( is_object( $post_type ) ) {
					echo wp_kses_post( $before ) . $post_type->labels->singular_name . wp_kses_post( $after );
				}
			} elseif ( is_attachment() ) {
				$parent = get_post( $parent_id );
				$cat    = get_the_category( $parent->ID );
				$cat    = $cat[0];
				if ( $cat ) {
					$cats = get_category_parents( $cat, true, $delimiter );
					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );
					if ( $show_title == 0 ) {
						$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					}
					echo wp_kses_post( $cats );
				}
				printf( $link, get_permalink( $parent ), $parent->post_title );
				if ( $show_current == 1 ) {
					echo esc_html( $delimiter ) . $before . get_the_title() . $after;
				}
			} elseif ( is_page() && ! $parent_id ) {
				if ( $show_current == 1 ) {
					echo wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
				}
			} elseif ( is_page() && $parent_id ) {
				if ( $parent_id != $frontpage_id ) {
					$breadcrumbs = array();
					while ( $parent_id ) {
						$page = get_page( $parent_id );
						if ( $parent_id != $frontpage_id ) {
							$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), get_the_title( $page->ID ) );
						}
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse( $breadcrumbs );
					for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
						echo wp_kses_post( $breadcrumbs[ $i ] );
						if ( $i != count( $breadcrumbs ) - 1 ) {
							echo esc_html( $delimiter );
						}
					}
				}
				if ( $show_current == 1 ) {
					if ( $show_home_link == 1 || ( $parent_id_2 != 0 && $parent_id_2 != $frontpage_id ) ) {
						echo esc_html( $delimiter );
					}
					echo wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
				}
			} elseif ( is_tag() ) {
				echo wp_kses_post( $before ) . sprintf( $text['tag'], single_tag_title( '', false ) ) . wp_kses_post( $after );
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo wp_kses_post( $before ) . sprintf( $text['author'], $userdata->display_name ) . wp_kses_post( $after );
			} elseif ( is_404() ) {
				echo wp_kses_post( $before ) . $text['404'] . wp_kses_post( $after );
			} elseif ( has_post_format() && ! is_singular() ) {
				echo get_post_format_string( get_post_format() );
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ' (';
				}
				echo esc_html__( 'Page', 'iori' ) . ' ' . get_query_var( 'paged' );
				if (
					is_category() || is_day() ||
					is_month() || is_year() || is_search() || is_tag() || is_author()
				) {
					echo ')';
				}
			}

			echo '</ul><!-- .breadcrumbs -->';
		}
	}
endif;


if ( ! function_exists( 'iori_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function iori_posted_on() {
		 $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'iori' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'iori_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function iori_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( ' %s', 'post author', 'iori' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

	}
endif;

if ( ! function_exists( 'iori_post_author' ) ) :
	/**
	 * Prints author information for the current author.
	 */
	function iori_post_author() {       ?>
		<?php
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( '%s', 'post author', 'iori' ),
			'<span class="author vcard font-md-bold color-brand-1 author-name"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		$user = wp_get_current_user();
		if ( $user && is_single() ) {
			?>
			<div class="author-post mg-top-20">
				<div class="avartar">
					<img class="img-fluid" src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" />
				</div>
				<div class="author-info">
					<div class="author-name playfair-display">
					<?php 
					echo '<span class="byline blog-item-author"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
					?>
					</div>
					<span class="date-post font-xs color-grey-500 department"><?php iori_posted_on(); ?><span class="font-xs color-grey-500 icon-read"><?php echo iori_reading_time(); ?></span></span>
					
				</div>
			</div>
			<?php
		}
	}
endif;

if ( ! function_exists( 'iori_entry_header' ) ) :
	/**
	 * Prints HTML with meta information for category
	 */
	function iori_entry_header() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ' ', 'iori' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links mr-10 mb-10">' . esc_html__( '%1$s', 'iori' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;


if ( ! function_exists( 'iori_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for tags and comments.
	 */
	function iori_entry_footer() { 
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'iori' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( '%1$s', 'iori' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'iori' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

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
	}
endif;

if ( ! function_exists( 'iori_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function iori_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;
