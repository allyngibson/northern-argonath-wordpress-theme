<?php

// define 125x125 ad spots for home.php
function argonath_register_sidebars() {
	register_sidebar( array(
		'name' => 'Home Sidebar',
		'id' => 'sidebar-home',
		'description' => 'The sidebar for the home page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => 'Home Ad Banner 1',
		'id' => 'widebanner-1',
		'description' => '468x80 ad block on home page (left)',
		'before_widget' => '<div class="bratachleft">',
		'after_widget' => "</div>",
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => 'Home Ad Banner 2',
		'id' => 'widebanner-2',
		'description' => '468x80 ad block on home page (right)',
		'before_widget' => '<div class="bratachright">',
		'after_widget' => "</div>",
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => 'Home 125 Ad Block 1',
		'id' => 'banner-1',
		'description' => '125x125 ad block on home page (top left)',
		'before_widget' => '<aside id="%1$s" class="widget imgl %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => 'Home 125 Ad Block 2',
		'id' => 'banner-2',
		'description' => '125x125 ad block on home page (top right)',
		'before_widget' => '<aside id="%1$s" class="widget imgr %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => 'Home 125 Ad Block 3',
		'id' => 'banner-3',
		'description' => '125x125 ad block on home page (middle left)',
		'before_widget' => '<aside id="%1$s" class="widget imgl %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => 'Home 125 Ad Block 4',
		'id' => 'banner-4',
		'description' => '125x125 ad block on home page (middle right)',
		'before_widget' => '<aside id="%1$s" class="widget imgr %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => 'Home 125 Ad Block 5',
		'id' => 'banner-5',
		'description' => '125x125 ad block on home page (bottom right)',
		'before_widget' => '<aside id="%1$s" class="widget imgl %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => 'Home 125 Ad Block 6',
		'id' => 'banner-6',
		'description' => '125x125 ad block on home page (bottom right)',
		'before_widget' => '<aside id="%1$s" class="widget imgr %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '',
		'after_title' => '',
	) );
}

// add links to meta widget
function argonath_meta() {
	echo '<li><a href="http://www.npr.org/">NPR</a></li>';
	echo "\n";
	echo '<li><a href="http://argoproject.org/">Project Argo</a></li>';
	echo "\n";
	echo '<li><a href="http://www.os-templates.com/">OS Templates</a></li>';
	echo "\n";
}

?>