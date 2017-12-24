<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * The default template for displaying content for portfolio post type.
 * Created by sketchthemes
*/
?>
<?php
	$id   = get_the_ID();
	$data = get_post_meta($id);
	$_front_portfolio_img   = !empty($data['_front_portfolio_img'][0]) ? $data['_front_portfolio_img'][0] : '' ;
	$_single_portfolio_img  = !empty($data['_single_portfolio_img'][0]) ? $data['_single_portfolio_img'][0] : '' ;
	$terms = get_the_terms( $post->ID, 'portfolio_category' ); 
	$cat_links = array();
	foreach ( $terms as $term ) {
		$cat_links[] = $term->slug;
	}
?>
<!-- Project Box -->
<div class="item project_box span4 avis_animate_when_almost_visible avis_bottom-to-top">
	<!-- standard -->
	<div class="project-item" id="post-<?php the_ID(); ?>">
		<div class="feature_image" style="position: relative;">
			<img class="skin-border" src="<?php echo $_front_portfolio_img; ?>" alt="<?php echo $_front_portfolio_img[0]; ?>" />
		</div>

		<div class="portfolio_overlay">
			<div class="port_overlay_content">
				<div class="title"><?php the_title();?></div>
				<div class="port_single_link">
					<a class="single-port-link" href="<?php the_permalink();?>" title="<?php the_title();?>"><i class="fa fa-link"></i></a>
					<a href="<?php echo $_single_portfolio_img; ?>" data-rel="prettyPhoto" title="View Large"><i class="fa fa-search"></i></a>
				</div>
			</div>
		</div>
		
	</div>
	<!-- standard -->
</div>
<!-- Project Box -->