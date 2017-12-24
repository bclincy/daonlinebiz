<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.1
 *
 *  functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 */
 
/********************************************************
 INCLUDE REQUIRED FILE FOR THEME (PLEASE DON'T REMOVE IT)
*********************************************************/
/**
 * THEMENAME & SHORTNAME	
 */

$avis_shortname = 'avis';	
$avis_themename = 'Avis';	
require_once(get_template_directory() . '/SketchBoard/functions/admin-init.php');
 
/**
 * THEME REQUIRED PLUGINS
 */
if ( !defined( 'AVIS_REQUIRED_PLUGINS' ) ) {
	define( 'AVIS_REQUIRED_PLUGINS', trailingslashit(get_theme_root()) . 'avis/includes/plugins' );
}
include_once('includes/avis-required-plugins.php');

/**
 * FUNTION TO ADD CSS CLASS TO BODY
 */
function avis_add_class( $classes ) {
	if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && is_front_page() ) {
		$classes[] = 'front-page';
	}
	return $classes;
}
add_filter( 'body_class','avis_add_class' );

 
/**
 * REGISTERS WIDGET AREAS
 */
function avis_widgets_init() {
	register_sidebar(array(
		'name' => 'Page Sidebar',
		'id'   => 'page-sidebar',
		'before_widget' => '<li id="%1$s" class="avis-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="avis-title">',
		'after_title' => '</h3><p class="title-seperator"><span></span></p>',
	));
	register_sidebar(array(
		'name' => 'Blog Sidebar',
		'id'   => 'blog-sidebar',
		'before_widget' => '<li id="%1$s" class="avis-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="avis-title">',
		'after_title' => '</h3><p class="title-seperator"><span></span></p>',
	));
	register_sidebar(array(
		'name' => 'Footer Sidebar',
		'id'   => 'footer-sidebar',
		'before_widget' => '<div id="%1$s" class="avis-footer-container span3 avis-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="avis-title avis-footer-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name'		  => __( 'Home Featured Sidebar', 'avis' ),
		'id'			=> 'home-featured-sidebar',
		'before_widget' => '<li id="%1$s" class="avis-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '',
		'after_title' => '',
	));
	register_sidebar(array(
		'name' => 'WooCommerce Sidebar',
		'id' => 'wooCommerce-sidebar',
		'before_widget' => '<li id="%1$s" class="avis-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="avis-title">',
		'after_title' => '</h3><p class="title-seperator"><span></span></p>',
	));
}
add_action( 'widgets_init', 'avis_widgets_init' );

/**
 * Sets up theme defaults and registers the various WordPress features that
 *  supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
*/
function avis_theme_setup() {
	/*
	 * Makes  available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Thirteen, use a find and
	 * replace to change 'avis' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'avis', get_template_directory() . '/languages' );
	 
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( "title-tag" );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support('post-thumbnails');

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array('video', 'gallery', 'quote') );
	set_post_thumbnail_size( 850, 400, true );
	add_image_size( 'portfolio-thumb-image',383,450,true);
	add_image_size( 'portfolio-related-image',285,200,true);
	add_image_size( 'portfolio-single-image',870,460,true);
	add_image_size( 'avis_standard_img',850,400,true);  //standard size
	add_image_size( 'avis_gallery_thumbnail_img',275,180,true);  //gallery thumbnail size
	add_image_size( 'full_gallery_thumbnail_img',385,220,true);  //gallery thumbnail size
	add_image_size( 'avis_fullblog_img',1170,400,true); //Full Blog size
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'Header' => __( 'Main Navigation', 'avis' ),
	));
}
add_action( 'after_setup_theme', 'avis_theme_setup' ); 

//---------------------------------------------------------------------
//---------------------------------------------------------------------