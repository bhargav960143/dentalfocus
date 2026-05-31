<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) exit;

use DentalFocus\FormBuilder\FormRepository;
use DentalFocus\FormBuilder\SubmissionRepository;
use DentalFocus\PostTypes\PostTypeRegistry;

$form_count       = ( new FormRepository() )->count();
$submission_count = ( new SubmissionRepository() )->count();

$cards = [
	[
		'title'  => __( 'Form Builder', 'DentalFocus' ),
		'desc'   => __( 'Create drag-and-drop forms. Auto-generates shortcodes. Capture patient enquiries.', 'DentalFocus' ),
		'icon'   => 'dashicons-feedback',
		'links'  => [
			[ 'url' => admin_url( 'admin.php?page=dk-forms' ),                   'label' => __( 'All Forms', 'DentalFocus' ) ],
			[ 'url' => admin_url( 'admin.php?page=dk-forms&action=create' ),     'label' => __( 'Add New', 'DentalFocus' ) ],
		],
		'badge'  => sprintf( __( '%d form(s)', 'DentalFocus' ), $form_count ),
	],
	[
		'title'  => __( 'Submissions', 'DentalFocus' ),
		'desc'   => __( 'View and export all form submissions. Filter by form. Download as CSV.', 'DentalFocus' ),
		'icon'   => 'dashicons-list-view',
		'links'  => [
			[ 'url' => admin_url( 'admin.php?page=dk-submissions' ), 'label' => __( 'View All', 'DentalFocus' ) ],
		],
		'badge'  => sprintf( __( '%d submission(s)', 'DentalFocus' ), $submission_count ),
	],
	[
		'title'  => __( 'Testimonials', 'DentalFocus' ),
		'desc'   => __( 'Manage patient testimonials. Use shortcode [dk_testimonials] to display.', 'DentalFocus' ),
		'icon'   => 'dashicons-format-quote',
		'links'  => [
			[ 'url' => admin_url( 'edit.php?post_type=dk-testimonial' ),     'label' => __( 'All', 'DentalFocus' ) ],
			[ 'url' => admin_url( 'post-new.php?post_type=dk-testimonial' ), 'label' => __( 'Add New', 'DentalFocus' ) ],
		],
	],
	[
		'title'  => __( 'Team', 'DentalFocus' ),
		'desc'   => __( 'Manage dental team members. Assign categories and display on any page.', 'DentalFocus' ),
		'icon'   => 'dashicons-groups',
		'links'  => [
			[ 'url' => admin_url( 'edit.php?post_type=dk-team' ),     'label' => __( 'All', 'DentalFocus' ) ],
			[ 'url' => admin_url( 'post-new.php?post_type=dk-team' ), 'label' => __( 'Add New', 'DentalFocus' ) ],
		],
	],
	[
		'title'  => __( 'Treatments', 'DentalFocus' ),
		'desc'   => __( 'Manage dental treatment listings with categories and pricing info.', 'DentalFocus' ),
		'icon'   => 'dashicons-plus-alt',
		'links'  => [
			[ 'url' => admin_url( 'edit.php?post_type=dk-treatment' ),     'label' => __( 'All', 'DentalFocus' ) ],
			[ 'url' => admin_url( 'post-new.php?post_type=dk-treatment' ), 'label' => __( 'Add New', 'DentalFocus' ) ],
		],
	],
	[
		'title'  => __( 'Portfolio', 'DentalFocus' ),
		'desc'   => __( 'Before/after case studies and smile gallery management.', 'DentalFocus' ),
		'icon'   => 'dashicons-portfolio',
		'links'  => [
			[ 'url' => admin_url( 'edit.php?post_type=dk-portfolio' ),     'label' => __( 'All', 'DentalFocus' ) ],
			[ 'url' => admin_url( 'post-new.php?post_type=dk-portfolio' ), 'label' => __( 'Add New', 'DentalFocus' ) ],
		],
	],
	[
		'title'  => __( 'Banners', 'DentalFocus' ),
		'desc'   => __( 'Manage hero banners and promotional slides for your dental website.', 'DentalFocus' ),
		'icon'   => 'dashicons-format-gallery',
		'links'  => [
			[ 'url' => admin_url( 'edit.php?post_type=dk-banner' ),     'label' => __( 'All', 'DentalFocus' ) ],
			[ 'url' => admin_url( 'post-new.php?post_type=dk-banner' ), 'label' => __( 'Add New', 'DentalFocus' ) ],
		],
	],
	[
		'title'  => __( 'Settings', 'DentalFocus' ),
		'desc'   => __( 'Configure email notifications, social media links, and plugin options.', 'DentalFocus' ),
		'icon'   => 'dashicons-admin-settings',
		'links'  => [
			[ 'url' => admin_url( 'admin.php?page=dk-settings' ),             'label' => __( 'General', 'DentalFocus' ) ],
			[ 'url' => admin_url( 'admin.php?page=dk-settings&tab=social' ),  'label' => __( 'Social Media', 'DentalFocus' ) ],
		],
	],
];
?>
<div class="wrap dk-dashboard">
	<h1 class="wp-heading-inline">
		<span class="dashicons dashicons-heart"></span>
		<?php echo esc_html__( 'DentalFocus', 'DentalFocus' ); ?>
		<span class="dk-version">v<?php echo esc_html( DentalFocus\Plugin::VERSION ); ?></span>
	</h1>

	<p class="dk-dashboard-intro">
		<?php esc_html_e( 'Complete dental practice website toolkit. Select a module below to get started.', 'DentalFocus' ); ?>
	</p>

	<div class="dk-cards">
		<?php foreach ( $cards as $card ) : ?>
		<div class="dk-card">
			<div class="dk-card-header">
				<span class="dashicons <?php echo esc_attr( $card['icon'] ); ?> dk-card-icon"></span>
				<h3 class="dk-card-title"><?php echo esc_html( $card['title'] ); ?></h3>
				<?php if ( ! empty( $card['badge'] ) ) : ?>
				<span class="dk-badge"><?php echo esc_html( $card['badge'] ); ?></span>
				<?php endif; ?>
			</div>
			<p class="dk-card-desc"><?php echo esc_html( $card['desc'] ); ?></p>
			<div class="dk-card-actions">
				<?php foreach ( $card['links'] as $link ) : ?>
				<a href="<?php echo esc_url( $link['url'] ); ?>" class="button button-secondary">
					<?php echo esc_html( $link['label'] ); ?>
				</a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>
