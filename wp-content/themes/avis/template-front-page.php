<?php
/**
 * Template Name: Home : Front Page Template
 *
 * This is the front page template. Here we shows the many different-2 section/features of the theme.
 *
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
*/
get_header(); 
?>
	<?php
	global $avis_shortname, $wp_query;
	$postid = $wp_query->post->ID;
	$_avis_frontpage_sections_order = get_post_meta($postid, '_avis_frontpage_sections_order', true);
	
	
	if(isset($_avis_frontpage_sections_order) && $_avis_frontpage_sections_order !=""){
	
		foreach($_avis_frontpage_sections_order as $fsection){ 


		
			if($fsection === "Featured Box Section"){
			
				get_template_part("includes/front-featured-boxes-section"); // FEATURED BOXES SECTION
			
			}elseif($fsection === "About Section"){
			
				get_template_part("includes/front-about-section"); // ABOUT SECTION
			
			}elseif($fsection === "Latest Project Section"){
			
				get_template_part("includes/front-portfolio-section"); // LATEST PROJECT SECTION
			
			}elseif($fsection === "Testimonial Section"){
			
				get_template_part("includes/front-testimonial-section"); // LATEST TESTIMONIAL SECTION
			
			}elseif($fsection === "Call To Action Section"){
			
				get_template_part("includes/front-calltoaction-section"); // STATISTICS CALL TO ACTION SECTION
			
			}elseif($fsection === "Services Section"){
			
				get_template_part("includes/front-services-section"); 	// OUR SERVICES SECTION
			
			}elseif($fsection === "Team Member Section"){
			
				get_template_part("includes/front-team-member-section");  // TEAM MEMBER SECTION
			
			}elseif($fsection === "Twitter Section"){
			
				get_template_part("includes/section-twitter-panel"); // TWITTER SECTION
			
			}elseif($fsection === "Our Brands Section"){
			
				get_template_part("includes/front-brands-section");	 // OUR BRANDS SECTION
				
			}elseif($fsection === "Page Content") {
				$post_object = get_post( $postid );
				if($post_object->post_content) {
				?>
					<!-- PAGE EDITER CONTENT -->
					<div id="front-content-box" class="avis-section">
						<div class="container">
							<div class="row-fluid"> 
								<?php 
									echo do_shortcode($post_object->post_content); 
								?>
							</div>
							<div class="border-content-box bottom-space"></div>
						</div>
					</div>
					<!-- \\PAGE EDITER CONTENT -->
				<?php
				}
			}
		}
	}
?>
<?php get_footer(); ?>