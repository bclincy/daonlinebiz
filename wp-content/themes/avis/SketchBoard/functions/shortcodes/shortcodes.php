<?php
/**
 * @package	 WordPress
 * @subpackage  Avis
 * @version	 1.0.0
 *
 * Theme Shortcode Definations.
 * Created by sketchthemes
*/
/********* SHORTCODES v.1.0 ************/
define('AVIS_SHORTCODES_VERSION', '1.0');
define('AVIS_SHORTCODES_DIR', get_template_directory_uri() . '/SketchBoard/functions/shortcodes');
add_action('wp_enqueue_scripts', 'avis_shortcodes_css');
function avis_shortcodes_css(){
	wp_enqueue_style('avis-shortcodes-css', AVIS_SHORTCODES_DIR . '/css/shortcodes.css', false, AVIS_SHORTCODES_VERSION, 'all');
	wp_enqueue_style('avis-tolltip-css', AVIS_SHORTCODES_DIR . '/css/tipTip.css', false, AVIS_SHORTCODES_VERSION, 'all');
  wp_enqueue_script('avis-tolltip-js', AVIS_SHORTCODES_DIR . '/js/jquery.tipTip.js', array('jquery'), AVIS_SHORTCODES_VERSION, true);
	wp_enqueue_script('avis-velocity-min-js', AVIS_SHORTCODES_DIR . '/js/jquery.velocity.min.js', array('jquery'), AVIS_SHORTCODES_VERSION, true);
	wp_enqueue_script('avis-dynamo-js', AVIS_SHORTCODES_DIR . '/js/dynamo.min.js', array('jquery'), AVIS_SHORTCODES_VERSION, true);
  wp_enqueue_script('avis-shortcodes-js', AVIS_SHORTCODES_DIR . '/js/shrotcodes.js', array('jquery'), AVIS_SHORTCODES_VERSION, true);
}
if (!function_exists('no_wpautop')) {
	function no_wpautop($content){ 
		$content = do_shortcode( shortcode_unautop($content) ); 
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
		return $content;
	}
  
}
/*********clear class*********/
function avis_clear( $atts, $content = null ) {
   return '<div class="clearfix">' . do_shortcode($content) . '</div>';
}
add_shortcode('clear','avis_clear');
/*********avis_container class
----------------------------------*********/
function avis_container( $atts, $content = null ) {
	$content = preg_replace('#<br \/>#', '', $content);
	 return '<div class="page-container clearfix">' . do_shortcode($content) . '</div>';
}
add_shortcode('page_container','avis_container');
/*********one_half
-----------------------------*********/
function avis_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half','avis_one_half');
/*********one_half last
---------------------------------*********/
function avis_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half_last','avis_one_half_last');
/**********avis_one_third********/
function avis_one_third( $atts, $content = null ) {
   return '<div class="one_third">'.do_shortcode($content).'</div>';
}
add_shortcode('one_third','avis_one_third');
/*********avis_one_third last*********/
function avis_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third_last','avis_one_third_last');
/*********avis_one_fourth*********/
function avis_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth','avis_one_fourth');
/*********avis_one_fourth last*********/
function avis_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth_last','avis_one_fourth_last');
/*********avis_two_third*********/
function avis_two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third','avis_two_third');
/*********avis_two_third last*********/
function avis_two_third_last( $atts, $content = null ) {
   return '<div class="two_third last">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third_last','avis_two_third_last');
/*********avis_three_fourth*********/
function avis_three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth','avis_three_fourth');
/*********avis_three_fourth last*********/
function avis_three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth last">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth_last','avis_three_fourth_last');
/********* avis_linkbutton *********/
function avis_linkbutton( $atts, $content = null ) {
	extract(shortcode_atts(array(
	'link'  => '#',
	'target'  => '',
	'size'  => '',
	'align' => '',
	'bgcolor' => '',
	'color'=>''
	), $atts));

  $align = ($align) ? ' align'.$align : '';
  $size = ($size) ? ' '.$size.'-button' : '';
  $target = ($target == 'blank') ? ' target="_blank"' : '';
  $bgcolor = ($bgcolor) ? ' '.$bgcolor : ' ';
  $color = ($color) ? ' '.$color : ' ';
  $out = '<a' .$target. ' class="button-link' .$size.$align. '" style="border-color:'.$color.';background-color:'.$bgcolor.';color:'.$color.';" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';
  return $out;
}
add_shortcode('link_button', 'avis_linkbutton');
/********* avis_tooltip *********/
function avis_tooltip( $atts, $content = null ) {
	extract(shortcode_atts(array(
	'tooltip_title'=> '' 
	), $atts));
   return '<span title="'.$tooltip_title.'" class="tooltip"><a href="javascript:void(0);">' . do_shortcode($content) . '</a></span>';
}
add_shortcode('tooltip','avis_tooltip');
/****************quote*************/
function avis_quote($atts, $content = null) {
		extract(shortcode_atts(array(
			'author'=> '',
			'link'=>'' 
	), $atts));
  return '<blockquote class="avis-quote">'. do_shortcode($content) .'<a href="'.$link.'" target="_blank"><span class="quoteauthor">'.$author.'</span></a></blockquote>';
}
add_shortcode('blockquote','avis_quote');
/****************avis_dropcaps
--------------------------------------------*************/
function avis_dropcaps($atts, $content = null) {
	extract(shortcode_atts(array(
	'type'=>'',
	'bgcolor'=>'',
	'color'=> '',
	'size'=>''	
	), $atts));
  return '<span class="avis-dropcaps '.$type.'" style="color:'.$color.';font-size:'.$size.';background-color:'.$bgcolor.';line-height:'.$size.';width:'.$size.';">'. do_shortcode($content) .'</span>';
}
add_shortcode('dropcaps','avis_dropcaps');
/**************** warning box *************/
function avis_worningbox($atts, $content = null) {
  return '<div class="notification fail cannothide" style="position: relative;"><div class="boximg warningimg"></div>'. do_shortcode($content) .'</div>';
}
add_shortcode('worningbox','avis_worningbox');
/**************** download box *************/
function avis_downloadbox($atts, $content = null) {
  return '<div class="notification success cannothide" style="position: relative;"><div class="boximg downloadimg"></div>'. do_shortcode($content) .'</div>';
}
add_shortcode('downloadbox','avis_downloadbox');
/**************** info  box *************/
function avis_infobox($atts, $content = null) {
 return '<div class="notification lock cannothide" style="position: relative;"><div class="boximg infoimg"></div>'. do_shortcode($content) .'</div>';
}
add_shortcode('infobox','avis_infobox');
/**************** normal  box *************/
function avis_normalbox($atts, $content = null) {
  return '<div class="notification download  cannothide" style="position: relative;"><div class="boximg normalimg"></div>'. do_shortcode($content) .'</div>';
}
add_shortcode('normalbox','avis_normalbox'); 
/**************** normal  box *************/
function avis_notificationbox($atts, $content = null) {
  return '<div class="notification edit cannothide" style="position: relative;"><div class="boximg notifyimg"></div>'. do_shortcode($content) .'</div>';
}
add_shortcode('notificationbox','avis_notificationbox');
/**************** notification success box *************/
function avis_notificationsuccessbox($atts, $content = null) {
	return '<div class="notification success canhide" style="position: relative;"><span>SUCCESS!</span> '. do_shortcode($content) .'<div class="icon"></div><div class="close-notification"></div></div>';
}
add_shortcode('successbox','avis_notificationsuccessbox');
/**************** notification fail box *************/
function avis_notificationerrorbox($atts, $content = null) {
	return '<div class="notification fail canhide" style="position: relative;"><span>ERROR!</span> '. do_shortcode($content) .'<div class="icon"></div><div class="close-notification"></div></div>';
}
add_shortcode('notification_error','avis_notificationerrorbox');
/**************** notification info   box *************/
function avis_notificationinfobox($atts, $content = null) {
	return '<div class="notification info canhide" style="position: relative;"><span>INFORMATION:</span>'. do_shortcode($content) .'<div class="icon"></div><div class="close-notification"></div></div>';
}
add_shortcode('notification_info','avis_notificationinfobox');
/**************** notification warning  box *************/
function avis_notificationwarningbox($atts, $content = null) {
	return '<div class="notification warning canhide" style="position: relative;"><span>WARNING!</span> '. do_shortcode($content) .'<div class="icon"></div><div class="close-notification"></div></div>';
}
add_shortcode('notification_warning','avis_notificationwarningbox');
/**************** notification download  box *************/
function avis_notificationdownloadbox($atts, $content = null) {
	return '<div class="notification download canhide" style="position: relative;"><span>DOWNLOAD:</span> '. do_shortcode($content) .'<div class="icon"></div><div class="close-notification"></div></div>';
}
add_shortcode('notification_download','avis_notificationdownloadbox');
/**************** notification chat   box *************/
function avis_notificationchatbox($atts, $content = null) {
	return '<div class="notification chat canhide" style="position: relative;"><span>HELLO!</span> '. do_shortcode($content) .'<div class="icon"></div><div class="close-notification"></div></div>';
}
add_shortcode('notification_chat','avis_notificationchatbox');
/**************** notification task box *************/
function avis_notificationtaskbox($atts, $content = null) {
	return '<div class="notification task canhide" style="position: relative;"><span>TASK!</span> '. do_shortcode($content) .'<div class="icon"></div><div class="close-notification"></div></div>';
}
add_shortcode('notification_task','avis_notificationtaskbox');
/**************** custom list *************/
function avis_custom_list($atts, $content = null) {
	extract(shortcode_atts(array(
	'type'=>''
	), $atts));
  return '<div class="custom_list '.$type.'">'. do_shortcode($content) .'</div>';
}
add_shortcode('custom_list','avis_custom_list');
/********* Google Maps Shortcode ***************/
function avis_googleMaps($atts, $content = null) {
   extract(shortcode_atts(array(
	  "width" => '640',
	  "height" => '480',
	  "src" => ''
   ), $atts));
   return '<div class="map-shortcode"><iframe width="'.$width.'" height="'.$height.'"  src="'.$src.'&amp;output=embed"></iframe></div>';
}
add_shortcode("googlemap", "avis_googleMaps");
/********* Youtube video  Shortcode ***************/
function avis_youtube($atts, $content=null){  
	extract(shortcode_atts( array('src' => '','width'=>'','height'=>''), $atts));  
	$return = $content;  
	if($content)  
	$return .= "<br /><br />";  
	preg_match_all('#(https://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i',$src,$output);
	$video_id = $output[4][0];
	$return .= '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/' . $video_id . '?wmode=opaque&amp;autohide=1" allowfullscreen></iframe>';  
	return $return;   
}  
add_shortcode('youtube', 'avis_youtube'); 
/********* vimeo video  Shortcode ***************/
function avis_vimeo($atts, $content=null){  
	extract(shortcode_atts( array('src' => '','width'=>'','height'=>''), $atts));  
	$return = $content;  
	if($content)  
		$return .= "<br /><br />";  
	$video_id = parse_vimeo($src);
	$return .= '<iframe width="'.$width.'" height="'.$height.'" src="//player.vimeo.com/video/' . $video_id . '" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';  
	return $return;   
}  
add_shortcode('vimeo', 'avis_vimeo');
/********* avis_tabwrapper  Shortcode ***************/
function avis_tabwrapper($atts, $content=null){ 
	extract(shortcode_atts( array('id' => '','itemno'=>'','orient'=>'','effect'=>''), $atts)); 
?>
	<script type="text/javascript">
		jQuery('document').ready(function(){
		  jQuery('#<?php echo $id; ?>').avis_tab({itemno:'<?php echo $itemno; ?>',orient:'<?php echo $orient; ?>',effect:<?php echo $effect; ?>});
		});
	</script>
<?php	
	$return = '<div id="'.$id.'">' . do_shortcode($content) . '</div>';  
	return $return;	
}  
add_shortcode('tabwrapper', 'avis_tabwrapper');
/********* avis_tabs  Shortcode ***************/
function avis_tabs($atts, $content=null){	   
	$return = '<ul class="avis_tabs clearfix">' . do_shortcode($content) . '</ul>';  
	return $return;	
}  
add_shortcode('tabs', 'avis_tabs');
/********* avis_tab  Shortcode ***************/
function avis_tab($atts, $content=null){	   
	$return = '<li><a href="javascript:void(0);">' . do_shortcode($content) . '</a></li>';  
	return $return;	
}  
add_shortcode('tabtxt', 'avis_tab');
/********* avis_tab_container  Shortcode ***************/
function avis_tabcontainer($atts, $content=null){	   
	$return = '<div class="avis_tab_container">' . do_shortcode($content) . '</div>';  
	return $return;	
}  
add_shortcode('tabcontainer', 'avis_tabcontainer');
/********* avis_tab_content  Shortcode ***************/
function avis_tabcontent($atts, $content=null){	   
	$return = '<div class="avis_tab_content">' . do_shortcode($content) . '</div>';  
	return $return;	
}  
add_shortcode('tabcontent', 'avis_tabcontent');
/********* avis_toggle  Shortcode ***************/
function avis_toggle($atts, $content=null){  
		extract(shortcode_atts( array('id' => '','state'=>'','effect'=>''), $atts)); 
?>
	<script type="text/javascript">
		jQuery('document').ready(function(){
		  jQuery('#<?php echo $id; ?>').avis_toggle({state:'<?php echo $state; ?>',effect:<?php echo $effect; ?>});
		});
	</script>
<?php		 
	$return = '<div id="'.$id.'">' . do_shortcode($content) . '</div>';  
	return $return;	
}  
add_shortcode('togglecontainer', 'avis_toggle');
/********* avis_tog_title  Shortcode ***************/
function avis_tog_title($atts, $content=null){  		 
	$return = '<h3 class="avis_tog_title">' . do_shortcode($content) . '</h3>';  
	return $return;	
}  
add_shortcode('togtitle', 'avis_tog_title');
/********* avis_tog_title  Shortcode ***************/
function avis_tog_content($atts, $content=null){  		 
	$return = '<div class="avis_tog_content">' . do_shortcode($content) . '</div>';  
	return $return;	
}  
add_shortcode('togcontent', 'avis_tog_content');
/********* avis_accordian  Shortcode ***************/
function avis_accordian($atts, $content=null){  
		extract(shortcode_atts( array('id' => '','hoverpause'=>'','itemno'=>'','effect'=>'','togacc'=>'','autoplay'=>'1'), $atts)); 
?>
	<script type="text/javascript">
		jQuery('document').ready(function(){
		  jQuery('#<?php echo $id; ?>').avis_accordian({hoverpause:<?php echo $hoverpause; ?>,itemno:'<?php echo $itemno; ?>',effect:<?php echo $effect; ?>,togacc:<?php echo $togacc; ?>,autoplay:<?php echo $autoplay; ?>});
		});
	</script>
<?php		 
	$return = '<div id="'.$id.'">' . do_shortcode($content) . '</div>';  
	return $return;	
}  
add_shortcode('accordiancontainer', 'avis_accordian');
/********* avis_price_table  Shortcode ***************/
if (!function_exists('avis_pricing_column')) {
	function avis_pricing_column($atts, $content = null) {
			$args = array(
				"title"		 => "",
				"price"		 => "0",
				"currency"	  => "$",
				"price_period"  => "Monthly",
				"link"		  => "",
				"target"		=> "",
				"button_text"   => "Buy Now",
				"active"		=> ""
			);
		extract(shortcode_atts($args, $atts));
		$html = ""; 
			if($target == ""){
					$target = "_self";
			}
			if($active == "yes") {
				$html .= "<div class='avis_price_table price_featured'>";
			}else{
				$html .= "<div class='avis_price_table'>";
			}
			$html .= "<div class='price_table_inner'>";
			if($active == "yes"){
					$html .= "<div class='active_best_price'><p>". __('My Best','avis') ."</p></div>";
			} 
		$html .= "<ul>";
		$html .= "<li class='cell table_title'>".strtoupper($title)."</li>";
		$html .= "<li class='prices'>";
		$html .= "<div class='price_in_table'>";
		$html .= "<sup class='value'>".$currency."</sup>";
		$html .= "<span class='price'>".$price."</span>";
		$html .= "<div class='mark'>".strtoupper($price_period)."</div>";
		$html .= "</div>";
		$html .= "</li>"; //close price li wrapper
		$html .= "<li class='sktprccont'>".no_wpautop($content)."</li>"; //append pricing table content 
		$html .="<li class='price_button'>";
		$html .= "<a class='qbutton normal' href='$link' target='$target'>".$button_text."</a>";
		$html .= "</li>"; //close button li wrapper
		$html .= "</ul>";
		$html .= "</div>"; //close price_table_inner
		$html .="</div>"; //close price_table
		return $html;
	}
}
add_shortcode('pricing_column', 'avis_pricing_column');
/********* Dynamic text rotator  Shortcode ********/
function avis_dynamic_text($atts, $content=null){  
	extract(shortcode_atts( array('id' => '','speed'=>'','delay'=>'','centered'=>'','lines'=>''), $atts)); 
	$speed	= ($speed !="") ? $speed : 300;	
	$delay	= ($delay !="") ? $delay : 1000;
	$centered = ($centered !="") ? $centered : 'left';
?>
	<script type="text/javascript">
		jQuery('document').ready(function(){
			jQuery('#<?php echo $id; ?>').dynamo({
				speed   : <?php echo $speed; ?>,
				delay   : <?php echo $delay; ?>,
				centered: '<?php echo $centered; ?>',
				lines   : [<?php echo $lines; ?>]
			});
		});
	</script>
<?php		 
	$return = '<span id="'.$id.'">' . do_shortcode($content) . '</span>';  
	return $return;	
}  
add_shortcode('dynamic_text_rotator', 'avis_dynamic_text');
/********* avis_acc_wrap  Shortcode ***************/
function avis_acc_wrap($atts, $content=null){  		 
	$return = '<div class="avis_acc_set">' . do_shortcode($content) . '</div>';  
	return $return;	
}  
add_shortcode('accwrap', 'avis_acc_wrap');
/********* avis_acc_title  Shortcode ***************/
function avis_acc_title($atts, $content=null){  		 
	$return = '<div class="avis_acc_title">' . do_shortcode($content) . '</div>';  
	return $return;	
}  
add_shortcode('acctitle', 'avis_acc_title');
/********* avis_acc_content  Shortcode ***************/
function avis_acc_content($atts, $content=null){  		 
	$return = '<div class="avis_acc_content">' . do_shortcode($content) . '</div>';  
	return $return;	
}  
add_shortcode('acccontent', 'avis_acc_content');
/********* Horizontal Break  Shortcode ***************/
function avis_hr($atts, $content=null){  
	extract(shortcode_atts( array('color' => '','width'=>'','style'=>''), $atts)); 		 
		$return = '<div class="horizotal_break clearfix" style="border-bottom-style:'.$style.';border-bottom-color:'.$color.';border-bottom-width:'.$width.';">' . do_shortcode($content) . '</div>';  
	return $return;	
}  
add_shortcode('hr', 'avis_hr');
/********* Go to top divider  Shortcode ***************/
function avis_gototop_divider($atts, $content=null){  
	extract(shortcode_atts( array('color' => '','width'=>'','style'=>''), $atts)); 		 
		$return = '<div class="horizotal_break clearfix" style="border-bottom-style:'.$style.';border-bottom-color:'.$color.';border-bottom-width:'.$width.';"><a style="color:'.$color.';" href="JavaScript:void(0);" title="Back To Top" id="back-to-top">' . do_shortcode($content) . '</a></div>';  
	return $return;	
}  
add_shortcode('gotop', 'avis_gototop_divider');
/********* Highlighted Shortcode ***************/
function avis_highlight($atts, $content=null){  
	extract(shortcode_atts( array('bgcolor' => '','color'=>''), $atts)); 		 
		$return = '<span class="highlighted" style="background-color:'.$bgcolor.';color:'.$color.';">' . do_shortcode($content) . '</span>';  
	return $return;	
}  
add_shortcode('highlighted', 'avis_highlight');
/*********Share bar shortcode****************/
function avis_share($atts, $content=null){  
extract(shortcode_atts( array('type' => ''), $atts)); 		
?>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "982f4ac7-8284-472b-a36a-6af95d0f6889", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<?php	
		$return = "<div class='avis_sharebar'>
					<span class='st_sharethis_".$type."' displayText='ShareThis'></span>
					<span class='st_facebook_".$type."' displayText='Facebook'></span>
					<span class='st_twitter_".$type."' displayText='Tweet'></span>
					<span class='st_googleplus_".$type."' displayText='Google +'></span>
					<span class='st_linkedin_".$type."' displayText='LinkedIn'></span>
					<span class='st_pinterest_".$type."' displayText='Pinterest'></span>
					<span class='st_email_".$type."' displayText='Email'></span></div>";  
	return $return;	
}  
add_shortcode('share_icon', 'avis_share');
/*********avis counter ****************/
function avis_counter($attributes, $content) {
		$attributes = shortcode_atts(
			array(
				'icon_class' => '',
				'count' => '99',
				'suffix' => '',
				'prefix' => '',
				'color' => '',
				'title' => '',
			), $attributes);
		$output = 	'<div class="avis-counter span3 fade_in_hide element_fade_in" data-count="'.$attributes['count'].'" data-prefix="'.$attributes['prefix'].'" data-suffix="'.$attributes['suffix'].'" style="color:'.$attributes['color'].';">
						<div class="avis-counter-h">
							<i class="fa '.$attributes['icon_class'].'"></i>
							<div class="avis-counter-number">'.$attributes['prefix'].$attributes['count'].$attributes['suffix'].'</div>
							<h6 class="avis-counter-title" style="color:'.$attributes['color'].';">'.$attributes['title'].'</h6>
						</div>
					</div>';
		return $output;
}
add_shortcode('avis_counter','avis_counter');

/* ---------------------------------------------------------------------------
* Progress Bars [avis_progress_bars id='' title='' value='' ][/avis_progress_bars]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'avis_progress_bars' ) )
{
  function avis_progress_bars( $attr, $content = null )
  {
	extract(shortcode_atts(array(
	  'id' => '',
	  'title' => '',
	  'value' => ''
	), $attr));
  
	$output = '<div id="'. $id .'" class="avis-progress-bars avis_animate_when_almost_visible avis_bottom-to-top">';
	  $output .= '<div class="avis-number-pb"><div class="avis-number-pb-shown dream"></div>';
	  $output .= '<div class="avis-number-pb-num">'. $value .'%</div>';
	$output .= '</div>';
	if( $title ) $output .= '<h3 class="avis-progress-title">'. $title .'</h3>';
	$output .= '</div>'."\n";
?>
<script type="text/javascript">
jQuery('document').ready(function(){
var waypoints = jQuery('#<?php echo $id; ?> .avis-number-pb').waypoint(function(direction) { 
  jQuery(function() {
	var percentageBar = jQuery('#<?php echo $id; ?> .avis-number-pb').NumberProgressBar({
	  style: 'percentage',
	  current: <?php echo $value; ?>
	})
  });

}, {
  offset: '90%'
})

});
</script>
<?php
	return $output;
  }
}
add_shortcode( 'avis_progress_bars', 'avis_progress_bars' );