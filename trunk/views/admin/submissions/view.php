<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) exit;

$data       = json_decode( $submission['data_json'], true ) ?? [];
$back_url   = admin_url( 'admin.php?page=dk-submissions' . ( $submission['form_id'] ? '&form_id=' . $submission['form_id'] : '' ) );
$export_url = wp_nonce_url(
	admin_url( 'admin.php?page=dk-submissions&action=export&form_id=' . $submission['form_id'] ),
	'dk_export_' . $submission['form_id']
);
$delete_url = wp_nonce_url(
	admin_url( 'admin.php?page=dk-submissions&action=delete&id=' . $submission['id'] ),
	'dk_delete_submission_' . $submission['id']
);
?>
<div class="wrap">
	<h1><?php esc_html_e( 'Submission Detail', 'DentalFocus' ); ?></h1>

	<div class="dk-submission-header">
		<a href="<?php echo esc_url( $back_url ); ?>" class="button">
			&larr; <?php esc_html_e( 'Back to Submissions', 'DentalFocus' ); ?>
		</a>
		<a href="<?php echo esc_url( $export_url ); ?>" class="button">
			<span class="dashicons dashicons-download"></span>
			<?php esc_html_e( 'Export Form CSV', 'DentalFocus' ); ?>
		</a>
		<a href="<?php echo esc_url( $delete_url ); ?>" class="button dk-btn-danger"
		   onclick="return confirm('<?php echo esc_js( __( 'Delete this submission?', 'DentalFocus' ) ); ?>')">
			<?php esc_html_e( 'Delete', 'DentalFocus' ); ?>
		</a>
	</div>

	<div class="dk-submission-meta postbox">
		<h3 class="hndle"><?php esc_html_e( 'Submission Info', 'DentalFocus' ); ?></h3>
		<div class="inside">
			<table class="dk-meta-table">
				<tr>
					<th><?php esc_html_e( 'ID', 'DentalFocus' ); ?></th>
					<td><?php echo absint( $submission['id'] ); ?></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'Form', 'DentalFocus' ); ?></th>
					<td><?php echo $form ? esc_html( $form['name'] ) : esc_html__( 'Unknown', 'DentalFocus' ); ?></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'Date', 'DentalFocus' ); ?></th>
					<td><?php echo esc_html( wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $submission['created_at'] . ' UTC' ) ) ); ?></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'IP Address', 'DentalFocus' ); ?></th>
					<td><?php echo esc_html( $submission['ip_address'] ?? '' ); ?></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="dk-submission-data postbox">
		<h3 class="hndle"><?php esc_html_e( 'Submitted Data', 'DentalFocus' ); ?></h3>
		<div class="inside">
			<table class="dk-data-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Field', 'DentalFocus' ); ?></th>
						<th><?php esc_html_e( 'Value', 'DentalFocus' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $data as $field_id => $item ) :
						$value = $item['value'] ?? '';
						$display = is_array( $value ) ? implode( ', ', array_map( 'esc_html', $value ) ) : esc_html( (string) $value );
					?>
					<tr>
						<th><?php echo esc_html( $item['label'] ?? $field_id ); ?></th>
						<td><?php echo $display; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
