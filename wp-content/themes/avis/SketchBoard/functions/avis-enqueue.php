<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Enqueue Theme Styles and Javascripts.
 * Created by sketchthemes
*/

global $avis_themename;
global $avis_shortname;

/************************************************
*  ENQUQUE CSS AND JAVASCRIPT
************************************************/
//ENQUEUE JQUERY 
function avis_script_enqueqe() {
	global $avis_shortname;
	if(!is_admin()) {
		wp_enqueue_script( 'jquery-masonry' );
		wp_enqueue_script('avis_flexslider_js', get_template_directory_uri() .'/js/jquery.flexslider-min.js',array('jquery'),'1.0',1 );
		wp_enqueue_script('avis_componentssimple_slide', get_template_directory_uri() .'/js/custom.js',array('jquery'),'1.0',1 );
		wp_enqueue_script("comment-reply");
	}	
}
add_action('init', 'avis_script_enqueqe');

//ENQUEUE STYLE FOR IE BROWSER
function avis_IE_enqueue_scripts() {
	global $is_IE;
	if($is_IE ) {
		if ( !is_admin() ) {
			wp_enqueue_style( 'ie-style', get_template_directory_uri().'/css/ie-style.css', false, $theme->Version  );
			wp_enqueue_style( 'awesome-theme-stylesheet', get_template_directory_uri().'/css/font-awesome-ie7.css', false, $theme->Version  );
			wp_enqueue_script('avis_html5shiv',get_template_directory_uri().'/js/html5shiv.min.js',array('jquery'),'1.0',true );
			wp_enqueue_script('avis_respond',get_template_directory_uri().'/js/respond.min.js',array('jquery'),'1.0',true );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'avis_IE_enqueue_scripts' );

//ENQUEUE ADMIN SCRIPTS
if( !function_exists('avis_page_admin_enqueue_scripts') ){
	add_action('admin_enqueue_scripts','avis_page_admin_enqueue_scripts');
	/**
	 * Register scripts for admin panel
	 * @return void
	 */
	function avis_page_admin_enqueue_scripts(){	
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_register_script('avis-admin-script', get_template_directory_uri() .'/SketchBoard/js/avis-admin-jquery.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('avis-admin-script');
		wp_enqueue_style('thickbox');
		wp_register_style( 'avis-admin-stylesheet', get_template_directory_uri().'/SketchBoard/css/avis-admin.css', false);
		wp_enqueue_style( 'avis-admin-stylesheet' );
	}
}


//ENQUEUE FRONT SCRIPTS
function avis_theme_stylesheet()
{
	global $avis_themename;
	global $avis_shortname;
	if ( !is_admin() ) 
	{
		$theme = wp_get_theme();
		wp_enqueue_script('avis_colorboxsimple_slide',get_template_directory_uri() .'/js/jquery.prettyPhoto.js',array('jquery'),true,'1.0');
		wp_enqueue_script('avis_hoverIntent', get_template_directory_uri().'/js/hoverIntent.js',array('jquery'),true,'1.0');
		wp_enqueue_script('avis_superfish', get_template_directory_uri().'/js/superfish.js',array('jquery'),true,'1.0');
		wp_enqueue_script('avis_AnimatedHeader', get_template_directory_uri().'/js/cbpAnimatedHeader.js',array('jquery'),true,'1.0');
		wp_enqueue_script('avis_isotope_slide',get_template_directory_uri().'/js/isotope.js',array('jquery'),'1.0',true);
		wp_enqueue_script('avis_easing_slide',get_template_directory_uri().'/js/jquery.easing.1.3.js',array('jquery'),'1.0',true);
		wp_enqueue_script('avis_waypoints',get_template_directory_uri().'/js/waypoints.min.js',array('jquery'),'1.0',true );
		wp_enqueue_script('avis_carousel',get_template_directory_uri().'/js/owl.carousel.js',array('jquery'),'1.0',true );
		wp_enqueue_script('avis_modernizr',get_template_directory_uri().'/js/modernizr.custom.js',array('jquery'),'1.0',true );
		wp_enqueue_script('avis_testimonial',get_template_directory_uri().'/js/jquery.avis_testimonial_slider.js',array('jquery'),'1.0',true );



		/*CUSTOM SCROLL BAR SCRIPT*/
		 if(is_singular( 'portfolio_post' )) {
			wp_enqueue_script('mCustomscript',get_template_directory_uri().'/js/jquery.mCustomScrollbar.concat.min.js',array('jquery'),'1.0',true );
		}
		
		wp_enqueue_style( 'avis-style', get_stylesheet_uri() );
		wp_enqueue_style('avis-animation-stylesheet', get_template_directory_uri().'/css/avis-animation.css', false, $theme->Version);
		wp_enqueue_style('avis-flexslider-stylesheet', get_template_directory_uri().'/css/flexslider.css', false, $theme->Version);
		wp_enqueue_style('avis-colorbox-theme-stylesheet', get_template_directory_uri().'/css/prettyPhoto.css', false, $theme->Version);
		wp_enqueue_style( 'avis-awesome-theme-stylesheet', get_template_directory_uri().'/css/font-awesome.min.css', false, $theme->Version);
		wp_enqueue_style( 'avis-testimonial-theme-stylesheet', get_template_directory_uri().'/css/avis-testimonial-slider.css', false, $theme->Version);

		/*OWL CAROUSEL*/
		wp_enqueue_style('avis-carousel-theme-stylesheet', get_template_directory_uri().'/css/owl.carousel.css', false, $theme->Version);
		wp_enqueue_style('avis-owltheme-theme-stylesheet', get_template_directory_uri().'/css/owl.theme.css', false, $theme->Version);
		wp_enqueue_style('avis-owltransitions-theme-stylesheet', get_template_directory_uri().'/css/owl.transitions.css', false, $theme->Version);
		
		/*SUPERFISH*/
		wp_enqueue_style( 'avis-ddsmoothmenu-superfish-stylesheet', get_template_directory_uri().'/css/superfish.css', false, $theme->Version);
		wp_enqueue_style( 'avis-portfolioStyle-theme-stylesheet', get_template_directory_uri().'/css/portfolioStyle.css', false, $theme->Version);
		wp_enqueue_style( 'avis-bootstrap-responsive-theme-stylesheet', get_template_directory_uri().'/css/bootstrap-responsive.css', false, $theme->Version);
		
		/*CUSTOM SCROLL BAR*/
		 if(is_singular( 'portfolio_post' )) {
			wp_enqueue_style( 'mCustomScrollbar', get_template_directory_uri().'/css/jquery.mCustomScrollbar.css', false, $theme->Version);
		}

		/*GOOGLE FONTS*/
		wp_enqueue_style( 'googleFontsraleway','//fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,800,900', false, $theme->Version);



	}
}
add_action('wp_enqueue_scripts', 'avis_theme_stylesheet');

function avis_head() {
	global $avis_shortname;
	$avis_favicon = "";
	$avis_meta = '<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">'."\n";

	if(avis_get_option($avis_shortname.'_favicon')) {
		$avis_favicon = avis_get_option($avis_shortname.'_favicon','bizstudio');
		$avis_meta .= "<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"$avis_favicon\"/>\n";
	}
	echo $avis_meta;

	if(!is_admin()) {
		require_once(get_template_directory().'/includes/avis-custom-css.php');
	}

	/***************** Custom CSS ****************/
	$avis_custom_css = avis_get_option($avis_shortname.'_custom_css');
	if($avis_custom_css !=""){ ?>
		<style type="text/css">
			<?php 
				echo $avis_custom_css; 
			?>
		</style>
		<?php } 
	}
	add_action('wp_head', 'avis_head');

//ENQUEUE FOOTER SCRIPT 
function avis_footer_script() {
	global $avis_shortname;
	?>
	<style type="text/css">
		#main{background:none;}
		#wrapper {
			<?php #echo avis_bg_style($avis_shortname."_bg_style"); ?>
		}
	</style>
	<?php
}
add_action('wp_footer', 'avis_footer_script');