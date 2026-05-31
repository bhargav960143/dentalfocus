<?php
declare(strict_types=1);

namespace DentalKit\Admin;

class Assets {

	private const ADMIN_PAGES = [
		'toplevel_page_dentalkit',
		'dentalkit_page_dk-forms',
		'dentalkit_page_dk-submissions',
		'dentalkit_page_dk-settings',
	];

	public function enqueue_admin( string $hook ): void {
		if ( ! in_array( $hook, self::ADMIN_PAGES, true ) ) {
			return;
		}

		wp_enqueue_style(
			'dk-admin',
			DK_PLUGIN_URL . 'assets/css/admin.css',
			[],
			DK_VERSION
		);

		wp_enqueue_script(
			'sortablejs',
			'https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js',
			[],
			'1.15.3',
			true
		);

		wp_enqueue_script(
			'dk-form-builder',
			DK_PLUGIN_URL . 'assets/js/admin/form-builder.js',
			[ 'jquery', 'sortablejs', 'wp-api-fetch' ],
			DK_VERSION,
			true
		);

		wp_enqueue_script(
			'dk-submissions',
			DK_PLUGIN_URL . 'assets/js/admin/submissions.js',
			[ 'jquery' ],
			DK_VERSION,
			true
		);

		wp_localize_script( 'dk-form-builder', 'DK', [
			'rest_url'  => rest_url( 'dentalkit/v1/' ),
			'nonce'     => wp_create_nonce( 'wp_rest' ),
			'admin_url' => admin_url( 'admin.php' ),
			'i18n'      => [
				'save_success'   => __( 'Form saved successfully.', 'dentalkit' ),
				'save_error'     => __( 'Error saving form. Please try again.', 'dentalkit' ),
				'confirm_delete' => __( 'Are you sure you want to delete this field?', 'dentalkit' ),
				'field_label'    => __( 'Field Label', 'dentalkit' ),
				'untitled_form'  => __( 'Untitled Form', 'dentalkit' ),
			],
		] );
	}

	public function enqueue_frontend(): void {
		if ( ! $this->page_has_dk_form() ) {
			return;
		}

		wp_enqueue_style(
			'dk-frontend',
			DK_PLUGIN_URL . 'assets/css/frontend.css',
			[],
			DK_VERSION
		);

		wp_enqueue_script(
			'dk-form',
			DK_PLUGIN_URL . 'assets/js/frontend/form.js',
			[ 'jquery' ],
			DK_VERSION,
			true
		);

		wp_localize_script( 'dk-form', 'DKForm', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'i18n'     => [
				'required'       => __( 'This field is required.', 'dentalkit' ),
				'invalid_email'  => __( 'Please enter a valid email address.', 'dentalkit' ),
				'invalid_phone'  => __( 'Please enter a valid phone number.', 'dentalkit' ),
				'submit_success' => __( 'Thank you! Your message has been sent.', 'dentalkit' ),
				'submit_error'   => __( 'An error occurred. Please try again.', 'dentalkit' ),
				'submitting'     => __( 'Sending…', 'dentalkit' ),
			],
		] );
	}

	private function page_has_dk_form(): bool {
		global $post;

		if ( ! is_a( $post, 'WP_Post' ) ) {
			return false;
		}

		$tags = [ 'dk_form', 'dk_social', 'dk_social_list', 'dk_testimonials', 'dk_team', 'dk_treatments', 'dk_portfolio', 'dk_banners' ];

		foreach ( $tags as $tag ) {
			if ( has_shortcode( $post->post_content, $tag ) ) {
				return true;
			}
		}

		return false;
	}
}
