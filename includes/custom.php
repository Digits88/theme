<?php

/**
 * Remove the inline styles from Themedd which are injected by the customizer
 */
add_filter( 'themedd_customize_color_options', '__return_false' );

/**
 * Remove inline styling from the download meta plugin
 */
remove_action( 'wp_head', 'edd_download_meta_styles' );
