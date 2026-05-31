<?php
declare(strict_types=1);

namespace DentalKit\FormBuilder;

class SocialShortcode {

	public function register(): void {
		add_shortcode( 'dk_social',      [ $this, 'render_single' ] );
		add_shortcode( 'dk_social_list', [ $this, 'render_list' ] );
	}

	/** [dk_social name="facebook"] → single anchor */
	public function render_single( array|string $atts ): string {
		$atts = shortcode_atts( [ 'name' => '', 'label' => '', 'class' => '' ], $atts, 'dk_social' );
		$slug = sanitize_key( $atts['name'] );

		if ( ! $slug ) {
			return '';
		}

		global $wpdb;
		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}dk_social_media WHERE slug = %s", $slug ),
			ARRAY_A
		);

		if ( ! $row ) {
			return '';
		}

		$label  = $atts['label'] ?: $row['title'];
		$class  = 'dk-social-link dk-social-' . esc_attr( $slug );
		if ( $atts['class'] ) {
			$class .= ' ' . esc_attr( sanitize_html_class( $atts['class'] ) );
		}

		return sprintf(
			'<a href="%s" class="%s" target="_blank" rel="noopener noreferrer">%s</a>',
			esc_url( $row['url'] ),
			$class,
			esc_html( $label )
		);
	}

	/** [dk_social_list] → <ul> of all social links */
	public function render_list( array|string $atts ): string {
		$atts = shortcode_atts( [ 'class' => '' ], $atts, 'dk_social_list' );

		global $wpdb;
		$rows = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}dk_social_media ORDER BY title ASC",
			ARRAY_A
		);

		if ( empty( $rows ) ) {
			return '';
		}

		$list_class = 'dk-social-list';
		if ( $atts['class'] ) {
			$list_class .= ' ' . esc_attr( sanitize_html_class( $atts['class'] ) );
		}

		$items = '';
		foreach ( $rows as $row ) {
			$items .= sprintf(
				'<li class="dk-social-item"><a href="%s" class="dk-social-link dk-social-%s" target="_blank" rel="noopener noreferrer">%s</a></li>',
				esc_url( $row['url'] ),
				esc_attr( $row['slug'] ),
				esc_html( $row['title'] )
			);
		}

		return '<ul class="' . $list_class . '">' . $items . '</ul>';
	}
}
