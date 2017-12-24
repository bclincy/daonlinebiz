<?php
/**
 * Template Name: About page Template
 *
 * The include file used for the About Page.
 *
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
*/ 
get_header(); 
global $avis_shortname;
?>

<?php if(have_posts()) : ?>
<?php while(have_posts()) : the_post(); ?>

<!-- Page Content Section -->
<?php if($post->post_content != "")  { ?>
<div class="container post-wrap">
	<div class="about_page_content row-fluid">
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

<!-- Get Meta From About Template -->
<?php
	$_about_work_process_heading  = get_post_meta( $post->ID,'_about_work_process_heading',true );
	$_about_work_process_desc	 = get_post_meta( $post->ID,'_about_work_process_desc',true );
	$_about_work_process_html	 = get_post_meta( $post->ID,'_about_work_process_html',true );

	$_about_team_member_heading   = get_post_meta( $post->ID,'_about_team_member_heading',true );
	$_about_team_member_desc	  = get_post_meta( $post->ID,'_about_team_member_desc',true );
?>
<!-- Get Meta From About Template -->

<!-- About Team Section -->
<div id="work-process-box" class="avis-section">
	<div class="work-process container">
		<div class="sections_inner_content">
			<?php if (isset($_about_work_process_heading) && $_about_work_process_heading !='') { ?><h2 class="section_heading"><?php echo $_about_work_process_heading; ?></h2><?php } ?>
			<?php if (isset($_about_work_process_desc) && $_about_work_process_desc !='') { ?><div class="section_description"><?php echo $_about_work_process_desc; ?></div><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>

		<div class="work_process_content row-fluid">
			<?php if (isset($_about_work_process_html) && $_about_work_process_html !='') { ?><div class="work_process_html clearfix"><?php echo do_shortcode($_about_work_process_html); ?></div><?php } ?>
		</div>

	</div>
</div>

<!-- About Team Section -->
<div id="team-division-box" class="avis-section about-template">
	<div class="team-division container">
		<div class="sections_inner_content">
			<?php if (isset($_about_team_member_heading) && $_about_team_member_heading !='') { ?><h2 class="section_heading"><?php echo $_about_team_member_heading; ?></h2><?php } ?>
			<?php if (isset($_about_team_member_desc) && $_about_team_member_desc !='') { ?><div class="section_description"><?php echo $_about_team_member_desc; ?></div><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>
		
		<!-- row-fluid --> 
		<div class="team-box row-fluid">
			<?php 					
				$the_query = new WP_Query( 'post_type=team_member&posts_per_page=-1');
				if($the_query->have_posts()) : 	// Start if	
				while ( $the_query->have_posts() ) : $the_query->the_post(); 	// Start While loop
					$id   = get_the_ID();			
					$data = get_post_meta($id);			
					$avatar 	= !empty($data['_teammember_avatar'][0]) ? $data['_teammember_avatar'][0] : '' ;	
					$content 	= !empty($data['_teammember_content'][0]) ? $data['_teammember_content'][0] : '' ;		
					$name 		= !empty($data['_teammember_name'][0]) ? $data['_teammember_name'][0] : '' ;	
					$job 		= !empty($data['_teammember_job'][0]) ? $data['_teammember_job'][0] : '' ;	
					$fb_url 	= !empty($data['_teammember_fb'][0]) ? $data['_teammember_fb'][0] : '' ;		
					$fb_url	 =  esc_url($fb_url);			
					$tw_url 	= !empty($data['_teammember_tw'][0]) ? $data['_teammember_tw'][0] : '' ;	
					$tw_url	 =  esc_url($tw_url);		
					$gplus_url 	= !empty($data['_teammember_gplus'][0]) ? $data['_teammember_gplus'][0] : '' ;		
					$gplus_url	=  esc_url($gplus_url);		
					$lkdin_url = !empty($data['_teammember_lkdin'][0]) ? $data['_teammember_lkdin'][0] : '' ;
					$lkdin_url	=  esc_url($lkdin_url);
					$vk_url 	= !empty($data['_teammember_vk'][0]) ? $data['_teammember_vk'][0] : '' ;	
					$vk_url	 =  esc_url($vk_url);
			?>   
		  	<div  class="team-box-mid span6 fade_in_hide element_fade_in">		
				<div class="teammember clearfix">			
					<div class="team_overlay_content">
						<div class="team-name-deg">
							<?php if( $name) { ?>
								<div class="title"><?php echo $name; ?></div>
								<div class="seperator"><span></span></div>
							<?php } ?>
							<?php if( $job) { ?>
								<div class="team_prof"><?php echo $job; ?></div>
							<?php } ?>
						</div>		
						<ul class="teamsocial">				
							<?php if( $fb_url) { ?><li><a class="team-fb" href="<?php echo $fb_url; ?>"><i class="fa fa-facebook"></i></a></li><?php } ?>
							<?php if( $lkdin_url) { ?><li><a class="team-li" href="<?php echo $lkdin_url; ?>"><i class="fa fa-linkedin"></i></a></li><?php } ?>
							<?php if( $gplus_url) { ?><li><a class="team-gp" href="<?php echo $gplus_url; ?>"><i class="fa fa-google-plus"></i></a></li><?php } ?>
							<?php if( $tw_url) { ?><li><a class="team-tw" href="<?php echo $tw_url; ?>"><i class="fa fa-twitter"></i></a></li><?php } ?>
							<?php if( $vk_url) { ?><li><a class="team-vk" href="<?php echo $vk_url; ?>"><i class="fa fa-vk"></i></a></li><?php } ?>
						</ul>
					</div>
					<div class="team-avatar"><div class="rect-shape"></div><img alt="team" src="<?php echo $avatar; ?>" class="teammember_img" /></div>
				</div>	  
			</div>
			<?php 
				endwhile; // End while loop
				wp_reset_query();
				endif; // End if 
			?>
		</div> 
		<!-- row-fluid --> 
	</div>
	<!-- container --> 
</div>
<!-- team-division-box -->
<?php get_footer(); ?>