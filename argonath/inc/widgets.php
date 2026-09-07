<?php

// custom widget for 125x125 University of Richmond ad banner
function widget_richmond_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;
		
	function widget_richmond($args) {
		extract($args);
		echo $before_widget;
		echo( '<a href="http://www.richmond.edu/" target="_blank">' );
		$bloginfo = get_bloginfo('stylesheet_directory');
		echo( '<img src="' . $bloginfo . '/img/bratach/richmond-shield.png" height="125" width="125" border="0" alt="The University of Richmond" />' );
		echo(' </a> ');
		echo( $after_widget );
	}

	register_sidebar_widget(array('125 x 125 University of Richmond Button', 'widgets'), 'widget_richmond');
}

// custom widget for 125x125 Project Argo ad banner
function widget_projectargo_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;
		
	function widget_projectargo($args) {
		extract($args);
		echo $before_widget;
		echo( '<a href="http://argoproject.org/" target="_blank">' );
		$bloginfo = get_bloginfo('stylesheet_directory');
		echo( '<img src="' . $bloginfo . '/img/bratach/projectargo.png" height="125" width="125" border="0" alt="Project Argo" />' );
		echo(' </a> ');
		echo( $after_widget );
	}

	register_sidebar_widget(array('125 x 125 Project Argo Button', 'widgets'), 'widget_projectargo');
}

// custom widget for 125x125 Out Project ad banner
function widget_atheism_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;
		
	function widget_atheism($args) {
		extract($args);
		echo $before_widget;
		echo( '<a href="http://outcampaign.org/" target="_blank">' );
		$bloginfo = get_bloginfo('stylesheet_directory');
		echo( '<img src="' . $bloginfo . '/img/bratach/out-campaign.png" height="125" width="125" border="0" alt="The Out Campaign" />' );
		echo(' </a> ');
		echo( $after_widget );
	}

	register_sidebar_widget(array('125 x 125 Out Campaign Button', 'widgets'), 'widget_atheism');
}

// custom widget to add 125x125 Opera ad banner
function widget_promote_opera_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;
		
	function widget_promote_opera($args) {
		extract($args);
		echo $before_widget;
		echo( '<a href="http://my.opera.com/community/download.pl?ref=allyngibson&p=opera_desktop" target="_blank">' );
		$bloginfo = get_bloginfo('stylesheet_directory');
		echo( '<img src="' . $bloginfo . '/img/bratach/opera.gif" height="125" width="125" border="0" alt="Opera" />' );
		echo(' </a> ');
		echo( $after_widget );
	}

	register_sidebar_widget(array('125 x 125 Opera Button', 'widgets'), 'widget_promote_opera');
}

// custom widget to add 125x125 NPR ad banner
function widget_promote_npr_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;
		
	function widget_promote_npr($args) {
		extract($args);
		echo $before_widget;
		echo( '<a href="http://www.npr.org/" target="_blank">' );
		$bloginfo = get_bloginfo('stylesheet_directory');
		echo( '<img src="' . $bloginfo . '/img/bratach/npr.png" height="125" width="125" border="0" alt="National Public Radio" />' );
		echo(' </a> ');
		echo( $after_widget );
	}

	register_sidebar_widget(array('125 x 125 NPR Button', 'widgets'), 'widget_promote_npr');
}

// custom widget to add 125x125 WordPress ad banner
function widget_wordpress_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;
		
	function widget_promote_wordpress($args) {
		extract($args);
		echo $before_widget;
		echo( '<a href="http://wordpress.org/" target="_blank">' );
		$bloginfo = get_bloginfo('stylesheet_directory');
		echo( '<img src="' . $bloginfo . '/img/bratach/wp-logo.png" height="125" width="125" border="0" alt="wordpress.org" />' );
		echo(' </a> ');
		echo( $after_widget );
	}

	register_sidebar_widget(array('125 x 125 WordPress Button', 'widgets'), 'widget_promote_wordpress');
}

// custom widget to add 468x60 Opera ad banner
function widget_promote_opera_banner_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;
		
	function widget_promote_opera_banner($args) {
		extract($args);
		echo $before_widget;
		echo( '<a href="http://my.opera.com/community/download.pl?ref=allyngibson&p=opera_desktop" target="_blank">' );
		$bloginfo = get_bloginfo('stylesheet_directory');
		echo( '<img src="' . $bloginfo . '/img/bratach/opera-wide.gif" height="60" width="468" border="0" alt="Opera" />' );
		echo(' </a> ');
		echo( $after_widget );
	}

	register_sidebar_widget(array('468 x 60 Opera Banner', 'widgets'), 'widget_promote_opera_banner');
}

function argonath_tag_cloud( $args = '' ) {
	$defaults = array(
		'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 45,
		'format' => 'flat', 'orderby' => 'name', 'order' => 'ASC',
		'exclude' => '', 'include' => ''
	);
	$args = wp_parse_args( $args, $defaults );

	$tags = get_tags( array_merge($args, array('orderby' => 'count', 'order' => 'DESC')) ); // Always query top tags

	if ( empty($tags) )
		return;

	$return = generate_argonath_tag_cloud( $tags, $args ); // Here's where those top tags get sorted according to $args
	if ( is_wp_error( $return ) )
		return false;
	else 
		echo apply_filters( 'wp_tag_cloud', $return, $args );
}

function generate_argonath_tag_cloud( $tags, $args = '' ) {
	global $wp_rewrite;
	$defaults = array(
		'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 45,
		'format' => 'flat', 'orderby' => 'name', 'order' => 'ASC'
	);
	$args = wp_parse_args( $args, $defaults );
	extract($args);

	if ( !$tags )
		return;
	$counts = $tag_links = array();
	foreach ( (array) $tags as $tag ) {
		$counts[$tag->name] = $tag->count;
		$tag_links[$tag->name] = get_tag_link( $tag->term_id );
		if ( is_wp_error( $tag_links[$tag->name] ) )
			return $tag_links[$tag->name];
		$tag_ids[$tag->name] = $tag->term_id;
	}

	$min_count = min($counts);
	$spread = max($counts) - $min_count;
	if ( $spread <= 0 )
		$spread = 1;
	$font_spread = $largest - $smallest;
	if ( $font_spread <= 0 )
		$font_spread = 1;
	$font_step = $font_spread / $spread;

	// SQL cannot save you; this is a second (potentially different) sort on a subset of data.
	if ( 'name' == $orderby )
		uksort($counts, 'strnatcasecmp');
	else
		asort($counts);

	if ( 'DESC' == $order )
		$counts = array_reverse( $counts, true );

	$a = array();

	$rel = ( is_object($wp_rewrite) && $wp_rewrite->using_permalinks() ) ? ' rel="tag"' : '';

	foreach ( $counts as $tag => $count ) {
		$tag_id = $tag_ids[$tag];
		$tag_link = clean_url($tag_links[$tag]);
		$tag = str_replace(' ', '&nbsp;', wp_specialchars( $tag ));
		$font_sizing = $font_sizing = " style='font-size: " . ( $smallest + ( ( $count - $min_count ) * $font_step ) ) . "$unit;'";
		if ( $smallest == $largest ) $font_sizing = " style='font-size: " . $smallest . "$unit;'";
		if ( 'none' == $unit ) $font_sizing = "";
		$a[] = "<a href='$tag_link' class='tag-link-$tag_id' title='" . attribute_escape( sprintf( __('%d topics'), $count ) ) . "'$rel". $font_sizing .">$tag</a>";
	}

	switch ( $format ) :
	case 'array' :
		$return =& $a;
		break;
	case 'list' :
		$return = "<ul class='wp-tag-cloud'>\n\t<li>";
		$return .= join("</li>\n\t<li>", $a);
		$return .= "</li>\n</ul>\n";
		break;
	default :
		$return = join("\n", $a);
		break;
	endswitch;

	return apply_filters( 'wp_generate_tag_cloud', $return, $tags, $args );
}

class Argonath_Widget_Calendar extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_calendar', 'description' => __( 'A calendar of your site&#8217;s posts') );
		parent::__construct('calendar', __('Calendar'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		global $wpdb, $m, $monthnum, $year, $timedifference, $wp_locale, $posts;
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

		$key = md5( $m . $monthnum . $year );
		if ( $cache = wp_cache_get( 'get_calendar', 'calendar' ) ) {
			if ( isset( $cache[ $key ] ) ) {
				echo $cache[ $key ];
				return;
			}
		}

		ob_start();
		// Quick check. If we have no posts at all, abort!
		if ( !$posts ) {
			$gotsome = $wpdb->get_var("SELECT ID from $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC LIMIT 1");
			if ( !$gotsome )
				return;
		}

		if ( isset($_GET['w']) )
			$w = ''.intval($_GET['w']);

		// week_begins = 0 stands for Sunday
		$week_begins = intval(get_option('start_of_week'));
		$add_hours = intval(get_option('gmt_offset'));
		$add_minutes = intval(60 * (get_option('gmt_offset') - $add_hours));

		// Let's figure out when we are
		if ( !empty($monthnum) && !empty($year) ) {
			$thismonth = ''.zeroise(intval($monthnum), 2);
			$thisyear = ''.intval($year);
		} elseif ( !empty($w) ) {
			// We need to get the month from MySQL
			$thisyear = ''.intval(substr($m, 0, 4));
			$d = (($w - 1) * 7) + 6; //it seems MySQL's weeks disagree with PHP's
			$thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('${thisyear}0101', INTERVAL $d DAY) ), '%m')");
		} elseif ( !empty($m) ) {
			$calendar = substr($m, 0, 6);
			$thisyear = ''.intval(substr($m, 0, 4));
			if ( strlen($m) < 6 )
					$thismonth = '01';
			else
					$thismonth = ''.zeroise(intval(substr($m, 4, 2)), 2);
		} else {
			$thisyear = gmdate('Y', current_time('timestamp'));
			$thismonth = gmdate('m', current_time('timestamp'));
		}

		$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);

		// Get the next and previous month and year with at least one post
		$previous = $wpdb->get_row("SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
			FROM $wpdb->posts
			WHERE post_date < '$thisyear-$thismonth-01'
			AND post_type = 'post' AND post_status = 'publish'
				ORDER BY post_date DESC
				LIMIT 1");
		$next = $wpdb->get_row("SELECT	DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
			FROM $wpdb->posts
			WHERE post_date >	'$thisyear-$thismonth-01'
			AND MONTH( post_date ) != MONTH( '$thisyear-$thismonth-01' )
			AND post_type = 'post' AND post_status = 'publish'
				ORDER	BY post_date ASC
				LIMIT 1");

		echo $before_widget . $before_title . $wp_locale->get_month($thismonth) . ' ' . date('Y', $unixmonth) . $after_title;
		echo '<div id="calendar_wrap">';

		echo '<table id="wp-calendar" summary="' . __('Calendar') . '">
		<thead>
		<tr>';

		$myweek = array();

		for ( $wdcount=0; $wdcount<=6; $wdcount++ ) {
			$myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
		}

		foreach ( $myweek as $wd ) {
			$day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
			echo "\n\t\t<th abbr=\"$wd\" scope=\"col\" title=\"$wd\">$day_name</th>";
		}

		echo '
		</tr>
		</thead>

		<tfoot>
		<tr>';

		if ( $previous ) {
			echo "\n\t\t".'<td abbr="' . $wp_locale->get_month($previous->month) . '" colspan="3" id="prev"><a href="' .
			get_month_link($previous->year, $previous->month) . '" title="' . sprintf(__('View posts for %1$s %2$s'), $wp_locale->get_month($previous->month),
				date('Y', mktime(0, 0 , 0, $previous->month, 1, $previous->year))) . '">&laquo; ' . $wp_locale->get_month_abbrev($wp_locale->get_month($previous->month)) . '</a></td>';
		} else {
			echo "\n\t\t".'<td colspan="3" id="prev" class="pad">&nbsp;</td>';
		}

		echo "\n\t\t".'<td class="pad">&nbsp;</td>';

		if ( $next ) {
			echo "\n\t\t".'<td abbr="' . $wp_locale->get_month($next->month) . '" colspan="3" id="next"><a href="' .
			get_month_link($next->year, $next->month) . '" title="' . sprintf(__('View posts for %1$s %2$s'), $wp_locale->get_month($next->month),
				date('Y', mktime(0, 0 , 0, $next->month, 1, $next->year))) . '">' . $wp_locale->get_month_abbrev($wp_locale->get_month($next->month)) . ' &raquo;</a></td>';
		} else {
			echo "\n\t\t".'<td colspan="3" id="next" class="pad">&nbsp;</td>';
		}

		echo '
		</tr>
		</tfoot>

		<tbody>
		<tr>';

		// Get days with posts
		$dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(post_date)
			FROM $wpdb->posts WHERE MONTH(post_date) = '$thismonth'
			AND YEAR(post_date) = '$thisyear'
			AND post_type = 'post' AND post_status = 'publish'
			AND post_date < '" . current_time('mysql') . '\'', ARRAY_N);
		if ( $dayswithposts ) {
			foreach ( $dayswithposts as $daywith ) {
				$daywithpost[] = $daywith[0];
			}
		} else {
			$daywithpost = array();
		}

		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'camino') !== false || strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'safari') !== false)
			$ak_title_separator = "\n";
		else
			$ak_title_separator = ', ';

		$ak_titles_for_day = array();
		$ak_post_titles = $wpdb->get_results("SELECT post_title, DAYOFMONTH(post_date) as dom "
			."FROM $wpdb->posts "
			."WHERE YEAR(post_date) = '$thisyear' "
			."AND MONTH(post_date) = '$thismonth' "
			."AND post_date < '".current_time('mysql')."' "
			."AND post_type = 'post' AND post_status = 'publish'"
		);
		if ( $ak_post_titles ) {
			foreach ( $ak_post_titles as $ak_post_title ) {

					$post_title = apply_filters( "the_title", $ak_post_title->post_title );
					$post_title = str_replace('"', '&quot;', wptexturize( $post_title ));

					if ( empty($ak_titles_for_day['day_'.$ak_post_title->dom]) )
						$ak_titles_for_day['day_'.$ak_post_title->dom] = '';
					if ( empty($ak_titles_for_day["$ak_post_title->dom"]) ) // first one
						$ak_titles_for_day["$ak_post_title->dom"] = $post_title;
					else
						$ak_titles_for_day["$ak_post_title->dom"] .= $ak_title_separator . $post_title;
			}
		}


		// See how much we should pad in the beginning
		$pad = calendar_week_mod(date('w', $unixmonth)-$week_begins);
		if ( 0 != $pad )
			echo "\n\t\t".'<td colspan="'.$pad.'" class="pad">&nbsp;</td>';

		$daysinmonth = intval(date('t', $unixmonth));
		for ( $day = 1; $day <= $daysinmonth; ++$day ) {
			if ( isset($newrow) && $newrow )
				echo "\n\t</tr>\n\t<tr>\n\t\t";
			$newrow = false;

			if ( $day == gmdate('j', (time() + (get_option('gmt_offset') * 3600))) && $thismonth == gmdate('m', time()+(get_option('gmt_offset') * 3600)) && $thisyear == gmdate('Y', time()+(get_option('gmt_offset') * 3600)) )
				echo '<td id="today">';
			else
				echo '<td>';

			if ( in_array($day, $daywithpost) ) // any posts today?
					echo '<a href="' . get_day_link($thisyear, $thismonth, $day) . "\" title=\"$ak_titles_for_day[$day]\">$day</a>";
			else
				echo $day;
			echo '</td>';

			if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins) )
				$newrow = true;
		}

		$pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins);
		if ( $pad != 0 && $pad != 7 )
			echo "\n\t\t".'<td class="pad" colspan="'.$pad.'">&nbsp;</td>';

		echo "\n\t</tr>\n\t</tbody>\n\t</table>";

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		$cache[ $key ] = $output;
		wp_cache_set( 'get_calendar', $cache, 'calendar' );
		echo '</div>';
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
	}
}

class Argonath_Widget_Tag_Cloud extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( "Your most used tags in a list format") );
		parent::__construct('tag_cloud', __('Tag Cloud'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' == $current_taxonomy ) {
				$title = __('Tags');
			} else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);
		if ( !empty($instance['display']) ) {
			$display = $instance['display'];
		} else {
			$display = 20;
		}

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		echo '<div class="tagcloud">';
		argonath_tag_cloud( "unit=none&format=list&number=".$display."&orderby=name" );
		echo "</div>\n";
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
		return $instance;
	}

	function form( $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy($instance);
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Tags to Display:') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['display'] );} ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:') ?></label>
	<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
	<?php foreach ( get_object_taxonomies('post') as $taxonomy ) :
				$tax = get_taxonomy($taxonomy);
				if ( !$tax->show_tagcloud || empty($tax->labels->name) )
					continue;
	?>
		<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
	<?php endforeach; ?>
	</select></p><?php
	}

	function _get_current_taxonomy($instance) {
		if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
			return $instance['taxonomy'];

		return 'post_tag';
	}
}

class Argonath_Widget_Recent_Posts extends WP_Widget {

	function Argonath_Widget_Recent_Posts() {
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site") );
		$this->WP_Widget('recent-posts', __('Recent Posts'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
		if ( ! $number = absint( $instance['number'] ) )
 			$number = 10;

		$exclude1 = get_cat_ID('twitter');
		$exclude2 = get_cat_ID('drabble');
		$r = new WP_Query(array('posts_per_page' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'cat' => '-'.$exclude1.',-'.$exclude2));
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php  while ($r->have_posts()) : $r->the_post(); ?>
		<li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}

// initialize custom widgets
function argonath_register_widgets() {
	add_action( 'widgets_init', 'widget_atheism_init' );
	add_action( 'widgets_init', 'widget_projectargo_init' );
	add_action( 'widgets_init', 'widget_promote_npr_init' );
	add_action( 'widgets_init', 'widget_promote_opera_init' );
	add_action( 'widgets_init', 'widget_promote_opera_banner_init' );
	add_action( 'widgets_init', 'widget_richmond_init' );
	add_action( 'widgets_init', 'widget_wordpress_init' );
}

// initialize replacement widgets
function argonath_replacement_widgets() {
	register_widget( 'Argonath_Widget_Calendar' );
	register_widget( 'Argonath_Widget_Recent_Posts' );
	register_widget( 'Argonath_Widget_Tag_Cloud' );
}

// deregister default WordPress widgets
function argonath_deregister_widgets() {
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
}

?>