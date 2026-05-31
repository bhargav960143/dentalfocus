<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder\Fields;

class PhoneField extends AbstractField {

	public function get_type(): string  { return 'phone'; }
	public function get_label(): string { return __( 'Phone Field', 'DentalFocus' ); }
	public function get_icon(): string  { return 'dashicons-phone'; }

	public function render( array $field, mixed $value = null ): string {
		$id          = esc_attr( $field['id'] );
		$name        = 'dk_fields[' . esc_attr( $field['id'] ) . ']';
		$placeholder = esc_attr( $field['placeholder'] ?? '' );
		$required    = ! empty( $field['required'] ) ? ' required' : '';
		$val         = esc_attr( (string) ( $value ?? '' ) );

		$input = sprintf(
			'<input type="tel" id="%s" name="%s" class="dk-input" placeholder="%s" value="%s" autocomplete="tel"%s />',
			$id, $name, $placeholder, $val, $required
		);

		return $this->wrap( $input, $field );
	}

	public function sanitize( mixed $value ): mixed {
		return preg_replace( '/[^0-9+\-\(\)\s]/', '', (string) $value ) ?? '';
	}
}
