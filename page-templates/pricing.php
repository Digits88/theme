<?php
/**
 * Template Name: Pricing
 */

get_header(); ?>

<?php
	themedd_page_header(
		array(
			'title'    => 'Start making more money, risk-free',
			'subtitle' => 'Purchase in confidence with our 30 Day Money Back Guarantee ' . affwp_show_refund_policy_link(),
			'classes'  => array( 'mb-sm-4', 'center-xs' )
		)
	);
?>

<section class="mb-xs-2 mb-lg-4 container">
	<div class="wrapper wide">
		<?php affwp_theme_pricing_table(); ?>
	</div>
</section>

<?php //affwp_theme_pricing_calculator(); ?>

<?php
/**
 * 30 Day Money Back Guarantee
 */
?>

<?php /*
<section class="container pv-xs-2 pv-lg-4 highlight">
    <div class="wrapper center-xs">
		<h2>30 Day Money Back Guarantee</h2>
        <p>We stand behind our product 100% <?php echo affwp_show_refund_policy_link(); ?></p>
    </div>
</section>
*/ ?>

<?php
$count_pro_add_ons           = function_exists( 'affwp_theme_get_add_on_count' ) ? affwp_theme_get_add_on_count( 'pro' ) : '';
$count_official_free_add_ons = function_exists( 'affwp_theme_get_add_on_count' ) ? affwp_theme_get_add_on_count( 'official-free' ) : '';
?>

<section class="container faqs faqs-new">
	<div class="wrapper pv-xs-2 pv-sm-4">
	<h2 class="center-sm mb-sm-4">Questions and Answers</h2>

	<div class="row around-sm mb-xs-2 mb-lg-4">

		<div class="col-xs-12 col-sm-6">

			<div class="faq">
				<h4>Can I purchase the pro add-ons separately?</h4>
				<p>The pro add-ons are only available to Professional or Ultimate license holders and cannot be purchased separately.</p>
			</div>

			<div class="faq">
				<h4>Do I get access to add-ons?</h4>
				<p>We have <a href="#modal-offical-free-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_official_free_add_ons; ?> official free add-ons</a> available for all license holders.</p>

				<p>If you have either a Professional or Ultimate license you also receive access to <a href="#modal-pro-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_pro_add_ons; ?> pro add-ons</a>, plus any additional pro add-ons we release in the future.</p>

				<p>There are also 3rd-party add-ons (free and paid) available to either download or purchase.</p>
			</div>



			<div class="faq">
				<h4>Do you have a refund policy?</h4>
				<p><a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">Yes we do</a>! We firmly stand behind the quality of our product and will refund 100% of your money within 30 days of purchase if you are unhappy with the plugin.</p>
			</div>

			<div class="faq">
				<h4>Do I get updates for the plugin?</h4>
				<p>Yes! Automatic updates are available free of charge to all users with a valid license key.</p>
			</div>

			<div class="faq">
				<h4>What is a "site"?</h4>
				<p>In our pricing above, a "site" refers to the number of WordPress websites you can use AffiliateWP on (you can have an unlimited number of affiliates promoting your website).</p>
			</div>

			<div class="faq">
				<h4>Do you offer support if I need help?</h4>
				<p>Yes! Top-notch customer support is key for a quality product, so we’ll do our very best to resolve any issues you encounter via our <a title="Support" href="<?php echo site_url( 'support' ); ?>">support page</a>.</p>
			</div>

			<div class="faq">
				<h4>What currency is your pricing listed in?</h4>
				<p>Our prices are listed in US Dollars.</p>
			</div>

		</div>

		<div class="col-xs-12 col-sm-6">

			<div class="faq">
				<h4>Do you offer a trial?</h4>
				<p>We don't offer a trial but we do have a <strong>30 Day Money Back Guarantee</strong> so you can try AffiliateWP risk-free on your own website.</p>
			</div>

			<div class="faq">
				<h4>Do I need to renew my license?</h4>
				<p>Your license key is valid for one year from the purchase date. You need an active license key for continued access to automatic updates and support.</p>
			</div>

			<div class="faq">
				<h4>Can I cancel my subscription?</h4>
				<p>Yes, your subscription for a Personal, Plus or Professional license can be cancelled at anytime from your account page. You will retain access to support and updates until your license key expires, one year from the purchase date.</p>
			</div>

			<div class="faq">
				<h4>Can I upgrade my license?</h4>
				<p>Yes, you can easily upgrade your license from your <a href="<?php echo site_url( 'account' ); ?>" title="Account" >account</a> page.</p>
			</div>

			<div class="faq">
				<h4>I don't want a subscription</h4>

				<p>The Ultimate license is a one-time payment with no subscription. Personal, Plus and Professional license subscriptions can be cancelled at anytime after purchase. Once cancelled, your license key will not renew automatically and will expire on the expiration date. Once expired, you will no longer receive automatic updates or have access to support. You may manually renew your license at any time to reactivate your subscription.</p>
			</div>

			<div class="faq">
				<h4>Will AffiliateWP work on WordPress.com?</h4>
				<p>No, AffiliateWP will not work on WordPress.com. It only works on self-hosted WordPress installs.</p>
			</div>

			<div class="faq">
				<h4>I have other pre-sale questions, can you help?</h4>
				<p>Yes! You can ask us any question through our <a title="Support" href="<?php echo site_url( 'support' ); ?>">support page</a>.</p>
			</div>

		</div>

	</div>

	</div>
</section>

<?php
/**
 * Call to action
 */
?>

<section class="tweets container highlight pv-xs-2 pv-lg-8">
    <div class="wrapper wide center-xs">
		<?php echo affwp_theme_tweet_slider(); ?>


    </div>
</section>


<section class="container pv-xs-2 pv-lg-4">

<div class="row center-xs">
	<div class="col-xs-12 col-sm-8">

		<a href="#pricing" class="scroll button button-large">Ready to increase sales?</a>
	</div>
</div>
</section>

<?php get_footer(); ?>
