jQuery(document).ready(function ($) {

	//Show/hide metabox, depending on element value
	jQuery(document).ready(function(){
		toggleMetaboxOnFormat("avis_quote_post_format", 'quote');
		toggleMetaboxOnFormat("avis_gallery_post_format", 'gallery');
		toggleMetaboxOnFormat("avis_video_post_format", 'video');
		
		jQuery("input[name=post_format]").on("change",function() {
			toggleMetaboxOnFormat("avis_quote_post_format", 'quote');
			toggleMetaboxOnFormat("avis_gallery_post_format", 'gallery');
			toggleMetaboxOnFormat("avis_video_post_format", 'video');
		});

		toggleMetaboxOnFormat("avis_standard_post_format_portfolio", '0');
		toggleMetaboxOnFormat("avis_gallery_post_format_portfolio", 'gallery');
		toggleMetaboxOnFormat("avis_video_post_format_portfolio", 'video');

		jQuery("input[name=post_format]").on("change",function() {
			toggleMetaboxOnFormat("avis_standard_post_format_portfolio", '0');
			toggleMetaboxOnFormat("avis_gallery_post_format_portfolio", 'gallery');
			toggleMetaboxOnFormat("avis_video_post_format_portfolio", 'video');
		});
		
		togglesectionboxOnFormat();
		
		jQuery("#page_template").on("change",function() {
			togglesectionboxOnFormat();
		});
	});
	function toggleMetaboxOnFormat(metaboxId, value) {
		var format = jQuery("input[name=post_format]:checked").val();
		if(format != value ){
			jQuery("#" + metaboxId).slideUp("fast");}
		else{
			jQuery("#" + metaboxId).slideDown("fast");		
		}
	}
	function togglesectionboxOnFormat() {
		var title = jQuery("#page_template").val();
		
		if(title === 'template-contact-page.php' || title === 'template-contact-with-sidebar.php' ) {
			jQuery("#avis_contact_page_metaboxes").slideDown("fast"); 
		}
		else { 
			jQuery("#avis_contact_page_metaboxes").slideUp("fast"); 
		}

		if(title === 'template-about-page.php') {
			jQuery("#avis_about_page_meta_boxes").slideDown("fast"); 
		}
		else { 
			jQuery("#avis_about_page_meta_boxes").slideUp("fast"); 
		}

		if(title === 'template-4col-project-page.php' || title === 'template-3col-project-page.php') {
			jQuery("#avis_portfolio_inner_meta_boxes").slideDown("fast"); 
		}
		else { 
			jQuery("#avis_portfolio_inner_meta_boxes").slideUp("fast"); 
		}
		
		if(title === 'template-front-page.php') {
			jQuery("#avis_page_meta_boxes").slideDown("fast"); 
			jQuery("#avis-fpage-sections-order-metaboxes").slideDown("fast"); 
			jQuery("#avis_header_meta_boxes").slideUp("fast");
		}
		else { 
			jQuery("#avis_page_meta_boxes").slideUp("fast"); 
			jQuery("#avis-fpage-sections-order-metaboxes").slideUp("fast"); 
			jQuery("#avis_header_meta_boxes").slideDown("fast");
		}
		
	}
});

jQuery(document).ready(function() 
{
	if(jQuery('#avis-frontpage-sections').length > 0){
		jQuery("#avis-frontpage-sections").sortable({placeholder: "ui-state-highlight"});
	}
});