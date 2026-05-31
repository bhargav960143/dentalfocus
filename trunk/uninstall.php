<?php
declare(strict_types=1);

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

$tables = [
	$wpdb->prefix . 'dk_forms',
	$wpdb->prefix . 'dk_submissions',
	$wpdb->prefix . 'dk_social_media',
];

foreach ( $tables as $table ) {
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$wpdb->query( "DROP TABLE IF EXISTS `{$table}`" );
}

delete_option( 'dk_settings' );
delete_option( 'dk_db_version' );
