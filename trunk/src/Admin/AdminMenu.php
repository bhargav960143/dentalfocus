<?php
declare(strict_types=1);

namespace DentalFocus\Admin;

use DentalFocus\Admin\Controller\DashboardController;
use DentalFocus\Admin\Controller\FormBuilderController;
use DentalFocus\Admin\Controller\SubmissionsController;
use DentalFocus\Admin\Controller\SettingsController;

class AdminMenu {

	public function register(): void {
		$dashboard   = new DashboardController();
		$form_builder = new FormBuilderController();
		$submissions = new SubmissionsController();
		$settings    = new SettingsController();

		add_menu_page(
			__( 'DentalFocus', 'DentalFocus' ),
			__( 'DentalFocus', 'DentalFocus' ),
			'manage_options',
			'DentalFocus',
			[ $dashboard, 'render' ],
			'dashicons-heart',
			81
		);

		add_submenu_page(
			'DentalFocus',
			__( 'Dashboard', 'DentalFocus' ),
			__( 'Dashboard', 'DentalFocus' ),
			'manage_options',
			'DentalFocus',
			[ $dashboard, 'render' ]
		);

		add_submenu_page(
			'DentalFocus',
			__( 'Form Builder', 'DentalFocus' ),
			__( 'Form Builder', 'DentalFocus' ),
			'manage_options',
			'dk-forms',
			[ $form_builder, 'render' ]
		);

		add_submenu_page(
			'DentalFocus',
			__( 'Submissions', 'DentalFocus' ),
			__( 'Submissions', 'DentalFocus' ),
			'manage_options',
			'dk-submissions',
			[ $submissions, 'render' ]
		);

		add_submenu_page(
			'DentalFocus',
			__( 'Settings', 'DentalFocus' ),
			__( 'Settings', 'DentalFocus' ),
			'manage_options',
			'dk-settings',
			[ $settings, 'render' ]
		);
	}
}
