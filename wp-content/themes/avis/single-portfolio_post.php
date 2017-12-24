<?php 
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * The Template for displaying all single projects.
*/

get_header(); 
	global $avis_shortname,$post; 
	$_portfolio_detail_text  = get_post_meta( $post->ID,'_portfolio_detail_text',true );
?>
<div class="main-wrapper-item">
<?php if(have_posts()) : ?>
<?php while(have_posts()) : the_post(); ?>
<?php 
	  $single_portfolioimg  = get_post_meta( $post->ID, '_single_portfolio_img',true);
	  $single_portimg	   = avis_get_attachment_id_from_url( $single_portfolioimg );
	  $singleimagearray	 = wp_get_attachment_image_src( $single_portimg, 'portfolio-single-image' );
?>
<div class="container post-wrap">
	<div class="row-fluid">
			<div id="content">  
				<div class="post" id="post-<?php the_ID(); ?>">					
					<div class="featured-image-shadow-box span9">
						<?php $format = get_post_format(); ?>

						<?php if($format == "video") { ?>
						<!-- \\ video-container -->
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
										<div class="port-flex-video widescreen vimeo">
											<iframe width="870" height="500" src="https://www.youtube.com/embed/<?php echo $avis_yvideo_id; ?>?wmode=opaque" class="youtube-video" allowfullscreen></iframe>
										</div>
									<?php } 
								}

									$avis_vvideo_id = parse_vimeo($youtube_src1);
									if($avis_vvideo_id) {?>
										<div class="port-flex-video widescreen vimeo">	 
											<iframe src='//player.vimeo.com/video/<?php echo $avis_vvideo_id; ?>?portrait=0&amp;title=0&amp;byline=0&amp;badge=0' width='870' height='500' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
										</div>
										<?php 
									} ?>
							</div>
							<!-- video-container // -->

							<?php }elseif($format == "gallery") { ?>
								<!-- gallery -->
								<?php 
									$portgallleryIDS = '';
									$_avis_postType_gallery_portfolio		  = get_post_meta($post->ID, "_avis_postType_gallery_portfolio", true);
									$_avis_postType_slider_delay_portfolio	 = get_post_meta($post->ID, "_avis_postType_slider_delay_portfolio", true);
									$_avis_postType_slider_speed_portfolio	 = get_post_meta($post->ID, "_avis_postType_slider_speed_portfolio", true);
									$_avis_postType_slider_autoplay_portfolio  = get_post_meta($post->ID, "_avis_postType_slider_autoplay_portfolio", true);
									$_avis_postType_slider_pause_portfolio	 = get_post_meta($post->ID, "_avis_postType_slider_pause_portfolio", true);
									
									// Check and validate gallery parameters
									$_avis_postType_slider_delay_portfolio	 = ($_avis_postType_slider_delay_portfolio) ? $_avis_postType_slider_delay_portfolio : "5000";
									$_avis_postType_slider_speed_portfolio	 = ($_avis_postType_slider_speed_portfolio) ? $_avis_postType_slider_speed_portfolio : "600";	
									$_avis_postType_slider_autoplay_portfolio  = ($_avis_postType_slider_autoplay_portfolio === "on") ? "true" : "false";
									$_avis_postType_slider_pause_portfolio	 = ($_avis_postType_slider_pause_portfolio === "on") ? "true" : "false";
								?>


									<div class="portfolio-flexslider portfolio-slider-<?php the_ID();?>" id="portfolio-slider-<?php the_ID(); ?>">
										<ul class="gallery-box slides avis-post-slider-<?php the_ID(); ?>">
											<?php $portgallleryIDS = explode(',', $_avis_postType_gallery_portfolio); ?>
											<?php foreach( $portgallleryIDS as $portattachmentID ): ?>
												<li class="port-gal-slide"> 
													<?php
														$port_attachment_size = 'portfolio-single-image';
														$port_attachment_img = wp_get_attachment_image_src( $portattachmentID, $port_attachment_size, true );
													?>
													<img src="<?php echo $port_attachment_img[0]; ?>" alt="<?php echo get_the_ID(); ?>" />
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
									
									<script type="text/javascript">
										jQuery(window).load(function(){
											jQuery('.portfolio-slider-<?php the_ID(); ?>').flexslider({
												animation: "fade",
												namespace: "postformat-gallery",	
												easing: "swing",				
												direction: "vertical",
												slideshow: <?php echo $_avis_postType_slider_autoplay_portfolio; ?>,
												slideshowSpeed:<?php echo $_avis_postType_slider_delay_portfolio; ?>,		
												animationSpeed:<?php echo $_avis_postType_slider_speed_portfolio; ?>,		 
												controlsContainer: "",
												controlNav: false,
												animationLoop: true,
												pauseOnHover: <?php echo $_avis_postType_slider_pause_portfolio; ?>,
												prevText: "",
												nextText: ""
											});
										});
									</script>
									<!-- gallery -->
							<?php } else{ ?>
								<img class="skin-border" src="<?php echo $singleimagearray[0]; ?>" alt="<?php _e('Single Blog Image', 'avis'); ?>" />
							<?php } ?>
					</div>

					<div class="portfolio_inner_content span3">
						<div class="skepost-meta clearfix">
							<?php if ($_portfolio_detail_text != '') { ?><h3><?php echo $_portfolio_detail_text; ?></h3><?php } else { ?> <h3><?php _e('Project Details','avis');?></h3> <?php } ?>
							<ul class="protfolio_details">
								<li class="date"><?php _e('<i class="fa fa-calendar"></i> ','avis');?><span><?php the_time('F j, Y') ?></span></li>
								<li class="author-name"><?php _e('<i class="fa fa-user"></i> ','avis');?><span><?php the_author(); ?></span></li>
								<li class="comments"><?php _e('<i class="fa fa-sitemap"></i> ','avis');?>
									<span>
										<?php 
											$terms= get_the_terms(get_the_ID(),'portfolio_category');		
											$port_cats = "";
											foreach($terms as $single_term) {
												$term_link = get_term_link($single_term, 'portfolio_category' );
												
												// If there was an error, continue to the next term.
												if ( is_wp_error( $term_link ) ) {
													continue;
												}
												if($single_term -> parent == 0) { 
													$state = $single_term -> name; 
													$port_cats .= ",".$state;
												}
											}
											$port_cats = substr($port_cats, 1);
											echo $port_cats
										?>
									</span>
								</li>
							</ul>
						</div>
						<!-- skepost-meta -->
						<div class="skepost">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'avis' ) ); ?>
							<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages :','avis').'</strong>','after' => '</p>', __('number','avis'),));	?>
						</div>
						<!-- skepost -->
					</div>					
					<div class="clearfix"></div>
				</div>
				<!-- post -->
				<?php endwhile; ?>
				<?php else :  ?>

				<div class="post">
					<h2><?php _e('Not Found','avis'); ?></h2>
				</div>
				<?php endif; ?>
			</div><!-- content --> 

			<!-- Related Projects -->
			<div class="related-wrap">

				<div class="sections_inner_content">
					<h2 class="section_heading"><?php _e('RELATED PROJECTS', 'avis')?></h2>
					<p class="front-title-seperator"><span></span></p>
				</div>

				<div class="related-portfolio clearfix">
					<?php 		 
						// get the custom post type's taxonomy terms						 
						// arguments
						$args = array(
						'post_type' => 'portfolio_post',
						'post_status' => 'publish',
						'posts_per_page' => 4, // you may edit this number
						'orderby' => 'rand',
						'post__not_in' => array ($post->ID),
						);
						$related_items = new WP_Query( $args );
						// loop over query
						if ($related_items->have_posts()) :
						echo '';
						while ( $related_items->have_posts() ) : $related_items->the_post();
						?>
						<div class="item project_box span3">
							<div class="project-item" id="post-<?php the_ID(); ?>">
							   <?php $format = get_post_format();
							   		if ( false === $format ) {
										$format = 'standard';
									}
							   ?>
							   <?php if($format == "video") { ?>
								<!-- \\ video-container -->
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
												<div class="port-flex-video widescreen vimeo">
													<iframe width="870" height="200" src="https://www.youtube.com/embed/<?php echo $avis_yvideo_id; ?>?wmode=opaque" class="youtube-video" allowfullscreen></iframe>
												</div>
											<?php }
										}

											$avis_vvideo_id = parse_vimeo($youtube_src1);
											if($avis_vvideo_id) {?>
												<div class="port-flex-video widescreen vimeo">	 
													<iframe src='//player.vimeo.com/video/<?php echo $avis_vvideo_id; ?>?portrait=0&amp;title=0&amp;byline=0&amp;badge=0' width='870' height='200' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
												</div>
												<?php 
											} ?>

									</div>
									<!-- video-container // -->

									<div class="portfolio_overlay">
										<div class="port_overlay_content">
											<div class="title"><?php the_title();?></div>
											<div class="port_single_link">
												<a class="single-port-link" href="<?php the_permalink();?>" title="<?php the_title();?>"><i class="fa fa-link"></i></a>
												<a href="<?php echo $youtube_src1; ?>" data-rel="prettyPhoto" title="View Large"><i class="fa fa-search"></i></a>
											</div>
										</div>
									</div>

									<?php }elseif($format == "gallery") { ?>
									<!-- gallery -->
									<?php 
										$portgallleryIDS = '';
										$_avis_postType_gallery_portfolio		  = get_post_meta($post->ID, "_avis_postType_gallery_portfolio", true);
										$_avis_postType_slider_delay_portfolio	 = get_post_meta($post->ID, "_avis_postType_slider_delay_portfolio", true);
										$_avis_postType_slider_speed_portfolio	 = get_post_meta($post->ID, "_avis_postType_slider_speed_portfolio", true);
										$_avis_postType_slider_autoplay_portfolio  = get_post_meta($post->ID, "_avis_postType_slider_autoplay_portfolio", true);
										$_avis_postType_slider_pause_portfolio	 = get_post_meta($post->ID, "_avis_postType_slider_pause_portfolio", true);
										
										// Check and validate gallery parameters
										$_avis_postType_slider_delay_portfolio	 = ($_avis_postType_slider_delay_portfolio) ? $_avis_postType_slider_delay_portfolio : "5000";
										$_avis_postType_slider_speed_portfolio	 = ($_avis_postType_slider_speed_portfolio) ? $_avis_postType_slider_speed_portfolio : "600";	
										$_avis_postType_slider_autoplay_portfolio  = ($_avis_postType_slider_autoplay_portfolio === "on") ? "true" : "false";
										$_avis_postType_slider_pause_portfolio	 = ($_avis_postType_slider_pause_portfolio === "on") ? "true" : "false";
									?>

										<div class="portfolio-flexslider portfolio-slider-<?php the_ID();?>" id="portfolio-slider-<?php the_ID(); ?>">
											<ul class="gallery-box slides avis-post-slider-<?php the_ID(); ?>">
												<?php $portgallleryIDS = explode(',', $_avis_postType_gallery_portfolio);
													  $count = count( $portgallleryIDS );
												?>
												<?php foreach( $portgallleryIDS as $portattachmentID ): ?>
													<li class="port-gal-slide"> 
														<?php
															$port_attachment_size = 'portfolio-related-image';
															$port_attachment_img = wp_get_attachment_image_src( $portattachmentID, $port_attachment_size, true );
															$port_attachment_img_large = wp_get_attachment_image_src( $portattachmentID, '', false );
														?>
														<a href="<?php echo $port_attachment_img[0]; ?>" data-rel="<?php if($count > 1) { ?>prettyPhoto[<?php echo $post->ID;?>]<?php } ?>" title="View Large">
															<img src="<?php echo $port_attachment_img[0]; ?>" alt="<?php echo get_the_ID(); ?>" />
														</a>
													</li>
												<?php $count--; endforeach; ?>
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
													slideshow: <?php echo $_avis_postType_slider_autoplay_portfolio; ?>,
													slideshowSpeed:<?php echo $_avis_postType_slider_delay_portfolio; ?>,		
													animationSpeed:<?php echo $_avis_postType_slider_speed_portfolio; ?>,		 
													controlsContainer: "",
													controlNav: false,
													animationLoop: true,
													pauseOnHover: <?php echo $_avis_postType_slider_pause_portfolio; ?>,
													prevText: "",
													nextText: ""
												});
											});
										</script>
										<!-- gallery -->
								<?php } elseif ( $format == "standard" ) {
									  $id		 = get_the_ID();
									  $data	   = get_post_meta($id);
									  $_single_portfolio_img   = !empty($data['_single_portfolio_img'][0]) ? $data['_single_portfolio_img'][0] : '' ;
									  $relsingle_portfolioimg  = get_post_meta( $post->ID, '_single_portfolio_img',true);
									  $relsingle_portimg	   = avis_get_attachment_id_from_url( $relsingle_portfolioimg );
									  $relimagearray		   = wp_get_attachment_image_src( $relsingle_portimg, 'portfolio-related-image' );

								 ?>
								   <div class="feature_image" style="position: relative; line-height: 0;">
								   		<img class="skin-border" src="<?php echo $relimagearray[0]; ?>" alt="<?php _e('Related Image', 'avis'); ?>" />
								   </div>

								   <div class="portfolio_overlay">
									   <div class="port_overlay_content">
											<div class="title"><?php the_title();?></div>
											<div class="port_single_link">
												<a class="single-port-link" href="<?php the_permalink();?>" title="<?php the_title();?>"><i class="fa fa-link"></i></a>
												<a href="<?php echo $_single_portfolio_img; ?>" data-rel="prettyPhoto[<?php echo $post->ID;?>]" title="View Large"><i class="fa fa-search"></i></a>
											</div>
										</div>
									</div>
							   <?php } ?>						   

							</div>
						</div>
						<?php
						endwhile;
						echo '';
						endif;
						// Reset Post Data
						wp_reset_postdata();
						?>
				</div>
			</div>
			<!-- Related Projects -->
		</div>
		<!-- Row-fluid -->
	</div>
	<!-- container -->
</div>
<!-- main-wrapper -->
<?php get_footer(); ?>