<?php

/**
 * Remove styling from subtitles plugin
 *
 * @since 1.0.0
 */
if ( class_exists( 'Subtitles' ) && method_exists( 'Subtitles', 'subtitle_styling' ) ) {
	remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
}

/**
 * Enable support for subtitles within themedd's post header
 * Subtitles don't usually appear because the title is rendered outside of the loop
 *
 * @since 1.0.0
 */
function affwp_theme_post_header_custom( ) {
   add_filter( 'subtitle_view_supported', '__return_true' );
}
add_action( 'themedd_page_header_before', 'affwp_theme_post_header_custom' );

/**
 * Remove support for subtitles after the header has been rendered
 * This is so the subtitles don't leak out and affect things like sharing icons etc
 *
 * @since 1.0.0
 */
function affwp_theme_post_header_remove_custom( ) {
	add_filter( 'subtitle_view_supported', '__return_false' );
}
add_action( 'themedd_page_header_end', 'affwp_theme_post_header_remove_custom' );

/**
 * Filter subtitle markup
 *
 * @since 1.0.0
 */
function affwp_theme_subtitle_markup( $markup ) {

    $markup['before'] = '<span class="subtitle">';

    return $markup;
}
add_filter( 'subtitle_markup', 'affwp_theme_subtitle_markup' );
