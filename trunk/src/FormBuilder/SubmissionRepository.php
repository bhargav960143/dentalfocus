<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder;

class SubmissionRepository {

	private string $table;

	public function __construct() {
		global $wpdb;
		$this->table = $wpdb->prefix . 'dk_submissions';
	}

	/** @return array<int, array<string, mixed>> */
	public function all(): array {
		global $wpdb;
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results( "SELECT * FROM `{$this->table}` ORDER BY created_at DESC", ARRAY_A ) ?: [];
	}

	/** @return array<int, array<string, mixed>> */
	public function by_form( int $form_id ): array {
		global $wpdb;
		return $wpdb->get_results(
			$wpdb->prepare( "SELECT * FROM `{$this->table}` WHERE form_id = %d ORDER BY created_at DESC", $form_id ),
			ARRAY_A
		) ?: [];
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

	public function create( int $form_id, array $data, string $ip, string $user_agent ): int {
		global $wpdb;
		$wpdb->insert(
			$this->table,
			[
				'form_id'    => $form_id,
				'data_json'  => wp_json_encode( $data ),
				'ip_address' => $ip,
				'user_agent' => $user_agent,
			],
			[ '%d', '%s', '%s', '%s' ]
		);
		return (int) $wpdb->insert_id;
	}

	public function delete( int $id ): bool {
		global $wpdb;
		return (bool) $wpdb->delete( $this->table, [ 'id' => $id ], [ '%d' ] );
	}

	public function count_by_form( int $form_id ): int {
		global $wpdb;
		return (int) $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM `{$this->table}` WHERE form_id = %d", $form_id )
		);
	}

	public function count(): int {
		global $wpdb;
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return (int) $wpdb->get_var( "SELECT COUNT(*) FROM `{$this->table}`" );
	}
}
