<?php
declare(strict_types=1);

namespace DentalKit\FormBuilder;

use DentalKit\FormBuilder\Fields\FieldRegistry;

class SubmissionHandler {

	public function handle(): void {
		$form_id = absint( $_POST['form_id'] ?? 0 );

		if ( ! $form_id ) {
			wp_send_json_error( [ 'message' => __( 'Invalid form.', 'dentalkit' ) ], 400 );
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_nonce'] ?? '' ) ), 'dk_submit_' . $form_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Security check failed.', 'dentalkit' ) ], 403 );
		}

		$repo = new FormRepository();
		$form = $repo->find_with_fields( $form_id );

		if ( ! $form || 'active' !== $form['status'] ) {
			wp_send_json_error( [ 'message' => __( 'Form not found.', 'dentalkit' ) ], 404 );
		}

		$raw_fields = (array) ( $_POST['dk_fields'] ?? [] );
		$data       = [];
		$errors     = [];

		foreach ( $form['fields'] as $field ) {
			$field_id = $field['id'];
			$type     = $field['type'] ?? 'text';
			$handler  = FieldRegistry::get( $type );

			if ( ! $handler ) {
				continue;
			}

			$raw   = $raw_fields[ $field_id ] ?? null;
			$clean = $handler->sanitize( $raw );
			$valid = $handler->validate( $clean, $field );

			if ( true !== $valid ) {
				$errors[ $field_id ] = $valid;
			} else {
				$data[ $field_id ] = [
					'label' => $field['label'] ?? $field_id,
					'value' => $clean,
				];
			}
		}

		if ( $errors ) {
			wp_send_json_error( [ 'errors' => $errors ], 422 );
		}

		$submission_repo = new SubmissionRepository();
		$submission_id   = $submission_repo->create(
			$form_id,
			$data,
			$this->get_client_ip(),
			sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ?? '' ) )
		);

		$this->maybe_send_notification( $form, $data );

		wp_send_json_success( [
			'message'       => __( 'Thank you! Your message has been sent.', 'dentalkit' ),
			'submission_id' => $submission_id,
		] );
	}

	private function get_client_ip(): string {
		$keys = [ 'HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' ];
		foreach ( $keys as $key ) {
			if ( ! empty( $_SERVER[ $key ] ) ) {
				$ip = sanitize_text_field( wp_unslash( $_SERVER[ $key ] ) );
				return explode( ',', $ip )[0];
			}
		}
		return '';
	}

	private function maybe_send_notification( array $form, array $data ): void {
		$settings = get_option( 'dk_settings', [] );

		if ( empty( $settings['email_notifications'] ) ) {
			return;
		}

		$to      = sanitize_email( $settings['notification_email'] ?? get_option( 'admin_email' ) );
		$subject = sprintf(
			/* translators: %s: form name */
			__( 'New submission: %s', 'dentalkit' ),
			$form['name']
		);

		$body = sprintf( "New form submission received for: %s\n\n", $form['name'] );
		foreach ( $data as $item ) {
			$val   = is_array( $item['value'] ) ? implode( ', ', $item['value'] ) : $item['value'];
			$body .= sprintf( "%s: %s\n", $item['label'], $val );
		}

		wp_mail( $to, $subject, $body );
	}
}
