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

		$form.on( 'submit', function ( e ) {
			e.preventDefault();

			clearErrors( $form );

			if ( ! validateForm( $form ) ) return;

			const $fields = $form.find( '[name^="dk_fields"]' );
			const data    = { action: 'dk_submit_form', form_id: formId, _nonce: nonce };

			$fields.each( function () {
				const name = $( this ).attr( 'name' );
				const type = $( this ).attr( 'type' );

				if ( type === 'checkbox' || type === 'radio' ) {
					if ( $( this ).is( ':checked' ) ) {
						const key = name.replace( 'dk_fields[', '' ).replace( '][]', '' ).replace( ']', '' );
						if ( ! data[ 'dk_fields[' + key + '][]' ] ) {
							data[ 'dk_fields[' + key + '][]' ] = [];
						}
						data[ 'dk_fields[' + key + '][]' ].push( $( this ).val() );
					}
				} else {
					data[ name ] = $( this ).val();
				}
			} );

			$submit.prop( 'disabled', true ).text( DKForm.i18n.submitting );
			$msg.hide().removeClass( 'dk-success dk-error' );

			$.post( DKForm.ajax_url, data, function ( response ) {
				if ( response.success ) {
					$msg.addClass( 'dk-success' ).text( response.data.message ).show();
					$form.find( '.dk-form-fields' ).slideUp( 300 );
					$submit.hide();
				} else {
					if ( response.data && response.data.errors ) {
						showErrors( $form, response.data.errors );
					}
					$msg.addClass( 'dk-error' ).text(
						response.data && response.data.message
							? response.data.message
							: DKForm.i18n.submit_error
					).show();
					$submit.prop( 'disabled', false ).text( $submit.data( 'original-text' ) || 'Send Message' );
				}
			} ).fail( function () {
				$msg.addClass( 'dk-error' ).text( DKForm.i18n.submit_error ).show();
				$submit.prop( 'disabled', false );
			} );
		} );

		$submit.data( 'original-text', $submit.text() );
	} );

	function validateForm( $form ) {
		let valid = true;

		$form.find( '[required]' ).each( function () {
			const $el  = $( this );
			const type = $el.attr( 'type' );

			let value = $el.val();
			if ( type === 'checkbox' ) {
				const name = $el.attr( 'name' );
				if ( $form.find( '[name="' + name + '"]:checked' ).length === 0 ) {
					showFieldError( $el.closest( '.dk-field' ), DKForm.i18n.required );
					valid = false;
				}
				return;
			}

			if ( ! value || ! value.trim() ) {
				showFieldError( $el.closest( '.dk-field' ), DKForm.i18n.required );
				$el.addClass( 'dk-error' );
				valid = false;
				return;
			}

			if ( type === 'email' && ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( value ) ) {
				showFieldError( $el.closest( '.dk-field' ), DKForm.i18n.invalid_email );
				$el.addClass( 'dk-error' );
				valid = false;
			}

			if ( type === 'tel' && value && ! /^[0-9+\-\(\)\s]{7,}$/.test( value ) ) {
				showFieldError( $el.closest( '.dk-field' ), DKForm.i18n.invalid_phone );
				$el.addClass( 'dk-error' );
				valid = false;
			}
		} );

		return valid;
	}

	function showFieldError( $field, msg ) {
		$field.find( '.dk-field-error' ).remove();
		$field.append( '<span class="dk-field-error" role="alert">' + escHtml( msg ) + '</span>' );
	}

	function showErrors( $form, errors ) {
		Object.entries( errors ).forEach( ( [ fieldId, msg ] ) => {
			const $field = $form.find( '[data-field-id="' + fieldId + '"]' );
			if ( $field.length ) showFieldError( $field, msg );
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
