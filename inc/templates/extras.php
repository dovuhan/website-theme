<?php
/**
 * extra theme functions
 * 
 * @package iori
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}


/**
 * Sidebar.
 */
function iori_sidebar() {
	$sidebar = iori_get_blog_layout();

	if ( isset( $sidebar ) && $sidebar == 'left_sidebar' || $sidebar == 'right_sidebar' ) {
		get_sidebar();
	}
}

/**
 * Filter content area's image.
 * ! todo 
 * hook filter 'the_content'
 *
 * @return string
 */
function iori_filter_lazyload_img( $content ) {
	return preg_replace_callback( '/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', 'iori_preg_lazyload_img', $content );
}

function iori_preg_lazyload_img( $img_match ) {
	// Replace the image source with lazy placeholder and add a custom attribute
	$img_replace = $img_match[1] . ' data-src' . substr( $img_match[2], 3 ) . $img_match[3];

	// Add 'lazyestload' to the class
	$img_replace = preg_replace( '/class\s*=\s*"/i', 'class="lozad ', $img_replace );

	// Add a no-script tag of the original element
	$img_replace .= '<noscript>' . $img_match[0] . '</noscript>';
	return $img_replace;
}

/**
 * Get blog view.
 */
function iori_blog_view() {
	
	$iori_grid_view = iori_get_blog_grid_list();
	
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
	
	if ( 1 == $iori_grid_view ) {
		$iori_grid_view = 'blogs-grid';
	} elseif ( 0 == $iori_grid_view ) {
		$iori_grid_view = 'blogs-list';
	}
	return $iori_grid_view;
}

/**
 * Excerpt limit.
 *
 * @param int    $limit
 * @param string $source
 * @return void
 */
function iori_excerpt( $limit, $source = null ) {
	
	$excerpt = $source == 'content' ? get_the_content() : get_the_excerpt();
	$excerpt = preg_replace( ' (\[.*?\])', '', $excerpt );
	$excerpt = strip_shortcodes( $excerpt );
	$excerpt = strip_tags( $excerpt );
	$excerpt = substr( $excerpt, 0, $limit );
	$excerpt = substr( $excerpt, 0, strripos( $excerpt, ' ' ) );
	$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
	$excerpt = $excerpt . '...';
	
	return $excerpt;
}

/**
 * Search form.
 */
function iori_search() {
	$iori_search_enable = iori_theme_option( 'iori_search_enable' );
	if ( $iori_search_enable ) {
		?>
	<div class="block block-search">
		<div class="block-title"><span class="icon_search"></span></div>
		<div class="block-content">
			<button type="button" class="close-canvas"><span class="icon_close"></span></button>
			<form class="form-minisearch needs-validation" action="<?php echo esc_url( home_url( '/' ) ); ?>" novalidate>
				<div class="form-subscribe form-input-group">
					<div class="input-group">
						<input type="text" name="s" class="form-control" required>
						<div class="invalid-feedback"><?php esc_html_e( 'Please enter any to search', 'iori' ); ?></div>
					</div>
					<div class="actions-toolbar">
						<button type="submit" class="btn btn-dark"><?php esc_html_e( 'Search', 'iori' ); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php } ?>
	<?php
}

/**
 * Get dy block custom post type.
 */
if ( ! function_exists( 'iori_get_dy_blocks' ) ) {
	function iori_get_dy_blocks( $new = false ) {
		$args         = array(
			'posts_per_page' => 500,
			'post_type'      => 'dy_block',
		);
		$blocks_posts = get_posts( $args );
		$array        = array();
		foreach ( $blocks_posts as $post ) :
			setup_postdata( $post );
			if ( $new ) {
				$array[ $post->ID ] = array(
					'name'  => $post->post_title,
					'value' => $post->ID,
				);
			} else {
				$array[ $post->post_title ] = $post->ID;
			}
		endforeach;
		wp_reset_postdata();
		return $array;
	}
}


/**
 * Comments callback function.
 */
function iori_comment( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? 'comment-item align-items-start' : 'comment-item align-items-start answer parent' ); ?> id="comment-<?php comment_ID(); ?>">
	<?php 
	if ( 'div' != $args['style'] ) { 
		?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php
	} 
	?>
	<div class="d-flex gap-2">
		<div class="comment-author vcard avartar">
		<?php 
		if ( $args['avatar_size'] != 0 ) {
			echo get_avatar( $comment, $args['avatar_size'] ); 
		} 
		?>
		</div>
		<div class="comment">
			<?php 
			if ( $comment->comment_approved == '0' ) { 
				?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'iori' ); ?></em><br/>
																		  <?php 
			} 
			?>
			<div class="comment-user playfair-display"><?php printf( __( '<cite class="fn">%s</cite>', 'iori' ), get_comment_author_link() ); ?></div>
			<div class="comment-content">
				<div class="comment-meta commentmetadata">
				<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php
					/* translators: 1: date, 2: time */
					printf( 
						esc_html__( '%1$s at %2$s', 'iori' ), 
						get_comment_date(),  
						get_comment_time() 
					); 
					?>
				</a>
				<?php 
				edit_comment_link( esc_html__( '(Edit)', 'iori' ), '  ', '' ); 
				?>
				</div>
				
				<?php comment_text(); ?>
				
				<div class="reply">
				<?php 
				comment_reply_link(
					array_merge( 
						$args, 
						array( 
							'add_below' => $add_below, 
							'depth'     => $depth, 
							'max_depth' => $args['max_depth'], 
						) 
					) 
				); 
				?>
					</div>
				</div>
			</div>
		</div>
		<?php 
		if ( 'div' != $args['style'] ) : 
			?>
			</div>
			<?php 
		endif;  
			
}


/*
 Display number navigation to next/previous set of posts when applicable.
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'iori_paging_nav' ) ) {

	function iori_paging_nav( $pages = '', $range = 2 ) {

		$showitems = ( $range * 1 ) + 1;

		global $paged;

		if ( empty( $paged ) ) {
			$paged = 1;
		}

		if ( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;

			if ( ! $pages ) {
				$pages = 1;
			}
		}

		if ( 1 != $pages ) {
			echo '
			<div class="toolbar bottom-toolbar"><ul class="pagination justify-content-center">';

			if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
				echo '<li class="page-item"><a class="page-link prev-post" href="' . get_pagenum_link( 1 ) . '"><span aria-hidden="true"><i class="arrow_left_alt"></i> Previous</span></a></li>';
			}

			for ( $i = 1; $i <= $pages; $i++ ) {
				if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
					$pagesed = ( $paged == $i ) ? "<li class=\"page-item active \"><a href='#' class=\"page-link \">" . $i . '</a></li>' : "<li class=\"page-item\"><a href='" . get_pagenum_link( $i ) . "' class='page-no pre page-link'>" . $i . '</a></li>';
					echo $pagesed;
				}
			}

			if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
				echo '<li class="page-item"><a class="page-link next-post" href="' . get_pagenum_link( $pages ) . '"><span aria-hidden="true">Next <i class="arrow_right_alt"></i></span></a></li>';
			}

			echo '</ul></div>';
		}
	}
}


if ( ! function_exists( 'iori_pagination' ) ) {
	
	function iori_pagination() {
		/**
		* Translators:
		* This text contains HTML to allow the text to be shorter on small screens.
		* The text inside the span with the class nav-short will be hidden on small screens.
		*/
		
		$prev_text = sprintf(
			'%s <span class="nav-prev-text">%s</span>',
			'<span aria-hidden="true">&larr;</span>',
			__( 'Newer <span class="nav-short">Posts</span>', 'iori' )
		);
		$next_text = sprintf(
			'<span class="nav-next-text">%s</span> %s',
			__( 'Older <span class="nav-short">Posts</span>', 'iori' ),
			'<span aria-hidden="true">&rarr;</span>'
		);
		
		$posts_pagination = get_the_posts_pagination(
			array(
				'mid_size'  => 1,
				'prev_text' => $prev_text,
				'next_text' => $next_text,
			)
		);
			
			// If we're not outputting the previous page link, prepend a placeholder with `visibility: hidden` to take its place.
		if ( strpos( $posts_pagination, 'prev page-numbers' ) === false ) {
			$posts_pagination = str_replace( '<div class="nav-links">', '<div class="nav-links"><span class="prev page-numbers placeholder" aria-hidden="true">' . $prev_text . '</span>', $posts_pagination );
		}
			
			// If we're not outputting the next page link, append a placeholder with `visibility: hidden` to take its place.
		if ( strpos( $posts_pagination, 'next page-numbers' ) === false ) {
			$posts_pagination = str_replace( '</div>', '<span class="next page-numbers placeholder" aria-hidden="true">' . $next_text . '</span></div>', $posts_pagination );
		}
			
		if ( $posts_pagination ) { 
			?>
				
				<div class="pagination-wrapper section-inner">
				
				<hr class="styled-separator pagination-separator is-style-wide" aria-hidden="true" />
				
				<?php echo '<div class="iori-pagination">' . $posts_pagination . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped during generation. ?>
				
				</div><!-- .pagination-wrapper -->
				
				<?php
		}
			
	}
}

// Estimated reading time.
function iori_reading_time() {
	global $post;
	$content     = get_post_field( 'post_content', $post->ID );
	$word_count  = str_word_count( strip_tags( $content ) );
	$readingtime = ceil( $word_count / 300 );
	if ( $readingtime == 1 ) {
		$timer = esc_html__( ' min read', 'iori' );
	} else {
		$timer = esc_html__( ' min read', 'iori' );
	}
	$totalreadingtime = '<span class="read-time">' . $readingtime . $timer . '</span>';
	return $totalreadingtime;
}

/**
 * Social share.
 */
function iori_social_share() {
	 $iori_social_share = iori_theme_option( 'iori_social_share' );
	// if ( $iori_social_share ) {
		$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); 
	?>
		<a href="http://www.facebook.com/sharer.php?u=<?php echo get_the_permalink( get_the_ID() ); ?>" target="_blank"><span class="icon-socials icon-facebook"></span></a>
		<a href="http://twitter.com/share?url=<?php echo get_the_permalink( get_the_ID() ); ?>&text=<?php echo get_the_title( get_the_ID() ); ?> target="_blank"><span class="icon-socials icon-twitter"></span></a>
		<a href="http://pinterest.com/pin/create/button/?url=<?php echo get_the_permalink( get_the_ID() ); ?>&media=<?php echo esc_url( $featured_img_url ); ?>&description=<?php echo get_the_title( get_the_ID() ); ?>" class="pin-it-button" count-layout="horizontal" target="_blank"><span class="icon-socials icon-pinterest">P</span></a>
		<?php
		// }
}


/**
 * Table of content.
 */
function iori_get_toc_shortcode( $content ) {
	// Parse toc list
	ob_start();
	$new_content = $content;
	$toc         = '';

	if ( is_single() ) {
		$list = array();
		$ids  = array();
		// Find all Headings from Content
		$headings = preg_match_all( '/<h\d[^>]*>.*?<\/h\d>/si', $content, $matches );
		if ( $headings > 0 && isset( $matches[0] ) ) {
			foreach ( $matches[0] as $k => $heading ) {
				// Getting the Heading Level
				preg_match_all( '/<h(\d)[^>]*>/si', $heading, $level );
				$level = $level[1][0] ?? 1;

				// update heading attributes
				$id  = '';
				$dom = new DOMDocument();
				$dom->loadHTML( $heading );
				$html = new DOMXPath( $dom );
				foreach ( $html->query( '//h1 | //h2 | //h3 | //h4 | //h5' ) as $el ) {
					// Get Heading ID
					$id = $el->getAttribute( 'id' ) ?? '';
					// Generate Heading ID if not exists
					if ( empty( $id ) ) {
						$id = str_replace( array( ' ', '.', ',' ), '-', trim( strtolower( strip_tags( $heading ) ) ) );
					}
					$i = 1;
					while ( true ) {
						if ( ! in_array( $id, $ids ) ) {
							$ids[] = $id;
							break;
						} else {
							$id = $id . '_' . ( $i++ );
						}
					}
					// Set Heading's Updated ID attribute
					$el->setAttribute( 'id', $id );
				}
				$new_heading = $dom->saveHTML();
				$new_content = str_replace( $heading, $new_heading, $new_content );

				$parent = false;
				// Locate and set the parent Heading
				if ( $level > 1 && ! empty( $list ) ) {
					$headingBeforeArr = array_slice( $list, 0, $k + 1 );
					krsort( $headingBeforeArr );
					foreach ( $headingBeforeArr as $key => $headingBefore ) {
						if ( $headingBefore['level'] < $level ) {
							$parent = $key;
							break;
						}
					}
				}
				// Add heading Item to array
				$list[] = array(
					'level'  => $level,
					'html'   => $heading,
					'parent' => $parent,
					'id'     => $id,
				);
			}

			/**
			 * Generate the Table of Content 
			 */
			if ( ! empty( $list ) ) {
				$toc .= "<div class='custom-toc-container'>";
				$toc .= "<div class='custom-toc-title'><h6>" . esc_html__( 'Table of Contents', 'iori' ) . '</h6></div>';
				$toc .= "<ul class='list-number custom-toc'>";
				foreach ( $list as $k => $row ) {
					if ( $row['parent'] !== false ) {
						continue;
					}
					$toc .= "<li class='custom-toc-item'>";
					$toc .= "<a href ='#{$row['id']}' class='custom-toc-item'>" . ( strip_tags( $row['html'] ) ) . '</a>';
					// Find Child Headings
					$toc .= iori_content_get_child( $list, $k );
					$toc .= '</li>';
				}
				$toc .= '</ul>';
				$toc .= '</div>';
			}
		}
	}
	return $toc . ob_get_clean();
}


//add_filter( 'the_content', 'iori_get_toc' );

function iori_get_toc( $content ) {
	$new_content = $content;
	if ( is_single() ) {
		$list = array();
		$ids  = array();
		// Find all Headings from Content
		$headings = preg_match_all( '/<h\d[^>]*>.*?<\/h\d>/si', $content, $matches );
		if ( $headings > 0 && isset( $matches[0] ) ) {
			foreach ( $matches[0] as $k => $heading ) {
				// Getting the Heading Level
				preg_match_all( '/<h(\d)[^>]*>/si', $heading, $level );
				$level = $level[1][0] ?? 1;
 
				// update heading attributes
				$id  = '';
				$dom = new DOMDocument();
				$dom->loadHTML( $heading );
				$html = new DOMXPath( $dom );
				foreach ( $html->query( '//h1 | //h2 | //h3 | //h4 | //h5' ) as $el ) {
					// Get Heading ID
					$id = $el->getAttribute( 'id' ) ?? '';
					// Generate Heading ID if not exists
					if ( empty( $id ) ) {
						$id = str_replace( array( ' ', '.', ',' ), '-', trim( strtolower( strip_tags( $heading ) ) ) );
					}
					$i = 1;
					while ( true ) {
						if ( ! in_array( $id, $ids ) ) {
							$ids[] = $id;
							break;
						} else {
							$id = $id . '_' . ( $i++ );
						}
					}
					// Set Heading's Updated ID attribute
					$el->setAttribute( 'id', $id );
				}
				$new_heading = $dom->saveHTML();
				$new_content = str_replace( $heading, $new_heading, $new_content );
 
				$parent = false;
				// Locate and set the parent Heading
				if ( $level > 1 && ! empty( $list ) ) {
					$headingBeforeArr = array_slice( $list, 0, $k + 1 );
					krsort( $headingBeforeArr );
					foreach ( $headingBeforeArr as $key => $headingBefore ) {
						if ( $headingBefore['level'] < $level ) {
							$parent = $key;
							break;
						}
					}
				}
				// Add heading Item to array
				$list[] = array(
					'level'  => $level,
					'html'   => $heading,
					'parent' => $parent,
					'id'     => $id,
				);
			}
		}   
	}
	return $new_content;
}
 
/**
 * Generate Sub-Headings for Table of Contents
 */
function iori_content_get_child( $list = array(), $parent = null ) {
	$child_content = '';
	if ( ! empty( $list ) && ! is_null( $parent ) ) {
		foreach ( $list as $k => $row ) {
			if ( ! is_numeric( $row['parent'] ) || $row['parent'] != $parent ) {
				continue;
			}
				$child_content .= "<li class='custom-toc-item'>";
				$child_content .= "<a href ='#{$row['id']}' class='custom-toc-item'>" . ( strip_tags( $row['html'] ) ) . '</a>';
				$child_content .= iori_content_get_child( $list, $k );
				$child_content .= '</li>';
		}
	}
	if ( ! empty( $child_content ) ) {
		$child_content = "<ul class='custom-toc'>{$child_content}</ul>";
	}
	return $child_content;
}



// Activate WordPress Maintenance Mode.
function iori_maintenance_mode() {
	$browser_coming_on_of = isset( $_GET['coming_soon'] ) ? $_GET['coming_soon'] : '';
	$coming_on_of         = iori_theme_option( 'coming_soon_on_off' );
	if ( $coming_on_of ) {
		if ( ! current_user_can( 'edit_themes' ) || ! is_user_logged_in() ) {
			wp_redirect( get_template_part( 'template-parts/coming', 'soon' ) );
			exit();
		}
	} elseif ( $browser_coming_on_of === 'true' ) {
		wp_redirect( get_template_part( 'template-parts/coming', 'soon' ) );
		exit();
	}
}
add_action( 'get_header', 'iori_maintenance_mode' );
