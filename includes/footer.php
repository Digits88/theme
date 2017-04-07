<?php

/**
 * Remove the site footer on specific pages
 */
function affwp_theme_remove_footer( $return ) {

	if ( edd_is_checkout() ) {
		$return = false;
	}

	return $return;
}

add_filter( 'themedd_footer_widgets_show', 'affwp_theme_remove_footer' );


function affwp_theme_add_footer_column() {
	?>

	<div class="widget-column meet-the-family">

		<h4>Meet the family</h4>
		<ul>

			<li>
				<a href="https://easydigitaldownloads.com/" target="_blank">
					<img src="<?php echo get_stylesheet_directory_uri() . '/images/meet-easy-digital-downloads.png'; ?>" alt="" />
					<span>Easy Digital Downloads</span>
				</a>

			</li>

			<li>
				<a href="https://restrictcontentpro.com/?ref=4570" target="_blank">
					<img src="<?php echo get_stylesheet_directory_uri() . '/images/meet-restrict-content-pro.png'; ?>" alt="" />
					<span>Restrict Content Pro</span>
				</a>
			</li>
		</ul>

	</div>
	<?php
}
add_action( 'themedd_footer_widgets_end', 'affwp_theme_add_footer_column' );

/**
 * Allows customization of the widget arguments
 */
function affwp_theme_footer_widget_tags( $widget_tags ) {

	$widget_tags['before_title'] = '<h4 class="widget-title">';
	$widget_tags['after_title']  = '</h4>';

	return $widget_tags;

}
add_filter( 'themedd_footer_1_widget_tags', 'affwp_theme_footer_widget_tags' );
add_filter( 'themedd_footer_2_widget_tags', 'affwp_theme_footer_widget_tags' );
add_filter( 'themedd_footer_3_widget_tags', 'affwp_theme_footer_widget_tags' );

/**
 * Mascot
 */
function affwp_theme_footer_mascot() {

	if ( ! ( is_page( 'about' ) || is_404() || ( function_exists( 'edd_is_failed_transaction_page' ) && edd_is_failed_transaction_page() ) ) ) : ?>
	<div id="mascot"></div>
	<?php endif;
}
add_action( 'themedd_footer_widgets_before', 'affwp_theme_footer_mascot' );
