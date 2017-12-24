<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme CalltoAction Section Template For Front Page.
 * Created by sketchthemes
*/
?>
<?php
$_home_parallax_sec	   = get_post_meta( $post->ID,'_home_parallax_sec',true );
$_action_section_heading  = get_post_meta( $post->ID,'_action_section_heading',true );

if($_home_parallax_sec == 'on'){ 
?>
<div id="full-division-box" class="avis-section avis_animate_when_almost_visible avis_bottom-to-top">
	<div class="container full-content-box" >

		<div class="sections_inner_content">
			<?php if (isset($_action_section_heading) && $_action_section_heading !='') { ?><h2 class="section_heading"><?php echo $_action_section_heading; ?></h2><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>

		<div class="row-fluid">
			<div class="parallax_inner_html span12">
				<?php $_home_parallax_shortcode = get_post_meta( $post->ID,'_home_parallax_shortcode',true ); ?>
				<?php if(isset($_home_parallax_shortcode)) { echo do_shortcode($_home_parallax_shortcode);} ?>	
			</div>
		</div>
	</div>
</div>
<?php } ?>