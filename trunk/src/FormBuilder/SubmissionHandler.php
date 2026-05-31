<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder;

use DentalFocus\FormBuilder\Fields\FieldRegistry;

class SubmissionHandler {

	public function handle(): void {
		$form_id = absint( $_POST['form_id'] ?? 0 );

		if ( ! $form_id ) {
			wp_send_json_error( [ 'message' => __( 'Invalid form.', 'DentalFocus' ) ], 400 );
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_nonce'] ?? '' ) ), 'dk_submit_' . $form_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Security check failed.', 'DentalFocus' ) ], 403 );
		}

		$repo = new FormRepository();
		$form = $repo->find_with_fields( $form_id );

		if ( ! $form || 'active' !== $form['status'] ) {
			wp_send_json_error( [ 'message' => __( 'Form not found.', 'DentalFocus' ) ], 404 );
		}

		if ( ! empty( $_POST['dk_hp_field'] ) ) {
			wp_send_json_error( [ 'message' => __( 'Spam detected.', 'DentalFocus' ) ], 400 );
		}

		$settings = get_option( 'dk_settings', [] );
		if ( ! empty( $settings['gdpr_enabled'] ) ) {
			$consent = (array) ( $_POST['dk_fields']['dk_gdpr_consent'] ?? [] );
			if ( ! in_array( '1', $consent, true ) ) {
				wp_send_json_error( [
					'errors' => [ 'dk_gdpr_consent' => __( 'You must accept the privacy policy to continue.', 'DentalFocus' ) ],
				], 422 );
			}
		}

		$raw_fields = (array) ( $_POST['dk_fields'] ?? [] );
		unset( $raw_fields['dk_gdpr_consent'] );

		$treatment_name = sanitize_text_field( wp_unslash( $_POST['dk_treatment_enquiry_name'] ?? '' ) );
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

		if ( $treatment_name ) {
			$data = array_merge(
				[ '_treatment' => [ 'label' => __( 'Treatment Enquiry', 'DentalFocus' ), 'value' => $treatment_name ] ],
				$data
			);
		}

		$user_agent = sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ?? '' ) );
		if ( mb_strlen( $user_agent ) > 512 ) {
			$user_agent = mb_substr( $user_agent, 0, 512 );
		}

		$submission_repo = new SubmissionRepository();
		$submission_id   = $submission_repo->create(
			$form_id,
			$data,
			$this->get_client_ip(),
			$user_agent
		);

		$this->maybe_send_notification( $form, $data );
		$this->maybe_send_patient_confirmation( $form, $data );

		$confirmation = sanitize_text_field( $form['confirmation_message'] ?? '' );
		wp_send_json_success( [
			'message'       => $confirmation ?: __( 'Thank you! Your message has been sent.', 'DentalFocus' ),
			'submission_id' => $submission_id,
		] );
	}

	private function get_client_ip(): string {
		$ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) );

		// Only trust forwarded headers if REMOTE_ADDR is a known private/proxy range
		if ( $this->is_trusted_proxy( $ip ) ) {
			foreach ( [ 'HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR' ] as $key ) {
				if ( ! empty( $_SERVER[ $key ] ) ) {
					$forwarded = sanitize_text_field( wp_unslash( $_SERVER[ $key ] ) );
					$candidate = trim( explode( ',', $forwarded )[0] );
					if ( filter_var( $candidate, FILTER_VALIDATE_IP ) ) {
						return $candidate;
					}
				}
			}
		}

		return filter_var( $ip, FILTER_VALIDATE_IP ) ? $ip : '';
	}

	private function is_trusted_proxy( string $ip ): bool {
		$private_ranges = [
			'10.0.0.0/8',
			'172.16.0.0/12',
			'192.168.0.0/16',
			'127.0.0.0/8',
		];
		foreach ( $private_ranges as $range ) {
			[ $subnet, $bits ] = explode( '/', $range );
			$ip_long     = ip2long( $ip );
			$subnet_long = ip2long( $subnet );
			$mask        = -1 << ( 32 - (int) $bits );
			if ( ( $ip_long & $mask ) === ( $subnet_long & $mask ) ) {
				return true;
			}
		}
		return false;
	}

	private function maybe_send_notification( array $form, array $data ): void {
		$settings = get_option( 'dk_settings', [] );

		if ( empty( $settings['email_notifications'] ) ) {
			return;
		}

		$to      = sanitize_email( $settings['notification_email'] ?? get_option( 'admin_email' ) );
		$subject = sprintf(
			/* translators: %s: form name */
			__( 'New submission: %s', 'DentalFocus' ),
			$form['name']
		);

		$body = sprintf( "New form submission received for: %s\n\n", $form['name'] );
		foreach ( $data as $item ) {
			$val   = is_array( $item['value'] ) ? implode( ', ', $item['value'] ) : $item['value'];
			$body .= sprintf( "%s: %s\n", $item['label'], $val );
		}

		wp_mail( $to, $subject, $body );
	}

	private function maybe_send_patient_confirmation( array $form, array $data ): void {
		$settings = get_option( 'dk_settings', [] );

		if ( empty( $settings['patient_confirmation'] ) ) {
			return;
		}

		$patient_email = '';
		foreach ( $data as $item ) {
			if ( is_string( $item['value'] ) && is_email( $item['value'] ) ) {
				$patient_email = $item['value'];
				break;
			}
		}

		if ( ! $patient_email ) {
			return;
		}

		$subject = sanitize_text_field(
			$settings['confirmation_subject'] ?? sprintf( __( 'Thank you for contacting us — %s', 'DentalFocus' ), get_bloginfo( 'name' ) )
		);

		$body = wp_kses_post(
			$settings['confirmation_body'] ?? sprintf(
				__( "Dear Patient,\n\nThank you for getting in touch. We have received your enquiry and will get back to you shortly.\n\nPractice: %s", 'DentalFocus' ),
				get_bloginfo( 'name' )
			)
		);

		$from_name  = sanitize_text_field( $settings['confirmation_from_name']  ?? get_bloginfo( 'name' ) );
		$from_email = sanitize_email( $settings['confirmation_from_email'] ?? get_option( 'admin_email' ) );

		$headers = [
			'Content-Type: text/plain; charset=UTF-8',
			'From: ' . $from_name . ' <' . $from_email . '>',
		];

		wp_mail( $patient_email, $subject, $body, $headers );
	}
}
