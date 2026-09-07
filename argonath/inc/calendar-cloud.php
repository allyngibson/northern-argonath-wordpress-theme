<?php
/*
  Plugin Name: Calendar Archives Plugin
  Plugin URI: http://blog.deadbeaf.org/wp_calendar_cloud_plugin/
  Description: Presents archives as a yearly calendar
  Version: 0.5
  Author: Allyn Gibson
  Author URI: http://blog.deadbeaf.org/


  Copyright 2007  Motohiro Takayama  (mootoh@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function argonath_calendar_cloud() {
	global $wpdb, $wp_locale;
	$smallest = 10;
	$largest = 35;
	$unit = 'pt';
	$number = 45;

	$after = '';
	$show_post_count = false;

	$arcresults = $wpdb->get_results("SELECT DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC" . $limit);
	if ( $arcresults ) {
		$afterafter = $after;
		foreach ( $arcresults as $arcresult ) {
			$url  = get_month_link($arcresult->year,  $arcresult->month);
			$text = sprintf(__('%1$s %2$d'), $wp_locale->get_month($arcresult->month), $arcresult->year);
		}
	}

	$ret = $counts = array();

	foreach ( $arcresults as $arcresult ) {
		$counts[$arcresult->year.'-'.$arcresult->month] = $arcresult->posts;
		if (!$ret[$arcresult->year]) {
			$ret[$arcresult->year] = array();
		}
		$ret[$arcresult->year][$arcresult->month] = $arcresult->posts;
	}

	$min_count = min($counts);
	$spread = max($counts) - $min_count;
	if ( $spread <= 0 )
		$spread = 1;
	$font_spread = $largest - $smallest;
	if ( $font_spread <= 0 )
		$font_spread = 1;
	$font_step = $font_spread / $spread;

	print ('<div class="calendar-cloud">');
	foreach ($ret as $year => $val) {
		if (0 == $year) continue;

		print ('<div class="year">'.$year.'</div>');
		print ('<div class="month">');
		for ($i=1; $i<=12; $i++) {
			$v = $val[$i];
			if ($v) {
				$url  = get_month_link($year, $i);
				$size = ($smallest + ( ( $v - $min_count ) * $font_step )).'pt';
				print('<span><a title="'.$v.' entries" href="'.$url.'" style="font-size:'.$size.';">'.$i.'</a></span>');
			} else {
				print ('<span class="absent">'.$i.'</span>');
			}
			if ($i % 6 == 0) {
				print("<br/>");
			}
		}
		/*
			 foreach ($val as $month) {
			 print($month[0].':'.$month[1].', ');
			 }
		 */
		print ('</div>');
	}
	//print(count($ret));
	print('</div>');
}

function get_argonath_archive_calendar($initial = true) {
	global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;

	$cache = array();
	$key = md5( $m . $monthnum . $year );
	if ( $cache = wp_cache_get( 'get_calendar', 'calendar' ) ) {
		if ( is_array($cache) && isset( $cache[ $key ] ) ) {
			echo $cache[ $key ];
			return;
		}
	}

	if ( !is_array($cache) )
		$cache = array();

	// Quick check. If we have no posts at all, abort!
	if ( !$posts ) {
		$gotsome = $wpdb->get_var("SELECT 1 as test FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' LIMIT 1");
		if ( !$gotsome ) {
			$cache[ $key ] = '';
			wp_cache_set( 'get_calendar', $cache, 'calendar' );
			return;
		}
	}

	ob_start();
	if ( isset($_GET['w']) )
		$w = ''.intval($_GET['w']);

	// week_begins = 0 stands for Sunday
	$week_begins = intval(get_option('start_of_week'));

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

	/* translators: Calendar caption: 1: month name, 2: 4-digit year */
	$calendar_caption = _x('%1$s %2$s', 'calendar caption');
	echo '<table class="wp-calendar" summary="' . esc_attr__('Calendar') . '">
	<caption>' . sprintf($calendar_caption, $wp_locale->get_month($thismonth), date('Y', $unixmonth)) . '</caption>
	<thead>
	<tr>';

	$myweek = array();

	for ( $wdcount=0; $wdcount<=6; $wdcount++ ) {
		$myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
	}

	foreach ( $myweek as $wd ) {
		$day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
		$wd = esc_attr($wd);
		echo "\n\t\t<th abbr=\"$wd\" scope=\"col\" title=\"$wd\">$day_name</th>";
	}

	echo '
	</tr>
	</thead>

	<tfoot>
	<tr>';

	echo "\n\t\t".'<td class="pad">&nbsp;</td>';

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
		foreach ( (array) $dayswithposts as $daywith ) {
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
		foreach ( (array) $ak_post_titles as $ak_post_title ) {

				$post_title = esc_attr( apply_filters( 'the_title', $ak_post_title->post_title ) );

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
		echo "\n\t\t".'<td colspan="'. esc_attr($pad) .'" class="pad">&nbsp;</td>';

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
				echo '<a href="' . get_day_link($thisyear, $thismonth, $day) . "\" title=\"" . esc_attr($ak_titles_for_day[$day]) . "\">$day</a>";
		else
			echo $day;
		echo '</td>';

		if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins) )
			$newrow = true;
	}

	$pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins);
	if ( $pad != 0 && $pad != 7 )
		echo "\n\t\t".'<td class="pad" colspan="'. esc_attr($pad) .'">&nbsp;</td>';

	echo "\n\t</tr>\n\t</tbody>\n\t</table>";

	$output = ob_get_contents();
	ob_end_clean();
	echo $output;
	$cache[ $key ] = $output;
	wp_cache_set( 'get_calendar', $cache, 'calendar' );
}

function argonath_calendar_archive() {
	global $wpdb, $wp_locale, $m;

	$after = '';

	$arcresults = $wpdb->get_results("SELECT DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC" . $limit);
	if ( $arcresults ) {
		$afterafter = $after;
		foreach ( $arcresults as $arcresult ) {
			$url  = get_month_link($arcresult->year,  $arcresult->month);
			$text = sprintf(__('%1$s %2$d'), $wp_locale->get_month($arcresult->month), $arcresult->year);
		}
	}

	$ret = $counts = array();

	foreach ( $arcresults as $arcresult ) {
		$counts[$arcresult->year.'-'.$arcresult->month] = $arcresult->posts;
		if (!$ret[$arcresult->year]) {
			$ret[$arcresult->year] = array();
		}
		$ret[$arcresult->year][$arcresult->month] = $arcresult->posts;
	}

	print ('<div class="calendar-archives">');
	foreach ($ret as $year => $val) {
		if (0 == $year) continue;

		$thisyear = strval( $year );
		print ('<div class="year">'.$year.'</div>');
		print ('<table width="100%" class="month"><tr>');
		for ($i=1; $i<=12; $i++) {
			$thismonth = intval( $i );
			$thismonth = strval ( $i );
			if ( $i < 10 ) $thismonth = '0'.$thismonth;
			$unixmonth = $thisyear.$thismonth; 
			print('<td valign="top" width="33%">');
			$m = get_the_time( $unixmonth);
			get_argonath_archive_calendar();
			print('</td>');

			if ($i % 2 == 0) {
				print("</tr>");
			}
		}
		/*
			 foreach ($val as $month) {
			 print($month[0].':'.$month[1].', ');
			 }
		 */
		print ('</table>');
	}
	//print(count($ret));
	print('</div>');
}
?>
