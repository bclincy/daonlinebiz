<?php
/**
 * Template name: Projects 3-col Template
 *
 * The include file used for the showing Portfolios.
 *
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
*/ 
get_header(); ?>
<?php if(have_posts()) : ?>
<?php while(have_posts()) : the_post(); ?>
<?php $_portfolio_inner_project_items  = get_post_meta( $post->ID,'_portfolio_inner_project_items',true ); ?>
<!-- Page Content Section -->
<?php if($post->post_content != "")  { ?>
<div class="container post-wrap">
	<div class="portfolio_three_col_content row-fluid">
		<div class="post" id="post-<?php the_ID(); ?>">
			<?php the_content(); ?>
			<?php wp_link_pages(__('<p><strong>Pages:</strong> ','avis'), '</p>', __('number','avis')); ?>
			<?php edit_post_link('Edit', '', ''); ?>	
		</div>
	</div>
</div>
<?php } ?>
<?php endwhile; ?>
<?php else :  ?>
<?php endif; ?>
<!-- Page Content Section -->
<!-- container -->
<div class="container">
	<!-- row-fluid -->
	<div class="row-fluid">
		<!-- Content -->
			<div id="content" class="span12">
				<div class="post project-temp3" id="post-<?php the_ID(); ?>" >
					<!-- Project Wrap -->
						<div class="project_wrap clearfix">
						<?php if(isset($_portfolio_inner_project_items) && $_portfolio_inner_project_items =='') { 
							echo "<div class='dod-error-msg'>Sorry, you haven't selected any project category.</div>";
						}else{ 
							$default ='';
						?>
						<div id="wrap" class="clearfix">
							<?php  
								$porttaxarr;
								foreach ($_portfolio_inner_project_items as $taxcatID) {
									$porttaxarr[] = $taxcatID;
								}
								 $args=array(
								 	'post_type' => 'portfolio_post',
									'posts_per_page'=> -1,
								 	'tax_query' => array(
											array(
												'taxonomy' => 'portfolio_category',
												'field' => 'id', 
												'terms' => $porttaxarr
											),
										),
								 	);
									$port_query = new WP_Query( $args ); 
								?>
							<div id="container-isotop" class="container-inner-isotop portfolio group three-col">
								<?php if($port_query->have_posts()) : ?>
									<?php 
									// The Loop
									while ( $port_query->have_posts() ) : $port_query->the_post();
									get_template_part( 'portfolio-formats/content-portfolio', get_post_format() );
									endwhile; 
									wp_reset_postdata();
									// Reset Query
								 	else : ?>
								 <p><?php _e( 'Sorry, no posts matched your criteria.', 'avis' ); ?></p>
								 <?php endif; ?>
							</div>
							<div class="clearfix"></div>
						</div>
						<?php } ?>
					</div>
					<!-- Project Wrap -->
				</div>	
			</div>
			<!-- Content -->
		<div class="clearfix"></div>
	</div>
	<!-- row-fluid -->		
</div>
<!-- container -->
<?php get_footer(); ?>