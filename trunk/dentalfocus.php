<?php
declare(strict_types=1);
/**
 * Plugin Name: Dental Focus
 * Plugin URI:  https://wordpress.org/plugins/dentalfocus/
 * Description: Complete dental practice website toolkit â€” drag-and-drop form builder, custom post types, submissions management, CSV export, and social media management.
 * Version:     2.8.0
 * Author:      Bhargav Patel
 * Author URI:  https://github.com/bhargav960143
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: dentalfocus
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP:      8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DK_VERSION',         '2.8.0' );
define( 'DK_PLUGIN_FILE',     __FILE__ );
define( 'DK_PLUGIN_DIR',      plugin_dir_path( __FILE__ ) );
define( 'DK_PLUGIN_URL',      plugin_dir_url( __FILE__ ) );
define( 'DK_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

spl_autoload_register( static function ( string $class ): void {
	$prefix   = 'DentalFocus\\';
	$base_dir = DK_PLUGIN_DIR . 'src/';

	if ( ! str_starts_with( $class, $prefix ) ) {
		return;
	}

	$relative = substr( $class, strlen( $prefix ) );
	$file     = $base_dir . str_replace( '\\', '/', $relative ) . '.php';

	if ( file_exists( $file ) ) {
		require $file;
	}
} );

register_activation_hook( __FILE__, [ 'DentalFocus\\Activator', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'DentalFocus\\Deactivator', 'deactivate' ] );

add_action( 'plugins_loaded', static function (): void {
	load_plugin_textdomain( 'DentalFocus', false, dirname( DK_PLUGIN_BASENAME ) . '/languages' );
	DentalFocus\Plugin::instance()->run();
} );
