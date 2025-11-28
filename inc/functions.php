<?php

/**
 * Iori Extra important functions.
 *
 * @package  Iori
 */

/**
 * Check if WooCommerce is active
 */
if ( ! function_exists( 'iori_is_woo_active' ) ) {
	function iori_is_woo_active() {
		 return class_exists( 'WooCommerce' );
	}
}

/**
 * Dokan is activate.
 */
if ( ! function_exists( 'iori_is_dokan_activated' ) ) {
	function iori_is_dokan_activated() {
		return class_exists( 'WeDevs_Dokan' ) ? true : false;
	}
}

if ( ! function_exists( 'iori_is_dokan_store_page' ) ) {
	function iori_is_dokan_store_page() {
		return function_exists( 'dokan_is_store_page' ) ? true : false;
	}
}

if ( ! function_exists( 'iori_is_dokan_pro_activated' ) ) {
	function iori_is_dokan_pro_activated() {
		return class_exists( 'Dokan_Pro' ) ? true : false;
	}
}


/**
 * Ajax request by pjax
 */
if ( ! function_exists( 'iori_is_ajax' ) ) {
	function iori_is_ajax() { 
		/**
		 * getallheaders
		 * 
		 * Core php function 'getallheaders'
		 * ref https://www.php.net/manual/en/function.getallheaders.php
		 */
		$headers_req = function_exists( 'getallheaders' ) ? getallheaders() : array();

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return 'wp-ajax';
		}

		if ( isset( $headers_req['x-pjax'] ) || isset( $headers_req['X-PJAX'] ) || isset( $headers_req['X-Pjax'] ) ) {
			return 'full-page';
		}

		if ( isset( $_REQUEST['woo_ajax'] ) ) {
			return 'fragments';
		}

		if ( function_exists( 'iori_is_pjax' ) && iori_is_pjax() ) {
			return true;
		}

		return false;
	}
}


/**
 * If plugin 'iori master' active for theme options.
 *
 * @return string|array|int
 */
function iori_theme_option( $theme_options ) {
	if ( function_exists( 'iori_get_option' ) ) {
		return iori_get_option( $theme_options );
	} else {
		return false;
	}
}

/**
 * If plugin 'iori master' active for customizer options.
 *
 * @return string|array|int
 */
function iori_customize_option( $customize_options ) {
	if ( function_exists( 'iori_get_customize_option' ) ) {
		return iori_get_customize_option( $customize_options );
	} else {
		return false;
	}
}


/**
 * track blog view
 */
if ( ! function_exists( 'iori_get_blog_view' ) ) {
	function iori_get_blog_view() {
		if ( apply_filters( 'iori_session', false ) ) {
			return iori_default_get_blog_view();
		} else {
			return iori_new_get_blog_view();
		}
	}
}

/**
 * track shop view
 */
if ( ! function_exists( 'iori_get_shop_view' ) ) {
	function iori_get_shop_view() {
		if ( iori_is_woo_active() ) {
			if ( apply_filters( 'iori_session', false ) ) {
				return iori_default_get_shop_view();
			} else {
				return iori_new_get_shop_view();
			}
		}
	}
}


/**
 * cookie setup
 */
if ( apply_filters( 'iori_session', false ) ) {
	add_action( 'iori_before_blog_page', 'iori_session', 100 );
	add_action( 'iori_before_shop_page', 'iori_session', 100 );
} else {
	add_action( 'init', 'iori_init_cookie', 100 );
}

/**
 * callback function | session
 */
if ( ! function_exists( 'iori_session' ) ) {
	function iori_session() {
		if ( ! class_exists( 'WC_Session_Handler' ) ) {
			return;
		}
		$s = WC()->session; // WC()->session
		if ( is_null( $s ) ) {
			return;
		}

		if ( isset( $_REQUEST['iori_shop_view'] ) ) {
			$s->set( 'iori_shop_view', $_REQUEST['iori_shop_view'] );
		}

		if ( isset( $_REQUEST['iori_grid_list'] ) ) {
			$s->set( 'iori_grid_list', $_REQUEST['iori_grid_list'] );
		}
	}
}

if ( ! function_exists( 'iori_init_cookie' ) ) {
	function iori_init_cookie() {
		/**
		  * shop cookie
		  */
		if ( isset( $_REQUEST['iori_shop_view'] ) ) {
			setcookie( 'iori_shop_view', $_REQUEST['iori_shop_view'], 0, COOKIEPATH, COOKIE_DOMAIN, false, false );
		}
		/**
		 * blog cookie
		 */
		if ( isset( $_REQUEST['iori_grid_list'] ) ) {
			setcookie( 'iori_grid_list', $_REQUEST['iori_grid_list'], 0, COOKIEPATH, COOKIE_DOMAIN, false, false );
		}
	}
}


/**
 * shop view session or without sesson
 */
if ( ! function_exists( 'iori_default_get_shop_view' ) ) {
	function iori_default_get_shop_view() {
		if ( ! class_exists( 'WC_Session_Handler' ) ) {
			return;
		}
		$s = WC()->session; // WC()->session
		if ( is_null( $s ) ) {
			return iori_theme_option( 'iori_shop_view' );
		}

		if ( isset( $_REQUEST['iori_shop_view'] ) ) {
			return $_REQUEST['iori_shop_view'];
		} elseif ( $s->__isset( 'iori_shop_view' ) ) {
			return $s->__get( 'iori_shop_view' );
		} else {
			$shop_view = iori_theme_option( 'iori_shop_view' );
			if ( is_shop() && $shop_view == 'grid' ) {
				return 'grid';
			} elseif ( is_shop() && $shop_view == 'list' ) {
				return 'list';
			} else {
				return $shop_view;
			}
		}
	}
}

if ( ! function_exists( 'iori_new_get_shop_view' ) ) {
	function iori_new_get_shop_view() {
		if ( isset( $_REQUEST['iori_shop_view'] ) ) {
			return $_REQUEST['iori_shop_view'];
		} elseif ( isset( $_COOKIE['iori_shop_view'] ) ) {
			return $_COOKIE['iori_shop_view'];
		} else {
			$shop_view = iori_theme_option( 'iori_shop_view' );
			if ( is_shop() && $shop_view == 'grid' ) {
				return 'grid';
			} elseif ( is_shop() && $shop_view == 'list' ) {
				return 'list';
			} else {
				return $shop_view;
			}
		}
	}
}


/**
 * blog view session or without sesson
 */
if ( ! function_exists( 'iori_default_get_blog_view' ) ) {
	function iori_default_get_blog_view() {
		if ( ! class_exists( 'WC_Session_Handler' ) ) {
			return;
		}
		$s = WC()->session; // WC()->session
		if ( is_null( $s ) ) {
			return iori_theme_option( 'iori_grid_list' );
		}

		if ( isset( $_REQUEST['iori_grid_list'] ) ) {
			return $_REQUEST['iori_grid_list'];
		} elseif ( $s->__isset( 'iori_grid_list' ) ) {
			return $s->__get( 'iori_grid_list' );
		} else {
			$blog_view = iori_theme_option( 'iori_grid_list' );
			if ( 1 == $blog_view ) {
				return true;
			} elseif ( 0 == $blog_view ) {
				return false;
			} else {
				return $blog_view;
			}
		}
	}
}

/**
 * get blog view
 */
if ( ! function_exists( 'iori_new_get_blog_view' ) ) {
	function iori_new_get_blog_view() {
		if ( isset( $_REQUEST['iori_grid_list'] ) ) {
			return $_REQUEST['iori_grid_list'];
		} elseif ( isset( $_COOKIE['iori_grid_list'] ) ) {
			return $_COOKIE['iori_grid_list'];
		} else {
			$blog_view = iori_theme_option( 'iori_grid_list' );
			if ( 1 == $blog_view ) {
				return true;
			} elseif ( 0 == $blog_view ) {
				return false;
			} else {
				return $blog_view;
			}
		}
	}
}

/**
 * Reset iori loop
 */
if ( ! function_exists( 'iori_reset_loop' ) ) {
	function iori_reset_loop() {
		unset( $GLOBALS['iori_loop'] );
		iori_setup_loop();
	}
	add_action( 'woocommerce_after_shop_loop', 'iori_reset_loop', 1000 );
	add_action( 'loop_end', 'iori_reset_loop', 1000 );
}

/**
 * Get loop prop
 */
if ( ! function_exists( 'iori_loop_prop' ) ) {
	function iori_loop_prop( $prop, $default = '' ) {
		iori_setup_loop();

		return isset( $GLOBALS['iori_loop'], $GLOBALS['iori_loop'][ $prop ] ) ? $GLOBALS['iori_loop'][ $prop ] : $default;
	}
}

/**
 * Set loop prop
 */
if ( ! function_exists( 'iori_set_loop_prop' ) ) {
	function iori_set_loop_prop( $prop, $value = '' ) {
		if ( ! isset( $GLOBALS['iori_loop'] ) ) {
			iori_setup_loop();
		}

		$GLOBALS['iori_loop'][ $prop ] = $value;
	}
}


/**
 * Setup loop
 */
if ( ! function_exists( 'iori_setup_loop' ) ) {
	function iori_setup_loop( $args = array() ) {
		if ( isset( $GLOBALS['iori_loop'] ) ) {
			return; // If the loop has already been setup, fail.
		}

		$default_args = array(
			'products_view'             => iori_get_shop_view(),
			'blogs_view'                => iori_get_blog_view(),
		);

		$GLOBALS['iori_loop'] = wp_parse_args( $args, $default_args );
	}
	add_action( 'woocommerce_before_shop_loop', 'iori_setup_loop', 10 );
	add_action( 'wp', 'iori_setup_loop', 50 );
	add_action( 'loop_start', 'iori_setup_loop', 10 );
}


/**
 * ------------------------------------------------------------------------------------------------
 * Register plugins necessary for theme
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'iori_register_required_plugins' ) ) {
	function iori_register_required_plugins() { 
		$plugins = array(

			// This is an example of how to include a plugin pre-packaged with a theme.
			array(
				'name'               => 'Elementor', // The plugin name.
				'slug'               => 'elementor', // The plugin slug (typically the folder name).
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			),

			array(
				'name'               => 'Iori Master', // The plugin name.
				'slug'               => 'iori-master', // The plugin slug (typically the folder name).
				'source'             => IORI_INC . 'plugins/iori-master.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => IORI_VERSION, // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),

			array(
				'name'      => 'WooCommerce',
				'slug'      => 'woocommerce',
				'required'  => true,
			),

			array(
				'name'      => 'Contact Form 7',
				'slug'      => 'contact-form-7',
				'required'  => false,
			),

			array(
				'name'      => 'MailChimp for WordPress',
				'slug'      => 'mailchimp-for-wp',
				'required'  => false,
			),

			// !todo
			// array(
			// 'name'      => 'TI WooCommerce Wishlist',
			// 'slug'      => 'ti-woocommerce-wishlist',
			// 'required'  => false,
			// ),

		);

		$config = array(
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'iori' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'iori' ),
				'installing'                      => 'Installing Plugin: %s', // %s = plugin name.
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'iori' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'iori' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'iori' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'iori' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'iori' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'iori' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'iori' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'iori' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'iori' ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'iori' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'iori' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'iori' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'iori' ),
				'complete'                        => 'All plugins installed and activated successfully. %s', // %s = dashboard link.
				'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			),
		);

		tgmpa( $plugins, $config );
	}

	add_action( 'tgmpa_register', 'iori_register_required_plugins' );
}
