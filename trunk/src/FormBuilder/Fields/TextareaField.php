<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder\Fields;

class TextareaField extends AbstractField {

	public function get_type(): string  { return 'textarea'; }
	public function get_label(): string { return __( 'Textarea', 'DentalFocus' ); }
	public function get_icon(): string  { return 'dashicons-editor-paragraph'; }

	public function render( array $field, mixed $value = null ): string {
		$id          = esc_attr( $field['id'] );
		$name        = 'dk_fields[' . esc_attr( $field['id'] ) . ']';
		$placeholder = esc_attr( $field['placeholder'] ?? '' );
		$rows        = absint( $field['rows'] ?? 5 );
		$required    = ! empty( $field['required'] ) ? ' required' : '';
		$val         = esc_textarea( (string) ( $value ?? '' ) );

		$input = sprintf(
			'<textarea id="%s" name="%s" class="dk-input dk-textarea" placeholder="%s" rows="%d"%s>%s</textarea>',
			$id, $name, $placeholder, $rows, $required, $val
		);

		return $this->wrap( $input, $field );
	}

	public function sanitize( mixed $value ): mixed {
		return sanitize_textarea_field( (string) $value );
	}
}
