<?php
declare(strict_types=1);

namespace DentalKit\Admin\Controller;

use DentalKit\FormBuilder\FormRepository;

class SettingsController {

	public function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Insufficient permissions.', 'dentalkit' ) );
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
			'notification_email'  => sanitize_email( $_POST['notification_email'] ?? '' ),
			'recaptcha_enabled'   => (bool) ( $_POST['recaptcha_enabled'] ?? false ),
			'recaptcha_site_key'  => sanitize_text_field( $_POST['recaptcha_site_key'] ?? '' ),
			'recaptcha_secret'    => sanitize_text_field( $_POST['recaptcha_secret'] ?? '' ),
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
				wp_die( esc_html__( 'Social media entry not found.', 'dentalkit' ) );
			}
		}

		require DK_PLUGIN_DIR . 'views/admin/settings/social-form.php';
	}

	private function handle_social_save(): void {
		check_admin_referer( 'dk_social_save' );

		global $wpdb;

		$id    = absint( $_POST['id'] ?? 0 );
		$title = sanitize_text_field( $_POST['title'] ?? '' );
		$url   = esc_url_raw( $_POST['url'] ?? '' );

		if ( ! $title || ! $url ) {
			wp_die( esc_html__( 'Title and URL are required.', 'dentalkit' ) );
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
			wp_die( esc_html__( 'Invalid ID.', 'dentalkit' ) );
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
