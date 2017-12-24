<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * The sidebar containing the secondary widget area, displays on pages.
 * If no active widgets in this sidebar, it will be hidden completely.
 */	
?>

<div id="sidebar_2" class="avis_widget">
	<ul class="skeside">
		<?php dynamic_sidebar( 'Page Sidebar' ); ?>
	</ul>
</div>
<!-- #sidebar_2 .avis_widget -->