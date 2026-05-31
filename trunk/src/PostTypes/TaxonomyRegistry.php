<?php
declare(strict_types=1);

namespace DentalFocus\PostTypes;

class TaxonomyRegistry {

	private const TAXONOMIES = [
		'dk-testimonial-cat' => [ 'post_type' => 'dk-testimonial', 'label' => 'Testimonial Category',  'slug' => 'testimonial-category' ],
		'dk-team-cat'        => [ 'post_type' => 'dk-team',        'label' => 'Team Category',          'slug' => 'team-category' ],
		'dk-treatment-cat'   => [ 'post_type' => 'dk-treatment',   'label' => 'Treatment Category',     'slug' => 'treatment-category' ],
		'dk-portfolio-cat'   => [ 'post_type' => 'dk-portfolio',   'label' => 'Portfolio Category',     'slug' => 'portfolio-category' ],
		'dk-banner-cat'      => [ 'post_type' => 'dk-banner',      'label' => 'Banner Category',        'slug' => 'banner-category' ],
	];

	public function register(): void {
		foreach ( self::TAXONOMIES as $taxonomy => $config ) {
			$label  = $config['label'];
			$plural = $label . 's';

			register_taxonomy( $taxonomy, $config['post_type'], [
				'labels'            => $this->build_labels( $label, $plural ),
				'hierarchical'      => true,
				'public'            => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'rewrite'           => [ 'slug' => $config['slug'] ],
			] );
		}
	}

	/** @return array<string, string> */
	private function build_labels( string $singular, string $plural ): array {
		return [
			'name'              => $plural,
			'singular_name'     => $singular,
			'search_items'      => sprintf( __( 'Search %s', 'DentalFocus' ), $plural ),
			'all_items'         => sprintf( __( 'All %s', 'DentalFocus' ), $plural ),
			'edit_item'         => sprintf( __( 'Edit %s', 'DentalFocus' ), $singular ),
			'update_item'       => sprintf( __( 'Update %s', 'DentalFocus' ), $singular ),
			'add_new_item'      => sprintf( __( 'Add New %s', 'DentalFocus' ), $singular ),
			'new_item_name'     => sprintf( __( 'New %s Name', 'DentalFocus' ), $singular ),
			'menu_name'         => $plural,
		];
	}
}
