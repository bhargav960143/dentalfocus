<?php
declare(strict_types=1);

namespace DentalFocus\PostTypes;

class TeamMeta {

	private const SOCIALS = [
		'linkedin'  => 'LinkedIn URL',
		'instagram' => 'Instagram URL',
		'facebook'  => 'Facebook URL',
		'twitter'   => 'Twitter / X URL',
	];

	public function register(): void {
		add_meta_box(
			'dk-team-social',
			__( 'Social Links', 'dentalfocus' ),
			[ $this, 'render_meta_box' ],
			'dk-team',
			'normal',
			'default'
		);
		add_action( 'save_post_dk-team', [ $this, 'save' ] );
	}

	public function render_meta_box( \WP_Post $post ): void {
		wp_nonce_field( 'dk_save_team_social_' . $post->ID, 'dk_team_social_nonce' );
		?>
		<table class="form-table" style="margin:0;">
			<?php foreach ( self::SOCIALS as $key => $label ) :
				$val = esc_attr( get_post_meta( $post->ID, '_dk_team_' . $key, true ) );
				?>
			<tr>
				<th style="width:140px;padding:6px 0;"><label for="dk_team_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
				<td style="padding:6px 0;">
					<input type="url" id="dk_team_<?php echo esc_attr( $key ); ?>"
						name="dk_team_social[<?php echo esc_attr( $key ); ?>]"
						value="<?php echo $val; ?>"
						class="regular-text"
						placeholder="https://" />
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php
	}

	public function save( int $post_id ): void {
		if (
			! isset( $_POST['dk_team_social_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dk_team_social_nonce'] ) ), 'dk_save_team_social_' . $post_id ) ||
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
			! current_user_can( 'edit_post', $post_id )
		) {
			return;
		}

		$submitted = (array) ( $_POST['dk_team_social'] ?? [] );
		foreach ( array_keys( self::SOCIALS ) as $key ) {
			update_post_meta( $post_id, '_dk_team_' . $key, esc_url_raw( wp_unslash( $submitted[ $key ] ?? '' ) ) );
		}
	}
}
