<?php
declare(strict_types=1);

namespace DentalFocus\Admin\Controller;

use DentalFocus\FormBuilder\FormRepository;

class SettingsController {

	public function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Insufficient permissions.', 'DentalFocus' ) );
		}

		$tab = sanitize_key( $_GET['tab'] ?? 'general' );

		if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
			$this->handle_post( $tab );
		}

		$action = sanitize_key( $_GET['action'] ?? 'index' );

		match ( $action ) {
			'social-add'    => $this->render_social_form( 'add' ),
			'social-edit'   => $this->render_social_form( 'edit' ),
			'social-save'   => $this->handle_social_save(),
			'social-delete' => $this->handle_social_delete(),
			default         => $this->render_index( $tab ),
		};
	}

	public function handle_hours_post(): void {
		if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
			return;
		}
		if ( empty( $_POST['dk_hours_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dk_hours_nonce'] ) ), 'dk_hours_save' ) ) {
			return;
		}
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$days  = [ 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' ];
		$hours = [];
		foreach ( $days as $day ) {
			$hours[ $day ] = [
				'open' => ! empty( $_POST['hours'][ $day ]['open'] ),
				'from' => sanitize_text_field( wp_unslash( $_POST['hours'][ $day ]['from'] ?? '' ) ),
				'to'   => sanitize_text_field( wp_unslash( $_POST['hours'][ $day ]['to']   ?? '' ) ),
			];
		}
		update_option( 'dk_opening_hours', $hours );

		wp_safe_redirect(
			add_query_arg( [ 'page' => 'dk-settings', 'tab' => 'hours', 'saved' => '1' ], admin_url( 'admin.php' ) )
		);
		exit;
	}

	private function render_index( string $tab ): void {
		global $wpdb;

		$settings      = get_option( 'dk_settings', [] );
		$social_media  = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}dk_social_media ORDER BY title ASC",
			ARRAY_A
		);

		require DK_PLUGIN_DIR . 'views/admin/settings/index.php';
	}

	private function handle_post( string $tab ): void {
		if ( 'general' !== $tab ) {
			return;
		}

		check_admin_referer( 'dk_settings_save' );

		$settings = [
			'email_notifications' => (bool) ( $_POST['email_notifications'] ?? false ),
			'notification_email'  => sanitize_email( wp_unslash( $_POST['notification_email'] ?? '' ) ),
			'recaptcha_enabled'   => (bool) ( $_POST['recaptcha_enabled'] ?? false ),
			'recaptcha_site_key'  => sanitize_text_field( wp_unslash( $_POST['recaptcha_site_key'] ?? '' ) ),
			'recaptcha_secret'    => sanitize_text_field( wp_unslash( $_POST['recaptcha_secret']    ?? '' ) ),
			'gdpr_enabled'             => (bool) ( $_POST['gdpr_enabled'] ?? false ),
			'gdpr_label'               => sanitize_text_field( wp_unslash( $_POST['gdpr_label']               ?? '' ) ),
			'gdpr_privacy_url'         => esc_url_raw( wp_unslash( $_POST['gdpr_privacy_url']         ?? '' ) ),
			'patient_confirmation'     => (bool) ( $_POST['patient_confirmation'] ?? false ),
			'confirmation_subject'     => sanitize_text_field( wp_unslash( $_POST['confirmation_subject']     ?? '' ) ),
			'confirmation_body'        => sanitize_textarea_field( wp_unslash( $_POST['confirmation_body']    ?? '' ) ),
			'confirmation_from_name'   => sanitize_text_field( wp_unslash( $_POST['confirmation_from_name']   ?? '' ) ),
			'confirmation_from_email'  => sanitize_email( wp_unslash( $_POST['confirmation_from_email']       ?? '' ) ),
		];

		update_option( 'dk_settings', $settings );

		wp_safe_redirect(
			add_query_arg( [ 'page' => 'dk-settings', 'tab' => 'general', 'saved' => '1' ], admin_url( 'admin.php' ) )
		);
		exit;
	}

	private function render_social_form( string $mode ): void {
		global $wpdb;

		$social = null;
		if ( 'edit' === $mode ) {
			$id     = absint( $_GET['id'] ?? 0 );
			$social = $wpdb->get_row(
				$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}dk_social_media WHERE id = %d", $id ),
				ARRAY_A
			);
			if ( ! $social ) {
				wp_die( esc_html__( 'Social media entry not found.', 'DentalFocus' ) );
			}
		}

		require DK_PLUGIN_DIR . 'views/admin/settings/social-form.php';
	}

	private function handle_social_save(): void {
		check_admin_referer( 'dk_social_save' );

		global $wpdb;

		$id    = absint( $_POST['id'] ?? 0 );
		$title = sanitize_text_field( wp_unslash( $_POST['title'] ?? '' ) );
		$url   = esc_url_raw( wp_unslash( $_POST['url']   ?? '' ) );

		if ( ! $title || ! $url ) {
			wp_die( esc_html__( 'Title and URL are required.', 'DentalFocus' ) );
		}

		if ( $id ) {
			$wpdb->update(
				$wpdb->prefix . 'dk_social_media',
				[ 'title' => $title, 'slug' => sanitize_title( $title ), 'url' => $url ],
				[ 'id' => $id ],
				[ '%s', '%s', '%s' ],
				[ '%d' ]
			);
		} else {
			$wpdb->insert(
				$wpdb->prefix . 'dk_social_media',
				[ 'title' => $title, 'slug' => sanitize_title( $title ), 'url' => $url ],
				[ '%s', '%s', '%s' ]
			);
		}

		wp_safe_redirect(
			add_query_arg( [ 'page' => 'dk-settings', 'tab' => 'social', 'saved' => '1' ], admin_url( 'admin.php' ) )
		);
		exit;
	}

	private function handle_social_delete(): void {
		$id = absint( $_GET['id'] ?? 0 );
		if ( ! $id ) {
			wp_die( esc_html__( 'Invalid ID.', 'DentalFocus' ) );
		}

		check_admin_referer( 'dk_social_delete_' . $id );

		global $wpdb;
		$wpdb->delete( $wpdb->prefix . 'dk_social_media', [ 'id' => $id ], [ '%d' ] );

		wp_safe_redirect(
			add_query_arg( [ 'page' => 'dk-settings', 'tab' => 'social', 'deleted' => '1' ], admin_url( 'admin.php' ) )
		);
		exit;
	}
}
