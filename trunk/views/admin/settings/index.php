<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) exit;

$active_tab = sanitize_key( $_GET['tab'] ?? 'general' );
?>
<div class="wrap">
	<h1><?php esc_html_e( 'DentalKit Settings', 'dentalkit' ); ?></h1>

	<?php if ( isset( $_GET['saved'] ) ) : ?>
	<div class="notice notice-success is-dismissible">
		<p><?php esc_html_e( 'Settings saved.', 'dentalkit' ); ?></p>
	</div>
	<?php endif; ?>

	<?php if ( isset( $_GET['deleted'] ) ) : ?>
	<div class="notice notice-success is-dismissible">
		<p><?php esc_html_e( 'Social media entry deleted.', 'dentalkit' ); ?></p>
	</div>
	<?php endif; ?>

	<nav class="nav-tab-wrapper">
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&tab=general' ) ); ?>"
		   class="nav-tab <?php echo 'general' === $active_tab ? 'nav-tab-active' : ''; ?>">
			<?php esc_html_e( 'General', 'dentalkit' ); ?>
		</a>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&tab=social' ) ); ?>"
		   class="nav-tab <?php echo 'social' === $active_tab ? 'nav-tab-active' : ''; ?>">
			<?php esc_html_e( 'Social Media', 'dentalkit' ); ?>
		</a>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&tab=help' ) ); ?>"
		   class="nav-tab <?php echo 'help' === $active_tab ? 'nav-tab-active' : ''; ?>">
			<?php esc_html_e( 'Help & Guide', 'dentalkit' ); ?>
		</a>
	</nav>

	<?php if ( 'general' === $active_tab ) : ?>
	<form method="post">
		<?php wp_nonce_field( 'dk_settings_save' ); ?>
		<table class="form-table">
			<tr>
				<th scope="row"><?php esc_html_e( 'Email Notifications', 'dentalkit' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="email_notifications" value="1"
							<?php checked( ! empty( $settings['email_notifications'] ) ); ?> />
						<?php esc_html_e( 'Send email notification on form submission', 'dentalkit' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="notification_email"><?php esc_html_e( 'Notification Email', 'dentalkit' ); ?></label></th>
				<td>
					<input type="email" id="notification_email" name="notification_email" class="regular-text"
						value="<?php echo esc_attr( $settings['notification_email'] ?? get_option( 'admin_email' ) ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'reCAPTCHA v3', 'dentalkit' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="recaptcha_enabled" value="1"
							<?php checked( ! empty( $settings['recaptcha_enabled'] ) ); ?> />
						<?php esc_html_e( 'Enable Google reCAPTCHA v3', 'dentalkit' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="recaptcha_site_key"><?php esc_html_e( 'reCAPTCHA Site Key', 'dentalkit' ); ?></label></th>
				<td>
					<input type="text" id="recaptcha_site_key" name="recaptcha_site_key" class="regular-text"
						value="<?php echo esc_attr( $settings['recaptcha_site_key'] ?? '' ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="recaptcha_secret"><?php esc_html_e( 'reCAPTCHA Secret Key', 'dentalkit' ); ?></label></th>
				<td>
					<input type="text" id="recaptcha_secret" name="recaptcha_secret" class="regular-text"
						value="<?php echo esc_attr( $settings['recaptcha_secret'] ?? '' ); ?>" />
				</td>
			</tr>
		</table>
		<?php submit_button( __( 'Save Settings', 'dentalkit' ) ); ?>
	</form>

	<?php elseif ( 'social' === $active_tab ) : ?>
	<div class="dk-social-header">
		<h2><?php esc_html_e( 'Social Media Links', 'dentalkit' ); ?></h2>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&action=social-add' ) ); ?>" class="button button-primary">
			<?php esc_html_e( 'Add New', 'dentalkit' ); ?>
		</a>
	</div>

	<div class="dk-info-box">
		<strong><?php esc_html_e( 'How to use:', 'dentalkit' ); ?></strong>
		<?php esc_html_e( 'Use shortcode', 'dentalkit' ); ?>
		<code>[dk_social name="facebook"]</code>
		<?php esc_html_e( 'to display a social link anywhere on your site.', 'dentalkit' ); ?>
	</div>

	<?php if ( empty( $social_media ) ) : ?>
	<p><?php esc_html_e( 'No social media links added yet.', 'dentalkit' ); ?></p>
	<?php else : ?>
	<table class="wp-list-table widefat fixed striped">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Title', 'dentalkit' ); ?></th>
				<th><?php esc_html_e( 'Slug', 'dentalkit' ); ?></th>
				<th><?php esc_html_e( 'URL', 'dentalkit' ); ?></th>
				<th><?php esc_html_e( 'Shortcode', 'dentalkit' ); ?></th>
				<th><?php esc_html_e( 'Actions', 'dentalkit' ); ?></th>
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
					<a href="<?php echo esc_url( $edit_url ); ?>" class="button button-small"><?php esc_html_e( 'Edit', 'dentalkit' ); ?></a>
					<a href="<?php echo esc_url( $delete_url ); ?>" class="button button-small dk-btn-danger"
					   onclick="return confirm('<?php echo esc_js( __( 'Delete this social media entry?', 'dentalkit' ) ); ?>')">
						<?php esc_html_e( 'Delete', 'dentalkit' ); ?>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>

	<?php elseif ( 'help' === $active_tab ) : ?>
	<div class="dk-help-guide">
		<h2><?php esc_html_e( 'DentalKit — Help & User Guide', 'dentalkit' ); ?></h2>

		<div class="dk-help-section">
			<h3><?php esc_html_e( '1. Form Builder', 'dentalkit' ); ?></h3>
			<ol>
				<li><?php esc_html_e( 'Go to DentalKit → Form Builder → Add New Form.', 'dentalkit' ); ?></li>
				<li><?php esc_html_e( 'Enter a form name, then drag field types from the left palette into the builder canvas.', 'dentalkit' ); ?></li>
				<li><?php esc_html_e( 'Click the edit icon on any field to set its label, placeholder, and required status.', 'dentalkit' ); ?></li>
				<li><?php esc_html_e( 'Click "Save Form". A shortcode is automatically generated — e.g. [dk_form id="1"].', 'dentalkit' ); ?></li>
				<li><?php esc_html_e( 'Paste the shortcode into any page or post to display the form.', 'dentalkit' ); ?></li>
			</ol>
		</div>

		<div class="dk-help-section">
			<h3><?php esc_html_e( '2. Submissions', 'dentalkit' ); ?></h3>
			<ol>
				<li><?php esc_html_e( 'View all patient submissions under DentalKit → Submissions.', 'dentalkit' ); ?></li>
				<li><?php esc_html_e( 'Filter by form using the dropdown, then click "Export CSV" to download.', 'dentalkit' ); ?></li>
				<li><?php esc_html_e( 'Click "View" on any row to see the full submission detail.', 'dentalkit' ); ?></li>
			</ol>
		</div>

		<div class="dk-help-section">
			<h3><?php esc_html_e( '3. Custom Post Types', 'dentalkit' ); ?></h3>
			<p><?php esc_html_e( 'DentalKit registers the following post types automatically:', 'dentalkit' ); ?></p>
			<ul>
				<li><strong>dk-testimonial</strong> — <?php esc_html_e( 'Patient testimonials', 'dentalkit' ); ?></li>
				<li><strong>dk-team</strong> — <?php esc_html_e( 'Dental team members', 'dentalkit' ); ?></li>
				<li><strong>dk-treatment</strong> — <?php esc_html_e( 'Dental treatments', 'dentalkit' ); ?></li>
				<li><strong>dk-portfolio</strong> — <?php esc_html_e( 'Case study portfolio', 'dentalkit' ); ?></li>
				<li><strong>dk-banner</strong> — <?php esc_html_e( 'Hero banners', 'dentalkit' ); ?></li>
			</ul>
		</div>

		<div class="dk-help-section">
			<h3><?php esc_html_e( '4. Social Media Shortcode', 'dentalkit' ); ?></h3>
			<p><?php esc_html_e( 'Add social links in Settings → Social Media, then use:', 'dentalkit' ); ?></p>
			<code>[dk_social name="facebook"]</code>
			<p><?php esc_html_e( 'Or in PHP templates:', 'dentalkit' ); ?></p>
			<code>&lt;?php echo do_shortcode(\'[dk_social name="facebook"]\'); ?&gt;</code>
		</div>

		<div class="dk-help-section">
			<h3><?php esc_html_e( '5. Email Notifications', 'dentalkit' ); ?></h3>
			<p><?php esc_html_e( 'Enable under Settings → General. Each form submission sends an email to the configured address.', 'dentalkit' ); ?></p>
		</div>
	</div>
	<?php endif; ?>
</div>
