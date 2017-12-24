<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 * Created by sketchthemes
 *
*/
global $avis_shortname, $avis_themename;
$avis_facebook  = avis_get_option($avis_shortname.'_fbook_link');
$avis_flickr	 = avis_get_option($avis_shortname.'_flickr_link');
$avis_linkedin  = avis_get_option($avis_shortname.'_linkedin_link');
$avis_gpluseone = avis_get_option($avis_shortname.'_gplus_link');
$avis_twitter   = avis_get_option($avis_shortname.'_twitter_link');
$avis_vk   = avis_get_option($avis_shortname.'_vk_link');
$avis_pinterest   = avis_get_option($avis_shortname.'_pinterest_link');
$avis_instagram   = avis_get_option($avis_shortname.'_instagram_link');
?>
	<div class="clearfix"></div>
</div>
<!-- #main --> 

<!-- #footer -->
<div id="footer" class="avis-section">
	<div class="container">
		<div class="row-fluid">
			<div class="second_wrapper">
				<?php dynamic_sidebar( 'Footer Sidebar' ); ?>
				<div class="clearfix"></div>
			</div><!-- second_wrapper -->
		</div>
	</div>

	<div class="third_wrapper">
		<div class="container">
			<div class="row-fluid">
				<?php $sktURL = 'http://www.sketchthemes.com/'; ?>
				<div class="copyright span6 alpha omega"> 
					<p>USA Officials Association</p>
				</div>
				<div class="owner span6 alpha omega">
					<!-- Footer Follow Us Section Start -->
						<div class="social-icons">
							
						</div>
					<!-- Footer Follow Us Section End -->
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div><!-- third_wrapper --> 
</div>
<!-- #footer -->

</div>
<!-- #wrapper -->
	<a href="JavaScript:void(0);" title="Back To Top" id="backtop"></a>
	<?php wp_footer(); ?>
</body>
</html>