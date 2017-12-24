<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Website Header Template
 * Created by sketchthemes
*/
?><!DOCTYPE html>
<?php global $avis_shortname, $avis_themename; ?>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php wp_head(); ?>
<?php $avis_custom_css = avis_get_option($avis_shortname.'_custom_css'); ?>	
<?php if($avis_custom_css){ ?>
<!--  Custom CSS Section Starts Here -->
<style type="text/css">
	<?php echo $avis_custom_css; ?>
</style>
<!--  Custom CSS Section Ends Here -->
<?php } 

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
</head>

<body <?php body_class(); ?> >
<div id="wrapper" class="skepage">
<div id="top-header">
	<div class="custom_third_wrapper">
		<div class="container">
			<div class="row-fluid">
				<div class="copyright span6 alpha omega"> 
					<p>Phone: (800)-269-211&nbsp;&nbsp;&nbsp;Email: info@trueusers.com</p>
				</div>
				<div class="owner span6 alpha omega">
					<!-- Footer Follow Us Section Start -->
						<div class="social-icons">
							<?php if($avis_facebook){?><li class="fb-icon"><a href="<?php echo esc_url($avis_facebook); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
							<?php if($avis_flickr){?><li class="flickr-icon"><a href="<?php echo esc_url($avis_flickr); ?>" target="_blank"><i class="fa fa-flickr"></i></a></li><?php } ?>							
							<?php if($avis_linkedin){?><li class="linkedin-icon"><a href="<?php echo esc_url($avis_linkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
							<?php if($avis_gpluseone){?><li class="gplus-icon"><a href="<?php echo esc_url($avis_gpluseone); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
							<?php if($avis_twitter){?><li class="tw-icon"><a href="<?php echo esc_url($avis_twitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
							<?php if($avis_vk){?><li class="vk-icon"><a href="<?php echo esc_url($avis_vk); ?>" target="_blank"><i class="fa fa-vk"></i></a></li><?php } ?>
							<?php if($avis_pinterest){?><li class="pinterest-icon"><a href="<?php echo esc_url($avis_pinterest); ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li><?php } ?>
							<?php if($avis_instagram){?><li class="instagram-icon"><a href="<?php echo esc_url($avis_instagram); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
						</div>
					<!-- Footer Follow Us Section End -->
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div><!-- custom_third_wrapper --> 
</div>	
<div id="main-head-wrap" class="clearfix">

	<?php   
		$frontslider_set_meta =''; 
		if( is_page_template('template-front-page.php')  ) { 
			$frontslider_set_meta = get_post_meta( $post->ID,'_home_slider_type',true );  // get slider meta for front page slider section
		}
	?>

	<!-- // header_wrap -->
	<div id="header_wrap">
		<div id="header" class="skehead-headernav clearfix">
			<div class="glow">
				<div id="skehead">
					<div class="container">	  
						<div class="row-fluid">	  
							<!-- #logo -->
							<div id="logo" class="span4">
								<?php if(avis_get_option($avis_shortname."_logo_img")){ ?>
									<div class="logo_inner">
										<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>" style="display: table;line-height: 0;" ><img class="logo" src="<?php echo avis_get_option($avis_shortname."_logo_img"); ?>" alt="<?php echo avis_get_option($avis_shortname."_logo_alt"); ?>" /></a>
									</div>
								<?php } else{ ?>
								<!-- #description -->
									<div id="site-title" class="logo_desp logo_inner">
										<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name') ?>" ><?php bloginfo('name'); ?></a>
										<div id="site-description"><?php bloginfo( 'description' ); ?></div>
									</div>
								<!-- #description -->
								<?php } ?>
							</div>
							<!-- #logo -->
							
							<!-- .top-nav-menu --> 
							<div class="top-nav-menu span8">
							
								<!-- Header Search Icon// -->
								<div class="top_search span1">						
									<ul class="nav-search-icon">
										<li>
											<a href="javascript:void(0);" class="strip-icon search-strip" title="search"><i class="fa fa-search"></i></a>
											<!-- search-strip -->
											<div class="hsearch" >
												<div class="container">
													<div class="row-fluid">
														<form method="get" id="header-searchform" action="<?php echo home_url('/'); ?>">
															<fieldset>
																<input type="text" value="" placeholder="Search Here ..." id="s" name="s">
																<input type="submit" value="Search" id="header-searchsubmit">
															</fieldset>
														</form>
													</div>
												</div>
											</div>
											<!-- search-strip -->
										</li>
									</ul>
								</div>
								<!-- Header Search Icon -->
								<div class="top-nav-menubar span11">
									<?php 
										if( function_exists( 'has_nav_menu' ) && has_nav_menu( 'Header' ) ) {
											wp_nav_menu(array( 'container_class' => 'avis-menu', 'container_id' => 'skenav', 'menu_id' => 'menu-main','menu' => 'Primary Menu','theme_location' => 'Header' )); 
										} else {
									?>
									<div class="avis-menu" id="skenav">
										<ul id="menu-main" class="menu">
											<?php wp_list_pages('title_li=&depth=0'); ?>
										</ul>
									</div>
									<?php } ?>
								</div>

							</div>
							<!-- .top-nav-menu --> 
						</div>
					</div>
				</div>
				<!-- #skehead -->
			</div>
			<!-- glow --> 
		</div>
		<div class="header-clone"></div>
	</div>
	<!-- header_wrap \\ -->

	<?php if( !(is_page_template('template-front-page.php')) ) { ?>
		<!-- BreadCrumb Section // -->
		<div class="bread-title-holder">
			<div class="container">
				<div class="row-fluid">
					<div class="container_inner clearfix">
						<h1 class="title">

							<?php if( is_page_template( 'archives.php' ) ) {

									if ( is_day() ) :
										printf( __( 'Daily Archives : <span>%s</span>', 'avis' ), get_the_date() );
									elseif ( is_month() ) :
										printf( __( 'Monthly Archives : <span>%s</span>', 'avis' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'avis' ) ) );
									elseif ( is_year() ) :
										printf( __( 'Yearly Archives : <span>%s</span>', 'avis' ), get_the_date( _x( 'Y', 'yearly archives date format', 'avis' ) ) );
									else :
										_e( 'Blog Archives', 'avis' );
									endif;

								} else if (is_author()) {

									$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
									_e('Author Archives : ','avis'); echo $curauth->display_name;


								} elseif (is_category()) { 

									printf( __( 'Category Archives : %s', 'avis' ), '<span>' . single_cat_title( '', false ) . '</span>' );

								} elseif (is_search()) {

									printf( __( 'Search Results for : %s', 'avis' ), '<span>' . get_search_query() . '</span>' );

								} elseif (is_tag()) {

									printf( __( 'Tag Archives : %s', 'avis' ), '<span>' . single_tag_title( '', false ) . '</span>' );

								} elseif (is_home()) {

									if (avis_get_option($avis_shortname.'_blogpage_heading')) { echo avis_get_option($avis_shortname.'_blogpage_heading'); }

								} elseif (is_404()) {

									_e('404', 'avis');

								} else{ 

									the_title();

								}
							?>
						<p class="title-seperator"><span></span></p>
						</h1>
						<?php if ((class_exists('avis_breadcrumb_class'))) { $avis_breadcumb = new avis_breadcrumb_class(); $avis_breadcumb->custom_breadcrumb();} ?>
					</div>
				</div>
			</div>
		</div>
		<!-- \\ BreadCrumb Section -->
<?php } ?>

</div>

<?php
	if( is_page_template('template-front-page.php')  ) { 
		$frontslider_set_meta = get_post_meta( $post->ID,'_home_slider_type',true );		
		if($frontslider_set_meta === 'revslider'){ get_template_part("includes/front-rev-slider-section"); }		
		else if($frontslider_set_meta === 'bgimage'){ get_template_part("includes/front-bgimage-section"); }	
	}
?>
<div id="main" class="clearfix">