/* DentalKit Frontend Form — v2.0.0 */
/* global jQuery, DKForm */

( function ( $ ) {
	'use strict';

	$( '.dk-form' ).each( function () {
		const $form   = $( this );
		const $msg    = $form.find( '.dk-form-message' );
		const formId  = $form.data( 'form-id' );
		const nonce   = $form.data( 'nonce' );
		const $submit = $form.find( '.dk-submit-btn' );

		$submit.data( 'original-text', $submit.text() );

		$form.on( 'submit', function ( e ) {
			e.preventDefault();

			clearErrors( $form );
			$msg.hide().removeClass( 'dk-success dk-error' );

			if ( ! validateForm( $form ) ) {
				return;
			}

			// Build POST data
			const postData = {
				action:  'dk_submit_form',
				form_id: formId,
				_nonce:  nonce,
			};

			// Collect all field values
			$form.find( '.dk-field' ).each( function () {
				const $field  = $( this );
				const fieldId = $field.data( 'field-id' );
				if ( ! fieldId ) return;

				const $inputs = $field.find( 'input, select, textarea' );
				const type    = $inputs.first().attr( 'type' );

				if ( type === 'checkbox' ) {
					const vals = [];
					$field.find( 'input[type="checkbox"]:checked' ).each( function () {
						vals.push( $( this ).val() );
					} );
					postData[ 'dk_fields[' + fieldId + ']' ] = vals;
				} else if ( type === 'radio' ) {
					postData[ 'dk_fields[' + fieldId + ']' ] = $field.find( 'input[type="radio"]:checked' ).val() || '';
				} else {
					postData[ 'dk_fields[' + fieldId + ']' ] = $inputs.first().val() || '';
				}
			} );

			$submit.prop( 'disabled', true ).text( DKForm.i18n.submitting );

			$.ajax( {
				url:      DKForm.ajax_url,
				type:     'POST',
				data:     postData,
				success: function ( response ) {
					if ( response.success ) {
						$msg.addClass( 'dk-success' )
							.text( response.data.message || DKForm.i18n.submit_success )
							.show();
						$form.find( '.dk-form-fields, .dk-form-footer' ).slideUp( 300 );
					} else {
						if ( response.data && response.data.errors ) {
							showServerErrors( $form, response.data.errors );
						}
						const errMsg = ( response.data && response.data.message )
							? response.data.message
							: DKForm.i18n.submit_error;
						$msg.addClass( 'dk-error' ).text( errMsg ).show();
						$submit.prop( 'disabled', false ).text( $submit.data( 'original-text' ) );
					}
				},
				error: function () {
					$msg.addClass( 'dk-error' ).text( DKForm.i18n.submit_error ).show();
					$submit.prop( 'disabled', false ).text( $submit.data( 'original-text' ) );
				},
			} );
		} );

		// Clear field error on input
		$form.on( 'input change', 'input, select, textarea', function () {
			$( this ).removeClass( 'dk-error' );
			const $fieldWrap = $( this ).closest( '.dk-field' );
			$fieldWrap.find( '.dk-field-error' ).remove();
		} );
	} );

	// ── Validation ────────────────────────────────────────────────────────────
	function validateForm( $form ) {
		let valid = true;

		$form.find( '.dk-field' ).each( function () {
			const $fieldWrap = $( this );
			const fieldId    = $fieldWrap.data( 'field-id' );
			const isRequired = $fieldWrap.attr( 'aria-required' ) === 'true';

			if ( ! fieldId ) return;

			const $inputs = $fieldWrap.find( 'input, select, textarea' );
			const type    = $inputs.first().attr( 'type' );

			if ( type === 'checkbox' ) {
				if ( isRequired && $fieldWrap.find( 'input:checked' ).length === 0 ) {
					showFieldError( $fieldWrap, DKForm.i18n.required );
					valid = false;
				}
				return;
			}

			if ( type === 'radio' ) {
				if ( isRequired && $fieldWrap.find( 'input:checked' ).length === 0 ) {
					showFieldError( $fieldWrap, DKForm.i18n.required );
					valid = false;
				}
				return;
			}

			const $input = $inputs.first();
			const val    = ( $input.val() || '' ).trim();

			if ( isRequired && val === '' ) {
				showFieldError( $fieldWrap, DKForm.i18n.required );
				$input.addClass( 'dk-error' );
				valid = false;
				return;
			}

			if ( val !== '' ) {
				if ( type === 'email' && ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( val ) ) {
					showFieldError( $fieldWrap, DKForm.i18n.invalid_email );
					$input.addClass( 'dk-error' );
					valid = false;
					return;
				}

				if ( type === 'tel' && ! /^[0-9+\-\(\)\s]{7,20}$/.test( val ) ) {
					showFieldError( $fieldWrap, DKForm.i18n.invalid_phone );
					$input.addClass( 'dk-error' );
					valid = false;
					return;
				}
			}
		} );

		return valid;
	}

	function showFieldError( $fieldWrap, msg ) {
		$fieldWrap.find( '.dk-field-error' ).remove();
		$fieldWrap.append(
			'<span class="dk-field-error" role="alert">' + escHtml( msg ) + '</span>'
		);
	}

	function showServerErrors( $form, errors ) {
		$.each( errors, function ( fieldId, msg ) {
			const $fieldWrap = $form.find( '[data-field-id="' + fieldId + '"]' );
			if ( $fieldWrap.length ) {
				showFieldError( $fieldWrap, msg );
				$fieldWrap.find( 'input, select, textarea' ).first().addClass( 'dk-error' );
			}
		} );
	}

	function clearErrors( $form ) {
		$form.find( '.dk-field-error' ).remove();
		$form.find( '.dk-error' ).removeClass( 'dk-error' );
	}

	function escHtml( str ) {
		return $( '<div>' ).text( str ).html();
	}

} )( jQuery );
