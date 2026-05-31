<?php
declare(strict_types=1);

namespace DentalFocus\PostTypes;

class PortfolioMeta {

	public function register(): void {
		add_meta_box(
			'dk-before-after',
			__( 'Before / After Images', 'dentalfocus' ),
			[ $this, 'render_meta_box' ],
			'dk-portfolio',
			'normal',
			'high'
		);
		add_action( 'save_post_dk-portfolio', [ $this, 'save' ] );
	}

	public function render_meta_box( \WP_Post $post ): void {
		$before_id = absint( get_post_meta( $post->ID, '_dk_before_image', true ) );
		$after_id  = absint( get_post_meta( $post->ID, '_dk_after_image',  true ) );
		wp_nonce_field( 'dk_save_ba_' . $post->ID, 'dk_ba_nonce' );
		?>
		<div class="dk-ba-meta">
			<?php foreach ( [ 'before' => __( 'Before Image', 'dentalfocus' ), 'after' => __( 'After Image', 'dentalfocus' ) ] as $key => $label ) :
				$img_id  = ( 'before' === $key ) ? $before_id : $after_id;
				$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'medium' ) : '';
			?>
			<div class="dk-ba-field">
				<strong><?php echo esc_html( $label ); ?></strong>
				<div class="dk-ba-preview" id="dk-ba-preview-<?php echo esc_attr( $key ); ?>">
					<?php if ( $img_url ) : ?>
					<img src="<?php echo esc_url( $img_url ); ?>" style="max-width:100%;height:auto;display:block;margin-bottom:8px;" />
					<?php endif; ?>
				</div>
				<input type="hidden" name="dk_<?php echo esc_attr( $key ); ?>_image" id="dk-<?php echo esc_attr( $key ); ?>-image-id" value="<?php echo esc_attr( (string) $img_id ); ?>" />
				<button type="button" class="button dk-ba-select" data-target="dk-<?php echo esc_attr( $key ); ?>-image-id" data-preview="dk-ba-preview-<?php echo esc_attr( $key ); ?>">
					<?php esc_html_e( 'Select Image', 'dentalfocus' ); ?>
				</button>
				<?php if ( $img_id ) : ?>
				<button type="button" class="button dk-ba-remove" data-target="dk-<?php echo esc_attr( $key ); ?>-image-id" data-preview="dk-ba-preview-<?php echo esc_attr( $key ); ?>" style="margin-left:4px;">
					<?php esc_html_e( 'Remove', 'dentalfocus' ); ?>
				</button>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<style>
		.dk-ba-meta { display:flex; gap:24px; }
		.dk-ba-field { flex:1; }
		.dk-ba-field strong { display:block; margin-bottom:8px; }
		</style>
		<?php
	}

	public function save( int $post_id ): void {
		if (
			! isset( $_POST['dk_ba_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dk_ba_nonce'] ) ), 'dk_save_ba_' . $post_id ) ||
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
			! current_user_can( 'edit_post', $post_id )
		) {
			return;
		}

		update_post_meta( $post_id, '_dk_before_image', absint( wp_unslash( $_POST['dk_before_image'] ?? 0 ) ) );
		update_post_meta( $post_id, '_dk_after_image',  absint( wp_unslash( $_POST['dk_after_image']  ?? 0 ) ) );
	}
}
