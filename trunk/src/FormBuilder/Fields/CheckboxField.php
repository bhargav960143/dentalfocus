<?php
declare(strict_types=1);

namespace DentalKit\FormBuilder\Fields;

class CheckboxField extends AbstractField {

	public function get_type(): string  { return 'checkbox'; }
	public function get_label(): string { return __( 'Checkboxes', 'dentalkit' ); }
	public function get_icon(): string  { return 'dashicons-yes-alt'; }

	public function render( array $field, mixed $value = null ): string {
		$id      = esc_attr( $field['id'] );
		$options = (array) ( $field['options'] ?? [] );
		$values  = (array) ( $value ?? [] );
		$html    = '<div class="dk-checkbox-group">';

		foreach ( $options as $idx => $opt ) {
			$opt_clean = esc_html( trim( (string) $opt ) );
			$opt_id    = $id . '_' . $idx;
			$checked   = in_array( $opt_clean, $values, true ) ? ' checked' : '';

			$html .= sprintf(
				'<label class="dk-checkbox-label"><input type="checkbox" id="%s" name="dk_fields[%s][]" value="%s"%s class="dk-checkbox" /> %s</label>',
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
		if ( ! is_array( $value ) ) {
			return [];
		}
		return array_map( 'sanitize_text_field', $value );
	}
}
