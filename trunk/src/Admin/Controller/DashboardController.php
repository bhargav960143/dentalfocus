<?php
declare(strict_types=1);

namespace DentalFocus\Admin\Controller;

class DashboardController {

	public function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Insufficient permissions.', 'DentalFocus' ) );
		}

		require DK_PLUGIN_DIR . 'views/admin/dashboard.php';
	}
}
