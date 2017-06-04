<?php

if ( ! defined( 'AFFWP_THEME_BLOG_POSTS_PER_PAGE' ) ) {
	define( 'AFFWP_THEME_BLOG_POSTS_PER_PAGE', 9 );
}

/**
 * Remove the categories and tags for now. We'll add these at a later date, in a different location
 *
 * @since 1.5.1
 */
remove_action( 'themedd_entry_content_end', 'themedd_show_entry_footer' );

/**
 * Hide sidebar on single posts.
 * We don't use any widgets in the sidebar but good to do just in case.
 *
 * @since 1.5.1
 */
function affwp_theme_hide_sidebar( $return ) {

	if ( is_singular( 'post' ) ) {
		$return = false;
	}

	return $return;

}
add_filter( 'themedd_show_sidebar', 'affwp_theme_hide_sidebar' );

/**
 * Remove standard post header on single posts
 *
 * @since 1.1.5
 */
function affwp_theme_remove_post_header( $ret ) {

	/**
	 * The new design is only for posts where a featured icon (SVG) has been set
	 */
	if ( ( affwp_theme_featured_icon( get_the_ID() ) || apply_filters( 'affwp_theme_post_animation', false ) ) && is_singular( 'post' ) ) {
		$ret = false;
	}

	return $ret;

}
add_filter( 'themedd_page_header', 'affwp_theme_remove_post_header' );


/**
 * New header design for single blog images
 *
 * @since 1.0.0
 */
function affwp_theme_blog_header() {

	/**
	 * The new design is only for posts where a featured icon (SVG) has been set
	 */

	if ( ! ( affwp_theme_featured_icon( get_the_ID() ) || apply_filters( 'affwp_theme_post_animation', false ) ) ) {
		return;
	}

	if ( is_singular( 'post' ) ) :

	?>
	<div class="hero <?php echo affwp_theme_blog_hero_classes( get_the_ID() ); ?>">

		<?php do_action( 'affwp_theme_hero_start' ); ?>

		<header class="page-header col-xs-12 blog-featured pv-xs-2 pv-sm-4 center-xs">
			<div class="wrapper">

				<?php do_action( 'themedd_page_header_start' ); ?>

				<h1 class="<?php echo get_post_type(); ?>-title center-xs">
					<?php echo get_the_title(); ?>
				</h1>

				<?php
				/**
				 * SVG animation will load on this hook if present
				 */
				do_action( 'themedd_page_header_end', get_the_ID() );
				?>

				<?php
				/**
				 * Load the featured icon (SVG set in admin) if present
				 */
				echo affwp_theme_featured_icon( get_the_ID() );
				?>

			</div>

		</header>
	</div>
<?php endif;
}
add_action( 'themedd_single_start', 'affwp_theme_blog_header' );

/**
 * Tweaks to the blog post
 *
 * @since 1.0.0
 */
function affwp_theme_blog_tweaks() {

	/**
	 * The new design is only for posts where the featured image is an SVG
	 * Going forward we might remove this requirement as we re-do older blog posts
	 */
	if ( ! affwp_theme_featured_icon( get_the_ID() ) ) {
		return;
	}

	if ( is_singular( 'post' ) ) {
		//remove the post thumbnail from the default location
		remove_action( 'themedd_article_start', 'themedd_show_post_thumbnail' );

		// remove the post header from the default location
	//	remove_action( 'themedd_single_start', 'themedd_load_page_header' );
	}

}
add_action( 'template_redirect', 'affwp_theme_blog_tweaks' );

/**
 * Sharing icons
 * Shown on single blog posts
 *
 * @since 1.0.0
 */
function affwp_theme_post_sharing() {

	// only show sharing icons on posts
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	if ( themedd_is_affiliatewp_active() && affwp_is_affiliate() ) {
		$url = affwp_get_affiliate_referral_url( array( 'base_url' => get_permalink() ) );
	} else {
		$url = get_permalink();
	}
?>

<div class="sharing-icons">

	<span>Share this article!</span>

	<a class="twitter" href="https://twitter.com/intent/tweet/?text=<?php echo the_title_attribute(); ?>&amp;url=<?php echo $url; ?>" target="_blank">
	    <svg version="1.1" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
	        <g>
	            <path d="M23.444,4.834c-0.814,0.363-1.5,0.375-2.228,0.016c0.938-0.562,0.981-0.957,1.32-2.019c-0.878,0.521-1.851,0.9-2.886,1.104 C18.823,3.053,17.642,2.5,16.335,2.5c-2.51,0-4.544,2.036-4.544,4.544c0,0.356,0.04,0.703,0.117,1.036 C8.132,7.891,4.783,6.082,2.542,3.332C2.151,4.003,1.927,4.784,1.927,5.617c0,1.577,0.803,2.967,2.021,3.782 C3.203,9.375,2.503,9.171,1.891,8.831C1.89,8.85,1.89,8.868,1.89,8.888c0,2.202,1.566,4.038,3.646,4.456 c-0.666,0.181-1.368,0.209-2.053,0.079c0.579,1.804,2.257,3.118,4.245,3.155C5.783,18.102,3.372,18.737,1,18.459 C3.012,19.748,5.399,20.5,7.966,20.5c8.358,0,12.928-6.924,12.928-12.929c0-0.198-0.003-0.393-0.012-0.588 C21.769,6.343,22.835,5.746,23.444,4.834z"/>
	        </g>
	    </svg>
	</a>

	<a class="facebook" href="https://facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank">
	    <svg version="1.1" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
	        <g>
	            <path d="M18.768,7.465H14.5V5.56c0-0.896,0.594-1.105,1.012-1.105s2.988,0,2.988,0V0.513L14.171,0.5C10.244,0.5,9.5,3.438,9.5,5.32 v2.145h-3v4h3c0,5.212,0,12,0,12h5c0,0,0-6.85,0-12h3.851L18.768,7.465z"/>
	        </g>
	    </svg>
	</a>

	<a class="google" href="https://plus.google.com/share?url=<?php echo $url; ?>" target="_blank">
	    <svg version="1.1" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
	        <g>
	            <path d="M11.366,12.928c-0.729-0.516-1.393-1.273-1.404-1.505c0-0.425,0.038-0.627,0.988-1.368 c1.229-0.962,1.906-2.228,1.906-3.564c0-1.212-0.37-2.289-1.001-3.044h0.488c0.102,0,0.2-0.033,0.282-0.091l1.364-0.989 c0.169-0.121,0.24-0.338,0.176-0.536C14.102,1.635,13.918,1.5,13.709,1.5H7.608c-0.667,0-1.345,0.118-2.011,0.347 c-2.225,0.766-3.778,2.66-3.778,4.605c0,2.755,2.134,4.845,4.987,4.91c-0.056,0.22-0.084,0.434-0.084,0.645 c0,0.425,0.108,0.827,0.33,1.216c-0.026,0-0.051,0-0.079,0c-2.72,0-5.175,1.334-6.107,3.32C0.623,17.06,0.5,17.582,0.5,18.098 c0,0.501,0.129,0.984,0.382,1.438c0.585,1.046,1.843,1.861,3.544,2.289c0.877,0.223,1.82,0.335,2.8,0.335 c0.88,0,1.718-0.114,2.494-0.338c2.419-0.702,3.981-2.482,3.981-4.538C13.701,15.312,13.068,14.132,11.366,12.928z M3.66,17.443 c0-1.435,1.823-2.693,3.899-2.693h0.057c0.451,0.005,0.892,0.072,1.309,0.2c0.142,0.098,0.28,0.192,0.412,0.282 c0.962,0.656,1.597,1.088,1.774,1.783c0.041,0.175,0.063,0.35,0.063,0.519c0,1.787-1.333,2.693-3.961,2.693 C5.221,20.225,3.66,19.002,3.66,17.443z M5.551,3.89c0.324-0.371,0.75-0.566,1.227-0.566l0.055,0 c1.349,0.041,2.639,1.543,2.876,3.349c0.133,1.013-0.092,1.964-0.601,2.544C8.782,9.589,8.363,9.783,7.866,9.783H7.865H7.844 c-1.321-0.04-2.639-1.6-2.875-3.405C4.836,5.37,5.049,4.462,5.551,3.89z"/>
	            <polygon points="23.5,9.5 20.5,9.5 20.5,6.5 18.5,6.5 18.5,9.5 15.5,9.5 15.5,11.5 18.5,11.5 18.5,14.5 20.5,14.5 20.5,11.5  23.5,11.5"/>
	        </g>
	    </svg>
	</a>

	<a class="email" href="mailto:?subject=<?php echo the_title_attribute(); ?>&amp;body=<?php echo $url; ?>" target="_self">
	    <svg version="1.1" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
	        <path d="M22,4H2C0.897,4,0,4.897,0,6v12c0,1.103,0.897,2,2,2h20c1.103,0,2-0.897,2-2V6C24,4.897,23.103,4,22,4z M7.248,14.434 l-3.5,2C3.67,16.479,3.584,16.5,3.5,16.5c-0.174,0-0.342-0.09-0.435-0.252c-0.137-0.239-0.054-0.545,0.186-0.682l3.5-2 c0.24-0.137,0.545-0.054,0.682,0.186C7.571,13.992,7.488,14.297,7.248,14.434z M12,14.5c-0.094,0-0.189-0.026-0.271-0.08l-8.5-5.5 C2.997,8.77,2.93,8.46,3.081,8.229c0.15-0.23,0.459-0.298,0.691-0.147L12,13.405l8.229-5.324c0.232-0.15,0.542-0.084,0.691,0.147 c0.15,0.232,0.083,0.542-0.148,0.691l-8.5,5.5C12.189,14.474,12.095,14.5,12,14.5z M20.934,16.248 C20.842,16.41,20.673,16.5,20.5,16.5c-0.084,0-0.169-0.021-0.248-0.065l-3.5-2c-0.24-0.137-0.323-0.442-0.186-0.682 s0.443-0.322,0.682-0.186l3.5,2C20.988,15.703,21.071,16.009,20.934,16.248z"/>
	    </svg>
	</a>

</div>

	<?php
}
add_action( 'themedd_entry_content_end', 'affwp_theme_post_sharing', 11 );

/**
 * Add a Twitter Follow button after the author biography on single posts
 *
 * Since the Twitter JS is loaded on single posts, the Twitter sharing icon will
 * use the same widgets.js script and pop up the Twitter window. All other sharing
 * icons will open in new windows
 *
 * @since 1.0.0
 */
function affwp_theme_bio_follow_author() {

	// only show if author has Twitter username entered on the WP profile
	if ( ! get_the_author_meta( 'twitter' ) ) {
		return;
	}

?>
	<a href="https://twitter.com/<?php the_author_meta( 'twitter' ); ?>" class="twitter-follow-button" data-show-count="false">Follow on Twitter</a>
<?php
}
add_action( 'themedd_author_description_end', 'affwp_theme_bio_follow_author' );

/**
 * Add post categories to body class
 * This is so we can style the header sections based on the category the post exists in
 *
 * @since 1.0.0
 */
function affwp_theme_post_body_classes( $classes ) {
	global $post;

	if ( is_singular( 'post' ) ) {

		$categories = get_the_category( $post->ID );

		if ( $categories ) {
			foreach ( $categories as $category ) {
				$classes[] = 'category-' . $category->category_nicename;
			}
		}
	}

	return $classes;
}
add_filter( 'body_class', 'affwp_theme_post_body_classes' );

/**
 * Get the category class for the blog page and single posts
 *
 * @since 1.3.5
 */
function affwp_theme_blog_hero_classes( $post_id = 0 ) {

	global $post;

	$classes = array();

	// add has-image CSS if the post has an SVG icon or animation
	if ( affwp_theme_featured_icon( $post_id ) || affwp_theme_animation_get_image( $post_id ) ) {
		$classes[] = 'has-image';
	} else {
		$classes[] = 'no-image';
	}

	$categories = get_the_category( $post_id );

	if ( $categories ) {
		foreach ( $categories as $category ) {
			$classes[] = 'category-' . $category->category_nicename;
		}
	}

	$classes = implode( ' ', $classes );

	return $classes;
}

/**
 * Output the author and date published
 *
 * @since 1.0.0
 */
function affwp_theme_post_header_meta() {

	global $post;

	// only show on single post
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$author_id    = $post->post_author;
	$author_name  = get_the_author_meta( 'display_name', $author_id );
	$author_email = get_the_author_meta( 'user_email', $author_id );
	$gravatar     = get_avatar( $author_email, 96 );

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$date = sprintf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span>%2$s</span>',
		esc_html_x( 'Posted on', 'Used before publish date.', 'themedd' ),
		$time_string
	);

	?>

	<span class="author-meta"><?php echo $author_name; ?> on <?php echo $date; ?></span>

	<?php
}
add_action( 'themedd_page_header_end', 'affwp_theme_post_header_meta' );

/**
 * Change the labels for the paging navigation
 *
 * @since 1.0.0
 */
function affwp_theme_paging_nav( $defaults ) {

	$defaults['next_posts_link']     = 'Older articles';
	$defaults['previous_posts_link'] = 'Newer articles';

	return $defaults;
}
add_filter( 'themedd_paging_nav', 'affwp_theme_paging_nav' );

/**
 * Add class names to the paging nav links so they can be turned into buttons
 *
 * @since 1.0.0
 */
function affwp_theme_post_link_attributes( $attr ) {

	$attr = 'class="button small outline secondary"';

	return $attr;
}
add_filter( 'next_posts_link_attributes', 'affwp_theme_post_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'affwp_theme_post_link_attributes' );

/**
 * Handle the post offset on the blog page
 *
 * @since 1.3.5
 */
function affwp_theme_blog_query_offset( &$query ) {

    // Return if not home
    if ( ! $query->is_home() ) {
        return;
    }

	// Return if not on main query
	if ( ! $query->is_main_query() ) {
        return;
    }

    // Desired offset
    $offset = 1;

    // Get posts per page
    $posts_per_page = AFFWP_THEME_BLOG_POSTS_PER_PAGE;

    // Detect and handle pagination
    if ( $query->is_paged ) {

        // Manually determine page query offset (offset + current page (minus one) x posts per page)
        $page_offset = $offset + ( ( $query->query_vars['paged'] - 1 ) * $posts_per_page );

        // Apply adjust page offset
        $query->set('offset', $page_offset );

    }
    else {

		if ( ! get_option( 'sticky_posts' ) ) {
			// This is the first page. Just use the offset (if no sticky post)
			$query->set( 'offset', $offset );
		}

		$query->set( 'post__not_in', get_option( 'sticky_posts' ) );

    }

}
add_action( 'pre_get_posts', 'affwp_theme_blog_query_offset', 1 );

/**
 * Handle the post offset on the blog page
 *
 * @since 1.3.5
 */
function affwp_theme_blog_adjust_offset_pagination( $found_posts, $query ) {

    // Define offset again
    $offset = 1;

    // Ensure we're modifying the right query object
    if ( $query->is_home() ) {
        // Reduce WordPress' found_posts count by the offset
        return $found_posts - $offset;
    }

    return $found_posts;

}
add_filter( 'found_posts', 'affwp_theme_blog_adjust_offset_pagination', 1, 2 );

/**
 * Check if we're on the blog page
 *
 * @since 1.3.5
 */
function affwp_theme_is_blog_page() {
	global $wp_query;
	return $wp_query->query_vars['pagename'] === 'blog';
}
