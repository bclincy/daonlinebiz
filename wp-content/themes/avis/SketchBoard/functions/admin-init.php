<?php
/**
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
 * Include theme function, enqueue and other section.
 * Created by sketchthemes
*/

/********************************************
 FRAME WORK CODE STARTS HERE
*********************************************/
/********************************************
 THEME VARIABLES
*********************************************/
global $avis_themename;
global $avis_shortname;
require_once(get_template_directory().'/SketchBoard/functions/avis-functions.php');			   	 		// PAGINATION, EXCERPT CONTROL ETC.
require_once(get_template_directory().'/SketchBoard/functions/avis-enqueue.php');				  			// ENQUEUE CSS SCRIPTS
require_once(get_template_directory().'/SketchBoard/functions/avis-breadcrumb.php');			   			// INCLUDE BREADCRUMB
require_once(get_template_directory().'/SketchBoard/functions/avis-frontpage-sections-order.php');			// FRONTPAGE SECTIONS ORDER
require_once(get_template_directory().'/SketchBoard/functions/post-types/avis-post-type-portfolio.php');   	// PORTFOLIO CUSTOM POST-TYPE
require_once(get_template_directory().'/SketchBoard/functions/post-types/avis-post-type-testimonial.php');  // TESTIMONIAL CUSTOM POST-TYPE
require_once(get_template_directory().'/SketchBoard/functions/post-types/avis-post-type-team-member.php');  // TEAM MEMBER CUSTOM POST-TYPE
require_once(get_template_directory().'/SketchBoard/functions/shortcodes/shortcodes.php');		   			// SHORTCODE INCLUDES
require_once(get_template_directory().'/SketchBoard/functions/widgets/include-widgets.php');		 			// INCLUDES WIDGET