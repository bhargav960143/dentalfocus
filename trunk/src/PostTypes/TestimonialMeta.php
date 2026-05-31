<?php
declare(strict_types=1);

namespace DentalFocus\PostTypes;

class TestimonialMeta {

	public function register(): void {
		add_meta_box(
			'dk-star-rating',
			__( 'Star Rating', 'dentalfocus' ),
			[ $this, 'render_meta_box' ],
			'dk-testimonial',
			'side',
			'high'
		);
		add_action( 'save_post_dk-testimonial', [ $this, 'save' ] );
	}

	public function render_meta_box( \WP_Post $post ): void {
		$rating = absint( get_post_meta( $post->ID, '_dk_rating', true ) );
		wp_nonce_field( 'dk_save_rating_' . $post->ID, 'dk_rating_nonce' );
		?>
		<div class="dk-rating-picker">
			<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
			<label class="dk-rating-label<?php echo $rating === $i ? ' dk-rating-label--active' : ''; ?>">
				<input
					type="radio"
					name="dk_rating"
					value="<?php echo $i; ?>"
					<?php checked( $rating, $i ); ?>
				>
				<?php echo str_repeat( '★', $i ) . str_repeat( '☆', 5 - $i ); ?>
			</label>
			<?php endfor; ?>
			<label class="dk-rating-label dk-rating-label--none">
				<input type="radio" name="dk_rating" value="0" <?php checked( $rating, 0 ); ?>>
				<?php esc_html_e( 'No rating', 'dentalfocus' ); ?>
			</label>
		</div>
		<?php
	}

	public function save( int $post_id ): void {
		if (
			! isset( $_POST['dk_rating_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dk_rating_nonce'] ) ), 'dk_save_rating_' . $post_id ) ||
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
			! current_user_can( 'edit_post', $post_id )
		) {
			return;
		}

		$rating = isset( $_POST['dk_rating'] ) ? absint( $_POST['dk_rating'] ) : 0;
		$rating = min( 5, max( 0, $rating ) );

		update_post_meta( $post_id, '_dk_rating', $rating );
	}
}
