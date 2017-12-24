<?php
/**
 * @package	 WordPress
 * @subpackage 	SketchThemes
 * @version 	1.0.0
 *
 * This is the Custom Css template for website.
 * Created by sketchthemes
 */
?>
<?php
	global $avis_shortname, $avis_themename, $post, $headercolorpicker, $color_scheme, $mobi_menu_width, $_persistent_on_off, $_primary_color_scheme;
	$_primary_color_scheme ="";

function skeHex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
	$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
	$rgbArray = array();
	if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
		$colorVal = hexdec($hexStr);
		$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
		$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
		$rgbArray['blue'] = 0xFF & $colorVal;
	} elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
		$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
		$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
		$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
	} else {
		return false; //Invalid hex color code
	}
	return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
} 

	if ( is_page_template( 'template-front-page.php' ) ) {
		$_home_about_image 		  = get_post_meta( $post->ID,'_home_about_image',true );
		$_home_testimonial_image  = get_post_meta( $post->ID,'_home_testimonial_image',true );
		$_home_services_bgimg  = get_post_meta( $post->ID,'_home_services_bgimg',true );
		$_home_tws_bgimg		  = get_post_meta( $post->ID,'_home_tws_bgimg',true );
	}	

	if(avis_get_option($avis_shortname.'_primary_color_scheme')){ $_primary_color_scheme = avis_get_option($avis_shortname.'_primary_color_scheme'); }
	if(avis_get_option($avis_shortname.'_colorpicker')){ $color_scheme = avis_get_option($avis_shortname.'_colorpicker'); } 
	if(avis_get_option($avis_shortname.'_headercolorpicker')){ $headercolorpicker = avis_get_option($avis_shortname.'_headercolorpicker'); } 
	if(avis_get_option($avis_shortname.'_navfontcolorpicker')){ $navfontcolorpicker = avis_get_option($avis_shortname.'_navfontcolorpicker'); } 
	if(avis_get_option($avis_shortname.'_persistent_on_off')){ $_persistent_on_off = avis_get_option($avis_shortname.'_persistent_on_off');}
	if(avis_get_option($avis_shortname.'_teamcolorpicker')){ $teamcolorpicker = avis_get_option($avis_shortname.'_teamcolorpicker'); } 
	if(avis_get_option($avis_shortname.'_teamtitlecolor')){ $teamtitlecolor = avis_get_option($avis_shortname.'_teamtitlecolor'); }	
	if(avis_get_option($avis_shortname.'_bread_background')){ $_bread_background = avis_get_option($avis_shortname.'_bread_background'); }
	if(avis_get_option($avis_shortname.'_fullparallax_image')){ $fullparallax_image = avis_get_option($avis_shortname.'_fullparallax_image'); }
	if(avis_get_option($avis_shortname.'_moblie_menu')){ $mobi_menu_width = avis_get_option($avis_shortname.'_moblie_menu'); } 
	if(avis_get_option($avis_shortname.'_logo_width')){ $avis_logo_wdth = avis_get_option($avis_shortname.'_logo_width'); } 
	if(avis_get_option($avis_shortname.'_logo_height')){ $avis_logo_hght = avis_get_option($avis_shortname.'_logo_height'); } 
	if(avis_get_option($avis_shortname.'_hide_con_map')){ $avis_hide_map = avis_get_option($avis_shortname.'_hide_con_map'); } 
	if(avis_get_option($avis_shortname.'_contact_gmap_height')){ $avis_map_height = avis_get_option($avis_shortname.'_contact_gmap_height'); } 
	if(avis_get_option($avis_shortname.'_hide_pro_filter')){ $avis_port_filter_hide = avis_get_option($avis_shortname.'_hide_pro_filter'); }

	if(is_page_template('template-contact-page.php') || is_page_template('template-contact-with-sidebar.php')) {
		$_contact_map_bg_image 	= avis_bg_style(get_post_meta($post->ID,'_contact_map_bg_image',true));
	}
	if(is_page_template('template-contact-page.php') || is_page() || is_search() || is_home() || is_404() || is_front_page() || is_page_template('template-blog-full-width.php') || is_page_template('template-blog-left-sidebar-page.php') || is_page_template('template-blog-right-sidebar-page.php') || is_page_template('template-masonry.php') || is_archive()) {
		$_bread_background  = avis_bg_style(avis_get_option($avis_shortname.'_bread_background'));
	}
	if(is_page() || is_singular()) {
		$_pagetitle_bg = avis_bg_style(get_post_meta($post->ID, '_pagetitle_bg', true));
		$_bread_background  = avis_bg_style(avis_get_option($avis_shortname.'_bread_background'));
	}

	$rgb=array();
	$rgb = skeHex2RGB($color_scheme);
	$R = $rgb['red'];
	$G = $rgb['green'];
	$B = $rgb['blue'];
	$rgbcolorteam = "rgba(". $R .",". $G .",". $B .",1)";
	$rgbcolor = "rgba(". $R .",". $G .",". $B .",.4)";
	$bdrrgbcolor = "rgba(". $R .",". $G .",". $B .",.7)";

	$hrgb = skeHex2RGB($_primary_color_scheme);
	$hR = $hrgb['red'];
	$hG = $hrgb['green'];
	$hB = $hrgb['blue'];
	$hrgbcolor = "rgba(". $hR .",". $hG .",". $hB .",.7)";
	$hrgbcolorscl = "rgba(". $hR .",". $hG .",". $hB .",.85)";
	$hrgbcolorsclsc = "rgba(". $hR .",". $hG .",". $hB .",.9)";

?>
<style type="text/css">

	/**************** LOGO SIZE ***************/
	.skehead-headernav .logo{width:<?php if(isset($avis_logo_wdth)){ echo $avis_logo_wdth; } ?>px;height:<?php if(isset($avis_logo_hght)){ echo $avis_logo_hght; } ?>px;}

	/***************** THEME *****************/

	/*************** TOP HEADER **************/
	.topbar_info:hover i,
	#footer .third_wrapper a:hover,
	.avis-footer-container ul li:hover:before,
	.avis-footer-container ul li:hover > a,
	.twitter_box a, .skepost-meta .comments a,#services-box .avis_tab_h ul.avis_tabs li.active:after{
		color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;}

	#calendar_wrap tfoot,#wp-calendar caption,#wp-calendar thead,#wp-calendar thead th {background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }
	.avis_price_table .price_table_inner .price_button a:hover {border: 1px solid <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; }
	.mid-box:hover .avis-iconbox.iconbox-top .iconbox-icon {cursor:pointer; background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;}
	.avis-section h2.section_heading, .about-avis-section h2.section_heading {color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;}
	.we_are_here_html .inner_html .fa, .map_overlay_text .fa,
	.service-icon i,.bread-title-holder a,#wp-calendar a:hover,
	ul.protfolio_details li .fa,.flex-caption .slider-title,
	.skepost-meta, .skepost, .skepost > p, .skepost-meta .comments span.author-name a,
	.iconbox-icon i, .avis-iconbox h4,.avis-title,.comment-author cite,.comment-author .says,
	.commentmetadata a, .comment-meta.commentmetadata{
		color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>;}

	 .avis_widget ul ul li:before, .widget_text ul li:before,
	 .widget_nav_menu ul li:before, .widget_pages ul li:before, 
	 .widget_categories ul li:before, .wpb_taxonomy ul li:before, 
	 .widget_recent_entries ul li:before, .widget_recent_comments ul li:before, 
	 .widget_archive ul li:before, .widget_meta ul li:before,
	 .avis_widget a:link, .avis_widget a:visited,
	 .widget_product_tag_cloud a,
	 #wp-calendar tbody td,div.avis_acc_title, div.avis_acc_content,
	 .work-procress-inner-wrap.one-fifth-part h3,.process-inner .fa.fa-chevron-right,
	 .avis-progress-bars .avis-progress-title,.avis-number-pb .avis-number-pb-num,
	 #services-box .avis_tabs .fa, #services-box .avis_tabs i,#services-box .avis_tab_h ul.avis_tabs li a,
	 .avis_price_table .price_in_table .value,.avis_price_table .price_in_table .price,.avis_price_table .price_in_table .mark,
	 .avis_price_table .price_table_inner ul li{
	 	color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; }

	.we_are_here_content .inner_html li:hover .fa,
	.about_we_are_here_content .inner_html li:hover .fa,
	.about_we_are_here_content h3,
	.post h3,.contact-post h3,.contact-add strong,.services-avis-section h2.section_heading,
	.skepost-meta span:hover, .skepost-meta span:hover .fa, .skepost-meta span:hover a,h3#reply-title,#comments,
	.cont_nav_inner span,.page-container.clearfix > h3,div.avis_acc_title.active,
	.avis_price_table.price_featured .price_in_table .value,.avis_price_table.price_featured .price_in_table .price,
	.avis_price_table.price_featured .price_in_table .mark,.related-wrap .sections_inner_content h2{ 
		color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;
	}
	.skepost-meta span:hover,#comments::after,h3#reply-title:after,.post-title > a::before {
		border-bottom-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;
	}
	.call_to_action .button-link.medium-button,
	#latest-project-section .port-readmore a.button-link,
	.navigation .alignleft a,.navigation .alignright a,.seperator > span,.title-seperator > span,
	.contact-seperator > span,.front-title-seperator > span,.about-title-seperator > span,.avis-number-pb-shown.dream,
	#services-box .avis_tab_h ul.avis_tabs li.active,#services-box .avis_tab_h ul.avis_tabs li:hover,
	#services-box .avis_tab_h .avis_tab_container .avis_tab_content{
		background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?> !important;
	}
	#wrapper .hsearch input[type="text"]{background-color:<?php if(isset($hrgbcolor)){ echo $hrgbcolor; } ?> !important;}















	.call_to_action .button-link.medium-button:hover,
	#latest-project-section .port-readmore a.button-link:hover,.navigation .alignleft a:hover,.navigation .alignright a:hover,.seperator{
		background-color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?> !important;
	}
	.parallax_inner_html h2,
	.services-inner-wrap:hover h3 > .fa, .services-inner-wrap:hover h3 > i, .quote_post .avis-quote .fa,
	.quote_wrapper .quote_post .avis-quote,.quote_post .avis-quote .quoteauthor a {color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;}
	#full-division-box .action-button {
		border-bottom: 1px solid <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;
		transition: all 1s ease 0s;-webkit-transition: all 1s ease 0s; -moz-transition: all 1s ease 0s; -o-transition: all 1s ease 0s;
	}
	.page-template-template-front-page a.large-button, 
	.page-template-template-front-page a.small-button, 
	.page-template-template-front-page a.medium-button{background: none repeat scroll 0 0 <?php echo $_primary_color_scheme; ?> !important; 
		transition: all 1s ease 0s;-webkit-transition: all 1s ease 0s; -moz-transition: all 1s ease 0s; -o-transition: all 1s ease 0s;
	}
	a.large-button:hover, a.small-button:hover, a.medium-button:hover {background: none repeat scroll 0 0 <?php echo $color_scheme; ?> !important;
		transition: all 1s ease 0s;-webkit-transition: all 1s ease 0s; -moz-transition: all 1s ease 0s; -o-transition: all 1s ease 0s;
	}
	.contact-post .contact-add .fa,
	.team-box-mid .team_overlay_content .title,
	.team-box-mid .team_overlay_content .team_prof,
	.team-box-mid .team_overlay_content .teamsocial a {color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; }


	.teammember:hover {background-color:<?php if(isset($rgbcolorteam)){ echo $rgbcolorteam;  } ?>;
		-webkit-transition: all 0.5s ease 0s;transition: all 0.5s ease 0s;-o-transition: all 0.5s ease 0s;-moz-transition:all 0.5s ease 0s; }
	.teammember:hover .team_overlay_content .title,
	.teammember:hover .team_overlay_content .team_prof{color: #fff; -webkit-transition: .3s ease-in-out;
		transition: .3s ease-in-out;-o-transition: .3s ease-in-out;-moz-transition:.3s ease-in-out;}
	.teammember:hover .team_overlay_content .seperator{background-color: #fff !important; -webkit-transition: .3s ease-in-out;
		transition: .3s ease-in-out;-o-transition: .3s ease-in-out;-moz-transition:.3s ease-in-out;}
	

	.gmap-close,.avis_widget .widget_tag_cloud a:hover {background-color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>;}
	.navigation .nav-previous,
	.navigation .nav-next,
	ul.protfolio_details li:hover .fa,
	#content .contact-left form input[type="submit"],
	.contact-post .contact-add .fa, #contact-gmap-toggle, .error-txt-first img,blockquote,
	#wp-calendar tbody a,.widget_product_tag_cloud a:hover,#respond input[type="submit"],.comments-template .reply a,
	#avis-paginate a,.sktmenu-toggle,.work-procress-inner-wrap.one-fifth-part:hover,.avis-twitter-widget .tweets ul li::before {
		background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;
	}
	.widget_tag_cloud a {color:#ffffff !important; background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }
	#avis-paginate a,div.avis_acc_title.active {border: 1px solid <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;}
	div.avis_acc_title.active {border-left-width: 6px;}
	div.avis_acc_title {border-left-width: 6px;}
	a#backtop {color:#ffffff; background-color:<?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }
	#full-twitter-box #bot-twitter .foot-tw-control-paging a.foot-tw-active,
	.avis_price_table .active_best_price,
	.navigation .nav-previous:hover,
	.navigation .nav-next:hover, #contact-gmap-toggle:hover, .postformat-gallerycontrol-nav li a.postformat-galleryactive,
	.flex-control-paging li a.flex-active,.avis_price_table .price_table_inner ul li.table_title,
	#header.skehead-headernav.skehead-headernav-shrink,#header.skehead-headernav.skehead-headernav-shrink #logo{
		background-color:<?php if(isset($color_scheme)){ echo $color_scheme; } ?>;
	}
	.filter a:hover,.filter li a.selected {color:<?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; border-bottom: 1px solid <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }
	#container-isotop .project_box:hover .portfolio_overlay {background-color: rgba(0, 0, 0, 0.8); }
	.port_single_link a {background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;}
	.port_single_link a:hover{background-color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>;}
	.avis_price_table.price_featured .price_table_inner ul li.table_title,.continue a{background: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }
	.sticky-post {color :<?php if(isset($color_scheme)){ echo $color_scheme; } ?>;border-color:<?php if(isset($bdrrgbcolor)){ echo $bdrrgbcolor; } ?>}
	.avis_price_table .price_table_inner .price_button a { border-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }
	.social li a:hover{background: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>;}
	.social li a:hover:before{color:#fff; }
	.flexslider:hover .flex-next:hover, .flexslider:hover .flex-prev:hover,a#backtop:hover,.slider-link a:hover,#respond input[type="submit"]:hover,.avis-ctabox div.avis-ctabox-button a:hover,#portfolio-division-box a.readmore:hover,.project-item .icon-image,.project-item:hover,.continue a:hover,#avis-paginate .avis-current,#avis-paginate a:hover,.postformat-gallerydirection-nav li a:hover,.comments-template .reply a:hover,#content .contact-left form input[type="submit"]:hover,.service-icon:hover,.avis-parallax-button:hover,.avis_price_table .price_table_inner .price_button a:hover,#content .avis-service-page div.one_third:hover .service-icon,#content div.one_half .avis-service-page:hover .service-icon  {background-color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; }
	form input[type="text"],form input[type="email"],
	form input[type="url"],form input[type="tel"],
	form input[type="number"],form input[type="range"],
	form input[type="date"], form input[type="file"],form select,form textarea{color :<?php if(isset($color_scheme)){ echo $color_scheme; } ?>}
	form input[type="text"]:focus,form input[type="email"]:focus,
	form input[type="url"]:focus,form input[type="tel"]:focus,
	form input[type="number"]:focus,form input[type="range"]:focus,
	form input[type="date"]:focus,form input[type="file"]:focus,form textarea:focus,
	#respond label,#respond .comment-notes {color :<?php if(isset($color_scheme)){ echo $color_scheme; } ?> }
	#content .contact-left form input[type="text"],#content .contact-left form input[type="email"],
	#content .contact-left form input[type="url"],#content .contact-left form input[type="tel"],
	#content .contact-left form input[type="number"],#content .contact-left form input[type="range"],
	#content .contact-left form input[type="date"],#content .contact-left form input[type="file"],
	#content .contact-left form textarea,#content .contact-left form select,
	p.comment-form-author,p.comment-form-email,p.comment-form-url,p.comment-form-comment
	{ border-bottom: 2px solid <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; color :<?php if(isset($color_scheme)){ echo $color_scheme; } ?>}
	#content .contact-left form textarea:focus,#content .contact-left form input[type="text"]:focus,
	#content .contact-left form input[type="email"]:focus, #content .contact-left form input[type="url"]:focus, 
	#content .contact-left form input[type="tel"]:focus, #content .contact-left form input[type="number"]:focus, 
	#content .contact-left form input[type="range"]:focus, #content .contact-left form input[type="date"]:focus, 
	#content .contact-left form input[type="file"]:focus,#content .contact-left form select:focus,
	form input[type="text"]:focus,form input[type="email"]:focus,form select:focus, 
	form input[type="url"]:focus,form input[type="tel"]:focus, form input[type="number"]:focus,form input[type="range"]:focus, 
	form input[type="date"]:focus,form input[type="file"]:focus,form textarea:focus {border-bottom: 2px solid <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;}
	.avis-ctabox div.avis-ctabox-button a,#portfolio-division-box .readmore,.slider-link a,
	.avis_tab_v ul.avis_tabs li.active,.avis_tab_h ul.avis_tabs li.active,
	.service-icon,.avis-parallax-button,#avis-paginate a:hover,#avis-paginate .avis-current,
	.avis-iconbox .iconbox-content h4 hr {border-color:<?php if(isset($color_scheme)){ echo $color_scheme; } ?>;}
	.clients-items li a:hover{border-bottom-color:<?php if(isset($color_scheme)){ echo $color_scheme; } ?>;}
	a,.avis_widget ul ul li:hover:before,.avis_widget ul ul li:hover,.avis_widget ul ul li:hover a,.title a ,.skepost-meta a:hover,.post-tags a:hover,.entry-title a:hover,.readmore a:hover,#Site-map .sitemap-rows ul li a:hover ,.childpages li a,#Site-map .sitemap-rows .title,.avis_widget a,.avis_widget a:hover,#Site-map .sitemap-rows ul li:hover,span.team_name,.reply a, a.comment-edit-link,#full-subscription-box .sub-txt .first-word{color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;text-decoration: none;}
	.single #content .title,#content .post-heading,.childpages li ,.fullwidth-heading,#respond .required{color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>;} 

	*::-moz-selection{background: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;color:#fff;}
	::selection {background: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;color:#fff;}
	.progress_bar {background: none repeat scroll 0 0 <?php if(isset($color_scheme)){ echo $color_scheme; } ?>;}
	.avis-front-subs-widget input[type="submit"]{ background-color:<?php if(isset($color_scheme)){ echo $color_scheme; } ?>;color:#fff;}
	
	#skenav ul li.current_page_item > a,
	#skenav ul li.current-menu-ancestor > a,
	#skenav ul li.current-menu-item > a,
	#skenav ul li.current-menu-parent > a,
	#skenav ul li:hover > a {background-color:<?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }

	#header.skehead-headernav.skehead-headernav-shrink #skenav ul.menu li.current_page_item > a,
	#header.skehead-headernav.skehead-headernav-shrink #skenav ul.menu li.current-menu-ancestor > a,
	#header.skehead-headernav.skehead-headernav-shrink #skenav ul.menu li.current-menu-item > a,
	#header.skehead-headernav.skehead-headernav-shrink #skenav ul.menu li.current-menu-parent > a,
	#header.skehead-headernav.skehead-headernav-shrink #skenav ul.menu li:hover > a {background-color:transparent;padding-bottom: 28px;border-bottom:3px solid <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }

	#skenav ul > li:hover::before,
	#skenav ul > li.current-menu-ancestor::before,
	#skenav ul > li.current-menu-item::before,
	#skenav ul > li.current-menu-parent::before,
	#skenav ul > li.current_page_item::before{ color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }

	#skenav ul ul li.current_page_item,
	#skenav ul ul li.current-menu-ancestor,
	#skenav ul ul li.current-menu-item,
	#skenav ul ul li.current-menu-parent,
	#skenav ul ul li:hover,
	#skenav ul ul.children li.page_item_has_children,
	#skenav ul ul.children li:hover {border-bottom:1px solid <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }

	#searchform .searchright { background: none repeat scroll 0 0 <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;}
	.avis-footer-container ul li {}
	.col-one .box .title, .col-two .box .title, .col-three .box .title, .col-four .box .title {color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?> !important;  }
	.avis-counter-h i, .error-txt,
	.error404 #searchform input[type="text"],
	.search #searchform input[type="text"], 
	#sidebar #searchform input[type="text"],#footer #searchform input[type="text"] {color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; }

	<?php 
		
		if(isset($_bread_background) && $_bread_background !='') {	?>
				#main-head-wrap {<?php echo $_bread_background; ?>}
			<?php  }
		else{
			?>
				#main-head-wrap {background: none repeat scroll 0 0 rgba(0, 0, 0, 0.6);}
			<?php
			}


		if(isset($_pagetitle_bg) && $_pagetitle_bg !='') {
			?> 
				#main-head-wrap {<?php echo $_pagetitle_bg; ?>;}
			<?php 
			}
		else if(isset($_bread_background) && $_bread_background !='') {
			?>
				#main-head-wrap {<?php echo $_bread_background; ?>;}
			<?php
			}
		else{
			?>
				#main-head-wrap {background: none repeat scroll 0 0 rgba(0, 0, 0, 0.6);}
			<?php
			}
	?>

	#about-section-box { background-image: url("<?php if(isset($_home_about_image)){ echo $_home_about_image; } ?>");background-repeat: no-repeat;background-size:cover;-webkit-background-size: cover; -moz-background-size: cover; background-repeat: no-repeat;overflow: hidden;background-attachment:fixed;}
	#full-testimonial-box { background-image: url("<?php if(isset($_home_testimonial_image)){ echo $_home_testimonial_image; } ?>");background-repeat: no-repeat;background-size:cover;-webkit-background-size: cover; -moz-background-size: cover; }
	#services-division-box { background-image: url("<?php if(isset($_home_services_bgimg)){ echo $_home_services_bgimg; } ?>");background-repeat: no-repeat;background-size:cover;-webkit-background-size: cover; -moz-background-size: cover; }
	#full-twitter-box { background-image: url("<?php if(isset($_home_tws_bgimg)){ echo $_home_tws_bgimg; } ?>"); background-size:cover;-webkit-background-size: cover; -moz-background-size: cover;background-repeat: no-repeat;background-attachment:fixed; }

	#map_canvas .contact-map-overlay { <?php if(isset($_contact_map_bg_image)){ echo $_contact_map_bg_image; } else { ?>background-color: rgba(0, 0, 0, 0.8);<?php } ?> }

	@keyframes team_ttb{25%{box-shadow:0 0 0 5px <?php if(isset($color_scheme)){ echo $rgbcolor; } ?>} 100%{box-shadow:0 0 0 5px <?php if(isset($color_scheme)){ echo $color_scheme; } ?>}}
	@-webkit-keyframes team_ttb{25%{box-shadow:0 0 0 5px <?php if(isset($color_scheme)){ echo $rgbcolor; } ?>} 100%{box-shadow:0 0 0 5px <?php if(isset($color_scheme)){ echo $color_scheme; } ?>}}
	@-moz-keyframes team_ttb{25%{box-shadow:0 0 0 5px <?php if(isset($color_scheme)){ echo $rgbcolor; } ?>} 100%{box-shadow:0 0 0 5px <?php if(isset($color_scheme)){ echo $color_scheme; } ?>}}
	@-o-keyframes team_ttb{25%{box-shadow:0 0 0 5px <?php if(isset($color_scheme)){ echo $rgbcolor; } ?>} 100%{box-shadow:0 0 0 5px <?php if(isset($color_scheme)){ echo $color_scheme; } ?>}}
	
	.footer-seperator{background-color: rgba(0,0,0,.2);}
	#footer div.follow-icons li:hover a{background: none repeat scroll 0 0 <?php if(isset($color_scheme)){ echo $color_scheme; } ?> !important;}
	#footer div.follow-icons .social li:hover a:before{color: #747474 !important; }

	.avis-iconbox.iconbox-top:hover .iconboxhover {  background-color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; }
	section > h1 { color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; }
	#avis-product-cat li > a { background-color: <?php if(isset($hrgbcolor)){ echo $hrgbcolor; } ?>; }
	#avis-product-cat .owl-buttons .owl-prev:hover, #avis-product-cat .owl-buttons .owl-next:hover, #avis-re-product .owl-buttons .owl-prev:hover, #avis-re-product .owl-buttons .owl-next:hover { background-color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; color: #fff; border: 1px solid <?php if(isset($color_scheme)){ echo $color_scheme; } ?>;}
	#avis-product-cat .owl-buttons .owl-prev, #avis-product-cat .owl-buttons .owl-next, #avis-re-product .owl-buttons .owl-prev, #avis-re-product .owl-buttons .owl-next { border: 1px solid <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; } 
	.header-cart > a { background-color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; }
	#avis-re-product .item .overlay a.prolink:hover { background-color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; }
	#content .featured-image-shadow-box .fa { color: <?php if(isset($color_scheme)){ echo $color_scheme; } ?>; }
	
	<?php if(isset($avis_hide_map) && $avis_hide_map === 'false' ){ ?>#map_canvas{display:none;}<?php } ?>
	<?php if(isset($avis_port_filter_hide) && $avis_port_filter_hide === 'false' ){ ?>#container-isotop{margin-top:0px !important;}<?php } ?>
	#map_canvas #map,#map_canvas{height:<?php if(isset($avis_map_height)){ echo $avis_map_height; } ?>px;}
 	<?php if(isset($avis_port_filter_hide) && $avis_port_filter_hide === 'false' ){ ?>#container-isotop{margin-top:0px !important;}<?php } ?>

	.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
		background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;
		 background-color: <?php if(isset($hrgbcolorscl)){ echo $hrgbcolorscl; } ?>;;
	}

	.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{
		background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;
		background-color: <?php if(isset($hrgbcolorscl)){ echo $hrgbcolorscl; } ?>;;
	}
	.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
	.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{
		background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>;
		background-color: <?php if(isset($hrgbcolorsclsc)){ echo $hrgbcolorsclsc; } ?>;;
	}
	
	/********************** MAIN NAVIGATION PERSISTENT **********************/
	<?php if($_persistent_on_off === 'off') { ?>#header.skehead-headernav.skehead-headernav-shrink {position: relative;} .header-clone {display:none;} <?php } ?>

	@media only screen and (max-width : <?php if(isset($mobi_menu_width)){ echo $mobi_menu_width; } ?>px) {
		#menu-main {
			display:none;
		}

		#header .container {
			width:97%;
		}

		#header.skehead-headernav.skehead-headernav-shrink #skenav ul.menu li.current_page_item > a, 
		#header.skehead-headernav.skehead-headernav-shrink #skenav ul.menu li.current-menu-ancestor > a, 
		#header.skehead-headernav.skehead-headernav-shrink #skenav ul.menu li.current-menu-item > a, 
		#header.skehead-headernav.skehead-headernav-shrink #skenav ul.menu li.current-menu-parent > a, 
		#header.skehead-headernav.skehead-headernav-shrink #skenav ul.menu li:hover > a {
			background-color: <?php if(isset($_primary_color_scheme)){ echo $_primary_color_scheme; } ?>; }
		}
		#header.skehead-headernav.skehead-headernav-shrink #skenav ul ul li.current_page_item a, 
		#header.skehead-headernav.skehead-headernav-shrink #skenav ul ul li.current-menu-ancestor a, 
		#header.skehead-headernav.skehead-headernav-shrink #skenav ul ul li.current-menu-item a, 
		#header.skehead-headernav.skehead-headernav-shrink #skenav ul ul li.current-menu-parent a, #skenav ul ul li:hover a, 
		#header.skehead-headernav.skehead-headernav-shrink #skenav ul ul.children li.current_page_item a, #skenav ul ul.children li:hover a {
			background: none repeat scroll 0 0 hsla(0, 0%, 0%, 0) !important;
			padding-left: 30px;
		}
	}
</style>

<script type="text/javascript">
jQuery(document).ready(function(){
'use strict';
	jQuery('#menu-main').sktmobilemenu({'fwidth':'<?php if(isset($mobi_menu_width)){ echo $mobi_menu_width; } ?>'});
});
</script> 