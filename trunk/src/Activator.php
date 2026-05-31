<?php
declare(strict_types=1);

namespace DentalKit;

class Activator {

	public static function activate(): void {
		self::check_requirements();
		self::create_tables();
		self::set_defaults();
		flush_rewrite_rules();
	}

	private static function check_requirements(): void {
		if ( version_compare( PHP_VERSION, Plugin::MIN_PHP, '<' ) ) {
			deactivate_plugins( DK_PLUGIN_BASENAME );
			wp_die(
				/* translators: %s: minimum PHP version */
				sprintf( esc_html__( 'DentalKit requires PHP %s or higher.', 'dentalkit' ), Plugin::MIN_PHP )
			);
		}

		if ( version_compare( get_bloginfo( 'version' ), Plugin::MIN_WP, '<' ) ) {
			deactivate_plugins( DK_PLUGIN_BASENAME );
			wp_die(
				/* translators: %s: minimum WordPress version */
				sprintf( esc_html__( 'DentalKit requires WordPress %s or higher.', 'dentalkit' ), Plugin::MIN_WP )
			);
		}
	}

	private static function create_tables(): void {
		global $wpdb;

		$collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( "CREATE TABLE {$wpdb->prefix}dk_forms (
			id          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			name        VARCHAR(255)        NOT NULL,
			description TEXT                         DEFAULT NULL,
			fields_json LONGTEXT            NOT NULL,
			status      VARCHAR(20)         NOT NULL DEFAULT 'active',
			created_at  DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at  DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY idx_status (status)
		) {$collate};" );

		dbDelta( "CREATE TABLE {$wpdb->prefix}dk_submissions (
			id          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			form_id     BIGINT(20) UNSIGNED NOT NULL,
			data_json   LONGTEXT            NOT NULL,
			ip_address  VARCHAR(45)                  DEFAULT NULL,
			user_agent  VARCHAR(512)                 DEFAULT NULL,
			created_at  DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY idx_form_id (form_id),
			KEY idx_created (created_at)
		) {$collate};" );

		dbDelta( "CREATE TABLE {$wpdb->prefix}dk_social_media (
			id         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			title      VARCHAR(255)     NOT NULL,
			slug       VARCHAR(255)     NOT NULL,
			url        VARCHAR(500)     NOT NULL DEFAULT '',
			created_at DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			UNIQUE KEY udx_slug (slug)
		) {$collate};" );

		update_option( 'dk_db_version', Plugin::VERSION );
	}

	private static function set_defaults(): void {
		add_option( 'dk_settings', [
			'email_notifications' => true,
			'notification_email'  => get_option( 'admin_email' ),
			'recaptcha_enabled'   => false,
			'recaptcha_site_key'  => '',
			'recaptcha_secret'    => '',
		] );
	}
}
