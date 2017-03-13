<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom scripts
 */


/**
 * Enqueue scripts
 *
 * @since 1.0.0
 */
function affwp_theme_enqueue_scripts() {

	// in addition to the parent theme's JS we load our own
	wp_register_script( 'affwp-js', get_stylesheet_directory_uri() . '/js/affiliatewp.min.js', array( 'jquery' ), AFFWP_THEME_VERSION, true );
	wp_enqueue_script( 'affwp-js' );

}
add_action( 'wp_enqueue_scripts', 'affwp_theme_enqueue_scripts' );


/**
 * Load Twitter JS on about page
 *
 * @since 1.0.0
 */
function affwp_theme_twitter_scripts() {

	if ( ! ( is_page( 'about' ) || is_singular( 'post' ) || affwp_theme_was_sale_purchase() ) ) {
		return;
	}

	?>

	<script>window.twttr = (function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0],
	    t = window.twttr || {};
	  if (d.getElementById(id)) return t;
	  js = d.createElement(s);
	  js.id = id;
	  js.src = "https://platform.twitter.com/widgets.js";
	  fjs.parentNode.insertBefore(js, fjs);

	  t._e = [];
	  t.ready = function(f) {
	    t._e.push(f);
	  };

	  return t;
	}(document, "script", "twitter-wjs"));</script>

	<?php

}
add_action( 'wp_footer', 'affwp_theme_twitter_scripts' );

/**
 * Dequeue scripts
 */
function affwp_theme_dequeue_scripts() {

	// remove EDD Free Downloads scripts from all non official-free add-on pages
	if ( ! ( is_singular( 'download' ) && has_term( 'official-free', 'download_category' ) ) ) {
		// scripts
		wp_dequeue_script( 'edd-free-downloads-mobile' );
		wp_dequeue_script( 'edd-free-downloads-modal' );
		wp_dequeue_script( 'edd-free-downloads' );

		// styles
		wp_dequeue_style( 'edd-free-downloads-modal' );
		wp_dequeue_style( 'edd-free-downloads' );
	}

	// Remove Help Scout Beacon from specific pages
	if (
		is_front_page() ||
		edd_is_checkout() ||
		is_page( 'pricing' ) ||
		is_page( 'account' ) ||
		is_page( 'affiliates' ) ||
		is_page( 'affiliates/join' ) ||
		is_page( 'affiliates/login' )
	) {
		wp_dequeue_script( 'beacon' );
	}

}
add_action( 'wp_enqueue_scripts', 'affwp_theme_dequeue_scripts');

/**
 * Enqueue account related scripts
 *
 * @since 1.0.0
 */
function affwp_theme_account_scripts() {

	wp_register_script( 'account-js', get_stylesheet_directory_uri() . '/js/account.min.js', array( 'jquery' ), THEMEDD_VERSION );

	if ( themedd_is_edd_sl_active() ) {
		wp_register_style( 'edd-sl-styles', plugins_url( '/css/edd-sl.css', EDD_SL_PLUGIN_FILE ), false, EDD_SL_VERSION );
	}

	// load jQuery UI + tabs for account page
	if ( is_page_template( 'page-templates/account.php' ) ) {

		/**
		 * Account page
		 */
		wp_enqueue_script( 'jquery-ui-tabs' );

		// load jQuery UI
		wp_enqueue_script( 'jquery-ui-core' );

		// load account JS
		wp_enqueue_script( 'account-js' );

		// load EDD SL's CSS styles
		wp_enqueue_style( 'edd-sl-styles' );

	}

}
add_action( 'wp_enqueue_scripts', 'affwp_theme_account_scripts' );

/**
 * Perform actions on template_redirect hook
 */
function affwp_theme_edd_template_redirect() {

	// remove HTML from EDD Free Downloads
	if ( ! ( is_singular( 'download' ) && has_term( 'official-free', 'download_category' ) ) ) {
		remove_action( 'wp_footer', 'edd_free_downloads_display_inline' );
	}
}
add_action( 'template_redirect', 'affwp_theme_edd_template_redirect' );

/**
 * Load the JS required for the call to action
 */
function affwp_themedd_call_to_action_js() {

	if ( ! affwp_theme_is_cta_page() ) {
		return;
	}

	?>

	<script>

	var theData = {
		labels: [1, 2, 3, 4, 5, 6, 7, 8],
		series: [
			[-200, -200, 200, 400, 700, 1500, 2000, 3000],
		]
	}

	var options = {
		fullWidth: true,
		showPoint: true,
		showArea: true,
		showLabel: false,
		axisX: {
			showGrid: false,
			showLabel: false,
			offset: 0
		},
		axisY: {
			showGrid: false,
			showLabel: false,
			offset: 0
		},
		chartPadding: 0,
		high: 2500,
		low: 0
	}

	var chart = new Chartist.Line('.ct-chart', theData, options );

	chart.on('draw', function(data) {

		if (data.type === 'point') {

			var circle = new Chartist.Svg('circle', {
				cx: [data.x],
				cy: [data.y],
				r: [8],
			}, 'ct-circle');

			var foreignObjectHTML = '<div class="blip-wrap"><span class="circle-blip' + ' blip-' + data.index + '"></span></div>';

			data.element.parent().foreignObject(foreignObjectHTML, {
				width: 80,
				height: 80,
				x: data.x - 40,
				y: data.y - 40
			});

			data.element.replace(circle);
		}

	});

	jQuery( ".cta-get-started" ).mouseenter(function() {
		jQuery('.circle-blip').addClass('blip-hover');
	});

	jQuery( ".cta-get-started" ).mouseleave(function() {
		jQuery('.circle-blip').removeClass('blip-hover');
	});

</script>

	<?php
}
add_action( 'wp_footer', 'affwp_themedd_call_to_action_js', 100 );
