<?php
/**
 * Returns the Google font stylesheet URL, if available.
 */
function argonath_fonts_url() {
	$fonts_url = '';

	$font_families = array();
	$font_families[] = 'Arimo:400,700,400italic,700italic';
	$font_families[] = 'Gentium+Basic:400,700,400italic,700italic';

	$protocol = is_ssl() ? 'https' : 'http';
	$query_args = array(
		'family' => implode( '|', $font_families ),
		'subset' => 'latin,latin-ext',
	);
	$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );

	return $fonts_url;
}

/**
 * Loads our special font CSS file.
 */
function argonath_fonts() {
	$fonts_url = argonath_fonts_url();
	if ( ! empty( $fonts_url ) )
		wp_enqueue_style( 'argonath-fonts', esc_url_raw( $fonts_url ), array(), null );
}
?>