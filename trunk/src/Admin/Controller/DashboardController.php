<?php
declare(strict_types=1);

namespace DentalKit\Admin\Controller;

class DashboardController {

	public function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Insufficient permissions.', 'dentalkit' ) );
		}

		require DK_PLUGIN_DIR . 'views/admin/dashboard.php';
	}
}
