<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme Service Template For Front Page.
 * Created by sketchthemes
*/
?>
<?php

//------ AVIS SERVICES SECTION ------
//-----------------------------------

global $avis_shortname,$post; 

$_home_services_section  = get_post_meta( $post->ID,'_home_services_section',true );
$_home_services_heading  = get_post_meta( $post->ID,'_home_services_heading',true );
$_home_services_desc	 = get_post_meta( $post->ID,'_home_services_desc',true );
$_home_services_html	 = get_post_meta( $post->ID,'_home_services_html',true );

//--- Check if section is enable or not -----
if($_home_services_section == 'on'){ ?>

<!-- services-division-box -->
<div id="services-division-box" class="avis-section"> 
	<!-- container -->
	<div class="services-division container">	
		<div class="sections_inner_content fade_in_hide element_fade_in">
			<?php if (isset($_home_services_heading) && $_home_services_heading !='') { ?><h2 class="section_heading"><?php echo $_home_services_heading; ?></h2><?php } ?>
			<?php if (isset($_home_services_desc) && $_home_services_desc !='') { ?><div class="section_description"><?php echo $_home_services_desc; ?></div><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>
		
		<!-- row-fluid -->
		<div class="our-skill-box row-fluid avis_animate_when_almost_visible avis_right-to-left">	 		
				<?php if(isset($_home_services_html) && $_home_services_html !='') { ?><div class="span12"><div class="services_content clearfix"><?php echo do_shortcode($_home_services_html); ?></div></div><?php } ?>
			<div class="clear"></div>   
		</div>
		<!-- row-fluid --> 
	</div>
	<!-- container -->
</div>
<!-- services-division-box -->
<?php } ?> 	