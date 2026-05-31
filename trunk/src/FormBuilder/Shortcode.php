<?php
declare(strict_types=1);

namespace DentalKit\FormBuilder;

use DentalKit\FormBuilder\Fields\FieldRegistry;

class Shortcode {

	public function register(): void {
		add_shortcode( 'dk_form', [ $this, 'render' ] );
	}

	/** @param array<string, string> $atts */
	public function render( array|string $atts ): string {
		$atts = shortcode_atts( [ 'id' => '0' ], $atts, 'dk_form' );
		$id   = absint( $atts['id'] );

		if ( ! $id ) {
			return '';
		}

		$repo = new FormRepository();
		$form = $repo->find_with_fields( $id );

		if ( ! $form || 'active' !== $form['status'] ) {
			return '';
		}

		return $this->render_form( $form );
	}

	private function render_form( array $form ): string {
		$nonce  = wp_create_nonce( 'dk_submit_' . $form['id'] );
		$fields = $form['fields'] ?? [];

		ob_start();
		?>
		<div class="dk-form-wrap" id="dk-form-<?php echo absint( $form['id'] ); ?>">
			<form class="dk-form" method="post" novalidate
				data-form-id="<?php echo absint( $form['id'] ); ?>"
				data-nonce="<?php echo esc_attr( $nonce ); ?>">

				<div class="dk-form-fields">
					<?php foreach ( $fields as $field ) :
						$type    = $field['type'] ?? 'text';
						$handler = FieldRegistry::get( $type );
						if ( $handler ) {
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- render() escapes all output internally via esc_attr/esc_html/esc_textarea
							echo $handler->render( $field );
						}
					endforeach; ?>
				</div>

				<div class="dk-form-footer">
					<button type="submit" class="dk-submit-btn">
						<?php echo esc_html( $form['submit_label'] ?? __( 'Send Message', 'dentalkit' ) ); ?>
					</button>
				</div>

				<div class="dk-form-message" aria-live="polite" style="display:none;"></div>
			</form>
		</div>
		<?php
		return ob_get_clean() ?: '';
	}
}
