<?php
/**
 * Pricing
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Pricing Calculator
 *
 * @since 1.0.0
 */
function affwp_theme_pricing_calculator() {

	// Gravity Forms must be installed
	if ( ! affwp_theme_is_gforms_active() ) {
		return;
	}

?>
	<section class="pricing-calculator container action pv-xs-4 center-xs start-sm">
		<div class="wrapper">
			<div class="row middle-xs">
				<div class="col-xs-12 col-md-7 mb-xs-2 mb-md-0">
					<h1 class="header">AffiliateWP pays for itself, fast</h1>
					<p>Use the pricing calculator to find out how many referral sales you'll need to cover the cost of AffiliateWP.</p>
				</div>
				<div class="col-xs-12 col-md-5 end-md">
					<a href="#pricing-calculator" class="popup-content button outline" data-effect="mfp-move-from-bottom">AffiliateWP Pricing Calculator</a>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Show refund policy link
 *
 * @since 1.0.0
 */
function affwp_show_refund_policy_link() {

	ob_start();
	?>

	- <a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">see our refund policy</a>.

	<?php

	return ob_get_clean();
}

/**
 * Modal content - refund policy
 * Shown on pricing page, homepage, checkout
 *
 * @since 1.0.0
 */
function affwp_theme_modal_content_refund_policy() {

	if ( ! ( is_page( 'pricing' ) || is_front_page() || affwp_theme_is_cta_page() || ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() ) ) ) {
		return;
	}

	// get the refund policy page
	$refund_policy = get_page_by_title( 'purchase terms and refund policy' );

	if ( ! $refund_policy ) {
		return;
	}

	?>
	<div id="refund-policy" class="popup entry-content mfp-with-anim mfp-hide">
		<h1><?php echo $refund_policy->post_title; ?></h1>
		<?php echo stripslashes( wpautop( $refund_policy->post_content, true ) ); ?>
	</div>
	<?php
}
add_action( 'wp_footer', 'affwp_theme_modal_content_refund_policy' );

/**
 * Modal content - pricing calculator
 *
 * @since 1.0.0
 */
function affwp_theme_modal_content_pricing_calculator() {

	if ( ! ( is_page( 'pricing' ) || is_front_page() || affwp_theme_is_cta_page() ) ) {
		return;
	}

	$refund_policy = get_page_by_title( 'purchase terms and refund policy' );

	if ( ! $refund_policy ) {
		return;
	}

	// Gravity Forms must be installed
	if ( ! affwp_theme_is_gforms_active() ) {
		return;
	}

	?>

	<div id="pricing-calculator" class="popup entry-content mfp-with-anim mfp-hide">

		<div id="pricing-result">


		<h2><span class="rounded-referral-sale-count"></span> is all you need!</h2>
		<p class="intro">Based on the below, you'll need just <strong><span class="rounded-referral-sale-count"></span></strong> from affiliates to cover the cost of <span class="license-type"></span> license.</p>
		<p>Have a play with our calculator to see how many affiliate-generated sales you need to cover the cost of AffiliateWP! Simply change the figures in the below fields and the calculator will update dynamically.</p>

		<?php /*
		<p>* Non-rounded number: <span class="referral-sale-count"></span></p>
		*/ ?>

		</div>

		<?php

			if ( function_exists( 'gravity_form' ) ) {
				gravity_form( affwp_theme_pricing_calculator_form_id(), false, false, false, '', true );
			}
		?>

		<?php /*
		<a href="#">Would you like to email yourself the above?</a>

		<form class="affwp-form" action="" method="post">
			<p>
				<input id="affwp-send-price-calculation" name="affwp_send_price_calculation" type="email" />
			</p>
			<p>
				<input type="hidden" name="affwp_calculation" />
				<input type="hidden" name="affwp_action" value="affwp_send_email" />
				<input class="button" type="submit" value="<?php esc_attr_e( 'Send', 'affiliate-wp' ); ?>" />
			</p>
		</form>
		*/ ?>

	</div>

	<script>
		jQuery(document).ready(function($) {
			var formID = '<?php echo affwp_theme_pricing_calculator_form_id(); ?>';

			var licenseType = jQuery( "#input_" + formID + "_3" ).find(":selected").text();
			var referralSaleCount = jQuery("#input_" + formID + "_9").val();
			var roundedReferralSaleCount = Math.ceil(referralSaleCount);

			var saleText;

			if ( roundedReferralSaleCount === 1 ) {
				saleText = 'sale';
			} else {
				saleText = 'sales';
			}

			if ( roundedReferralSaleCount === 0 ) {
				roundedReferralSaleCount = 1;
				saleText = 'sale';
			}

			var joinerText = 'a ';

			if ( 'Ultimate ($449)' === licenseType ) {
				joinerText = 'an ';
			}

			jQuery('.license-type').html( joinerText + licenseType );
			jQuery('.rounded-referral-sale-count').html(roundedReferralSaleCount + ' ' + saleText );

			jQuery('.referral-sale-count').html(referralSaleCount + ' ' + saleText );
			jQuery('input[name="affwp_calculation"]').html(roundedReferralSaleCount);

			// update text when the answers have been changed
			jQuery( "#input_" + formID + "_9" ).change(function() {

				var referralSaleCount = jQuery("#input_" + formID + "_9").val();

				var roundedReferralSaleCount = Math.ceil(referralSaleCount);

				if ( roundedReferralSaleCount === 1 ) {
					saleText = 'sale';
				} else {
					saleText = 'sales';
				}

				var referralSaleCount = jQuery(this).val();
				var licenseType = jQuery( "#input_" + formID + "_3" ).find(":selected").text();

				var joinerText = 'a ';

				if ( 'Ultimate ($449)' === licenseType ) {
					joinerText = 'an ';
				}

				jQuery('.rounded-referral-sale-count').html(roundedReferralSaleCount + ' ' + saleText );
				jQuery('.referral-sale-count').html(referralSaleCount + ' ' + saleText);
				jQuery('input[name="affwp_calculation"]').html(roundedReferralSaleCount);
				jQuery('.license-type').html( joinerText + licenseType );

			});

			<?php if ( affwp_theme_is_gforms_active() ) : ?>


			gform.addFilter( 'gform_calculation_formula', function( formula, formulaField, formId, calcObj ) {

				// modify the formula if flat rate is chosen
				if ( formId == '1' && jQuery("#input_" + formID + "_4").val() === 'Flat dollar amount ($)' ) {

					// {Which license are you interested in?:3} / ( {Average price of your product/s:1} - ( ( {Average price of your product/s:1} * {How much commission will your affiliates earn:2} ) / 100 ) )
					formula = '{:3} / ( {:1} - {:2} )';
				}

				return formula;

			});

			<?php endif; ?>

		});
	</script>
	<?php
}
//add_action( 'wp_footer', 'affwp_theme_modal_content_pricing_calculator' );

/**
 * Allows the customer to send themself an email with the result
 *
 * @since 1.0.0
 */
function affwp_theme_send_email() {

	if ( ! ( isset( $_POST['affwp_action'] ) && 'affwp_send_email' === $_POST['affwp_action'] ) ) {
		return;
	}

	$email = isset( $_POST['affwp_send_price_calculation'] ) ? $_POST['affwp_send_price_calculation'] : '';
	$message = isset( $_POST['affwp_calculation'] ) ? $_POST['affwp_calculation'] : '';

	wp_mail( $email, 'AffiliateWP price calculation', $message );

}
//add_action( 'template_redirect', 'affwp_theme_send_email' );

/**
 * Include specific pages that should have the call to action
 *
 * @since 1.0.0
 */
function affwp_theme_is_cta_page() {

	if (
		is_post_type_archive( 'testimonial' ) ||
		is_post_type_archive( 'integration' ) ||
		is_singular( 'integration' ) ||
		is_page( 'screenshots' ) ||
		is_page( 'features' ) ||
		is_page( 'changelog' ) ||
		is_tax( 'type' )
	) {
		return true;
	}

	return false;
}

/**
 * Pricing call to action
 *
 * @since 1.0.0
 * @todo add tracking code so we can see how effective it is
 */
function affwp_themedd_call_to_action() {

	if ( ! affwp_theme_is_cta_page() ) {
		return;
	}

	?>

	<?php /*
	<section class="container highlight action pv-xs-4 cta-get-started">
	    <div class="wrapper">

	        <div class="row middle-xs">
	            <div class="col-xs-12 col-sm-7 mb-xs-2 mb-sm-0 text-center-xs text-left-sm">
					<h1 class="header">Get more sales with AffiliateWP</h1>
	                <p>Our customers tell us that AffiliateWP is easy to use, reliable, and <em>just works</em>. They love it, and we think you’ll love it too. Ready to get started? Try AffiliateWP risk-free today, and start growing your business with affiliate marketing.</p>
	            </div>

				<div class="col-xs col-sm-5 end-sm text-center-xs text-left-sm">
					<a href="<?php echo site_url( 'pricing' ); ?>" class="button outline">Get started now</a>
				</div>

	        </div>

			<div id="graph" class="ct-chart"></div>

	    </div>
	</section>
	*/ ?>

	<section class="highlight action pv-xs-4 cta-get-started">
		<div class="wrapper">
			<div class="container">
				<div class="row middle-xs">
					<div class="col-xs-12 col-sm-7 mb-xs-2 mb-sm-0 text-center-xs text-left-sm">
						<h1 class="header">Get more sales with AffiliateWP</h1>
						<p>Our customers tell us that AffiliateWP is easy to use, reliable, and <em>just works</em>. They love it, and we think you’ll love it too. Ready to get started? Try AffiliateWP risk-free today, and start growing your business with affiliate marketing.</p>
					</div>

					<div class="col-xs col-sm-5 end-sm text-center-xs text-left-sm">
						<a href="<?php echo site_url( 'pricing' ); ?>" class="button outline">Get started now</a>
					</div>

				</div>

				<div id="graph" class="ct-chart"></div>
			</div>



		</div>
	</section>


	<section class="section-grey pv-xs-2 cta-get-started-bottom">
		<div class="wrapper">
			<div class="container">
				<div class="row row middle-xs">

					<div class="col-xs-12 col-sm-4 mb-xs-2 mb-sm-0">
						<svg width="48px" height="48px">
		                    <use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svgs/svg-defs.svg#icon-feature-money-back-guarantee'; ?>"></use>
		                </svg>
						<p>30 day <a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">money back guarantee</a></p>
					</div>

					<div class="col-xs-12 col-sm-4 center-md mb-xs-2 mb-sm-0">
						<svg width="48px" height="48px">
		                    <use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svgs/svg-defs.svg#icon-feature-secure-payment'; ?>"></use>
		                </svg>
						<p>Secure online payment</p>
					</div>

					<div class="col-xs-12 col-sm-4 end-md">
						<svg width="48px" height="48px">
		                    <use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svgs/svg-defs.svg#icon-feature-support'; ?>"></use>
		                </svg>
						<p>Fast and friendly <a href="<?php echo site_url( 'support' ); ?>">support</a></p>
					</div>

				</div>
			</div>

		</div>
	</section>

	<?php
}
add_action( 'themedd_content_end', 'affwp_themedd_call_to_action' );






/**
 * Determine the value of the pro add-ons included with the Professional or Ultimate license
 *
 * @since 1.0.0
 */
function affwp_theme_pro_add_ons_value() {
	return 60 * affwp_theme_get_add_on_count( 'pro' );
}

/**
 * Get a price for a specific pricing option.
 *
 * @since 1.5.2
 */
function affwp_theme_get_price( $pricing_option = '' ) {

	// Return early if no pricing option specified.
	if ( empty( $pricing_option ) ) {
		return;
	}

	switch ( $pricing_option ) {

		case 'ultimate':
			$price = 499;
			break;

		case 'professional':
			$price = 249;
			break;

		case 'plus':
			$price = 149;
			break;

		case 'personal':
			$price = 99;
			break;
	}

	return $price;

}

/**
 * Get the sale price for a specific pricing option.
 *
 * @since 1.5.2
 */
function affwp_theme_get_sale_price( $pricing_option = '' ) {

	// Determine if there is a current sale.
	$current_sale_discount_id = function_exists( 'affwpcf_is_current_sale' ) ? affwpcf_is_current_sale() : false;

	// Return early if there's no sale or no pricing option specified.
	if ( ! $current_sale_discount_id || empty( $pricing_option ) ) {
		return;
	}

	// Get the discount object.
	$discount = edd_get_discount( $current_sale_discount_id );

	// Get the sale amount.
	$sale_amount = $discount->amount;

	// Determine the sale price.
	$sale_price = affwp_theme_get_price( $pricing_option ) - affwp_theme_get_price( $pricing_option ) / 100 * $sale_amount;

	return $sale_price;

}

/**
 * Show the price
 *
 * @since 1.5.2
 */
function affwp_theme_show_price( $pricing_option = '' ) {

	// Return early if no pricing option specified.
	if ( empty( $pricing_option ) ) {
		return;
	}

	// Determine if there is a current sale.
	$current_sale_discount_id = function_exists( 'affwpcf_is_current_sale' ) ? affwpcf_is_current_sale() : false;

	// Get the normal price.
	$price = affwp_theme_get_price( $pricing_option );

	// Get the sale price.
	$sale_price = affwp_theme_get_sale_price( $pricing_option );
	$sale_price = number_format( $sale_price, 2, '.', '' );
	$sale_price = preg_replace('/\.([0-9]*)/', '<sup>.$1</sup>', $sale_price );

	?>

	<?php if ( $current_sale_discount_id ) : ?>

		<?php
		/**
		 * There's a sale, show the old price (crossed out) and the new sale price.
		 */
		?>
		<span class="price old"><sup>$</sup><s><?php echo $price; ?></s></span><span class="price"><sup>$</sup><?php echo $sale_price; ?></span>
	<?php else : ?>

		<?php
		/**
		 * No sale, show the usual price.
		 */
		?>
		<span class="price"><sup>$</sup><?php echo $price; ?></span>

	<?php endif; ?>

	<?php

}

/**
 * Pricing table
 */
function affwp_theme_pricing_table() {

	$download_id = function_exists( 'affwp_theme_get_download_id' ) ? affwp_theme_get_download_id() : '';
	$checkout_url = function_exists( 'edd_get_checkout_uri' ) ? edd_get_checkout_uri() : '';

	$download_url = add_query_arg( array( 'edd_action' => 'add_to_cart', 'download_id' => $download_id ), $checkout_url );

	$count_pro_add_ons           = function_exists( 'affwp_theme_get_add_on_count' ) ? affwp_theme_get_add_on_count( 'pro' ) : '';
	$count_official_free_add_ons = function_exists( 'affwp_theme_get_add_on_count' ) ? affwp_theme_get_add_on_count( 'official-free' ) : '';

?>

	<section class="pricing-table" id="pricing">

			<?php

			$cart_items = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : '';

			if ( $cart_items ) {
				$options = wp_list_pluck(  $cart_items, 'options' );
				$price_ids = wp_list_pluck(  $options, 'price_id' );
			}

			?>

			<div class="row pricing table-row mb-xs-2">

				<?php
					$price_id = 3;
					$in_cart = $cart_items ? in_array( $price_id, $price_ids ) : '';
					$in_cart_class = $cart_items && in_array( $price_id, $price_ids ) ? ' in-cart' : '';
				?>
	            <div class="col-xs-12 col-sm-6 col-lg-3 center-xs mb-xs-5 mb-sm-2<?php echo $in_cart_class; ?>">
	                <div class="table-option pv-xs-2">
						<?php if ( $in_cart ) : ?>
						<span>In your cart</span>
						<?php endif; ?>
                        <h2>Ultimate</h2>

                        <ul class="mb-xs-2">

							<li class="pricing">
								<?php echo affwp_theme_show_price( 'ultimate' ); ?>
								<span class="length">one-time payment</span>
							</li>
							<li class="feature price">
								<a href="#modal-pro-add-ons" class="popup-content link-highlight" data-effect="mfp-move-from-bottom"><strong><?php echo $count_pro_add_ons; ?> pro add-ons</strong></a>
								<span class="add-on-value">(a massive <span>$<?php echo affwp_theme_pro_add_ons_value(); ?></span> value!)</span>
							</li>
							<li class="feature"><span class="plus">PLUS</span> all future pro add-ons</li>
							<li class="feature"><strong><a href="#modal-offical-free-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_official_free_add_ons; ?> official free add-ons</a></strong></li>
                            <li class="feature"><strong>Lifetime plugin updates</strong></li>
                            <li class="feature"><strong>Lifetime email support</strong></li>
							<li class="feature"><strong>Unlimited sites</strong></li>
							<li class="feature">All core features included</li>

                        </ul>

                        <div class="footer">
							<?php
								if ( $in_cart ) {
									$button_link = $checkout_url;
									$text = 'Checkout';
								} else {
									$button_link = $download_url . '&amp;edd_options[price_id]=' . $price_id;
									$text = 'Purchase';
								}
							?>
							<a class="button" href="<?php echo $button_link; ?>"><?php echo $text; ?></a>
                        </div>

	                </div>
	            </div>

				<?php
					$price_id = 2;
					$in_cart = $cart_items ? in_array( $price_id, $price_ids ) : '';
					$in_cart_class = $cart_items && in_array( $price_id, $price_ids ) ? ' in-cart' : '';

					if ( ! $cart_items ) {
						$highlight_class = ' best-value';
					} else {
						$highlight_class = '';
					}
				?>
	            <div class="col-xs-12 col-sm-6 col-lg-3 center-xs mb-xs-2<?php echo $highlight_class; ?><?php echo $in_cart_class; ?>">

	                <div class="table-option pv-xs-2">
						<?php if ( ! $cart_items ) : ?>
						<span>Most popular</span>
						<?php endif; ?>

						<?php if ( $in_cart ) : ?>
						<span>In your cart</span>
						<?php endif; ?>

	                        <h2>Professional</h2>

	                        <ul class="mb-xs-2">
	                            <li class="pricing">
									<?php echo affwp_theme_show_price( 'professional' ); ?>
									<span class="length">first year</span>
								</li>

								<li class="feature price">
									<a href="#modal-pro-add-ons" class="popup-content link-highlight" data-effect="mfp-move-from-bottom"><strong><?php echo $count_pro_add_ons; ?> pro add-ons</strong></a>
									<span class="add-on-value">(a massive <span>$<?php echo affwp_theme_pro_add_ons_value(); ?></span> value!)</span>
								</li>
								<li class="feature"><span class="plus">PLUS</span> all future pro add-ons</li>
								<li class="feature"><strong><a href="#modal-offical-free-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_official_free_add_ons; ?> official free add-ons</a></strong></li>
	                            <li class="feature">Plugin updates *</li>
	                            <li class="feature">Email support *</li>
								<li class="feature"><strong>Unlimited sites</strong></li>
								<li class="feature">All core features included</li>
	                        </ul>

							<div class="footer">
								<?php
									if ( $in_cart ) {
										$button_link = $checkout_url;
										$text = 'Checkout';
									} else {
										$button_link = $download_url . '&amp;edd_options[price_id]=' . $price_id;
										$text = 'Purchase';
									}
								?>
								<a class="button" href="<?php echo $button_link; ?>"><?php echo $text; ?></a>
	                        </div>
	                </div>
	            </div>

				<?php
					$price_id = 1;
					$in_cart = $cart_items ? in_array( $price_id, $price_ids ) : '';
					$in_cart_class = $cart_items && in_array( $price_id, $price_ids ) ? ' in-cart' : '';
				?>
	            <div class="col-xs-12 col-sm-6 col-lg-3 center-xs mb-xs-2<?php echo $in_cart_class; ?>">
	                <div class="table-option pv-xs-2">
						<?php if ( $in_cart ) : ?>
						<span>In your cart</span>
						<?php endif; ?>
							<h2>Plus</h2>

	                        <ul class="mb-xs-2">

								<li class="pricing">
									<?php echo affwp_theme_show_price( 'plus' ); ?>
									<span class="length">first year</span>
								</li>
								<li class="feature"><strong><a href="#modal-offical-free-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_official_free_add_ons; ?> official free add-ons</a></strong></li>

	                            <li class="feature">Plugin updates *</li>
	                            <li class="feature">Email support *</li>
								<li class="feature">3 sites</li>
								<li class="feature">All core features included</li>
	                        </ul>

							<div class="footer">
								<?php
									if ( $in_cart ) {
										$button_link = $checkout_url;
										$text = 'Checkout';
									} else {
										$button_link = $download_url . '&amp;edd_options[price_id]=' . $price_id;
										$text = 'Purchase';
									}
								?>
								<a class="button" href="<?php echo $button_link; ?>"><?php echo $text; ?></a>
	                        </div>
	                </div>
	            </div>

				<?php
					$price_id = 0;
					$in_cart = $cart_items ? in_array( $price_id, $price_ids ) : '';
					$in_cart_class = $cart_items && in_array( $price_id, $price_ids ) ? ' in-cart' : '';
				?>
	            <div class="col-xs-12 col-sm-6 col-lg-3 center-xs mb-xs-2<?php echo $in_cart_class; ?>">
	                <div class="table-option pv-xs-2">
						<?php if ( $in_cart ) : ?>
						<span>In your cart</span>
						<?php endif; ?>
	                        <h2>Personal</h2>

	                        <ul class="mb-xs-2">

								<li class="pricing">
									<?php echo affwp_theme_show_price( 'personal' ); ?>
									<span class="length">first year</span>
								</li>

								<li class="feature"><strong><a href="#modal-offical-free-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_official_free_add_ons; ?> official free add-ons</a></strong></li>

								<li class="feature">Plugin updates *</li>
	                            <li class="feature">Email support *</li>
								<li class="feature">1 site</li>
								<li class="feature">All core features included</li>
	                        </ul>

							<div class="footer">
								<?php
									if ( $in_cart ) {
										$button_link = $checkout_url;
										$text = 'Checkout';
									} else {
										$button_link = $download_url . '&amp;edd_options[price_id]=' . $price_id;
										$text = 'Purchase';
									}
								?>
								<a class="button" href="<?php echo $button_link; ?>"><?php echo $text; ?></a>
	                        </div>

	                </div>
	            </div>

	        </div>

			<div class="row center-xs">
				<div class="col-xs-12">
					<p class="mb-xs-0">* Plugin updates and email support are provided for the duration of your current subscription.<br/><span class="add-on-clause">Pro add-ons are only available with Professional and Ultimate licenses.</span> <?php if( is_page('pricing') ) { echo '<br/>See FAQs below for details.'; } ?> All purchases are subject to our terms of use.</p>
				</div>
			</div>

	</section>

	<?php affwp_theme_add_on_popups(); ?>

	<?php
}


/**
 * Addon popups
 */
function affwp_theme_add_on_popups() {

	  $args = array(
	      'post_type' => 'download',
	      'posts_per_page' => -1,
	      'tax_query' => array(
	          array(
	              'taxonomy' => 'download_category',
	              'field' => 'slug',
	              'terms' => 'pro'
	          )
	      )
	  );

	  $wp_query = new WP_Query( $args );
	?>

	<div id="modal-pro-add-ons" class="modal addons popup entry-content mfp-with-anim mfp-hide">
		<h1>Pro add-ons</h1>
		<p>Pro add-ons are only available to <strong>Professional</strong> or <strong>Ultimate</strong> license-holders. These license-holders will also receive any additional pro add-ons we release in the future.</p>
		<?php if ( $wp_query->have_posts() ) : ?>

		    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

		        <article>

					<div class="row">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="col-xs-12 col-sm-6">
								<h3><?php the_title(); ?></h3>
								<?php the_excerpt(); ?>
							</div>
							<div class="col-xs-12 col-sm-6">
								<?php themedd_post_thumbnail( 'thumbnail', false ); ?>
							</div>
						<?php else : ?>
							<div class="col-xs-12">
								<h3><?php the_title(); ?></h3>
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>
					</div>
				</article>

		    <?php endwhile; wp_reset_query(); ?>

		<?php endif; ?>

	</div>

	<?php

	  $args = array(
	      'post_type' => 'download',
	      'posts_per_page' => -1,
	      'tax_query' => array(
	          array(
	              'taxonomy' => 'download_category',
	              'field' => 'slug',
	              'terms' => 'official-free'
	          )
	      )
	  );

	  $official_free = new WP_Query( $args );

	?>

	<div id="modal-offical-free-add-ons" class="modal addons popup entry-content mfp-with-anim mfp-hide">

		<h1>Official Free Add-ons</h1>

		<?php if ( $official_free->have_posts() ) : ?>

		    <?php while ( $official_free->have_posts() ) : $official_free->the_post(); ?>

				<article>

					<div class="row">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="col-xs-12 col-sm-6">
								<h3><?php the_title(); ?></h3>
								<?php the_excerpt(); ?>
							</div>
							<div class="col-xs-12 col-sm-6">
								<?php themedd_post_thumbnail( 'thumbnail', false ); ?>
							</div>
						<?php else : ?>
							<div class="col-xs-12">
								<h3><?php the_title(); ?></h3>
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>
					</div>
				</article>

		    <?php endwhile; wp_reset_query(); ?>

		<?php endif; ?>

	</div>

	<?php
}
