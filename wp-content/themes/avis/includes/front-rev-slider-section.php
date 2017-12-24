<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme Revolution Slider Template For Front Page.
 * Created by sketchthemes
*/
?>
<div class="avis_revolution">
<?php 
	if(function_exists('putRevSlider')) {
		$revAlias = get_post_meta( $post->ID, '_home_revslider', true );
		if(isset($revAlias)){ putRevSlider( $revAlias ); } 
	}else{
		_e('<div class="rev_slider_install_err">Please install the <b>Revolution Slider</b> from admin section</div>','');
	}
?>
</div>