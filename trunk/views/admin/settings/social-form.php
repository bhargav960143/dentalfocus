<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) exit;

$is_edit = null !== $social;
$title   = $is_edit ? __( 'Edit Social Media', 'DentalFocus' ) : __( 'Add Social Media', 'DentalFocus' );
?>
<div class="wrap">
	<h1><?php echo esc_html( $title ); ?></h1>

	<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&action=social-save' ) ); ?>">
		<?php wp_nonce_field( 'dk_social_save' ); ?>
		<?php if ( $is_edit ) : ?>
		<input type="hidden" name="id" value="<?php echo absint( $social['id'] ); ?>" />
		<?php endif; ?>

		<table class="form-table">
			<tr>
				<th scope="row"><label for="title"><?php esc_html_e( 'Title', 'DentalFocus' ); ?> <span class="required">*</span></label></th>
				<td>
					<input type="text" id="title" name="title" class="regular-text" required
						value="<?php echo $is_edit ? esc_attr( $social['title'] ) : ''; ?>"
						placeholder="<?php esc_attr_e( 'e.g. Facebook', 'DentalFocus' ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="url"><?php esc_html_e( 'URL', 'DentalFocus' ); ?> <span class="required">*</span></label></th>
				<td>
					<input type="url" id="url" name="url" class="regular-text" required
						value="<?php echo $is_edit ? esc_url( $social['url'] ) : ''; ?>"
						placeholder="https://" />
				</td>
			</tr>
		</table>

		<p class="submit">
			<button type="submit" class="button button-primary">
				<?php echo $is_edit ? esc_html__( 'Update', 'DentalFocus' ) : esc_html__( 'Add Social Media', 'DentalFocus' ); ?>
			</button>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=dk-settings&tab=social' ) ); ?>" class="button">
				<?php esc_html_e( 'Cancel', 'DentalFocus' ); ?>
			</a>
		</p>
	</form>
</div>
