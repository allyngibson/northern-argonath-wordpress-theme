<?php

// delay publication of posts on RSS feeds by half an hour
function publish_later_on_feed($where) {
	global $wpdb;

	if ( is_feed() ) {
		// timestamp in WP-format
		$now = gmdate('Y-m-d H:i:s');

		// value for wait; + device
		$wait = '30'; // integer

		// http://dev.mysql.com/doc/refman/5.0/en/date-and-time-functions.html#function_timestampdiff
		$device = 'MINUTE'; //MINUTE, HOUR, DAY, WEEK, MONTH, YEAR

		// add SQL-sytax to default $where
		$where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
	}
	return $where;
}

// remove category twitter posts from RSS feeds
function feed_category_exclude($query) {
	$exclude = get_cat_ID( 'twitter' );
	if ($query->is_feed) {
		$query->set( 'category__not_in', array( $exclude) );
	}
	return $query;
}

?>