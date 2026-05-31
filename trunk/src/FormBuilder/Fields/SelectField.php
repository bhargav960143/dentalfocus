<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder\Fields;

class SelectField extends AbstractField {

	public function get_type(): string  { return 'select'; }
	public function get_label(): string { return __( 'Dropdown', 'DentalFocus' ); }
	public function get_icon(): string  { return 'dashicons-arrow-down-alt2'; }

	public function render( array $field, mixed $value = null ): string {
		$id       = esc_attr( $field['id'] );
		$name     = 'dk_fields[' . esc_attr( $field['id'] ) . ']';
		$required = ! empty( $field['required'] ) ? ' required' : '';
		$options  = (array) ( $field['options'] ?? [] );

		$opts_html = '<option value="">' . esc_html__( '— Select —', 'DentalFocus' ) . '</option>';
		foreach ( $options as $opt ) {
			$opt_clean = trim( (string) $opt );
			$opt_attr  = esc_attr( $opt_clean );
			$opt_html  = esc_html( $opt_clean );
			$selected  = selected( $value, $opt_clean, false );
			$opts_html .= "<option value=\"{$opt_attr}\"{$selected}>{$opt_html}</option>";
		}

		$input = sprintf(
			'<select id="%s" name="%s" class="dk-select"%s>%s</select>',
			$id, $name, $required, $opts_html
		);

		return $this->wrap( $input, $field );
	}

	public function sanitize( mixed $value ): mixed {
		return sanitize_text_field( (string) $value );
	}
}
