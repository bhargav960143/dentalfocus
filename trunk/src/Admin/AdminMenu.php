<?php
declare(strict_types=1);

namespace DentalKit\Admin;

use DentalKit\Admin\Controller\DashboardController;
use DentalKit\Admin\Controller\FormBuilderController;
use DentalKit\Admin\Controller\SubmissionsController;
use DentalKit\Admin\Controller\SettingsController;

class AdminMenu {

	public function register(): void {
		$dashboard   = new DashboardController();
		$form_builder = new FormBuilderController();
		$submissions = new SubmissionsController();
		$settings    = new SettingsController();

		add_menu_page(
			__( 'DentalKit', 'dentalkit' ),
			__( 'DentalKit', 'dentalkit' ),
			'manage_options',
			'dentalkit',
			[ $dashboard, 'render' ],
			'dashicons-heart',
			81
		);

		add_submenu_page(
			'dentalkit',
			__( 'Dashboard', 'dentalkit' ),
			__( 'Dashboard', 'dentalkit' ),
			'manage_options',
			'dentalkit',
			[ $dashboard, 'render' ]
		);

		add_submenu_page(
			'dentalkit',
			__( 'Form Builder', 'dentalkit' ),
			__( 'Form Builder', 'dentalkit' ),
			'manage_options',
			'dk-forms',
			[ $form_builder, 'render' ]
		);

		add_submenu_page(
			'dentalkit',
			__( 'Submissions', 'dentalkit' ),
			__( 'Submissions', 'dentalkit' ),
			'manage_options',
			'dk-submissions',
			[ $submissions, 'render' ]
		);

		add_submenu_page(
			'dentalkit',
			__( 'Settings', 'dentalkit' ),
			__( 'Settings', 'dentalkit' ),
			'manage_options',
			'dk-settings',
			[ $settings, 'render' ]
		);
	}
}
