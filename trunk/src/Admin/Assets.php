<?php
declare(strict_types=1);

namespace DentalFocus\Admin;

class Assets {

	private const ADMIN_PAGES = [
		'toplevel_page_DentalFocus',
		'DentalFocus_page_dk-forms',
		'DentalFocus_page_dk-submissions',
		'DentalFocus_page_dk-settings',
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
			'rest_url'  => rest_url( 'DentalFocus/v1/' ),
			'nonce'     => wp_create_nonce( 'wp_rest' ),
			'admin_url' => admin_url( 'admin.php' ),
			'i18n'      => [
				'save_success'   => __( 'Form saved successfully.', 'DentalFocus' ),
				'save_error'     => __( 'Error saving form. Please try again.', 'DentalFocus' ),
				'confirm_delete' => __( 'Are you sure you want to delete this field?', 'DentalFocus' ),
				'field_label'    => __( 'Field Label', 'DentalFocus' ),
				'untitled_form'  => __( 'Untitled Form', 'DentalFocus' ),
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

		wp_enqueue_script(
			'dk-before-after',
			DK_PLUGIN_URL . 'assets/js/frontend/before-after.js',
			[],
			DK_VERSION,
			true
		);

		wp_localize_script( 'dk-form', 'DKForm', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'i18n'     => [
				'required'       => __( 'This field is required.', 'DentalFocus' ),
				'invalid_email'  => __( 'Please enter a valid email address.', 'DentalFocus' ),
				'invalid_phone'  => __( 'Please enter a valid phone number.', 'DentalFocus' ),
				'submit_success' => __( 'Thank you! Your message has been sent.', 'DentalFocus' ),
				'submit_error'   => __( 'An error occurred. Please try again.', 'DentalFocus' ),
				'submitting'     => __( 'Sending…', 'DentalFocus' ),
			],
		] );
	}

	public function enqueue_portfolio_meta( string $hook ): void {
		if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
			return;
		}
		global $post;
		if ( ! $post || 'dk-portfolio' !== $post->post_type ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_script(
			'dk-portfolio-meta',
			DK_PLUGIN_URL . 'assets/js/admin/portfolio-meta.js',
			[ 'jquery' ],
			DK_VERSION,
			true
		);
	}

	public function enqueue_block_editor(): void {
		wp_enqueue_script(
			'dk-blocks',
			DK_PLUGIN_URL . 'assets/js/admin/blocks.js',
			[
				'wp-blocks',
				'wp-element',
				'wp-block-editor',
				'wp-components',
				'wp-server-side-render',
				'wp-i18n',
				'wp-api-fetch',
			],
			DK_VERSION,
			true
		);
	}

	private function page_has_dk_form(): bool {
		global $post;

		if ( ! is_a( $post, 'WP_Post' ) ) {
			return false;
		}

		$tags = [ 'dk_form', 'dk_treatment_enquiry', 'dk_social', 'dk_social_list', 'dk_whatsapp', 'dk_call', 'dk_map', 'dk_opening_hours', 'dk_before_after', 'dk_testimonials', 'dk_team', 'dk_treatments', 'dk_portfolio', 'dk_banners' ];

		foreach ( $tags as $tag ) {
			if ( has_shortcode( $post->post_content, $tag ) ) {
				return true;
			}
		}

		$block_names = [
			'dentalfocus/form', 'dentalfocus/testimonials', 'dentalfocus/team',
			'dentalfocus/treatments', 'dentalfocus/portfolio', 'dentalfocus/banners',
			'dentalfocus/social', 'dentalfocus/social-list', 'dentalfocus/whatsapp',
			'dentalfocus/before-after',
		];

		foreach ( $block_names as $block_name ) {
			if ( has_block( $block_name, $post ) ) {
				return true;
			}
		}

		return false;
	}
}
