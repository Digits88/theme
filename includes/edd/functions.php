<?php
/**
 * EDD functions
 */

/**
 * Get's the customer's first name from purchase session
 *
 * @since 1.0.0
 */
function affwp_theme_edd_purchase_get_first_name() {
	// get purchase session
	$purchase_session = edd_get_purchase_session();

	// get the key
	$purchase_key = $purchase_session['purchase_key'];

	// get the payment ID from the purchase key
	$payment_id = edd_get_purchase_id_by_key( $purchase_key );

	$user_info  = edd_get_payment_meta_user_info( $payment_id );
	$first_name = $user_info['first_name'];

	if ( $first_name )
		return $first_name;

	return null;
}

/**
 * Get ID of AffiliateWP based on title
 *
 * @since  1.0.0
 */
function affwp_theme_get_download_id() {

	$download     = get_page_by_title( 'AffiliateWP', OBJECT, 'download' );
	$download_id  = $download ? $download->ID : '';

	if ( $download_id ) {
		return $download_id;
	}

	return false;
}

/**
 * Get supported integrations for a specific download
 *
 * @since 1.0.0
 */
function affwp_theme_get_integrations( $download_id = 0 ) {

	if ( ! $download_id ) {
		return false;
	}

	// does it support all integrations?
	$all_integrations = get_post_meta( $download_id, '_affwp_integration_all', true );

	if ( $all_integrations ) {
		return affwp_theme_get_all_integrations();
	}

	$integrations = get_post_meta( $download_id, '_affwp_integration' );

	if ( $integrations ) {
		return $integrations;
	}

	return false;

}

/**
 * Get an array of all integration IDs
 *
 * @since 1.0.0
 * @return array $integrations
 */
function affwp_theme_get_all_integrations() {

	$args = array(
		'posts_per_page' => -1,
		'post_type'      => 'integration',
		'orderby'        => 'menu_order',
		'order'          => 'ASC'
	);

	if ( current_user_can( 'manage_options' ) ) {
		$args['post_status'] = array( 'pending', 'draft', 'future', 'publish' );
	}

	$integrations = get_posts( $args );

	if ( $integrations ) {
		return wp_list_pluck( $integrations, 'ID' );
	}

	return false;
}

/**
 * Get number of add-ons in the pro add-ons category
 * Excludes any add-ons that are coming soon
 *
 * @since  1.0.0
 * @return int number of add-ons
 */
function affwp_theme_get_pro_add_on_count() {

	$args = array(
		'post_type'         => 'download',
		'download_category' => 'pro',
		'posts_per_page'    => -1,
	);

	$add_ons = new WP_Query( $args );

	return (int) $add_ons->found_posts;

}


/**
 * Determine if a download is a pro add-on or not
 *
 * @since  1.0.0
 */
function affwp_theme_is_pro_add_on( $download_id = 0 ) {

	if ( has_term( 'pro', 'download_category', $download_id ) ) {
		return true;
	}

	return false;

}

/**
 * Get number of add-ons in each category
 * @return string number of add-ons
 *
 * @since 1.0.0
 */
function affwp_theme_get_add_on_count( $add_on_category = '' ) {

	if ( ! $add_on_category ) {
		return;
	}

	$args = array(
		'type'     => 'download',
		'taxonomy' => 'download_category',
	);

	$categories = get_categories( $args );

	foreach ( $categories as $category ) {
		if ( $category->slug == $add_on_category ) {
			$count = $category->count;
			return $count;
		}
	}

}

/**
 * Get a user's download price IDs that they have access to
 *
 * @since  1.0.0
 */
function affwp_theme_get_users_licenses( $user_id = 0 ) {

	if ( ! function_exists( 'edd_software_licensing' ) ) {
		return;
	}

	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}

	// if user is still a guest return an empty array as their ID will be 0
	if ( ! $user_id ) {
		return array();
	}

	$args = array(
		'posts_per_page' => -1,
		'post_type'      => 'edd_license',
		'meta_key'       => '_edd_sl_user_id',
		'meta_value'     => $user_id,
		'fields'         => 'ids'
	);

	$keys     = array();
	$licenses = get_posts( $args );

	if ( $licenses ) {
		foreach ( $licenses as $key ) {
			$keys[ $key ] = array(
				'license'     => get_post_meta( $key, '_edd_sl_key', true ),
				'price_id'    => get_post_meta( $key, '_edd_sl_download_price_id', true ),
				'limit'       => edd_software_licensing()->get_license_limit( affwp_theme_get_download_id(), $key ),
				'expires'     => edd_software_licensing()->get_license_expiration( $key )
			);
		}
	}

	return $keys;
}



/**
 * Get users price ids
 *
 * @since 1.0.0
 */
function affwp_theme_get_users_price_ids( $user_id = 0 ) {

	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}

	$keys = affwp_theme_get_users_licenses( $user_id );

	if ( $keys ) {
		$keys = wp_list_pluck( $keys, 'price_id' );
	} else {
		$keys = array();
	}

	return $keys;

}

/**
 * Get the download URL of AffiliateWP, based on the user's purchase
 *
 * @since 1.0.0
 */
function affwp_theme_edd_download_url( $download_id = 0 ) {

	if ( ! function_exists( 'edd_software_licensing' ) ) {
		return;
	}

	// get user's current purchases
	$purchases = edd_get_users_purchases( get_current_user_id(), -1, false, 'complete' );

	$found_purchase_key = false;

	if ( $purchases ) {

		foreach ( $purchases as $key => $purchase ) {

			$payment_meta = edd_get_payment_meta( $purchase->ID );

			// get array of all downloads purchased
			$download_ids = wp_list_pluck( $payment_meta['downloads'], 'id' );

			// download found
			if ( in_array( $download_id, $download_ids ) ) {

				// get customer's license keys.
				// we need to find the first non-expired license key
				$licenses = edd_software_licensing()->get_licenses_of_purchase( $purchase->ID );

				if ( $licenses ) {

					foreach ( $licenses as $license ) {

						// license must not be expired (it will be inactive or active)
						if ( 'expired' !== edd_software_licensing()->get_license_status( $license->ID ) ) {
							$found_purchase_key = $key;
							break 2;
						}

					}
				}
			}
		} // endforeach

		// get payment meta for the purchase containing the download
		// payment key could be int 0
		if ( is_int( $found_purchase_key ) ) {

			$payment_meta = edd_get_payment_meta( $purchases[$found_purchase_key]->ID );

			// get the download files for the download
			$download_files = edd_get_download_files( $download_id );

			if ( ! $download_files ) {
				// no download file exists
				return false;
			}

			// we want to retrieve the first download file attached
			$download_index = array_keys( $download_files );

			// build the download URL
			$download_url = edd_get_download_file_url( $payment_meta['key'], $payment_meta['user_info']['email'], $download_index[0], $download_id );

			if ( $download_url ) {
				return $download_url;
			}
		}

	}

	return false;

}

/**
 * Returns the URL to download an add on
 *
 * @since 1.0.0
 * @return string
*/
function affwp_theme_get_add_on_download_url( $add_on_id = 0 ) {

	$args = array(
		'edd_action' => 'add_on_download',
		'add_on'     => $add_on_id,
	);

	return add_query_arg( $args, home_url() );
}

/**
 * Check an individual license to see if it has expired
 */
function affwp_theme_has_license_expired( $license = '' ) {

	if ( ! $license ) {
		return false;
	}

	$check_license = edd_software_licensing()->check_license(
		array(
			'key'     => $license,
			'item_id' => affwp_theme_get_download_id()
		)
	);

	if ( $check_license === 'expired' ) {
		return true;
	}

	return false;
}

/**
 * Check if any of the user's license has expired
 * @since 1.3
 */
function affwp_theme_has_users_license_expired() {

	if ( ! function_exists( 'edd_software_licensing' ) ) {
		return;
	}

	$edd_sl      = edd_software_licensing();
	$licenses    = affwp_theme_get_users_licenses();
	$has_expired = false;

	if ( $licenses ) {

		foreach ( $licenses as $license ) {

			if ( affwp_theme_has_license_expired( $license['license'] ) ) {
				$has_expired = true;
				break;
			}

		}

	}

	return $has_expired;
}

/**
 * Find out if customer can access pro add-ons
 * This will return true if the customer at least 1 valid (active and not expired) Pro or Ultimate license
 */
function affwp_theme_can_access_pro_add_ons() {

	// set flag to false by default
	$can_access = false;

	// get users licenses
	$licenses = affwp_theme_get_users_licenses();

	if ( $licenses ) {

		// loop through licenses
		foreach ( $licenses as $id => $license ) {

			// user has ultimate license, nothing to see here, let them through.
			if ( $license['price_id'] === '3' ) {
				$can_access = true;
				break;
			}

			// customer has professional license
			if ( $license['price_id'] === '2' ) {

				// find at least 1 professional license that hasn't expired
				if ( ! affwp_theme_has_license_expired( $license['license'] ) ) {
					// customer can access pro add-ons
					$can_access = true;
					break;
				}

			}

		}

	}

	return $can_access;

}

/**
 * Can the user become an affiliate?
 *
 * Customer can apply to become an affiliate after 45 days
 */
function affwp_theme_can_become_affiliate() {

	// Return early if the customer is not logged in.
	if ( ! is_user_logged_in() ) {
		return;
	}

	$can_become_affiliate = false;
	$purchase_date        = '';
	$purchases            = edd_get_users_purchases( get_current_user_id(), -1, false, 'complete' );

	// reverse the array so it looks at oldest purchases first
	$purchases = $purchases ? array_reverse( $purchases ) : '';

	if ( ! empty( $purchases ) ) {

		foreach ( $purchases as $purchase ) {

			$payment = get_post_meta( $purchase->ID, '_edd_payment_meta', true );

			$downloads = $payment['downloads'];

			if ( $downloads ) {

				if ( current_user_can( 'manage_options' ) ) {
					var_dump( $downloads );
				}

				foreach ( $downloads as $download ) {

					if ( $download['id'] === affwp_theme_get_download_id() ) {

						// AffiliateWP was purchased, get the data and exit out of loop
						$purchase_date = get_post_meta( $purchase->ID, '_edd_completed_date', true );
						break 2;
					}
				}
			}
		}
	}

	if ( $purchase_date ) {
		// if the current time is 45 days past the compelted date, return true;
		$current_blog_time = current_time( 'mysql' );

		$date1 = new DateTime( $purchase_date );
		$date2 = new DateTime( $current_blog_time );

		$days_since_purchase = $date2->diff( $date1 )->format("%a");

		$days_to_wait = 45;

		if ( $days_since_purchase >= $days_to_wait ) {
			$can_become_affiliate = true;
		}
	}

	return $can_become_affiliate;

}
add_action( 'template_redirect', 'affwp_theme_can_become_affiliate' );
