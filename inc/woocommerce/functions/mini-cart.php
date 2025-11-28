<?php
/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'iori_woocommerce_header_cart' ) ) {
			iori_woocommerce_header_cart();
		}
	?>
 *
 * @since 1.0
 * @package iori
 */

if ( ! function_exists( 'iori_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function iori_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		iori_woocommerce_cart_link();
		$fragments['div.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}

if ( ! function_exists( 'iori_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function iori_woocommerce_cart_link() {
		?>
		<div class="block block-mini-cart cart-contents">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'iori' ),
				WC()->cart->get_cart_contents_count()
			);
			$item_count_text = ( ! empty( $item_count_text ) ) ? $item_count_text : '';
			?>
			<div class="amount icon_bag_alt iori-theme"></div> <div class="count"><?php echo esc_html( $item_count_text ); ?></div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'iori_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function iori_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'block-title current-menu-item';
		} else {
			$class = 'block-title ';
		}
		?>
		<ul id="site-header-cart" class="list-unstyled block block-mini-cart site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php iori_woocommerce_cart_link(); ?>
			</li>
			<li>
				<div class="block-content">
					<button type="button" class="close-canvas"><span class="icon_close"></span></button>
					<div class="mini-cart-wrapper">
						<div class="mini-cart-list">
						<?php
						$instance = array(
							'title' => '',
						);
						
						the_widget( 'WC_Widget_Cart', $instance );
						?>
						</div>
					</div>
				</div>
				
			</li>
		</ul>
		<?php
	}
}
