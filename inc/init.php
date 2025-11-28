<?php
/**
 * Init all supporting files
 * 
 * @package iori
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'IORI_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'IORI_VERSION', '1.0.0' );
}

if ( ! defined( 'IORI_DIR' ) ) {
	define( 'IORI_DIR', get_template_directory() );
}

if ( ! defined( 'IORI_ADMIN_DIR' ) ) {
	define( 'IORI_ADMIN_DIR', get_template_directory() . '/inc/admin/' );
}

if ( ! defined( 'IORI_INC' ) ) {
	define( 'IORI_INC', get_template_directory() . '/inc/' );
}

if ( ! defined( 'IORI_URI' ) ) {
	define( 'IORI_URI', get_template_directory_uri() );
}

if ( ! defined( 'IORI_ASSETS' ) ) {
	define( 'IORI_ASSETS', IORI_URI . '/assets' );
}

if ( ! defined( 'IORI_ADMIN_URI' ) ) {
	define( 'IORI_ADMIN_URI', IORI_URI . '/inc/admin/assets/' );
}

if ( ! defined( 'IORI_MODULES_URI' ) ) {
	define( 'IORI_MODULES_URI', IORI_URI . '/inc/modules/' );
}

// @phpcs:disable
/**
 * Modules
 * Load different modules
 * ===========================================================
 */
require IORI_INC . 'modules/iori-nav-menu/iori-nav-walker.php';
require IORI_INC . 'modules/iori-nav-menu/nav-menu-images.php';
require IORI_INC . 'modules/variation/variation-swatcher.php';

/**
 * Functions
 * Include all supporting callback functions & hooks
 * ==========================================================
 */
require IORI_INC . 'functions.php';
require IORI_INC . 'templates/extras.php';
require IORI_INC . 'templates/template-tags.php';
require IORI_INC . 'templates/theme-helper.php';

// Theme's hook's callback templates.
require IORI_INC . 'templates/functions/enqueue.php';
require IORI_INC . 'templates/functions/setup.php';
require IORI_INC . 'templates/functions/layout.php';
require IORI_INC . 'templates/functions/ajax.php';
require IORI_INC . 'templates/functions/widgets.php';

// Hooks.
require IORI_INC . 'templates/hooks/enqueue.php';
require IORI_INC . 'templates/hooks/setup.php';
require IORI_INC . 'templates/hooks/layout.php';
require IORI_INC . 'templates/hooks/ajax.php';
require IORI_INC . 'templates/hooks/widgets.php'; 

//options 
require IORI_INC . 'options/templates/functions.php'; 
require IORI_INC . 'options/templates/hooks.php'; 

/**
 * Woocommerces
 * Includes all woo files.
 * ===========================================================
 */

if ( iori_is_woo_active() ) {

	//options 
	require IORI_INC . 'options/woocommerce/functions.php'; 
	require IORI_INC . 'options/woocommerce/hooks.php'; 

	// Hook's callback woocommerce.
	require IORI_INC . 'woocommerce/functions/setup.php';
	require IORI_INC . 'woocommerce/functions/shop.php';
	require IORI_INC . 'woocommerce/functions/shop-single.php';
	require IORI_INC . 'woocommerce/functions/mini-cart.php';
	require IORI_INC . 'woocommerce/functions/add-to-cart.php';
	require IORI_INC . 'woocommerce/functions/flash-sale.php';
	require IORI_INC . 'woocommerce/functions/checkout.php';
	require IORI_INC . 'woocommerce/functions/form-login.php';

	// Hooks.
	require IORI_INC . 'woocommerce/hooks/setup.php';
	require IORI_INC . 'woocommerce/hooks/shop.php';
	require IORI_INC . 'woocommerce/hooks/shop-single.php';
	require IORI_INC . 'woocommerce/hooks/mini-cart.php';
	require IORI_INC . 'woocommerce/hooks/add-to-cart.php';
	require IORI_INC . 'woocommerce/hooks/flash-sale.php';
	require IORI_INC . 'woocommerce/hooks/checkout.php';
	require IORI_INC . 'woocommerce/hooks/form-login.php';

	// Helper function.
	require IORI_INC . 'woocommerce/woocommerce-helper.php';


	// Dokan.
	if( iori_is_dokan_activated() ){
		require IORI_INC . 'integrations/dokan/functions/layout.php';
		require IORI_INC . 'integrations/dokan/hooks/layout.php';
	}
}


/**
 * Shortcodes.
 * ===========================================================
 */
require IORI_INC . 'shortcodes/extra-block.php';


/**
 * Load 3rd party plugin.
 * ===========================================================
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require IORI_INC . 'integrations/jetpack.php';
}
require IORI_INC . 'integrations/tgm-plugin-activation.php';
require IORI_INC . 'integrations/elementor/functions.php';

// @phpcs:enable
