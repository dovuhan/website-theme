<?php if ( ! defined( 'IORI_DIR' ) ) {
	exit( 'No direct script access allowed' );}
/**
* Extra Block shortcode
*/

if ( ! function_exists( 'iori_extra_block_shortcode' ) ) {
	function iori_extra_block_shortcode( $atts ) {
		extract(
			shortcode_atts(
				array(
					'id' => 0,
				),
				$atts
			)
		);

		return iori_extra_block( $id );
	}
}
