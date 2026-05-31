(function () {
	'use strict';

	var blocks       = wp.blocks;
	var el           = wp.element.createElement;
	var Fragment     = wp.element.Fragment;
	var useState     = wp.element.useState;
	var useEffect    = wp.element.useEffect;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var useBlockProps     = wp.blockEditor.useBlockProps;
	var PanelBody    = wp.components.PanelBody;
	var SelectControl  = wp.components.SelectControl;
	var TextControl    = wp.components.TextControl;
	var RangeControl   = wp.components.RangeControl;
	var Placeholder    = wp.components.Placeholder;
	var Spinner        = wp.components.Spinner;
	var ServerSideRender = wp.serverSideRender;
	var __           = wp.i18n.__;
	var apiFetch     = wp.apiFetch;

	// ── FORM BLOCK ─────────────────────────────────────────────────────────────
	blocks.registerBlockType( 'dentalfocus/form', {
		title:       __( 'Dental Form', 'dentalfocus' ),
		description: __( 'Display a dental appointment or enquiry form.', 'dentalfocus' ),
		category:    'dentalfocus',
		icon:        'feedback',
		keywords:    [ __( 'dental', 'dentalfocus' ), __( 'form', 'dentalfocus' ), __( 'appointment', 'dentalfocus' ), __( 'booking', 'dentalfocus' ) ],
		attributes: {
			formId: { type: 'string', default: '' },
		},
		edit: function ( props ) {
			var formId        = props.attributes.formId;
			var setAttributes = props.setAttributes;
			var blockProps    = useBlockProps();

			var formsState   = useState( [] );
			var forms        = formsState[0];
			var setForms     = formsState[1];

			var loadingState = useState( true );
			var loading      = loadingState[0];
			var setLoading   = loadingState[1];

			useEffect( function () {
				apiFetch( { path: '/DentalFocus/v1/forms' } ).then( function ( data ) {
					var options = [ { label: __( '— Select a form —', 'dentalfocus' ), value: '' } ];
					if ( Array.isArray( data ) ) {
						data.forEach( function ( form ) {
							options.push( { label: form.name, value: String( form.id ) } );
						} );
					}
					setForms( options );
					setLoading( false );
				} ).catch( function () {
					setForms( [ { label: __( '— No forms found —', 'dentalfocus' ), value: '' } ] );
					setLoading( false );
				} );
			}, [] );

			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'Form Settings', 'dentalfocus' ), initialOpen: true },
						loading
							? el( Spinner, null )
							: el( SelectControl, {
								label:    __( 'Select Form', 'dentalfocus' ),
								value:    formId,
								options:  forms,
								onChange: function ( val ) { setAttributes( { formId: val } ); },
							} )
					)
				),
				el( 'div', blockProps,
					formId
						? el( ServerSideRender, { block: 'dentalfocus/form', attributes: props.attributes } )
						: el( Placeholder, {
							icon:         'feedback',
							label:        __( 'Dental Form', 'dentalfocus' ),
							instructions: __( 'Select a form in the block settings panel on the right.', 'dentalfocus' ),
						} )
				)
			);
		},
		save: function () { return null; },
	} );

	// ── CPT BLOCKS ─────────────────────────────────────────────────────────────
	var cptBlocks = [
		{
			name:           'dentalfocus/testimonials',
			title:          __( 'Dental Testimonials', 'dentalfocus' ),
			description:    __( 'Display a grid of patient testimonials.', 'dentalfocus' ),
			icon:           'format-quote',
			keywords:       [ __( 'testimonials', 'dentalfocus' ), __( 'reviews', 'dentalfocus' ), __( 'patients', 'dentalfocus' ) ],
			defaultColumns: 3,
			defaultLimit:   6,
		},
		{
			name:           'dentalfocus/team',
			title:          __( 'Dental Team', 'dentalfocus' ),
			description:    __( 'Display dental team members in a grid.', 'dentalfocus' ),
			icon:           'groups',
			keywords:       [ __( 'team', 'dentalfocus' ), __( 'dentist', 'dentalfocus' ), __( 'staff', 'dentalfocus' ) ],
			defaultColumns: 3,
			defaultLimit:   6,
		},
		{
			name:           'dentalfocus/treatments',
			title:          __( 'Dental Treatments', 'dentalfocus' ),
			description:    __( 'Display a grid of dental treatments or services.', 'dentalfocus' ),
			icon:           'heart',
			keywords:       [ __( 'treatments', 'dentalfocus' ), __( 'services', 'dentalfocus' ), __( 'dental', 'dentalfocus' ) ],
			defaultColumns: 3,
			defaultLimit:   6,
		},
		{
			name:           'dentalfocus/portfolio',
			title:          __( 'Dental Portfolio', 'dentalfocus' ),
			description:    __( 'Display a dental portfolio or before/after gallery.', 'dentalfocus' ),
			icon:           'format-gallery',
			keywords:       [ __( 'portfolio', 'dentalfocus' ), __( 'gallery', 'dentalfocus' ), __( 'before after', 'dentalfocus' ) ],
			defaultColumns: 4,
			defaultLimit:   12,
		},
		{
			name:           'dentalfocus/banners',
			title:          __( 'Dental Banners', 'dentalfocus' ),
			description:    __( 'Display promotional banners for the dental practice.', 'dentalfocus' ),
			icon:           'megaphone',
			keywords:       [ __( 'banners', 'dentalfocus' ), __( 'promotions', 'dentalfocus' ), __( 'offers', 'dentalfocus' ) ],
			defaultColumns: 1,
			defaultLimit:   6,
		},
	];

	cptBlocks.forEach( function ( config ) {
		blocks.registerBlockType( config.name, {
			title:       config.title,
			description: config.description,
			category:    'dentalfocus',
			icon:        config.icon,
			keywords:    config.keywords,
			attributes: {
				limit:    { type: 'integer', default: config.defaultLimit },
				columns:  { type: 'integer', default: config.defaultColumns },
				category: { type: 'string',  default: '' },
			},
			edit: function ( props ) {
				var attributes    = props.attributes;
				var setAttributes = props.setAttributes;
				var blockProps    = useBlockProps();

				return el( Fragment, null,
					el( InspectorControls, null,
						el( PanelBody, { title: __( 'Display Settings', 'dentalfocus' ), initialOpen: true },
							el( RangeControl, {
								label:    __( 'Number of Items', 'dentalfocus' ),
								value:    attributes.limit,
								min:      1,
								max:      50,
								onChange: function ( val ) { setAttributes( { limit: val } ); },
							} ),
							el( RangeControl, {
								label:    __( 'Columns', 'dentalfocus' ),
								value:    attributes.columns,
								min:      1,
								max:      6,
								onChange: function ( val ) { setAttributes( { columns: val } ); },
							} ),
							el( TextControl, {
								label:    __( 'Filter by Category Slug', 'dentalfocus' ),
								value:    attributes.category,
								help:     __( 'Optional. Enter a category slug to filter items.', 'dentalfocus' ),
								onChange: function ( val ) { setAttributes( { category: val } ); },
							} )
						)
					),
					el( 'div', blockProps,
						el( ServerSideRender, { block: config.name, attributes: attributes } )
					)
				);
			},
			save: function () { return null; },
		} );
	} );

	// ── SOCIAL BLOCK ───────────────────────────────────────────────────────────
	blocks.registerBlockType( 'dentalfocus/social', {
		title:       __( 'Dental Social Link', 'dentalfocus' ),
		description: __( 'Display a single social media link for the dental practice.', 'dentalfocus' ),
		category:    'dentalfocus',
		icon:        'share',
		keywords:    [ __( 'social', 'dentalfocus' ), __( 'facebook', 'dentalfocus' ), __( 'instagram', 'dentalfocus' ) ],
		attributes: {
			name: { type: 'string', default: '' },
		},
		edit: function ( props ) {
			var name          = props.attributes.name;
			var setAttributes = props.setAttributes;
			var blockProps    = useBlockProps();

			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'Social Settings', 'dentalfocus' ), initialOpen: true },
						el( TextControl, {
							label:    __( 'Platform Name', 'dentalfocus' ),
							value:    name,
							help:     __( 'e.g. facebook, instagram, twitter, linkedin', 'dentalfocus' ),
							onChange: function ( val ) { setAttributes( { name: val } ); },
						} )
					)
				),
				el( 'div', blockProps,
					name
						? el( ServerSideRender, { block: 'dentalfocus/social', attributes: props.attributes } )
						: el( Placeholder, {
							icon:         'share',
							label:        __( 'Dental Social Link', 'dentalfocus' ),
							instructions: __( 'Enter a platform name (e.g. facebook) in the block settings.', 'dentalfocus' ),
						} )
				)
			);
		},
		save: function () { return null; },
	} );

	// ── SOCIAL LIST BLOCK ──────────────────────────────────────────────────────
	blocks.registerBlockType( 'dentalfocus/social-list', {
		title:       __( 'Dental Social Links List', 'dentalfocus' ),
		description: __( 'Display all social media links for the dental practice.', 'dentalfocus' ),
		category:    'dentalfocus',
		icon:        'networking',
		keywords:    [ __( 'social', 'dentalfocus' ), __( 'links', 'dentalfocus' ), __( 'all platforms', 'dentalfocus' ) ],
		attributes:  {},
		edit: function ( props ) {
			var blockProps = useBlockProps();
			return el( 'div', blockProps,
				el( ServerSideRender, { block: 'dentalfocus/social-list', attributes: {} } )
			);
		},
		save: function () { return null; },
	} );

	// ── BEFORE / AFTER BLOCK ──────────────────────────────────────────────────
	blocks.registerBlockType( 'dentalfocus/before-after', {
		title:       __( 'Before / After Slider', 'dentalfocus' ),
		description: __( 'Image comparison slider for dental before/after results.', 'dentalfocus' ),
		category:    'dentalfocus',
		icon:        'format-gallery',
		keywords:    [ __( 'before after', 'dentalfocus' ), __( 'comparison', 'dentalfocus' ), __( 'slider', 'dentalfocus' ) ],
		attributes: {
			post:         { type: 'string', default: '' },
			before:       { type: 'string', default: '' },
			after:        { type: 'string', default: '' },
			label_before: { type: 'string', default: 'Before' },
			label_after:  { type: 'string', default: 'After'  },
		},
		edit: function ( props ) {
			var attributes    = props.attributes;
			var setAttributes = props.setAttributes;
			var blockProps    = useBlockProps();

			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'Image Settings', 'dentalfocus' ), initialOpen: true },
						el( TextControl, {
							label:    __( 'Portfolio Post ID', 'dentalfocus' ),
							value:    attributes.post,
							help:     __( 'Enter a Portfolio post ID to pull before/after images automatically.', 'dentalfocus' ),
							onChange: function ( val ) { setAttributes( { post: val } ); },
						} ),
						el( TextControl, {
							label:    __( 'Before Image ID', 'dentalfocus' ),
							value:    attributes.before,
							help:     __( 'Media library attachment ID. Used if no Post ID set.', 'dentalfocus' ),
							onChange: function ( val ) { setAttributes( { before: val } ); },
						} ),
						el( TextControl, {
							label:    __( 'After Image ID', 'dentalfocus' ),
							value:    attributes.after,
							onChange: function ( val ) { setAttributes( { after: val } ); },
						} ),
						el( TextControl, {
							label:    __( 'Before Label', 'dentalfocus' ),
							value:    attributes.label_before,
							onChange: function ( val ) { setAttributes( { label_before: val } ); },
						} ),
						el( TextControl, {
							label:    __( 'After Label', 'dentalfocus' ),
							value:    attributes.label_after,
							onChange: function ( val ) { setAttributes( { label_after: val } ); },
						} )
					)
				),
				el( 'div', blockProps,
					( attributes.post || ( attributes.before && attributes.after ) )
						? el( ServerSideRender, { block: 'dentalfocus/before-after', attributes: attributes } )
						: el( Placeholder, {
							icon:         'format-gallery',
							label:        __( 'Before / After Slider', 'dentalfocus' ),
							instructions: __( 'Enter a Portfolio Post ID, or Before and After image IDs in the block settings.', 'dentalfocus' ),
						} )
				)
			);
		},
		save: function () { return null; },
	} );

	// ── WHATSAPP BLOCK ─────────────────────────────────────────────────────────
	blocks.registerBlockType( 'dentalfocus/whatsapp', {
		title:       __( 'WhatsApp Button', 'dentalfocus' ),
		description: __( 'Display a WhatsApp click-to-chat button for the dental practice.', 'dentalfocus' ),
		category:    'dentalfocus',
		icon:        'format-chat',
		keywords:    [ __( 'whatsapp', 'dentalfocus' ), __( 'chat', 'dentalfocus' ), __( 'contact', 'dentalfocus' ) ],
		attributes: {
			number:  { type: 'string', default: '' },
			message: { type: 'string', default: '' },
			label:   { type: 'string', default: 'Chat on WhatsApp' },
			style:   { type: 'string', default: 'button' },
		},
		edit: function ( props ) {
			var attributes    = props.attributes;
			var setAttributes = props.setAttributes;
			var blockProps    = useBlockProps();

			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'WhatsApp Settings', 'dentalfocus' ), initialOpen: true },
						el( TextControl, {
							label:    __( 'WhatsApp Number', 'dentalfocus' ),
							value:    attributes.number,
							help:     __( 'With country code, digits only. e.g. 919876543210', 'dentalfocus' ),
							onChange: function ( val ) { setAttributes( { number: val } ); },
						} ),
						el( TextControl, {
							label:    __( 'Pre-filled Message', 'dentalfocus' ),
							value:    attributes.message,
							help:     __( 'Optional. Message pre-filled when patient opens WhatsApp.', 'dentalfocus' ),
							onChange: function ( val ) { setAttributes( { message: val } ); },
						} ),
						el( TextControl, {
							label:    __( 'Button Label', 'dentalfocus' ),
							value:    attributes.label,
							onChange: function ( val ) { setAttributes( { label: val } ); },
						} ),
						el( SelectControl, {
							label:    __( 'Style', 'dentalfocus' ),
							value:    attributes.style,
							options: [
								{ label: __( 'Button (green)', 'dentalfocus' ), value: 'button' },
								{ label: __( 'Link',           'dentalfocus' ), value: 'link' },
							],
							onChange: function ( val ) { setAttributes( { style: val } ); },
						} )
					)
				),
				el( 'div', blockProps,
					attributes.number
						? el( ServerSideRender, { block: 'dentalfocus/whatsapp', attributes: attributes } )
						: el( Placeholder, {
							icon:         'format-chat',
							label:        __( 'WhatsApp Button', 'dentalfocus' ),
							instructions: __( 'Enter a WhatsApp number in the block settings panel.', 'dentalfocus' ),
						} )
				)
			);
		},
		save: function () { return null; },
	} );

} )();
