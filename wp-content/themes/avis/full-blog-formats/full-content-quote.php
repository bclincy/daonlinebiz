<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * The template for displaying posts in the Quote post format.
 * Created by sketchthemes
*/
?>

<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
		<div class="quote_wrapper">		
			<div class="featured-image-shadow-box quote_featured_img">		
				<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
				<?php 
						$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'avis_standard_img');
				?>
				<a href="<?php the_permalink(); ?>" class="image">
					<img src="<?php echo $thumbnail[0];?>" alt="<?php the_title(); ?>" class="featured-image alignnon"/>
				</a>
				<?php } ?>
			</div>
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