<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * The template for displaying posts in the Gallery post format.
 * Created by sketchthemes
 */
?>
<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
		<div class="slider-attach">
			<?php 
				$gallleryIDS = '';
				$_avis_postType_gallery		  = get_post_meta($post->ID, "_avis_postType_gallery", true);
				$_avis_postType_slider_delay	 = get_post_meta($post->ID, "_avis_postType_slider_delay", true);
				$_avis_postType_slider_speed	 = get_post_meta($post->ID, "_avis_postType_slider_speed", true);
				$_avis_postType_slider_autoplay  = get_post_meta($post->ID, "_avis_postType_slider_autoplay", true);
				$_avis_postType_slider_pause	 = get_post_meta($post->ID, "_avis_postType_slider_pause", true);
				
				// Check and validate gallery parameters
				$_avis_postType_slider_delay	 = ($_avis_postType_slider_delay) ? $_avis_postType_slider_delay : "5000";
				$_avis_postType_slider_speed	 = ($_avis_postType_slider_speed) ? $_avis_postType_slider_speed : "600";	
				$_avis_postType_slider_autoplay  = ($_avis_postType_slider_autoplay === "on") ? "true" : "false";
				$_avis_postType_slider_pause	 = ($_avis_postType_slider_pause === "on") ? "true" : "false";
			?>

			<div class="image-gallery-slider post-slider-<?php the_ID();?>" id="post-slider-<?php the_ID(); ?>">
				<ul class="gallery-box slides avis-post-slider-<?php the_ID(); ?>">
					<?php $gallleryIDS = explode(',', $_avis_postType_gallery); ?>
					<?php foreach( $gallleryIDS as $attachmentID ): ?>
						<li> 
							<?php
								$attachment_size = 'avis_standard_img';
								$attachment_img = wp_get_attachment_image_src( $attachmentID, $attachment_size, false );
							?>
							<img src="<?php echo $attachment_img[0]; ?>" alt="<?php echo get_the_ID(); ?>" width="<?php echo $attachment_img[1]; ?>" height="<?php echo $attachment_img[2]; ?>" />
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="gallery-thumbnail-slider gallery-carousel-<?php the_ID();?>" id="gallery-carousel-<?php the_ID(); ?>">
				<ul class="gallery-thumbnail-box slides avis-post-slider-<?php the_ID(); ?>">
					<?php $gallleryIDS = explode(',', $_avis_postType_gallery); ?>
					<?php foreach( $gallleryIDS as $attachmentID ): ?>
						<li> 
							<?php
								$attachment_size = 'avis_gallery_thumbnail_img';
								$attachment_img = wp_get_attachment_image_src( $attachmentID, $attachment_size, false );
							?>
							<img src="<?php echo $attachment_img[0]; ?>" alt="<?php echo get_the_ID(); ?>" width="<?php echo $attachment_img[1]; ?>" height="<?php echo $attachment_img[2]; ?>" />
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			
			
			<script type="text/javascript">
				jQuery(window).load(function(){
					jQuery('#gallery-carousel-<?php the_ID(); ?>').flexslider({
						animation: "slide",
						controlNav: false,
						directionNav: false,
						animationLoop: true,
						slideshow: true,	
						itemWidth: 275,
						itemMargin: 5,
						asNavFor: '#post-slider-<?php the_ID(); ?>'
					 });

					jQuery('.post-slider-<?php the_ID(); ?>').flexslider({
						animation: "fade",
						namespace: "postformat-gallery",	
						easing: "swing",				
						direction: "vertical",
						slideshow: <?php echo $_avis_postType_slider_autoplay; ?>,
						slideshowSpeed:<?php echo $_avis_postType_slider_delay; ?>,		
						animationSpeed:<?php echo $_avis_postType_slider_speed; ?>,		 
						controlsContainer: "",
						controlNav: false,
						animationLoop: true,
						pauseOnHover: <?php echo $_avis_postType_slider_pause; ?>,
						prevText: "",
						nextText: "",
						sync: "#gallery-carousel-<?php the_ID(); ?>"
					});
				});
			</script>  

		</div><!-- slider-attach -->

		<div class="post_inner_wrap clearfix">
			<h1 class="post-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_title(); ?>
				</a>
			</h1>
			<div class="skepost-meta clearfix">				
			   <?php avis_postmeta(); ?>
			</div>
			<!-- skepost-meta -->
			<div class="skepost">
				<?php the_excerpt(); ?> 
				<div class="continue"><a href="<?php the_permalink(); ?>"><?php _e('Read More','avis');?></a></div>		  
			</div>
			<!-- skepost -->
		</div>
</div>
<!-- post -->