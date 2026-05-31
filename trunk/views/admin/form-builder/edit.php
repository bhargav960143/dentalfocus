<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) exit;

use DentalFocus\FormBuilder\Fields\FieldRegistry;

$is_edit    = ! empty( $form );
$form_id    = $is_edit ? (int) $form['id'] : 0;
$form_name  = $is_edit ? $form['name'] : '';
$form_desc  = $is_edit ? ( $form['description'] ?? '' ) : '';
$fields     = $is_edit ? ( json_decode( $form['fields_json'], true ) ?? [] ) : [];
$shortcode  = $is_edit ? '[dk_form id="' . $form_id . '"]' : '';
$page_title = $is_edit ? __( 'Edit Form', 'DentalFocus' ) : __( 'Create Form', 'DentalFocus' );

$field_types = FieldRegistry::all();
?>
<div class="wrap dk-builder-wrap">
	<h1><?php echo esc_html( $page_title ); ?></h1>

	<?php if ( $is_edit ) : ?>
	<div class="dk-shortcode-bar">
		<strong><?php esc_html_e( 'Shortcode:', 'DentalFocus' ); ?></strong>
		<code id="dk-shortcode-display"><?php echo esc_html( $shortcode ); ?></code>
		<button type="button" class="button button-small" id="dk-copy-shortcode">
			<?php esc_html_e( 'Copy', 'DentalFocus' ); ?>
		</button>
		<span id="dk-copy-confirm" style="display:none; color:#00a32a;">
			<?php esc_html_e( 'Copied!', 'DentalFocus' ); ?>
		</span>
	</div>
	<?php endif; ?>

	<div class="dk-builder-layout">

		<!-- Field Palette -->
		<div class="dk-palette">
			<h3><?php esc_html_e( 'Field Types', 'DentalFocus' ); ?></h3>
			<p class="description"><?php esc_html_e( 'Drag fields into the form builder.', 'DentalFocus' ); ?></p>
			<ul class="dk-palette-list" id="dk-palette">
				<?php foreach ( $field_types as $type => $handler ) : ?>
				<li class="dk-palette-item" draggable="true" data-type="<?php echo esc_attr( $type ); ?>">
					<span class="dashicons <?php echo esc_attr( $handler->get_icon() ); ?>"></span>
					<?php echo esc_html( $handler->get_label() ); ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<!-- Builder Canvas -->
		<div class="dk-canvas">
			<div class="dk-form-meta">
				<label for="dk-form-name"><strong><?php esc_html_e( 'Form Name', 'DentalFocus' ); ?> <span class="required">*</span></strong></label>
				<input type="text" id="dk-form-name" class="regular-text" value="<?php echo esc_attr( $form_name ); ?>"
					placeholder="<?php esc_attr_e( 'e.g. Appointment Request', 'DentalFocus' ); ?>" required />

				<label for="dk-form-desc" style="margin-top:10px;display:block;">
					<strong><?php esc_html_e( 'Description (optional)', 'DentalFocus' ); ?></strong>
				</label>
				<textarea id="dk-form-desc" class="large-text" rows="2"
					placeholder="<?php esc_attr_e( 'Internal description for this form', 'DentalFocus' ); ?>"><?php echo esc_textarea( $form_desc ); ?></textarea>
			</div>

			<h3><?php esc_html_e( 'Form Fields', 'DentalFocus' ); ?></h3>

			<div id="dk-drop-zone" class="dk-drop-zone" data-form-id="<?php echo esc_attr( (string) $form_id ); ?>">
				<?php if ( empty( $fields ) ) : ?>
				<div class="dk-drop-placeholder" id="dk-drop-placeholder">
					<span class="dashicons dashicons-plus-alt2"></span>
					<p><?php esc_html_e( 'Drag fields here to build your form', 'DentalFocus' ); ?></p>
				</div>
				<?php endif; ?>

				<?php foreach ( $fields as $field ) : ?>
				<div class="dk-field-row" data-field-id="<?php echo esc_attr( $field['id'] ); ?>"
					data-type="<?php echo esc_attr( $field['type'] ); ?>">
					<div class="dk-field-row-handle">
						<span class="dashicons dashicons-menu"></span>
					</div>
					<div class="dk-field-row-info">
						<span class="dk-field-type-badge"><?php echo esc_html( $field['type'] ); ?></span>
						<span class="dk-field-label-preview"><?php echo esc_html( $field['label'] ?? '' ); ?></span>
						<?php if ( ! empty( $field['required'] ) ) : ?>
						<span class="dk-required-badge"><?php esc_html_e( 'Required', 'DentalFocus' ); ?></span>
						<?php endif; ?>
					</div>
					<div class="dk-field-row-actions">
						<button type="button" class="button button-small dk-edit-field" title="<?php esc_attr_e( 'Edit field', 'DentalFocus' ); ?>">
							<span class="dashicons dashicons-edit"></span>
						</button>
						<button type="button" class="button button-small dk-remove-field" title="<?php esc_attr_e( 'Remove field', 'DentalFocus' ); ?>">
							<span class="dashicons dashicons-trash"></span>
						</button>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

			<!-- Field Settings Panel -->
			<div id="dk-field-settings" class="dk-field-settings" style="display:none;">
				<h4><?php esc_html_e( 'Field Settings', 'DentalFocus' ); ?></h4>
				<table class="form-table dk-settings-table">
					<tr>
						<th><label for="dk-field-label"><?php esc_html_e( 'Label', 'DentalFocus' ); ?></label></th>
						<td><input type="text" id="dk-field-label" class="regular-text" /></td>
					</tr>
					<tr>
						<th><label for="dk-field-placeholder"><?php esc_html_e( 'Placeholder', 'DentalFocus' ); ?></label></th>
						<td><input type="text" id="dk-field-placeholder" class="regular-text" /></td>
					</tr>
					<tr class="dk-settings-options-row" style="display:none;">
						<th><label for="dk-field-options"><?php esc_html_e( 'Options', 'DentalFocus' ); ?></label></th>
						<td>
							<textarea id="dk-field-options" class="large-text" rows="4"
								placeholder="<?php esc_attr_e( 'One option per line', 'DentalFocus' ); ?>"></textarea>
							<p class="description"><?php esc_html_e( 'Enter each option on a new line.', 'DentalFocus' ); ?></p>
						</td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Required', 'DentalFocus' ); ?></th>
						<td>
							<label>
								<input type="checkbox" id="dk-field-required" />
								<?php esc_html_e( 'This field is required', 'DentalFocus' ); ?>
							</label>
						</td>
					</tr>
				</table>
				<button type="button" class="button button-primary" id="dk-update-field">
					<?php esc_html_e( 'Update Field', 'DentalFocus' ); ?>
				</button>
				<button type="button" class="button" id="dk-cancel-edit">
					<?php esc_html_e( 'Cancel', 'DentalFocus' ); ?>
				</button>
			</div>

			<!-- Save Actions -->
			<div class="dk-builder-actions">
				<button type="button" class="button button-primary button-large" id="dk-save-form">
					<?php echo $is_edit ? esc_html__( 'Update Form', 'DentalFocus' ) : esc_html__( 'Save Form', 'DentalFocus' ); ?>
				</button>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-forms' ) ); ?>" class="button button-large">
					<?php esc_html_e( 'Cancel', 'DentalFocus' ); ?>
				</a>
				<span id="dk-save-status" class="dk-save-status"></span>
			</div>
		</div>
	</div>
</div>

<script>
window.DKBuilderData = <?php echo wp_json_encode(
	[
		'form_id'  => $form_id,
		'fields'   => $fields,
		'is_edit'  => $is_edit,
	],
	JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
); ?>;
</script>
