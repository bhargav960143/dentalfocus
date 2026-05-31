<?php
declare(strict_types=1);

namespace DentalKit\Admin\Controller;

use DentalKit\FormBuilder\FormRepository;

class FormBuilderController {

	private FormRepository $repo;

	public function __construct() {
		$this->repo = new FormRepository();
	}

	public function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Insufficient permissions.', 'dentalkit' ) );
		}

		$action = sanitize_key( $_GET['action'] ?? 'index' );

		match ( $action ) {
			'edit', 'create' => $this->render_edit(),
			'delete'         => $this->handle_delete(),
			default          => $this->render_index(),
		};
	}

	private function render_index(): void {
		$forms = $this->repo->all();
		require DK_PLUGIN_DIR . 'views/admin/form-builder/index.php';
	}

	private function render_edit(): void {
		$id   = absint( $_GET['id'] ?? 0 );
		$form = $id ? $this->repo->find( $id ) : null;

		if ( $id && ! $form ) {
			wp_die( esc_html__( 'Form not found.', 'dentalkit' ) );
		}

		require DK_PLUGIN_DIR . 'views/admin/form-builder/edit.php';
	}

	private function handle_delete(): void {
		$id = absint( $_GET['id'] ?? 0 );

		if ( ! $id ) {
			wp_die( esc_html__( 'Invalid form ID.', 'dentalkit' ) );
		}

		check_admin_referer( 'dk_delete_form_' . $id );

		$this->repo->delete( $id );

		wp_safe_redirect(
			add_query_arg( [ 'page' => 'dk-forms', 'deleted' => '1' ], admin_url( 'admin.php' ) )
		);
		exit;
	}
}
