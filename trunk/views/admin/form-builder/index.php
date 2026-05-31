<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Form Builder', 'dentalkit' ); ?></h1>
	<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-forms&action=create' ) ); ?>" class="page-title-action">
		<?php esc_html_e( 'Add New Form', 'dentalkit' ); ?>
	</a>
	<hr class="wp-header-end">

	<?php if ( isset( $_GET['deleted'] ) ) : ?>
	<div class="notice notice-success is-dismissible">
		<p><?php esc_html_e( 'Form deleted successfully.', 'dentalkit' ); ?></p>
	</div>
	<?php endif; ?>

	<?php if ( empty( $forms ) ) : ?>
	<div class="dk-empty-state">
		<span class="dashicons dashicons-feedback dk-empty-icon"></span>
		<h2><?php esc_html_e( 'No forms yet', 'dentalkit' ); ?></h2>
		<p><?php esc_html_e( 'Create your first drag-and-drop form to start capturing patient enquiries.', 'dentalkit' ); ?></p>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-forms&action=create' ) ); ?>" class="button button-primary button-hero">
			<?php esc_html_e( 'Create Your First Form', 'dentalkit' ); ?>
		</a>
	</div>
	<?php else : ?>

	<?php
	$sub_repo = new DentalKit\FormBuilder\SubmissionRepository();
	?>

	<table class="wp-list-table widefat fixed striped dk-forms-table">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Form Name', 'dentalkit' ); ?></th>
				<th><?php esc_html_e( 'Fields', 'dentalkit' ); ?></th>
				<th><?php esc_html_e( 'Submissions', 'dentalkit' ); ?></th>
				<th><?php esc_html_e( 'Shortcode', 'dentalkit' ); ?></th>
				<th><?php esc_html_e( 'Created', 'dentalkit' ); ?></th>
				<th><?php esc_html_e( 'Actions', 'dentalkit' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $forms as $form ) :
				$fields      = json_decode( $form['fields_json'], true ) ?? [];
				$field_count = count( $fields );
				$sub_count   = $sub_repo->count_by_form( (int) $form['id'] );
				$shortcode   = '[dk_form id="' . $form['id'] . '"]';
				$edit_url    = admin_url( 'admin.php?page=dk-forms&action=edit&id=' . $form['id'] );
				$subs_url    = admin_url( 'admin.php?page=dk-submissions&form_id=' . $form['id'] );
				$delete_url  = wp_nonce_url(
					admin_url( 'admin.php?page=dk-forms&action=delete&id=' . $form['id'] ),
					'dk_delete_form_' . $form['id']
				);
			?>
			<tr>
				<td>
					<strong><a href="<?php echo esc_url( $edit_url ); ?>"><?php echo esc_html( $form['name'] ); ?></a></strong>
					<?php if ( $form['description'] ) : ?>
					<p class="description"><?php echo esc_html( $form['description'] ); ?></p>
					<?php endif; ?>
				</td>
				<td><?php echo esc_html( $field_count ); ?></td>
				<td>
					<a href="<?php echo esc_url( $subs_url ); ?>"><?php echo esc_html( $sub_count ); ?></a>
				</td>
				<td>
					<code class="dk-shortcode-cell" title="<?php esc_attr_e( 'Click to copy', 'dentalkit' ); ?>">
						<?php echo esc_html( $shortcode ); ?>
					</code>
				</td>
				<td><?php echo esc_html( wp_date( get_option( 'date_format' ), strtotime( $form['created_at'] ) ) ); ?></td>
				<td>
					<a href="<?php echo esc_url( $edit_url ); ?>" class="button button-small">
						<?php esc_html_e( 'Edit', 'dentalkit' ); ?>
					</a>
					<a href="<?php echo esc_url( $delete_url ); ?>" class="button button-small dk-btn-danger"
					   onclick="return confirm('<?php echo esc_js( __( 'Delete this form and all its submissions? This cannot be undone.', 'dentalkit' ) ); ?>')">
						<?php esc_html_e( 'Delete', 'dentalkit' ); ?>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
</div>
