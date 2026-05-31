<?php
declare(strict_types=1);

namespace DentalKit\FormBuilder\Fields;

interface FieldInterface {

	public function get_type(): string;

	public function get_label(): string;

	public function get_icon(): string;

	/** Render HTML input for frontend form */
	public function render( array $field, mixed $value = null ): string;

	/** Sanitize submitted value */
	public function sanitize( mixed $value ): mixed;

	/** Return true if valid, or error string if invalid */
	public function validate( mixed $value, array $field ): true|string;
}
