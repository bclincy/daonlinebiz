<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * The template for displaying portfolio in the Gallery post format.
 * Created by sketchthemes
*/
?>
<!-- Project Box -->
<div class="item project_box span4 avis_animate_when_almost_visible avis_bottom-to-top">
	<!-- gallery -->
	<div class="project-item" id="post-<?php the_ID(); ?>">

		<?php 
			$portgallleryIDS = '';
			$_avis_postType_gallery_portfolio		  = get_post_meta($post->ID, "_avis_postType_gallery_portfolio", true);
			$_avis_postType_slider_delay_portfolio	 = get_post_meta($post->ID, "_avis_postType_slider_delay_portfolio_portfolio", true);
			$_avis_postType_slider_speed_portfolio	 = get_post_meta($post->ID, "_avis_postType_slider_speed_portfolio_portfolio", true);
			$_avis_postType_slider_autoplay_portfolio  = get_post_meta($post->ID, "_avis_postType_slider_autoplay_portfolio_portfolio", true);
			$_avis_postType_slider_pause_portfolio	 = get_post_meta($post->ID, "_avis_postType_slider_pause_portfolio_portfolio", true);
			
			// Check and validate gallery parameters
			$_avis_postType_slider_delay_portfolio	 = ($_avis_postType_slider_delay_portfolio) ? $_avis_postType_slider_delay_portfolio : "5000";
			$_avis_postType_slider_speed_portfolio	 = ($_avis_postType_slider_speed_portfolio) ? $_avis_postType_slider_speed_portfolio : "600";	
			$_avis_postType_slider_autoplay_portfolio  = ($_avis_postType_slider_autoplay_portfolio === "on") ? "true" : "false";
			$_avis_postType_slider_pause_portfolio	 = ($_avis_postType_slider_pause_portfolio === "on") ? "true" : "false";
		?>

			<div class="portfolio-slider-<?php the_ID();?>" id="portfolio-slider-<?php the_ID(); ?>">
				<ul class="gallery-box slides avis-post-slider-<?php the_ID(); ?>">
					<?php $portgallleryIDS = explode(',', $_avis_postType_gallery_portfolio); 
						  $count = count( $portgallleryIDS );	
					 ?>
					<?php foreach( $portgallleryIDS as $portattachmentID ): ?>
						<li class="port-gal-slide"> 
							<?php
								$port_attachment_size = 'portfolio-thumb-image';
								$port_attachment_img = wp_get_attachment_image_src( $portattachmentID, $port_attachment_size, true );
								$port_attachment_img_large = wp_get_attachment_image_src( $portattachmentID, '', false );
							?>
							<a href="<?php echo $port_attachment_img[0]; ?>" data-rel="<?php if($count > 1) { ?>prettyPhoto[<?php echo $post->ID;?>]<?php } ?>" title="View Large">
								<img src="<?php echo $port_attachment_img[0]; ?>" alt="<?php echo get_the_ID(); ?>" />
							</a>
						</li>
					<?php $count--;
					endforeach; ?>
				</ul>
			</div>

			<div class="portfolio_overlay">
				<div class="port_overlay_content">
					<div class="title"><?php the_title();?></div>
					<div class="port_single_link">
						<a class="single-port-link" href="<?php the_permalink();?>" title="<?php the_title();?>"><i class="fa fa-link"></i></a>
						<a href="<?php echo $port_attachment_img_large[0]; ?>" data-rel="prettyPhoto[<?php echo $post->ID;?>]" title="View Large"><i class="fa fa-search"></i></a>
					</div>
				</div>
			</div>		
			
			<script type="text/javascript">
				jQuery(window).load(function(){
					jQuery('.portfolio-slider-<?php the_ID(); ?>').flexslider({
						animation: "fade",
						namespace: "postformat-gallery",	
						easing: "swing",				
						direction: "vertical",
						slideshow: '<?php echo $_avis_postType_slider_autoplay_portfolio; ?>',
						slideshowSpeed:'<?php echo $_avis_postType_slider_delay_portfolio; ?>',		
						animationSpeed:'<?php echo $_avis_postType_slider_speed_portfolio; ?>',		 
						controlsContainer: "",
						controlNav: false,
						animationLoop: false,
						slideshow: false,
						pauseOnHover: <?php echo $_avis_postType_slider_pause_portfolio; ?>,
						prevText: "",
						nextText: ""
					});
				});
			</script>
			<!-- gallery -->
		</div>
</div>
<!-- Project Box -->