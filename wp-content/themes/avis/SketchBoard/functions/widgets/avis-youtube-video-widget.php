<?php
global $avis_themename;
global $avis_shortname;
/********************************************
SKT YOUTUBE VIDEO WIDGET START
*********************************************/
class SktYoutubeVideoWidget extends WP_Widget {
	/** constructor */
	function __construct() {

		global $avis_themename;

		$widget_ops = array('classname' => 'sktyoutubevideo', 'description' => 'Sketch Themes widget for Youtube Video' );

		parent::__construct('SktYoutubeVideoWidget',"Youtube Video - $avis_themename", $widget_ops);	

	}
 
	/** @see WP_Widget::widget */
	function widget($args, $instance) {	
		global $avis_shortname;	
		extract( $args );
		$title = esc_attr($instance['title']);
		$video_id = esc_attr($instance['video_id']);							
		$you_height = esc_attr($instance['you_height']);	
		$you_width = esc_attr($instance['you_width']);
		if(isset($instance['you_autoplay'])){$you_autoplay = $instance['you_autoplay'];} else {$you_autoplay=0;}
		if(isset($instance['you_controls'])){$you_controls = $instance['you_controls'];} else {$you_controls=0;}
		$you_themelight = esc_attr($instance['you_themelight']);
		?>
			  <?php echo $before_widget; ?>
				<?php if ( $title )
					echo $before_title . $title . $after_title; ?>
					<div class="avis-youtube-video"><iframe width="<?php echo $you_width; ?>" height="<?php echo $you_height; ?>" src="http://www.youtube.com/embed/<?php echo $video_id; ?>?theme=<?php echo $you_themelight; ?>&amp;autoplay=<?php echo $you_autoplay; ?>&amp;controls=<?php echo $you_controls; ?>" allowfullscreen></iframe></div>
				<?php echo $after_widget; ?>
			  <?php
	}
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['video_id'] = strip_tags($new_instance['video_id']);
	$instance['you_height'] = strip_tags($new_instance['you_height']);
	$instance['you_width'] = strip_tags($new_instance['you_width']);	
	$instance['you_autoplay'] = $new_instance['you_autoplay'];
	$instance['you_controls'] = $new_instance['you_controls'];
	$instance['you_themelight'] = strip_tags($new_instance['you_themelight']);
		return $instance;
	}
	/** @see WP_Widget::form */
	function form($instance) {
		if(isset($instance['title'])){ $title = esc_attr($instance['title']); }
		if(isset($instance['video_id'])){ $video_id = esc_attr($instance['video_id']);}
		if(isset($instance['you_height'])){$you_height = esc_attr($instance['you_height']);}			
		if(isset($instance['you_width'])){$you_width = esc_attr($instance['you_width']);}
		if(isset($instance['you_autoplay'])){$you_autoplay = $instance['you_autoplay'];} else {$you_autoplay=0;}
		if(isset($instance['you_controls'])){$you_controls = $instance['you_controls'];} else {$you_controls=0;}
		if(isset($instance['you_themelight'])){$you_themelight = esc_attr($instance['you_themelight']);}
		if(empty($you_themelight)){$you_themelight=__('dark','avis');}
		?>
		 <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if(isset($title)){echo $title;} else { echo 'Youtube';}  ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('video_id'); ?>"><?php _e('Video ID:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('video_id'); ?>" name="<?php echo $this->get_field_name('video_id'); ?>" type="text" value="<?php if(isset($video_id)){echo $video_id;} else { echo 'czGtkInN3uA';} ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('you_height'); ?>"><?php _e('Video Height:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('you_height'); ?>" name="<?php echo $this->get_field_name('you_height'); ?>" type="text" value="<?php if(isset($you_height)){echo $you_height;} else { echo '152';}  ?>" /></label></p>		 		
		 <p><label for="<?php echo $this->get_field_id('you_width'); ?>"><?php _e('Video Width:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('you_width'); ?>" name="<?php echo $this->get_field_name('you_width'); ?>" type="text" value="<?php if(isset($you_width)){echo $you_width;} else { echo '270';}  ?>" /></label></p>		 		
		 <p><label for="<?php echo $this->get_field_id('you_autoplay'); ?>"><?php _e('AutoPlay:','avis'); ?><input class="checkbox" value="1" type="checkbox" <?php checked($you_autoplay , 1); ?> id="<?php echo $this->get_field_id( 'you_autoplay' ); ?>" name="<?php echo $this->get_field_name( 'you_autoplay' ); ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('you_controls'); ?>"><?php _e('Show Player Controls:','avis'); ?><input class="checkbox" value="1" type="checkbox" <?php checked($you_controls , 1); ?> id="<?php echo $this->get_field_id( 'you_controls' ); ?>" name="<?php echo $this->get_field_name( 'you_controls' ); ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('you_themelight'); ?>"><?php _e('Select Theme:','avis'); ?><select class="widefat" id="<?php echo $this->get_field_id('you_themelight'); ?>" name="<?php echo $this->get_field_name('you_themelight'); ?>"><option value="light" <?php selected('light', $you_themelight); ?>><?php _e('Light','avis');?></option><option value="dark" <?php selected('dark', $you_themelight); ?>><?php _e('Dark','avis');?></option></select></label></p>
		<?php 
	}
}
add_action('widgets_init', create_function('', 'return register_widget("SktYoutubeVideoWidget");'));
/********************************************
SKT-YOUTUBE-VIDEO WIDGET END
*********************************************/