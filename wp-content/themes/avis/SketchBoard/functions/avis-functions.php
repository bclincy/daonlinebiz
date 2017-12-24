<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Define Theme Functions.
 * Created by sketchthemes
*/

global $avis_themename;
global $avis_shortname;

if ( !class_exists( 'OT_Loader' )){	
	//THEME SHORTNAME	
	$avis_shortname = 'avis';	
	$avis_themename = 'Avis';	
	define('AVIS_ADMIN_MENU_NAME','Avis');
}

/***************** EXCERPT LENGTH ************/
function avis_excerpt_length($length) {
	return 50;
}
add_filter('excerpt_length', 'avis_excerpt_length');


/***************** READ MORE ****************/
function avis_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'avis_excerpt_more');


/********************************************
 PAGINATION
*********************************************
 * Retrieve or display pagination code.
 *
 * The defaults for overwriting are:
 * 'page' - Default is null (int). The current page. This function will
 *	  automatically determine the value.
 * 'pages' - Default is null (int). The total number of pages. This function will
 *	  automatically determine the value.
 * 'range' - Default is 3 (int). The number of page links to show before and after
 *	  the current page.
 * 'gap' - Default is 3 (int). The minimum number of pages before a gap is 
 *	  replaced with ellipses (...).
 * 'anchor' - Default is 1 (int). The number of links to always show at begining
 *	  and end of pagination
 * 'before' - Default is '<div class="emm-paginate">' (string). The html or text 
 *	  to add before the pagination links.
 * 'after' - Default is '</div>' (string). The html or text to add after the
 *	  pagination links.
 * 'title' - Default is '__('Pages:', 'avis')' (string). The text to display before the
 *	  pagination links.
 * 'next_page' - Default is '__('&raquo;', 'avis')' (string). The text to use for the 
 *	  next page link.
 * 'previous_page' - Default is '__('&laquo', 'avis')' (string). The text to use for the 
 *	  previous page link.
 * 'echo' - Default is 1 (int). To return the code instead of echo'ing, set this
 *	  to 0 (zero).
 *
 *
 * @param array|string $args Optional. Override default arguments.
 * @return string HTML content, if not displaying.
 *  
 * Usage:
 * 
 * <?php if (function_exists("avis_paginate")) { avis_paginate(); } ?>
* 
*/

function avis_paginate($args = null) {
	global $avis_themename, $avis_shortname;
	$defaults = array(
		'page'   => null, 
		'pages'  => null, 
		'range'  => 3, 
		'gap'	=> 3, 
		'anchor' => 1,
		'before' => '<div id="'.$avis_shortname.'-paginate">', 
		'after'  => '<div class="clear"></div></div>',
		'title'  => __('', 'avis'),
		'nextpage' => __('<i class="fa fa-angle-right"></i>', 'avis'), 
		'previouspage' => __('<i class="fa fa-angle-left"></i>', 'avis'),
		'echo' => 1
	);
	
	$r = wp_parse_args($args, $defaults);
	extract($r, EXTR_SKIP);
	if (!$page && !$pages) {
		global $wp_query;
		$page = get_query_var('paged');
		$page = !empty($page) ? intval($page) : 1;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$pages = intval(ceil($wp_query->found_posts / $posts_per_page));
	}

	$output = "";

	if ($pages > 1) {	
		$output .= "$before<span class='$avis_shortname-title'>$title</span>";
		$ellipsis = "<span class='$avis_shortname-gap'>...</span>";
		if ($page > 1 && !empty($previouspage)) {
			$output .= "<a href='" . get_pagenum_link($page - 1) . "' class='$avis_shortname-prev'>$previouspage</a>";
		}

		$min_links = $range * 2 + 1;
		$block_min = min($page - $range, $pages - $min_links);
		$block_high = max($page + $range, $min_links);
		$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;
		$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;

		if ($left_gap && !$right_gap) {
			$output .= sprintf('%s%s%s', 
				avis_paginate_loop(1, $anchor), 
				$ellipsis, 
				avis_paginate_loop($block_min, $pages, $page)
			);
		}
		else if ($left_gap && $right_gap) {
			$output .= sprintf('%s%s%s%s%s', 
				avis_paginate_loop(1, $anchor), 
				$ellipsis, 
				avis_paginate_loop($block_min, $block_high, $page), 
				$ellipsis, 
				avis_paginate_loop(($pages - $anchor + 1), $pages)
			);
		}
		else if ($right_gap && !$left_gap) {
			$output .= sprintf('%s%s%s', 
				avis_paginate_loop(1, $block_high, $page),
				$ellipsis,
				avis_paginate_loop(($pages - $anchor + 1), $pages)
			);
		}
		else {
			$output .= avis_paginate_loop(1, $pages, $page);
		}
		if ($page < $pages && !empty($nextpage)) {
			$output .= "<a href='" . get_pagenum_link($page + 1) . "' class='$avis_shortname-next'>$nextpage</a>";
		}
		$output .= $after;
	}
	if ($echo) {
		echo $output;
	}
	return $output;
}

/**
 * Helper function for pagination which builds the page links.
 *
 * @access private
 *
 * @param int $start The first link page.
 * @param int $max The last link page.
 * @return int $page Optional, default is 0. The current page.
 */

function avis_paginate_loop($start, $max, $page = 0) {
	global $avis_themename, $avis_shortname;
	$output = "";
	for ($i = $start; $i <= $max; $i++) {
		$output .= ($page === intval($i)) 
		? "<span class='$avis_shortname-page $avis_shortname-current'>$i</span>" 
		: "<a href='" . get_pagenum_link($i) . "' class='$avis_shortname-page'>$i</a>";
	}
	return $output;
}

/**
 * SETS UP THE CONTENT WIDTH VALUE BASED ON THE THEME'S DESIGN.
 */

if ( ! isset( $content_width ) ){
	$content_width = 900;
}

/*************************************************
 Redirect to Theme setting page after activation
**************************************************/
if(is_admin() && isset($_GET['activated']) && $pagenow =='themes.php'){
	//Do redirect
	global $avis_shortname;
	header( 'Location: '.admin_url().'themes.php?page=ot-theme-options' ) ;
}

/********************************************************
	#DEFINE REQUIRED CONSTANTS HERE# &
	#OPTIONAL: SET 'OT_SHOW_PAGES' FILTER TO FALSE#.
	#THIS WILL HIDE THE SETTINGS & DOCUMENTATION PAGES.#
*********************************************************/

//CHECK AND FOUND OUT THE THEME VERSION AND ITS BASE NAME

if(function_exists('wp_get_theme')){
	$avis_theme_data = wp_get_theme(get_option('template'));
	$avis_theme_version = $avis_theme_data->Version;  
} else {
	$avis_theme_data = get_theme_data( get_template_directory(). '/style.css');
	$avis_theme_version = $avis_theme_data['Version'];
} 

define( 'AVIS_OPTS_FRAMEWORK_DIRECTORY_URI', trailingslashit(get_template_directory_uri() . '/SketchBoard/includes/') );	
define( 'AVIS_OPTS_FRAMEWORK_DIRECTORY_PATH', trailingslashit(get_template_directory() . '/SketchBoard/includes/') );
define( 'AVIS_THEME_VERSION',$avis_theme_version);	
	
add_filter( 'ot_show_pages', '__return_false' );

// REQUIRED: SET 'OT_THEME_MODE' FILTER TO TRUE.
add_filter( 'ot_theme_mode', '__return_true' );

// DISABLE ADD NEW LAYOUT SECTION FROM OPTIONS PAGE.
add_filter( 'ot_show_new_layout', '__return_false' );

// REQUIRED: INCLUDE OPTIONTREE.
require_once get_template_directory() . '/SketchBoard/includes/ot-loader.php';

// THEME OPTIONS
require_once get_template_directory() . '/SketchBoard/includes/options/theme-options.php';


/********************************************
	GET THEME OPTIONS VALUE FUNCTION
*********************************************/
function avis_get_option( $option_id, $default = '' ){
	return ot_get_option( $option_id, $default = '' );
}


function avis_bg_style($background) {
	$bg_style = NULL;

	if ($background) {
		if($background['background-image']){
			
			$bg_style = 'background:';
			
			if ($background['background-color']) {
				$bg_style .= $background['background-color'];
			}
			if ($background['background-image']) {
				$bg_style .= ' url('.$background['background-image'].')';
			}
			if ($background['background-repeat']) {
				$bg_style .= ' '.$background['background-repeat'];
			}
			if ($background['background-attachment']) {
				$bg_style .= ' '.$background['background-attachment'];
			}
			if ($background['background-position']) {
				$bg_style .= ' '.$background['background-position'];
			}
			if ($background['background-size']) {
				$bg_style .= ' / '.$background['background-size']. ';';
			}

		} else{
			if ($background['background-color']) {
				$bg_style .= 'background:'.$background['background-color'];
			}
		}
	}

	return $bg_style;
}


/*************************************************
*  THEME OPTIONS BACKUP SECTION
**************************************************/

/**
 * IMPORT EXPORT THEME OPTIONS
 */
add_action( 'init', 'register_options_pages' );

/**
 * Registers all the required admin pages.
 */
function register_options_pages() {

  // Only execute in admin & if OT is installed
  if ( is_admin() && function_exists( 'ot_register_settings' ) ) {
	// Register the pages
	ot_register_settings( 
	  array(
		array( 
		  'id'			  => 'import_export',
		  'pages'		   => array(
			array(
			  'id'			 => 'import_export',
			  'parent_slug'	=> 'themes.php',
			  'page_title'	 => AVIS_ADMIN_MENU_NAME.' Options Backup/Restore',
			  'menu_title'	 => AVIS_ADMIN_MENU_NAME.' Backup',
			  'capability'	 => 'edit_theme_options',
			  'menu_slug'	  => 'tmq-theme-backup',
			  'icon_url'	   => null,
			  'position'	   => null,
			  'updated_message'=> 'Options updated.',
			  'reset_message'  => 'Options reset.',
			  'button_text'	=> 'Save Changes',
			  'show_buttons'   => false,
			  'screen_icon'	=> 'themes',
			  'contextual_help'=> null,
			  'sections'	   => array(
				array(
				  'id'		 => 'tmq_import_export',
				  'title'	  => __( 'Import/Export', 'avis' )
				)
			  ),
			  'settings'	   => array(
				array(
					'id'	   => 'import_data_text',
					'label'	=> 'Import Theme Options',
					'desc'	 => __( 'Theme Options', 'avis' ),
					'std'	  => '',
					'type'	 => 'import-data',
					'section'  => 'tmq_import_export',
					'rows'	 => '',
					'post_type'=> '',
					'taxonomy' => '',
					'class'	=> ''
				),
				array(
					'id'	   => 'export_data_text',
					'label'	=> 'Export Theme Options',
					'desc'	 => __( 'Theme Options', 'avis' ),
					'std'	  => '',
					'type'	 => 'export-data',
					'section'  => 'tmq_import_export',
					'rows'	 => '',
					'post_type'=> '',
					'taxonomy' => '',
					'class'	=> ''
				)
			  )
			)
		  )
		)
	  )
	);
  }
}

/**
 * Import Data option type.
 *
 * @return	string
 *
 * @access	public
 * @since	 2.0
 */
if ( ! function_exists( 'ot_type_import_data' ) ) {

	function ot_type_import_data() {

		echo '<form method="post" id="import-data-form">';

		/* form nonce */
		wp_nonce_field( 'import_data_form', 'import_data_nonce' );

		/* format setting outer wrapper */
		echo '<div class="format-setting type-textarea has-desc">';

		/* description */
		echo '<div class="description">';

		if ( OT_SHOW_SETTINGS_IMPORT ) {
			echo '<p>' . __( 'Only after you\'ve imported the Settings should you try and update your Theme Options.', 'option-tree' ) . '</p>';
		}
		
		echo '<p>' . __( 'To import your Theme Options copy and paste what appears to be a random string of alpha numeric characters into this textarea and press the "Import Theme Options" button.', 'option-tree' ) . '</p>';
		/* button */
		echo '<button class="option-tree-ui-button blue right hug-right">' . __( 'Import Theme Options', 'option-tree' ) . '</button>';
		echo '</div>';

		/* textarea */
		echo '<div class="format-setting-inner">';
		echo '<textarea rows="10" cols="40" name="import_data" id="import_data" class="textarea"></textarea>';
		echo '</div>';
		echo '</div>';
		echo '</form>';
	}

}

/**
 * Export Data option type.
 *
 * @return	string
 *
 * @access	public
 * @since	 2.0
 */
if ( ! function_exists( 'ot_type_export_data' ) ) {

	function ot_type_export_data() {

		/* format setting outer wrapper */
		echo '<div class="format-setting type-textarea simple has-desc">';

		/* description */
		echo '<div class="description">';
		echo '<p>' . __( 'Export your Theme Options data by highlighting this text and doing a copy/paste into a blank .txt file. Then save the file for importing into another install of WordPress later.', 'option-tree' ) . '</p>';
		echo '</div>';

		/* get theme options data */
		$data = get_option( 'option_tree' );
		$data = ! empty( $data ) ? ot_encode( serialize( $data ) ) : '';

		echo '<div class="format-setting-inner">';
		echo '<textarea rows="10" cols="40" name="export_data" id="export_data" class="textarea">' . $data . '</textarea>';
		echo '</div>';
		echo '</div>';
		
	}
}

/*********************************************
*  TO CHECK IF A PAGE TEMPLATE IS ACTIVE
*********************************************/
function is_pagetemplate_active($pagetemplate = '')
{
	global $wpdb;
	$sql = "select meta_key from $wpdb->postmeta where meta_key like '_wp_page_template' and meta_value like '" . $pagetemplate . "'";
	$result = $wpdb->query($sql);
	if ($result){
		return TRUE;
	}
	else {
		return FALSE;
	}
}

/*********************************************
*   LIMIT WORDS
*********************************************/
function avis_slider_limit_words($string, $word_limit) {
	$words = explode(' ', $string);
	return implode(' ', array_slice($words, 0, $word_limit));
}

/********************************************
	ADD REVOLUTION SLIDER SELECT OPTION
*********************************************/
function add_revslider_select_type( $array ) {
	$array['revslider-select'] = 'Revolution Slider Select';
	return $array;
}
add_filter( 'ot_option_types_array', 'add_revslider_select_type' ); 

// Show RevolutionSlider select option
function ot_type_revslider_select( $args = array() ) {
	extract( $args );
	$has_desc = $field_desc ? true : false;
	
	echo '<div class="format-setting type-revslider-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
	echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
	echo '<div class="format-setting-inner">';
	
	// Add This only if RevSlider is Activated
	if ( class_exists( 'RevSliderAdmin' ) ) {
		echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';

		/* get revolution array */
		$slider = new RevSlider();
		$arrSliders = $slider->getArrSlidersShort();

		/* has slides */
		if ( ! empty( $arrSliders ) ) {
			echo '<option value="">-- ' . __( 'Choose One', 'option-tree' ) . ' --</option>';
			foreach ( $arrSliders as $rev_id => $rev_slider ) {
				echo '<option value="' . esc_attr( $rev_id ) . '"' . selected( $field_value, $rev_id, false ) . '>' . esc_attr( $rev_slider ) . '</option>';
			}
		} else {
			echo '<option value="">' . __( 'No Sliders Found', 'option-tree' ) . '</option>';
		}
		echo '</select>';
	} else {																											
		echo '<span style="color: red;">' . __( 'Sorry! Revolution Slider is not Installed or Activated', 'avis' ). '</span>';
	}
	echo '</div>';
	echo '</div>';
}

function parse_vimeo($link){
	 
	$regexstr = '~
		# Match Vimeo link and embed code
		(?:<iframe [^>]*src=")?	   # If iframe match up to first quote of src
		(?:						 # Group vimeo url
			https?:\/\/			 # Either http or https
			(?:[\w]+\.)*			# Optional subdomains
			vimeo\.com			  # Match vimeo.com
			(?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
			\/					  # Slash before Id
			([0-9]+)				# $1: VIDEO_ID is numeric
			[^\s]*				  # Not a space
		)						   # End group
		"?						  # Match end quote if part of src
		(?:[^>]*></iframe>)?		# Match the end of the iframe
		(?:<p>.*</p>)?			  # Match any title information stuff
		~ix';
	 
	preg_match($regexstr, $link, $matches);
	 
	return $matches[1];
	 
}

function avis_postmeta(){

	$output = '.=';
	$output ?><div class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?></div>
	<div class="comment-date"><div class="comments"><?php _e('by ','avis'); ?><span class="author-name"><?php the_author_posts_link(); ?></span><?php _e(' with ','avis'); ?><span class="commentnum"><?php comments_popup_link(__('No Comments','avis'), __('1 Comment ','avis'), __('% Comments ','avis')); ?></span></div>
	<div class="date"><?php the_time('F j, Y'); ?></div></div><?php ; ?>

	<?php return $output;
}

/********************************************
	ATTACHMENT IMAGE ID
*********************************************/

function avis_get_attachment_id_from_url( $attachment_url = '' ) {

	global $wpdb;
	$attachment_id = false;

	// If there is no url, return.
	if ( '' == $attachment_url )
		return;

	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}

	return $attachment_id;
}