<?php
declare(strict_types=1);

namespace DentalKit\FormBuilder\Fields;

class TextField extends AbstractField {

	public function get_type(): string  { return 'text'; }
	public function get_label(): string { return __( 'Text Field', 'dentalkit' ); }
	public function get_icon(): string  { return 'dashicons-editor-textcolor'; }

	public function render( array $field, mixed $value = null ): string {
		$id          = esc_attr( $field['id'] );
		$name        = 'dk_fields[' . esc_attr( $field['id'] ) . ']';
		$placeholder = esc_attr( $field['placeholder'] ?? '' );
		$required    = ! empty( $field['required'] ) ? ' required' : '';
		$val         = esc_attr( (string) ( $value ?? '' ) );

		$input = sprintf(
			'<input type="text" id="%s" name="%s" class="dk-input" placeholder="%s" value="%s"%s />',
			$id, $name, $placeholder, $val, $required
		);

		return $this->wrap( $input, $field );
	}

	public function sanitize( mixed $value ): mixed {
		return sanitize_text_field( (string) $value );
	}
}
