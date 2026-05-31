<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder\Fields;

class FieldRegistry {

	/** @var array<string, FieldInterface> */
	private static array $fields = [];

	public static function boot(): void {
		$types = [
			new TextField(),
			new EmailField(),
			new PhoneField(),
			new TextareaField(),
			new SelectField(),
			new CheckboxField(),
			new RadioField(),
			new DateField(),
		];

		foreach ( $types as $field ) {
			self::$fields[ $field->get_type() ] = $field;
		}

		do_action( 'dk_register_field_types', self::$fields );
	}

	public static function get( string $type ): ?FieldInterface {
		if ( empty( self::$fields ) ) {
			self::boot();
		}
		return self::$fields[ $type ] ?? null;
	}

	/** @return array<string, FieldInterface> */
	public static function all(): array {
		if ( empty( self::$fields ) ) {
			self::boot();
		}
		return self::$fields;
	}
}
