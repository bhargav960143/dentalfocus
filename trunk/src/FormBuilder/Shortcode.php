<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder;

use DentalFocus\FormBuilder\Fields\FieldRegistry;

class Shortcode {

	public function register(): void {
		add_shortcode( 'dk_form',               [ $this, 'render' ] );
		add_shortcode( 'dk_treatment_enquiry',  [ $this, 'render_treatment_enquiry' ] );
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

	/** [dk_treatment_enquiry id="1" treatment="Teeth Whitening"] */
	public function render_treatment_enquiry( array|string $atts ): string {
		$atts = shortcode_atts( [ 'id' => '0', 'treatment' => '' ], $atts, 'dk_treatment_enquiry' );
		$id   = absint( $atts['id'] );

		if ( ! $id ) {
			return '';
		}

		$treatment = sanitize_text_field( $atts['treatment'] );
		if ( ! $treatment ) {
			global $post;
			if ( $post && 'dk-treatment' === get_post_type( $post ) ) {
				$treatment = get_the_title( $post );
			}
		}

		$repo = new FormRepository();
		$form = $repo->find_with_fields( $id );

		if ( ! $form || 'active' !== $form['status'] ) {
			return '';
		}

		return $this->render_form( $form, $treatment );
	}

	private function render_form( array $form, string $treatment_name = '' ): string {
		$nonce    = wp_create_nonce( 'dk_submit_' . $form['id'] );
		$fields   = $form['fields'] ?? [];
		$settings = get_option( 'dk_settings', [] );

		ob_start();
		?>
		<div class="dk-form-wrap" id="dk-form-<?php echo absint( $form['id'] ); ?>">
			<form class="dk-form" method="post" novalidate
				data-form-id="<?php echo absint( $form['id'] ); ?>"
				data-nonce="<?php echo esc_attr( $nonce ); ?>">

				<?php if ( $treatment_name ) : ?>
				<div class="dk-field dk-treatment-name-field">
					<span class="dk-label"><?php esc_html_e( 'Enquiry about', 'DentalFocus' ); ?></span>
					<div class="dk-treatment-name-value"><?php echo esc_html( $treatment_name ); ?></div>
					<input type="hidden" name="dk_treatment_enquiry_name" value="<?php echo esc_attr( $treatment_name ); ?>" />
				</div>
				<?php endif; ?>

				<div class="dk-form-fields">
					<?php foreach ( $fields as $field ) :
						$type    = $field['type'] ?? 'text';
						$handler = FieldRegistry::get( $type );
						if ( $handler ) {
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- render() escapes all output internally
							echo $handler->render( $field );
						}
					endforeach; ?>
				</div>

				<?php if ( ! empty( $settings['gdpr_enabled'] ) ) :
					$gdpr_label = $settings['gdpr_label'] ?? __( 'I have read and agree to the Privacy Policy.', 'DentalFocus' );
					$gdpr_url   = $settings['gdpr_privacy_url'] ?? '';
					?>
				<div class="dk-field dk-gdpr-field" data-field-id="dk_gdpr_consent" aria-required="true">
					<label class="dk-gdpr-label">
						<input type="checkbox" name="dk_fields[dk_gdpr_consent][]" value="1" />
						<?php echo esc_html( $gdpr_label ); ?>
						<?php if ( $gdpr_url ) : ?>
						<a href="<?php echo esc_url( $gdpr_url ); ?>" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Privacy Policy', 'DentalFocus' ); ?>
						</a>
						<?php endif; ?>
					</label>
				</div>
				<?php endif; ?>

				<div class="dk-hp-field" aria-hidden="true" style="position:absolute;left:-9999px;overflow:hidden;height:0;">
					<input type="text" name="dk_hp_field" value="" tabindex="-1" autocomplete="off" />
				</div>

				<div class="dk-form-footer">
					<button type="submit" class="dk-submit-btn">
						<?php echo esc_html( $form['submit_label'] ?? __( 'Send Message', 'DentalFocus' ) ); ?>
					</button>
				</div>

				<div class="dk-form-message" aria-live="polite" style="display:none;"></div>
			</form>
		</div>
		<?php
		return ob_get_clean() ?: '';
	}
}
