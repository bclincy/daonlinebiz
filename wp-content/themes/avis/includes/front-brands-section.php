<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme Brand Section Template For Front Page.
 * Created by sketchthemes
*/
?>
<!-- FULL-CLIENT-BOX -->
<?php
global $avis_shortname;
$_home_brand_sec 	= get_post_meta( $post->ID,'_home_brand_sec',true );
$_home_brands_logos 	= get_post_meta( $post->ID,'_home_brands_logos',true ); 
$_home_brand_title 		= get_post_meta( $post->ID,'_home_brand_title',true ); 
$_home_brand_desc  		= get_post_meta( $post->ID,'_home_brand_desc',true );

if($_home_brand_sec == 'on'){ 
	if($_home_brands_logos != NULL) { ?>

<div id="full-client-box" class="avis-section">
	<div class="container">
		<div class="sections_inner_content fade_in_hide element_fade_in">
			<?php if(isset($_home_brand_title) && $_home_brand_title !="") { ?><h2 class="section_heading"><?php echo $_home_brand_title; ?></h2><?php } ?>
			<?php if (isset($_home_brand_desc) && $_home_brand_desc !="") { ?><div class="section_description"><?php echo $_home_brand_desc; ?></div><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>
		<div class="row-fluid">
			<div id="our-brands">
					<?php if(avis_get_option($avis_shortname."_clientsec_title")){?><h3 class="inline-border"><?php echo avis_get_option($avis_shortname."_clientsec_title"); ?></h3><span class="border_left"></span><?php } ?>
					<ul id="brand-logos" class="owl-carousel clients-items">
						<?php 
							foreach($_home_brands_logos as $key => $_home_brands_logo)
							{
									if($_home_brands_logo['_home_clogo_img']){ ?><li class="item span2"><a href="<?php if($_home_brands_logo['_home_clogo_url']){ echo esc_url($_home_brands_logo['_home_clogo_url']); } ?>" title="<?php if($_home_brands_logo['title']){ echo $_home_brands_logo['title']; } ?>"><img alt="client-logo" src="<?php if($_home_brands_logo['_home_clogo_img']){ echo $_home_brands_logo['_home_clogo_img']; } ?>"></a></li><?php } 			   
							}
						?>
					</ul>
			</div><!-- /our-brands -->
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#brand-logos").owlCarousel({
			items : 4,
			lazyLoad : true,
			navigation : false,
			autoPlay : true,
			pagination : false
			
		});
	});
</script>
<?php } } ?>


