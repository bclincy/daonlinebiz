<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * The template for displaying posts in the Video post format.
 * Created by sketchthemes
*/
?>
<!-- Project Box -->
<div class="item project_box span4 avis_animate_when_almost_visible avis_bottom-to-top">
	<!-- video -->
	<div class="project-item" id="post-<?php the_ID(); ?>">

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
		
			<div class="portfolio_overlay">
				<div class="port_overlay_content">
					<div class="title"><?php the_title();?></div>
					<div class="port_single_link">
						<a class="single-port-link" href="<?php the_permalink();?>" title="<?php the_title();?>"><i class="fa fa-link"></i></a>
						<a href="<?php echo $youtube_src1; ?>" data-rel="prettyPhoto" title="View Large"><i class="fa fa-search"></i></a>
					</div>
				</div>
			</div>

		</div>
		<!-- video -->
</div>
<!-- Project Box -->