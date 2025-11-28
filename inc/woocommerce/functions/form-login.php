<?php
/**
 * Login and registration form.
 *
 * @since 1.0
 * @package iori
 */

function iori_woocommerce_before_customer_login_form() {
	?>
		<div class="iori-login-reg">
		   <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
				<div class="log-reg-area font_oswald text-center">
					<span class="log-reg-btn login active">Login</span>
					<span class="log-reg-btn reginstration">Registration</span>
			</div>
			<?php endif; ?>
	 <?php
}



function iori_woocommerce_after_customer_login_form() {
	?>
		</div>
	<?php
}
 
