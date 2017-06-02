<?php

/**
 * Specify the container for filtering
 */
function affwp_theme_integration_footer_js() {

	if ( ! is_post_type_archive( 'integration' ) ) {
		return;
	}

	?>
	<script>
		var containerEl = document.querySelector('.integration-grid');

		var mixer = mixitup(containerEl);

		var filter = document.querySelectorAll('.integration-filter a');

		for( i = 0; i < filter.length; i++ ) {
			filter[i].addEventListener("click", function(e) {
				e.preventDefault();
			});
		};

	</script>
	<?php
}
add_action( 'wp_footer', 'affwp_theme_integration_footer_js', 100 );

/**
 * Enqueue scripts
 *
 * @since 1.0.0
 */
function affwp_theme_integration_enqueue_scripts() {

	// in addition to the parent theme's JS we load our own
	wp_register_script( 'mixitup', get_stylesheet_directory_uri() . '/js/mixitup.min.js', '', AFFWP_THEME_VERSION, true );

	if ( is_post_type_archive( 'integration' ) ) {
		wp_enqueue_script( 'mixitup' );
	}



}
add_action( 'wp_enqueue_scripts', 'affwp_theme_integration_enqueue_scripts' );

/**
 * Add breadcrumb to the "type" taxonomy page above the title
 *
 * @since 1.3.0
 */
function affwp_theme_integration_taxonomy_breadcrumb() {
	// only show this on the taxonomy page
	if ( ! is_tax( 'type' ) ) {
		return;
	}

	?>
	<div class="breadcrumb">
		<a href="<?php echo get_post_type_archive_link( 'integration' ); ?>">Integrations</a>
	</div>

	<?php
}
add_action( 'themedd_page_header_wrapper_start', 'affwp_theme_integration_taxonomy_breadcrumb' );

/**
 * Integration not supported notice
 *
 * @since 1.3.0
 */
function affwp_theme_integration_notice() {
	?>

	<div class="wrapper">
		<div class="row center-xs">
			<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
				<p>Is your preferred plugin not listed? We may still support it through our generic referral tracking script. <a href="http://docs.affiliatewp.com/article/66-generic-referral-tracking-script" target="_blank">Learn more &rarr;</a></p>
			</div>
		</div>
	</div>

	<?php
}
