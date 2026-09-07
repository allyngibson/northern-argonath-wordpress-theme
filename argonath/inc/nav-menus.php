<?php

// Create row of links on the homepage as a menu
function argonath_register_custom_menus() {
    $menus = array(
        'primary'         => 'Mobile Theme Menu',
        'buttons'         => 'Homepage Links',
    );
    register_nav_menus( $menus );

    foreach ( $menus as $location => $label ) {
        // if a location isn't wired up...
        if ( ! has_nav_menu( $location ) ) {

            // get or create the nav menu
            $nav_menu = wp_get_nav_menu_object( $label );
            if ( ! $nav_menu ) {
                $new_menu_id = wp_create_nav_menu( $label );
                $nav_menu = wp_get_nav_menu_object( $new_menu_id );
            }

            // wire it up to the location
            $locations = get_theme_mod( 'nav_menu_locations' );
            $locations[ $location ] = $nav_menu->term_id;
            set_theme_mod( 'nav_menu_locations', $locations );
        } 
    }
}

// Create walker to handle the row of links on the homepage
class Argonath_Buttons_Walker extends Walker {
    /*
     * Custom menu walker to create link buttons on homepage.
     */
	var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'post-' . $item->ID;

		$class_names = ' class="grid_4"';

		$id = apply_filters( 'nav_menu_item_id', 'post-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<article' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$thumbnail = '';
		$thumbnailid = (int)$item->object_id;
		$thumbnail = get_the_post_thumbnail( $thumbnailid, 'featured' );

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $thumbnail;
		$item_output .= '<strong>';
		$item_output .= apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</strong></a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</article>\n";
	}
}

// add date to the top navigation menu
function argonath_menu_date( $items, $args ) {
	if( $args->theme_location == 'global-nav' ) {
		if(function_exists( shire_reckoning )) {
			return $items . '<li class="navdate">' . shire_reckoning( 'auto' ) . '</li>';
		} else {
			return $items . '<li class="navdate">' . date("F j, Y") . '</li>';
		}
	}
	return $items;
}

?>