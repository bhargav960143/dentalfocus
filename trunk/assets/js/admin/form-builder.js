/* DentalKit Form Builder — v2.0.0 */
/* global DK, DKBuilderData, Sortable */

( function () {
	'use strict';

	const { form_id, fields, is_edit } = window.DKBuilderData || {};

	let formFields     = Array.isArray( fields ) ? [ ...fields ] : [];
	let editingFieldId = null;

	const dropZone      = document.getElementById( 'dk-drop-zone' );
	const palette       = document.getElementById( 'dk-palette' );
	const placeholder   = document.getElementById( 'dk-drop-placeholder' );
	const settingsPanel = document.getElementById( 'dk-field-settings' );

	if ( ! dropZone || ! palette || ! settingsPanel ) return;

	// ── Event delegation — covers PHP-rendered AND JS-added field rows ────────
	dropZone.addEventListener( 'click', function ( e ) {
		const editBtn   = e.target.closest( '.dk-edit-field' );
		const removeBtn = e.target.closest( '.dk-remove-field' );

		if ( editBtn ) {
			const row = editBtn.closest( '.dk-field-row' );
			if ( row ) openFieldSettings( row.dataset.fieldId );
		}

		if ( removeBtn ) {
			const row = removeBtn.closest( '.dk-field-row' );
			if ( row && confirm( DK.i18n.confirm_delete ) ) {
				removeField( row.dataset.fieldId );
			}
		}
	} );

	// ── Drag from palette ─────────────────────────────────────────────────────
	palette.querySelectorAll( '.dk-palette-item' ).forEach( item => {
		item.addEventListener( 'dragstart', e => {
			e.dataTransfer.setData( 'text/plain', item.dataset.type );
		} );
	} );

	dropZone.addEventListener( 'dragover', e => {
		e.preventDefault();
		dropZone.classList.add( 'dk-drag-over' );
	} );

	dropZone.addEventListener( 'dragleave', e => {
		if ( ! dropZone.contains( e.relatedTarget ) ) {
			dropZone.classList.remove( 'dk-drag-over' );
		}
	} );

	dropZone.addEventListener( 'drop', e => {
		e.preventDefault();
		dropZone.classList.remove( 'dk-drag-over' );
		const type = e.dataTransfer.getData( 'text/plain' );
		if ( type ) addField( type );
	} );

	// ── SortableJS — reorder ──────────────────────────────────────────────────
	if ( window.Sortable ) {
		Sortable.create( dropZone, {
			animation: 150,
			handle: '.dk-field-row-handle',
			ghostClass: 'sortable-ghost',
			filter: '#dk-drop-placeholder',
			onEnd: syncOrderFromDOM,
		} );
	}

	// ── Add new field ─────────────────────────────────────────────────────────
	function addField( type ) {
		const id = 'field_' + Date.now();
		const field = {
			id,
			type,
			label:       toTitleCase( type ) + ' Field',
			placeholder: '',
			required:    false,
			order:       formFields.length,
		};

		if ( [ 'select', 'checkbox', 'radio' ].includes( type ) ) {
			field.options = [ 'Option 1', 'Option 2' ];
		}
		if ( 'textarea' === type ) field.rows = 5;

		formFields.push( field );
		renderFieldRow( field );
		hidePlaceholder();
	}

	function renderFieldRow( field ) {
		const row = document.createElement( 'div' );
		row.className = 'dk-field-row';
		row.dataset.fieldId = field.id;
		row.dataset.type    = field.type;

		row.innerHTML = buildRowHTML( field );
		dropZone.appendChild( row );
	}

	function buildRowHTML( field ) {
		const reqBadge = field.required
			? '<span class="dk-required-badge">Required</span>'
			: '';

		return `
			<div class="dk-field-row-handle">
				<span class="dashicons dashicons-menu"></span>
			</div>
			<div class="dk-field-row-info">
				<span class="dk-field-type-badge">${ escHtml( field.type ) }</span>
				<span class="dk-field-label-preview">${ escHtml( field.label ) }</span>
				${ reqBadge }
			</div>
			<div class="dk-field-row-actions">
				<button type="button" class="button button-small dk-edit-field" title="Edit field">
					<span class="dashicons dashicons-edit"></span>
				</button>
				<button type="button" class="button button-small dk-remove-field" title="Remove field">
					<span class="dashicons dashicons-trash"></span>
				</button>
			</div>
		`;
	}

	// Update DOM row after settings saved
	function refreshFieldRow( field ) {
		const row = dropZone.querySelector( `[data-field-id="${ field.id }"]` );
		if ( ! row ) return;
		row.querySelector( '.dk-field-label-preview' ).textContent = field.label;

		const existingBadge = row.querySelector( '.dk-required-badge' );
		if ( field.required && ! existingBadge ) {
			const badge = document.createElement( 'span' );
			badge.className   = 'dk-required-badge';
			badge.textContent = 'Required';
			row.querySelector( '.dk-field-row-info' ).appendChild( badge );
		} else if ( ! field.required && existingBadge ) {
			existingBadge.remove();
		}
	}

	function removeField( fieldId ) {
		formFields = formFields.filter( f => f.id !== fieldId );
		const row  = dropZone.querySelector( `[data-field-id="${ fieldId }"]` );
		if ( row ) row.remove();
		if ( formFields.length === 0 ) showPlaceholder();
		if ( editingFieldId === fieldId ) closeFieldSettings();
	}

	function syncOrderFromDOM() {
		dropZone.querySelectorAll( '.dk-field-row' ).forEach( ( row, i ) => {
			const field = formFields.find( f => f.id === row.dataset.fieldId );
			if ( field ) field.order = i;
		} );
	}

	// ── Field settings panel ──────────────────────────────────────────────────
	function openFieldSettings( fieldId ) {
		const field = formFields.find( f => f.id === fieldId );
		if ( ! field ) {
			console.warn( 'DentalKit: field not found in formFields:', fieldId );
			return;
		}

		editingFieldId = fieldId;

		document.getElementById( 'dk-field-label' ).value       = field.label || '';
		document.getElementById( 'dk-field-placeholder' ).value = field.placeholder || '';
		document.getElementById( 'dk-field-required' ).checked  = !! field.required;

		const optRow  = settingsPanel.querySelector( '.dk-settings-options-row' );
		const hasOpts = [ 'select', 'checkbox', 'radio' ].includes( field.type );
		optRow.style.display = hasOpts ? '' : 'none';

		if ( hasOpts ) {
			document.getElementById( 'dk-field-options' ).value = ( field.options || [] ).join( '\n' );
		}

		settingsPanel.style.display = '';
		document.getElementById( 'dk-field-label' ).focus();
	}

	function closeFieldSettings() {
		editingFieldId = null;
		settingsPanel.style.display = 'none';
	}

	document.getElementById( 'dk-update-field' ).addEventListener( 'click', () => {
		if ( ! editingFieldId ) return;

		const field = formFields.find( f => f.id === editingFieldId );
		if ( ! field ) return;

		const newLabel = document.getElementById( 'dk-field-label' ).value.trim();
		field.label       = newLabel || field.label;
		field.placeholder = document.getElementById( 'dk-field-placeholder' ).value.trim();
		field.required    = document.getElementById( 'dk-field-required' ).checked;

		if ( [ 'select', 'checkbox', 'radio' ].includes( field.type ) ) {
			field.options = document.getElementById( 'dk-field-options' ).value
				.split( '\n' )
				.map( s => s.trim() )
				.filter( Boolean );
		}

		refreshFieldRow( field );
		closeFieldSettings();
	} );

	document.getElementById( 'dk-cancel-edit' ).addEventListener( 'click', closeFieldSettings );

	// ── Save form via REST ────────────────────────────────────────────────────
	document.getElementById( 'dk-save-form' ).addEventListener( 'click', async () => {
		const name = document.getElementById( 'dk-form-name' ).value.trim();
		const desc = document.getElementById( 'dk-form-desc' ).value.trim();

		if ( ! name ) {
			setStatus( DK.i18n.untitled_form + ' — please enter a form name.', 'error' );
			document.getElementById( 'dk-form-name' ).focus();
			return;
		}

		if ( formFields.length === 0 ) {
			setStatus( 'Add at least one field before saving.', 'error' );
			return;
		}

		syncOrderFromDOM();
		const sortedFields = [ ...formFields ].sort( ( a, b ) => a.order - b.order );

		const btn    = document.getElementById( 'dk-save-form' );
		btn.disabled = true;
		setStatus( '…', '' );

		const method = is_edit ? 'PUT' : 'POST';
		const url    = DK.rest_url + 'forms' + ( is_edit && form_id ? '/' + form_id : '' );

		try {
			const res  = await fetch( url, {
				method,
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce':  DK.nonce,
				},
				body: JSON.stringify( { name, description: desc, fields: sortedFields } ),
			} );

			const json = await res.json();

			if ( ! res.ok ) {
				throw new Error( json.message || DK.i18n.save_error );
			}

			setStatus( DK.i18n.save_success, 'success' );

			if ( ! is_edit && json.id ) {
				window.location.href = DK.admin_url + '?page=dk-forms&action=edit&id=' + json.id + '&saved=1';
			}
		} catch ( err ) {
			setStatus( err.message || DK.i18n.save_error, 'error' );
		} finally {
			btn.disabled = false;
		}
	} );

	// ── Copy shortcode ────────────────────────────────────────────────────────
	const copyBtn = document.getElementById( 'dk-copy-shortcode' );
	if ( copyBtn ) {
		copyBtn.addEventListener( 'click', () => {
			const code = document.getElementById( 'dk-shortcode-display' ).textContent.trim();
			navigator.clipboard.writeText( code ).then( () => {
				const confirmEl = document.getElementById( 'dk-copy-confirm' );
				confirmEl.style.display = 'inline';
				setTimeout( () => { confirmEl.style.display = 'none'; }, 2000 );
			} );
		} );
	}

	// Shortcode cell click-to-copy (forms list page)
	document.querySelectorAll( '.dk-shortcode-cell' ).forEach( el => {
		el.style.cursor = 'pointer';
		el.addEventListener( 'click', () => {
			navigator.clipboard.writeText( el.textContent.trim() ).then( () => {
				const prev = el.style.background;
				el.style.background = '#d7f3e3';
				setTimeout( () => { el.style.background = prev; }, 1500 );
			} );
		} );
	} );

	// ── Helpers ───────────────────────────────────────────────────────────────
	function setStatus( msg, type ) {
		const el     = document.getElementById( 'dk-save-status' );
		el.textContent = msg;
		el.className   = 'dk-save-status ' + type;
	}

	function hidePlaceholder() {
		if ( placeholder ) placeholder.style.display = 'none';
	}

	function showPlaceholder() {
		if ( placeholder ) placeholder.style.display = '';
	}

	function escHtml( str ) {
		const d = document.createElement( 'div' );
		d.appendChild( document.createTextNode( String( str ) ) );
		return d.innerHTML;
	}

	function toTitleCase( str ) {
		return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	}

	// ── Init ─────────────────────────────────────────────────────────────────
	if ( formFields.length > 0 ) {
		hidePlaceholder();
	}

} )();
