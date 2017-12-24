<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Theme Default Content Section Template For Front Page.
 * Created by sketchthemes
*/
?>
<!-- PAGE EDITER CONTENT -->
<div id="front-content-box" class="avis-section">
	<div class="container">
		<div class="row-fluid"> 
			<?php 
				$post_object = get_post( $postid );
				if($post_object->post_content) {
					echo do_shortcode($post_object->post_content); 
				}
			?>
		</div>
		<div class="border-content-box bottom-space"></div>
	</div>
</div>
<!-- \\PAGE EDITER CONTENT -->