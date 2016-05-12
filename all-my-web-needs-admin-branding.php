<?php
/*
Plugin Name: All My Web Needs - Branding
Description: This plugin incorporates custom features created by All My Web Needs.
Author: All My Web Needs
Author URI: https://allmywebneeds.com
Version: 1.2.1
GitHub Plugin URI: https://github.com/kizinko/all-my-web-needs-admin-branding
GitHub Branch: master
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Add custom CSS stylesheet for Login Page
 **/
add_action( 'login_enqueue_scripts', 'login_stylesheet__amwn' );
function login_stylesheet__amwn() {
	wp_enqueue_style( 'amwn-login-style', plugins_url('all-my-web-needs-admin-branding') . "/style-login.css", array(), null );
}

/**
 * login header url
 **/
add_action( 'login_headerurl', 'login_headerurl__amwn' );
function login_headerurl__amwn() {
	return home_url();
}

/**
 * login header title
 **/
add_action( 'login_headertitle', 'login_headertitle__amwn' );
function login_headertitle__amwn() {
	return get_bloginfo('name');
}

/**
 * Add custom CSS stylesheet for Admin Area
 **/
// add_action( 'admin_head', 'admin_stylesheet__amwn' );
function admin_stylesheet__amwn() {
	echo "<link rel='stylesheet' id='custom_wp_admin_css' href='" . plugins_url('all-my-web-needs-admin-branding') . "/all-my-web-needs/style-admin.css' type='text/css' media='all' />";
}

/**
 * Remove update notification (nag) from top of admin area
 **/
add_action( 'admin_init', 'no_update_nag__amwn' );
function no_update_nag__amwn() {
	remove_action( 'admin_notices', 'update_nag', 3 );
}

/**
 * Remove unwanted dashboard widgets for relevant users
 **/
add_action( 'wp_dashboard_setup', 'wptutsplus_remove_dashboard_widgets__amwn' );
function wptutsplus_remove_dashboard_widgets__amwn() {
	$user = wp_get_current_user();
	if ( ! $user->has_cap( 'manage_sites' ) ) {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'normal' );
		remove_meta_box( 'tribe_dashboard_widget', 'dashboard', 'normal' );
		remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal' );
		remove_meta_box( 'woocommerce_dashboard_recent_reviews', 'dashboard', 'normal' );
		remove_meta_box( 'woocommerce_dashboard_recent_orders', 'dashboard', 'normal' );
		remove_meta_box( 'woocommerce_dashboard_sales', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	}
}

/**
 * Move the 'Right Now' dashboard widget to the right hand side
 **/
add_action( 'wp_dashboard_setup', 'wptutsplus_move_dashboard_widget__amwn' );
function wptutsplus_move_dashboard_widget__amwn() {
	$user = wp_get_current_user();
	if ( ! $user->has_cap( 'manage_sites' ) ) {
		global $wp_meta_boxes;
		$widget = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'];
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_right_now'] = $widget;
	}
}

/**
 * Add widgets to dashboard
 **/
function wptutsplus_add_dashboard_widgets__amwn() {
	wp_add_dashboard_widget( 'wptutsplus_dashboard_welcome', 'Welcome', 'wptutsplus_add_welcome_widget__amwn' );
	wp_add_dashboard_widget( 'wptutsplus_dashboard_links', 'Useful Links', 'wptutsplus_add_links_widget__amwn' );
}

/**
 * Create "Welcome" widget for dashboard
 **/
function wptutsplus_add_welcome_widget__amwn() {

	?>
	<p><strong>This CMS (content management system) lets you edit the pages and blog posts on your website.</strong></p>
	<p>Your site consists of the following content, which you can access via the menu on the left:</p>
	<ul>
		<li><strong>Pages</strong> - Web Pages (home page, about us, etc.)</li>
		<li><strong>Posts</strong> - Blog Posts (news, articles, etc.)</li>
		<li><strong>Media</strong> - Images / Videos / Documents (you can upload via the Media menu on the left or within each post or page)</li>
	</ul>
	<p>On each editing screen there are instructions to help you add and edit content. If you need assistance please contact your web specialist at <a href="http://allmywebneeds.com">All My Web Needs</a> or send us a message on our <a href="http://allmywebneeds.com/support">support page</a>.</p>
	<?php
}

/**
 * Create "Useful Links" widget for dashboard
 **/
add_action( 'wp_dashboard_setup', 'wptutsplus_add_dashboard_widgets__amwn' );
function wptutsplus_add_links_widget__amwn() {
	?>
	<p>Some links to resources which will help you manage your site:</p>
	<ul>
		<li><a href="http://easywpguide.com">Easy WP Guide</a></li>
		<li><a href="http://www.wpbeginner.com">WP Beginner</a></li>
	</ul>
	<?php
}

/**
 * Add support link in admin toolbar
 **/
add_action( 'wp_before_admin_bar_render', 'add_support_link_to_toolbar__amwn' );
function add_support_link_to_toolbar__amwn() {
	global $wp_admin_bar;
	$wp_admin_bar->add_node(array(
		'id'    => 'allmywebneeds-support-link',
		'title' => 'Get Support',
		'href'  => 'http://allmywebneeds.com/support'
	));
}

/**
 * Replace footer text in admin area
 **/
add_filter('admin_footer_text', 'remove_footer_admin__amwn');
function remove_footer_admin__amwn( $footer ) {
	$footer = ' Customized by <a href="http://allmywebneeds.com" target="_blank">All My Web Needs</a> | CMS Developed by <a href="http://www.wordpress.org" target="_blank">WordPress</a> ';
	return $footer;
}
