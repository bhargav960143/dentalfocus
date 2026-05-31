<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder;

class BeforeAfterShortcode {

	public function register(): void {
		add_shortcode( 'dk_before_after', [ $this, 'render' ] );
	}

	/** @param array<string,string>|string $atts */
	public function render( array|string $atts ): string {
		$atts = shortcode_atts( [
			'post'         => '0',
			'before'       => '0',
			'after'        => '0',
			'label_before' => __( 'Before', 'dentalfocus' ),
			'label_after'  => __( 'After',  'dentalfocus' ),
		], $atts, 'dk_before_after' );

		$before_id = 0;
		$after_id  = 0;

		$post_id = absint( $atts['post'] );
		if ( $post_id ) {
			$before_id = absint( get_post_meta( $post_id, '_dk_before_image', true ) );
			$after_id  = absint( get_post_meta( $post_id, '_dk_after_image',  true ) );
		} else {
			$before_id = absint( $atts['before'] );
			$after_id  = absint( $atts['after'] );
		}

		if ( ! $before_id || ! $after_id ) {
			return '';
		}

		$before_url = wp_get_attachment_image_url( $before_id, 'large' );
		$after_url  = wp_get_attachment_image_url( $after_id,  'large' );

		if ( ! $before_url || ! $after_url ) {
			return '';
		}

		$label_before = esc_html( $atts['label_before'] );
		$label_after  = esc_html( $atts['label_after'] );

		return sprintf(
			'<div class="dk-ba-slider" data-dk-ba>
				<img class="dk-ba-after-img" src="%1$s" alt="%3$s">
				<div class="dk-ba-before-wrap" style="width:50%%">
					<img class="dk-ba-before-img" src="%2$s" alt="%4$s">
				</div>
				<div class="dk-ba-handle" style="left:50%%">
					<div class="dk-ba-btn">&#8660;</div>
				</div>
				<span class="dk-ba-label dk-ba-label--after">%3$s</span>
				<span class="dk-ba-label dk-ba-label--before">%4$s</span>
			</div>',
			esc_url( $after_url ),
			esc_url( $before_url ),
			$label_after,
			$label_before
		);
	}
}
