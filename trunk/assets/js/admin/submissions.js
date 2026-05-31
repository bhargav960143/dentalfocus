/* DentalFocus Submissions Admin — v2.0.0 */

( function () {
	'use strict';

	// Confirm before export (large data sets)
	const exportBtn = document.querySelector( '.dk-export-btn' );
	if ( exportBtn ) {
		exportBtn.addEventListener( 'click', e => {
			const rows = document.querySelectorAll( '.wp-list-table tbody tr' ).length;
			if ( rows > 1000 ) {
				if ( ! confirm( 'You are about to export ' + rows + ' submissions. Continue?' ) ) {
					e.preventDefault();
				}
			}
		} );
	}

} )();
