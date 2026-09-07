<?php

function argonath_custom_taxonomies() {
	// HOMEPAGE SPOTLIGHT
	if ( ! taxonomy_exists( 'spotlight-row' ) ) {
		register_taxonomy( 'spotlight-row', 'post', array(
			'hierarchical' => true,
			'label' => 'Homepage Spotlight',
			'query_var' => true,
			'rewrite' => true,
		) );
		wp_insert_term( 'Display', 'spotlight-row' );
	}
}

?>