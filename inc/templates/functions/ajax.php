<?php
/**
 * Iori Ajax Callback function.
 *
 * @package  Iori
 */
/**
 * Load menu drodpwns with AJAX actions
 */
if ( ! function_exists( 'iori_load_extra_blocks_dropdowns_action' ) ) {
	function iori_load_extra_blocks_dropdowns_action() {
		$response = array(
			'status'  => 'error',
			'message' => 'Can\'t load blocks with AJAX',
			'data'    => array(),
		);

		if ( class_exists( 'WPBMap' ) ) {
			WPBMap::addAllMappedShortcodes();
		}

		if ( isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {
			$ids = iori_clean( $_POST['ids'] );
			foreach ( $ids as $id ) {
				$id      = (int) $id;
				$content = iori_get_html_block( $id );
				if ( ! $content ) {
					continue;
				}

				$response['status']      = 'success';
				$response['message']     = 'At least one block loaded';
				$response['data'][ $id ] = $content;
			}
		}

		echo json_encode( $response );

		die();
	}
}
