<?php

/**
 * Sketch Team member functions and definitions
 *
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 */

/*-----------------------------------------------------------------------------------*/

/*	Register Team Member post format.

/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'avis_teammember_posttype_init' );

if ( !function_exists( 'avis_teammember_posttype_init' ) ) :

function avis_teammember_posttype_init() {

	global $avis_themename,$avis_shortname;

	$avis_teammember_labels = array(

		'name' =>  ucwords($avis_themename).__(' Team Member','avis' ),

		'singular_name' => _x('teammember', 'post type singular name','avis'),

		'add_new' => _x('Add New', 'team member','avis'),

		'add_new_item' => __('Add New Team Member','avis'),

		'edit_item' => __('Edit Team Member','avis'),

		'new_item' => __('New Team Member','avis'),

		'all_items' => __('All Team Member','avis'),

		'view_item' => __('View Team Member','avis'),

		'search_items' => __('Search Team Member','avis'),

		'not_found' =>  __('No Team Member found','avis'),

		'not_found_in_trash' => __('No Team Member found in Trash','avis'), 

		'parent_item_colon' => '',

		'menu_name' => __('Avis Team','avis')

	);

	$avis_teammember_args = array(

		'labels' => $avis_teammember_labels,

		'public' => true,

		'publicly_queryable' => true,

		'show_ui' => true, 

		'show_in_menu' => true, 

		'query_var' => true,

		'rewrite' => true,

		'capability_type' => 'post',

		'has_archive' => true, 

		'hierarchical' => false,

		'rewrite' => array('slug' => 'team-member'),

		'menu_icon' => 'dashicons-admin-users',

		'supports' => array( 'title' )

	); 

	register_post_type( 'team_member', $avis_teammember_args );

}

endif;