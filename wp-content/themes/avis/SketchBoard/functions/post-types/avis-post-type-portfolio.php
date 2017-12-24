<?php

/**
 * Sketch Portfolio functions and definitions
 *
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 */

/*-----------------------------------------------------------------------------------*/

/*	Register Portfolio post format.

/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'avis_portfolio_post_type' );



function avis_portfolio_post_type() {

global $avis_shortname;

	register_post_type( 'portfolio_post',

		array(

			'labels' => array(

			'name' =>  __('Avis Portfolio', 'avis' ),

			'singular_name' => __( 'portfolio', 'avis' ),

			'add_new' => __('Add Portfolio', 'avis'),

			'add_new_item' => __('Add New Portfolio', 'avis'),

			'edit_item' => __('Edit Portfolio', 'avis'),

			'new_item' => __('New Portfolio', 'avis'),

			'all_items' => __('All Portfolios', 'avis'),

			'view_item' => __('View Portfolio', 'avis')

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

	'menu_icon' => 'dashicons-portfolio',

	'rewrite' => array('slug' => 'portfolio_post'),

	'supports' => array('title','editor','post-formats'),

	'taxonomies'=>array('portfolio_category','portfolio_tag')

	));

}



function portfolio_category_init() {



	// create a new taxonomy

	register_taxonomy(

		'portfolio_category',

		'portfolio_post',

		array(

			'hierarchical' => true,

			'label' => __( 'Portfolio Categories', 'avis' ),

			'singular_label' => __( 'Portfolio Category', 'avis' ),

			'rewrite' => array( 'slug' => 'portfolio_category')

		)

	);

}

add_action( 'init', 'portfolio_category_init' );


function avis_wp_default_terms(){

$parent_term = term_exists( 'uncategories portfolio', 'portfolio_category' ); // array is returned if taxonomy is given

$parent_term_id = $parent_term['term_id']; // get numeric term id

	if ($parent_term == 0 && $parent_term == null) {

		wp_insert_term(

			'uncategories portfolio', // the term 

			'portfolio_category', // the taxonomy

			array(

				'description'=> 'uncategories portfolio.',

				'slug' => 'all_portfolios',

				'parent'=> $parent_term_id

			)

		);

	}

}

add_action( 'init', 'avis_wp_default_terms' );


function avis_set_default_object_terms( $post_id, $post ) {

	if ( 'publish' === $post->post_status ) {

		$defaults = array(

			'portfolio_category' => array( 'all_portfolios' ),

			);

		$taxonomies = get_object_taxonomies( $post->post_type );

		foreach ( (array) $taxonomies as $taxonomy ) {

			$terms = wp_get_post_terms( $post_id, $taxonomy );

			if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {

				wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );

			}

		}

	}

}

add_action( 'save_post', 'avis_set_default_object_terms', 100, 2 );
