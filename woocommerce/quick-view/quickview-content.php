<?php
global $post, $product, $woocommerce;
$attachment_ids    = $product->get_gallery_image_ids();
$post_thumbnail_id = $product->get_image_id();


$attachment_count = count( $attachment_ids );
?>
<div <?php wc_product_class( 'catalog-product-view single-product position-relative quickview-mode bg-white', $product ); ?>>
	<div <?php wc_product_class( 'product-main-info', $product ); ?>>
			<div class="row">
				<div class="col-md-6 col-sm-12 col-12">
					<div id="owl-carousel-gallery" class="images">
						<div class="woocommerce-product-gallery__wrapper">
							<?php
							$attributes = array(
								'title' => esc_attr( get_the_title( get_post_thumbnail_id() ) ),
							);
							if ( has_post_thumbnail() ) {
								echo '<figure class="woocommerce-product-gallery__image">' . get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'woocommerce_single' ), $attributes ) . '</figure>';
								if ( $attachment_count > 0 ) {
									foreach ( $attachment_ids as $attachment_id ) {
										echo '<div class="product-image-wrap"><figure class="woocommerce-product-gallery__image">' . wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'woocommerce_single' ) ) . '</figure></div>';
									}
								}
							} else {
								echo '<figure class="woocommerce-product-gallery__image--placeholder">' . apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'iori' ) ), $post->ID ) . '</figure>';
							}
							?>
						</div>
					</div>

				</div>
				<div class="col-md-6 col-sm-12 col-12 summary entry-summary">
					<div class="summary-inner iori-scroll">
						<div class="iori-scroll-content product-details">
							<?php
							/**
							 * Hook: woocommerce_single_product_summary.
							 *
							 * @hooked woocommerce_template_single_title - 5
							 * @hooked woocommerce_template_single_rating - 10
							 * @hooked woocommerce_template_single_price - 10
							 * @hooked woocommerce_template_single_excerpt - 20
							 * @hooked woocommerce_template_single_add_to_cart - 30
							 * @hooked woocommerce_template_single_meta - 40
							 * @hooked woocommerce_template_single_sharing - 50
							 * @hooked WC_Structured_Data::generate_product_data() - 60
							 */
							do_action( 'woocommerce_single_product_summary' );
							?>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
