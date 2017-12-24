<?php
global $avis_themename;
global $avis_shortname;
/********************************************
MultiSocialFeed WIDGET START
*********************************************/
class SktMultiSocialFeed extends WP_Widget {
	/** constructor */
	function __construct() {

		global $avis_themename;

		$widget_ops = array('classname' => 'sktmultisocialstream', 'description' => 'Sketch Themes widget for MultiSocialFeed' );

		parent::__construct('SktMultiSocialFeed',"MultiSocialFeed - $avis_themename", $widget_ops);	

	}
 
	/** @see WP_Widget::widget */
	function widget($args, $instance) {	
		global $avis_shortname;	
		extract( $args );
		$title = esc_attr($instance['title']);
		$user_name = esc_attr($instance['user_name']);							
		$num_posts = esc_attr($instance['num_posts']);	
		$social_network = esc_attr($instance['social_network']);
		if(empty($num_posts)){ $num_posts=2;}
		?>
			  <?php echo $before_widget; ?>
				<?php if ( $title )
						echo $before_title . $title . $after_title; ?>
						<script type="text/javascript">
							(function($){$.fn.extend({avis_social_pics:function(options){var defaults={username:"sketchthemes",limit:10,network_id:"pinterest"};function avis_htmlelement(data,container){var feeds=data.feed;if(!feeds)return false;var html="";html+="<ul class='clearfix'>";for(var i=0;i<feeds.entries.length;i++){var entry=feeds.entries[i];var content=entry.content;html+="<li>"+content+"</li>"}html+="</ul>";$(container).html(html);$(container).find("li").each(function(){pinterest_img_src=$(this).find("img").attr("src");pinterest_url=
							"http://www.pinterest.com"+$(this).find("a").attr("href");pinterest_desc=$(this).find("p:nth-child(2)").html();pinterest_desc=pinterest_desc.replace("'","`");$(this).empty();$(this).append("<a rel='testings[gallery]' href='"+pinterest_img_src+"'><img src='"+pinterest_img_src+"' alt=''></a>");var img_w=$(this).find("img").width();var img_h=$(this).find("img").height()})}var options=$.extend(defaults,options);return this.each(function(){var o=options;var obj=$(this);if(o.network_id==
							"dribbble"){obj.append("<ul class='clearfix'></ul>");$.getJSON("http://dribbble.com/"+o.username+"/shots.json?callback=?",function(data){$.each(data.shots,function(i,shot){if(i<o.limit){var img_title=shot.title;img_title=img_title.replace("'","`");var image=$("<img/>").attr({src:shot.image_teaser_url,alt:img_title});var url=$("<a/>").attr({href:shot.image_teaser_url,rel:"testings[gallery]"});var url2=$(url).append(image);var li=$("<li/>").append(url2);$("ul",obj).append(li)}});$("li img",obj).each(function(){var img_w=
							$(this).width();var img_h=$(this).height();if(img_w<img_h)$(this).addClass("portrait");else $(this).addClass("landscape")})})}if(o.network_id=="pinterest"){var url="http://pinterest.com/"+o.username+"/feed.rss";var api="http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&callback=?&q="+encodeURIComponent(url);api+="&num="+o.limit;api+="&output=json_xml";$.getJSON(api,function(data){if(data.responseStatus==200)avis_htmlelement(data.responseData,obj);else alert("Whoops. Wrong Pinterest Username.")})}if(o.network_id==
							"flickr"){obj.append("<ul class='clearfix'></ul>");$.getJSON("https://api.flickr.com/services/rest/?method=flickr.people.findByUsername&username="+o.username+"&format=json&api_key=85145f20ba1864d8ff559a3971a0a033&jsoncallback=?",function(data){var nsid=data.user.nsid;$.getJSON("https://api.flickr.com/services/rest/?method=flickr.photos.search&user_id="+nsid+"&format=json&api_key=85145f20ba1864d8ff559a3971a0a033&per_page="+o.limit+"&page=1&extras=url_z&jsoncallback=?",function(data){$.each(data.photos.photo,function(i,
							img){var img_owner=img.owner;var img_title=img.title;var img_src=img.url_z;var img_id=img.id;var img_url="http://www.flickr.com/photos/"+img_owner+"/"+img_id;var image=$("<img/>").attr({src:img_src,alt:img_title});var url=$("<a/>").attr({href:img_src,rel:"testings[gallery]"});var url2=$(url).append(image);var li=$("<li/>").append(url2);$("ul",obj).append(li)})})})}if(o.network_id=="instagram"){obj.append("<ul></ul>");var token="188312888.f79f8a6.1b920e7f642b4693a4cb346162bf7154";url="https://api.instagram.com/v1/users/search?q="+
							o.username+"&access_token="+token+"&count=1&callback=?";$.getJSON(url,function(data){$.each(data.data,function(i,shot){var instagram_username=shot.username;if(instagram_username==o.username){var user_id=shot.id;if(user_id!=""){url="https://api.instagram.com/v1/users/"+user_id+"/media/recent/?access_token="+token+"&count="+o.limit+"&callback=?";$.getJSON(url,function(data){$.each(data.data,function(i,shot){var img_src=shot.images.thumbnail.url;var img_url=shot.link;var img_title="";if(shot.caption!=
							null)img_title=shot.caption.text;var image=$("<img/>").attr({src:img_src,alt:img_title});var url=$("<a/>").attr({href:img_src,rel:"testings[gallery]"});var url2=$(url).append(image);var li=$("<li/>").append(url2);$("ul",obj).append(li)})})}}})})}})}})})(jQuery);
							
							jQuery(document).ready(function() { 
								jQuery('#avis-stream-<?php echo $this->id;?>').avis_social_pics({username:"<?php echo $user_name; ?>",limit:<?php echo $num_posts; ?>,network_id:"<?php echo $social_network; ?>"});
							});	
							
							jQuery(window).load(function() { 
								jQuery("a[rel^='testings']").prettyPhoto({
									animation_speed:'normal',
									theme:'light_square',
									slideshow:3000,
									show_title:false,
									autoplay_slideshow: false,
									social_tools: false
								});
							});	
						</script>
						<div id="avis-stream-<?php echo $this->id;?>" class="clearfix"></div>
						
			 <?php echo $after_widget; ?>
				 <?php
	}
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['user_name'] = strip_tags($new_instance['user_name']);
	$instance['num_posts'] = strip_tags($new_instance['num_posts']);		
	$instance['social_network'] = strip_tags($new_instance['social_network']);
		return $instance;
	}
	/** @see WP_Widget::form */
	function form($instance) {
		if(isset($instance['title'])){$title = esc_attr($instance['title']);}
		if(isset($instance['user_name'])){$user_name = esc_attr($instance['user_name']);}
		if(isset($instance['num_posts'])){$num_posts = esc_attr($instance['num_posts']);}		
		if(isset($instance['social_network'])){$social_network = esc_attr($instance['social_network']);		}
		if(empty($num_posts)){ $num_posts=4;}
		if(empty($social_network)) {$social_network= __('pinterest','avis');}
		?>
		 <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if(isset($title)){echo $title;} else { echo 'MultiSocial';}  ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('user_name'); ?>"><?php _e('Username:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('user_name'); ?>" name="<?php echo $this->get_field_name('user_name'); ?>" type="text" value="<?php if(isset($user_name)){echo $user_name;} else { echo 'sketchthemes';} ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e('Number Of Post: eg:4','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" type="text" value="<?php if(isset($num_posts)){echo $num_posts;} ?>" /></label></p>		 		
		 <p>
			 <label for="<?php echo $this->get_field_id('social_network'); ?>"><?php _e('Select Network:','avis'); ?>
				 <select class="widefat" id="<?php echo $this->get_field_id('social_network'); ?>" name="<?php echo $this->get_field_name('social_network'); ?>">
					 <option value="pinterest" <?php selected('pinterest', $social_network); ?>><?php _e('Pinterest','avis');?></option>
					 <option value="dribbble" <?php selected('dribbble', $social_network); ?>><?php _e('Dribbble','avis');?></option>
					 <option value="flickr" <?php selected('flickr', $social_network); ?>><?php _e('Flickr','avis');?></option>
					 <option value="instagram" <?php selected('instagram', $social_network); ?>><?php _e('Instagram','avis');?></option>
				 </select>
			 </label>
		</p>
		<?php 
	}
	
	
}
add_action('widgets_init', create_function('', 'return register_widget("SktMultiSocialFeed");'));
/********************************************
Latest Posts WIDGET END
*********************************************/
