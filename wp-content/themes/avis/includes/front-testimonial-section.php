<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme Testimonial Template For Front Page.
 * Created by sketchthemes
*/
?>
<?php
$_home_testimonial_section = get_post_meta( $post->ID,'_home_testimonial_section',true );
$_home_testimonial_heading = get_post_meta( $post->ID,'_home_testimonial_heading',true );
$_home_testimonial_desc	= get_post_meta( $post->ID,'_home_testimonial_desc',true );

if($_home_testimonial_section == 'on'){ 
?>
<div id="full-testimonial-box" class="avis-section">
	<div class="container testimonial-content-box" >

		<div class="sections_inner_content fade_in_hide element_fade_in">
			<?php if (isset($_home_testimonial_heading) && $_home_testimonial_heading !='') { ?><h2 class="section_heading"><?php echo $_home_testimonial_heading; ?></h2><?php } ?>
			<?php if (isset($_home_testimonial_desc) && $_home_testimonial_desc !='') { ?><div class="section_description"><?php echo $_home_testimonial_desc; ?></div><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>

		<!-- Testimonial Section Starts -->
		<div class="row-fluid">
			<ul id="testimonial-item" class="owl-carousel testimonials-items">
				<?php 
					$args = array('post_type'=>'testimonial_post','posts_per_page' => -1);
					$the_query = new WP_Query($args);
					if($the_query->have_posts()) : 
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$id					  = get_the_ID();
					$data					= get_post_meta($id);
					$_testimonial_avatar	 = !empty($data['_testimonial_avatar'][0]) ? $data['_testimonial_avatar'][0] : '' ;
					$_testimonial_job_title  = !empty($data['_testimonial_job_title'][0]) ? $data['_testimonial_job_title'][0] : '' ;
					$_testimonial_text 		 = !empty($data['_testimonial_text'][0]) ? $data['_testimonial_text'][0] : '' ;
					$myarray[] = $_testimonial_avatar;
				?>

				<li class="clearfix">					
					<div class="span3 testimonial-img">
						<div class="testimonial_quote_icon"><i class="fa fa-quote-left"></i></div>
						<div class="testimonial_avatar_img"><img src="<?php echo $_testimonial_avatar; ?>" alt="<?php echo $_testimonial_avatar[0]; ?>"/></div>
					</div>
					<div class="span9 testimonial-content-box">
						<div class="testimonial_content"><?php echo $_testimonial_text; ?></div>
						<div class="title_outer"><?php the_title(); echo ", " . $_testimonial_job_title;  ?></div>
					</div>						
				</li>
			
				<?php endwhile; ?>
				<?php else : ?>
				<h2><?php _e('Apologies, but no Testimonial were found.','avis'); ?></h2>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
		</div>
		<!-- Testimonial Section End -->
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#testimonial-item").owlCarousel({
			items : 1,
			lazyLoad : true,
			navigation : false,
			autoPlay : true,
			itemsDesktop : [1199, 1],
			itemsDesktopSmall : [979, 1],
			itemsTablet : [768, 1],
			itemsMobile : [479, 1],
			transitionStyle : "backSlide",
			stopOnHover : true,
			pagination : false
			
		});
	});
</script>
<?php } ?>