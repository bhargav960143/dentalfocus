<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) exit;

$current_form = $form_id ? ( ( new DentalFocus\FormBuilder\FormRepository() )->find( $form_id ) ) : null;
$export_url   = $form_id
	? wp_nonce_url( admin_url( 'admin.php?page=dk-submissions&action=export&form_id=' . $form_id ), 'dk_export_' . $form_id )
	: wp_nonce_url( admin_url( 'admin.php?page=dk-submissions&action=export&form_id=0' ), 'dk_export_0' );
?>
<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Submissions', 'DentalFocus' ); ?></h1>

	<a href="<?php echo esc_url( $export_url ); ?>" class="page-title-action dk-export-btn">
		<span class="dashicons dashicons-download"></span>
		<?php esc_html_e( 'Export CSV', 'DentalFocus' ); ?>
	</a>
	<hr class="wp-header-end">

	<?php if ( isset( $_GET['deleted'] ) ) : ?>
	<div class="notice notice-success is-dismissible">
		<p><?php esc_html_e( 'Submission deleted.', 'DentalFocus' ); ?></p>
	</div>
	<?php endif; ?>

	<!-- Filter by form -->
	<div class="dk-filter-bar">
		<form method="get">
			<input type="hidden" name="page" value="dk-submissions" />
			<select name="form_id" onchange="this.form.submit()">
				<option value=""><?php esc_html_e( 'All Forms', 'DentalFocus' ); ?></option>
				<?php foreach ( $forms as $f ) : ?>
				<option value="<?php echo absint( $f['id'] ); ?>" <?php selected( $form_id, $f['id'] ); ?>>
					<?php echo esc_html( $f['name'] ); ?>
				</option>
				<?php endforeach; ?>
			</select>
		</form>
	</div>

	<?php if ( empty( $submissions ) ) : ?>
	<div class="dk-empty-state">
		<span class="dashicons dashicons-list-view dk-empty-icon"></span>
		<h2><?php esc_html_e( 'No submissions yet', 'DentalFocus' ); ?></h2>
		<p><?php esc_html_e( 'When visitors submit your forms, their data will appear here.', 'DentalFocus' ); ?></p>
	</div>
	<?php else : ?>
	<table class="wp-list-table widefat fixed striped">
		<thead>
			<tr>
				<th style="width:50px"><?php esc_html_e( 'ID', 'DentalFocus' ); ?></th>
				<th><?php esc_html_e( 'Form', 'DentalFocus' ); ?></th>
				<th><?php esc_html_e( 'Data Preview', 'DentalFocus' ); ?></th>
				<th><?php esc_html_e( 'IP Address', 'DentalFocus' ); ?></th>
				<th><?php esc_html_e( 'Date', 'DentalFocus' ); ?></th>
				<th><?php esc_html_e( 'Actions', 'DentalFocus' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $submissions as $sub ) :
				$data        = json_decode( $sub['data_json'], true ) ?? [];
				$preview     = [];
				$count       = 0;
				foreach ( $data as $item ) {
					if ( $count >= 3 ) break;
					$val       = is_array( $item['value'] ) ? implode( ', ', $item['value'] ) : $item['value'];
					$preview[] = esc_html( $item['label'] ) . ': ' . esc_html( $val );
					$count++;
				}
				$form_label = '';
				foreach ( $forms as $f ) {
					if ( (int) $f['id'] === (int) $sub['form_id'] ) {
						$form_label = $f['name'];
						break;
					}
				}
				$view_url   = admin_url( 'admin.php?page=dk-submissions&action=view&id=' . $sub['id'] );
				$delete_url = wp_nonce_url(
					admin_url( 'admin.php?page=dk-submissions&action=delete&id=' . $sub['id'] ),
					'dk_delete_submission_' . $sub['id']
				);
			?>
			<tr>
				<td><?php echo absint( $sub['id'] ); ?></td>
				<td><?php echo esc_html( $form_label ); ?></td>
				<td class="dk-data-preview"><?php echo implode( ' &bull; ', $preview ); ?></td>
				<td><?php echo esc_html( $sub['ip_address'] ?? '' ); ?></td>
				<td><?php echo esc_html( wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $sub['created_at'] . ' UTC' ) ) ); ?></td>
				<td>
					<a href="<?php echo esc_url( $view_url ); ?>" class="button button-small"><?php esc_html_e( 'View', 'DentalFocus' ); ?></a>
					<a href="<?php echo esc_url( $delete_url ); ?>" class="button button-small dk-btn-danger"
					   onclick="return confirm('<?php echo esc_js( __( 'Delete this submission?', 'DentalFocus' ) ); ?>')">
						<?php esc_html_e( 'Delete', 'DentalFocus' ); ?>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
</div>
