<?php

function argonath_archives() {
	global $month, $wpdb;
	$now = current_time('mysql');

	//get categories IDs from slugs
	$exclude_cat_1 = get_category_by_slug("podcast");
	$exclude_cat_2 = get_category_by_slug("twitter");
 
	//list of categories to exclude
	$exclude_list = $exclude_cat_1->cat_ID . ', ' . $exclude_cat_2->cat_ID;
			
	$sql1 = "SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month, count(ID) as posts ";
	$sql1 = $sql1 . "LEFT JOIN $wpdb->term_relationships ON ";
	$sql1 = $sql1 . "($wpdb->posts.ID = $wpdb->term_relationships.object_id) ";
	$sql1 = $sql1 . "LEFT JOIN $wpdb->term_taxonomy ON ";
	$sql1 = $sql1 . "($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) ";
	$sql1 = $sql1 . "FROM " . $wpdb->posts . " WHERE post_date <'" . $now . "' ";
	$sql1 = $sql1 . "AND post_status='publish' AND post_password='' AND post_type='post' ";
	$sql1 = $sql1 . "AND $wpdb->term_taxonomy.term_id NOT IN ($exclude_list) ";
	$sql1 = $sql1 . "GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";

	echo( $sql1 . '<br />' );
	$arcresults = $wpdb->get_results( $sql1 );

	print_r( $arcresults );
	
	if ($arcresults) {
		foreach ($arcresults as $arcresult) {
			$url = get_month_link($arcresult->year, $arcresult->month);
			$text = sprintf('%s %d', $month[zeroise($arcresult->month,2)], $arcresult->year);
			echo get_archives_link($url, $text, '','<strong>','</strong>');
			
			$thismonth = zeroise($arcresult->month,2);
			$thisyear = $arcresult->year;

			$sql2 = "SELECT ID, post_date, post_title, comment_status ";
			$sql2 = $sql2 . "FROM " . $wpdb->posts . " ";
			$sql2 = $sql2 . "LEFT JOIN $wpdb->term_relationships ON ";
			$sql2 = $sql2 . "($wpdb->posts.ID = $wpdb->term_relationships.object_id) ";
			$sql2 = $sql2 . "LEFT JOIN $wpdb->term_taxonomy ON ";
			$sql2 = $sql2 . "($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) ";
			$sql2 = $sql2 . "WHERE post_date LIKE '$thisyear-$thismonth-%' ";
			$sql2 = $sql2 . "AND post_date <'" . $now . "' AND post_status='publish' ";
			$sql2 = $sql2 . "AND $wpdb->term_taxonomy.term_id NOT IN ($exclude_list) ";
			$sql2 = $sql2 . "AND post_password='' AND post_type='post' ORDER BY post_date DESC";

			$arcresults2 = $wpdb->get_results( $sql2 );
			
			if ($arcresults2) {
                echo "<ul class=\"postspermonth\">\n";
                foreach ($arcresults2 as $arcresult2) {
                       if ($arcresult2->post_date != '0000-00-00 00:00:00') {
                         $url       = get_permalink($arcresult2->ID);
                         $arc_title = $arcresult2->post_title;

                         if ($arc_title) $text = strip_tags($arc_title);
                        else $text = $arcresult2->ID;
                        $title_text = wp_specialchars($text, 1);

                          echo '<li>' . mysql2date('d', $arcresult2->post_date). ': ' . "<a href='$url' title='$title_text'>".wptexturize($text)."</a>";
						// Here is where you can enable comment count if you would like, just remove the /* from the front and back of the line below
						//Save the file and re-upload and you should have all your comment count again
                        /*$comments_count = $wpdb->get_var("SELECT COUNT(comment_id) FROM " . $wpdb->comments . " WHERE comment_post_ID=" . $arcresult2->ID . " AND comment_approved='1'");
                        if ($arcresult2->comment_status == "open" OR $comments_count > 0) echo ' (' . $comments_count . ')';*/
                        echo '</li>';
                     }
                }
                echo '</ul>';
            }
        }
    }
}
?>