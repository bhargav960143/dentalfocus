<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder;

class SocialShortcode {

	public function register(): void {
		add_shortcode( 'dk_social',      [ $this, 'render_single' ] );
		add_shortcode( 'dk_social_list', [ $this, 'render_list' ] );
		add_shortcode( 'dk_whatsapp',    [ $this, 'render_whatsapp' ] );
		add_shortcode( 'dk_call',        [ $this, 'render_call' ] );
		add_shortcode( 'dk_map',         [ $this, 'render_map' ] );
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

	/**
	 * [dk_whatsapp number="919876543210" message="Hello" label="Chat on WhatsApp" style="button"]
	 * Renders a WhatsApp click-to-chat link or button.
	 */
	public function render_whatsapp( array|string $atts ): string {
		$atts = shortcode_atts( [
			'number'  => '',
			'message' => '',
			'label'   => __( 'Chat on WhatsApp', 'dentalfocus' ),
			'style'   => 'button',
		], $atts, 'dk_whatsapp' );

		$number = preg_replace( '/[^0-9]/', '', $atts['number'] );

		if ( ! $number ) {
			return '';
		}

		$url = 'https://wa.me/' . $number;
		if ( $atts['message'] ) {
			$url .= '?text=' . rawurlencode( sanitize_text_field( $atts['message'] ) );
		}

		$class = 'button' === $atts['style'] ? 'dk-whatsapp-btn' : 'dk-whatsapp-link';

		return sprintf(
			'<a href="%s" class="%s" target="_blank" rel="noopener noreferrer">%s</a>',
			esc_url( $url ),
			esc_attr( $class ),
			esc_html( $atts['label'] )
		);
	}

	/**
	 * [dk_call number="+441234567890" label="Call Us Now" style="button"]
	 * Renders a click-to-call tel: link or button.
	 */
	public function render_call( array|string $atts ): string {
		$atts = shortcode_atts( [
			'number' => '',
			'label'  => __( 'Call Us Now', 'dentalfocus' ),
			'style'  => 'button',
		], $atts, 'dk_call' );

		$number = sanitize_text_field( $atts['number'] );
		if ( ! $number ) {
			return '';
		}

		$tel   = 'tel:' . preg_replace( '/[^\d+]/', '', $number );
		$class = 'button' === $atts['style'] ? 'dk-call-btn' : 'dk-call-link';

		return sprintf(
			'<a href="%s" class="%s">%s</a>',
			esc_url( $tel ),
			esc_attr( $class ),
			esc_html( $atts['label'] )
		);
	}

	/**
	 * [dk_map address="123 Dental St, London" height="400" zoom="15"]
	 * Embeds a Google Maps iframe for the practice address.
	 */
	public function render_map( array|string $atts ): string {
		$atts = shortcode_atts( [
			'address' => '',
			'height'  => '400',
			'zoom'    => '15',
		], $atts, 'dk_map' );

		$address = sanitize_text_field( $atts['address'] );
		if ( ! $address ) {
			return '';
		}

		$height = absint( $atts['height'] ) ?: 400;
		$src    = 'https://maps.google.com/maps?q=' . rawurlencode( $address ) . '&z=' . absint( $atts['zoom'] ) . '&output=embed';

		return sprintf(
			'<div class="dk-map-wrap"><iframe src="%s" width="100%%" height="%d" style="border:0;border-radius:8px;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="%s"></iframe></div>',
			esc_url( $src ),
			$height,
			esc_attr( __( 'Practice Location', 'dentalfocus' ) )
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
