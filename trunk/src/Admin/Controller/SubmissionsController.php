<?php
declare(strict_types=1);

namespace DentalKit\Admin\Controller;

use DentalKit\FormBuilder\FormRepository;
use DentalKit\FormBuilder\SubmissionRepository;
use DentalKit\Export\CsvExporter;

class SubmissionsController {

	private SubmissionRepository $repo;
	private FormRepository $form_repo;

	public function __construct() {
		$this->repo      = new SubmissionRepository();
		$this->form_repo = new FormRepository();
	}

	public function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Insufficient permissions.', 'dentalkit' ) );
		}

		$action = sanitize_key( $_GET['action'] ?? 'index' );

		match ( $action ) {
			'view'   => $this->render_view(),
			'export' => $this->handle_export(),
			'delete' => $this->handle_delete(),
			default  => $this->render_index(),
		};
	}

	private function render_index(): void {
		$form_id     = absint( $_GET['form_id'] ?? 0 );
		$forms       = $this->form_repo->all();
		$submissions = $form_id
			? $this->repo->by_form( $form_id )
			: $this->repo->all();

		require DK_PLUGIN_DIR . 'views/admin/submissions/index.php';
	}

	private function render_view(): void {
		$id         = absint( $_GET['id'] ?? 0 );
		$submission = $id ? $this->repo->find( $id ) : null;

		if ( ! $submission ) {
			wp_die( esc_html__( 'Submission not found.', 'dentalkit' ) );
		}

		$form = $this->form_repo->find( (int) $submission['form_id'] );
		require DK_PLUGIN_DIR . 'views/admin/submissions/view.php';
	}

	private function handle_export(): void {
		$form_id = absint( $_GET['form_id'] ?? 0 );
		check_admin_referer( 'dk_export_' . $form_id );

		$form = $form_id ? $this->form_repo->find( $form_id ) : null;
		$submissions = $form_id
			? $this->repo->by_form( $form_id )
			: $this->repo->all();

		( new CsvExporter() )->stream( $form, $submissions );
		exit;
	}

	private function handle_delete(): void {
		$id = absint( $_GET['id'] ?? 0 );
		if ( ! $id ) {
			wp_die( esc_html__( 'Invalid submission ID.', 'dentalkit' ) );
		}

		check_admin_referer( 'dk_delete_submission_' . $id );
		$this->repo->delete( $id );

		wp_safe_redirect(
			add_query_arg( [ 'page' => 'dk-submissions', 'deleted' => '1' ], admin_url( 'admin.php' ) )
		);
		exit;
	}
}
