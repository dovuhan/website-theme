;(function ( $ ) {
	'use strict';

	/**
	 * @TODO Code a function the calculate available combination instead of use WC hooks
	 */
	$.fn.iori_variation_swatches_form = function () {
		return this.each( function() {
			var $form = $( this ),
				clicked = null,
				selected = [];

			$form
				.addClass( 'swatches-support' )
				.on( 'click', '.swatch', function ( e ) {
					e.preventDefault();
					var $el = $( this ),
						$select = $el.closest( '.value' ).find( 'select' ),
						attribute_name = $select.data( 'attribute_name' ) || $select.attr( 'name' ),
						value = $el.data( 'value' );

					$select.trigger( 'focusin' );

					// Check if this combination is available
					if ( ! $select.find( 'option[value="' + value + '"]' ).length ) {
						$el.siblings( '.swatch' ).removeClass( 'selected' );
						$select.val( value ).change();
						$form.trigger( 'iori_no_matching_variations', [$el] );
						return;
					}

					clicked = attribute_name;

					if ( selected.indexOf( attribute_name ) === -1 ) {
						selected.push(attribute_name);
					}

					if ( $el.hasClass( 'selected' ) ) {
						$select.val( '' );
						$el.removeClass( 'selected' );

						delete selected[selected.indexOf(attribute_name)];
					} else {
						$el.addClass( 'selected' ).siblings( '.selected' ).removeClass( 'selected' );
						$select.val( value );
					}

					$select.change();
				} )
				.on( 'click', '.reset_variations', function () {
					$( this ).closest( '.variations_form' ).find( '.swatch.selected' ).removeClass( 'selected' );
					selected = [];
				} )
				.on( 'iori_no_matching_variations', function() {
					window.alert( wc_add_to_cart_variation_params.i18n_no_matching_variations_text );
				} );
		} );
	};

	$( function () {
		$( '.variations_form' ).iori_variation_swatches_form();
		$( document.body ).trigger( 'iori_initialized' );
	} );

	jQuery(document).ready(function(){
		var selectedImg = jQuery(".swatch-popup");
		
		if( jQuery(".swatch-popup").find('.selected') ) {
			var selectedhtml = jQuery("span.swatch.swatch-popup.selected").html();
			jQuery("#selected_popup_item").html(selectedhtml);
		}

		selectedImg.on('click', function() {
			if( jQuery(this).is('.selected')){
				// console.log("selected");
				jQuery("#selected_popup_item").empty();
			}else {
				// console.log("not selected");
				jQuery("#selected_popup_item").html(this.innerHTML);
			}

		});

		jQuery(".reset_variations").on('click', function() {
			jQuery("#selected_popup_item").empty();
		});
		
	});

	// Get the modal
	var modal = jQuery("#ji_popup_modal");
	if(modal.length > 0) {
		// Get the button that opens the modal
		var btn = document.getElementById("ji_popup");
		
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];
		
		// When the user clicks the button, open the modal 
		btn.onclick = function() {
			modal.style.display = "block";
		}
		
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}
		
		jQuery(".swatch-popup").on('click', function(){
			jQuery("#ji_popup_modal").hide();
		});
		
		jQuery("#selected_popup_item").on('click', function(){
			jQuery("#ji_popup_modal").show();
		});
		
		
		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	}
})( jQuery );