<?php
/**
 * Wrap breadcrumb inside class.
 *
 * @since 1.0
 * @package iori
 */

if ( ! function_exists( 'iori_before_wrap_single_product' ) ) {
	function iori_before_wrap_single_product() {
		?>
		<div class="container justify-content-between align-items-center">
		<?php
	}
}


if ( ! function_exists( 'iori_after_wrap_single_product' ) ) {
	function iori_after_wrap_single_product() {
		?>
		</div>
		</div>
		<div class="iori-shop-single">
		<?php
	}
}


/**
* wrapper summary
*/
if ( ! function_exists( 'iori_before_single_product_summary' ) ) {
	function iori_before_single_product_summary() {
		?>
		<div class="container">
		<div class="product-main-info row align-items-center mt-80 mb-80">
			<div class="single-img-gallery col-md-6">
		<?php
	}
}

if ( ! function_exists( 'iori_before_single_product_image' ) ) {
	function iori_before_single_product_image() {
		?>
		
		<?php
	}
}

if ( ! function_exists( 'iori_after_single_product_image' ) ) {
	function iori_after_single_product_image() {
		?>
		</div>

		<?php
	}
}



if ( ! function_exists( 'iori_before_single_single_add_to_cart' ) ) {
	function iori_before_single_single_add_to_cart() {
		?>
		<div class="product-form-options">
		<?php
	}
}

if ( ! function_exists( 'iori_after_single_single_add_to_cart' ) ) {
	function iori_after_single_single_add_to_cart() {
		?>
		</div>
		<?php
	}
}


// tabs
function iori_product_description_and_reviews() {
	the_content(); // Product Description
	comments_template(); // Product Reviews
}

/**
* Quatity form wrapper
* 
* before quantity
*/
if ( ! function_exists( 'iori_before_quantity' ) ) {
	function iori_before_quantity() {
		?>
		<div class="product-addtocart-form">
		<div class="qtity">
		<?php
	}
}


/**
* End Quantity wrapper
*/
if ( ! function_exists( 'iori_after_quantity' ) ) {
	function iori_after_quantity() {
		$product_metabox_settings = get_post_meta( get_the_ID(), '_iori_product_settings', true );
		$product_size_on_off      = isset( $product_metabox_settings['product_size_on_off'] ) ? $product_metabox_settings['product_size_on_off'] : '';
		$product_size_img         = isset( $product_metabox_settings['product_size_img'] ) ? $product_metabox_settings['product_size_img'] : '';
		$product_size_text        = isset( $product_metabox_settings['product_size_text'] ) ? $product_metabox_settings['product_size_text'] : '';

		if ( $product_size_on_off ) {
			?>
		<div class="product-list-options text size-option">
			<a href="<?php echo esc_url( $product_size_img ); ?>" class="popup-image"><?php echo esc_html( $product_size_text ); ?></a>
		</div>
		<?php } ?>
		</div>
		<?php
	}
}




/**
* end wrapper summary
*/
if ( ! function_exists( 'iori_after_single_product_summary' ) ) {
	function iori_after_single_product_summary() {
		?>
		</div>
		<!-- ./summary -->
		</div>
		<?php
	}
}



/**
 * wrap tab section
 */
function iori_woocommerce_before_tabs() {  
	?>
	<div class="st-product-details">
		<div class="container">
			<div class="product-details-tab pt-80">
			<div class="content-heading">
				<h2 class="title"><?php esc_html_e( 'DESCRIPTION', 'iori' ); ?></h2>
			</div>
	<?php
}

/**
 * end tab section
 */
function iori_woocommerce_after_tabs() {
	?>
	</div>
	</div>
	</div>
	<!-- /.st-product-details -->
	
	<?php
}

/**
 * Related Products Args Filter
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function iori_woocommerce_related_products_args( $args ) {
	 $defaults = array(
		 'posts_per_page' => 3,
		 'columns'        => 3,
	 );

	 $args = wp_parse_args( $defaults, $args );

	 return $args;
}

/**
 * wrap related product section
 */
function iori_woocommerce_before_related() {   
	?>
	<section class="st-new-arrivals-3col st-ralated-items">
	<div class="container">
		<div class="products-widget">
			<div class="products-widget-content clear-margin-owl">
				<div id="new-products-widget2" class="owl-carousel products-grid">
	<?php
}


/**
 * end related product section
 */
function iori_woocommerce_after_related() {    
	?>
	</div>
	</div>
	</div>
	</div>
</section>
	<?php
}
