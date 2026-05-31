<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder\Fields;

abstract class AbstractField implements FieldInterface {

	public function validate( mixed $value, array $field ): true|string {
		if ( ! empty( $field['required'] ) && ( '' === $value || null === $value ) ) {
			return sprintf(
				/* translators: %s: field label */
				__( '%s is required.', 'DentalFocus' ),
				esc_html( $field['label'] ?? __( 'This field', 'DentalFocus' ) )
			);
		}
		return true;
	}

	protected function wrap( string $input_html, array $field ): string {
		$id       = esc_attr( $field['id'] );
		$label    = esc_html( $field['label'] ?? '' );
		$required = ! empty( $field['required'] );
		$req_attr = $required ? ' aria-required="true"' : '';
		$req_mark = $required ? ' <span class="dk-required" aria-hidden="true">*</span>' : '';

		return sprintf(
			'<div class="dk-field dk-field--%1$s" data-field-id="%2$s"%3$s>
				<label class="dk-label" for="%2$s">%4$s%5$s</label>
				%6$s
			</div>',
			esc_attr( $this->get_type() ),
			$id,
			$req_attr,
			$label,
			$req_mark,
			$input_html
		);
	}
}
