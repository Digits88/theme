<?php



/**
 * Set the number of widget areas to 3 (default is 4).
 * This will only 3 sidebars on the admin widgets page.
 */
function affwp_theme_themedd_footer_widget_areas() {
	return 3;
}
add_filter( 'themedd_footer_widget_areas', 'affwp_theme_themedd_footer_widget_areas' );

/**
 * We're only using 3 footer widgets in the admin but since we're dynamically appending a column (meet the family), change this to 4
 */
function affwp_theme_footer_widgets_columns_class() {
	return 4;
}
add_filter( 'themedd_footer_widget_regions', 'affwp_theme_footer_widgets_columns_class' );

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

function affwp_theme_add_footer_column() {
	?>

	<div class="footer-widget widget-column meet-the-family col-xs-12 col-sm-6 col-lg-3">

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
 * Mascot
 */
function affwp_theme_footer_mascot() {

	if ( ! ( is_page( 'about' ) || is_404() || ( function_exists( 'edd_is_failed_transaction_page' ) && edd_is_failed_transaction_page() ) ) ) : ?>
	<div id="mascot"></div>
	<?php endif;
}
add_action( 'themedd_footer_widgets_before', 'affwp_theme_footer_mascot' );
