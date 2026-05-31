/* DentalFocus Before/After Slider */
( function () {
	'use strict';

	function initSlider( slider ) {
		var beforeWrap = slider.querySelector( '.dk-ba-before-wrap' );
		var beforeImg  = slider.querySelector( '.dk-ba-before-img' );
		var handle     = slider.querySelector( '.dk-ba-handle' );
		var dragging   = false;

		function setWidth() {
			beforeImg.style.width = slider.offsetWidth + 'px';
		}

		function setPosition( clientX ) {
			var rect = slider.getBoundingClientRect();
			var pct  = Math.max( 0, Math.min( 100, ( ( clientX - rect.left ) / rect.width ) * 100 ) );
			beforeWrap.style.width = pct + '%';
			handle.style.left      = pct + '%';
		}

		setWidth();
		window.addEventListener( 'resize', setWidth );

		/* Mouse */
		handle.addEventListener( 'mousedown', function ( e ) {
			dragging = true;
			e.preventDefault();
		} );
		document.addEventListener( 'mousemove', function ( e ) {
			if ( dragging ) setPosition( e.clientX );
		} );
		document.addEventListener( 'mouseup', function () {
			dragging = false;
		} );

		/* Touch */
		handle.addEventListener( 'touchstart', function () {
			dragging = true;
		}, { passive: true } );
		document.addEventListener( 'touchmove', function ( e ) {
			if ( dragging ) setPosition( e.touches[0].clientX );
		}, { passive: true } );
		document.addEventListener( 'touchend', function () {
			dragging = false;
		} );

		/* Click anywhere on slider */
		slider.addEventListener( 'click', function ( e ) {
			setPosition( e.clientX );
		} );
	}

	document.querySelectorAll( '[data-dk-ba]' ).forEach( initSlider );
} )();
