<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme Static Background Image Section Template For Front Page.
 * Created by sketchthemes
*/
?>

<div class="Skt-header-image">
<?php $front_bg_image = get_post_meta( $post->ID, '_home_bgimage', true ); ?>
	<!-- header image -->
		<div class="avis-front-bgimg"><img alt="Background Image" class="ad-slider-image" width="1585"  src="<?php if($front_bg_image) { echo $front_bg_image; } else { echo get_template_directory_uri().'/images/1600x500.png';}?>" ></div>
	<!-- end  header image  -->
</div>