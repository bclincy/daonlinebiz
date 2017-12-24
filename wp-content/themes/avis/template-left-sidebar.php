<?php 
/**
 * Template Name: Page : Left Sidebar Template
 *
 * This is the Normal Page Template like default page.php, but this is with left sidebar.
 *
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
*/
get_header(); ?>
<?php global $avis_shortname; ?>
<div class="main-wrapper-item"> 
	<?php if(have_posts()) : ?>
	<?php while(have_posts()) : the_post(); ?>	
	<div class="page-content left-sidebar">
		<div class="container post-wrap">
			<div class="row-fluid">
			<div id="content" class="span9">
				<div class="post" id="post-<?php the_ID(); ?>">
					<div class="skepost">
						<?php the_content(); ?>
						<?php wp_link_pages(__('<p><strong>Pages:</strong> ','avis'), '</p>', __('number','avis')); ?>
						<?php edit_post_link('Edit', '', ''); ?>	
					</div><!-- skepost --> 
				</div>
				<!-- post -->
				<?php endwhile; ?>
				<?php else :  ?>
				<div class="post">
					<h2>
						<?php _e('Page Does Not Exist','avis'); ?>
					</h2>
				</div>
				<?php endif; ?>
				<div class="clearfix"></div>
			</div><!-- content -->

			<!-- Sidebar -->
			<div id="sidebar" class="span3">
				<?php get_sidebar('page'); ?>
			</div>
			<!-- Sidebar --> 
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>