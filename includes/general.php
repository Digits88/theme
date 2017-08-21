<?php
/**
 * General
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load our site logo
 *
 * @since 1.0
 */
function affwp_theme_site_branding() {

   ?>

   <svg id="logo" width="175" height="32" viewBox="0 0 175 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve">
       <g id="Artboard1" transform="matrix(0.767477,1.19172e-16,1.33089e-16,0.313725,0,0)">
           <g id="logo" transform="matrix(1.51782,-5.76563e-16,-6.43895e-16,3.7131,-65.3073,-160.137)">
               <g id="logo-mark" transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                   <path d="M135.136,134.694C131.007,134.694 127.647,131.334 127.647,127.205C127.647,123.075 131.007,119.716 135.136,119.716C139.265,119.716 142.625,123.075 142.625,127.205C142.625,131.334 139.265,134.694 135.136,134.694M65.617,134.694C61.488,134.694 58.128,131.334 58.128,127.205C58.128,123.075 61.488,119.716 65.617,119.716C69.746,119.716 73.105,123.075 73.105,127.205C73.105,131.334 69.746,134.694 65.617,134.694M100.921,58.129C105.05,58.129 108.409,61.488 108.409,65.617C108.409,69.747 105.05,73.107 100.921,73.107C96.791,73.107 93.432,69.747 93.432,65.617C93.432,61.488 96.791,58.129 100.921,58.129M135.136,105.332C134.102,105.332 133.093,105.429 132.097,105.569L117.689,79.636C120.87,75.837 122.792,70.949 122.792,65.617C122.792,53.557 112.981,43.746 100.921,43.746C88.86,43.746 79.047,53.557 79.047,65.617C79.047,70.843 80.894,75.643 83.963,79.409L68.943,105.613C67.856,105.446 66.75,105.332 65.617,105.332C53.556,105.332 43.745,115.144 43.745,127.205C43.745,139.266 53.556,149.078 65.617,149.078C77.677,149.078 87.49,139.266 87.49,127.205C87.49,121.979 85.643,117.179 82.573,113.412L97.593,87.21C98.681,87.377 99.786,87.491 100.921,87.491C101.954,87.491 102.963,87.394 103.958,87.254L118.366,113.188C115.186,116.987 113.264,121.874 113.264,127.205C113.264,139.266 123.075,149.078 135.136,149.078C147.197,149.078 157.008,139.266 157.008,127.205C157.008,115.144 147.197,105.332 135.136,105.332" />
               </g>
               <g id="logo-text">
                   <g transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                       <path d="M209.339,105.971L224.273,105.971L216.854,79.812L209.339,105.971ZM205.533,64.022L230.741,64.022L252.334,132.035L231.693,132.035L228.078,119.384L205.533,119.384L201.919,132.035L183.75,132.035L205.533,64.022Z" />
                   </g>
                   <g transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                       <path d="M258.058,93.89L251.781,93.89L251.781,82.285L258.058,82.285L258.058,78.48C258.058,66.114 265.668,60.311 277.463,60.311C280.603,60.311 282.886,60.692 285.074,61.263L285.074,73.724C283.837,73.344 282.41,73.058 280.507,73.058C276.703,73.058 274.991,75.341 274.991,78.48L274.991,82.285L289.45,82.285L289.45,77.91C289.45,65.543 297.154,59.646 308.95,59.646C312.088,59.646 314.277,60.026 316.464,60.597L316.464,73.058C315.228,72.678 313.991,72.487 311.994,72.487C308.093,72.487 306.476,74.675 306.476,77.91L306.476,82.285L316.464,82.285L316.464,93.89L306.476,93.89L306.476,132.035L289.45,132.035L289.45,93.89L274.991,93.89L274.991,132.035L258.058,132.035L258.058,93.89Z" />
                   </g>
                   <g transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                       <path d="M321.381,82.285L338.407,82.285L338.407,132.035L321.381,132.035L321.381,82.285ZM320.525,68.778C320.525,63.737 324.52,59.931 329.847,59.931C335.173,59.931 339.264,63.737 339.264,68.778C339.264,73.82 335.173,77.529 329.847,77.529C324.52,77.529 320.525,73.82 320.525,68.778" />
                   </g>
                   <g transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                       <rect x="347.531" y="60.407" width="16.932" height="71.628" />
                   </g>
                   <g transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                       <path d="M373.584,82.285L390.61,82.285L390.61,132.035L373.584,132.035L373.584,82.285ZM372.727,68.778C372.727,63.737 376.722,59.931 382.049,59.931C387.376,59.931 391.466,63.737 391.466,68.778C391.466,73.82 387.376,77.529 382.049,77.529C376.722,77.529 372.727,73.82 372.727,68.778" />
                   </g>
                   <g transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                       <path d="M427.927,114.627L427.927,111.583L423.456,111.583C416.607,111.583 413.563,112.915 413.563,117.005C413.563,119.859 415.465,121.666 419.46,121.666C424.312,121.666 427.927,118.908 427.927,114.627M396.726,118.242C396.726,106.542 406.619,101.976 423.17,101.976L427.927,101.976L427.927,100.834C427.927,96.078 426.785,92.939 421.364,92.939C416.702,92.939 414.989,95.698 414.61,98.836L398.628,98.836C399.39,86.851 408.807,80.954 422.409,80.954C436.108,80.954 444.859,86.566 444.859,99.788L444.859,132.035L428.307,132.035L428.307,126.232C425.929,129.847 421.553,133.176 413.563,133.176C404.621,133.176 396.726,128.8 396.726,118.242" />
                   </g>
                   <g transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                       <path d="M454.959,116.054L454.959,93.89L448.967,93.89L448.967,82.285L454.959,82.285L454.959,71.917L471.986,71.917L471.986,82.285L481.784,82.285L481.784,93.89L471.986,93.89L471.986,114.437C471.986,118.052 473.794,119.669 477.028,119.669C478.931,119.669 480.357,119.384 481.879,118.813L481.879,131.75C479.691,132.32 476.457,133.177 472.462,133.177C461.237,133.177 454.959,127.754 454.959,116.054" />
                   </g>
                   <g transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                       <path d="M520.441,101.5C520.155,95.507 517.207,92.178 511.689,92.178C506.552,92.178 503.033,95.507 502.177,101.5L520.441,101.5ZM484.769,107.778L484.769,107.017C484.769,91.037 496.66,80.954 511.689,80.954C525.292,80.954 536.992,88.753 536.992,106.637L536.992,111.107L501.987,111.107C502.462,117.671 506.267,121.476 512.355,121.476C517.967,121.476 520.345,118.908 521.011,115.578L536.992,115.578C535.47,126.803 526.814,133.176 511.785,133.176C496.184,133.176 484.769,124.044 484.769,107.778" />
                   </g>
                   <g transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                       <path d="M536.848,64.022L556.538,64.022L565.289,106.447L574.421,64.022L591.734,64.022L601.626,106.828L610.854,64.022L628.927,64.022L613.041,132.035L592.685,132.035L582.221,88.849L571.662,132.035L552.638,132.035L536.848,64.022Z" />
                   </g>
                   <g transform="matrix(0.227591,-1.15556e-32,-1.15556e-32,0.227591,34.7879,34.8883)">
                       <path d="M659.574,95.793C665.852,95.793 669.181,92.844 669.181,87.232L669.181,86.852C669.181,81.049 665.757,78.671 659.669,78.671L653.962,78.671L653.962,95.793L659.574,95.793ZM634.556,64.022L660.43,64.022C679.074,64.022 687.73,72.298 687.73,86.756L687.73,87.137C687.73,101.405 678.123,109.11 661.286,109.11L653.962,109.11L653.962,132.035L634.556,132.035L634.556,64.022Z" />
                   </g>
               </g>

           </g>
       </g>
   </svg>

   <?php
}
add_action( 'themedd_site_branding_site_title_before', 'affwp_theme_site_branding' );

/**
 * Page header classes
 *
 * @since 1.0.0
 */
function affwp_theme_page_header_classes( $classes ) {

	if ( is_page( '3rd-party' ) ) {
		$new_classes = array( 'highlight mb-xs-4' );
		return array_merge( $classes, $new_classes );
	}

	return $classes;

}
add_filter( 'themedd_page_header_classes', 'affwp_theme_page_header_classes' );

/**
 * Typography
 *
 * @since 1.0
 */
function affwp_theme_typography() {
?>
<link rel="stylesheet" type="text/css" href="https://cloud.typography.com/6988232/608824/css/fonts.css" />
<?php
}
add_action( 'wp_head', 'affwp_theme_typography' );

/**
 * Load lightbox scripts on specific pages
 *
 * @since 1.0.0
 */
function affwp_theme_load_lightbox( $lightbox ) {

	// load lightbox on pricing page
	if (
		is_page( 'pricing' ) ||
		is_front_page() ||
		is_singular( 'download' ) ||
		affwp_theme_is_cta_page()
	) {
		$lightbox = true;
	}

	return $lightbox;
}
add_filter( 'themedd_enable_popup', 'affwp_theme_load_lightbox' );


/**
 * Post Lightboxes
 */
function affwp_theme_post_lightbox() {

    if ( ! ( is_singular( 'post' ) || is_singular( 'download' ) || is_page( 'affiliates' ) ) ) {
        return;
    }

	?>
	<script type="text/javascript">

		jQuery(document).ready(function($) {

			$('.enlarge').magnificPopup({
                type: 'image',
                preloader: true,
                closeOnContentClick: true,
                closeBtnInside: false,
                fixedContentPos: true,
                mainClass: 'mfp-with-zoom',
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true,
                    duration: 300
                }
            });

		});
	</script>

<?php
}
add_action( 'wp_footer', 'affwp_theme_post_lightbox', 100 );

/**
 * Disable jetpack carousel comments
 *
 * @since 1.0.0
 */
function affwp_theme_jetpack_remove_attachment_comments( $open, $post_id ) {

	$post = get_post( $post_id );

	if ( $post->post_type == 'attachment' ) {
        return false;
    }

	return $open;

}
add_filter( 'comments_open', 'affwp_theme_jetpack_remove_attachment_comments', 10 , 2 );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0.0
 */
function affwp_theme_body_classes( $classes ) {

	global $post;

	if ( is_page_template( 'page-templates/account.php' ) ) {
		$classes[] = 'account';
	}

	if ( ! is_user_logged_in() ) {
        $classes[] = 'logged-out';
    }

	return $classes;

}
add_filter( 'body_class', 'affwp_theme_body_classes' );

/**
 * Custom copyright
 *
 * @since 1.0.0
 */
function affwp_theme_copyright( $copyright ) {

	$copyright = '<p>' . sprintf( __( '&copy; %s %s', 'themedd' ), date('Y'), get_bloginfo( 'name' ) . ', LLC' ) . '</p>';

	return $copyright;
}
add_filter( 'themedd_copyright', 'affwp_theme_copyright' );

/**
 * Filter excerpt
 *
 * @since 1.0.0
 */
function affwp_theme_custom_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'affwp_theme_custom_excerpt_more' );

/**
 * Limit excerpt length to 20 characters
 *
 * @since 1.0.0
 */
function affwp_theme_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'affwp_theme_excerpt_length' );

/**
 * Adjust primary column widths
 *
 * @since 1.1.5
 */
function affwp_theme_themedd_adjust_primary_column_widths( $classes ) {

	if ( is_singular( 'download' ) ) {
		// reset the array
		$classes = array();
		// add our new classes
		$classes[] = 'col-xs-12 col-md-8';
	}

	return $classes;
}
add_filter( 'themedd_primary_classes', 'affwp_theme_themedd_adjust_primary_column_widths' );

/**
 * Adjust secondary column widths
 *
 * @since 1.1.5
 */
function affwp_themedd_secondary_column_widths( $classes ) {

	if ( is_singular( 'download' ) ) {
		$classes = array();
		$classes[] = 'col-xs-12 col-md-4';
	}

	return $classes;
}
add_filter( 'themedd_secondary_classes', 'affwp_themedd_secondary_column_widths' );

/**
 * Pre get post queries
 *
 * @since 1.0.0
 */
function affwp_theme_pre_get_posts( $query ) {

    if ( $query->is_main_query() && ! is_admin() ) {

		// Show all downloads on /add-ons/pro
		if ( $query->is_tax( 'download_category' ) ) {
			$query->set( 'posts_per_page', -1 );
		}

		// Show all integrations on type taxonomy pages regardless of post status for site admins
		if ( ( $query->is_tax( 'download_category' ) || $query->is_tax( 'type' ) ) && current_user_can( 'manage_options' ) ) {
			$query->set( 'post_status', array( 'pending', 'draft', 'future', 'publish' ) );
		}

    }

}
add_action( 'pre_get_posts', 'affwp_theme_pre_get_posts' );
