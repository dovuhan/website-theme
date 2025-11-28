<?php
/**
 * Shop header.
 *
 * @since 1.0
 * @package iori
 */

/**
 * Woocommerce Default loop column
 *
 * @param int Original value
 * @return int New number of columns
 */
if ( ! function_exists( 'iori_loop_columns' ) ) {
	function iori_loop_columns() {
		return iori_get_product_count();
	}
}


if ( ! function_exists( 'iori_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 */
	function iori_woocommerce_wrapper_before() {
		$wrapper = 'page-detail-wrapper container';
		
		$display_none                 = '';
		$iori_shop_breadcrumb_section = iori_theme_option( 'iori_shop_breadcrumb_section' );
		$iori_shop_breadcrumb_img     = iori_theme_option( 'iori_shop_breadcrumb_section_image' );
		$shop_items                   = iori_theme_option( 'iori_shop_cat' );
		if ( ! is_product() && is_shop() ) {
			$display_none = ' normal-shop-head';
		} elseif ( iori_is_dokan_store_page() ) {
			$display_none = ' dokan-section-top';
		}
		?>
		<?php
		if ( ! iori_is_ajax() && ! is_product() && $iori_shop_breadcrumb_section ) {
			?>
			<section class="section bg-7 box-banner-shop-grid" 
			<?php 
			if ( $iori_shop_breadcrumb_img ) {
				?>
				style="background-image: url(<?php echo esc_attr( $iori_shop_breadcrumb_img ); ?>);" <?php } ?>>
				<div class="container">
				<div class="banner-shop-grid"><span class="font-xl-bold color-grey-300 text-uppercase wow animate__animated animate__fadeIn" data-wow-delay=".0s">camera collection</span>
					<h2 class="color-brand-1 mt-15 mb-60 font-bold-800 wow animate__animated animate__fadeIn" data-wow-delay=".0s">Ready to capture every<br class="d-none d-lg-block">wonderful moment</h2>
					<ul class="list-categories">
					<?php 
					$i = 1;
					if ( $shop_items ) {
						foreach ( $shop_items as $shop_item ) { 
							?>
										<li class="wow animate__animated animate__fadeIn" data-wow-delay=".0<?php echo esc_attr( $i ); ?>s"><a class="btn btn-white-circle active" href="<?php echo esc_url( $shop_item['shop_cat_link'] ); ?>"><?php echo esc_html( $shop_item['shop_cat_title'] ); ?></a></li>
										<?php 
										$i++;
						}
					} 
					?>
				</ul>
				</div>
				</div>
			</section>
		<?php } ?>

		<?php 
		// important for ajaxify
		if ( function_exists( 'iori_is_pjax' ) && ! iori_is_ajax() && ! is_product() ) : 
			?>
			<div id="iori-ajax-wrapper">
		<?php elseif ( function_exists( 'iori_is_pjax' ) && iori_is_pjax() ) : ?>
			<?php _wp_render_title_tag(); ?>
		<?php endif ?>
		<div class="<?php echo esc_attr( $wrapper . $display_none ); ?>">
			<?php if ( $iori_shop_breadcrumb_section == false ) { ?>
				<h2><?php echo esc_html__( 'Shop', 'iori' ); ?></h2>
			<?php } ?>
		<?php
	}
}


if ( ! function_exists( 'iori_woocommerce_after_breadcrumb' ) ) {
	/**
	 * End Breadcrumb Content.
	 * */
	function iori_woocommerce_after_breadcrumb() {
		?>
			</div>
			<!-- ./page-title-wrapper -->
		<?php
	}
}

if ( ! function_exists( 'iori_woocommerce_before_product_header' ) ) {
	/**
	 * wrap product header with iori class
	 */
	function iori_woocommerce_before_product_header() {
		if ( woocommerce_product_loop() ) {  
			?>
			<?php do_action( 'iori_before_shop_page' ); ?>
			<div class="site container">
				<main id="primary" class="site-main">
					<div class="toolbar product-toolbar top-toolbar">
						<?php 
		} 
	}
}


if ( ! function_exists( 'iori_woocommerce_after_product_header' ) ) {
	/**
	 * End wrap product header with iori class
	 */
	function iori_woocommerce_after_product_header() {
		$iori_sorting      = iori_theme_option( 'iori_sorting' );
		$current_shop_view = iori_get_shop_view();
		if ( $iori_sorting == 'button' ) {
			?>
			<div class="sort-by">
				<span class="label"><?php esc_html_e( 'Sort by:', 'iori' ); ?></span>
				<a href="<?php echo esc_url( iori_shop_page_link( false ) ); ?>?orderby=price" class="action-sort"><?php esc_html_e( 'Price', 'iori' ); ?></a>
				<a href="<?php echo esc_url( iori_shop_page_link( false ) ); ?>?orderby=date" class="action-sort"><?php esc_html_e( 'Date', 'iori' ); ?></a>
				<a href="<?php echo esc_url( iori_shop_page_link( false ) ); ?>?orderby=name" class="action-sort"><?php esc_html_e( 'Name', 'iori' ); ?></a>
			</div>
		<?php } ?>
			<div class="view-mode">
				<a rel="nofollow" href="<?php echo add_query_arg( 'iori_shop_view', 'grid', iori_shop_page_link( true ) ); ?>" class="modes-mode mode-grid<?php echo ( 'grid' == $current_shop_view ) ? ' active' : ''; ?>" title="Grid"><span class="icon_grid-2x2"></span></a>
				<a rel="nofollow" href="<?php echo add_query_arg( 'iori_shop_view', 'list', iori_shop_page_link( true ) ); ?>" class="modes-mode mode-list<?php echo ( 'list' == $current_shop_view ) ? ' active' : ''; ?>" title="List"><span class="icon_ul"></span></a>
			</div>
			
		
		</div>
		<?php
	}
}



if ( ! function_exists( 'iori_woocommerce_before_product_section' ) ) {
	/**
	 * End wrap product section start
	 */
	function iori_woocommerce_before_product_section() {
		$iori_shop_view = iori_get_product_view();
		?>
		<div class="products-<?php echo esc_attr( $iori_shop_view ); ?>">
		<?php
	}
}


if ( ! function_exists( 'iori_woocommerce_after_product_section' ) ) {
	/**
	 * End wrap product section with end
	 */
	function iori_woocommerce_after_product_section() {        
		?>
		</div>
		<?php
	}
}



if ( ! function_exists( 'iori_woocommerce_before_product_item' ) ) {
	/**
	 * End wrap product section start
	 */
	function iori_woocommerce_before_product_item() {    
		$iori_shop_view = iori_get_product_view();

		?>
		<div class="product-item card-product <?php echo isset( $iori_shop_view ) && $iori_shop_view == 'grid' ? 'col-lg-3 col-md-6' : 'list-view'; ?>">
		<?php
	}
}


if ( ! function_exists( 'iori_woocommerce_after_product_item' ) ) {
	/**
	 * End wrap product section with end
	 */
	function iori_woocommerce_after_product_item() {       
		?>
		</div>
		<?php
	}
}


if ( ! function_exists( 'iori_woocommerce_before_shop_loop_item' ) ) {
	/**
	 * End wrap product image with iori class 'product-image'
	 */
	function iori_woocommerce_before_shop_loop_item() {        
		?>
		<div class="product-image card-image">
		<?php 
		$iori_shop_view = iori_get_product_view();
		
		?>
		<?php

	}
}


if ( ! function_exists( 'iori_woocommerce_after_shop_loop_item' ) ) {
	/**
	 * End product image with iori class 'product-image'
	 */
	function iori_woocommerce_after_shop_loop_item() {         
		?>
		</div>
		<!-- /.product-image -->
		<?php
	}
}



if ( ! function_exists( 'iori_woocommerce_before_shop_loop_item_title' ) ) {
	/**
	 * wrap product
	 * title, rating, price with iori class 'product-details'
	 */
	function iori_woocommerce_before_shop_loop_item_title() {
		$iori_shop_view = 'grid';
		
		$classes        = 'card-info';
		$iori_shop_view = iori_get_product_view();
		
		// list view only for shop page
		if ( is_shop() && $iori_shop_view == 'list' ) { 
			$classes = 'product-detail-info';
		}
		?>
		<div class="product-details">
			<div class="<?php echo esc_attr( $classes ); ?>">

		<?php
		if ( is_shop() && $iori_shop_view == 'list' ) {
			iori_wishlist_quick_view();
		}
	}
}


if ( ! function_exists( 'iori_woocommerce_after_shop_loop_item_title' ) ) {
	/**
	 * end product
	 * title, rating, price with iori class 'product-details'
	 */
	function iori_woocommerce_after_shop_loop_item_title() {
		
		?>
		</div> 
		<!-- /.product-detail-1st/2nd | product-detail-info -->
		<?php
	}
}



if ( ! function_exists( 'iori_woocommerce_before_cart' ) ) {
	/**
	 * wrap add to cart button
	 * with iori class 'product-details--hover'
	 */
	function iori_woocommerce_before_cart() {
		$iori_shop_view = 'grid';
		$iori_shop_view = iori_get_product_view();
		// shop page except
		$iori_shop_excerpt_list = iori_theme_option( 'iori_shop_excerpt_list' );
		$limit                  = $iori_shop_excerpt_list;
		if ( is_shop() && $iori_shop_view == 'list' ) { 
			?>
			<div class="short-description">
			<?php echo iori_excerpt( $limit ); ?>
			</div>
		<?php } else { ?>
			<div class="color-grey-300 font-xs">
				<?php echo iori_excerpt( $limit ); ?>
			</div>
			<div class="product-details--hover">
			<?php echo iori_swatches_list(); ?>
			<?php 
		} 
	}
}



if ( ! function_exists( 'iori_woocommerce_after_cart' ) ) {
	/**
	 * End add to cart button
	 * with iori class 'product-details--hover'
	 */
	function iori_woocommerce_after_cart() {
		$iori_shop_view = 'grid';
		$iori_shop_view = iori_get_product_view();
		
		if ( $iori_shop_view == 'grid' ) { 
			?>
		</div>
		<!-- /.product-details-hover -->
		<?php } ?>

		</div>
		<!-- /.product-details -->
		<?php
	}
}




if ( ! function_exists( 'iori_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 */
	function iori_woocommerce_wrapper_after() {
		$shop_layout = iori_get_shop_layout();
		$shop_bottom = iori_get_shop_bottom();
		if ( woocommerce_product_loop() ) {
			?>
			</main>
			<!-- #main-->
					<?php 
					if ( ! is_product() ) {
						
						if ( isset( $shop_layout ) && $shop_layout == 'right_sidebar' ) {
							get_sidebar( 'shop' );
						}
						if ( isset( $shop_layout ) && $shop_layout == 'left_sidebar' ) {
							get_sidebar( 'shop' );
						}
					}
					?>
				</div>
				<!-- /.site -->
				<?php
		} else {
			echo '</div>';
		}
		if ( $shop_bottom && ! is_product() ) {
			?>
				<section class="st-group-products">
					<div class="container">
						<div class="row">
							<div class="col-lg-3 col-sm-6 col-12 mg-bottom-40">
								<div class="list-widget-product">
									<div class="block-title">
										<h5 class="title"><?php esc_html_e( 'ON SALE PRODUCTS', 'iori' ); ?></h5>
									</div>
									<div class="block-content">
							<?php 
							$instance = array(
								'title'  => '',
								'number' => 3,
								'show'   => 'onsale',
							);
							$args     = array();
							the_widget( 'WC_Widget_Products', $instance, $args ); 
							// echo do_shortcode( '[sale_products columns="3" per_page="12"]' );
							?>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-sm-6 col-12 mg-bottom-40">
								<div class="list-widget-product">
									<div class="block-title">
										<h5 class="title"><?php esc_html_e( 'FEATURED PRODUCTS', 'iori' ); ?></h5>
									</div>
									<div class="block-content">
									<?php 
									$instance = array(
										'title'  => '',
										'number' => 3,
										'show'   => 'featured',
									);
									$args     = array();
									the_widget( 'WC_Widget_Products', $instance, $args ); 
									?>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-sm-6 col-12 mg-bottom-40">
								<div class="list-widget-product">
									<div class="block-title">
										<h5 class="title"><?php esc_html_e( 'TOP RATED PRODUCTS', 'iori' ); ?></h5>
									</div>
									<div class="block-content">
									<?php 
									$instance = array(
										'title'  => '',
										'number' => 3,
									);
									$args     = array();
									the_widget( 'WC_Widget_Top_Rated_Products', $instance, $args ); 
									?>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-sm-6 col-12 mg-bottom-40">
								<div class="list-widget-product">
									<div class="block-title">
										<h5 class="title"><?php esc_html_e( 'NEW ARRIVALS PRODUCTS', 'iori' ); ?></h5>
									</div>
									<div class="block-content">
									<?php 
									$instance = array(
										'title'   => '',
										'number'  => 3,
										'orderby' => 'date',
									);
									$args     = array();
									the_widget( 'WC_Widget_Products', $instance, $args ); 
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php } ?>
			<?php if ( ! iori_is_ajax() ) { ?>
			</div>
			<?php } ?>
			<?php 
			if ( iori_is_ajax() ) { 
				die();
			}
			?>
		<?php
	}
}
