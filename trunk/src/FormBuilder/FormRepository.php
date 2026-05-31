<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder;

class FormRepository {

	private string $table;

	public function __construct() {
		global $wpdb;
		$this->table = $wpdb->prefix . 'dk_forms';
	}

	/** @return array<int, array<string, mixed>> */
	public function all(): array {
		global $wpdb;
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results( "SELECT * FROM `{$this->table}` ORDER BY created_at DESC", ARRAY_A ) ?: [];
	}

	/** @return array<string, mixed>|null */
	public function find( int $id ): ?array {
		global $wpdb;
		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM `{$this->table}` WHERE id = %d", $id ),
			ARRAY_A
		);
		return $row ?: null;
	}

	/** @return array<string, mixed>|null */
	public function find_with_fields( int $id ): ?array {
		$form = $this->find( $id );
		if ( ! $form ) {
			return null;
		}
		$form['fields'] = json_decode( $form['fields_json'], true ) ?? [];
		return $form;
	}

	public function create( string $name, string $description, array $fields ): int {
		global $wpdb;
		$wpdb->insert(
			$this->table,
			[
				'name'        => $name,
				'description' => $description,
				'fields_json' => wp_json_encode( $fields ),
				'status'      => 'active',
			],
			[ '%s', '%s', '%s', '%s' ]
		);
		return (int) $wpdb->insert_id;
	}

	public function update( int $id, string $name, string $description, array $fields ): bool {
		global $wpdb;
		$result = $wpdb->update(
			$this->table,
			[
				'name'        => $name,
				'description' => $description,
				'fields_json' => wp_json_encode( $fields ),
			],
			[ 'id' => $id ],
			[ '%s', '%s', '%s' ],
			[ '%d' ]
		);
		return false !== $result;
	}

	public function delete( int $id ): bool {
		global $wpdb;
		return (bool) $wpdb->delete( $this->table, [ 'id' => $id ], [ '%d' ] );
	}

	public function count(): int {
		global $wpdb;
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return (int) $wpdb->get_var( "SELECT COUNT(*) FROM `{$this->table}`" );
	}
}
