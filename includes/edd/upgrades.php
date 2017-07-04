<?php
/**
 * Upgrades
*/

/**
 * Determine if a customer can upgrade their license (Software licensing plugin)
 *
 * @since 1.0.0
 */
function themedd_edd_can_upgrade_license() {

	if ( ! themedd_is_edd_sl_active() ) {
		return;
	}

	$can_upgrade = false;

	$license_keys = edd_software_licensing()->get_license_keys_of_user();

	if ( $license_keys ) {
		foreach ( $license_keys as $license ) {
			 if ( edd_sl_license_has_upgrades( $license->ID ) && 'expired' !== edd_software_licensing()->get_license_status( $license->ID ) ) {
				$can_upgrade = true;
				break;
			 }
		}
	}

	return $can_upgrade;

}

/**
 * Processes the license upgrade
 */
function affwp_theme_process_license_upgrade() {

	// get type. plus, professional or ultimate
	$type    = isset( $_GET['type'] ) ? strtolower( $_GET['type'] ) : '';
	$license = isset( $_GET['key'] ) ? strtolower( $_GET['key'] ) : '';

	if ( ! is_user_logged_in() || ( 'plus' !== $type && 'professional' !== $type && 'ultimate' !== $type ) ) {
		// Isn't logged in, so go back to pricing
		wp_redirect( home_url( '/pricing/' ) ); exit;
	}

	$affwp_id = affwp_theme_get_download_id();
	$licenses = affwp_theme_get_users_licenses();

	$has_ultimate_license     = in_array( 3, affwp_theme_get_users_price_ids() );
	$has_professional_license = in_array( 2, affwp_theme_get_users_price_ids() );
	$has_plus_license         = in_array( 1, affwp_theme_get_users_price_ids() );
	$has_personal_license     = in_array( 0, affwp_theme_get_users_price_ids() );

	switch ( $type ) {

		case 'ultimate':

			if ( $has_professional_license ) {
				$discount = 199;
			} elseif ( $has_plus_license ) {
				$discount = 99;
			} elseif ( $has_personal_license ) {
				$discount = 49;
			} else {
				// Hasn't purchased, so go back to pricing
				wp_redirect( home_url( '/pricing/' ) ); exit;
			}

			$price_id = 3;

			break;

		case 'professional':

			if ( $has_plus_license ) {
				$discount = 99;
			} elseif ( $has_personal_license ) {
				$discount = 49;
			} else {
				// Hasn't purchased, so go back to pricing
				wp_redirect( home_url( '/pricing/' ) ); exit;
			}

			$price_id = 2;

			break;

		case 'plus':

			if ( $has_personal_license ) {
				$discount = 49;
			}
			else {
				// Hasn't purchased, so go back to pricing
				wp_redirect( home_url( '/pricing/' ) ); exit;
			}

			$price_id = 1;

			break;

	} // end switch

	// Remove anything in the cart
	edd_empty_cart();

	// Add the correct license
	edd_add_to_cart( $affwp_id, array( 'price_id' => $price_id, 'upgrade' => $license ) );

	EDD()->session->set( 'is_upgrade', '1' );
	EDD()->session->set( 'upgrade_price_id', $price_id );
	EDD()->session->set( 'upgrade_key', $license );
	EDD()->session->set( 'upgrade_discount', $discount );

	wp_redirect( edd_get_checkout_uri() ); exit;

}
add_action( 'edd_upgrade_affwp_license', 'affwp_theme_process_license_upgrade' );

/**
 * Sets the discount amount based on the upgrade fee
 *
 * @since 1.0.0
 * @param $discount float The discount amount
 * @param $item array the cart item array
 * @return float
 */
function affwp_theme_cart_item_discounted_amount( $discounted_price, $discounts, $item, $price ) {

	if ( ! function_exists( 'EDD' ) ) {
		return $discounted_price;
	}

	if ( ! EDD()->session->get( 'is_upgrade' ) ) {
		return $discounted_price;
	}

	$price_id         = EDD()->session->get( 'upgrade_price_id' );
	$upgrade_discount = EDD()->session->get( 'upgrade_discount' );
	$cart_discounts   = edd_get_cart_discounts();

	if( $upgrade_discount && edd_cart_has_discounts() ) {

		$discounted_price = $price - $upgrade_discount;
		foreach( $cart_discounts as $discount ) {

			$discounted_price = edd_get_discounted_amount( $discount, $discounted_price );

		}
	}

	return $discounted_price;
}
add_filter( 'edd_get_cart_item_discounted_amount', 'affwp_theme_cart_item_discounted_amount', 10, 4 );

/**
 * Sets the discount amount based on the upgrade fee
 *
 * @since 1.0.0
 * @param $discount float The discount amount
 * @param $item array the cart item array
 * @return float
 */
function affwp_theme_cart_details_item_discount( $discount, $item ) {

	if ( ! function_exists( 'EDD' ) ) {
		return $discount;
	}

	if ( ! EDD()->session->get( 'is_upgrade' ) ) {
		return $discount;
	}

	if ( edd_cart_has_discounts() ) {
		return $discount;
	}

	$price_id         = EDD()->session->get( 'upgrade_price_id' );
	$upgrade_discount = EDD()->session->get( 'upgrade_discount' );

	$item_price_id = isset( $item['options']['price_id'] ) ? $item['options']['price_id'] : '';

	if ( $upgrade_discount & ( $item_price_id == $price_id ) ) {
		$discount = $upgrade_discount;
	}

	return $discount;

}
add_filter( 'edd_get_cart_content_details_item_discount_amount', 'affwp_theme_cart_details_item_discount', 10, 2 );

/**
 * Displays the upgrade discount row on the cart
 *
 * @since 1.0.0
 * @return void
 */
function affwp_theme_cart_items_upgrade_row() {

	if ( ! EDD()->session->get( 'is_upgrade' ) ) {
		return;
	}

	$upgrade_discount = EDD()->session->get( 'upgrade_discount' );
	$upgrade_price_id = EDD()->session->get( 'upgrade_price_id' );

	$cart_contents = edd_get_cart_contents();
	$show_discount = false;

	if ( $cart_contents ) {
		foreach ( $cart_contents as $download ) {
			$price_id = isset( $download['options']['price_id'] ) ? $download['options']['price_id'] : '';

			 if ( $price_id == $upgrade_price_id ) {
			 	$show_discount = true;
			 	break;
			 }
		}
	}

	if ( ! $show_discount ) {
		return;
	}
?>
	<tr class="edd_cart_footer_row edd_sl_renewal_row">
		<td colspan="3"><?php printf( __( 'License upgrade discount: $%s', 'edd_sl' ), $upgrade_discount ); ?></td>
	</tr>
<?php
}
add_action( 'edd_cart_items_after', 'affwp_theme_cart_items_upgrade_row' );

/**
 * Update payment status
 *
 * @since 1.0.0
 * @return void
 */
function affwp_theme_post_upgrade_license_updates( $payment_id, $new_status, $old_status ) {

	if ( ! function_exists( 'edd_software_licensing' ) ) {
		return;
	}

	if ( $old_status == 'publish' || $old_status == 'complete' )
		return; // Make sure that payments are only completed once

	// Make sure the payment completion is only processed when new status is complete
	if ( $new_status != 'publish' && $new_status != 'complete' )
		return;

	$edd_sl = edd_software_licensing();

	$items = edd_get_payment_meta_cart_details( $payment_id );
	foreach ( $items as $index => $item ) {
		if ( ! empty( $item['item_number']['options']['upgrade'] ) ) {

			// Prevent a new license from being created
			remove_action( 'edd_complete_download_purchase', array( $edd_sl, 'generate_license' ), 0 );

			$key     = $item['item_number']['options']['upgrade'];
			$license = $edd_sl->get_license_by_key( $key );
			update_post_meta( $license, '_edd_sl_download_price_id', $item['item_number']['options']['price_id'] );
			update_post_meta( $license, '_edd_sl_cart_index', $index );
			add_post_meta( $license, '_edd_sl_payment_id', $payment_id );

		}
	}

}
add_action( 'edd_update_payment_status', 'affwp_theme_post_upgrade_license_updates', -9999, 3 );
