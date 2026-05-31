<?php
declare(strict_types=1);

namespace DentalKit\FormBuilder\Fields;

class SelectField extends AbstractField {

	public function get_type(): string  { return 'select'; }
	public function get_label(): string { return __( 'Dropdown', 'dentalkit' ); }
	public function get_icon(): string  { return 'dashicons-arrow-down-alt2'; }

	public function render( array $field, mixed $value = null ): string {
		$id       = esc_attr( $field['id'] );
		$name     = 'dk_fields[' . esc_attr( $field['id'] ) . ']';
		$required = ! empty( $field['required'] ) ? ' required' : '';
		$options  = (array) ( $field['options'] ?? [] );

		$opts_html = '<option value="">' . esc_html__( '— Select —', 'dentalkit' ) . '</option>';
		foreach ( $options as $opt ) {
			$opt       = esc_html( trim( (string) $opt ) );
			$selected  = selected( $value, $opt, false );
			$opts_html .= "<option value=\"{$opt}\"{$selected}>{$opt}</option>";
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
