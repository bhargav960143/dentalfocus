<?php
declare(strict_types=1);

namespace DentalKit;

class Plugin {

	private static ?Plugin $instance = null;
	private Loader $loader;

	public const VERSION  = '2.0.0';
	public const SLUG     = 'dentalkit';
	public const TD       = 'dentalkit';
	public const MIN_WP   = '6.0';
	public const MIN_PHP  = '8.0';

	private function __construct() {
		$this->loader = new Loader();
		$this->register_hooks();
	}

	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function register_hooks(): void {
		$post_types = new PostTypes\PostTypeRegistry();
		$taxonomies = new PostTypes\TaxonomyRegistry();
		$shortcode        = new FormBuilder\Shortcode();
		$social_shortcode = new FormBuilder\SocialShortcode();
		$cpt_shortcodes   = new FormBuilder\CptShortcodes();
		$handler          = new FormBuilder\SubmissionHandler();
		$rest             = new REST\FormEndpoint();

		$this->loader->add_action( 'init', $post_types,       'register' );
		$this->loader->add_action( 'init', $taxonomies,       'register' );
		$this->loader->add_action( 'init', $shortcode,        'register' );
		$this->loader->add_action( 'init', $social_shortcode, 'register' );
		$this->loader->add_action( 'init', $cpt_shortcodes,   'register' );
		$this->loader->add_action( 'rest_api_init', $rest, 'register_routes' );
		$this->loader->add_action( 'wp_ajax_dk_submit_form',        $handler, 'handle' );
		$this->loader->add_action( 'wp_ajax_nopriv_dk_submit_form', $handler, 'handle' );

		if ( is_admin() ) {
			$menu   = new Admin\AdminMenu();
			$assets = new Admin\Assets();
			$this->loader->add_action( 'admin_menu',             $menu,   'register' );
			$this->loader->add_action( 'admin_enqueue_scripts',  $assets, 'enqueue_admin' );
		} else {
			$assets = new Admin\Assets();
			$this->loader->add_action( 'wp_enqueue_scripts', $assets, 'enqueue_frontend' );
		}
	}

	public function run(): void {
		$this->loader->run();
	}
}
