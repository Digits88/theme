<?php

/**
 * Allow SVG animations to show with the new layout
 *
 * @since 1.4.5
 */
function affwp_theme_show_animation( $ret, $post_id = 0 ) {

	$post_id = empty( $post_id ) ? get_the_ID() : $post_id;

	if ( ! affwp_theme_animation_allowed_post_id( $post_id ) ) {
		return false;
	}

	// override the layout, just for this post
	return true;

}
add_filter( 'affwp_theme_post_animation', 'affwp_theme_show_animation', 10, 2 );

/**
 * Is post ID allowed?
 *
 * @uses affwp_theme_animation_post_titles()
 * @since 1.4.5
 */
function affwp_theme_animation_allowed_post_id( $post_id = 0 ) {

	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );

	if ( in_array( $post->post_title, affwp_theme_animation_post_titles() ) ) {
		return $post_id;
	}

	return false;

}

/**
 * Allowed post titles for SVG animations
 *
 * @since 1.4.5
 */
function affwp_theme_animation_post_titles() {

	// allowed post titles
	$post_titles = array(
		'Introducing the REST API Extended add-on',
		'REST API Extended',
		'Version 2.0 released!',
		'Version 1.9 released!',
		'Version 1.8 released!',
		'Affiliate Landing Pages',
		'Affiliate Landing Pages add-on released!'
	);

	return $post_titles;
}

/**
 * Load the animation object
 *
 * @since 1.4.5
 */
function affwp_theme_featured_icon_animation( $post_id = 0 ) {

	if ( empty( $post_id ) ) {
		return;
	}

	if ( is_singular() ) {
		// objects are loaded on single posts since they might be animated
		echo affwp_theme_animation_get_image( $post_id, 'object' );
	} else {
		// the default img (SVG) is loaded since it must be clickable
		return affwp_theme_animation_get_image( $post_id );
	}

}
add_action( 'themedd_page_header_end', 'affwp_theme_featured_icon_animation' );

/**
 * Get the SVG objects
 *
 * @since 1.4.5
 */
function affwp_theme_animation_get_image( $post_id = 0, $type = 'img' ) {

	if ( empty( $post_id ) ) {
		return;
	}

	$post  = get_post( $post_id );
	$image = '';

	ob_start();

	switch ( $post->post_title ) {

		case 'Introducing the REST API Extended add-on':
		case 'REST API Extended':
			$image = 'add-on-rest-api';
			break;

		case 'Version 2.0 released!':
		case 'Version 1.9 released!':
		case 'Version 1.8 released!':
			$image = 'product-update';
			break;

		case 'Affiliate Landing Pages add-on released!':
		case 'Affiliate Landing Pages':
			$image = 'add-on-affiliate-landing-pages';
			break;

	}

	if ( 'img' === $type ) : // image for use on blog listings etc or whenever it can be clicked ?>
		<img id="main-svg" src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/animation/' . $image . '.svg'; ?>" />
	<?php elseif( 'object' === $type ) : // object (animated) for use on single post pages ?>
		<object id="main-svg" data="<?php echo get_stylesheet_directory_uri() . '/images/svgs/animation/' . $image . '.svg'; ?>" type="image/svg+xml" ></object>
	<?php endif; ?>

	<?php

	$content = ob_get_contents();

	ob_end_clean();

	return $content;
}

/**
 * Load the animation SVG on single download pages
 *
 * @since 1.4.5
 */
function affwp_theme_featured_icon_animation_single_download() {

	if ( ! apply_filters( 'affwp_theme_post_animation', false ) ) {
		return;
	}

	$post = get_post( get_the_ID() );

	if ( 'REST API Extended' === $post->post_title ) { ?>
		<object id="main-svg" class="animated" data="<?php echo get_stylesheet_directory_uri() . '/images/svgs/animation/add-on-rest-api.svg'; ?>" type="image/svg+xml" ></object>
	<?php }

	if ( 'Affiliate Landing Pages' === $post->post_title ) { ?>
		<object id="main-svg" class="animated" data="<?php echo get_stylesheet_directory_uri() . '/images/svgs/animation/add-on-affiliate-landing-pages.svg'; ?>" type="image/svg+xml" ></object>
	<?php }

}

/**
 * Load the required animation scripts
 *
 * @since 1.4.5
 */
function affwp_theme_enqueue_animation_scripts() {

	if ( ! affwp_theme_animation_allowed_post_id( get_the_ID() ) ) {
		return;
	}

	// core animations file
	wp_enqueue_script( 'animation', get_stylesheet_directory_uri() . '/js/animation.min.js', array(), AFFWP_THEME_VERSION, true );

	if ( affwp_theme_animation_can_debug() ) {
		wp_enqueue_script( 'gsap-draggable', get_stylesheet_directory_uri() . '/js/Draggable.min.js', array(), AFFWP_THEME_VERSION, true );
	}

}
add_action( 'wp_enqueue_scripts', 'affwp_theme_enqueue_animation_scripts' );

/**
 * Loads the animation code for the "Affiliate Landing Pages" download page
 *
 * @since 1.4.5
 */
function affwp_theme_animation_affiliate_landing_pages_add_on() {

	if ( ! is_singular() ) {
		return;
	}

	$post = get_post( get_the_ID() );

	if ( ! (
		'Affiliate Landing Pages' === $post->post_title ||
		'Affiliate Landing Pages add-on released!' === $post->post_title
	) ) {
		return;
	}

	?>
	<script>

	/**
	 * Get Timeline
	 */
	function getTimeline() {
		<?php if ( affwp_theme_animation_can_debug() ) : ?>
			var	tl = new TimelineMax({ onUpdate: updateFunction, onUpdateParams:["{self}"] });
		<?php else : ?>
			var	tl = new TimelineMax();
		<?php endif; ?>

		return tl;
	}

	window.addEventListener('load',function() {

		tl = getTimeline();

		var svgDocument = document.getElementById("main-svg");

		// get the inner DOM of the SVG
		var $this = svgDocument.contentDocument;

		// Set up variables.
		var browser        = $this.getElementById('window-main'),
			browserDivider = $this.getElementById('window-divider'),
			browserDots    = $this.querySelectorAll('#dots circle'),
			target         = $this.getElementById('target'),
			targetStripes  = $this.querySelectorAll('#target circle'),
			arrow          = $this.getElementById('arrow');

		// show the SVG
		TweenLite.set("#main-svg", {visibility:"visible"});

		TweenLite.set( arrow, {transformOrigin:"0% 100%"});

		// Draw the outer browser window.
		tl.fromTo( browser, 1, {drawSVG:"0%"}, {drawSVG:"100%", ease:Power3.easeInOut })

		// Draw the browser's divider line.
		.fromTo( browserDivider, 1, {drawSVG:"0%"}, {drawSVG:"100%", ease:Power3.easeInOut }, "browserDivider" )

		// Animate the browser dots.
		.staggerFrom( browserDots, 1, {scale: 0, opacity:0, ease:Elastic.easeOut, force3D:true, transformOrigin:"50% 50%" }, 0.1 )

		// Animate the target's stripes
		.staggerFrom( targetStripes, 1, {scale: 0, opacity:0, ease:Power3.easeOut, force3D:true, transformOrigin:"50% 50%" }, 0.1, "browserDivider -=0.25" )

		// Bring the arrow in and hit the target
		.from(arrow, 0.1, {x: '+=2000px', y: '-=1000px', ease:Power4.easeInOut }, "arrowHit" )

		// Shake the arrow as it hits the target
		.to( arrow, 0.1, {rotation:-3} )
		.to( arrow, 0.1, {rotation:3} )
		.to( arrow, 0.1, {rotation:-3} )
		.to( arrow, 0.1, {rotation:3} )
		.to( arrow, 0.1, {rotation:0} )

		// Shake the target
		.to( target, 0.1, {scale: 0.9, ease:Power4.easeOut, force3D:true, transformOrigin:"50% 50%" }, "-=0.5" )
		.to( target, 0.1, {scale: 1, ease:Power4.easeOut, force3D:true, transformOrigin:"50% 50%" }, "-=0.4" )

	}); // end window.load

	</script>

	<?php

}
add_action( 'wp_footer', 'affwp_theme_animation_affiliate_landing_pages_add_on', 100 );

/**
 * Loads the animation code for the "Introducing the REST API Extended add-on" post and the "REST API Extended" download page
 *
 * @since 1.4.5
 */
function affwp_theme_animation_rest_api_add_on() {

	if ( ! is_singular() ) {
		return;
	}

	$post = get_post( get_the_ID() );

	if ( ! (
		'Introducing the REST API Extended add-on' === $post->post_title ||
		'REST API Extended' === $post->post_title )
	) {
		return;
	}

	?>
	<script>

	/**
	 * Get Timeline
	 */
	function getTimeline() {
		<?php if ( affwp_theme_animation_can_debug() ) : ?>
			var	tl = new TimelineMax({ onUpdate: updateFunction, onUpdateParams:["{self}"] });
		<?php else : ?>
			var	tl = new TimelineMax();
		<?php endif; ?>

		return tl;
	}

	window.addEventListener('load',function() {

		tl = getTimeline();

		var svgDocument = document.getElementById("main-svg");

		// get the inner DOM of the SVG
		var $this = svgDocument.contentDocument;

		var circleMain  = $this.getElementById("circle-main"),
			circleOne   = $this.getElementsByClassName("circle-1"),
			circleTwo   = $this.getElementsByClassName("circle-2"),
			circleThree = $this.getElementsByClassName("circle-3"),
			circleFour  = $this.getElementsByClassName("circle-4"),
			line        = $this.getElementsByClassName("line"),
			lineReverse = $this.getElementsByClassName("line-reverse"),
			smallCircle = $this.getElementsByClassName("small-circle"),
			outerRing   = $this.getElementsByClassName("outer-ring");

		// show the SVG
		TweenLite.set("#main-svg", {visibility:"visible"});

		TweenLite.set( circleOne, {rotation:100, transformOrigin:"50% 50%"});
		TweenLite.set( circleTwo, {rotation:150, transformOrigin:"50% 50%"});
		TweenLite.set( circleThree, {rotation:220, transformOrigin:"50% 50%"});
		TweenLite.set( circleFour, {rotation:270, transformOrigin:"50% 50%"});

		tl.fromTo( circleMain, 0.5, {drawSVG:"0%"}, {drawSVG:"100%"})
		.fromTo( line, 0.5, {drawSVG:"100% 100%"}, {drawSVG:"100%"})
		.fromTo( lineReverse, 0.5, {drawSVG:"0%"}, {drawSVG:"100%"}, 0.5)
		.fromTo( smallCircle, 0.5, {drawSVG:"0%"}, {drawSVG:"100%"})
		.fromTo( outerRing, 0.5, {scale: 0.8, opacity: 0, transformOrigin:"50% 50%"}, {scale: 1, opacity:1}, "-=0.5" )

	}); // end window.load

	</script>

	<?php

}
add_action( 'wp_footer', 'affwp_theme_animation_rest_api_add_on', 100 );

/**
 * Loads the animation code for the product update posts
 */
function affwp_theme_animation_product_update() {

	if ( ! is_singular() ) {
		return;
	}

	$post = get_post( get_the_ID() );

	if ( ! (
		'Version 2.0 released!' === $post->post_title ||
		'Version 1.9 released!' === $post->post_title ||
		'Version 1.8 released!' === $post->post_title
		)
	) {
		return;
	}

	?>
	<script>

	/**
	 * Get Timeline
	 */
	function getTimeline() {
		<?php if ( affwp_theme_animation_can_debug() ) : ?>
			var	tl = new TimelineMax({ onUpdate: updateFunction, onUpdateParams:["{self}"] });
		<?php else : ?>
			var	tl = new TimelineMax();
		<?php endif; ?>

		return tl;
	}

	/**
	 * Animation
	 */
	window.addEventListener('load',function() {

		tl = getTimeline();

		var svgDocument = document.getElementById("main-svg");

		// get the inner DOM of the SVG
		var $this = svgDocument.contentDocument;

		var wind = $this.querySelectorAll('#wind path'),
			box = $this.getElementById("box"),
			tick = $this.querySelectorAll('#tick path'),
			labelMain = $this.querySelectorAll('#label');

		// show the SVG
		TweenLite.set("#main-svg", {visibility:"visible"});

		// rotate label from the center
		TweenLite.set( labelMain, {transformOrigin:"50% 50%"});

		// set the transform origin of the box to the bottom right corner
		TweenLite.set( box, {transformOrigin:"100% 100%"});

		// bring the wind in
		tl.staggerFrom( wind, 0.25, {opacity:0, x:-100, ease:Back.easeOut, force3D:true }, 0.05)
		// move the box in from the left
		.from( box, 0.5, { x:-450, ease: Power4.easeOut }, '-=0.5' )
		// lift the box up on the bottom right corner as it's moving
		.to( box, 0.25, { rotation: 10 }, '-=0.3'  )
		// put the box back down
		.to( box, 0.25, { delay: 0.1, rotation: 0, ease: Power4.easeIn  }, '-=0.0' )
		// bring the label in
		.fromTo( labelMain, 0.25, {rotation: -90, scale: 1.5, autoAlpha:0}, {rotation: 0, scale: 1, autoAlpha:1, ease:Power1.easeIn } )
		// tick the label
		.fromTo( tick, 0.5, {drawSVG:"0%"}, {drawSVG:"102%", ease:Power4.easeInOut}, '+=0.25')

	});

	</script>

	<?php

}
add_action( 'wp_footer', 'affwp_theme_animation_product_update', 100 );

/**
 * Animation debugging
 *
 * @since 1.4.5
 */
function affwp_theme_animation_debug() {

	if ( ! affwp_theme_animation_can_debug() ) {
		return;
	}

	?>
	<script>

	/**
	 * Update function
	 * Runs on every frame of animation
	 */
	function updateFunction( tl ) {

		var xPos = tl.progress() * dragLimit;

		tnProgress = ( Math.round( tl.progress() * 1000) ) /1000;

		TweenLite.set(dragElem, {x:xPos});
		TweenLite.set(dragBar, {width:xPos+10});

		logDiv.innerHTML = tnProgress;

	}

	var div1          = document.getElementById("main-svg"),
		dragBar       = document.getElementsByClassName("drag-bar"),
		dragElem      = document.querySelector('.drag-elem'),
		widthDragElem = dragElem.offsetWidth,
		dragContainer = document.getElementById("drag-container"),
		dragLimit     = dragContainer.offsetWidth - dragElem.offsetWidth,
		logDiv        = document.querySelector('#log-div span');

	var tnProgress;

	Draggable.create(dragElem, {
		type:'x',
		bounds:dragContainer,
		edgeResistance:1,
		onDrag:function() {
			tnProgress       = ( Math.round( (this.x / dragLimit) * 1000) ) /1000;
			logDiv.innerHTML = tnProgress;

			tl.progress(tnProgress);
			TweenLite.set(dragBar, {width:this.x + 10});
		}
	});

	// buttons
	var play    = document.getElementById("play"),
		pause   = document.getElementById("pause"),
		reverse = document.getElementById("reverse"),
		resume  = document.getElementById("resume"),
		restart = document.getElementById("restart");


	play.onclick = function() {
		// play() only plays forward from current position. If timeline has finished, play() has nowhere to go.
		// if the timeline is not done then play() or else restart() (restart always restarts from the beginning).
		if ( tl.progress() != 1 ) {
			tl.play();
		} else {
			tl.restart();
		}

	}

	pause.onclick = function() {
		tl.pause();
	}

	reverse.onclick = function() {
		tl.reverse();
	}

	resume.onclick = function() {
		tl.resume();
	}

	restart.onclick = function() {
		tl.restart();
	}

	</script>
	<?php
}
add_action( 'wp_footer', 'affwp_theme_animation_debug', 100 );

/**
 * Load CSS for SVG debug tools
 *
 * @since 1.4.5
 */
function affwp_theme_animation_css() {

	if ( ! affwp_theme_animation_can_debug() ) {
		return;
	}

	?>
	<style>

	.svg-debug {
		position: fixed;
		bottom: 2rem;
		right: 2rem;
		background: #222;
		text-align: center;
	}

	.svg-debug button {
		background: #60b9b3;
		border: 1px solid #000;
		padding: 0.5rem 1rem;
		font-size: 0.875rem;
	}

	.svg-debug button:hover {
		background: #49a7a0;
	}

	#log-div {
		padding: 1rem;
		font-size: 0.875rem;
		color: #fff;
	}

	#drag-wrapper {
		text-align: center;
		padding: 1rem;
	}

	.drag-border {
		border: solid 4px #fff;
		width: 458px;
		border-radius: 5px;
		overflow: hidden;
		position: relative;
	}

	#drag-container {
		width: 450px;
		background: #eee;
	}

	.drag-elem {
		position: relative;
		background: #000;
		height: 20px;
		width: 20px;
		z-index: 10;
		border-radius: 5px;
	}

	.drag-bar {
		height: 20px;
		background: #60b9b3;
		width: 0;
		position: absolute;
		z-index: 5;
		border-radius: 5px;
	}

	</style>
	<?php
}
add_action( 'wp_head', 'affwp_theme_animation_css' );

/**
 * Debug/preview HTML
 *
 * @since 1.4.5
 */
function affwp_theme_animation_debug_html() {

	if ( ! affwp_theme_animation_can_debug() ) {
		return;
	}

	?>

	<div class="svg-debug">

		<div id="drag-wrapper">
			<div class="drag-border">
				<div id="drag-container">
					<div class="drag-bar"></div>
					<div class="drag-elem"></div>
				</div>
			</div>
		</div>

		<div class="controls">
			<button id="play">Play</button>
			<button id="pause">Pause</button>
			<button id="reverse">Reverse</button>
			<button id="resume">Resume</button>
			<button id="restart">Restart</button>
		</div>

		<div id="log-div">Current progress: <span></span></div>
	</div>

	<?php
}
add_action( 'wp_footer', 'affwp_theme_animation_debug_html' );

/**
 * Determine if the current user can debug
 * Example: /?debug=svg
 *
 * @since 1.4.5
 */
function affwp_theme_animation_can_debug() {

	if ( isset( $_GET['debug'] ) && 'svg' === $_GET['debug'] && current_user_can( 'manage_options' ) ) {
		return true;
	}

	return false;

}
