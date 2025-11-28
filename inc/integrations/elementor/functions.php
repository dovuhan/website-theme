<?php
/**
 * Iori Elementor supporting functions.
 *
 * @package  Iori
 */
use Elementor\Plugin;

/**
 * Elementor is installed.
 */
if ( ! function_exists( 'iori_is_elementor_installed' ) ) {
	/**
	 * Check if Elementor Plugin is activated.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	function iori_is_elementor_installed() {
		return did_action( 'elementor/loaded' );
	}
}


if ( ! function_exists( 'iori_elementor_get_content' ) ) {
	/**
	 * Retrieve builder content for display.
	 *
	 * @since 1.0.0
	 *
	 * @param integer $id The post ID.
	 *
	 * @return string
	 */
	function iori_elementor_get_content( $id ) {
		$inline_css = apply_filters( 'iori_elementor_content_inline_css', true );

		$content = Plugin::$instance->frontend->get_builder_content_for_display( $id, $inline_css );

		if ( $inline_css ) {
			wp_deregister_style( 'elementor-post-' . $id );
			wp_dequeue_style( 'elementor-post-' . $id );
		}

		return $content;
	}
}


/**
 * iori extra blocks
 */
function iori_extra_block( $id ) {
	$content = '';
	$post    = get_post( $id );
	if ( ! $post || $post->post_type != 'dy_block' ) {
		return;
	}
	
	if ( iori_is_elementor_installed() ) {
		$content = iori_elementor_get_content( $id );
	}
	return $content;
}

if ( ! function_exists( 'iori_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function iori_elementor_register_elementor_locations( $elementor_theme_manager ) {
		$elementor_theme_manager->register_location(
			'header',
			array(
				'is_core'         => false,
				'public'          => false,
				'label'           => esc_html__( 'Header', 'iori' ),
				'edit_in_content' => false,
			)
		);

		$elementor_theme_manager->register_location(
			'footer',
			array(
				'is_core'         => false,
				'public'          => false,
				'label'           => esc_html__( 'Footer', 'iori' ),
				'edit_in_content' => false,
			)
		);
	}

	add_action( 'elementor/theme/register_locations', 'iori_elementor_register_elementor_locations' );
}
