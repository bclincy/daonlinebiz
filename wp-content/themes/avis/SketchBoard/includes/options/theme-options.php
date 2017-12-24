<?php
global $avis_themename;
global $avis_shortname;

/**
 * Initialize the options before anything else. 
 */
add_action( 'admin_init', '_custom_theme_options', 1 );

/**
 * Theme Mode demo code of all the available option types.
 *
 * @return	void
 *
 * @access	private
 * @since	 2.0
 */
function _custom_theme_options() {

global $avis_themename;
global $avis_shortname;
  
   /**
	* Get a copy of the saved settings array. 
	*/
	$saved_settings = get_option( 'option_tree_settings', array() );

	// If using image radio buttons, define a directory path
	$imagepath  =  get_template_directory_uri() . '/images/';
	$sktsiteurl = home_url();
	$sktsitenm  = get_bloginfo('name');
	
	// BACKGROUND DEFAULTS
	$background_defaults = array(
		'background-color'	 => '#000000',
		'background-image'	 => '',
		'background-repeat'	=> 'repeat-y',
		'background-position'  => 'center top',
		'background-attachment'=>'fixed' 
	);
	
  /**
   * Create a custom settings array that we pass to 
   * the OptionTree Settings API Class.
   */
  $custom_settings = array(
	'contextual_help' => array(
		'content'	   => array( 
			array(
				'id'		=> 'general_help',
				'title'	 => 'General',
				'content'   => '<p>Help content goes here!</p>'
			)
		),
		'sidebar'	 => '<p>Sidebar content goes here!</p>'
		),
		'sections'		=> array(
			array(
				'title'   => __( 'General Settings', 'avis' ),
				'id'	  => 'general_default'
			),			
			array(
				'title'   => __( 'Header Settings', 'avis' ),
				'id'	  => 'header_settings'
			),	
			array(
				'title'   => __( 'Breadcrumb Settings', 'avis' ),
				'id'	  => 'breadcrumb_settings'
			),			
			array(
				'title'   => __( 'Blog Settings', 'avis' ),
				'id'	  => 'blog_settings'
			),
			array(	  
				'title'   => 'Twitter Slider',
				'id'	  => 'twitter_slider'
			),
			array(	  
				'title'   => __( 'Footer Settings', 'avis' ),
				'id'	  => 'footer_section'
			),
			array(	  
				'title'   => __( 'Custom JS', 'avis' ),
				'id'	  => 'custom_js_section'
			),		
			array(	  
				'title'   => __( 'Custom CSS', 'avis' ),
				'id'	  => 'custom_css_section'
			),
			array(	  
				'title'   => __( 'Custom Messages', 'avis' ),
				'id'	  => 'custom_messages'
			),
			array(	  
				'title'   => __( 'Shortcodes', 'avis' ),
				'id'	  => 'shortcodes_section'
			)
		),
		
		'settings'		=> array(

		//==================================================================
		// GENERAL SETTINGS SECTION STARTS =================================
		//==================================================================
		
		array(
			'id'		  => 'avis_welcome_speach',
			'label'	   => 'Welcome to Avis',
			'desc'		=> '<h1>Welcome to Avis</h1>
			<p>Thank you for using Avis. Get started below and go through the left tabs to set up your website.</p>',
			'std'		 => '',
			'type'		=> 'textblock',
			'section'	 => 'general_default',
			'rows'		=> '',
			'post_type'   => '',
			'taxonomy'	=> '',
			'class'	   => ''
		),
		array(
			'label'	   => __( 'Primary Color Scheme', 'avis'),
			'id'		  => $avis_shortname.'_primary_color_scheme',
			'type'		=> 'colorpicker',
			'desc'		=> 'Set primary theme color.',
			'std'		 => '#0bbcee',
			'section'	 => 'general_default'
		),
		array(
			'label'	   => __( 'Secondry Color Scheme', 'avis'),
			'id'		  => $avis_shortname.'_colorpicker',
			'type'		=> 'colorpicker',
			'desc'		=> 'Set secondry theme color.',
			'std'		 => '#353b48',
			'section'	 => 'general_default'
		),
		array(
			'label'	   => __( 'Upload Favicon', 'avis'),
			'id'		  => $avis_shortname.'_favicon',
			'type'		=> 'upload',
			'desc'		=> 'This creates a custom favicon for your website.',
			'std'		 => '',
			'section'	 => 'general_default'
		),
		array(
			'id'		  => $avis_shortname.'_show_pagination',
			'label'	   => __('Custom Pagination', 'avis'),
			'desc'		=> __('On/Off custom pagination on blog page.', 'avis'),
			'type'		=> 'on-off',
			'std'		 => 'on',
			'section'	 => 'general_default'
		),
		
		//------ END GENERAL SETTINGS SECTION ------------------------------

		//==================================================================
		// BREADCRUMB SETTINGS SECTION STARTS ==========================
		//==================================================================
		
		array(
			'label'	   => __( 'Choose Page Title & Breadcrumb Background Color & Image', 'avis'),
			'id'		  => $avis_shortname.'_bread_background',
			'std'		 => array(
				'background-color'	  => '#939393',
				'background-repeat'	 => 'no-repeat',
				'background-attachment' => 'scroll',
				'background-position'   => 'center center',
				'background-size'	   => 'auto',
				'background-image'	  => $imagepath.'title-bg.jpg',
			),
			'desc'		=> __( 'Upload image & color for page title background.', 'avis' ),
			'type'		=> 'background',
			'section'	 => 'breadcrumb_settings'
		),
		
		
		//==================================================================
		// HEADER SETTINGS SECTION STARTS ==================================
		//==================================================================
		
		array(
			'label'	   => __( 'Change Logo', 'avis'),
			'id'		  => $avis_shortname.'_logo_img',
			'type'		=> 'upload',
			'desc'		=> 'This creates a custom logo for your website.',
			'std'		 => $imagepath.'logo.png',
			'section'	 => 'header_settings'
		),
		array(
			'id'		  => $avis_shortname.'_logo_width',
			'label'	   => __( 'Logo Image Width (in pixel)', 'avis'),
			'desc'		=> 'Enter logo image width in pixel',
			'std'		 => '120',
			'type'		=> 'text',
			'section'	 => 'header_settings'
		),
		array(
			'id'		  => $avis_shortname.'_logo_height',
			'label'	   => __( 'Logo Image Height (in pixel)', 'avis'),
			'desc'		=> 'Enter logo image height in pixel',
			'std'		 => '39',
			'type'		=> 'text',
			'section'	 => 'header_settings'
		),
		array(
			'id'		  => $avis_shortname.'_logo_alt',
			'label'	   => __( 'Logo ALT Text', 'avis'),
			'desc'		=> 'Enter logo image alt attribute text.',
			'std'		 => 'Avis Theme',
			'type'		=> 'text',
			'section'	 => 'header_settings'
		),	
		array(
			'id'		  => $avis_shortname.'_moblie_menu',
			'label'	   => __( 'Mobile Menu Activate Width', 'avis'),
			'desc'		=> __( 'Layout width after which mobile menu will get activated', 'avis' ),
			'std'		 => '1025',
			'type'		=> 'numeric-slider',
			'section'	 => 'header_settings',
			'rows'		=> '',
			'post_type'   => '',
			'taxonomy'	=> '',
			'min_max_step'=> '100,1180,1'
		),
		array(
			'id'		  => $avis_shortname.'_persistent_on_off',
			'label'	   => __( 'Persistent (sticky) Header Navigation', 'avis' ),
			'desc'		=> sprintf( __( 'On/Off persistent (sticky) header navigation', 'avis' ), '<code>on</code>', '<code>off</code>' ),
			'std'		 => 'on',
			'type'		=> 'on-off',
			'section'	 => 'header_settings'
		),
		
		//------ END HEADER SETTINGS SECTION -------------------------------
		
		
		//==================================================================
		// BLOG SETTINGS SECTION STARTS ====================================
		//==================================================================	

		array(
			'id'		  => $avis_shortname.'_blogpage_heading',
			'label'	   => __( 'Enter Blog Page Title', 'avis'),
			'desc'		=> 'Enter Blog Page Title text.',
			'std'		 => 'Blog',
			'type'		=> 'text',
			'section'	 => 'blog_settings'
		),
			
		//------ END BLOG SETTINGS SECTION ---------------------------------


		//==================================================================
		// TWITTER SLIDER SECTION STARTS ===================================
		//==================================================================
		

		array(
			'id'		  => 'avis_twitter_slider',
			'label'	   => 'Twitter Slider',
			'desc'		=> '<h2>Twitter Slider</h2>',
			'std'		 => '',
			'type'		=> 'textblock',
			'section'	 => 'twitter_slider',
		),
		array(
			'id'		  => 'twitter_configuration',
			'label'	   => 'Twitter Configuration Info',
			'desc'		=> '<h2><b>Twitter Configuration Info</b></h2>
			<p>More information on Twiiter api keys and how to get them, read this <a href="http://www.sketchthemes.com/tutorials/getting-new-twitter-api-consumer-and-secret-keys/" target="_blank">http://www.sketchthemes.com/tutorials/getting-new-twitter-api-consumer-and-secret-keys/</a> tutorial to find out..</p>',
			'std'		 => '',
			'type'		=> 'textblock',
			'section'	 => 'twitter_slider',
		),
		array(
			'id'		  => $avis_shortname.'_cachetime',
			'label'	   => __( 'Cache Tweets(In Minutes)', 'avis'),
			'desc'		=> 'Cache tweets(in minutes).',
			'std'		 => '1',
			'type'		=> 'text',
			'section'	 => 'twitter_slider'
		),
		array(
			'id'		  => $avis_shortname.'_tws_no_twitts',
			'label'	   => __( 'Number of Latest Tweets Display', 'avis'),
			'desc'		=> 'Number of latest tweets display.',
			'std'		 => '10',
			'type'		=> 'text',
			'section'	 => 'twitter_slider'
		),
		array(
			'id'		  => $avis_shortname.'_tw_username',
			'label'	   => __( 'Twitter Username', 'avis'),
			'desc'		=> 'Enter twitter username.',
			'std'		 => 'sketchthemes',
			'type'		=> 'text',
			'section'	 => 'twitter_slider'
		),
		array(
			'id'		  => $avis_shortname.'_twitter_consumer',
			'label'	   => __( 'API Key', 'avis'),
			'desc'		=> 'Enter consumer key.',
			'std'		 => '',
			'type'		=> 'text',
			'section'	 => 'twitter_slider'
		),
		array(
			'id'		  => $avis_shortname.'_twitter_con_s',
			'label'	   => __( 'API Secret Key', 'avis'),
			'desc'		=> 'Enter consumer secret key.',
			'std'		 => '',
			'type'		=> 'text',
			'section'	 => 'twitter_slider'
		),
		array(
			'id'		  => $avis_shortname.'_twitter_acc_t',
			'label'	   => __( 'Access Token Key', 'avis'),
			'desc'		=> 'Enter access token key.',
			'std'		 => '',
			'type'		=> 'text',
			'section'	 => 'twitter_slider'
		),
		array(
			'id'		  => $avis_shortname.'_twitter_acc_t_s',
			'label'	   => __( 'Access Token Secret Key', 'avis'),
			'desc'		=> 'Enter access token secret key.',
			'std'		 => '',
			'type'		=> 'text',
			'section'	 => 'twitter_slider'
		),
		
		array(
			'id'		  => 'twitter_slider_settings',
			'label'	   => 'Twitter Slider Configuration',
			'desc'		=> '<h2><b>Twitter Slider Configuration</b></h2>
			<p>Please make the slider setttings according to your requirements.</p>',
			'std'		 => '',
			'type'		=> 'textblock',
			'section'	 => 'twitter_slider',
		),
		array(
			'id'		  => $avis_shortname.'_tws_effect',
			'label'	   => __( 'Animation (Effect)', 'avis' ),
			'desc'		=> __( 'Set slider animation effect.', 'avis' ),
			'std'		 => 'fade',
			'type'		=> 'radio',
			'section'	 => 'twitter_slider',
			'choices'	 => array( 
				array(
					'value'	   => 'fade',
					'label'	   => __( 'Fade', 'avis' ),
					'src'		 => ''
				),
				array(
					'value'	   => 'slide',
					'label'	   => __( 'Slide', 'avis' ),
					'src'		 => ''
				)
			)
		),
		array(
			'id'		  => $avis_shortname.'_tws_delay',
			'label'	   => __( 'Time Delay', 'avis'),
			'desc'		=> __( 'Set time between slide transitions (<b>in milliseconds</b>)', 'avis' ),
			'std'		 => '7000',
			'type'		=> 'numeric-slider',
			'section'	 => 'twitter_slider',
			'min_max_step'=> '0,100000,100',
		),
		array(
			'id'		  => $avis_shortname.'_tws_speed',
			'label'	   => __( 'Animation Speed', 'avis'),
			'desc'		=> __( 'Set speed of the transition (<b>in milliseconds</b>)', 'avis' ),
			'std'		 => '600',
			'type'		=> 'numeric-slider',
			'section'	 => 'twitter_slider',
			'min_max_step'=> '0,10000,10',
		),
		array(
			'id'		  => $avis_shortname.'_tws_autoplay',
			'label'	   => __('Auto Play (on/off)', 'avis'),
			'desc'		=> __('On/Off animate automatically', 'avis'),
			'type'		=> 'on-off',
			'section'	 => 'twitter_slider',
			'std'		 => 'on'
		),
		array(
			'id'		  => $avis_shortname.'_tws_pause',
			'label'	   => __('Pause on Hover (on/off)', 'avis'),
			'desc'		=> __('On/Off pause on Hover', 'avis'),
			'type'		=> 'on-off',
			'section'	 => 'twitter_slider',
			'std'		 => 'on'
		),		
		
	
		//------ END TWITTER SLIDER SECTION --------------------------------

		
		//==================================================================
		// FOOTER SETTINGS SECTION STARTS ==================================
		//==================================================================
		
		array(
			'id'		  => 'avis_social_box',
			'label'	   => 'Footer Social Box',
			'desc'		=> '<h2>Footer Social Box</h2>',
			'std'		 => '',
			'type'		=> 'textblock',
			'section'	 => 'footer_section',
		),
		array(
			'label'	   => 'Facebook Link',
			'id'		  => $avis_shortname.'_fbook_link',
			'type'		=> 'text',
			'desc'		=> 'Enter Facebook Link.',
			'std'		 => '#',
			'section'	 => 'footer_section'
		),
		array(
			'label'	   => 'Flickr Link',
			'id'		  => $avis_shortname.'_flickr_link',
			'type'		=> 'text',
			'desc'		=> 'Enter Flickr link.',
			'std'		 => '#',
			'section'	 => 'footer_section'
		),
		array(
			'label'	   => 'Linkedin Link',
			'id'		  => $avis_shortname.'_linkedin_link',
			'type'		=> 'text',
			'desc'		=> 'Enter Linkedin link.',
			'std'		 => '#',
			'section'	 => 'footer_section'
		),
		array(
			'label'	   => 'Google Plus Link',
			'id'		  => $avis_shortname.'_gplus_link',
			'type'		=> 'text',
			'desc'		=> 'Enter Google plus Id.',
			'std'		 => '#',
			'section'	 => 'footer_section'
		),
		array(
			'label'	   => 'Twitter Link',
			'id'		  => $avis_shortname.'_twitter_link',
			'type'		=> 'text',
			'desc'		=> 'Enter Twitter link.',
			'std'		 => '#',
			'section'	 => 'footer_section'
		),
		array(
			'label'	   => 'Vk Link',
			'id'		  => $avis_shortname.'_vk_link',
			'type'		=> 'text',
			'desc'		=> 'Enter Vk link.',
			'std'		 => '#',
			'section'	 => 'footer_section'
		),
		array(
			'label'	   => 'Pinterest Link',
			'id'		  => $avis_shortname.'_pinterest_link',
			'type'		=> 'text',
			'desc'		=> 'Enter Pinterest link.',
			'std'		 => '#',
			'section'	 => 'footer_section'
		),
		array(
			'label'	   => 'Instagram Link',
			'id'		  => $avis_shortname.'_instagram_link',
			'type'		=> 'text',
			'desc'		=> 'Enter Instagram link.',
			'std'		 => '#',
			'section'	 => 'footer_section'
		),
		array(
			'label'	   => 'Copyright Text',
			'id'		  => $avis_shortname.'_copyright',
			'type'		=> 'textarea',
			'desc'		=> 'You can use HTML for links etc..',
			'std'		 => 'Avis Wordpress Theme &copy; 2015',
			'section'	 => 'footer_section'
		),			
		array(
			'label'	   => 'Google Analytics Code:',
			'id'		  => $avis_shortname.'_analytics',
			'desc'		=> '<p><strong>Insert a Google Analytics tracking code snippet</strong> or any other code snippet to be inserted in the body of the HTML document.</p>

Example: 
<pre><code class="spark-replace-script-tags">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-24568407-1\']);
  _gaq.push([\'_setDomainName\', \'maddim.com\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
	var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
	ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
	var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();
</code></pre>

<p>Note: <em>Such code can be retrieved from <a href="'.esc_url("https://www.google.com/analytics/").'" class="targetblank">Google Analytics</a> > Admin > Tracking Info.</em></p>',
			'std'		 => '',
			'type'		=> 'textarea-simple',
			'section'	 => 'footer_section',
			'rows'		=> '20',
			'post_type'   => '',
			'taxonomy'	=> '',
			'class'	   => ''
		),
		
		//------ END FOOTER SETTINGS SECTION -------------------------------
		
		
		//==================================================================
		// CUSTOM JS SECTION STARTS ========================================
		//==================================================================
		
		array(
			'label'	   => 'Custom Javascript',
			'id'		  => $avis_shortname.'_custom_js',
			'desc'		=> '<p><strong>Enter custom javascript</strong> <br />
This allows you to add custom javascript code to all pages.</p>

Example:
<pre><code>(function ($) {
	 $(document).ready(function () {
		  // Your custom code
	 });
})(jQuery);
</code></pre>',
			'std'		 => '',
			'type'		=> 'textarea-simple',
			'section'	 => 'custom_js_section',
			'rows'		=> '30',
			'post_type'   => '',
			'taxonomy'	=> '',
			'class'	   => ''
		),
		
		//------ END CUSTOM JS SECTION -------------------------------------
		
		
		//==================================================================
		// CUSTOM CSS SECTION STARTS =======================================
		//==================================================================	
		
		array(
			'id'		  => $avis_shortname.'_custom_css',
			'label'	   => 'Custom CSS',
			'desc'		=> '<p><strong>Enter custom CSS</strong> <br />
This allows you to add custom styles to all pages.</p>

Example: 
<pre><code>#header-area{
	display:none;
}</code></pre>',
			'std'		 => '',
			'type'		=> 'css',
			'section'	 => 'custom_css_section',
			'rows'		=> '30',
			'post_type'   => '',
			'taxonomy'	=> '',
			'class'	   => ''
		),
		
		//------ END CUSTOM CSS SECTION ------------------------------------	
	

		//==================================================================
		// CUSTOM MESSAGES SECTION STARTS ==================================
		//==================================================================
		
		array(
			'id'		  => $avis_shortname.'_four_zero_four_txt',
			'label'	   => __( '404 Page Error Message', 'avis'),
			'desc'		=> 'Add error message for 404 page.',
			'std'		 => "We seem to have lost this page, try one of instead this.",
			'type'		=> 'textarea-simple',
			'rows'		=> '2',
			'section'	 => 'custom_messages'
		),
	

		//------ END CUSTOM MESSAGES SECTION -------------------------------
		
				
		//==================================================================
		// SHORTCODES SECTION STARTS =======================================
		//==================================================================		
			  
		array(
			'id'		  => 'avis_shortcodes_doc',
			'label'	   => 'Shortcodes Documentation',
			'desc'		=> '<h1>Shortcodes Documentation</h1>
			<p>Use any of the following shortcodes by simply copy/pasting them into any page, post or text widget.</p>
			<li><a href="#doc-skillchart">Avis - Our Skill</a></li>
			<strong>Content</strong>
			<ul style="margin-left: 15px">
				<li><a href="#doc-button">Button</a></li>
				<li><a href="#doc-blockquote">Blockquote</a></li>
				<li><a href="#doc-contentbox">Content Box</a></li>
				<li><a href="#doc-customlists">Custom Icon Lists</a></li>
				<li><a href="#doc-divider">Divider</a></li>
				<li><a href="#doc-dropcaps">Dropcaps</a></li>
				<li><a href="#doc-googlemap">GoogleMap</a></li>
				<li><a href="#doc-video">Video</a></li>
				<li><a href="#doc-highlighttext">Highlight Text</a></li>
				<li><a href="#doc-pricetbl">Pricing Table</a></li>
				<li><a href="#doc-share">Share</a></li>
				<li><a href="#doc-statistics">Statistics</a></li>
				<li><a href="#doc-tabs">Tabs</a></li>
				<li><a href="#doc-toggleacc">Toggle & Accordian</a></li>
				<li><a href="#doc-tooltips">Tooltips</a></li>		
			</ul>
			<div class="format-setting-label"><h3 id="doc-button" class="label"></h3></div>
			
<!---------------------------------------------------------------
---------------- Avis - Skill Progress Bar Shortcode ------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-skillchart" class="label">Avis - Skill Progress Bar Shortcode</h3></div>
<p><strong>Example:</strong><br />
<p><b>You can control skill progress bar shortcode using the following attributes:</b><br />
<code>id="p4"</code> ("Enter unique ids.")<br />
<code>value="95"</code> ("Enter value for show percentage.")<br />
<code>title="SUPPORT AND DOCUMENTATION"</code> ("Enter title of the bar.")<br />
</p>
<textarea class="small-area">
[avis_progress_bars id="p4" title="SUPPORT AND DOCUMENTATION" value="90"][/avis_progress_bars]
</textarea></p>
<!---------------------------------------------------------------
---------------------- Button Shortcode -------------------------
---------------------------------------------------------------->			
<div class="format-setting-label"><h3 id="doc-button" class="label">Button</h3></div>

<p><strong>Example:</strong><br />
<div class="sc_small">Small Button</div>
<textarea class="small-area">
[link_button link="http://www.sketchthemes.com" size="small" color="#1CC6DA" align="left"]Button Text[/link_button]
</textarea></p>

<div class="sc_small">Medium Button</div>
<textarea class="small-area">
[link_button link="http://www.sketchthemes.com" size="medium" color="#E41B88" align="left"]Button Text[/link_button]
</textarea></p>

<div class="sc_small">Large Button</div>
<textarea class="small-area">
[link_button link="http://www.sketchthemes.com" size="large" color="#E41B88" align="left"]Button Text[/link_button]
</textarea></p>


<!---------------------------------------------------------------
-------------------- Blockquote Shortcode -----------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-blockquote" class="label">Blockquote</h3></div>

<p><strong>Example:</strong><br />
<textarea class="small-area2">
[blockquote author="- Avis" link="http://www.sketchthemes.com"]Vestibulum dapibus, nisi fermentum tempus convallis, sapien tellus ultricies felis, sit amet commodo nisl leo quis ligula.[/blockquote]
</textarea></p>


<!---------------------------------------------------------------
-------------------- Content Box Shortcode ----------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-contentbox" class="label">Content Box</h3></div>

<p><strong>Example:</strong><br />
<div class="sc_small">Warning Box</div>
<textarea class="small-area">
[worningbox]Vestibulum dapibus, nisi fermentum tempus convallis, sapien tellus ultricies felis.[/worningbox]
</textarea></p>

<div class="sc_small">Download Box</div>
<textarea class="small-area">
[downloadbox]Vestibulum dapibus, nisi fermentum tempus convallis, sapien tellus ultricies felis.[/downloadbox]
</textarea></p>

<div class="sc_small">Infomation Box</div>
<textarea class="small-area">
[infobox]Vestibulum dapibus, nisi fermentum tempus convallis, sapien tellus ultricies felis.[/infobox]
</textarea></p>

<div class="sc_small">Normal Box</div>
<textarea class="small-area">
[normalbox]Vestibulum dapibus, nisi fermentum tempus convallis, sapien tellus ultricies felis.[/normalbox]
</textarea></p>

<div class="sc_small">Notification Box</div>
<textarea class="small-area">
[notificationbox]Vestibulum dapibus, nisi fermentum tempus convallis, sapien tellus ultricies felis.[/notificationbox]
</textarea></p>

<div class="sc_small">Success Notification box</div>
<textarea class="small-area">
[successbox]This is a success message.[/successbox]
</textarea></p>

<div class="sc_small">Error Notification box</div>
<textarea class="small-area">
[notification_error]This is a error message.[/notification_error]
</textarea></p>

<div class="sc_small">Information Notification box</div>
<textarea class="small-area">
[notification_info]This is a information message.[/notification_info]
</textarea></p>

<div class="sc_small">Chat Notification box</div>
<textarea class="small-area">
[notification_chat]This is a chat message.[/notification_chat]
</textarea></p>

<div class="sc_small">Task Notification box</div>
<textarea class="small-area">
[notification_task]This is a task message.[/notification_task]
</textarea></p>


<!---------------------------------------------------------------
----------------- Custom Icon Lists Shortcode -------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-customlists" class="label">Custom Icon Lists</h3></div>

<p><strong>Example:</strong><br />
<p><b>You can control list-style of each list using the given attribute:</b><br /><br />
<code>type="asterisk-icon"</code> ("ban-icon" or "book-icon" or "bookmark-icon" or "certificate-icon" or "check-icon" or "gear-icon" or "comments-icon" or "download-icon" or "edit-icon" or "envelope-icon" or "exclamation-icon" or "external-link-icon" or "folder-open-icon" or "info-icon" or "mail-forward-icon" or "mail-forward-icon" or "plus-icon" or "refresh-icon" or "star-icon" or "tags-icon" or "map-marker-icon" or "link-icon" or "paperclip-icon" or "paperclip-icon" or "warning-icon" or "angle-right-icon")
</p>

<textarea class="small-area3">
[custom_list type="asterisk-icon"] 
	<ul> 
		<li>Sample list item</li> 
		<li>Sample list item</li> 
		<li>
			<ul> 
				<li>Sample list item</li> 
				<li>Sample list item</li> 
			</ul> 
		</li> 
		<li>Sample list item</li> 
		<li>Sample list item</li> 
	</ul> 
[/custom_list]
</textarea></p>


<!---------------------------------------------------------------
-------------------- Divider Shortcode --------------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-divider" class="label">Dropcaps</h3></div>

<p><strong>Example:</strong><br />
<div class="sc_small">Thin</div>
<textarea class="small-area">
[hr width="1px" color="#e74c3c" style="solid"][/hr]
</textarea></p>

<div class="sc_small">Thick</div>
<textarea class="small-area">
[hr width="2px" color="#2980b9" style="solid"][/hr]
</textarea></p>

<div class="sc_small">Dotted</div>
<textarea class="small-area">
[hr width="1px" color="#9b59b6" style="dotted"][/hr]
</textarea></p>

<div class="sc_small">Dashed</div>
<textarea class="small-area">
[hr width="1px" color="#16a085" style="dashed"][/hr]
</textarea></p>

<div class="sc_small">Back To Top with Divider</div>
<textarea class="small-area">
[gotop width="1px" color="#e67e22" style="solid"]Back to top[/gotop]
</textarea></p>


<!---------------------------------------------------------------
-------------------- Dropcaps Shortcode -------------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-dropcaps" class="label">Dropcaps</h3></div>

<p><strong>Example:</strong><br />
<div class="sc_small">Normal Dropcaps</div>
<textarea class="small-area">
[dropcaps type="normal" color="red" size="50px"]V[/dropcaps]
</textarea></p>

<div class="sc_small">Circle Dropcaps</div>
<textarea class="small-area">
[dropcaps type="circle" bgcolor="#E0E0E0" color="orchid" size="50px"]V[/dropcaps]
</textarea></p>

<div class="sc_small">Square Dropcaps</div>
<textarea class="small-area">
[dropcaps type="square" bgcolor="#ECFFE0" color="#43AD00" size="50px"]V[/dropcaps]
</textarea></p>

<div class="sc_small">Square with Round Corner Dropcaps</div>
<textarea class="small-area">
[dropcaps type="square-round-corner" color="oldlace" size="50px"]V[/dropcaps]
</textarea></p>


<!---------------------------------------------------------------
--------------------- GoogleMap Shortcode -----------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-googlemap" class="label">GoogleMap</h3></div>

<p><strong>Example:</strong><br />
<textarea class="small-area2">
[googlemap width="900" height="400" src="https://maps.google.com/maps?q=hollywood&hl=en&sll=52.160455,14.106445&sspn=17.099454,53.569336&hnear=Hollywood,+Los+Angeles,+Los+Angeles+County,+California&t=m&z=17"][/googlemap]
</textarea></p>

<!---------------------------------------------------------------
--------------------- Video Shortcode -----------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-video" class="label">Video</h3></div>

<p><strong>Example:</strong><br />
<textarea class="small-area2">
[youtube src="http://www.youtube.com/watch?v=EyEyojMvveY" width="562" height="317"][/youtube]
[vimeo src="http://vimeo.com/64473966" width="562" height="317"][/vimeo]
</textarea></p>

<!---------------------------------------------------------------
------------------ Highlight-text Shortcode ---------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-highlighttext" class="label">Highlight Text</h3></div>

<p><strong>Example:</strong><br />
<textarea class="small-area2">
[highlighted bgcolor="#e74c3c" color="#fff"]consectetur[/highlighted]
</textarea></p>


<!---------------------------------------------------------------
------------------- Price Table Shortcode -----------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-pricetbl" class="label">Price Table</h3></div>

<p><strong>Example:</strong><br />
<textarea class="small-area3">
[page_container]
[one_third]
[pricing_column title="STANDARD" price="39" currency="$"  price_period="MONTHLY" title_bg_color="#7FBF00" button_color="#7FBF00" link="#" target="_self" button_text="PURCHASE" active="no"] 
<ul> 
	<li>Featured Content 1</li> 
	<li>Featured Content 2</li> 
	<li>Featured Content 3</li> 
	<li>Featured Content 4</li> 
	<li>Featured Content 5</li> 
</ul> 
[/pricing_column] 
[/one_third] 

[one_third]
[pricing_column title="BUSINESS" price="49" currency="$" price_period="MONTHLY" title_bg_color="#7FBF00" button_color="#7FBF00" link="#" target="_self" button_text="PURCHASE" active="yes"] 
<ul> 
	<li>Featured Content 1</li> 
	<li>Featured Content 2</li> 
	<li>Featured Content 3</li> 
	<li>Featured Content 4</li> 
	<li>Featured Content 5</li> 
</ul> 
[/pricing_column]
[/one_third]

[one_third_last]
[pricing_column title="ULTIMATE" price="59" currency="$" price_period="MONTHLY" title_bg_color="#7FBF00" button_color="#7FBF00" link="#" target="_self" button_text="PURCHASE" active="no"] 
<ul> 
	<li>Featured Content 1</li> 
	<li>Featured Content 2</li> 
	<li>Featured Content 3</li> 
	<li>Featured Content 4</li> 
	<li>Featured Content 5</li> 
</ul> 
[/pricing_column] 
[/one_third_last] 
[/page_container]
</textarea></p>


<!---------------------------------------------------------------
---------------------- Share Shortcode --------------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-share" class="label">Share</h3></div>

<p><strong>Example:</strong><br />
<div class="sc_small">Share Icon with Large Icon</div>
<textarea class="small-area">
[share_icon type="large"][/share_icon]
</textarea></p>

<div class="sc_small">Share Icon with Vertical Count</div>
<textarea class="small-area">
[share_icon type="vcount"][/share_icon]
</textarea></p>

<div class="sc_small">Share Icon with Horizontal Count</div>
<textarea class="small-area">
[share_icon type="hcount"][/share_icon]
</textarea></p>


<!---------------------------------------------------------------
-------------------- Statistics Shortcode -----------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-statistics" class="label">Statistics</h3></div>

<p><strong>Example:</strong><br />
<div class="sc_small">Share Icon with Large Icon</div>
<textarea class="small-area4">
[avis_counter count="45" color="#8e44ad" prefix="$" title="Standard Theme"][/avis_counter]
[avis_counter count="75" color="#8e44ad" title="Extended Theme" prefix="$"][/avis_counter]
[avis_counter count="99" color="#8e44ad" title="Standard Membership" prefix="$"][/avis_counter]
[avis_counter count="199" color="#8e44ad" title="Extended Membership" prefix="$"][/avis_counter]
</textarea></p>


<!---------------------------------------------------------------
----------------------- Tabs Shortcode --------------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-tabs" class="label">Tabs</h3></div>
<p>Split your content into tabs.</p>
<p><strong>Example:</strong><br />
<div class="sc_small">Horizontal Tab</div>
<textarea class="small-area3">
[tabwrapper id="ske_alicontainer" itemno="1" orient="h" effect="1"] 
	[tabs] 
		[tabtxt]Tab1[/tabtxt] 
		[tabtxt]Tab2[/tabtxt] 
		[tabtxt]Tab3[/tabtxt] 
		[tabtxt]Tab4[/tabtxt] 
	[/tabs] 
	[tabcontainer] 
		[tabcontent]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse viverra mauris eget tortor imperdiet vehicula. Proin egestas diam ac mauris molestie hendrerit. Quisque nec nisi tortor. Etiam at mauris sit amet magna suscipit hendrerit non sed ligula. Vivamus purus odio, mollis ut sagittis vel, feugiat et nulla. Aenean id felis sed ligula volutpat consectetur.[/tabcontent] 
		[tabcontent]Donec ut sem sit amet augue faucibus lacinia in ac neque. Aliquam laoreet neque vel lorem consectetur lobortis. Ut non bibendum metus. Etiam tristique fermentum purus, sit amet adipiscing sem blandit non. Duis ut ante dui, sed fermentum ante. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.[/tabcontent] 
		[tabcontent]Ut gravida hendrerit erat, a pellentesque dolor mattis et. Donec ligula diam, luctus id dapibus ac, egestas eu risus. Curabitur eget leo nisl. Nulla ac dapibus mi. Morbi enim nulla, porttitor ac vestibulum et, scelerisque eu justo. Mauris sit amet ornare est. Duis rhoncus lacinia sodales. Pellentesque sit amet ultrices odio.[/tabcontent] 
		[tabcontent]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse viverra mauris eget tortor imperdiet vehicula. Proin egestas diam ac mauris molestie hendrerit. Quisque nec nisi tortor. Etiam at mauris sit amet magna suscipit hendrerit non sed ligula. Vivamus purus odio, mollis ut sagittis vel, feugiat et nulla. Aenean id felis sed ligula volutpat consectetur.[/tabcontent] 
	[/tabcontainer] 
[/tabwrapper]
</textarea></p>

<div class="sc_small">Vertical Tab</div>
<textarea class="small-area3">
[tabwrapper id="sktana_container1" itemno="1" orient="v" effect="1"] 
	[tabs] 
		[tabtxt]Tab1[/tabtxt] 
		[tabtxt]Tab2[/tabtxt] 
		[tabtxt]Tab3[/tabtxt] 
		[tabtxt]Tab4[/tabtxt] 
	[/tabs] 
	[tabcontainer] 
		[tabcontent]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse viverra mauris eget tortor imperdiet vehicula. Proin egestas diam ac mauris molestie hendrerit. Quisque nec nisi tortor. Etiam at mauris sit amet magna suscipit hendrerit non sed ligula. Vivamus purus odio, mollis ut sagittis vel, feugiat et nulla. Aenean id felis sed ligula volutpat consectetur.[/tabcontent] 
		[tabcontent]Donec ut sem sit amet augue faucibus lacinia in ac neque. Aliquam laoreet neque vel lorem consectetur lobortis. Ut non bibendum metus. Etiam tristique fermentum purus, sit amet adipiscing sem blandit non. Duis ut ante dui, sed fermentum ante. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.[/tabcontent] 
		[tabcontent]Ut gravida hendrerit erat, a pellentesque dolor mattis et. Donec ligula diam, luctus id dapibus ac, egestas eu risus. Curabitur eget leo nisl. Nulla ac dapibus mi. Morbi enim nulla, porttitor ac vestibulum et, scelerisque eu justo. Mauris sit amet ornare est. Duis rhoncus lacinia sodales. Pellentesque sit amet ultrices odio.[/tabcontent] 
		[tabcontent]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse viverra mauris eget tortor imperdiet vehicula. Proin egestas diam ac mauris molestie hendrerit. Quisque nec nisi tortor. Etiam at mauris sit amet magna suscipit hendrerit non sed ligula. Vivamus purus odio, mollis ut sagittis vel, feugiat et nulla. Aenean id felis sed ligula volutpat consectetur.[/tabcontent] 
	[/tabcontainer] 
[/tabwrapper]
</textarea></p>


<!---------------------------------------------------------------
---------------- Toggle & Accordian Shortcode -------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-toggleacc" class="label">Toggle & Accordian</h3></div>

<p><strong>Example:</strong><br />
<div class="sc_small">Toggle With Fade Animation</div>
<textarea class="small-area4">
[togglecontainer id="ske_container" state="open" effect="1"]
[togtitle]This is open content with fade effect[/togtitle]
[togcontent]Smokin driveway wrestlin go darn truck moonshine wirey cow grandpa saw, coonskin bull, java, huntin.Smokin driveway wrestlin go darn truck moonshine wirey cow grandpa saw, coonskin bull, java, huntin.[/togcontent]
[/togglecontainer]
</textarea></p>

<div class="sc_small">Toggle With Slide Animation</div>
<textarea class="small-area4">
[togglecontainer id="ske_container" state="open" effect="2"]
[togtitle]This is open content with fade effect[/togtitle]
[togcontent]Smokin driveway wrestlin go darn truck moonshine wirey cow grandpa saw, coonskin bull, java, huntin.Smokin driveway wrestlin go darn truck moonshine wirey cow grandpa saw, coonskin bull, java, huntin.[/togcontent]
[/togglecontainer]
</textarea></p>

<div class="sc_small">Accordian With Fade Animation</div>
<textarea class="small-area3">
[accordiancontainer id="ske_container8" effect="1" togacc="1" hoverpause="0" itemno="1"]
	[accwrap]
		[acctitle]Slide First[/acctitle]
		[acccontent]Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.[/acccontent]
	[/accwrap]
	
	[accwrap]
		[acctitle]Slide second[/acctitle]
		[acccontent]Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.[/acccontent]
	[/accwrap]
	
	[accwrap]
		[acctitle]Slide Third[/acctitle]
		[acccontent]Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.[/acccontent]
	[/accwrap]
[/accordiancontainer]
</textarea></p>

<div class="sc_small">Accordian Slider With Fade Animation</div>
<textarea class="small-area3">
[accordiancontainer id="ske_container8" effect="1" togacc="0" hoverpause="0" itemno="1" autoplay="0"]
	[accwrap]
		[acctitle]Slide First[/acctitle]
		[acccontent]Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.[/acccontent]
	[/accwrap]
	
	[accwrap]
		[acctitle]Slide second[/acctitle]
		[acccontent]Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.[/acccontent]
	[/accwrap]
	
	[accwrap]
		[acctitle]Slide Third[/acctitle]
		[acccontent]Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.[/acccontent]
	[/accwrap]
[/accordiancontainer]
</textarea></p>

<div class="sc_small">Accordian Slider With Slide Animation & Autoplay</div>
<textarea class="small-area3">
[accordiancontainer id="ske_container2" effect="2" togacc="0" hoverpause="1"]
	[accwrap]
		[acctitle]Slide First[/acctitle]
		[acccontent]Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.[/acccontent]
	[/accwrap]
	
	[accwrap]
		[acctitle]Slide second[/acctitle]
		[acccontent]Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.[/acccontent]
	[/accwrap]
	
	[accwrap]
		[acctitle]Slide Third[/acctitle]
		[acccontent]Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.[/acccontent]
	[/accwrap]
[/accordiancontainer]
</textarea></p>


<!---------------------------------------------------------------
---------------------- Tooltips Shortcode -----------------------
---------------------------------------------------------------->
<div class="format-setting-label"><h3 id="doc-tooltips" class="label">Tooltips</h3></div>

<p><strong>Example:</strong><br />
<textarea class="small-area">
[tooltip tooltip_title="Ut aliquet purus et justo tincidunt at viverra ligula cursus."]Tooltip example[/tooltip]
</textarea></p>',
		'std'		 => '',
		'type'		=> 'textblock',
		'section'	 => 'shortcodes_section',
		'rows'		=> '',
		'post_type'   => '',
		'taxonomy'	=> '',
		'class'	   => 'shortcodes_textblock'
	  ),
	  
		//------ END SHORTCODE SETTINGS SECTION ----------------------------

	)
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
	update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}



/**
 * Initialize the avis Contact Page Meta Boxes. 
 */
add_action( 'admin_init', 'avis_contact_metaboxes' );

function avis_contact_metaboxes() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/

	$avis_contact_metaboxes = array(
	'id'		  => 'avis_contact_page_metaboxes',
	'title'	   => __( 'Avis : Contact Page Settings', 'avis' ),
	'desc'		=> '',
	'pages'	   => array( 'page' ),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
	
			array(
				'label' => __( 'Google Map', 'avis' ),
				'id'	=> '_contact_google_map',
				'desc'  => __( 'Make it on/off, enable/disable Google Map.','avis'),
				'std'   => 'on',
				'type'  => 'on-off',
			),
			array(  
				'label' => __( 'Google Map API Key', 'avis' ),
				'id'	=> '_contact_gmap_apikey',
				'type'  => 'text',
				'condition'   => '_contact_google_map:is(on)',
				'desc'  => __( 'Create Google map API key from <a href="https://developers.google.com/maps/documentation/javascript/get-api-key?utm_source=geoblog&utm_medium=social&utm_campaign=2016-geo-na-website-gmedia-blogs-us-blogPost&utm_content=TBC">here</a>', 'avis' )
			),
			array(
				'id'		  => 'contact_gmap_settings',
				'label'	   => __( 'Google Map Settings', 'avis' ),
				'desc'		=> '<h2><b>Google Map Settings</b></h2>',
				'std'		 => '',
				'type'		=> 'textblock',
				'condition'   => '_contact_google_map:is(on)',
			),
			array(
				'label' => __( 'Map Overlay Background Image', 'avis'),
				'id'	=> '_contact_map_bg_image',
				'std'   => '',
				'desc'  => __( 'Upload image & color for Map background.', 'avis' ),
				'type'  => 'background',
			),
			array(
				'label' => __( 'Map Overlay Content', 'avis'),
				'id'	=> '_contact_map_overlay_content',
				'std'   => '',
				'desc'  => __( 'Enter Map Overlay Content.', 'avis' ),
				'type'  => 'textarea',
			),
			array(  
				'label' => __( 'Map Height', 'avis' ),
				'id'	=> '_contact_gmap_height',
				'type'  => 'text',
				'condition'   => '_contact_google_map:is(on)',
				'desc'  => __( 'Set Google map height in PX', 'avis' )
			),
			array(  
				'label' => __( 'View Map Title', 'avis' ),
				'id'	=> '_contact_view_map_title',
				'type'  => 'text',
				'condition'   => '_contact_google_map:is(on)',
				'desc'  => __( 'Set view map title for the button.', 'avis' )
			),
			array(  
				'label' => __( 'Latitude', 'avis' ),
				'id'	=> '_contact_gmap_lat',
				'type'  => 'text',
				'condition'   => '_contact_google_map:is(on)',
				'desc'  => __( 'To find latitude and longitude right click on the google map at your desired location and from context menu select Whats here & you will get the latitude and longitude at searchbox..', 'avis' )
			),
			array(  
				'label' => __( 'Longitude', 'avis' ),
				'id'	=> '_contact_gmap_long',
				'type'  => 'text',
				'condition'   => '_contact_google_map:is(on)',
				'desc'  => __( 'To find latitude and longitude right click on the google map at your desired location and from context menu select Whats here & you will get the latitude and longitude at searchbox..', 'avis' )
			),
			array(
				'label' => __( 'Info Window Content (HTML tags can be used)', 'avis' ),
				'id'	=> '_contact_gmap_infotxt',
				'type'  => 'textarea',
				'condition'   => '_contact_google_map:is(on)',
				'desc'  => __( 'Enter the content for info window.', 'avis' )
			),
			array(
				'label'	   => 'Info Window by default',
				'id'		  => '_contact_gmap_infost',
				'type'		=> 'radio',
				'desc'		=> 'Set state (open/close) for the info window by default.',
				'std'		 => 'open',
				'condition'   => '_contact_google_map:is(on)',
				'choices'	 => array(
					array(
						'label'	   => 'OPEN',
						'value'	   => 'open'
					),
					array(
						'label'	   => 'CLOSE',
						'value'	   => 'close'
					)
				)
			),			
			array(
				'label' => __( 'Marker icon', 'avis'),
				'id'	=> '_contact_gmap_iconimg',
				'desc'  => __( 'upload icon for location on map.', 'avis' ),
				'condition'   => '_contact_google_map:is(on)',
				'type'  => 'upload',
			),
			array(
				'label'	   => 'Marker Animation',
				'id'		  => '_contact_gmap_markanim',
				'type'		=> 'radio',
				'desc'		=> 'Set marker animation.',
				'std'		 => 'DROP',
				'condition'   => '_contact_google_map:is(on)',
				'choices'	 => array(
					array(
						'label'	   => 'BOUNCE',
						'value'	   => 'BOUNCE'
					),
					array(
						'label'	   => 'DROP',
						'value'	   => 'DROP'
					)
				)
			),
			 array(
				'id'		  => '_contact_gmap_zlevel',
				'label'	   => __( 'Map Zoom Level', 'avis' ),
				'desc'		=> __( 'Set Google Map Zoom Level.', 'avis' ),
				'std'		 => '14',
				'type'		=> 'select',
				'condition'   => '_contact_google_map:is(on)',
				'choices'	 => array( 
					array(
						'value'	   => '1',
						'label'	   => __( '1', 'avis' )
					),
					array(
						'value'	   => '2',
						'label'	   => __( '2', 'avis' )
					),
					array(
						'value'	   => '3',
						'label'	   => __( '3', 'avis' )
					),
					array(
						'value'	   => '4',
						'label'	   => __( '4', 'avis' )
					),
					array(
						'value'	   => '5',
						'label'	   => __( '5', 'avis' )
					),
					array(
						'value'	   => '6',
						'label'	   => __( '6', 'avis' )
					),
					array(
						'value'	   => '7',
						'label'	   => __( '7', 'avis' )
					),
					array(
						'value'	   => '8',
						'label'	   => __( '8', 'avis' )
					),
					array(
						'value'	   => '9',
						'label'	   => __( '9', 'avis' )
					),
					array(
						'value'	   => '10',
						'label'	   => __( '10', 'avis' )
					),
					array(
						'value'	   => '11',
						'label'	   => __( '11', 'avis' )
					),
					array(
						'value'	   => '12',
						'label'	   => __( '12', 'avis' )
					),
					array(
						'value'	   => '13',
						'label'	   => __( '13', 'avis' )
					),
					array(
						'value'	   => '14',
						'label'	   => __( '14', 'avis' )
					),
					array(
						'value'	   => '15',
						'label'	   => __( '15', 'avis' )
					),
					array(
						'value'	   => '16',
						'label'	   => __( '16', 'avis' )
					),
					array(
						'value'	   => '17',
						'label'	   => __( '17', 'avis' )
					),
					array(
						'value'	   => '18',
						'label'	   => __( '18', 'avis' )
					),
					array(
						'value'	   => '19',
						'label'	   => __( '19', 'avis' )
					),
					array(
						'value'	   => '20',
						'label'	   => __( '20', 'avis' )
					),
					array(
						'value'	   => '21',
						'label'	   => __( '21', 'avis' )
					)					
				)
			),
			array(
				'id'		  => '_contact_gmap_maptype',
				'label'	   => __( 'Map Type', 'avis' ),
				'desc'		=> __( 'Set Map Type', 'avis' ),
				'std'		 => 'ROADMAP',
				'type'		=> 'select',
				'condition'   => '_contact_google_map:is(on)',
				'choices'	 => array( 
					array(
						'value'	   => 'ROADMAP',
						'label'	   => __( 'ROADMAP', 'avis' )
					),
					array(
						'value'	   => 'SATELLITE',
						'label'	   => __( 'SATELLITE', 'avis' )
					),
					array(
						'value'	   => 'HYBRID',
						'label'	   => __( 'HYBRID', 'avis' )
					),
					array(
						'value'	   => 'TERRAIN',
						'label'	   => __( 'TERRAIN', 'avis' )
					)				
				)
			),
		)
	);

	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/

	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_contact_metaboxes );
}


/**
 * INITIALIZE THE AVIS_VIDEO_POST_FORMAT
 */
add_action( 'admin_init', 'avis_video_post_format' );

function avis_video_post_format() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/

	$avis_video_post_format = array(
	'id'		  => 'avis_video_post_format',
	'title'	   => __( 'Avis : Video Format', 'avis' ),
	'desc'		=> '',
	'pages'	   => array( 'post' ),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
	  
			array(  
				'label' => __( 'Add video URL (YouTube / Vimeo)', 'avis' ),
				'id'	=> '_avis_postType_video',
				'type'  => 'text',
				'desc'  => __( 'Enter video URL (youtube / vimeo).', 'avis' )
			),
		)
	);

	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/

	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_video_post_format );

}


/**
 * INITIALIZE THE AVIS_GALLERY_POST_FORMAT
 */
add_action( 'admin_init', 'avis_gallery_post_format' );

function avis_gallery_post_format() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/

	$avis_gallery_format = array(
	'id'		  => 'avis_gallery_post_format',
	'title'	   => __( 'Avis : Gallery Format', 'avis' ),
	'desc'		=> '',
	'pages'	   => array( 'post' ),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
	  
			array(
				'label' => __( 'Add Images to Gallery', 'avis' ),
				'id'	=> '_avis_postType_gallery',
				'type'  => 'gallery',
				'desc'  => sprintf( __( 'Please add the images to create a gallery', 'avis' ) )
			),
			array(
				'id'		  => '_avis_postType_slider_delay',
				'label'	   => __( 'Time Delay', 'avis'),
				'desc'		=> __( 'Set time between slide transitions (<b>in milliseconds</b>)', 'avis' ),
				'std'		 => '7000',
				'type'		=> 'numeric-slider',
				'min_max_step'=> '0,100000,100',
			),
			array(
				'id'		  => '_avis_postType_slider_speed',
				'label'	   => __( 'Animation Speed', 'avis'),
				'desc'		=> __( 'Set speed of the transition (<b>in milliseconds</b>)', 'avis' ),
				'std'		 => '600',
				'type'		=> 'numeric-slider',
				'min_max_step'=> '0,10000,10',
			),
			array(
				'label' => __('Auto Play (on/off)', 'avis'),
				'desc'  => __('On/Off animate automatically', 'avis'),
				'id'	=> '_avis_postType_slider_autoplay',
				'type'  => 'on-off',
				'std'   => 'on'
			),
			array(
				'label' => __('Pause on Hover (on/off)', 'avis'),
				'desc'  => __('On/Off pause on Hover', 'avis'),
				'id'	=> '_avis_postType_slider_pause',
				'type'  => 'on-off',
				'std'   => 'on'
			)
		)
	);

	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/

	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_gallery_format );

}

/**
 * INITIALIZE THE AVIS_QOUTE_POST_FORMAT
 */
add_action( 'admin_init', 'avis_quote_post_format' );

function avis_quote_post_format() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/

	$avis_quote_post_format = array(
	'id'		  => 'avis_quote_post_format',
	'title'	   => __( 'Avis : Quote Format', 'avis' ),
	'desc'		=> '',
	'pages'	   => array( 'post' ),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
	  
			array(  
				'label' => __( 'Quote Text', 'avis' ),
				'id'	=> '_avis_postType_quote',
				'type'  => 'textarea',
				'desc'  => __( 'Enter text for quote.', 'avis' )
			),
			array(  
				'label' => __( 'Author Name', 'avis' ),
				'id'	=> '_avis_postType_quote_author',
				'type'  => 'text',
				'desc'  => __( 'Enter author name.', 'avis' )
			),
			array(  
				'label' => __( 'Author URL', 'avis' ),
				'id'	=> '_avis_postType_quote_authorUrl',
				'type'  => 'text',
				'desc'  => __( 'Enter author url.', 'avis' )
			)
		)
	);

	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/

	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_quote_post_format );
}

/**
 * INITIALIZE THE AVIS_STANDARD_POST_FORMAT FOR PORTFOLIO
 */
add_action( 'admin_init', 'avis_standard_post_format_portfolio' );

function avis_standard_post_format_portfolio() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/

	$avis_standard_post_format_portfolio = array(
	'id'		  => 'avis_standard_post_format_portfolio',
	'title'	   => __( 'Avis : Standard Format', 'avis' ),
	'desc'		=> '',
	'pages'	   => array( 'portfolio_post' ),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
			array(
				'id'		  => 'portfolio_fornt_page_setting',
				'label'	   => 'Front Page Setting For Portfolio',
				'desc'		=> '<h2>Front Page Setting For Portfolio</h2>',
				'std'		 => '',
				'type'		=> 'textblock',
			),
			array(
				'label'	   => 'Front Page Portfolio Image',
				'id'		  => '_front_portfolio_img',
				'type'		=> 'upload',
				'desc'		=> 'Upload Portfolio Image For Front Page ( Random Size ).',
				'std'		 => '',
			),
			array(
				'id'		  => 'portfolio_single_page_setting',
				'label'	   => 'Single Page Setting For Portfolio',
				'desc'		=> '<h2>Single Page Setting For Portfolio</h2>',
				'std'		 => '',
				'type'		=> 'textblock',
			),
			array(
				'label'	   => 'Single Page Portfolio Image',
				'id'		  => '_single_portfolio_img',
				'type'		=> 'upload',
				'desc'		=> 'Upload Portfolio Image For Single Page (1170px * 500px).',
				'std'		 => '',
			),
		)
	);

	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/

	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_standard_post_format_portfolio );
}

/**
 * INITIALIZE THE AVIS_VIDEO_POST_FORMAT FOR PORTFOLIO
 */
add_action( 'admin_init', 'avis_video_post_format_portfolio' );

function avis_video_post_format_portfolio() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/

	$avis_video_post_format_portfolio = array(
	'id'		  => 'avis_video_post_format_portfolio',
	'title'	   => __( 'Avis : Video Format', 'avis' ),
	'desc'		=> '',
	'pages'	   => array( 'portfolio_post' ),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
	  
			array(  
				'label' => __( 'Add video URL (YouTube / Vimeo)', 'avis' ),
				'id'	=> '_avis_postType_video',
				'type'  => 'text',
				'desc'  => __( 'Enter video URL (youtube / vimeo).', 'avis' )
			),
		)
	);

	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/

	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_video_post_format_portfolio );

}


/**
 * INITIALIZE THE AVIS_GALLERY_POST_FORMAT FOR PORTFOLIO
 */
add_action( 'admin_init', 'avis_gallery_post_format_portfolio' );

function avis_gallery_post_format_portfolio() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/

	$avis_gallery_post_format_portfolio = array(
	'id'		  => 'avis_gallery_post_format_portfolio',
	'title'	   => __( 'Avis : Gallery Format', 'avis' ),
	'desc'		=> '',
	'pages'	   => array( 'portfolio_post' ),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
	  
			array(
				'label' => __( 'Add Images to Portfolio Gallery', 'avis' ),
				'id'	=> '_avis_postType_gallery_portfolio',
				'type'  => 'gallery',
				'desc'  => sprintf( __( 'Please add the images to create a portfolio gallery', 'avis' ) )
			),
			array(
				'id'		  => '_avis_postType_slider_delay_portfolio',
				'label'	   => __( 'Time Delay', 'avis'),
				'desc'		=> __( 'Set time between slide transitions (<b>in milliseconds</b>)', 'avis' ),
				'std'		 => '7000',
				'type'		=> 'numeric-slider',
				'min_max_step'=> '0,100000,100',
			),
			array(
				'id'		  => '_avis_postType_slider_speed_portfolio',
				'label'	   => __( 'Animation Speed', 'avis'),
				'desc'		=> __( 'Set speed of the transition (<b>in milliseconds</b>)', 'avis' ),
				'std'		 => '600',
				'type'		=> 'numeric-slider',
				'min_max_step'=> '0,10000,10',
			),
			array(
				'label' => __('Auto Play (on/off)', 'avis'),
				'desc'  => __('On/Off animate automatically', 'avis'),
				'id'	=> '_avis_postType_slider_autoplay_portfolio',
				'type'  => 'on-off',
				'std'   => 'on'
			),
			array(
				'label' => __('Pause on Hover (on/off)', 'avis'),
				'desc'  => __('On/Off pause on Hover', 'avis'),
				'id'	=> '_avis_postType_slider_pause_portfolio',
				'type'  => 'on-off',
				'std'   => 'on'
			)
		)
	);

	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/

	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_gallery_post_format_portfolio );

}

/**
 * Initialize the avis Page Meta Boxes. 
 */
add_action( 'admin_init', 'avis_page_meta_boxes' );

function avis_page_meta_boxes() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/

	$avis_page_meta_boxes = array(
	'id'		  => 'avis_page_meta_boxes',
	'title'	   => __( 'Avis : Homepage Elements', 'avis' ),
	'desc'		=> '',
	'pages'	   => array( 'page' ),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(

			array(
				'id'		  => '_home_slider_type',
				'label'	   => __( 'Header Background Section', 'avis' ),
				'desc'		=> __( 'Select one of option according to your need.', 'avis' ),
				'std'		 => 'revslider',
				'type'		=> 'radio',
				'section'	 => 'option_types',
				'rows'		=> '3',
				'operator'	=> 'and',
				'choices'	 => array( 
				
					array(
						'value'  => 'bgimage',
						'label'  => __( 'Background Image', 'avis' ),
						'src'	=> ''
					),
					array(
						'value'  => 'revslider',
						'label'  => __( 'Revolution Slider', 'avis' ),
						'src'	=> ''
					),
				)
			),
			array(
				'label'	   => __( 'Revolution Slider', 'avis' ),
				'id'		  => '_home_revslider',
				'type'		=> 'revslider-select',
				'desc'		=> __( 'Select one of Revolution Slider', 'avis' ),
				'condition'   => '_home_slider_type:is(revslider)'
			),
			array(
				'label' 	  => __( 'Background Image', 'avis'),
				'id'		  => '_home_bgimage',
				'desc'		=> __( 'upload header background image.', 'avis' ),
				'type'		=> 'upload',
				'condition'   => '_home_slider_type:is(bgimage)'
			),			
			array(
				'id'		  => '_option_divider',
				'desc'		=> __( '', 'avis' ),
				'std'		 => '',
				'class'	   => '_option_divider',
				'type'		=> 'textblock',
			),
			
			array(
				'label' => __( 'Featured Box Section', 'avis' ),
				'id'	=> '_home_fetured_boxes',
				'desc'  => __( 'Make it on, if you want to enable Featured Box Section','avis'),
				'std'   => 'on',
				'type'  => 'on-off',
			),
			array(
				'id'		  =>'_featured_heading',
				'label'	   => __( 'Main Featured Heading', 'avis'),
				'desc'		=> 'Enter Main Featured Heading.',
				'std'		 => 'Care Features',
				'type'		=> 'text',
				'condition'   => '_home_fetured_boxes:is(on)',
			),
			array(
				'id'		  =>'_featured_desc',
				'label'	   => __( 'Main Featured Description', 'avis'),
				'desc'		=> 'Enter Main Featured Description.',
				'std'		 => 'Care Features',
				'type'		=> 'textarea',
				'condition'   => '_home_fetured_boxes:is(on)',
			),
			array(
				'label'	   => __( 'Featured Widget Section', 'avis' ),
				'id'		  => '_home_fetured_widget direction',
				'desc'		=>  __( '<h2>Featured Widget Section</h2>
				<p>GO through the Featured Widget Section to set featured boxes in this section.( Widget -> Featured Box - avis )</p>', 'avis'),
				'std'		 => '',
				'type'		=> 'textblock',
				'condition'   => '_home_fetured_boxes:is(on)',
			),
			array(
				'id'		  => '_option_divider',
				'desc'		=> __( '', 'avis' ),
				'std'		 => '',
				'class'	   => '_option_divider',
				'type'		=> 'textblock',
			),

			array(
				'label' => __( 'About Section', 'avis' ),
				'id'	=> '_home_about_section',
				'desc'  => __( 'Make it on, if you want to enable About Section','avis'),
				'std'   => 'on',
				'type'  => 'on-off',
			),
			array(
				'label'	   => __( 'Upload Image For About Section', 'avis'),
				'id'		  => '_home_about_image',
				'type'		=> 'upload',
				'desc'		=> '',
				'std'		 => '',
				'condition'   => '_home_about_section:is(on)',
			),
			array(
				'id'		  =>'_about_section_heading',
				'label'	   => __( 'Main About Section Heading', 'avis'),
				'desc'		=> 'Enter Main Heading.',
				'std'		 => 'About Us',
				'type'		=> 'text',
				'condition'   => '_home_about_section:is(on)',
			),
			array(
				'id'		  =>'_about_section_desc',
				'label'	   => __( 'About Section Description', 'avis'),
				'desc'		=> 'Enter Main Description.',
				'std'		 => '',
				'type'		=> 'textarea',
				'condition'   => '_home_about_section:is(on)',
			),
			array(
				'id'		  =>'_about_section_html',
				'label'	   => __( 'About Section Inner Html Content', 'avis'),
				'desc'		=> 'Enter Inner HTML Content.',
				'std'		 => '',
				'type'		=> 'textarea',
				'condition'   => '_home_about_section:is(on)',
			),

			array(
				'id'		  => '_option_divider',
				'desc'		=> __( '', 'avis' ),
				'std'		 => '',
				'class'	   => '_option_divider',
				'type'		=> 'textblock',
			),
			array(
				'label'	   => __( 'Latest Project Section', 'avis' ),
				'id'		  => '_home_project_section',
				'desc'		=> __( 'Make it on, if you want to enable Latest Project Section','avis'),
				'std'		 => 'on',
				'type'		=> 'on-off',
			),
			array(
				'id'		  =>'_project_section_heading',
				'label'	   => __( 'Latest Project Heading', 'avis'),
				'desc'		=> 'Enter Latest Project Heading.',
				'std'		 => 'We Are Here',
				'type'		=> 'text',
				'condition'   => '_home_project_section:is(on)',
			),
			array(
				'id'		  =>'_project_section_desc',
				'label'	   => __( 'Latest Project Description', 'avis'),
				'desc'		=> 'Enter Latest Project Description.',
				'std'		 => '',
				'type'		=> 'textarea',
				'condition'   => '_home_project_section:is(on)',
			),
			array(
				'id'		  => '_front_latest_project_items',
				'label'	   => __( 'Select Project Categories', 'avis' ),
				'desc'		=> __( 'Select Project categories Latest Project Section', 'avis' ),
				'std'		 => '',
				'type'		=> 'taxonomy-checkbox',
				'condition'   => '_home_project_section:is(on)',
				'post_type'   => 'portfolio_post',
				'taxonomy'	=> 'portfolio_category',
			),
			array(
				'id'		  => '_option_divider',
				'desc'		=> __( '', 'avis' ),
				'std'		 => '',
				'class'	   => '_option_divider',
				'type'		=> 'textblock',
			),

			array(
				'label'	   => __( 'Testimonial Section', 'avis' ),
				'id'		  => '_home_testimonial_section',
				'desc'		=> __( 'Make it on, if you want to enable Testimonial Section','avis'),
				'std'		 => 'on',
				'type'		=> 'on-off',
			),
			array(
				'label'	   => __( 'Upload Image For Testimonial Section', 'avis'),
				'id'		  => '_home_testimonial_image',
				'type'		=> 'upload',
				'desc'		=> '',
				'std'		 => '',
				'condition'   => '_home_testimonial_section:is(on)',
			),
			array(
				'id'		  =>'_home_testimonial_heading',
				'label'	   => __( 'Main Testimonial Heading', 'avis'),
				'desc'		=> 'Enter Main Testimonial Heading.',
				'std'		 => 'Testimonials',
				'type'		=> 'text',
				'condition'   => '_home_testimonial_section:is(on)',
			),
			array(
				'id'		  =>'_home_testimonial_desc',
				'label'	   => __( 'Main Testimonial Description', 'avis'),
				'desc'		=> 'Enter Main Testimonial Description.',
				'std'		 => '',
				'type'		=> 'textarea',
				'condition'   => '_home_testimonial_section:is(on)',
			),
			array(
				'id'		  => '_option_divider',
				'desc'		=> __( '', 'avis' ),
				'std'		 => '',
				'class'	   => '_option_divider',
				'type'		=> 'textblock',
			),

			array(
				'label'	   => __( 'Call To Action Section', 'avis' ),
				'id'		  => '_home_parallax_sec',
				'desc'		=> __( 'Make it on, if you want to enable parallax section','avis'),
				'std'		 => 'on',
				'type'		=> 'on-off',
			),
			array(
				'id'		  =>'_action_section_heading',
				'label'	   => __( 'Call To Action Heading', 'avis'),
				'desc'		=> 'Enter Call To Action Heading.',
				'std'		 => 'Call To Action',
				'type'		=> 'text',
				'condition'   => '_home_parallax_sec:is(on)',
			),
			array(
				'label'	   => __( 'Add Content Here', 'avis' ),
				'id'		  => '_home_parallax_shortcode',
				'type'		=> 'textarea',
				'desc'		=> __( 'Add avis parallax content.', 'avis' ),
				'condition'   => '_home_parallax_sec:is(on)',
				'rows'		=> '2'
			),
			array(
				'id'		  => '_option_divider',
				'desc'		=> __( '', 'avis' ),
				'std'		 => '',
				'class'	   => '_option_divider',
				'type'		=> 'textblock',
			),

			array(
				'label'	   => __( 'Services Section', 'avis' ),
				'id'		  => '_home_services_section',
				'desc'		=> __( 'Make it on, if you want to enable Services Section','avis'),
				'std'		 => 'on',
				'type'		=> 'on-off',
			),
			array(
				'label'	   => __( 'Services Section Background Image', 'avis'),
				'id'		  => '_home_services_bgimg',
				'type'		=> 'upload',
				'desc'		=> 'Please add background image for Services section.',
				'std'		 => '',
				'condition'   => '_home_services_section:is(on)',
			),
			array(
				'id'		  =>'_home_services_heading',
				'label'	   => __( 'Services Heading', 'avis'),
				'desc'		=> 'Enter Services Section Main Heading.',
				'std'		 => 'Services',
				'type'		=> 'text',
				'condition'   => '_home_services_section:is(on)',
			),
			array(
				'id'		  =>'_home_services_desc',
				'label'	   => __( 'Services Section Description', 'avis'),
				'desc'		=> 'Enter Services Section Main Description.',
				'std'		 => '',
				'type'		=> 'textarea',
				'condition'   => '_home_services_section:is(on)',
			),
			array(
				'id'		  =>'_home_services_html',
				'label'	   => __( 'Services Section Html', 'avis'),
				'desc'		=> 'Enter Services Section Html.',
				'std'		 => '',
				'type'		=> 'textarea',
				'condition'   => '_home_services_section:is(on)',
				'rows'		=> '4',
			),
			array(
				'id'		  => '_option_divider',
				'desc'		=> __( '', 'avis' ),
				'std'		 => '',
				'class'	   => '_option_divider',
				'type'		=> 'textblock',
			),

			array(
				'label'	   => __( 'Team Member Section', 'avis' ),
				'id'		  => '_home_ourteam_section',
				'desc'		=> __( 'Make it on, if you want to enable Team Member Section','avis'),
				'std'		 => 'on',
				'type'		=> 'on-off',
			),
			array(
				'id'		  =>'_our_team_member_heading',
				'label'	   => __( 'Team Member Heading', 'avis'),
				'desc'		=> 'Enter Team Member Main Heading.',
				'std'		 => 'Meet The Team',
				'type'		=> 'text',
				'condition'   => '_home_ourteam_section:is(on)',
			),
			array(
				'id'		  =>'_our_team_member_desc',
				'label'	   => __( 'Team Member Description', 'avis'),
				'desc'		=> 'Enter Team Member Main Description.',
				'std'		 => '',
				'type'		=> 'textarea',
				'condition'   => '_home_ourteam_section:is(on)',
			),
			array(
				'id'		  =>'_our_team_member_option',
				'label'	   => __( 'Choose One Option', 'avis'),
				'desc'		=> 'Choose One Option Either Latest Or Specific Team Member.',
				'std'		 => '',
				'type'		=> 'radio',
				'condition'   => '_home_ourteam_section:is(on)',
				'choices'	 => array(
					array(
						'label'	   => 'Latest',
						'value'	   => 'latest'
					),
					array(
						'label'	   => 'Specific',
						'value'	   => 'specific'
					)
				)
			),
			array(
				'label'	   => __( 'First Team Member', 'avis' ),
				'id'		  => '_avis_teammember_sel1',
				'section'	 => 'option_types',
				'type'		=> 'custom-post-type-select',
				'desc'		=> __( 'Select First Team Member', 'avis' ),
				'post_type'   => 'team_member',
				'condition'   => '_our_team_member_option:is(specific)'
			),
			array(
				'label'	   => __( 'Second Team Member', 'avis' ),
				'id'		  => '_avis_teammember_sel2',
				'section'	 => 'option_types',
				'type'		=> 'custom-post-type-select',
				'desc'		=> __( 'Select Second Team Member', 'avis' ),
				'post_type'   => 'team_member',
				'condition'   => '_our_team_member_option:is(specific)'
			),
			array(
				'label'	   => __( 'Third Team Member', 'avis' ),
				'id'		  => '_avis_teammember_sel3',
				'section'	 => 'option_types',
				'type'		=> 'custom-post-type-select',
				'desc'		=> __( 'Select Third Team Member', 'avis' ),
				'post_type'   => 'team_member',
				'condition'   => '_our_team_member_option:is(specific)'
			),
			array(
				'label'	   => __( 'Fourth Team Member', 'avis' ),
				'id'		  => '_avis_teammember_sel4',
				'section'	 => 'option_types',
				'type'		=> 'custom-post-type-select',
				'desc'		=> __( 'Select Fourth Team Member', 'avis' ),
				'post_type'   => 'team_member',
				'condition'   => '_our_team_member_option:is(specific)'
			),
			array(
				'id'		  => '_option_divider',
				'desc'		=> __( '', 'avis' ),
				'std'		 => '',
				'class'	   => '_option_divider',
				'type'		=> 'textblock',
			),

			array(
				'label'	   => __( 'Twitter Section', 'avis' ),
				'id'		  => '_home_twitter_section',
				'desc'		=> __( 'Make it on, if you want to enable Twitter Section','avis'),
				'std'		 => 'on',
				'type'		=> 'on-off',
			),
			array(
				'label'	   => __( 'Twitter Section Background Image', 'avis'),
				'id'		  => '_home_tws_bgimg',
				'type'		=> 'upload',
				'desc'		=> 'Please add background image for twitter section.',
				'std'		 => '',
				'condition'   => '_home_twitter_section:is(on)',
			),
			array(
				'id'		  => '_home_twitter_heading',
				'label'	   => __( 'Twitter Section Title', 'avis'),
				'desc'		=> 'Enter Twitter Section Title',
				'std'		 => 'Twitter Feed',
				'condition'   => '_home_twitter_section:is(on)',
				'type'		=> 'text',
			),
			array(
				'id'		  => '_home_twitter_desc',
				'label'	   => __( 'Twitter Section Description', 'avis'),
				'desc'		=> 'Enter Twitter Section Description',
				'std'		 => '',
				'condition'   => '_home_twitter_section:is(on)',
				'type'		=> 'textarea',
			),
			array(
				'id'		  => '_option_divider',
				'desc'		=> __( '', 'avis' ),
				'std'		 => '',
				'class'	   => '_option_divider',
				'type'		=> 'textblock',
			),

			array(
				'label'	   => __( 'Our Brands Section', 'avis' ),
				'id'		  => '_home_brand_sec',
				'desc'		=> __( 'Make it on, if you want to enable Subscription Section','avis'),
				'std'		 => 'on',
				'type'		=> 'on-off',
			),	
			array(
				'id'		  => '_home_brand_title',
				'label'	   => __( 'Our Brands Title', 'avis'),
				'desc'		=> 'Enter our brands title',
				'std'		 => 'Our Brands',
				'condition'   => '_home_brand_sec:is(on)',
				'type'		=> 'text',
			),
			array(
				'id'		  => '_home_brand_desc',
				'label'	   => __( 'Our Brands Description', 'avis'),
				'desc'		=> 'Enter our brands Description',
				'std'		 => 'Our Brands',
				'condition'   => '_home_brand_sec:is(on)',
				'type'		=> 'textarea',
			),		   
			array(
				'label'	   => __( 'Brands Logo', 'avis'),
				'id'		  => '_home_brands_logos',
				'desc'		=> 'Add Brands Logo from Here',
				'std'		 => '',
				'type'		=> 'list-item',
				'rows'		=> '',
				'post_type'   => '',
				'taxonomy'	=> '',
				'class'	   => '',
				'condition'   => '_home_brand_sec:is(on)',
				'settings'	=> array( 
					array(
						'label'	   => __( 'Upload Logo', 'avis'),
						'id'		  => '_home_clogo_img',
						'type'		=> 'upload',
						'desc'		=> 'Upload image for client logo.',
						'std'		 => '',
					),				
					array(
						'id'		  => '_home_clogo_url',
						'label'	   => __( 'Website URL', 'avis'),
						'desc'		=> 'Enter client logo url',
						'std'		 => '',
						'type'		=> 'text',
					),
				)
			),
		)
	);

	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/

	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_page_meta_boxes );

}




/**
 * Initialize the Avis Header-Footer Meta Boxes. 
 */
add_action( 'admin_init', 'avis_header_meta_boxes' );

function avis_header_meta_boxes() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/

	$avis_header_meta_boxes = array(
	'id'		  => 'avis_header_meta_boxes',
	'title'	   => __( 'Avis : Page Title Section', 'avis' ),
	'desc'		=> '',
	'pages'	   => array('page','post','product', 'portfolio_post'),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
			array(
				'label' => __( 'Page Title Background Setting', 'avis'),
				'id'	=> '_pagetitle_bg',
				'std'   => '',
				'desc'  => __( 'Upload image & color for page title background.', 'avis' ),
				'type'  => 'background',
			),				
		)
	);

	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/

	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_header_meta_boxes );
}

/**
 * Initialize the Avis Team Member Options. 
 */
add_action( 'admin_init', 'avis_team_member_meta_boxes' );
function avis_team_member_meta_boxes() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/
	$avis_team_member_meta_boxes = array(
	'id'		  => 'avis_team_member_meta_boxes',
	'title'	   => __( 'Avis : Team Member Options', 'avis' ),
	'desc'		=> '',
	'pages'	   => array('team_member'),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
			array(
				'label'	   => 'By (Name)',
				'id'		  => '_teammember_name',
				'type'		=> 'text',
				'desc'		=> 'Team member name',
				'std'		 => '',
			),
			array(
				'label'	   => 'Avatar',
				'id'		  => '_teammember_avatar',
				'type'		=> 'upload',
				'desc'		=> 'Upload team member avtar image (287px * 298px)',
				'std'		 => '',
			),
			array(
				'label'	   => 'Job Title',
				'id'		  => '_teammember_job',
				'type'		=> 'text',
				'desc'		=> 'Team member Job title',
				'std'		 => '',
			),
			array(
				'label'	   => 'Job Description',
				'id'		  => '_teammember_content',
				'type'		=> 'textarea',
				'desc'		=> 'Team member Job Description (Word limit 25).',
				'std'		 => '',
			),
			array(
				'label'	   => 'Facebook Url',
				'id'		  => '_teammember_fb',
				'type'		=> 'text',
				'desc'		=> 'Team member Facebook Url',
				'std'		 => '',
			),
			array(
				'label'	   => 'Linkedin Url',
				'id'		  => '_teammember_lkdin',
				'type'		=> 'text',
				'desc'		=> 'Team member Linkedin Url',
				'std'		 => '',
			),
			array(
				'label'	   => 'Google Plus',
				'id'		  => '_teammember_gplus',
				'type'		=> 'text',
				'desc'		=> 'Team member Google Plus Url',
				'std'		 => '',
			),
			array(
				'label'	   => 'Twitter Url',
				'id'		  => '_teammember_tw',
				'type'		=> 'text',
				'desc'		=> 'Team member Twitter Url',
				'std'		 => '',
			),
			array(
				'label'	   => 'Vk Url',
				'id'		  => '_teammember_vk',
				'type'		=> 'text',
				'desc'		=> 'Team member Vk Url',
				'std'		 => '',
			),
		)
	);
	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/
	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_team_member_meta_boxes );
}

/**
 * Initialize the Avis Team Member Options. 
 */
add_action( 'admin_init', 'avis_testimonail_meta_boxes' );
function avis_testimonail_meta_boxes() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/
	$avis_testimonail_meta_boxes = array(
	'id'		  => 'avis_testimonail_meta_boxes',
	'title'	   => __( 'Avis : Testimonial Options', 'avis' ),
	'desc'		=> '',
	'pages'	   => array('testimonial_post'),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
			array(
				'label'	   => 'Author Image',
				'id'		  => '_testimonial_avatar',
				'type'		=> 'upload',
				'desc'		=> 'Upload testimonial author image (147px * 146px).',
				'std'		 => '',
			),
			array(
				'label'	   => 'Job Title',
				'id'		  => '_testimonial_job_title',
				'type'		=> 'text',
				'desc'		=> 'Author job title.',
				'std'		 => '',
			),
			array(
				'label'	   => 'Content',
				'id'		  => '_testimonial_text',
				'type'		=> 'textarea',
				'desc'		=> 'Author testimonial content.',
				'std'		 => '',
			),
		)
	);
	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/
	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_testimonail_meta_boxes );
}

/**
 * Initialize the Avis Portfolio Inner Page Meta Boxes. 
 */
add_action( 'admin_init', 'avis_portfolio_meta_boxes' );
function avis_portfolio_meta_boxes() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/
	$avis_portfolio_meta_boxes = array(
	'id'		  => 'avis_portfolio_meta_boxes',
	'title'	   => __( 'Avis : Portfolio Options', 'avis' ),
	'desc'		=> '',
	'pages'	   => array('portfolio_post'),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
			array(
				'label'	   => 'Portfolio Detail Text',
				'id'		  => '_portfolio_detail_text',
				'type'		=> 'text',
				'desc'		=> 'Enter the title for Portfolio details section.',
				'std'		 => '',
			),		
		)
	);
	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/
	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_portfolio_meta_boxes );
}
/**
 * Initialize the Avis About Page Meta Boxs. 
 */
add_action( 'admin_init', 'avis_about_page_meta_boxes' );
function avis_about_page_meta_boxes() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/
	$avis_about_page_meta_boxes = array(
	'id'		  => 'avis_about_page_meta_boxes',
	'title'	   => __( 'Avis : About Options', 'avis' ),
	'desc'		=> '',
	'pages'	   => array('page'),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
			array(
				'id'		  =>'_about_work_process_heading',
				'label'	   => __( 'About Work Process Heading', 'avis'),
				'desc'		=> 'Enter About Work Process Main Heading.',
				'std'		 => 'Work Process',
				'type'		=> 'text',
			),
			array(
				'id'		  =>'_about_work_process_desc',
				'label'	   => __( 'About Work Process Description', 'avis'),
				'desc'		=> 'Enter About Work Process Main Description.',
				'std'		 => '',
				'type'		=> 'textarea',
			),
			array(
				'id'		  =>'_about_work_process_html',
				'label'	   => __( 'About Work Process HTML', 'avis'),
				'desc'		=> 'Enter About Work Process HTML.',
				'std'		 => '',
				'type'		=> 'textarea',
			),
			array(
				'id'		  =>'_about_team_member_heading',
				'label'	   => __( 'About Team Member Heading', 'avis'),
				'desc'		=> 'Enter About Team Member Main Heading.',
				'std'		 => 'Meet The Team',
				'type'		=> 'text',
			),
			array(
				'id'		  =>'_about_team_member_desc',
				'label'	   => __( 'About Team Member Description', 'avis'),
				'desc'		=> 'Enter About Team Member Main Description.',
				'std'		 => '',
				'type'		=> 'textarea',
			),
		)
	);
	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/
	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_about_page_meta_boxes );
}

/**
 * Initialize the Avis About Page Meta Boxs. 
 */
add_action( 'admin_init', 'avis_portfolio_inner_meta_boxes' );
function avis_portfolio_inner_meta_boxes() 
{
	/**
	* Create a custom meta boxes array that we pass to 
	* the OptionTree Meta Box API Class.
	*/
	$avis_portfolio_inner_meta_boxes = array(
	'id'		  => 'avis_portfolio_inner_meta_boxes',
	'title'	   => __( 'Avis : Portfolio Options', 'avis' ),
	'desc'		=> '',
	'pages'	   => array('page'),
	'context'	 => 'normal',
	'priority'	=> 'high',
	'fields'	  => array(
			array(
				'id'		  => '_portfolio_inner_project_items',
				'label'	   => __( 'Select Project Categories', 'avis' ),
				'desc'		=> __( 'Select categories for inner portfolio section', 'avis' ),
				'std'		 => '',
				'type'		=> 'taxonomy-checkbox',
				'post_type'   => 'portfolio_post',
				'taxonomy'	=> 'portfolio_category',
			),
		)
	);
	/**
	* Register our meta boxes using the 
	* ot_register_meta_box() function.
	*/
	if ( function_exists( 'ot_register_meta_box' ) )
	ot_register_meta_box( $avis_portfolio_inner_meta_boxes );
}


?>