<?php 
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * The Template for displaying all single posts.
*/

get_header(); ?>

<?php global $avis_shortname; ?>
<div class="main-wrapper-item">
<?php if(have_posts()) : ?>
<?php while(have_posts()) : the_post(); ?>	
<div class="container post-wrap">
	<div class="row-fluid">
		<div id="container" class="span9">
			<div id="content">  
					<div class="post" id="post-<?php the_ID(); ?>">
					  <div class="single_post_wrap">
					  	<div class="quote_wrapper">
					  	<?php $format = get_post_format(); ?>
							<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
								<div class="featured-image-shadow-box <?php if($format == "quote") { ?>quote_featured_img <?php }else { ?>standard_featured_img <?php } ?>">
									<?php the_post_thumbnail('avis_standard_img'); ?>
								</div>
							<?php } ?>

							<?php if($format == "quote") { ?>
								<div class="quote_post">
									<?php
										//quote datas
										$post_id =  get_the_ID();
										$quote = get_post_meta($post->ID, "_avis_postType_quote", true);
										$quote_author = get_post_meta($post->ID, "_avis_postType_quote_author", true);
										$quote_author_url = get_post_meta($post->ID, "_avis_postType_quote_author_url", true);
									?>
									<blockquote class="avis-quote clearfix">
										<?php echo $quote ;?>
										<span class="quoteauthor clearfix"><a href="<?php if(isset($quote_author_url)){echo $quote_author_url;} ?>" title=" author" target="_blank"><?php _e('- ','avis');?><?php echo $quote_author ;?></a><i class="fa fa-quote-left"></i></span>
									</blockquote>
								</div>
							<?php } ?>
						</div>
						<?php if($format == "video") { ?>
						<div class="post-image clearfix">
							<div class="video-container">
								<?php $post_id =  get_the_ID();
									if (get_post_meta($post->ID, '_avis_postType_video', true)){ 
										$youtube_src1 =	get_post_meta($post->ID, '_avis_postType_video', true);
										
										 if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $youtube_src1)) {
											preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i',$youtube_src1,$output);
											$avis_yvideo_id = $output[4][0];
										} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $youtube_src1)) {
											preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i',$youtube_src1,$output);
											$avis_yvideo_id = $output[4][0];
										} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/',$youtube_src1)) {
											preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i',$youtube_src1,$output);
											$avis_yvideo_id = $output[4][0];
										} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $youtube_src1)) {
											preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i',$youtube_src1,$output);
											$avis_yvideo_id = $output[4][0];
										} else if(preg_match('/https:\/\/(www\.)*youtube\.com\/.*/',$youtube_src1)){
											preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i',$youtube_src1,$output);
											$avis_yvideo_id = $output[4][0];
										}
										
										if(isset($avis_yvideo_id)){ ?>
											<div class="flex-video widescreen vimeo">
												<iframe width="770" height="442" src="https://www.youtube.com/embed/<?php echo $avis_yvideo_id; ?>?wmode=opaque" class="youtube-video" allowfullscreen></iframe>
											</div>
										<?php } 
									}

									$avis_vvideo_id = parse_vimeo($youtube_src1);
									if($avis_vvideo_id) {?>
										<div class="flex-video widescreen vimeo">	 
											<iframe src='//player.vimeo.com/video/<?php echo $avis_vvideo_id; ?>?portrait=0&amp;title=0&amp;byline=0&amp;badge=0' width='770' height='442' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
										</div>
										<?php 
									} ?>
				
							</div>
						</div>
						<?php } ?>

						<?php if($format == "gallery") { ?>

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
						<?php } ?>

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
								<?php the_content(); ?>
							</div>
							<!-- skepost -->
						</div>
					  </div><!-- single-post-wrap -->

						<div class="navigation"> 
							<?php previous_post_link( __('<span class="nav-previous"><i class="fa fa-angle-left"></i><i class="fa fa-angle-left"></i> %link</span>','avis')); ?>
							<?php next_post_link( __('<span class="nav-next">%link <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></span>','avis')); ?> 
						</div>

						<div class="clearfix"></div>
						<div class="comments-template">
							<?php comments_template( '', true ); ?>
						</div>
					</div>
				<!-- post -->
				<?php endwhile; ?>
				<?php else :  ?>

				<div class="post">
					<h2><?php _e('Not Found','avis'); ?></h2>
				</div>
				<?php endif; ?>
			</div><!-- content -->
		</div><!-- container --> 

		<!-- Sidebar -->
		<div id="sidebar" class="span3">
			<?php get_sidebar(); ?>
		</div>
		<!-- Sidebar --> 

	</div>
 </div>
</div>
<?php get_footer(); ?>