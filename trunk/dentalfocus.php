<?php
/**
 * Plugin Name: DentalKit
 * Plugin URI:  https://wordpress.org/plugins/dentalfocus/
 * Description: Complete dental practice website toolkit — drag-and-drop form builder, custom post types, submissions management, CSV export, and social media management.
 * Version:     2.0.0
 * Author:      Bhargav Patel
 * Author URI:  https://www.trentiums.com/bhargav
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: dentalkit
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP:      8.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DK_VERSION',         '2.0.0' );
define( 'DK_PLUGIN_FILE',     __FILE__ );
define( 'DK_PLUGIN_DIR',      plugin_dir_path( __FILE__ ) );
define( 'DK_PLUGIN_URL',      plugin_dir_url( __FILE__ ) );
define( 'DK_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

spl_autoload_register( static function ( string $class ): void {
	$prefix   = 'DentalKit\\';
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

register_activation_hook( __FILE__, [ 'DentalKit\\Activator', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'DentalKit\\Deactivator', 'deactivate' ] );

add_action( 'plugins_loaded', static function (): void {
	load_plugin_textdomain( 'dentalkit', false, dirname( DK_PLUGIN_BASENAME ) . '/languages' );
	DentalKit\Plugin::instance()->run();
} );
