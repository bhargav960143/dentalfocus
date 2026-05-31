<?php
declare(strict_types=1);

namespace DentalKit\PostTypes;

class PostTypeRegistry {

	private const TYPES = [
		'dk-testimonial' => [
			'label'       => 'Testimonial',
			'icon'        => 'dashicons-format-quote',
			'position'    => 82,
			'supports'    => [ 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ],
			'taxonomies'  => [ 'dk-testimonial-cat' ],
		],
		'dk-team' => [
			'label'       => 'Team Member',
			'icon'        => 'dashicons-groups',
			'position'    => 83,
			'supports'    => [ 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ],
			'taxonomies'  => [ 'dk-team-cat' ],
		],
		'dk-treatment' => [
			'label'       => 'Treatment',
			'icon'        => 'dashicons-plus-alt',
			'position'    => 84,
			'supports'    => [ 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ],
			'taxonomies'  => [ 'dk-treatment-cat' ],
		],
		'dk-portfolio' => [
			'label'       => 'Portfolio',
			'icon'        => 'dashicons-portfolio',
			'position'    => 85,
			'supports'    => [ 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ],
			'taxonomies'  => [ 'dk-portfolio-cat' ],
		],
		'dk-banner' => [
			'label'       => 'Banner',
			'icon'        => 'dashicons-format-gallery',
			'position'    => 86,
			'supports'    => [ 'title', 'editor', 'thumbnail', 'revisions' ],
			'taxonomies'  => [ 'dk-banner-cat' ],
		],
	];

	public function register(): void {
		foreach ( self::TYPES as $slug => $config ) {
			$label  = $config['label'];
			$plural = $label . 's';

			register_post_type( $slug, [
				'label'               => __( $plural, 'dentalkit' ),
				'labels'              => $this->build_labels( $label, $plural ),
				'description'         => '',
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_rest'        => true,
				'menu_position'       => $config['position'],
				'menu_icon'           => $config['icon'],
				'supports'            => $config['supports'],
				'taxonomies'          => $config['taxonomies'],
				'hierarchical'        => false,
				'has_archive'         => true,
				'publicly_queryable'  => true,
				'can_export'          => true,
				'capability_type'     => 'post',
				'rewrite'             => [ 'slug' => $slug ],
			] );
		}
	}

	/** @return array<string, string> */
	private function build_labels( string $singular, string $plural ): array {
		return [
			'name'               => $plural,
			'singular_name'      => $singular,
			'add_new'            => __( 'Add New', 'dentalkit' ),
			'add_new_item'       => sprintf( __( 'Add New %s', 'dentalkit' ), $singular ),
			'edit_item'          => sprintf( __( 'Edit %s', 'dentalkit' ), $singular ),
			'new_item'           => sprintf( __( 'New %s', 'dentalkit' ), $singular ),
			'view_item'          => sprintf( __( 'View %s', 'dentalkit' ), $singular ),
			'search_items'       => sprintf( __( 'Search %s', 'dentalkit' ), $plural ),
			'not_found'          => sprintf( __( 'No %s found', 'dentalkit' ), strtolower( $plural ) ),
			'not_found_in_trash' => sprintf( __( 'No %s in trash', 'dentalkit' ), strtolower( $plural ) ),
			'all_items'          => sprintf( __( 'All %s', 'dentalkit' ), $plural ),
			'menu_name'          => $plural,
		];
	}
}
