var frame,
	iori = iori || {};

jQuery( document ).ready( function ( $ ) {
	'use strict';
	var wp = window.wp,
		$body = $( 'body' );

	$( '#term-hm_color' ).wpColorPicker();

	// Update attribute image
	$body.on( 'click', '.iori-upload-image-button', function ( event ) {
		event.preventDefault();

		var $button = $( this );

		// If the media frame already exists, reopen it.
		if ( frame ) {
			frame.open();
			return;
		}

		// Create the media frame.
		frame = wp.media.frames.downloadable_file = wp.media( {
			title   : iori.i18n.mediaTitle,
			button  : {
				text: iori.i18n.mediaButton
			},
			multiple: false
		} );

		// When an image is selected, run a callback.
		frame.on( 'select', function () {
			var attachment = frame.state().get( 'selection' ).first().toJSON();

			$button.siblings( 'input.iori-term-image' ).val( attachment.id );
			$button.siblings( '.iori-remove-image-button' ).show();
			$button.parent().prev( '.iori-term-image-thumbnail' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
		} );

		// Finally, open the modal.
		frame.open();

	} ).on( 'click', '.iori-remove-image-button', function () {
		var $button = $( this );

		$button.siblings( 'input.iori-term-image' ).val( '' );
		$button.siblings( '.iori-remove-image-button' ).show();
		$button.parent().prev( '.iori-term-image-thumbnail' ).find( 'img' ).attr( 'src', iori.placeholder );

		return false;
	} );

	// Toggle add new attribute term modal
	var $modal = $( '#iori-modal-container' ),
		$spinner = $modal.find( '.spinner' ),
		$msg = $modal.find( '.message' ),
		$metabox = null;

	$body.on( 'click', '.iori_add_new_attribute', function ( e ) {
		e.preventDefault();
		var $button = $( this ),
			taxInputTemplate = wp.template( 'iori-input-tax' ),
			data = {
				type: $button.data( 'type' ),
				tax : $button.closest( '.woocommerce_attribute' ).data( 'taxonomy' )
			};

		// Insert input
		$modal.find( '.iori-term-swatch' ).html( $( '#tmpl-iori-input-' + data.type ).html() );
		$modal.find( '.iori-term-tax' ).html( taxInputTemplate( data ) );

		if ( 'color' == data.type ) {
			$modal.find( 'input.iori-input-color' ).wpColorPicker();
		}

		$metabox = $button.closest( '.woocommerce_attribute.wc-metabox' );
		$modal.show();
	} ).on( 'click', '.iori-modal-close, .iori-modal-backdrop', function ( e ) {
		e.preventDefault();

		closeModal();
	} );

	// Send ajax request to add new attribute term
	$body.on( 'click', '.iori-new-attribute-submit', function ( e ) {
		e.preventDefault();

		var $button = $( this ),
			type = $button.data( 'type' ),
			error = false,
			data = {};

		// Validate
		$modal.find( '.iori-input' ).each( function () {
			var $this = $( this );

			if ( $this.attr( 'name' ) != 'slug' && !$this.val() ) {
				$this.addClass( 'error' );
				error = true;
			} else {
				$this.removeClass( 'error' );
			}

			data[$this.attr( 'name' )] = $this.val();
		} );

		if ( error ) {
			return;
		}

		// Send ajax request
		$spinner.addClass( 'is-active' );
		$msg.hide();
		wp.ajax.send( 'iori_add_new_attribute', {
			data   : data,
			error  : function ( res ) {
				$spinner.removeClass( 'is-active' );
				$msg.addClass( 'error' ).text( res ).show();
			},
			success: function ( res ) {
				$spinner.removeClass( 'is-active' );
				$msg.addClass( 'success' ).text( res.msg ).show();

				$metabox.find( 'select.attribute_values' ).append( '<option value="' + res.id + '" selected="selected">' + res.name + '</option>' );
				$metabox.find( 'select.attribute_values' ).change();

				closeModal();
			}
		} );
	} );

	/**
	 * Close modal
	 */
	function closeModal() {
		$modal.find( '.iori-term-name input, .iori-term-slug input' ).val( '' );
		$spinner.removeClass( 'is-active' );
		$msg.removeClass( 'error success' ).hide();
		$modal.hide();
	}
} );

