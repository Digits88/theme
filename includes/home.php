<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Modifications to the homepage
 */


/**
 * Add a hero section to homepage
 *
 * @since 1.0.0
 */
function affwp_theme_home_hero_section() {

	if ( ! is_front_page() ) {
		return;
	}

	?>

	<div class="hero">

		<div class="home-fade"></div>
		<?php do_action( 'affwp_theme_hero_start' ); ?>

		<section class="container-fluid">
			<div class="wrapper wide">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-12 pv-xs-2 pv-sm-8 aligncenter">

						<h1 class="mb-xs-2">Easily create your full-featured affiliate program on WordPress</h1>
						<p class="intro">You’re here because you want an affiliate marketing solution that works. AffiliateWP is an easy-to-use, reliable WordPress plugin that gives you the affiliate marketing tools you need to grow your business and make more money.</p>

						<?php /*
						<h1 class="ph-lg-5 mb-xs-2">Easy affiliate marketing for WordPress that <strong>works</strong></h1>
						<p class="intro">You’re here because you want an affiliate marketing solution that works. AffiliateWP is an <strong>easy-to-use</strong>, <strong>reliable</strong> WordPress plugin that gives you the affiliate marketing tools you need to <strong>grow</strong> your business and <strong>make more money</strong>.</p>
						*/ ?>

						<div id="cta">
							<a href="#section-pricing" class="scroll button large">Start earning more</a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<?php
		/**
		 * Show the graph
		 */
		?>
		<div id="graph" class="ct-chart"></div>

	</div>

	<?php
}
add_action( 'themedd_header', 'affwp_theme_home_hero_section', 11 );

/**
 * Move the header on the homepage
 *
 * @since 1.0.0
 */
function affwp_theme_move_header() {

	if ( ! is_front_page() ) {
		return;
	}

	remove_action( 'themedd_header', 'themedd_header' );
	add_action( 'affwp_theme_hero_start', 'themedd_header' );

}
add_action( 'template_redirect', 'affwp_theme_move_header' );

/**
 * Load the Chartist JS on the homepage for the graph
 *
 * @since 1.0.0
 */
function affwp_theme_chartist_js() {

	if ( ! ( is_front_page() ) ) {
		return;
	}

	?>

	<script>

	var chart = new Chartist.Line('.ct-chart', {
		labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
		series: [
			[250, 300, 200, 200, 250, 200, 320, 400, 280, 250],
			[300, 380, 300, 400, 530, 740, 800, 1000, 1400, 2000],
		]
	}, {
		fullWidth: true,
		showPoint: true,
		showArea: true,
		showLabel: false,
		axisX: {
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
	});

	chart.on('draw', function(data) {

		jQuery( "#cta .button" ).hover(
			function() {
				jQuery('body').addClass('cta');
			}, function() {
				jQuery('body').removeClass('cta');
			}
		);

		jQuery(".ct-series-b .circle-blip").hover(function() {
			jQuery(this).addClass("animated");
		});

		jQuery('.circle-blip').bind('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(e) {
			jQuery(this).removeClass("animated");
		});

		if ( data.type === 'point' ) {

			var circle = new Chartist.Svg('circle', {
				cx: [data.x],
				cy: [data.y],
				r: [8],
			}, 'ct-circle');

			var foreignObjectHTML = '<div class="blip-wrap"><span class="circle-blip"></span></div>';

			data.element.parent().foreignObject(foreignObjectHTML, {
				width: 80,
				height: 80,
				x: data.x - 40,
				y: data.y - 40
			});

			data.element.replace(circle);

		}

	});

</script>

<?php
}
add_action( 'wp_footer', 'affwp_theme_chartist_js', 100 );


/**
 * "How it works" modal on homepage
 *
 * @since 1.0.0
 */
function affwp_theme_how_it_works_modal_content() {


	if ( ! is_front_page() ) {
		return;
	}

	?>

	<div id="how-it-works" class="popup entry-content mfp-with-anim mfp-hide">
		<h1>
			How Affiliate Marketing works
		</h1>

		<img src="<?php echo get_stylesheet_directory_uri() . '/images/how-it-works.svg'; ?>" alt="How affiliate marketing works" />
	</div>


	<?php
}
add_action( 'wp_footer', 'affwp_theme_how_it_works_modal_content' );
