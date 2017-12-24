<?php
/**
 * Avis Testimonials functions and definitions
 *
 * @package	 WordPress
 * @subpackage  Avis
 * @version	 1.0.0
 *
 */
/*-----------------------------------------------------------------------------------*/
/*  Register Testimonial post format.
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'avis_testimonial_post_type' );

function avis_testimonial_post_type() {
global $avis_shortname;
	register_post_type( 'testimonial_post',
		array(
			'labels' => array(
			'name' =>  __('Avis Testimonial', 'avis' ),
			'singular_name' => __( 'testimonial', 'avis' ),
			'add_new' => __('Add Testimonial', 'avis'),
			'add_new_item' => __('Add New Testimonial', 'avis'),
			'edit_item' => __('Edit Testimonial', 'avis'),
			'new_item' => __('New Testimonial', 'avis'),
			'all_items' => __('All Testimonial', 'avis'),
			'view_item' => __('View Testimonial', 'avis')
			),
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true, 
	'show_in_menu' => true, 
	'query_var' => true,
	'rewrite' => true,
	'capability_type' => 'post',
	'has_archive' => true, 
	'hierarchical' => false,
	'menu_icon' => 'dashicons-testimonial',
	'rewrite' => array('slug' => 'testimonial_post'),
	'supports' => array('title')
	));
}
