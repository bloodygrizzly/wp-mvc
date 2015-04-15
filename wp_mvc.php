<?php
/*
Plugin Name: WP MVC
Plugin URI: http://wordpress.org/extend/plugins/wp-mvc/
Description: Sets up an MVC framework inside of WordPress.
Author: Tom Benner
Version: 1.3
Author URI: 
*/

if (!defined('MVC_PLUGIN_PATH')) {
	define('MVC_PLUGIN_PATH', dirname(__FILE__).'/');
}

// Load public functionality
require_once MVC_PLUGIN_PATH.'core/loaders/mvc_public_loader.php';
$loader = new MvcPublicLoader();

if (is_admin()) {

	// Load admin functionality
	require_once MVC_PLUGIN_PATH.'core/loaders/mvc_admin_loader.php';
	$admin_loader = new MvcAdminLoader();
	
	add_action('wp_loaded', array($loader,'load_rewrite_rules'));
	add_action('admin_init', array($admin_loader, 'admin_init'));
	add_action('admin_menu', array($admin_loader, 'add_menu_pages'));
	add_action('admin_menu', array($admin_loader, 'add_settings_pages'));
	add_action('plugins_loaded', array($admin_loader, 'add_admin_ajax_routes'));

}  else {

	add_filter('rewrite_rules_array', array($loader, 'add_rewrite_rules'));
	add_filter('query_vars', array($loader, 'add_query_vars'));
	add_action('template_redirect', array($loader, 'template_redirect'));
}

// Load global functionality

add_action('init', array($loader, 'init'));
add_action('widgets_init', array($loader, 'register_widgets'));
add_filter('post_type_link', array($loader, 'filter_post_link'), 10, 2);
