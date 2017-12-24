<?php
/**
 * Template Name: Blog : Left Sidebar Template
 *
 * The include file used for the showing blogs with the use of left sidebar.
 *
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
*/
get_header(); ?>
<?php global $avis_shortname; ?>
<div class="main-wrapper-item blog-template">
	<div class="container post-wrap left-sidebar">
		<div class="row-fluid">
				<div id="content" class="span9 blogsidebar">
					<?php 
					if(get_query_var( 'page')){$paged=get_query_var('page');}
					else{$paged=get_query_var('paged');}
					$args=array('post_type' => 'post','paged' => $paged);
					query_posts( $args ); 
					?>
					<?php if(have_posts()) : ?>
					<?php /* The loop */ ?>
					<?php while(have_posts()) : the_post(); ?>
					<?php if(is_sticky($post->ID)) { _e("<div class='sticky-post'>featured</div>",'avis'); } ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
					<?php get_template_part( 'includes/navigation', 'section' ); ?>
					<?php else :  ?>
					<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
					<?php wp_reset_query();?>
				</div>
				<!-- content -->

				<!-- Sidebar -->
				<div id="sidebar" class="span3">
					<?php get_sidebar(); ?>
				</div>
				<!-- Sidebar --> 
		</div><!-- row-fluid -->
	</div><!-- container -->
</div>
<?php get_footer(); ?>