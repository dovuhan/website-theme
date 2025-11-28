<?php
/**
 * Wrap checkout form
 *
 * @since 1.0
 * @package iori
 */

function iori_woocommerce_checkout_before_customer_details() {
	?>
	<div class="iori-checkout-form col-xl-7 col-lg-8 col-md-12 col-12">
	<?php
}

/**
 * End checkout form
 */
function iori_woocommerce_checkout_after_customer_details() {  
	?>
	</div>
	<?php
}


/**
 * Wrap order review
 */
function iori_woocommerce_checkout_before_order_review_heading() {     
	?>
	<div class="iori-checkout col-xl-4 col-lg-4 col-md-12 col-12 ml-auto">
	<?php
}

/**
 * End order review
 */
function iori_woocommerce_checkout_after_order_review() {  
	?>
	</div>
	<?php
}


/**
 * Wrap payment option
 */
function iori_before_woocommerce_checkout_payment() {  
	?>
	<div class="iori-payment block block-subtotal">
		<div class="label h6"><?php esc_html_e( 'Payment Method', 'iori' ); ?></div>
	<?php
}

/**
 * End payment option
 */
function iori_after_woocommerce_checkout_payment() {   
	?>
	</div>
	<?php
}

