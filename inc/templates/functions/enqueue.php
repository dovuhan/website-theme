<?php


/* Enqueue Custom Fonts Script */
function iori_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	* Translators: If there are characters in your language that are not supported
	* by Chivo, translate this to 'off'. Do not translate into your own language.
	*/
	if ( 'off' !== _x( 'on', 'Chivo font: on or off', 'iori' ) ) {
		$fonts[] = 'Chivo';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg(
			array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			),
			'//fonts.bunny.net/css?family=chivo:700|manrope:400,500,700,800|shippori-mincho:700,800'
		);
	}

	return esc_url_raw( $fonts_url );
}


/* Now enque fonts for fontend */
function iori_scripts_styles() {
	wp_enqueue_style( 'iori-fonts', iori_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'iori_scripts_styles' );
/**
 * Iori Enqueue callback functions.
 *
 * @package  Iori
 */
/**
 * iori styles
 */
if ( ! function_exists( 'iori_enqueue_styles' ) ) {
	function iori_enqueue_styles() {
		$iori_css_optimization = iori_theme_option( 'iori_css_optimization' );

		if ( $iori_css_optimization ) {
			wp_enqueue_style( 'iori-styles', IORI_ASSETS . '/css/app.min.css', IORI_VERSION );
			wp_style_add_data( 'iori-styles', 'rtl', 'replace' );
		} else {
			$styles = array(
				'bootstrap'                           => 'plugins/bootstrap.css',
				'normalize'                           => 'vendors/normalize.css',
				'animate'                             => 'plugins/animate.css',
				'animate-min'                         => 'plugins/animate.min.css',
				'jquery-ui'                           => 'plugins/jquery-ui.css',
				'magnific-popup'                      => 'plugins/magnific-popup.css',
				'perfect-scollbar'                    => 'plugins/perfect-scrollbar.css',
				'select2-min'                         => 'plugins/select2.min.css',
				'slick'                               => 'plugins/slick.css',
				'swiper-bundle'                       => 'plugins/swiper-bundle.min.css',
				'uicons-regular-rounded'              => 'vendors/uicons-regular-rounded.css',
				'uicons-regular-straight'             => 'vendors/uicons-regular-straight.css',
				'main-style'                          => 'style.css',

			);

			foreach ( $styles as $index => $style ) {
				wp_register_style( $index, IORI_ASSETS . '/css/' . $style, IORI_VERSION );
				wp_enqueue_style( $index );
			}
		}

		wp_enqueue_style( 'iori-style', get_stylesheet_uri(), array(), IORI_VERSION );
		wp_style_add_data( 'iori-style', 'rtl', 'replace' );
	}
}


/**
 * iori scripts
 */
if ( ! function_exists( 'iori_enqueue_scripts' ) ) {
	function iori_enqueue_scripts() {
		$iori_js_optimization = iori_theme_option( 'iori_js_optimization' );
		if ( $iori_js_optimization ) {
			wp_enqueue_script( 'iori-app', IORI_ASSETS . '/js/app.min.js', array( 'jquery' ), IORI_VERSION, true );

			$l10n = array(
				'woo_installed' => iori_is_woo_active(),
				'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			);
			wp_localize_script( 'iori-app', 'iori_settings', $l10n );
		} else {
			$scripts = array(
				'bootstrap'             => 'vendors/bootstrap.bundle.min.js',
				'jquery-countdown'      => 'vendors/jquery.countdown.min.js',
				'jquery-elevatezoom'    => 'vendors/jquery.elevatezoom.js',
				'counterup'             => 'vendors/counterup.js',
				'pjax'                  => 'vendors/jquery.pjax.min.js',
				'isotope'               => 'vendors/isotope.js',
				'magnific-popup'        => 'vendors/magnific-popup.js',
				'modernizr'             => 'vendors/modernizr-3.6.0.min.js',
				'noUISlider'            => 'vendors/noUISlider.js',
				'perfect-scrollbar-min' => 'vendors/perfect-scrollbar.min.js',
				'scrollup'              => 'vendors/scrollup.js',
				'select2'               => 'vendors/select2.min.js',
				'slick'                 => 'vendors/slick.js',
				'slider'                => 'vendors/slider.js',
				'swiper-bundle'         => 'vendors/swiper-bundle.min.js',
				'waypoints'             => 'vendors/waypoints.js',
				'wow'                   => 'vendors/wow.js',
				'gsap'                  => 'vendors/gsap.min.js',
				'ali-animation'         => 'ali-animation.js',
				'iori-main'             => 'main.js',
			);

			foreach ( $scripts as $key => $script ) {
				wp_enqueue_script( $key, IORI_ASSETS . '/js/' . $script, array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );
			}

			$l10n = array(
				'woo_installed' => iori_is_woo_active(),
				'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			);
			wp_localize_script( 'iori-custom', 'iori_settings', $l10n );
		}

		if ( iori_theme_option( 'iori_quick_view_variable' ) ) {
			wp_enqueue_script( 'wc-add-to-cart-variation', false, array(), wp_get_theme()->get( 'Version' ) );
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}



if ( ! function_exists( 'iori_enqueue' ) ) {
	/**
	 * Enqueues styles and scripts used by the theme
	 */
	function iori_enqueue() {
		// Enqueue styles
		iori_enqueue_styles();

		// Enqueue scripts
		iori_enqueue_scripts();
	}
}

/**
 * iori admin scrirpts and styles
 */
if ( ! function_exists( 'iori_enqueue_admin_style' ) ) {

	function iori_enqueue_admin_style() {
		if ( is_admin() ) {
			wp_enqueue_style( 'iori-admin-style', IORI_ADMIN_URI . 'css/admin.css', array(), IORI_VERSION );
		}
	}
}


if ( ! function_exists( 'iori_admin_enqueue' ) ) {
	/**
	 * Enqueues admin styles and scripts used by the theme
	 */
	function iori_admin_enqueue() {
		 // admin styles
		iori_enqueue_admin_style();
	}
}
