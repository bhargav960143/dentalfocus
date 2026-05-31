<?php
declare(strict_types=1);

namespace DentalFocus;

class Loader {

	/** @var array<int, array<string, mixed>> */
	private array $actions = [];

	/** @var array<int, array<string, mixed>> */
	private array $filters = [];

	public function add_action( string $hook, object $component, string $callback, int $priority = 10, int $args = 1 ): void {
		$this->actions[] = compact( 'hook', 'component', 'callback', 'priority', 'args' );
	}

	public function add_filter( string $hook, object $component, string $callback, int $priority = 10, int $args = 1 ): void {
		$this->filters[] = compact( 'hook', 'component', 'callback', 'priority', 'args' );
	}

	public function run(): void {
		foreach ( $this->filters as $h ) {
			add_filter( $h['hook'], [ $h['component'], $h['callback'] ], $h['priority'], $h['args'] );
		}
		foreach ( $this->actions as $h ) {
			add_action( $h['hook'], [ $h['component'], $h['callback'] ], $h['priority'], $h['args'] );
		}
	}
}
