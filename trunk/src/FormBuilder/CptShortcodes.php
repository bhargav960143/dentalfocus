<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder;

class CptShortcodes {

	private const SHORTCODES = [
		'dk_testimonials' => [ 'post_type' => 'dk-testimonial', 'tax' => 'dk-testimonial-cat', 'cols' => 3 ],
		'dk_team'         => [ 'post_type' => 'dk-team',        'tax' => 'dk-team-cat',        'cols' => 3 ],
		'dk_treatments'   => [ 'post_type' => 'dk-treatment',   'tax' => 'dk-treatment-cat',   'cols' => 3 ],
		'dk_portfolio'    => [ 'post_type' => 'dk-portfolio',   'tax' => 'dk-portfolio-cat',   'cols' => 4 ],
		'dk_banners'      => [ 'post_type' => 'dk-banner',      'tax' => 'dk-banner-cat',      'cols' => 1 ],
	];

	public function register(): void {
		foreach ( self::SHORTCODES as $tag => $config ) {
			add_shortcode( $tag, function ( array|string $atts ) use ( $tag, $config ) {
				return $this->render( $tag, $config, $atts );
			} );
		}
	}

	private function render( string $tag, array $config, array|string $raw_atts ): string {
		$atts = shortcode_atts( [
			'limit'    => 10,
			'category' => '',
			'columns'  => $config['cols'],
			'orderby'  => 'date',
			'order'    => 'DESC',
		], $raw_atts, $tag );

		$args = [
			'post_type'      => $config['post_type'],
			'post_status'    => 'publish',
			'posts_per_page' => absint( $atts['limit'] ),
			'orderby'        => sanitize_key( $atts['orderby'] ),
			'order'          => in_array( strtoupper( $atts['order'] ), [ 'ASC', 'DESC' ], true )
				? strtoupper( $atts['order'] )
				: 'DESC',
		];

		if ( $atts['category'] ) {
			$args['tax_query'] = [ [
				'taxonomy' => $config['tax'],
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $atts['category'] ),
			] ];
		}

		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return '';
		}

		$cols    = absint( $atts['columns'] );
		$cols    = max( 1, min( $cols, 6 ) );
		$type    = str_replace( 'dk-', '', $config['post_type'] );
		$classes = "dk-cpt-grid dk-{$type}-grid dk-cols-{$cols}";

		ob_start();
		echo '<div class="' . esc_attr( $classes ) . '">';

		while ( $query->have_posts() ) {
			$query->the_post();
			$this->render_card( $type );
		}

		echo '</div>';

		wp_reset_postdata();

		return ob_get_clean() ?: '';
	}

	private function render_card( string $type ): void {
		$has_thumb = has_post_thumbnail();
		$permalink = get_permalink();
		$title     = get_the_title();
		$excerpt   = get_the_excerpt();
		?>
		<div class="dk-cpt-item dk-<?php echo esc_attr( $type ); ?>-item">
			<?php if ( $has_thumb ) : ?>
			<div class="dk-cpt-thumbnail">
				<a href="<?php echo esc_url( $permalink ); ?>">
					<?php the_post_thumbnail( 'medium', [ 'class' => 'dk-cpt-img', 'alt' => esc_attr( $title ) ] ); ?>
				</a>
			</div>
			<?php endif; ?>
			<div class="dk-cpt-content">
				<?php if ( 'testimonial' === $type ) :
				$rating = absint( get_post_meta( get_the_ID(), '_dk_rating', true ) );
				?>
				<?php if ( $rating > 0 ) : ?>
				<div class="dk-star-rating" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'dentalfocus' ), $rating ) ); ?>">
					<?php
					for ( $i = 1; $i <= 5; $i++ ) {
						echo '<span class="dk-star ' . ( $i <= $rating ? 'dk-star--filled' : 'dk-star--empty' ) . '">★</span>';
					}
					?>
				</div>
				<?php endif; ?>
				<div class="dk-testimonial-quote">
					<?php the_content(); ?>
				</div>
				<p class="dk-testimonial-author">&mdash; <?php echo esc_html( $title ); ?></p>
				<?php else :
				$price      = sanitize_text_field( get_post_meta( get_the_ID(), '_dk_price',      true ) );
				$price_note = sanitize_text_field( get_post_meta( get_the_ID(), '_dk_price_note', true ) );
				?>
				<h3 class="dk-cpt-title">
					<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
				</h3>
				<?php if ( $excerpt ) : ?>
				<p class="dk-cpt-excerpt"><?php echo esc_html( $excerpt ); ?></p>
				<?php endif; ?>
				<?php if ( $price && 'treatment' === $type ) : ?>
				<div class="dk-treatment-price">
					<span class="dk-price-value"><?php echo esc_html( $price ); ?></span>
					<?php if ( $price_note ) : ?>
					<span class="dk-price-note"><?php echo esc_html( $price_note ); ?></span>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<?php if ( 'team' === $type ) :
					$socials = [
						'linkedin'  => get_post_meta( get_the_ID(), '_dk_team_linkedin',  true ),
						'instagram' => get_post_meta( get_the_ID(), '_dk_team_instagram', true ),
						'facebook'  => get_post_meta( get_the_ID(), '_dk_team_facebook',  true ),
						'twitter'   => get_post_meta( get_the_ID(), '_dk_team_twitter',   true ),
					];
					$socials = array_filter( $socials );
					if ( $socials ) : ?>
				<div class="dk-team-socials">
					<?php foreach ( $socials as $platform => $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" class="dk-team-social-link dk-team-social-<?php echo esc_attr( $platform ); ?>"
					   target="_blank" rel="noopener noreferrer">
						<?php echo esc_html( ucfirst( $platform ) ); ?>
					</a>
					<?php endforeach; ?>
				</div>
				<?php endif; endif; ?>
				<a href="<?php echo esc_url( $permalink ); ?>" class="dk-cpt-link">
					<?php esc_html_e( 'Read More', 'DentalFocus' ); ?> &rarr;
				</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
