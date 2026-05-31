<?php
declare(strict_types=1);

namespace DentalFocus\REST;

use DentalFocus\FormBuilder\FormRepository;
use DentalFocus\FormBuilder\SubmissionRepository;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

class FormEndpoint {

	private const NS = 'DentalFocus/v1';

	public function register_routes(): void {
		register_rest_route( self::NS, '/forms', [
			[
				'methods'             => 'GET',
				'callback'            => [ $this, 'index' ],
				'permission_callback' => [ $this, 'admin_only' ],
			],
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'store' ],
				'permission_callback' => [ $this, 'admin_only' ],
				'args'                => $this->form_schema(),
			],
		] );

		register_rest_route( self::NS, '/forms/(?P<id>\d+)', [
			[
				'methods'             => 'GET',
				'callback'            => [ $this, 'show' ],
				'permission_callback' => [ $this, 'admin_only' ],
			],
			[
				'methods'             => 'PUT,PATCH',
				'callback'            => [ $this, 'update' ],
				'permission_callback' => [ $this, 'admin_only' ],
				'args'                => $this->form_schema(),
			],
			[
				'methods'             => 'DELETE',
				'callback'            => [ $this, 'destroy' ],
				'permission_callback' => [ $this, 'admin_only' ],
			],
		] );
	}

	public function admin_only(): bool|WP_Error {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'forbidden', __( 'Insufficient permissions.', 'DentalFocus' ), [ 'status' => 403 ] );
		}
		return true;
	}

	public function index(): WP_REST_Response {
		$repo  = new FormRepository();
		$forms = $repo->all();

		foreach ( $forms as &$form ) {
			$form['fields']           = json_decode( $form['fields_json'], true ) ?? [];
			$form['submission_count'] = ( new SubmissionRepository() )->count_by_form( (int) $form['id'] );
			unset( $form['fields_json'] );
		}

		return rest_ensure_response( $forms );
	}

	public function show( WP_REST_Request $request ): WP_REST_Response|WP_Error {
		$repo = new FormRepository();
		$form = $repo->find_with_fields( (int) $request->get_param( 'id' ) );

		if ( ! $form ) {
			return new WP_Error( 'not_found', __( 'Form not found.', 'DentalFocus' ), [ 'status' => 404 ] );
		}

		unset( $form['fields_json'] );
		return rest_ensure_response( $form );
	}

	public function store( WP_REST_Request $request ): WP_REST_Response|WP_Error {
		$repo = new FormRepository();
		$id   = $repo->create(
			sanitize_text_field( $request->get_param( 'name' ) ),
			sanitize_textarea_field( $request->get_param( 'description' ) ?? '' ),
			$this->sanitize_fields( (array) ( $request->get_param( 'fields' ) ?? [] ) )
		);

		$form = $repo->find_with_fields( $id );
		unset( $form['fields_json'] );

		return rest_ensure_response( $form );
	}

	public function update( WP_REST_Request $request ): WP_REST_Response|WP_Error {
		$id   = (int) $request->get_param( 'id' );
		$repo = new FormRepository();

		if ( ! $repo->find( $id ) ) {
			return new WP_Error( 'not_found', __( 'Form not found.', 'DentalFocus' ), [ 'status' => 404 ] );
		}

		$repo->update(
			$id,
			sanitize_text_field( $request->get_param( 'name' ) ),
			sanitize_textarea_field( $request->get_param( 'description' ) ?? '' ),
			$this->sanitize_fields( (array) ( $request->get_param( 'fields' ) ?? [] ) )
		);

		$form = $repo->find_with_fields( $id );
		unset( $form['fields_json'] );

		return rest_ensure_response( $form );
	}

	public function destroy( WP_REST_Request $request ): WP_REST_Response|WP_Error {
		$id   = (int) $request->get_param( 'id' );
		$repo = new FormRepository();

		if ( ! $repo->find( $id ) ) {
			return new WP_Error( 'not_found', __( 'Form not found.', 'DentalFocus' ), [ 'status' => 404 ] );
		}

		$repo->delete( $id );
		return rest_ensure_response( [ 'deleted' => true, 'id' => $id ] );
	}

	private function sanitize_fields( array $fields ): array {
		$allowed_types = [ 'text', 'email', 'phone', 'textarea', 'select', 'checkbox', 'radio', 'date' ];
		$clean         = [];

		foreach ( $fields as $field ) {
			if ( ! is_array( $field ) ) {
				continue;
			}
			$type = sanitize_key( $field['type'] ?? 'text' );
			if ( ! in_array( $type, $allowed_types, true ) ) {
				continue;
			}

			$clean_field = [
				'id'          => sanitize_key( $field['id'] ?? wp_generate_uuid4() ),
				'type'        => $type,
				'label'       => sanitize_text_field( $field['label'] ?? '' ),
				'placeholder' => sanitize_text_field( $field['placeholder'] ?? '' ),
				'required'    => (bool) ( $field['required'] ?? false ),
				'order'       => absint( $field['order'] ?? 0 ),
			];

			if ( in_array( $type, [ 'select', 'checkbox', 'radio' ], true ) ) {
				$clean_field['options'] = array_map(
					'sanitize_text_field',
					(array) ( $field['options'] ?? [] )
				);
			}

			if ( 'textarea' === $type ) {
				$clean_field['rows'] = absint( $field['rows'] ?? 5 );
			}

			$clean[] = $clean_field;
		}

		return $clean;
	}

	private function form_schema(): array {
		return [
			'name'        => [ 'required' => true,  'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ],
			'description' => [ 'required' => false, 'type' => 'string' ],
			'fields'      => [ 'required' => true,  'type' => 'array' ],
		];
	}
}
