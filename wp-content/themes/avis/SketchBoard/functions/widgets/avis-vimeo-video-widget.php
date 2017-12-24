<?php
global $avis_themename;
global $avis_shortname;
/******************************************** 
SKT  Vimeo Video WIDGET START
*********************************************/
class SktVimeoVideoWidget extends WP_Widget {
	/** constructor */
	function __construct() {

		global $avis_themename;

		$widget_ops = array('classname' => 'sktvimeovideo', 'description' => 'Sketch Themes widget for Vimeo Video' );

		parent::__construct('SktVimeoVideoWidget',"Vimeo Video - $avis_themename", $widget_ops);	

	}
 
	/** @see WP_Widget::widget */
	function widget($args, $instance) {	
		global $avis_shortname;	
		extract( $args );
		$title = esc_attr($instance['title']);
		$vimeo_video_id = esc_attr($instance['vimeo_video_id']);						
		$vimeo_height = esc_attr($instance['vimeo_height']);	
		$vimeo_width = esc_attr($instance['vimeo_width']);
		$vimeo_autoplay   = $instance['vimeo_autoplay'];
		?>
			  <?php echo $before_widget; ?>
				<?php if ( $title )
					echo $before_title . $title . $after_title; ?>
					<div class="avis-vimeo-video"><iframe src="http://player.vimeo.com/video/<?php echo $vimeo_video_id; ?>?api=1&amp;player_id=vimeoplayer&amp;byline=1&amp;portrait=1&amp;autoplay=<?php echo $vimeo_autoplay; ?>" width="<?php echo $vimeo_width; ?>" height="<?php echo $vimeo_height; ?>" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>
				<?php echo $after_widget; ?>
			  <?php
	}
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['vimeo_video_id'] = strip_tags($new_instance['vimeo_video_id']);
	$instance['vimeo_height'] = strip_tags($new_instance['vimeo_height']);
	$instance['vimeo_width'] = strip_tags($new_instance['vimeo_width']);	
	$instance['vimeo_autoplay'] = $new_instance['vimeo_autoplay'];
		return $instance;
	}
	/** @see WP_Widget::form */
	function form($instance) {
		if(isset($instance['title'])){ $title = esc_attr($instance['title']); }
		if(isset($instance['vimeo_video_id'])){ $vimeo_video_id = esc_attr($instance['vimeo_video_id']);}
		if(isset($instance['vimeo_height'])){$vimeo_height = esc_attr($instance['vimeo_height']);}			
		if(isset($instance['vimeo_width'])){$vimeo_width = esc_attr($instance['vimeo_width']);}
		if(isset($instance['vimeo_autoplay'])){$vimeo_autoplay = $instance['vimeo_autoplay'];} else { $vimeo_autoplay = 0;} 
		?>
		 <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if(isset($title)){echo $title;} else { echo 'Vimeo';}  ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('vimeo_video_id'); ?>"><?php _e('Video ID:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('vimeo_video_id'); ?>" name="<?php echo $this->get_field_name('vimeo_video_id'); ?>" type="text" value="<?php if(isset($vimeo_video_id)){echo $vimeo_video_id;} else { echo '83742286';} ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('vimeo_height'); ?>"><?php _e('Video Height:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('vimeo_height'); ?>" name="<?php echo $this->get_field_name('vimeo_height'); ?>" type="text" value="<?php if(isset($vimeo_height)){echo $vimeo_height;} else { echo '152';} ?>" /></label></p>		 		
		 <p><label for="<?php echo $this->get_field_id('vimeo_width'); ?>"><?php _e('Video Width:','avis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('vimeo_width'); ?>" name="<?php echo $this->get_field_name('vimeo_width'); ?>" type="text" value="<?php if(isset($vimeo_width)){echo $vimeo_width;} else { echo '270';}?>" /></label></p>		 		
		 <p><label for="<?php echo $this->get_field_id('vimeo_autoplay'); ?>"><?php _e('AutoPlay:','avis'); ?><input class="checkbox" value="1" type="checkbox" <?php checked($vimeo_autoplay , 1 ); ?> id="<?php echo $this->get_field_id( 'vimeo_autoplay' ); ?>" name="<?php echo $this->get_field_name( 'vimeo_autoplay' ); ?>"  /></label></p>
		<?php 
	}
}
add_action('widgets_init', create_function('', 'return register_widget("SktVimeoVideoWidget");'));
/********************************************
Latest Posts WIDGET END
*********************************************/