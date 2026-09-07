<?php
/*
Plugin Name: My Tweets Widget
Description: This plugin creates a widget that allows you to pull in your latest tweets to display on your site.
Author: Nathan Rice
Author URI: http://www.nathanrice.net/
Version: 1.0
*/

add_action('widgets_init', create_function('', "register_widget('My_Tweets_Widget');"));
class My_Tweets_Widget extends WP_Widget {

	function My_Tweets_Widget() {
		$widget_ops = array( 'classname' => 'mytweets', 'description' => 'Display your latest tweets in a widget' );
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'my-tweets-widget' );
		$this->WP_Widget( 'my-tweets-widget', 'My Tweets', $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		
		$scripts = '<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>'."\n".'<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/'.$instance['twitter_id'].'.json?callback=twitterCallback2&amp;count='.$instance['twitter_num'].'"></script>'."\n";
		
		echo $before_widget;
		
			echo '<div class="twitter">';
			if ($instance['title']) echo $before_title . $instance['title'] . $after_title;
			echo '<ul id="twitter_update_list"></ul></div>';
			echo $scripts;
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) { ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title"); ?>:</label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter_id'); ?>"><?php _e('Twitter Username'); ?>:</label>
			<input id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" value ="<?php echo $instance['twitter_id']; ?>" style="width: 95%;" />
		</p>
		
		<p>	
			<label for="<?php echo $this->get_field_id('twitter_num'); ?>"><?php _e('Number of Tweets to Show'); ?>:</label>
			<input id="<?php echo $this->get_field_id('twitter_num'); ?>" name="<?php echo $this->get_field_name('twitter_num'); ?>" value ="<?php echo $instance['twitter_num']; ?>" size="3" />
		</p>
	<?php 
	}
}
?>