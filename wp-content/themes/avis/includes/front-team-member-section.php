<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme Team Member Template For Front Page.
 * Created by sketchthemes
*/
?>
<?php

//-- AVIS_TEAM_MEMBERS -----
//-----------------------------------

global $avis_shortname; 

$_home_ourteam_section  = get_post_meta( $post->ID,'_home_ourteam_section',true );
$_our_team_member_heading  = get_post_meta( $post->ID,'_our_team_member_heading',true );
$_our_team_member_desc  = get_post_meta( $post->ID,'_our_team_member_desc',true );
$_our_team_member_option  = get_post_meta( $post->ID,'_our_team_member_option',true );


if($_our_team_member_option === 'specific') {
	$teammember_sel1 = get_post_meta( $post->ID,'_avis_teammember_sel1',true );
	$teammember_sel2 = get_post_meta( $post->ID,'_avis_teammember_sel2',true );
	$teammember_sel3 = get_post_meta( $post->ID,'_avis_teammember_sel3',true );
	$teammember_sel4 = get_post_meta( $post->ID,'_avis_teammember_sel4',true );
	$team_members =  array($teammember_sel1, $teammember_sel2, $teammember_sel3,$teammember_sel4);
}

if($_home_ourteam_section == 'on'){ ?>
<div id="team-division-box" class="avis-section">  
	<div class="team-division container">	
		<div class="sections_inner_content fade_in_hide element_fade_in">
			<?php if (isset($_our_team_member_heading) && $_our_team_member_heading !='') { ?><h2 class="section_heading"><?php echo $_our_team_member_heading; ?></h2><?php } ?>
			<?php if (isset($_our_team_member_desc) && $_our_team_member_desc !='') { ?><div class="section_description"><?php echo $_our_team_member_desc; ?></div><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>
		
		<div class="team-box row-fluid">
			<?php 	
				if($_our_team_member_option === 'specific') {
					$the_query = new WP_Query( array( 'post_type' => 'team_member', 'posts_per_page' => '4', 'orderby' => 'post__in', 'post__in' => $team_members ) );
				}else{
					$the_query = new WP_Query( 'post_type=team_member&posts_per_page=-1');	
				}	

				if($the_query->have_posts()) : 		
				while ( $the_query->have_posts() ) : $the_query->the_post();		
					$id   = get_the_ID();			
					$data = get_post_meta($id);			
					$avatar 	= !empty($data['_teammember_avatar'][0]) ? $data['_teammember_avatar'][0] : '' ;	
					$content 	= !empty($data['_teammember_content'][0]) ? $data['_teammember_content'][0] : '' ;		
					$name 		= !empty($data['_teammember_name'][0]) ? $data['_teammember_name'][0] : '' ;	
					$job 		= !empty($data['_teammember_job'][0]) ? $data['_teammember_job'][0] : '' ;	
					$fb_url 	= !empty($data['_teammember_fb'][0]) ? $data['_teammember_fb'][0] : '' ;		
					$fb_url	 =  esc_url($fb_url);
					$lkdin_url = !empty($data['_teammember_lkdin'][0]) ? $data['_teammember_lkdin'][0] : '' ;
					$lkdin_url	=  esc_url($lkdin_url);		
					$gplus_url 	= !empty($data['_teammember_gplus'][0]) ? $data['_teammember_gplus'][0] : '' ;		
					$gplus_url	=  esc_url($gplus_url);
					$tw_url 	= !empty($data['_teammember_tw'][0]) ? $data['_teammember_tw'][0] : '' ;	
					$tw_url	 =  esc_url($tw_url);
					$vk_url 	= !empty($data['_teammember_vk'][0]) ? $data['_teammember_vk'][0] : '' ;	
					$vk_url	 =  esc_url($vk_url);
			?>   

			<!--team-container-->	
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
				endwhile;
				wp_reset_query();
				endif;
			?>	   
			<div class="clear"></div>   
		</div> 
	</div>
</div>
<?php } ?> 	