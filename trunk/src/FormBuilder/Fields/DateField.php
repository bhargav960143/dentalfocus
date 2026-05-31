<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder\Fields;

class DateField extends AbstractField {

	public function get_type(): string  { return 'date'; }
	public function get_label(): string { return __( 'Date Field', 'DentalFocus' ); }
	public function get_icon(): string  { return 'dashicons-calendar-alt'; }

	public function render( array $field, mixed $value = null ): string {
		$id       = esc_attr( $field['id'] );
		$name     = 'dk_fields[' . esc_attr( $field['id'] ) . ']';
		$required = ! empty( $field['required'] ) ? ' required' : '';
		$val      = esc_attr( (string) ( $value ?? '' ) );
		$min      = esc_attr( $field['min_date'] ?? '' );
		$max      = esc_attr( $field['max_date'] ?? '' );

		$input = sprintf(
			'<input type="date" id="%s" name="%s" class="dk-input" value="%s" min="%s" max="%s"%s />',
			$id, $name, $val, $min, $max, $required
		);

		return $this->wrap( $input, $field );
	}

	public function sanitize( mixed $value ): mixed {
		$date = sanitize_text_field( (string) $value );
		return preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ? $date : '';
	}

	public function validate( mixed $value, array $field ): true|string {
		$base = parent::validate( $value, $field );
		if ( true !== $base ) {
			return $base;
		}
		if ( '' !== $value && ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', (string) $value ) ) {
			return __( 'Please enter a valid date.', 'DentalFocus' );
		}
		return true;
	}
}
