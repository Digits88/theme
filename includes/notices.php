<?php

/**
 * Dequeue simple notices pro
 */
function affwp_theme_dequeue_style() {
	wp_dequeue_style( 'notifications' );
}
add_action( 'wp_enqueue_scripts', 'affwp_theme_dequeue_style' );

/**
 * Show notices
 */
function affwp_theme_display_notice() {

	// don't display notice if there's a discount being used
	if ( isset( $_GET['discount'] ) ) {
		return;
	}

	// Don't show notice if on checkout or purchase confirmation page.
	if ( edd_is_checkout() || edd_is_success_page() ) {
		return;
	}

	// this displays the notification area if the user has not read it before
	global $user_ID;

	$notice_args = array(
		'post_type'      => 'notices',
		'posts_per_page' => 1,
		'meta_key'       => '_enabled',
		'meta_value'     => '1'
	);

	$expired = get_page_by_title( 'License expired', 'OBJECT', 'notices' );

	// exclude notice if license has not expired
	if ( $expired && ! affwp_theme_has_users_license_expired() ) {
		$notice_args['exclude'] = array( $expired->ID );
	}

	$notices = get_posts( $notice_args );

	if ( $notices ) {

		foreach ( $notices as $key => $notice ) {

			$logged_in_only = get_post_meta($notice->ID, '_notice_for_logged_in_only', true);

			$can_view = false;

			if ( $logged_in_only == 'All' ) {
				$can_view = true;
			} else if ( $logged_in_only == 'Logged In' && is_user_logged_in() ) {
				$can_view = true;
			} else if ( $logged_in_only == 'Logged Out' && ! is_user_logged_in() ) {
				$can_view = true;
			}

			if ( $can_view ) {

				if ( function_exists( 'pippin_check_notice_is_read' ) && pippin_check_notice_is_read( $notice->ID, $user_ID ) != true ) { ?>

					<div id="notification-area" class="snp-hidden">

							<div class="notice-content">

								<svg id="announcement" width="32px" height="32px">
								   <use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svgs/svg-defs.svg#icon-announcement'; ?>"></use>
								</svg>

								<?php echo do_shortcode( wpautop( $notice->post_content ) ); ?>

								<?php if( ! get_post_meta($notice->ID, '_hide_close', true)) { ?>

								<a class="remove-notice" href="#" id="remove-notice" rel="<?php echo $notice->ID; ?>">
								<svg width="24px" height="24px">
									   <use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svgs/svg-defs.svg#icon-remove'; ?>"></use>
									</svg>
								</a>

								<?php } ?>

							</div>

					</div>
				<?php }

			} // can view
		}
	}
}

remove_action( 'wp_footer', 'pippin_display_notice' );
add_action( 'themedd_site_before', 'affwp_theme_display_notice' );

/**
 * Let the customer know the discount was successfully applied
 */
function affwp_theme_discount_success() {

	$discount = isset( $_GET['discount'] ) && $_GET['discount'] ? $_GET['discount'] : '';

	$link  = false;
	$class = '';

	// remove link and change message on account page because they will be upgrading etc
	if ( is_page( 'account' ) ) {
		$text  = 'Woohoo! Your discount was successfully added to checkout.';
	} else {
		$text  = 'Woohoo! Your discount was successfully added to checkout. Purchase AffiliateWP now &rarr;';
		$link  = true;
		$class = ' link';
	}

	if ( ! $discount ) {
		return;
	}

	?>
	<div id="notification-area" class="discount-applied<?php echo $class; ?>">
		<div id="notice-content">

		<?php if ( $link ) : ?>
			<a href="/pricing">
		<?php endif; ?>
			<svg id="announcement" width="32px" height="32px">
			   <use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svgs/svg-defs.svg#icon-thumbs-up'; ?>"></use>
			</svg>
			<p><strong><?php echo $text; ?></strong></p>
		<?php if ( $link ) : ?>
			</a>
		<?php endif; ?>

		</div>
	</div>
		<?php
}
add_action( 'themedd_site_before', 'affwp_theme_discount_success' );

/**
 * Add a metabox to the notices post type
 *
 * @since  1.4.7
 */
function affwp_theme_notices_add_meta_box() {
	add_meta_box( 'affwp_theme_sale_notice', 'Sale Notice', 'affwp_theme_notices_sale_meta_box', array( 'notices' ), 'side', 'default' );
}
add_action( 'add_meta_boxes', 'affwp_theme_notices_add_meta_box' );

/**
 * Add the meta box
 *
 * @since  1.4.7
 */
function affwp_theme_notices_sale_meta_box( $post ) {

	$is_sale_notice = get_post_meta( $post->ID, 'affwp_notice_is_sale', true );

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'affwp_theme_sale_notice_nonce', 'affwp_theme_sale_notice_nonce' );

?>
	<p>	<input type="checkbox" name="affwp_notice_is_sale" id="affwp-notice-is-sale" value="1" <?php echo checked( $is_sale_notice, 1 ); ?>/>
		<label for="affwp-notice-is-sale">This is a sale notice</label>
	</p>

<?php
}

/**
 * Save post meta when the save_post action is called
 *
 * @since  1.4.7
 * @param  int $post_id
 * @global array $post All the data of the the current post
 * @return void
 */
function affwp_theme_notices_save_meta_box( $post_id, $post ) {

	/**
	 * We need to verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['affwp_theme_sale_notice_nonce'] ) ) {
		return $post_id;
	}

	$nonce = $_POST['affwp_theme_sale_notice_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'affwp_theme_sale_notice_nonce' ) ) {
		return $post_id;
	}

	// If this is an autosave, our form has not been submitted,
	// so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// Check the user's permissions.
	if ( 'notices' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

	}

	// OK, its safe for us to save the data now.

	$is_sale_notice = isset( $_POST['affwp_notice_is_sale'] ) ? sanitize_text_field( $_POST['affwp_notice_is_sale'] ) : '';

	if ( $is_sale_notice ) {
		// Update post meta.
		update_post_meta( $post_id, 'affwp_notice_is_sale', true );
	} else {
		// Delete post meta.
		delete_post_meta( $post_id, 'affwp_notice_is_sale' );
	}

}
// Save metabox.
add_action( 'save_post', 'affwp_theme_notices_save_meta_box', 10, 2 );
