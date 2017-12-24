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
<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">		
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
								<iframe width="770" height="500" src="https://www.youtube.com/embed/<?php echo $avis_yvideo_id; ?>?wmode=opaque" class="youtube-video" allowfullscreen></iframe>
							</div>
						<?php } 
					}

					$avis_vvideo_id = parse_vimeo($youtube_src1);
					if($avis_vvideo_id) {?>
						<div class="flex-video widescreen vimeo">	 
							<iframe src='http://player.vimeo.com/video/<?php echo $avis_vvideo_id; ?>?portrait=0&amp;title=0&amp;byline=0&amp;badge=0' width='770' height='442' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
						</div>
						<?php 
					} ?>
					
			</div>
		</div>
		
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