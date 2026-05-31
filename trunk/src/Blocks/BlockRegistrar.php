<?php
declare(strict_types=1);

namespace DentalFocus\Blocks;

class BlockRegistrar {

	private const CPT_BLOCKS = [
		'testimonials' => [ 'default_limit' => 6,  'default_columns' => 3 ],
		'team'         => [ 'default_limit' => 6,  'default_columns' => 3 ],
		'treatments'   => [ 'default_limit' => 6,  'default_columns' => 3 ],
		'portfolio'    => [ 'default_limit' => 12, 'default_columns' => 4 ],
		'banners'      => [ 'default_limit' => 6,  'default_columns' => 1 ],
	];

	public function register(): void {
		add_filter( 'block_categories_all', [ $this, 'register_category' ] );

		register_block_type( 'dentalfocus/form', [
			'attributes'      => [
				'formId' => [ 'type' => 'string', 'default' => '' ],
			],
			'render_callback' => [ $this, 'render_form' ],
		] );

		foreach ( self::CPT_BLOCKS as $type => $defaults ) {
			register_block_type( 'dentalfocus/' . $type, [
				'attributes'      => [
					'limit'    => [ 'type' => 'integer', 'default' => $defaults['default_limit'] ],
					'columns'  => [ 'type' => 'integer', 'default' => $defaults['default_columns'] ],
					'category' => [ 'type' => 'string',  'default' => '' ],
				],
				'render_callback' => function ( array $atts ) use ( $type ): string {
					return $this->render_cpt( $type, $atts );
				},
			] );
		}

		register_block_type( 'dentalfocus/social', [
			'attributes'      => [
				'name' => [ 'type' => 'string', 'default' => '' ],
			],
			'render_callback' => [ $this, 'render_social' ],
		] );

		register_block_type( 'dentalfocus/social-list', [
			'attributes'      => [],
			'render_callback' => [ $this, 'render_social_list' ],
		] );

		register_block_type( 'dentalfocus/before-after', [
			'attributes'      => [
				'post'         => [ 'type' => 'string', 'default' => '' ],
				'before'       => [ 'type' => 'string', 'default' => '' ],
				'after'        => [ 'type' => 'string', 'default' => '' ],
				'label_before' => [ 'type' => 'string', 'default' => 'Before' ],
				'label_after'  => [ 'type' => 'string', 'default' => 'After'  ],
			],
			'render_callback' => [ $this, 'render_before_after' ],
		] );

		register_block_type( 'dentalfocus/whatsapp', [
			'attributes'      => [
				'number'  => [ 'type' => 'string', 'default' => '' ],
				'message' => [ 'type' => 'string', 'default' => '' ],
				'label'   => [ 'type' => 'string', 'default' => 'Chat on WhatsApp' ],
				'style'   => [ 'type' => 'string', 'default' => 'button' ],
			],
			'render_callback' => [ $this, 'render_whatsapp' ],
		] );
	}

	public function register_category( array $categories ): array {
		return array_merge(
			[ [ 'slug' => 'dentalfocus', 'title' => 'Dental Focus', 'icon' => 'heart' ] ],
			$categories
		);
	}

	public function render_form( array $atts ): string {
		$id = absint( $atts['formId'] ?? 0 );
		if ( ! $id ) {
			return '<p class="dk-block-empty">' . esc_html__( 'Select a form in the block settings panel.', 'dentalfocus' ) . '</p>';
		}
		return do_shortcode( '[dk_form id="' . $id . '"]' );
	}

	private function render_cpt( string $type, array $atts ): string {
		$limit   = absint( $atts['limit']    ?? 6 );
		$columns = absint( $atts['columns']  ?? 3 );
		$cat     = sanitize_text_field( $atts['category'] ?? '' );
		$cat_str = $cat ? ' category="' . esc_attr( $cat ) . '"' : '';
		return do_shortcode( '[dk_' . $type . ' limit="' . $limit . '" columns="' . $columns . '"' . $cat_str . ']' );
	}

	public function render_social( array $atts ): string {
		$name = sanitize_text_field( $atts['name'] ?? '' );
		if ( ! $name ) {
			return '<p class="dk-block-empty">' . esc_html__( 'Enter a platform name (e.g. facebook) in the block settings.', 'dentalfocus' ) . '</p>';
		}
		return do_shortcode( '[dk_social name="' . esc_attr( $name ) . '"]' );
	}

	public function render_social_list(): string {
		return do_shortcode( '[dk_social_list]' );
	}

	public function render_before_after( array $atts ): string {
		$post         = sanitize_text_field( $atts['post']         ?? '' );
		$before       = sanitize_text_field( $atts['before']       ?? '' );
		$after        = sanitize_text_field( $atts['after']        ?? '' );
		$label_before = sanitize_text_field( $atts['label_before'] ?? 'Before' );
		$label_after  = sanitize_text_field( $atts['label_after']  ?? 'After' );

		$sc = '[dk_before_after';
		if ( $post )         $sc .= ' post="'         . esc_attr( $post )         . '"';
		if ( $before )       $sc .= ' before="'       . esc_attr( $before )       . '"';
		if ( $after )        $sc .= ' after="'        . esc_attr( $after )        . '"';
		if ( $label_before ) $sc .= ' label_before="' . esc_attr( $label_before ) . '"';
		if ( $label_after )  $sc .= ' label_after="'  . esc_attr( $label_after )  . '"';
		$sc .= ']';

		$html = do_shortcode( $sc );
		if ( ! $html ) {
			return '<p class="dk-block-empty">' . esc_html__( 'Set before/after image IDs or a portfolio post ID in block settings.', 'dentalfocus' ) . '</p>';
		}
		return $html;
	}

	public function render_whatsapp( array $atts ): string {
		$number  = sanitize_text_field( $atts['number']  ?? '' );
		$message = sanitize_text_field( $atts['message'] ?? '' );
		$label   = sanitize_text_field( $atts['label']   ?? 'Chat on WhatsApp' );
		$style   = in_array( $atts['style'] ?? 'button', [ 'button', 'link' ], true ) ? $atts['style'] : 'button';

		if ( ! $number ) {
			return '<p class="dk-block-empty">' . esc_html__( 'Enter a WhatsApp number in the block settings.', 'dentalfocus' ) . '</p>';
		}

		return do_shortcode(
			'[dk_whatsapp number="' . esc_attr( $number ) . '" message="' . esc_attr( $message ) . '" label="' . esc_attr( $label ) . '" style="' . esc_attr( $style ) . '"]'
		);
	}
}
