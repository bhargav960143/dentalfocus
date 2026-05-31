<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder\Fields;

class RadioField extends AbstractField {

	public function get_type(): string  { return 'radio'; }
	public function get_label(): string { return __( 'Radio Buttons', 'DentalFocus' ); }
	public function get_icon(): string  { return 'dashicons-marker'; }

	public function render( array $field, mixed $value = null ): string {
		$id      = esc_attr( $field['id'] );
		$options = (array) ( $field['options'] ?? [] );
		$html    = '<div class="dk-radio-group">';

		foreach ( $options as $idx => $opt ) {
			$opt_clean = esc_html( trim( (string) $opt ) );
			$opt_id    = $id . '_' . $idx;
			$checked   = checked( $value, $opt_clean, false );

			$html .= sprintf(
				'<label class="dk-radio-label"><input type="radio" id="%s" name="dk_fields[%s]" value="%s"%s class="dk-radio" /> %s</label>',
				esc_attr( $opt_id ),
				esc_attr( $field['id'] ),
				$opt_clean,
				$checked,
				$opt_clean
			);
		}

		$html .= '</div>';
		return $this->wrap( $html, $field );
	}

	public function sanitize( mixed $value ): mixed {
		return sanitize_text_field( (string) $value );
	}
}
