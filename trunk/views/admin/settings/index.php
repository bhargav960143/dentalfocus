<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) exit;

$active_tab = sanitize_key( $_GET['tab'] ?? 'general' );
?>
<div class="wrap">
	<h1><?php esc_html_e( 'DentalFocus Settings', 'DentalFocus' ); ?></h1>

	<?php if ( isset( $_GET['saved'] ) ) : ?>
	<div class="notice notice-success is-dismissible">
		<p><?php esc_html_e( 'Settings saved.', 'DentalFocus' ); ?></p>
	</div>
	<?php endif; ?>

	<?php if ( isset( $_GET['deleted'] ) ) : ?>
	<div class="notice notice-success is-dismissible">
		<p><?php esc_html_e( 'Social media entry deleted.', 'DentalFocus' ); ?></p>
	</div>
	<?php endif; ?>

	<nav class="nav-tab-wrapper">
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&tab=general' ) ); ?>"
		   class="nav-tab <?php echo 'general' === $active_tab ? 'nav-tab-active' : ''; ?>">
			<?php esc_html_e( 'General', 'DentalFocus' ); ?>
		</a>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&tab=social' ) ); ?>"
		   class="nav-tab <?php echo 'social' === $active_tab ? 'nav-tab-active' : ''; ?>">
			<?php esc_html_e( 'Social Media', 'DentalFocus' ); ?>
		</a>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&tab=hours' ) ); ?>"
		   class="nav-tab <?php echo 'hours' === $active_tab ? 'nav-tab-active' : ''; ?>">
			<?php esc_html_e( 'Opening Hours', 'DentalFocus' ); ?>
		</a>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&tab=help' ) ); ?>"
		   class="nav-tab <?php echo 'help' === $active_tab ? 'nav-tab-active' : ''; ?>">
			<?php esc_html_e( 'Help & Guide', 'DentalFocus' ); ?>
		</a>
	</nav>

	<?php if ( 'general' === $active_tab ) : ?>
	<form method="post">
		<?php wp_nonce_field( 'dk_settings_save' ); ?>
		<table class="form-table">
			<tr>
				<th scope="row"><?php esc_html_e( 'Email Notifications', 'DentalFocus' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="email_notifications" value="1"
							<?php checked( ! empty( $settings['email_notifications'] ) ); ?> />
						<?php esc_html_e( 'Send email notification on form submission', 'DentalFocus' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="notification_email"><?php esc_html_e( 'Notification Email', 'DentalFocus' ); ?></label></th>
				<td>
					<input type="email" id="notification_email" name="notification_email" class="regular-text"
						value="<?php echo esc_attr( $settings['notification_email'] ?? get_option( 'admin_email' ) ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'reCAPTCHA v3', 'DentalFocus' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="recaptcha_enabled" value="1"
							<?php checked( ! empty( $settings['recaptcha_enabled'] ) ); ?> />
						<?php esc_html_e( 'Enable Google reCAPTCHA v3', 'DentalFocus' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="recaptcha_site_key"><?php esc_html_e( 'reCAPTCHA Site Key', 'DentalFocus' ); ?></label></th>
				<td>
					<input type="text" id="recaptcha_site_key" name="recaptcha_site_key" class="regular-text"
						value="<?php echo esc_attr( $settings['recaptcha_site_key'] ?? '' ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="recaptcha_secret"><?php esc_html_e( 'reCAPTCHA Secret Key', 'DentalFocus' ); ?></label></th>
				<td>
					<input type="text" id="recaptcha_secret" name="recaptcha_secret" class="regular-text"
						value="<?php echo esc_attr( $settings['recaptcha_secret'] ?? '' ); ?>" />
				</td>
			</tr>
			<tr><td colspan="2"><hr></td></tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Patient Confirmation Email', 'DentalFocus' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="patient_confirmation" value="1"
							<?php checked( ! empty( $settings['patient_confirmation'] ) ); ?> />
						<?php esc_html_e( 'Send confirmation email to patient after form submission', 'DentalFocus' ); ?>
					</label>
					<p class="description"><?php esc_html_e( 'Sends to the first email address found in the submission.', 'DentalFocus' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="confirmation_from_name"><?php esc_html_e( 'From Name', 'DentalFocus' ); ?></label></th>
				<td>
					<input type="text" id="confirmation_from_name" name="confirmation_from_name" class="regular-text"
						value="<?php echo esc_attr( $settings['confirmation_from_name'] ?? get_bloginfo( 'name' ) ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="confirmation_from_email"><?php esc_html_e( 'From Email', 'DentalFocus' ); ?></label></th>
				<td>
					<input type="email" id="confirmation_from_email" name="confirmation_from_email" class="regular-text"
						value="<?php echo esc_attr( $settings['confirmation_from_email'] ?? get_option( 'admin_email' ) ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="confirmation_subject"><?php esc_html_e( 'Email Subject', 'DentalFocus' ); ?></label></th>
				<td>
					<input type="text" id="confirmation_subject" name="confirmation_subject" class="large-text"
						value="<?php echo esc_attr( $settings['confirmation_subject'] ?? sprintf( __( 'Thank you for contacting us — %s', 'DentalFocus' ), get_bloginfo( 'name' ) ) ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="confirmation_body"><?php esc_html_e( 'Email Body', 'DentalFocus' ); ?></label></th>
				<td>
					<textarea id="confirmation_body" name="confirmation_body" class="large-text" rows="5"><?php echo esc_textarea( $settings['confirmation_body'] ?? sprintf( __( "Dear Patient,\n\nThank you for getting in touch. We have received your enquiry and will get back to you shortly.\n\nPractice: %s", 'DentalFocus' ), get_bloginfo( 'name' ) ) ); ?></textarea>
				</td>
			</tr>
			<tr><td colspan="2"><hr></td></tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'GDPR Consent', 'DentalFocus' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="gdpr_enabled" value="1"
							<?php checked( ! empty( $settings['gdpr_enabled'] ) ); ?> />
						<?php esc_html_e( 'Show GDPR consent checkbox on all forms', 'DentalFocus' ); ?>
					</label>
					<p class="description"><?php esc_html_e( 'Adds a required consent checkbox. Form cannot be submitted without it.', 'DentalFocus' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="gdpr_label"><?php esc_html_e( 'Consent Label', 'DentalFocus' ); ?></label></th>
				<td>
					<input type="text" id="gdpr_label" name="gdpr_label" class="large-text"
						value="<?php echo esc_attr( $settings['gdpr_label'] ?? __( 'I have read and agree to the Privacy Policy.', 'DentalFocus' ) ); ?>" />
					<p class="description"><?php esc_html_e( 'Label shown next to the checkbox. A link to your privacy policy will be appended if the URL below is set.', 'DentalFocus' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="gdpr_privacy_url"><?php esc_html_e( 'Privacy Policy URL', 'DentalFocus' ); ?></label></th>
				<td>
					<input type="url" id="gdpr_privacy_url" name="gdpr_privacy_url" class="regular-text"
						value="<?php echo esc_attr( $settings['gdpr_privacy_url'] ?? '' ); ?>"
						placeholder="https://example.com/privacy-policy" />
				</td>
			</tr>
		</table>
		<?php submit_button( __( 'Save Settings', 'DentalFocus' ) ); ?>
	</form>

	<?php elseif ( 'social' === $active_tab ) : ?>
	<div class="dk-social-header">
		<h2><?php esc_html_e( 'Social Media Links', 'DentalFocus' ); ?></h2>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&action=social-add' ) ); ?>" class="button button-primary">
			<?php esc_html_e( 'Add New', 'DentalFocus' ); ?>
		</a>
	</div>

	<div class="dk-info-box">
		<strong><?php esc_html_e( 'How to use:', 'DentalFocus' ); ?></strong>
		<?php esc_html_e( 'Use shortcode', 'DentalFocus' ); ?>
		<code>[dk_social name="facebook"]</code>
		<?php esc_html_e( 'to display a social link anywhere on your site.', 'DentalFocus' ); ?>
	</div>

	<?php if ( empty( $social_media ) ) : ?>
	<p><?php esc_html_e( 'No social media links added yet.', 'DentalFocus' ); ?></p>
	<?php else : ?>
	<table class="wp-list-table widefat fixed striped">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Title', 'DentalFocus' ); ?></th>
				<th><?php esc_html_e( 'Slug', 'DentalFocus' ); ?></th>
				<th><?php esc_html_e( 'URL', 'DentalFocus' ); ?></th>
				<th><?php esc_html_e( 'Shortcode', 'DentalFocus' ); ?></th>
				<th><?php esc_html_e( 'Actions', 'DentalFocus' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $social_media as $sm ) :
				$edit_url   = admin_url( 'admin.php?page=dk-settings&action=social-edit&id=' . $sm['id'] );
				$delete_url = wp_nonce_url(
					admin_url( 'admin.php?page=dk-settings&action=social-delete&id=' . $sm['id'] ),
					'dk_social_delete_' . $sm['id']
				);
			?>
			<tr>
				<td><?php echo esc_html( $sm['title'] ); ?></td>
				<td><code><?php echo esc_html( $sm['slug'] ); ?></code></td>
				<td><a href="<?php echo esc_url( $sm['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $sm['url'] ); ?></a></td>
				<td><code>[dk_social name="<?php echo esc_attr( $sm['slug'] ); ?>"]</code></td>
				<td>
					<a href="<?php echo esc_url( $edit_url ); ?>" class="button button-small"><?php esc_html_e( 'Edit', 'DentalFocus' ); ?></a>
					<a href="<?php echo esc_url( $delete_url ); ?>" class="button button-small dk-btn-danger"
					   onclick="return confirm('<?php echo esc_js( __( 'Delete this social media entry?', 'DentalFocus' ) ); ?>')">
						<?php esc_html_e( 'Delete', 'DentalFocus' ); ?>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>

	<?php elseif ( 'hours' === $active_tab ) :
		$hours = get_option( 'dk_opening_hours', [] );
		$days  = [ 'monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday' ];
		?>
	<form method="post">
		<?php wp_nonce_field( 'dk_hours_save', 'dk_hours_nonce' ); ?>
		<table class="wp-list-table widefat fixed striped" style="margin-top:16px;">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Day', 'DentalFocus' ); ?></th>
					<th><?php esc_html_e( 'Open?', 'DentalFocus' ); ?></th>
					<th><?php esc_html_e( 'From', 'DentalFocus' ); ?></th>
					<th><?php esc_html_e( 'To', 'DentalFocus' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ( $days as $key => $label ) :
				$entry = $hours[ $key ] ?? [];
				?>
			<tr>
				<td><strong><?php echo esc_html( $label ); ?></strong></td>
				<td>
					<input type="checkbox" name="hours[<?php echo esc_attr( $key ); ?>][open]" value="1"
						<?php checked( ! empty( $entry['open'] ) ); ?> />
				</td>
				<td>
					<input type="text" name="hours[<?php echo esc_attr( $key ); ?>][from]"
						value="<?php echo esc_attr( $entry['from'] ?? '09:00' ); ?>"
						placeholder="09:00" style="width:90px;" />
				</td>
				<td>
					<input type="text" name="hours[<?php echo esc_attr( $key ); ?>][to]"
						value="<?php echo esc_attr( $entry['to'] ?? '17:00' ); ?>"
						placeholder="17:00" style="width:90px;" />
				</td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<p class="description" style="margin-top:8px;">
			<?php esc_html_e( 'Display anywhere with:', 'DentalFocus' ); ?> <code>[dk_opening_hours]</code>
			<?php esc_html_e( 'or', 'DentalFocus' ); ?> <code>[dk_opening_hours style="list"]</code>
		</p>
		<?php submit_button( __( 'Save Hours', 'DentalFocus' ) ); ?>
	</form>

	<?php elseif ( 'help' === $active_tab ) : ?>
	<div class="dk-help-guide">
		<h2><?php esc_html_e( 'DentalFocus — Help & User Guide', 'DentalFocus' ); ?></h2>

		<div class="dk-help-section">
			<h3><?php esc_html_e( '1. Form Builder', 'DentalFocus' ); ?></h3>
			<ol>
				<li><?php esc_html_e( 'Go to DentalFocus → Form Builder → Add New Form.', 'DentalFocus' ); ?></li>
				<li><?php esc_html_e( 'Enter a form name, then drag field types from the left palette into the builder canvas.', 'DentalFocus' ); ?></li>
				<li><?php esc_html_e( 'Click the edit icon on any field to set its label, placeholder, and required status.', 'DentalFocus' ); ?></li>
				<li><?php esc_html_e( 'Click "Save Form". A shortcode is automatically generated — e.g. [dk_form id="1"].', 'DentalFocus' ); ?></li>
				<li><?php esc_html_e( 'Paste the shortcode into any page or post to display the form.', 'DentalFocus' ); ?></li>
			</ol>
		</div>

		<div class="dk-help-section">
			<h3><?php esc_html_e( '2. Submissions', 'DentalFocus' ); ?></h3>
			<ol>
				<li><?php esc_html_e( 'View all patient submissions under DentalFocus → Submissions.', 'DentalFocus' ); ?></li>
				<li><?php esc_html_e( 'Filter by form using the dropdown, then click "Export CSV" to download.', 'DentalFocus' ); ?></li>
				<li><?php esc_html_e( 'Click "View" on any row to see the full submission detail.', 'DentalFocus' ); ?></li>
			</ol>
		</div>

		<div class="dk-help-section">
			<h3><?php esc_html_e( '3. Custom Post Types', 'DentalFocus' ); ?></h3>
			<p><?php esc_html_e( 'DentalFocus registers the following post types automatically:', 'DentalFocus' ); ?></p>
			<ul>
				<li><strong>dk-testimonial</strong> — <?php esc_html_e( 'Patient testimonials', 'DentalFocus' ); ?></li>
				<li><strong>dk-team</strong> — <?php esc_html_e( 'Dental team members', 'DentalFocus' ); ?></li>
				<li><strong>dk-treatment</strong> — <?php esc_html_e( 'Dental treatments', 'DentalFocus' ); ?></li>
				<li><strong>dk-portfolio</strong> — <?php esc_html_e( 'Case study portfolio', 'DentalFocus' ); ?></li>
				<li><strong>dk-banner</strong> — <?php esc_html_e( 'Hero banners', 'DentalFocus' ); ?></li>
			</ul>
		</div>

		<div class="dk-help-section">
			<h3><?php esc_html_e( '4. Social Media Shortcode', 'DentalFocus' ); ?></h3>
			<p><?php esc_html_e( 'Add social links in Settings → Social Media, then use:', 'DentalFocus' ); ?></p>
			<code>[dk_social name="facebook"]</code>
			<p><?php esc_html_e( 'Or in PHP templates:', 'DentalFocus' ); ?></p>
			<code>&lt;?php echo do_shortcode(\'[dk_social name="facebook"]\'); ?&gt;</code>
		</div>

		<div class="dk-help-section">
			<h3><?php esc_html_e( '5. Email Notifications', 'DentalFocus' ); ?></h3>
			<p><?php esc_html_e( 'Enable under Settings → General. Each form submission sends an email to the configured address.', 'DentalFocus' ); ?></p>
		</div>
	</div>
	<?php endif; ?>
</div>
