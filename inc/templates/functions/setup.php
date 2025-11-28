<?php
/**
 * Iori Setup functions
 *
 * @package  Iori
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function iori_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function iori_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// theme options
	$expand_content = iori_theme_option( 'iori_expand' );
	if ( $expand_content == true ) {
		$classes[] = 'guten-container';
	} else {
		$classes[] = 'no-guten-container';
	}

	$blog_layout = iori_get_blog_layout();
	
	if ( ! is_front_page() && is_home() || is_single() || is_archive() && ! is_shop() && ! is_product_category() ) {
		if ( isset( $blog_layout ) && $blog_layout == 'full_width' ) {
			$classes[] = 'full-width';
		} elseif ( isset( $blog_layout ) && $blog_layout == 'right_sidebar' ) {
			$classes[] = 'right-sidebar-active';
		} elseif ( isset( $blog_layout ) && $blog_layout == 'left_sidebar' ) {
			$classes[] = 'left-sidebar-active';
		}
	}

	
	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) && is_home() ) {
		$classes[] = 'no-sidebar';
	}
	
	return $classes;
}


/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @see mc_content_width()
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1170; /* pixels */
}

if ( ! function_exists( 'iori_content_width' ) ) {
	/**
	 * Adjust content_width value for image attachment template.
	 */
	function iori_content_width() {
		if ( is_attachment() && wp_attachment_is_image() ) {
			$GLOBALS['content_width'] = 1170; /* pixels */
		}
	}
}

if ( ! function_exists( 'iori_setup' ) ) {
	/**
	 * Sets up iori WordPress Theme
	 */
	function iori_setup() {		
		// Declare features supported by the theme
		iori_declare_theme_support();
		
		// Register Nav menus
		iori_register_nav_menus();
	}
}

if ( ! function_exists( 'iori_load_theme_textdomain' ) ) {
	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 */
	function iori_load_theme_textdomain() {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on iori, use a find and replace
		* to change 'iori' to the name of your theme in all the template files.
		*/
		// wp-content/themes/iori-child/languages/it_IT.mo
		load_theme_textdomain( 'iori', get_stylesheet_directory() . '/languages' );
		
		// wp-content/themes/iori/languages/it_IT.mo
		load_theme_textdomain( 'iori', get_template_directory() . '/languages' );
	}
}

add_action( 'after_setup_theme', 'iori_load_theme_textdomain' );

if ( ! function_exists( 'iori_declare_theme_support' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function iori_declare_theme_support() {        
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		
		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );
		
		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );
		
		/**
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
		
		/**
		* Custom background
		*/
		add_theme_support(
			'custom-background',
			apply_filters(
				'iori_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Extra small', 'iori' ),
					'shortName' => esc_html_x( 'XS', 'Font size', 'iori' ),
					'size'      => 16,
					'slug'      => 'extra-small',
				),
				array(
					'name'      => esc_html__( 'Small', 'iori' ),
					'shortName' => esc_html_x( 'S', 'Font size', 'iori' ),
					'size'      => 18,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Normal', 'iori' ),
					'shortName' => esc_html_x( 'M', 'Font size', 'iori' ),
					'size'      => 20,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Large', 'iori' ),
					'shortName' => esc_html_x( 'L', 'Font size', 'iori' ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Extra large', 'iori' ),
					'shortName' => esc_html_x( 'XL', 'Font size', 'iori' ),
					'size'      => 40,
					'slug'      => 'extra-large',
				),
				array(
					'name'      => esc_html__( 'Huge', 'iori' ),
					'shortName' => esc_html_x( 'XXL', 'Font size', 'iori' ),
					'size'      => 96,
					'slug'      => 'huge',
				),
				array(
					'name'      => esc_html__( 'Gigantic', 'iori' ),
					'shortName' => esc_html_x( 'XXXL', 'Font size', 'iori' ),
					'size'      => 144,
					'slug'      => 'gigantic',
				),
			)
		);

		// Custom background color.
		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'd1e4dd',
			)
		);

		// Editor color palette.
		$black     = '#000000';
		$dark_gray = '#28303D';
		$gray      = '#39414D';
		$green     = '#D1E4DD';
		$blue      = '#D1DFE4';
		$purple    = '#D1D1E4';
		$red       = '#E4D1D1';
		$orange    = '#E4DAD1';
		$yellow    = '#EEEADD';
		$white     = '#FFFFFF';

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Black', 'iori' ),
					'slug'  => 'black',
					'color' => $black,
				),
				array(
					'name'  => esc_html__( 'Dark gray', 'iori' ),
					'slug'  => 'dark-gray',
					'color' => $dark_gray,
				),
				array(
					'name'  => esc_html__( 'Gray', 'iori' ),
					'slug'  => 'gray',
					'color' => $gray,
				),
				array(
					'name'  => esc_html__( 'Green', 'iori' ),
					'slug'  => 'green',
					'color' => $green,
				),
				array(
					'name'  => esc_html__( 'Blue', 'iori' ),
					'slug'  => 'blue',
					'color' => $blue,
				),
				array(
					'name'  => esc_html__( 'Purple', 'iori' ),
					'slug'  => 'purple',
					'color' => $purple,
				),
				array(
					'name'  => esc_html__( 'Red', 'iori' ),
					'slug'  => 'red',
					'color' => $red,
				),
				array(
					'name'  => esc_html__( 'Orange', 'iori' ),
					'slug'  => 'orange',
					'color' => $orange,
				),
				array(
					'name'  => esc_html__( 'Yellow', 'iori' ),
					'slug'  => 'yellow',
					'color' => $yellow,
				),
				array(
					'name'  => esc_html__( 'White', 'iori' ),
					'slug'  => 'white',
					'color' => $white,
				),
			)
		);

		add_theme_support(
			'editor-gradient-presets',
			array(
				array(
					'name'     => esc_html__( 'Purple to yellow', 'iori' ),
					'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'purple-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to purple', 'iori' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $purple . ' 100%)',
					'slug'     => 'yellow-to-purple',
				),
				array(
					'name'     => esc_html__( 'Green to yellow', 'iori' ),
					'gradient' => 'linear-gradient(160deg, ' . $green . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'green-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to green', 'iori' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $green . ' 100%)',
					'slug'     => 'yellow-to-green',
				),
				array(
					'name'     => esc_html__( 'Red to yellow', 'iori' ),
					'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'red-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to red', 'iori' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $red . ' 100%)',
					'slug'     => 'yellow-to-red',
				),
				array(
					'name'     => esc_html__( 'Purple to red', 'iori' ),
					'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $red . ' 100%)',
					'slug'     => 'purple-to-red',
				),
				array(
					'name'     => esc_html__( 'Red to purple', 'iori' ),
					'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $purple . ' 100%)',
					'slug'     => 'red-to-purple',
				),
			)
		);
		
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		/**
		* Add support for core custom logo.
		*
		* @link https://codex.wordpress.org/Theme_Logo
		*/
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );

		// Add support for experimental cover block spacing.
		add_theme_support( 'custom-spacing' );

		// Add support for custom units.
		// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
		add_theme_support( 'custom-units' );

	}
}

/**
* Iori Resister nav menu
*/
if ( ! function_exists( 'iori_register_nav_menus' ) ) {
	function iori_register_nav_menus() {
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'iori-main-menu'   => esc_html__( 'Main Menu', 'iori' ),
				'iori-menu-footer' => esc_html__( 'Footer Menu', 'iori' ),
			)
		);
	}
}


/** 
* Allow SVG logo.
*/
if ( ! function_exists( 'iori_allow_upload_mimes' ) ) {
	function iori_allow_upload_mimes( $mimes ) {
		$mimes['svg']   = 'image/svg+xml';
		$mimes['svgz']  = 'image/svg+xml';
		$mimes['woff']  = 'font/woff';
		$mimes['woff2'] = 'font/woff2';
		$mimes['ttf']   = 'font/ttf';
		$mimes['eot']   = 'font/eot';
		// $mimes['svg'] = 'font/svg';
		// $mimes['woff'] = 'application/x-font-woff';
		// $mimes['ttf'] = 'application/x-font-ttf';
		// $mimes['eot'] = 'application/vnd.ms-fontobject';
		return $mimes;
	}
}
