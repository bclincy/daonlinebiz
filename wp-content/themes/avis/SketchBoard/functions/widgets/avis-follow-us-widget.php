<?php
global $avis_themename;
global $avis_shortname;
/********************************************
Follow Us WIDGET START
*********************************************/
class SktFollowWidget extends WP_Widget {
	/** constructor */
	function __construct() {

		global $avis_themename;

		$widget_ops = array('classname' => 'SktFollowContact', 'description' => "Sketch Themes widget for Follow Us - $avis_themename footer" );

		parent::__construct('SktFollowWidget',"Follow Us - $avis_themename",$widget_ops);	

	}
 
	/** @see WP_Widget::widget */
	function widget($args, $instance) {		
		extract( $args );
		$title = esc_attr($instance['title']);
		if(empty($title))
		{
			$title=__('Follow Us','avis');
		}				
		if(isset($instance['follow_linkedin'])&&$instance['follow_linkedin']!=''){$follow_linkedin = esc_url($instance['follow_linkedin']); }
		if(isset($instance['follow_facebook'])&&$instance['follow_facebook']!=''){$follow_facebook = esc_url($instance['follow_facebook']); }
		if(isset($instance['follow_twitter'])&&$instance['follow_twitter']!=''){$follow_twitter = esc_url($instance['follow_twitter']); }
		if(isset($instance['follow_flickr'])&&$instance['follow_flickr']!=''){$follow_flickr = esc_url($instance['follow_flickr']); }
		if(isset($instance['follow_gplusicon'])&&$instance['follow_gplusicon']!=''){$follow_gplusicon = esc_url($instance['follow_gplusicon']); }
		if(isset($instance['follow_skype'])&&$instance['follow_skype']!=''){$follow_skype = $instance['follow_skype']; }
		if(isset($instance['follow_youtube'])&&$instance['follow_youtube']!=''){$follow_youtube = esc_url($instance['follow_youtube']); }
		if(isset($instance['follow_dribble'])&&$instance['follow_dribble']!=''){$follow_dribble = esc_url($instance['follow_dribble']); }
		if(isset($instance['follow_pinterest'])&&$instance['follow_pinterest']!=''){ $follow_pinterest = esc_url($instance['follow_pinterest']); }
		if(isset($instance['follow_tumblr'])&&$instance['follow_tumblr']!=''){$follow_tumblr = esc_url($instance['follow_tumblr']); }
		if(isset($instance['follow_github'])&&$instance['follow_github']!=''){$follow_github = esc_url($instance['follow_github']); }
		if(isset($instance['follow_foursquare'])&&$instance['follow_foursquare']!=''){$follow_foursquare = esc_url($instance['follow_foursquare']); }
		if(isset($instance['follow_vk'])&&$instance['follow_vk']!=''){$follow_vk = esc_url($instance['follow_vk']); }
		if(isset($instance['follow_whatsapp'])&&$instance['follow_whatsapp']!=''){$follow_whatsapp = esc_url($instance['follow_whatsapp']); }
		if(isset($instance['follow_insta'])&&$instance['follow_insta']!=''){$follow_insta = esc_url($instance['follow_insta']); }
		?>
		<?php echo $before_widget; ?>
		<?php 
		if($title)
		echo $before_title . $title . $after_title; 
		?>
		<div class="follow-icons">
		<ul class="social clearfix"> 
		<?php if(isset($follow_linkedin)){ ?> <li class="linkedin-icon"> <a target="_blank" href="<?php echo $follow_linkedin;?>" title="Linkedin"></a></li> <?php } ?>
		<?php if(isset($follow_facebook)){ ?> <li class="facebook-icon"> <a target="_blank" href="<?php echo $follow_facebook;?>" title="Facebook"></a></li> <?php } ?>
		<?php if(isset($follow_twitter)){ ?> <li class="twitter-icon"> <a target="_blank" href="<?php echo $follow_twitter;?>" title="Twitter"></a></li> <?php } ?>
		<?php if(isset($follow_flickr)){ ?> <li class="flickr-icon"> <a target="_blank" href="<?php echo $follow_flickr;?>" title="Flickr"></a></li> <?php } ?>
		<?php if(isset($follow_gplusicon)){ ?> <li class="gplusicon-icon"> <a target="_blank" href="<?php echo $follow_gplusicon;?>" title="Googleplus"></a></li> <?php } ?>
		<?php if(isset($follow_skype)){ ?> <li class="skype-icon"> <a target="_blank" href="skype:<?php echo $follow_skype;?>?call" title="Skype"></a></li> <?php } ?>
		<?php if(isset($follow_youtube)){ ?> <li class="youtube-icon"> <a target="_blank" href="<?php echo $follow_youtube;?>" title="Youtube"></a></li> <?php } ?>
		<?php if(isset($follow_dribble)){ ?> <li class="dribble-icon"> <a target="_blank" href="<?php echo $follow_dribble;?>" title="Dribbble"></a></li> <?php } ?>
		<?php if(isset($follow_pinterest)){ ?> <li class="pinterest-icon"> <a target="_blank" href="<?php echo $follow_pinterest;?>" title="Pinterest"></a></li> <?php } ?>
		<?php if(isset($follow_tumblr)){ ?> <li class="tumblr-icon"> <a target="_blank" href="<?php echo $follow_tumblr;?>" title="Tumblr"></a></li> <?php } ?>
		<?php if(isset($follow_github)){ ?> <li class="github-icon"> <a target="_blank" href="<?php echo $follow_github;?>" title="Github"></a></li> <?php } ?>
		<?php if(isset($follow_foursquare)){ ?> <li class="foursquare-icon"> <a target="_blank" href="<?php echo $follow_foursquare;?>" title="Foursquare"></a></li> <?php } ?>
		<?php if(isset($follow_vk)){ ?> <li class="vk-icon"> <a target="_blank" href="<?php echo $follow_vk;?>" title="VK"></a></li> <?php } ?>
		<?php if(isset($follow_whatsapp)){ ?> <li class="whatsapp-icon"> <a target="_blank" href="<?php echo $follow_whatsapp;?>" title="VK"></a></li> <?php } ?>
		<?php if(isset($follow_insta)){ ?> <li class="insta-icon"> <a target="_blank" href="<?php echo $follow_insta;?>" title="VK"></a></li> <?php } ?>
		 </ul>
		<div class="clear"></div>
		</div>
		<?php echo $after_widget; ?>
		<?php
	}
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['follow_linkedin'] = esc_url($new_instance['follow_linkedin']);
		$instance['follow_facebook'] = esc_url($new_instance['follow_facebook']);
		$instance['follow_twitter'] = esc_url($new_instance['follow_twitter']);
		$instance['follow_flickr'] = esc_url($new_instance['follow_flickr']);
		$instance['follow_gplusicon'] = esc_url($new_instance['follow_gplusicon']);
		$instance['follow_skype'] = $new_instance['follow_skype'];
		$instance['follow_youtube'] = esc_url($new_instance['follow_youtube']);
		$instance['follow_dribble'] = esc_url($new_instance['follow_dribble']);
		$instance['follow_pinterest'] = esc_url($new_instance['follow_pinterest']);
		$instance['follow_tumblr'] = esc_url($new_instance['follow_tumblr']);
		$instance['follow_github'] = esc_url($new_instance['follow_github']);
		$instance['follow_foursquare'] = esc_url($new_instance['follow_foursquare']);
		$instance['follow_vk'] = esc_url($new_instance['follow_vk']);
		$instance['follow_whatsapp'] = esc_url($new_instance['follow_whatsapp']);
		$instance['follow_insta'] = esc_url($new_instance['follow_insta']);
		return $instance;
	}
	/** @see WP_Widget::form */
	function form($instance) {
	  if(isset($instance['title'])){
		$title = esc_attr($instance['title']);				
	}
	 if(isset($instance['follow_linkedin'])){
			$follow_linkedin = esc_url($instance['follow_linkedin']);
		}
	 if(isset($instance['follow_facebook'])){
		$follow_facebook = esc_url($instance['follow_facebook']);
	 }
	 if(isset($instance['follow_twitter'])){
		$follow_twitter = esc_url($instance['follow_twitter']);
	}
	 if(isset($instance['follow_flickr'])){
		$follow_flickr = esc_url($instance['follow_flickr']);
	  }	  
	  if(isset($instance['follow_gplusicon'])){
		$follow_gplusicon = esc_url($instance['follow_gplusicon']);
	  }
	  if(isset($instance['follow_skype'])){
		$follow_skype = $instance['follow_skype'];
	  }
	  if(isset($instance['follow_youtube'])){
		$follow_youtube = esc_url($instance['follow_youtube']);
	  }
	  if(isset($instance['follow_dribble'])){
		$follow_dribble = esc_url($instance['follow_dribble']);
	  }
	  if(isset($instance['follow_pinterest'])){
		$follow_pinterest = esc_url($instance['follow_pinterest']);
	  }
	  if(isset($instance['follow_tumblr'])){
		$follow_tumblr = esc_url($instance['follow_tumblr']);
	  }
	  if(isset($instance['follow_github'])){
		$follow_github = esc_url($instance['follow_github']);
	  }
	  if(isset($instance['follow_foursquare'])){
				$follow_foursquare = esc_url($instance['follow_foursquare']);
	  }
	  if(isset($instance['follow_vk'])){
				$follow_vk = esc_url($instance['follow_vk']);
	  }
	  if(isset($instance['follow_whatsapp'])){
				$follow_whatsapp = esc_url($instance['follow_whatsapp']);
	  }
	  if(isset($instance['follow_insta'])){
				$follow_insta = esc_url($instance['follow_insta']);
	  }
	  
		?>
		 <p>
		 <label for="<?php echo $this->get_field_id('title'); ?>">
		 <?php _e('Title:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if(isset($title)){ echo $title; } ?>" />
		 </label></p>
		 <p>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_linkedin'); ?>"><?php _e('Link for Linkedin','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_linkedin'); ?>" name="<?php echo $this->get_field_name('follow_linkedin'); ?>" type="text" value="<?php if(isset($follow_linkedin)){ echo $follow_linkedin; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_facebook'); ?>"><?php _e('Link for Facebook','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_facebook'); ?>" name="<?php echo $this->get_field_name('follow_facebook'); ?>" type="text" value="<?php if(isset($follow_facebook)){ echo $follow_facebook; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_twitter'); ?>"><?php _e('Link for Twitter','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_twitter'); ?>" name="<?php echo $this->get_field_name('follow_twitter'); ?>" type="text" value="<?php if(isset($follow_twitter)){ echo $follow_twitter; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_flickr'); ?>"><?php _e('Link for Flickr','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_flickr'); ?>" name="<?php echo $this->get_field_name('follow_flickr'); ?>" type="text" value="<?php if(isset($follow_flickr)){ echo $follow_flickr; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_gplusicon'); ?>"><?php _e('Link for Google+','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_gplusicon'); ?>" name="<?php echo $this->get_field_name('follow_gplusicon'); ?>" type="text" value="<?php if(isset($follow_gplusicon)){ echo $follow_gplusicon; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_skype'); ?>"><?php _e('Skype UserID','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_skype'); ?>" name="<?php echo $this->get_field_name('follow_skype'); ?>" type="text" value="<?php if(isset($follow_skype)){ echo $follow_skype; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_youtube'); ?>"><?php _e('Link for YouTube','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_youtube'); ?>" name="<?php echo $this->get_field_name('follow_youtube'); ?>" type="text" value="<?php if(isset($follow_youtube)){ echo $follow_youtube; }?>" /></label>
		 </p>
		  <p>
			<label for="<?php echo $this->get_field_id('follow_dribble'); ?>"><?php _e('Link for Dribbble','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_dribble'); ?>" name="<?php echo $this->get_field_name('follow_dribble'); ?>" type="text" value="<?php if(isset($follow_dribble)){ echo $follow_dribble; }?>" /></label>
		 </p>
		  <p>
			<label for="<?php echo $this->get_field_id('follow_pinterest'); ?>"><?php _e('Link for Pinterest','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_pinterest'); ?>" name="<?php echo $this->get_field_name('follow_pinterest'); ?>" type="text" value="<?php if(isset($follow_pinterest)){ echo $follow_pinterest; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_tumblr'); ?>"><?php _e('Link for Tumblr','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_tumblr'); ?>" name="<?php echo $this->get_field_name('follow_tumblr'); ?>" type="text" value="<?php if(isset($follow_tumblr)){ echo $follow_tumblr; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_github'); ?>"><?php _e('Link for Github','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_github'); ?>" name="<?php echo $this->get_field_name('follow_github'); ?>" type="text" value="<?php if(isset($follow_github)){ echo $follow_github; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_foursquare'); ?>"><?php _e('Link for Foursquar','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_foursquare'); ?>" name="<?php echo $this->get_field_name('follow_foursquare'); ?>" type="text" value="<?php if(isset($follow_foursquare)){ echo $follow_foursquare; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_vk'); ?>"><?php _e('Link for VK','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_vk'); ?>" name="<?php echo $this->get_field_name('follow_vk'); ?>" type="text" value="<?php if(isset($follow_vk)){ echo $follow_vk; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_whatsapp'); ?>"><?php _e('Link for WhatsApp','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_whatsapp'); ?>" name="<?php echo $this->get_field_name('follow_whatsapp'); ?>" type="text" value="<?php if(isset($follow_whatsapp)){ echo $follow_whatsapp; }?>" /></label>
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('follow_insta'); ?>"><?php _e('Link for Instagram','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('follow_insta'); ?>" name="<?php echo $this->get_field_name('follow_insta'); ?>" type="text" value="<?php if(isset($follow_insta)){ echo $follow_insta; }?>" /></label>
		 </p>
		<?php 
	}
}
add_action('widgets_init', create_function('', 'return register_widget("SktFollowWidget");'));
/********************************************
Follow us and contact WIDGET END
*********************************************/