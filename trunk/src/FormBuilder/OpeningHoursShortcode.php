<?php
declare(strict_types=1);

namespace DentalFocus\FormBuilder;

class OpeningHoursShortcode {

	private const DAYS = [
		'monday'    => 'Monday',
		'tuesday'   => 'Tuesday',
		'wednesday' => 'Wednesday',
		'thursday'  => 'Thursday',
		'friday'    => 'Friday',
		'saturday'  => 'Saturday',
		'sunday'    => 'Sunday',
	];

	public function register(): void {
		add_shortcode( 'dk_opening_hours', [ $this, 'render' ] );
	}

	public function render( array|string $atts ): string {
		$atts  = shortcode_atts( [ 'style' => 'table' ], $atts, 'dk_opening_hours' );
		$hours = get_option( 'dk_opening_hours', [] );

		if ( empty( $hours ) ) {
			return '';
		}

		$today = strtolower( gmdate( 'l' ) );
		ob_start();
		?>
		<div class="dk-opening-hours">
			<?php if ( 'list' === $atts['style'] ) : ?>
			<ul class="dk-hours-list">
				<?php foreach ( self::DAYS as $key => $label ) :
					$entry = $hours[ $key ] ?? [];
					$open  = ! empty( $entry['open'] );
					?>
				<li class="dk-hours-row<?php echo $key === $today ? ' dk-hours-today' : ''; ?>">
					<span class="dk-hours-day"><?php echo esc_html( $label ); ?></span>
					<span class="dk-hours-time">
						<?php if ( $open ) : ?>
							<?php echo esc_html( $entry['from'] ?? '' ); ?> &ndash; <?php echo esc_html( $entry['to'] ?? '' ); ?>
						<?php else : ?>
							<?php esc_html_e( 'Closed', 'dentalfocus' ); ?>
						<?php endif; ?>
					</span>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php else : ?>
			<table class="dk-hours-table">
				<tbody>
				<?php foreach ( self::DAYS as $key => $label ) :
					$entry = $hours[ $key ] ?? [];
					$open  = ! empty( $entry['open'] );
					?>
				<tr class="dk-hours-row<?php echo $key === $today ? ' dk-hours-today' : ''; ?>">
					<td class="dk-hours-day"><?php echo esc_html( $label ); ?></td>
					<td class="dk-hours-time">
						<?php if ( $open ) : ?>
							<?php echo esc_html( $entry['from'] ?? '' ); ?> &ndash; <?php echo esc_html( $entry['to'] ?? '' ); ?>
						<?php else : ?>
							<?php esc_html_e( 'Closed', 'dentalfocus' ); ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean() ?: '';
	}
}
