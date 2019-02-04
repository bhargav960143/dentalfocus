<?php
/**
 * Plugin Name: Dentalfocus
 * Plugin URI: http://www.dentalfocus.co.uk
 * Description: This plugin is use for dentalfocus website features, provide various package and easy to use functionality, manage all settings from admin side. Provide quality of work and explore new way to keep in touch with clients and technologies.
 * Version: 1.0
 * Author: Dentalfocus Team
 * Author URI: http://www.dentalfocus.co.uk
 * License: GPL2
 */
 
/*
	Plugin Configuration
*/
if(!defined('DF_DIR')){
	define("DF_DIR", plugin_dir_url( __FILE__ ));
}
include 'include/config.php';
include 'include/db-function.php';
include 'dentalfocusmanager.php';
/*
	Add hook in plugin activation time.
	Add plugin configuration at activation time.
	
	Function parameter detail.
	
	Assign current file path 	
	1) __FILE__ 					: C:\xampp\htdocs\blog\wp-content\plugins\Dentalfocus\config.php
	2) dentalfocus_register_setup	: Function name you want to execute at activation time. 
*/
register_activation_hook(__FILE__, 'dentalfocus_acive_plugin');
/*
	Add hook in plugin uninstall time.
	Remove plugin from plugins folder
	
	Function parameter detail.
	
	Assign current file path 	
	1) __FILE__ 					: C:\xampp\htdocs\blog\wp-content\plugins\Dentalfocus\config.php
	2) dentalfocus_deactive_plugin	: Function name you want to execute at deactivation time. 
*/
register_uninstall_hook(__FILE__, 'dentalfocus_uninstall_plugin');
?>