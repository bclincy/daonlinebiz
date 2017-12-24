<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * The default template for displaying content. Used for both single and index/archive/search.
 * Created by sketchthemes
*/
?>
<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
		
		<div class="featured-image-shadow-box standard_featured_img">
			<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
				<?php
						$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'avis_fullblog_img');
				?>
				<a href="<?php the_permalink(); ?>" class="image">
					<img src="<?php echo $thumbnail[0];?>" alt="<?php the_title(); ?>" class="featured-image alignnon"/>
				</a>
				
			<?php } ?>
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