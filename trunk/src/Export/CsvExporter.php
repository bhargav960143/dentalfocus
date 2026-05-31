<?php
declare(strict_types=1);

namespace DentalFocus\Export;

class CsvExporter {

	public function stream( ?array $form, array $submissions ): void {
		$form_name = $form ? sanitize_file_name( $form['name'] ) : 'submissions';
		$filename  = 'dk-' . $form_name . '-' . gmdate( 'Y-m-d' ) . '.csv';

		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
		header( 'Cache-Control: no-store, no-cache' );
		header( 'Pragma: no-cache' );

		$out = fopen( 'php://output', 'w' );
		if ( false === $out ) {
			return;
		}

		// BOM for Excel UTF-8 compatibility
		fwrite( $out, "\xEF\xBB\xBF" );

		if ( empty( $submissions ) ) {
			fputcsv( $out, [ __( 'No submissions found.', 'DentalFocus' ) ] );
			fclose( $out );
			return;
		}

		$headers = $this->extract_headers( $submissions );
		fputcsv( $out, array_merge( [ 'ID', 'Date' ], array_values( $headers ) ) );

		foreach ( $submissions as $sub ) {
			$data = json_decode( $sub['data_json'], true ) ?? [];
			$row  = [ $sub['id'], $sub['created_at'] ];

			foreach ( array_keys( $headers ) as $field_id ) {
				$item  = $data[ $field_id ] ?? null;
				$value = $item['value'] ?? '';
				$value = is_array( $value ) ? implode( ', ', $value ) : (string) $value;
				$row[] = $this->sanitize_csv_value( $value );
			}

			fputcsv( $out, $row );
		}

		fclose( $out );
	}

	private function sanitize_csv_value( string $value ): string {
		if ( $value !== '' && in_array( $value[0], [ '=', '+', '-', '@', "\t", "\r" ], true ) ) {
			return "\t" . $value;
		}
		return $value;
	}

	/** @return array<string, string> field_id => label */
	private function extract_headers( array $submissions ): array {
		$headers = [];
		foreach ( $submissions as $sub ) {
			$data = json_decode( $sub['data_json'], true ) ?? [];
			foreach ( $data as $field_id => $item ) {
				if ( ! isset( $headers[ $field_id ] ) ) {
					$headers[ $field_id ] = $item['label'] ?? $field_id;
				}
			}
		}
		return $headers;
	}
}
