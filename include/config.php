<?php
ob_start();
error_reporting(0);
/*
	Include config function file to manage plugin configuration
*/
include 'config-function.php';
/*
	Register Current Plufin Path
*/
register_current_plugin_path();
/*
	Add hook (action) to initialize plugin default function
*/
add_action('init', 'init_dentalfocus');
add_action('init', 'custom_cms_register');
add_action('init', 'custom_register_taxonomy');
add_action('admin_enqueue_scripts', 'df_register_css_js');