<?php

require_once( STYLESHEETPATH . '/inc/archives.php' );
require_once( STYLESHEETPATH . '/inc/calendar-cloud.php' );
require_once( STYLESHEETPATH . '/inc/fonts.php' );
require_once( STYLESHEETPATH . '/inc/images.php' );
require_once( STYLESHEETPATH . '/inc/limit-post.php' );
require_once( STYLESHEETPATH . '/inc/nav-menus.php' );
require_once( STYLESHEETPATH . '/inc/pages.php' );
require_once( STYLESHEETPATH . '/inc/rss.php' );
require_once( STYLESHEETPATH . '/inc/sidebars.php' );
require_once( STYLESHEETPATH . '/inc/taxonomies.php' );
require_once( STYLESHEETPATH . '/inc/widgets.php' );


function register_argonath_script() {
	wp_register_script( 's3Slider', get_bloginfo('stylesheet_directory') . '/js/jquery-s3slider.js', array( 'jquery' ), false, true );
	wp_register_script( 's3Slider-setup', get_bloginfo('stylesheet_directory') . '/js/jquery-s3slider.setup.js', array( 'jquery' ), false, true );
}
 
function print_argonath_script() {
	global $add_argonath_script;

	if ( !$add_argonath_script ) return;
	wp_print_scripts('s3Slider');
	wp_print_scripts('s3Slider-setup');
}

function jptweak_remove_share() {
	// Taken from http://jetpack.me/2013/06/10/moving-sharing-icons/
	if ( function_exists( 'sharing_display' ) ) {
		// remove_filter( 'the_content', 'sharing_display', 19 )
		remove_filter( 'the_excerpt', 'sharing_display', 19 );
	}
}

function argonath_hide_sticky() {
    global $post_type, $pagenow;
    if( 'post.php' != $pagenow && 'post-new.php' != $pagenow )
        return;
    ?>
    <style type="text/css">#sticky-span { display:none!important }</style>
    <?php
}

function argo_setup() {
	// The following definitions are taken from the core Argo functions.php file
	// since we overwrite the function to make for cleaner code with registration
	// of custom Argonath functions
	// Please see Argo's function.php for explanation of these lines
	add_editor_style();
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-header');
	define( 'HEADER_TEXTCOLOR', '' );
	define( 'HEADER_IMAGE', get_stylesheet_directory_uri() . '/img/headers/default-logo.png' );
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'argo_header_image_width', 460 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'argo_header_image_height', 140 ) );
	add_custom_image_header( 'argo_header_style', 'argo_admin_header_style', 'argo_admin_header_image' );
	register_default_headers( array(
		'wheel' => array(
			'url' => '%s/img/headers/default-logo.png',
			'thumbnail_url' => '%s/img/headers/default-logo-thumbnail.png',
			/* translators: header image description */
			'description' => 'Wheel',
		),
	) );

	// Custom Argonath registrations begin here

	// Load JavaScript routines for the image carousel
	add_action('init', 'register_argonath_script');
	add_action('wp_footer', 'print_argonath_script');

	// Deregister WordPress default widgets
	add_action('widgets_init', 'argonath_deregister_widgets');

	// Initialize custom Argonath widgets and widget areas
	argonath_register_widgets();
	argonath_replacement_widgets();

	// Register Argonath widget areas
	add_action( 'widgets_init', 'argonath_register_sidebars' );

	// Register Argonath custom menus
	add_action( 'after_setup_theme', 'argonath_register_custom_menus' );

	// Add custom links to Meta block
	add_action( 'wp_meta', 'argonath_meta' );

	// Prevent self-pinging
	add_action( 'pre_ping', 'no_self_ping' );

	// Delay publication of posts to RSS feeds
	add_filter( 'posts_where', 'publish_later_on_feed' );

	// Remove Twitter archive posts from RSS feeds
	add_filter( 'pre_get_posts','feed_category_exclude' );

	// Activate tags and categories for Pages
	add_action( 'admin_init', 'tags_for_pages' );

	// Hide categories Feeds and Hidden from wp_list_pages
	add_filter( 'wp_list_pages_excludes', 'argonath_page_filter' );

	// Add post tags to page header for SEO
	add_action( 'wp_head', 'argonath_post_keywords' );

	// Remove pages from search results
	add_filter( 'pre_get_posts','argonath_search_filter' );

	// Register banner image size -- 940 x 340
	argonath_create_image_sizes();

	// Register Argonath custom taxonomies
	add_action( 'init', 'argonath_custom_taxonomies' );

	// Remove Sticky Posts; remove option in composition screens, turn off in db
	update_option( 'sticky_posts' , array() );
	add_action( 'admin_print_styles', 'argonath_hide_sticky' );

	// Load custom fonts
	add_action( 'wp_enqueue_scripts', 'argonath_fonts' );

	// Add date to the top navigation menu
	add_filter( 'wp_nav_menu_items', 'argonath_menu_date', 10, 2 );

	// Add support for all available post formats by default.
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// Remove custom excerpt link from More Featured footer posts
	remove_filter( 'Argo_more_featured_Widget', 'argo_custom_excerpt_more' );

	// Remove custom excerpt link from More Featured footer posts
	remove_filter( 'Argo_more_featured_Widget', 'argo_get_excerpt' );

	// Remove Sharedaddy/Jetpack sharing icons on excerpts
	add_action( 'loop_end', 'jptweak_remove_share' );

}

?>