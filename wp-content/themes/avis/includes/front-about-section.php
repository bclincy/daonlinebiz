<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme About Section Template For Front Page.
 * Created by sketchthemes
*/
?>
<?php global $avis_shortname; ?>
<?php 
	$_home_about_section 	 = get_post_meta( $post->ID,'_home_about_section',true );
	$_about_section_heading  = get_post_meta( $post->ID,'_about_section_heading',true );
	$_about_section_desc 	 = get_post_meta( $post->ID,'_about_section_desc',true ); 
	$_about_section_html 	 = get_post_meta( $post->ID,'_about_section_html',true ); 

if($_home_about_section == 'on'){ 
 ?>
<div id="about-section-box" class="avis-section">
	<div class="container">
		<div class="sections_inner_content fade_in_hide element_fade_in">
			<?php if (isset($_about_section_heading) && $_about_section_heading !='') { ?><h2 class="section_heading"><?php echo $_about_section_heading; ?></h2><?php } ?>
			<?php if (isset($_about_section_desc) && $_about_section_desc !='') { ?><div class="section_description"><?php echo $_about_section_desc; ?></div><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>
		<div class="about_section_content row-fluid avis_animate_when_almost_visible avis_left-to-right">
			<?php if (isset($_about_section_html) && $_about_section_html !='') { ?><div class="about_section_html clearfix"><?php echo do_shortcode($_about_section_html); ?></div><?php } ?>
		</div>
	</div>
</div>
<?php }?>