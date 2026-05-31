/* DentalFocus Portfolio Meta — media uploader */
/* global wp */
( function ( $ ) {
	'use strict';

	$( document ).on( 'click', '.dk-ba-select', function () {
		var $btn     = $( this );
		var targetId = $btn.data( 'target' );
		var previewId = $btn.data( 'preview' );
		var frame    = wp.media( {
			title:    'Select Image',
			button:   { text: 'Use this image' },
			multiple: false,
			library:  { type: 'image' },
		} );

		frame.on( 'select', function () {
			var attachment = frame.state().get( 'selection' ).first().toJSON();
			$( '#' + targetId ).val( attachment.id );
			$( '#' + previewId ).html(
				'<img src="' + attachment.url + '" style="max-width:100%;height:auto;display:block;margin-bottom:8px;" />'
			);
			$btn.next( '.dk-ba-remove' ).show();
		} );

		frame.open();
	} );

	$( document ).on( 'click', '.dk-ba-remove', function () {
		var $btn     = $( this );
		var targetId = $btn.data( 'target' );
		var previewId = $btn.data( 'preview' );
		$( '#' + targetId ).val( '' );
		$( '#' + previewId ).html( '' );
		$btn.hide();
	} );

} )( jQuery );
