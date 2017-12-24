<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme Portfolio Section Template For Front Page.
 * Created by sketchthemes
*/
?>
<?php global $avis_shortname; ?>
<?php 
	$_home_project_section 			 = get_post_meta( $post->ID,'_home_project_section',true );
	$_project_section_heading 		 = get_post_meta( $post->ID,'_project_section_heading',true ); 
	$_project_section_desc 			 = get_post_meta( $post->ID,'_project_section_desc',true );
	$_front_latest_project_items  	 = get_post_meta( $post->ID,'_front_latest_project_items',true );
if($_home_project_section == 'on') { 
?>

<div id="latest-project-section" class="avis-section">	
	<!-- container -->
	<div class="container">
		<div class="sections_inner_content fade_in_hide element_fade_in">
			<?php if (isset($_project_section_heading) && $_project_section_heading !='' ) { ?><h2 class="section_heading"><?php echo $_project_section_heading; ?></h2><?php } ?>
			<?php if (isset($_project_section_desc) && $_project_section_desc !='' ) { ?><div class="section_description"><?php echo $_project_section_desc; ?></div><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>
		<!-- row-fluid -->
		<div class="row-fluid">

			<!-- Content -->
			<div id="content" class="span12">
				<div class="post project-temp3" id="post-<?php the_ID(); ?>" >
					<!-- Project Wrap -->
						<div class="project_wrap clearfix">
							<?php if(isset($_front_latest_project_items) && $_front_latest_project_items =='') { 
								echo "<div class='dod-error-msg'>Sorry, you haven't selected any project category.</div>";
							}else{ 
								$default ='';
							?>
							<div id="wrap" class="clearfix">
								<?php  
								foreach ($_front_latest_project_items as $taxcatID) {
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
								<div id="container-isotop" class="portfolio group three-col">
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
</div>
<?php }?>
