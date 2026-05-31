<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) exit;

use DentalKit\FormBuilder\FormRepository;
use DentalKit\FormBuilder\SubmissionRepository;
use DentalKit\PostTypes\PostTypeRegistry;

$form_count       = ( new FormRepository() )->count();
$submission_count = ( new SubmissionRepository() )->count();

$cards = [
	[
		'title'  => __( 'Form Builder', 'dentalkit' ),
		'desc'   => __( 'Create drag-and-drop forms. Auto-generates shortcodes. Capture patient enquiries.', 'dentalkit' ),
		'icon'   => 'dashicons-feedback',
		'links'  => [
			[ 'url' => admin_url( 'admin.php?page=dk-forms' ),                   'label' => __( 'All Forms', 'dentalkit' ) ],
			[ 'url' => admin_url( 'admin.php?page=dk-forms&action=create' ),     'label' => __( 'Add New', 'dentalkit' ) ],
		],
		'badge'  => sprintf( __( '%d form(s)', 'dentalkit' ), $form_count ),
	],
	[
		'title'  => __( 'Submissions', 'dentalkit' ),
		'desc'   => __( 'View and export all form submissions. Filter by form. Download as CSV.', 'dentalkit' ),
		'icon'   => 'dashicons-list-view',
		'links'  => [
			[ 'url' => admin_url( 'admin.php?page=dk-submissions' ), 'label' => __( 'View All', 'dentalkit' ) ],
		],
		'badge'  => sprintf( __( '%d submission(s)', 'dentalkit' ), $submission_count ),
	],
	[
		'title'  => __( 'Testimonials', 'dentalkit' ),
		'desc'   => __( 'Manage patient testimonials. Use shortcode [dk_testimonials] to display.', 'dentalkit' ),
		'icon'   => 'dashicons-format-quote',
		'links'  => [
			[ 'url' => admin_url( 'edit.php?post_type=dk-testimonial' ),     'label' => __( 'All', 'dentalkit' ) ],
			[ 'url' => admin_url( 'post-new.php?post_type=dk-testimonial' ), 'label' => __( 'Add New', 'dentalkit' ) ],
		],
	],
	[
		'title'  => __( 'Team', 'dentalkit' ),
		'desc'   => __( 'Manage dental team members. Assign categories and display on any page.', 'dentalkit' ),
		'icon'   => 'dashicons-groups',
		'links'  => [
			[ 'url' => admin_url( 'edit.php?post_type=dk-team' ),     'label' => __( 'All', 'dentalkit' ) ],
			[ 'url' => admin_url( 'post-new.php?post_type=dk-team' ), 'label' => __( 'Add New', 'dentalkit' ) ],
		],
	],
	[
		'title'  => __( 'Treatments', 'dentalkit' ),
		'desc'   => __( 'Manage dental treatment listings with categories and pricing info.', 'dentalkit' ),
		'icon'   => 'dashicons-plus-alt',
		'links'  => [
			[ 'url' => admin_url( 'edit.php?post_type=dk-treatment' ),     'label' => __( 'All', 'dentalkit' ) ],
			[ 'url' => admin_url( 'post-new.php?post_type=dk-treatment' ), 'label' => __( 'Add New', 'dentalkit' ) ],
		],
	],
	[
		'title'  => __( 'Portfolio', 'dentalkit' ),
		'desc'   => __( 'Before/after case studies and smile gallery management.', 'dentalkit' ),
		'icon'   => 'dashicons-portfolio',
		'links'  => [
			[ 'url' => admin_url( 'edit.php?post_type=dk-portfolio' ),     'label' => __( 'All', 'dentalkit' ) ],
			[ 'url' => admin_url( 'post-new.php?post_type=dk-portfolio' ), 'label' => __( 'Add New', 'dentalkit' ) ],
		],
	],
	[
		'title'  => __( 'Banners', 'dentalkit' ),
		'desc'   => __( 'Manage hero banners and promotional slides for your dental website.', 'dentalkit' ),
		'icon'   => 'dashicons-format-gallery',
		'links'  => [
			[ 'url' => admin_url( 'edit.php?post_type=dk-banner' ),     'label' => __( 'All', 'dentalkit' ) ],
			[ 'url' => admin_url( 'post-new.php?post_type=dk-banner' ), 'label' => __( 'Add New', 'dentalkit' ) ],
		],
	],
	[
		'title'  => __( 'Settings', 'dentalkit' ),
		'desc'   => __( 'Configure email notifications, social media links, and plugin options.', 'dentalkit' ),
		'icon'   => 'dashicons-admin-settings',
		'links'  => [
			[ 'url' => admin_url( 'admin.php?page=dk-settings' ),             'label' => __( 'General', 'dentalkit' ) ],
			[ 'url' => admin_url( 'admin.php?page=dk-settings&tab=social' ),  'label' => __( 'Social Media', 'dentalkit' ) ],
		],
	],
];
?>
<div class="wrap dk-dashboard">
	<h1 class="wp-heading-inline">
		<span class="dashicons dashicons-heart"></span>
		<?php echo esc_html__( 'DentalKit', 'dentalkit' ); ?>
		<span class="dk-version">v<?php echo esc_html( DentalKit\Plugin::VERSION ); ?></span>
	</h1>

	<p class="dk-dashboard-intro">
		<?php esc_html_e( 'Complete dental practice website toolkit. Select a module below to get started.', 'dentalkit' ); ?>
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
