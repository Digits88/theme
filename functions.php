<?php
/**
 * Constants
 *
 * @since 1.0
 */
if ( ! defined( 'AFFWP_THEME_INCLUDES_DIR' ) ) {
	define( 'AFFWP_THEME_INCLUDES_DIR', trailingslashit( get_stylesheet_directory() ) . 'includes' ); // Sets the path to the theme's includes directory.
}

if ( ! defined( 'AFFWP_THEME_VERSION' ) ) {
	define( 'AFFWP_THEME_VERSION', '1.5.4' );
}

function themedd_styles() {

	// Suffix.
	$suffix = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? '' : '.min';

	// Theme stylesheet.
	wp_enqueue_style( 'affwp', get_theme_file_uri( 'style' . $suffix . '.css' ), array(), filemtime( get_stylesheet_directory() . '/' . 'style' . $suffix . '.css' ) );
}
add_action( 'wp_enqueue_scripts', 'themedd_styles' );


/**
 * Setup
 *
 * @since 1.0
 */
function affwp_theme_setup() {

	add_post_type_support( 'page', 'excerpt' );

	// add subtitles to downloads
	add_post_type_support( 'download', 'subtitles' );

	// custom stuff
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'countdown.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'account.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'changelog.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'home.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'custom.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'gravity-forms.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'integrations.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'scripts.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'general.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'pricing.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'icons.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'twitter.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'footer.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'features.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'notices.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'compatibility/subtitles.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'functions.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'blog.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'animation.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'affiliates.php' );
	require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'lightbox.php' );

	// EDD functions
	if ( function_exists( 'themedd_is_edd_active' ) && themedd_is_edd_active() ) {
		require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'download-meta.php' );
		require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'navigation.php' );
		require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'show-add-on-info.php' );

		// EDD specific
		require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'edd/edd.php' );
		require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'edd/functions.php' );
		require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'edd/upgrades.php' );
		require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'edd/downloads.php' );
		require_once( trailingslashit( AFFWP_THEME_INCLUDES_DIR ) . 'edd/checkout.php' );

	}

	// add a new image size for our screenshots. These are hard cropped from the top left
	add_image_size( 'affwp-screenshot', 663, 332, array( 'left', 'top' ) );

}
add_action( 'after_setup_theme', 'affwp_theme_setup' );


/**
 * Add our screenshot image size to WordPress so we can select it
 */
function affwp_theme_image_size_names_choose( $sizes ) {

    return array_merge( $sizes, array(
        'affwp-screenshot' => __( 'Screenshot' ),
    ) );

}
add_filter( 'image_size_names_choose', 'affwp_theme_image_size_names_choose' );

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'themedd_post_thumbnail' ) ) :
function themedd_post_thumbnail() {

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) : ?>

	<div class="post-thumbnail">

		<?php

		if ( affwp_theme_featured_icon( get_the_ID() ) ) {
			echo affwp_theme_featured_icon( get_the_ID() );
		} elseif ( ! apply_filters( 'affwp_theme_post_animation', false ) ) {
			the_post_thumbnail();
		}

		/**
		 * Load SVG animation if there's one available for the single download
		 */
		echo affwp_theme_featured_icon_animation_single_download();

		?>

	</div>

	<?php else : ?>

		<?php
		if ( affwp_theme_featured_icon( get_the_ID() ) ) {
			$image = affwp_theme_featured_icon( get_the_ID() );
		} elseif ( apply_filters( 'affwp_theme_post_animation', false ) ) {
			$image = affwp_theme_animation_get_image( get_the_ID() );
		} else {
			$image = get_the_post_thumbnail( get_the_ID(), 'post-thumbnail', array( 'alt' => get_the_title() ) );
		}
		?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php echo $image; ?>
		</a>

	<?php endif; // End is_singular()
}
endif;
