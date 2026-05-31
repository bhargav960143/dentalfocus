<?php
declare(strict_types=1);

namespace DentalKit\FormBuilder\Fields;

class EmailField extends AbstractField {

	public function get_type(): string  { return 'email'; }
	public function get_label(): string { return __( 'Email Field', 'dentalkit' ); }
	public function get_icon(): string  { return 'dashicons-email'; }

	public function render( array $field, mixed $value = null ): string {
		$id          = esc_attr( $field['id'] );
		$name        = 'dk_fields[' . esc_attr( $field['id'] ) . ']';
		$placeholder = esc_attr( $field['placeholder'] ?? '' );
		$required    = ! empty( $field['required'] ) ? ' required' : '';
		$val         = esc_attr( (string) ( $value ?? '' ) );

		$input = sprintf(
			'<input type="email" id="%s" name="%s" class="dk-input" placeholder="%s" value="%s" autocomplete="email"%s />',
			$id, $name, $placeholder, $val, $required
		);

		return $this->wrap( $input, $field );
	}

	public function sanitize( mixed $value ): mixed {
		return sanitize_email( (string) $value );
	}

	public function validate( mixed $value, array $field ): true|string {
		$base = parent::validate( $value, $field );
		if ( true !== $base ) {
			return $base;
		}
		if ( '' !== $value && ! is_email( $value ) ) {
			return __( 'Please enter a valid email address.', 'dentalkit' );
		}
		return true;
	}
}
