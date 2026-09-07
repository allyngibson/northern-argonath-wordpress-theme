<?php

// determine page ID by page slug
function argonath_get_ID_by_page_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

// remove pages from search results
function argonath_search_filter($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}

// determine number of posts to show on the homepage
function argonath_homepage_posts() {
	global $add_my_script;
	$add_my_script = true;

	$post_quantity = get_option( 'posts_per_page' );

	$argonath_homepage_posts = 10;
	if ( $post_quantity < 18 ) $argonath_homepage_posts = 8;
	if ( $post_quantity < 14 ) $argonath_homepage_posts = 6;
	if ( $post_quantity < 10 ) $argonath_homepage_posts = 4;
	if ( $post_quantity < 6 ) $argonath_homepage_posts = 2;

	return $argonath_homepage_posts;
}

// activate excerpts for pages
add_post_type_support( 'page', 'excerpt' );

// add categories and tags to pages
function tags_for_pages() {
	register_taxonomy_for_object_type('post_tag', 'page');
	register_taxonomy_for_object_type('category', 'page');
}
 
// prevent self-pinging
function no_self_ping( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link )
		if ( 0 === strpos( $link, $home ) )
			unset($links[$l]);
}

// add post tags to page header
function argonath_post_keywords() {
	global $post;
	if( is_single() || is_page() || is_home() ) :
		$tags = get_the_tags($post->ID);
		if($tags) :
			foreach($tags as $tag) :
				$sep = (empty($keywords)) ? '' : ', ';
				$keywords .= $sep . $tag->name;
			endforeach;
			echo( '<meta name="keywords" content="' . $keywords . '" />' );
		endif;
	endif;
}

// filter for wp_list_pages to exclude pages in the Feeds
// and Hidden categories
function argonath_page_filter($exclude_array) {
	global $wpdb;
	$table = $wpdb->prefix . "posts";

	//get categories IDs from slugs
	$exclude_cat_1 = get_category_by_slug( 'feeds' );
	$exclude_cat_2 = get_category_by_slug( 'hidden' );
 
	//list of categories to exclude
	$exclude_list = $exclude_cat_1->cat_ID . ', ' . $exclude_cat_2->cat_ID;

	$sql = "SELECT ID FROM $wpdb->posts ";
	$sql = $sql. "LEFT JOIN $wpdb->term_relationships ON ";
	$sql = $sql. "($wpdb->posts.ID = $wpdb->term_relationships.object_id) ";
	$sql = $sql. "LEFT JOIN $wpdb->term_taxonomy ON ";
	$sql = $sql. "($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) ";
	$sql = $sql. "WHERE post_type = 'page' AND $wpdb->posts.post_status = 'publish' ";
	$sql = $sql. "AND $wpdb->term_taxonomy.taxonomy = 'category' ";
	$sql = $sql. "AND $wpdb->term_taxonomy.term_id IN ($exclude_list)";

	$id_array = $wpdb->get_col( $sql );
	$exclude_array = array_merge( $id_array, $exclude_array );
	return $exclude_array;
}

?>