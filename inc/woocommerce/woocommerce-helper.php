<?php
/**
 * Wishlist and quick view.
 *
 * @since 1.0
 * @package iori
 */

// Get shop page layout options.
if ( ! function_exists( 'iori_get_shop_layout' ) ) {
	function iori_get_shop_layout() {
		return apply_filters( 'iori_shop_layout', 'left_sidebar' );
	}
}

// Get shop product view options.
if ( ! function_exists( 'iori_get_product_view' ) ) {
	function iori_get_product_view() {
		return apply_filters( 'iori_product_view', 'grid' );
	}
}

// Get number of products.
if ( ! function_exists( 'iori_get_product_count' ) ) {
	function iori_get_product_count() {
		return apply_filters( 'iori_product_count', 4 );
	}
}

// Quick View.
if ( ! function_exists( 'iori_get_quick_view' ) ) {
	function iori_get_quick_view() {
		return apply_filters( 'iori_quick_view', true );
	}
}

// Wishlist View.
if ( ! function_exists( 'iori_get_wishlist_view' ) ) {
	function iori_get_wishlist_view() {
		return apply_filters( 'iori_wishlist_view', true );
	}
}

// Shop Bottom View.
if ( ! function_exists( 'iori_get_shop_bottom' ) ) {
	function iori_get_shop_bottom() {
		return apply_filters( 'iori_shop_bottom', true );
	}
}

/**
 * Wishlist.
 */
function iori_wishlist_quick_view() {
	$quick_view    = iori_get_quick_view();
	$wishlist_view = iori_get_wishlist_view();
	?>
	<div class="quick-wishlist">
	<?php 
	// 3rd party plugin 'ti wishlist'.
	if ( $wishlist_view ) { 
		if ( shortcode_exists( 'ti_wishlists_addtowishlist' ) ) { 
			?>
		<div class="add-to-wishlist"><div class="icon_heart"><?php echo do_shortcode( '[ti_wishlists_addtowishlist]' ); ?></div></div>
		<?php } ?>
	<?php } ?>
	
	</div>
	<?php
}


/**
* Ajax load Quick View.
*/
/*
------------------------------------------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_product_quick_view', 'iori_product_quick_view' );
add_action( 'wp_ajax_product_quick_view', 'iori_product_quick_view' );
function iori_product_quick_view( $id = false ) {
	
	if ( isset( $_GET['id'] ) ) {
		$id = sanitize_text_field( (int) $_GET['id'] );
	}
	if ( ! $id || ! iori_is_woo_active() ) {
		return;
	}

	$the_query = new WP_Query(
		array(
			'post_type'      => 'product',
			'posts_per_page' => 1,
			'post__in'       => array( $id ),
		)
	);
	
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
				get_template_part( 'woocommerce/quick-view/quickview', 'content' );
		}
	} else {
		echo '<div id="postdata">' . esc_html__( 'Didnt find anything', 'iori' ) . '</div>';
	}
	wp_reset_postdata(); 
	die();
}


/**
* Show attribute swatches list
* ===============================================================
*/
if ( ! function_exists( 'iori_swatches_list' ) ) {
	function iori_swatches_list( $attribute_name = false ) {
		global $product;
		
		$id = $product->get_id();
		
		if ( empty( $id ) || ! $product->is_type( 'variable' ) ) {
			return false;
		}
		
		if ( ! $attribute_name ) {
			$product_attr   = get_post_meta( get_the_ID(), '_iori_product_settings', true );
			$attribute_name = isset( $product_attr['product_attr'] ) ? $product_attr['product_attr'] : '';
		}
		
		if ( empty( $attribute_name ) ) {
			return false;
		}
		
		// Swatches cache
		$cache          = apply_filters( 'iori_swatches_cache', true );
		$transient_name = 'iori_swatches_cache_' . $id;
		
		if ( $cache ) {
			$available_variations = get_transient( $transient_name );
		} else {
			$available_variations = array();
		}
		
		if ( ! $available_variations ) {
			$available_variations = $product->get_available_variations();
			if ( $cache ) {
				set_transient( $transient_name, $available_variations, apply_filters( 'iori_swatches_cache_time', WEEK_IN_SECONDS ) );
			}
		}
		
		if ( empty( $available_variations ) ) {
			return false;
		}
		
		$swatches_to_show = iori_get_option_variations( $attribute_name, $available_variations, false, $id );
		
		if ( empty( $swatches_to_show ) ) {
			return false;
		}
		$out = '';
		
		$out .= '<div class="product-list-options image">';
		
		$swatch_size = iori_wc_get_attribute_term( $attribute_name, 'swatch_size' );
		
		$terms                = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'slugs' ) );
		$swatches_to_show_tmp = $swatches_to_show;
		
		$swatches_to_show = array();
		
		foreach ( $terms as $id => $slug ) {
			if ( ! isset( $swatches_to_show_tmp[ $slug ] ) ) {
				continue;
			}
			$swatches_to_show[ $slug ] = $swatches_to_show_tmp[ $slug ];
		}
		
		$index = 0;
		
		foreach ( $swatches_to_show as $key => $swatch ) {
			$style        = $class = '';
			$swatch_limit = iori_theme_option( 'swatches_limit_count' ) ? iori_theme_option( 'swatches_limit_count' ) : 3;

			if ( count( $swatches_to_show ) > (int) $swatch_limit ) {
				if ( $index >= $swatch_limit ) {
					$class .= ' iori-attr-hidden';
				}
				if ( $index === (int) $swatch_limit ) {
					$out .= '<div class="iori-attr-limit">+' . ( count( $swatches_to_show ) - (int) $swatch_limit ) . '</div>';
				}
			}
			
			$index++;
			
			if ( ! empty( $swatch['color'] ) ) {
				$style  = 'background-color:' . $swatch['color'];
				$class .= ' swatch-with-bg';
			} elseif ( isset( $swatch['image_src'] ) ) {
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $swatch['variation_id'] ), 'woocommerce_thumbnail' );
				if ( ! empty( $thumb ) ) {
					$style  = 'background-image: url(' . $thumb[0] . ')';
					$class .= ' swatch-with-bg iori-tooltip';
				}
			} elseif ( ! empty( $swatch['image'] ) ) {
				$style  = 'background-image: url(' . $swatch['image'] . ')';
				$class .= ' swatch-with-bg';
			} elseif ( ! empty( $swatch['size'] ) ) {
				$class .= ' text-only ';
			}
			
			$style .= ';';
			
			$data = '';
			
			if ( isset( $swatch['image_src'] ) ) {
				$data .= 'data-image-src="' . $swatch['image_src'] . '"';
				$data .= ' data-image-srcset="' . $swatch['image_srcset'] . '"';
				$data .= ' data-image-sizes="' . $swatch['image_sizes'] . '"';
				
				if ( ! $swatch['is_in_stock'] ) {
					$class .= ' variation-out-of-stock';
				}
			}
			
			$class .= ' swatch-size-default' . $swatch_size;
			
			$term = get_term_by( 'slug', $key, $attribute_name );

			if ( ! empty( $swatch['image'] ) ) {
				$out .= '<div data-toggle="tooltip" title="' . $term->name . '" class="option-item iori-tooltip' . esc_attr( $class ) . '" style="' . esc_attr( $style ) . '" ' . $data . '>' . $swatch['image'] . '</div>';
			} elseif ( ! empty( $swatch['size'] ) ) {
				$out .= '<div data-toggle="tooltip" title="' . $term->name . '" class="size-label option-item iori-tooltip' . esc_attr( $class ) . '" style="' . esc_attr( $style ) . '" ' . $data . '>' . $swatch['size'] . '</div>';
			} elseif ( ! empty( $swatch['color'] ) ) {
				$out .= '<div data-toggle="tooltip" title="' . $term->name . '" class="color-attr option-item iori-tooltip' . esc_attr( $class ) . '" style="' . esc_attr( $style ) . '" ' . $data . '>' . $swatch['color'] . '</div>';
			} else {
				$out .= '<div data-toggle="tooltip" title="' . $term->name . '" class="default-attr option-item iori-tooltip' . esc_attr( $class ) . '" style="' . esc_attr( $style ) . '" ' . $data . '>' . $term->name . '</div>';
			}
		}
		
		$out .= '</div>';
		
		return $out;
		
	}
}

/**
 * Veriation's options.
 */
if ( ! function_exists( 'iori_get_option_variations' ) ) {
	function iori_get_option_variations( $attribute_name, $available_variations, $option = false, $product_id = false ) {
		$swatches_to_show = array();
		
		foreach ( $available_variations as $key => $variation ) {
			$option_variation = array();
			$attr_key         = 'attribute_' . $attribute_name;
			if ( ! isset( $variation['attributes'][ $attr_key ] ) ) {
				return;
			}
			
			$val = $variation['attributes'][ $attr_key ]; // red green black ..
			
			if ( ! empty( $variation['image']['src'] ) ) {
				$option_variation = array(
					'variation_id' => $variation['variation_id'],
					'is_in_stock'  => $variation['is_in_stock'],
					'image_src'    => $variation['image']['src'],
					'image_srcset' => $variation['image']['srcset'],
					'image_sizes'  => $variation['image']['sizes'],
				);
			}
			
			// Get only one variation by attribute option value
			if ( $option ) {
				if ( $val != $option ) {
					continue;
				} else {
					return $option_variation;
				}
			} else {
				// Or get all variations with swatches to show by attribute name
				$swatch                   = iori_has_swatch( $product_id, $attribute_name, $val );
				$swatches_to_show[ $val ] = array_merge( $swatch, $option_variation );
			}
		}
		
		return $swatches_to_show;
		
	}
}


if ( ! function_exists( 'iori_has_swatch' ) ) {
	function iori_has_swatch( $id, $attr_name, $value ) {
		$swatches = array();
		
		$color = $image = $label = '';
		
		$term = get_term_by( 'slug', $value, $attr_name );

		if ( is_object( $term ) ) {
			$color = get_term_meta( $term->term_id, 'hm_color', true );
			$image = get_term_meta( $term->term_id, 'hm_image', true );
			$label = get_term_meta( $term->term_id, 'hm_label', true );
		}
		
		if ( $color != '' ) {
			$swatches['color'] = $color;
		}
		
		if ( $image != '' ) {
			$swatches['image'] = wp_get_attachment_image( $image, array( 55, 55 ) );
		}
		
		if ( $label != '' ) {
			$swatches['size'] = $label; 
		}
		
		return $swatches;
	}
}

if ( ! function_exists( 'iori_clear_swatches_cache' ) ) {
	function iori_clear_swatches_cache( $post_id ) {
		if ( ! apply_filters( 'iori_swatches_cache', true ) ) {
			return;
		}
		
		$transient_name = 'iori_swatches_cache_' . $post_id;
		
		delete_transient( $transient_name );
	}
	
	add_action( 'save_post', 'iori_clear_swatches_cache' );
}


if ( ! function_exists( 'iori_get_active_variations' ) ) {
	function iori_get_active_variations( $attribute_name, $available_variations ) {
		$results = array();
		
		if ( ! $available_variations ) {
			return $results;
		}
		
		foreach ( $available_variations as $variation ) {
			$attr_key = 'attribute_' . $attribute_name;
			if ( isset( $variation['attributes'][ $attr_key ] ) ) {
				$results[] = $variation['attributes'][ $attr_key ];
			}
		}
		
		return $results;
	}
}


/**
* Get attribute term function
*/
if ( ! function_exists( 'iori_wc_get_attribute_term' ) ) {
	function iori_wc_get_attribute_term( $attribute_name, $term ) {
		return get_option( 'iori_' . $attribute_name . '_' . $term );
	}
}

/**
 * shop page link
 */
if ( ! function_exists( 'iori_shop_page_link' ) ) {
	function iori_shop_page_link( $keep_query = false, $taxonomy = '' ) {
		// Base Link decided by current page
		if ( Automattic\Jetpack\Constants::is_defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) || is_shop() ) {
			$link = get_permalink( wc_get_page_id( 'shop' ) );
		} elseif ( is_product_category() ) {
			$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
		} elseif ( is_product_tag() ) {
			$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
		} elseif ( get_queried_object() ) {
			$queried_object = get_queried_object();
			$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		} else {
			$link = '';
		}

		if ( $keep_query ) {

			// Min/Max
			if ( isset( $_GET['min_price'] ) ) {
				$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
			}

			if ( isset( $_GET['max_price'] ) ) {
				$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
			}

			// Orderby
			if ( isset( $_GET['orderby'] ) ) {
				$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
			}
			
			if ( isset( $_GET['stock_status'] ) ) {
				$link = add_query_arg( 'stock_status', wc_clean( $_GET['stock_status'] ), $link );
			}

			/**
			 * Search Arg.
			 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
			 */
			if ( get_search_query() ) {
				$link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
			}

			// Post Type Arg
			if ( isset( $_GET['post_type'] ) ) {
				$link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );

				// Prevent post type and page id when pretty permalinks are disabled.
				if ( is_shop() ) {
					$link = remove_query_arg( 'page_id', $link );
				}
			}

			// Min Rating Arg
			if ( isset( $_GET['min_rating'] ) ) {
				$link = add_query_arg( 'min_rating', wc_clean( $_GET['min_rating'] ), $link );
			}

			// All current filters
			if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
				foreach ( $_chosen_attributes as $name => $data ) {
					if ( $name === $taxonomy ) {
						continue;
					}
					$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
					if ( ! empty( $data['terms'] ) ) {
						$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
					}
					if ( 'or' == $data['query_type'] ) {
						$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
					}
				}
			}
		}
		
		$link = apply_filters( 'iori_shop_page_link', $link, $keep_query, $taxonomy );
		
		if ( is_string( $link ) ) {
			return $link;
		} else {
			return '';
		}
	}
}

/**
 * my account pages
 */

if ( ! function_exists( 'iori_my_account_links' ) ) {
	function iori_my_account_links() {
		?>
		<div class="iori-my-account-links">
			<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				<div class="<?php echo esc_attr( $endpoint ); ?>-link">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
	add_action( 'woocommerce_account_dashboard', 'iori_my_account_links', 10 );
}
