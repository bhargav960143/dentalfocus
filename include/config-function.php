<?php
/*
	Create function for register plugin configuration at activation time.
	Setup Database, Create Pages, Insert Widget, Insert Menu, Define Constants All are manage at lugin activation time.
*/
function dentalfocus_acive_plugin(){
	/*
		Define Global variable to use database connection
	*/
	global $wpdb;
	/*
		Get and set database default charset
		Create table for social media url manage
	*/
	$df_social_table = 'df_socialmedia';
	/*
		Check IF table not exist then create table.
	*/
	$createTable = "CREATE TABLE IF NOT EXISTS $df_social_table (
						id 		INT(11) 		NOT NULL AUTO_INCREMENT,
						title 	VARCHAR(255) 	NOT NULL,
						slug    VARCHAR(255)    NOT NULL,
						url 	VARCHAR(255) 	DEFAULT '' NOT NULL,
						PRIMARY KEY id (id)
					)";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $createTable );
}
/*
	Create function to remove plugin at uninstall time
*/
function dentalfocus_uninstall_plugin(){
	/*
		Define Global variable to use database connection
	*/
	global $wpdb;
	/*
		Get and set database default charset
		Drop table at deactivation of plugin
	*/
	$df_social_table = 'df_socialmedia';
	/*
		Check IF Table exist then remove
	*/
	$deleteTable = "DROP TABLE IF EXISTS $df_social_table";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $deleteTable );
}
/*
	Register Current Plugin And Manage Current Plugin Path
*/
function register_current_plugin_path(){
	/*
		Define Plugin Asserts
		Check the Asserts Path is defined, If not Then define
	*/
	if(!defined('DF_IMAGES')){
		define("DF_IMAGES", DF_DIR.'/images/');
	}
	if(!defined('DF_CSS')){
		define("DF_CSS", DF_DIR.'/css/');
	}
	if(!defined('DF_SCRIPTS')){
		define("DF_SCRIPTS", DF_DIR.'/scripts/');
	}
	if(!defined('WP_ADMIN_URL')){
		define("WP_ADMIN_URL", site_url().'/wp-admin/');
	}
}
/*
	Create function for iitialize dentalfocus settings.
	Register action and hooks.
*/
function init_dentalfocus(){
	/*
		Add action to register dentalfocus menu
	*/
	add_action('admin_menu', 'dentalfocus_admin_menu');
}
/*
	Create function for register dentalfocus menu.
	Register dashboard of dantal focus and give all manage option in the dashboard.
*/
function dentalfocus_admin_menu(){
	/*
		Add dentalfocus menu page for manage option		
	*/
	add_menu_page('Dentalfocus', 'Dentalfocus', 'manage_options', 'dentalfocus', 'dentalfocusmanager', DF_IMAGES.'favicon.ico', 81);
	add_menu_page('DF Settings', 'DF Settings', 'manage_options', 'dfsettings', 'dentalfocusmanager', 'dashicons-share-alt', 88);	
}
/*
	Create function for initialize custom texonomy
	Register Custom Post Type
*/
function custom_cms_register() {
	$labelsTestimonial = array(
		'name'                => _x( 'Testimonial', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Testimonial', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Testimonial', 'text_domain' ),
		'view_item'           => __( 'View Testimonial', 'text_domain' ),
		'add_new_item'        => __( 'Add New Testimonial', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Testimonial', 'text_domain' ),
		'update_item'         => __( 'Update Testimonial', 'text_domain' ),
		'search_items'        => __( 'Search Testimonial', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$labelsTeam = array(
		'name'                => _x( 'Team', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Team', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Team', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Team', 'text_domain' ),
		'view_item'           => __( 'View Team', 'text_domain' ),
		'add_new_item'        => __( 'Add New Team', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Team', 'text_domain' ),
		'update_item'         => __( 'Update Team', 'text_domain' ),
		'search_items'        => __( 'Search Team', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$labelsTreatment = array(
		'name'                => _x( 'Treatment', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Treatment', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Treatment', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Treatment', 'text_domain' ),
		'view_item'           => __( 'View Treatment', 'text_domain' ),
		'add_new_item'        => __( 'Add New Treatment', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Treatment', 'text_domain' ),
		'update_item'         => __( 'Update Treatment', 'text_domain' ),
		'search_items'        => __( 'Search Treatment', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$labelsPortfolio = array(
		'name'                => _x( 'Portfolio', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Portfolio', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Portfolio', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Portfolio', 'text_domain' ),
		'view_item'           => __( 'View Portfolio', 'text_domain' ),
		'add_new_item'        => __( 'Add New Portfolio', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Portfolio', 'text_domain' ),
		'update_item'         => __( 'Update Portfolio', 'text_domain' ),
		'search_items'        => __( 'Search Portfolio', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$labelsBanner = array(
		'name'                => _x( 'Banner', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Banner', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Banner', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Banner', 'text_domain' ),
		'view_item'           => __( 'View Banner', 'text_domain' ),
		'add_new_item'        => __( 'Add New Banner', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Banner', 'text_domain' ),
		'update_item'         => __( 'Update Banner', 'text_domain' ),
		'search_items'        => __( 'Search Banner', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	
	$argsTestimonial = array(
		'label'               => __( 'testimonial', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labelsTestimonial,
		'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'),
		'taxonomies'          => array( 'category-testimonial' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 82,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'menu_icon' 		  => 'dashicons-testimonial'
	);
	$argsTeam = array(
		'label'               => __( 'team', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labelsTeam,
		'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'),
		'taxonomies'          => array( 'category-team' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 83,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'menu_icon' 		  => 'dashicons-groups'
	);
	$argsTreatment = array(
		'label'               => __( 'treatment', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labelsTreatment,
		'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'),
		'taxonomies'          => array( 'category-treatment' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 84,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'menu_icon' 		  => 'dashicons-plus-alt'
	);
	$argsPortfolio = array(
		'label'               => __( 'portfolio', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labelsPortfolio,
		'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'),
		'taxonomies'          => array( 'category-portfolio' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 85,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'menu_icon' 		  => 'dashicons-portfolio'
	);
	$argsBanner = array(
		'label'               => __( 'banner', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labelsBanner,
		'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'),
		'taxonomies'          => array( 'category-banner' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 86,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'menu_icon' 		  => 'dashicons-format-gallery'
	);
	
	register_post_type( 'testimonial', $argsTestimonial );
	register_post_type( 'team', $argsTeam );
	register_post_type( 'treatment', $argsTreatment );
	register_post_type( 'portfolio', $argsPortfolio );
	register_post_type( 'banner', $argsBanner );
}
/*
	Create function for initialize custom texonomy
	Register a taxonomy
*/
function custom_register_taxonomy(){
	
	register_taxonomy( 'treatment-categories', 'treatment',
		array(
			'labels' => array(
				'name'              => 'Treatment Categories',
				'singular_name'     => 'Treatment Categories',
				'search_items'      => 'Search Treatment Categories',
				'all_items'         => 'All Treatment Categories',
				'edit_item'         => 'Edit Treatment Categories',
				'update_item'       => 'Update Treatment Categories',
				'add_new_item'      => 'Add New Treatment Categories',
				'new_item_name'     => 'New Treatment Categories Name',
				'menu_name'         => 'Treatment Categories',
			),
			
			'hierarchical' => true,
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'treatment-categories' ),
			'show_admin_column' => true
		)
	);
	
	register_taxonomy( 'banner-categories', 'banner',
		array(
			'labels' => array(
				'name'              => 'Banner Categories',
				'singular_name'     => 'Banner Categories',
				'search_items'      => 'Search Banner Categories',
				'all_items'         => 'All Banner Categories',
				'edit_item'         => 'Edit Banner Categories',
				'update_item'       => 'Update Banner Categories',
				'add_new_item'      => 'Add New Banner Categories',
				'new_item_name'     => 'New Banner Categories Name',
				'menu_name'         => 'Banner Categories',
			),
			'hierarchical' => true,
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'banner-categories' ),
			'show_admin_column' => true
		)
	);
	
	register_taxonomy( 'portfolio-categories', 'portfolio',
		array(
			'labels' => array(
				'name'              => 'Portfolio Categories',
				'singular_name'     => 'Portfolio Categories',
				'search_items'      => 'Search Portfolio Categories',
				'all_items'         => 'All Portfolio Categories',
				'edit_item'         => 'Edit Portfolio Categories',
				'update_item'       => 'Update Portfolio Categories',
				'add_new_item'      => 'Add New Portfolio Categories',
				'new_item_name'     => 'New Portfolio Categories Name',
				'menu_name'         => 'Portfolio Categories',
			),
			'hierarchical' => true,
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'portfolio-categories' ),
			'show_admin_column' => true
		)
	);
	
	register_taxonomy( 'team-categories', 'team',
		array(
			'labels' => array(
				'name'              => 'Team Categories',
				'singular_name'     => 'Team Categories',
				'search_items'      => 'Search Team Categories',
				'all_items'         => 'All Team Categories',
				'edit_item'         => 'Edit Team Categories',
				'update_item'       => 'Update Team Categories',
				'add_new_item'      => 'Add New Team Categories',
				'new_item_name'     => 'New Team Categories Name',
				'menu_name'         => 'Team Categories',
			),
			'hierarchical' => true,
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'team-categories' ),
			'show_admin_column' => true
		)
	);
	
	register_taxonomy( 'testimonial-categories', 'testimonial',
		array(
			'labels' => array(
				'name'              => 'Testimonial Categories',
				'singular_name'     => 'Testimonial Categories',
				'search_items'      => 'Search Testimonial Categories',
				'all_items'         => 'All Testimonial Categories',
				'edit_item'         => 'Edit Testimonial Categories',
				'update_item'       => 'Update Testimonial Categories',
				'add_new_item'      => 'Add New Testimonial Categories',
				'new_item_name'     => 'New Testimonial Categories Name',
				'menu_name'         => 'Testimonial Categories',
			),
			'hierarchical' => true,
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'testimonial-categories' ),
			'show_admin_column' => true
		)
	);
}
/*
	Create function for register css and js
*/
function df_register_css_js(){
	/*
     	Register Stylesheet for plugin
    */
	wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('validationEngine-jquery-css', DF_CSS . 'validationengine.jquery.css');

	/*
     	Register Scripts for plugin
    */
    wp_register_script('jquery.dataTables.js', DF_SCRIPTS . 'jquery.dataTables.js', array('jquery'));
    wp_enqueue_script('jquery.dataTables.js');
    wp_enqueue_script('jquery-validationEngine-js', DF_SCRIPTS . 'jquery.validationEngine.js');
    wp_enqueue_script('jquery-validationEngine-en-js', DF_SCRIPTS . 'jquery.validationEngine-en.js');
}
/*
	Function to create for message display.
	Message class are below.
	
	.media-upload-form .notice, 
	.media-upload-form div.error, 
	.wrap .notice, .wrap div.error, 
	.wrap div.updated
*/
function messagedisplay(){
	if(isset($_REQUEST['msg']) && !empty($_REQUEST['msg'])){
		switch ($_REQUEST['msg']) {
			case "swr":
				$messageText = "Something went wrong please try again.";
				$divClass = 'error';
			break;
			case "rsi":
				$messageText = "Record has been successfully inserted.";
				$divClass = 'updated';
			break;
			case "rds":
				$messageText = "Record has been successfully deleted.";
				$divClass = 'updated';
			break;
			case "rus":
				$messageText = "Record has been successfully updated.";
				$divClass = 'updated';
			break;
			default:
				$messageText = "Something went wrong please try again.";
				$divClass = 'error';
		}
		?><div class="updated <?php echo $divClass; ?> below-h4">
			<h4><?php echo $messageText; ?></h4>
		</div><?php
	}
}
?>