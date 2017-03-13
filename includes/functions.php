<?php

/**
 * Retrieve the featured icon
 * Featured icons can be shown on single posts and downloads
 *
 * @since 1.0.0
 */
function affwp_theme_featured_icon( $post_id = 0 ) {

	$post_id = ! empty( $post_id ) ? $post_id : get_the_ID();

	if ( class_exists( 'MultiPostThumbnails' ) && MultiPostThumbnails::get_the_post_thumbnail( get_post_type(), 'feature-icon', $post_id ) ) {
		return MultiPostThumbnails::get_the_post_thumbnail( get_post_type(), 'feature-icon', $post_id );
	}

	return false;
}

/**
 * Is Gravity Forms active?
 *
 * @since 1.0.0
 * @return bool
 */
function affwp_theme_is_gforms_active() {
	return class_exists( 'GFForms' );
}

/**
 * Count how many screenshots there are
 * Images must be uploaded directly to post/page and cannot already exist (or the parent ID will be incorrect)
 *
 * @since 1.0.0
 */
function affwp_theme_screenshot_count() {

	$count = 0;

	$page = get_page_by_title( 'Screenshots' );

	$args = array(
		'post_mime_type' => 'image',
		'numberposts'    => -1,
		'post_parent'    => $page->ID,
		'post_type'      => 'attachment',
	);

	$gallery = get_children( $args );

	if ( $gallery ) {
		$count = count( $gallery );
	}

	return $count;

}

/**
 * Determine if the purchase was part of a sale
 */
function affwp_theme_was_sale_purchase() {

	$purchase_session = edd_get_purchase_session();

	if ( $purchase_session && ! ( isset( $_GET['payment_key'] ) && $_GET['payment_key'] ) ) {

		// main purchase confirmation page
		$payment_id = edd_get_purchase_id_by_key( $purchase_session['purchase_key'] );

	} elseif ( isset( $_GET['payment_key'] ) && $_GET['payment_key'] ) {

		$payment_key = isset( $_GET['payment_key'] ) ? $_GET['payment_key'] : '';

		if ( $payment_key ) {
			// get the payment ID from the purchase key
			$payment_id = edd_get_purchase_id_by_key( $payment_key );
		}
	}

	// payment ID found
	if ( isset( $payment_id ) ) {

		$payment   = new EDD_Payment( $payment_id );
		$discounts = $payment->discounts;

		// purchase must contain discount, discount must be started, active, and not expired

		$discount_id = edd_get_discount_id_by_code( $discounts );

		if (
			function_exists( 'affwpcf_discount_ids' ) &&
			in_array( $discount_id, affwpcf_discount_ids() ) && // make sure discount exists in the discount array
			edd_is_discount_started( $discount_id, false ) &&   // make sure discount has started, don't set error at checkout
			edd_is_discount_active( $discount_id ) &&           // make sure discount is active
			! edd_is_discount_expired( $discount_id )           // make sure discount has not expired
		) {
			return $discounts;
		}

	}

	return false;
}
