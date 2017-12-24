<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme Featured Box Section Template For Front Page.
 * Created by sketchthemes
*/
?>
<?php global $avis_shortname; ?>
<?php 
	$_featured_heading 		= get_post_meta( $post->ID,'_featured_heading',true );
	$_featured_desc 		= get_post_meta( $post->ID,'_featured_desc',true ); 
	$fraturedbox 			= get_post_meta( $post->ID,'_home_fetured_boxes',true );

if($fraturedbox == 'on'){ 
 ?>
<div id="featured-box" class="avis-section">

	<!-- container -->
	<div class="container">
		<div class="sections_inner_content fade_in_hide element_fade_in">
			<?php if (isset($_featured_heading) && $_featured_heading !='') { ?><h2 class="section_heading"><?php echo $_featured_heading; ?></h2><?php } ?>
			<?php if (isset($_featured_desc) && $_featured_desc !='') { ?><div class="section_description"><?php echo $_featured_desc; ?></div><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>

		<!-- row-fluid -->
		<ul class="mid-box-mid row-fluid">
				<?php dynamic_sidebar( 'Home Featured Sidebar' ); ?>	
			<div class="clearfix"></div>
		</ul>
		<!-- row-fluid -->
		
	</div>
	<!-- container -->
</div>
<?php }?>