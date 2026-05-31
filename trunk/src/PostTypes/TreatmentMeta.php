<?php
declare(strict_types=1);

namespace DentalFocus\PostTypes;

class TreatmentMeta {

	public function register(): void {
		add_meta_box(
			'dk-treatment-price',
			__( 'Treatment Price', 'dentalfocus' ),
			[ $this, 'render_meta_box' ],
			'dk-treatment',
			'side',
			'high'
		);
		add_action( 'save_post_dk-treatment', [ $this, 'save' ] );
	}

	public function render_meta_box( \WP_Post $post ): void {
		$price = sanitize_text_field( get_post_meta( $post->ID, '_dk_price', true ) );
		$note  = sanitize_text_field( get_post_meta( $post->ID, '_dk_price_note', true ) );
		wp_nonce_field( 'dk_save_price_' . $post->ID, 'dk_price_nonce' );
		?>
		<p>
			<label for="dk_price" style="font-weight:600;display:block;margin-bottom:4px;">
				<?php esc_html_e( 'Price', 'dentalfocus' ); ?>
			</label>
			<input
				type="text"
				id="dk_price"
				name="dk_price"
				value="<?php echo esc_attr( $price ); ?>"
				placeholder="<?php esc_attr_e( 'e.g. £99, From £49, Free', 'dentalfocus' ); ?>"
				style="width:100%;"
			/>
			<span class="description"><?php esc_html_e( 'Displayed on the treatment card.', 'dentalfocus' ); ?></span>
		</p>
		<p>
			<label for="dk_price_note" style="font-weight:600;display:block;margin-bottom:4px;">
				<?php esc_html_e( 'Price Note', 'dentalfocus' ); ?>
			</label>
			<input
				type="text"
				id="dk_price_note"
				name="dk_price_note"
				value="<?php echo esc_attr( $note ); ?>"
				placeholder="<?php esc_attr_e( 'e.g. per session, per arch', 'dentalfocus' ); ?>"
				style="width:100%;"
			/>
		</p>
		<?php
	}

	public function save( int $post_id ): void {
		if (
			! isset( $_POST['dk_price_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dk_price_nonce'] ) ), 'dk_save_price_' . $post_id ) ||
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
			! current_user_can( 'edit_post', $post_id )
		) {
			return;
		}

		update_post_meta( $post_id, '_dk_price',      sanitize_text_field( wp_unslash( $_POST['dk_price']      ?? '' ) ) );
		update_post_meta( $post_id, '_dk_price_note', sanitize_text_field( wp_unslash( $_POST['dk_price_note'] ?? '' ) ) );
	}
}
