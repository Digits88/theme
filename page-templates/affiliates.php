<?php
/**
 * Template Name: Affiliates
 */

get_header(); ?>

<?php

/**
 * User is an affiliate, show the affiliate area
 */
if ( function_exists( 'affwp_is_affiliate' ) && affwp_is_affiliate() ) : ?>

<?php

	if ( is_user_logged_in() ) {
		$subtitle = sprintf( __( 'Welcome, %s (%s)' , 'themedd' ), wp_get_current_user()->display_name, '<a href="' . wp_logout_url( '/affiliates/login/' ) . '">Log out?</a>' );
	} else {
		$subtitle = __( 'Come on in!', 'themedd' );
	}

	themedd_page_header(
		array(
			'title'    => 'Affiliate Area',
			'subtitle' => $subtitle
		)
	);

?>

<section class="container">
    <div class="wrapper">
		<?php affiliate_wp()->templates->get_template_part( 'dashboard' ); ?>
	</div>
</section>

<?php else : ?>

<?php
/**
 * Show our affiliates information page
 */
?>

<div class="affiliates-header animating center-xs">
	<header class="page-header">
		<h1 class="page-title">
			<span class="entry-title-primary">Refer customers and earn cash</span>
			<span class="subtitle">Use and love AffiliateWP? Become an affiliate and earn 20% commission on each successful sale you refer!</span>
		</h1>
	</header>
</div>


<?php
/**
 * Features
 */
?>
<section class="container pv-xs-2 pv-lg-4 rationale">
    <div class="wrapper">

        <div class="row center-xs">
            <div class="col-xs-12 col-sm-4">

                <img class="mb-xs-1" width="96" height="96" src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/original/affiliates-refer-and-earn.svg'; ?>" />

                <h2>Refer and earn</h2>
                <p class="mb-lg-0">Refer customers to AffiliateWP and earn 20% commission on each successful sale. Enjoy uncapped, unlimited commissions!</p>

            </div>

            <div class="col-xs-12 col-sm-4">

                <img class="mb-xs-1" width="96" height="96" src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/original/affiliates-banners.svg'; ?>" />
                <h2>High quality banners</h2>
                <p class="mb-lg-0">Get up and running in minutes with our ready-to-go affiliate banners. Place these banners on your site and start promoting AffiliateWP instantly.</p>

            </div>

            <div class="col-xs-12 col-sm-4">

            <img class="mb-xs-1" width="96" height="96" src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/original/affiliates-referral-statistics.svg'; ?>" />
                <h2>Detailed referral statistics</h2>
                <p class="mb-lg-0">View accurate performance data in your private affiliate area. See up-to-date information for visits, referrals, conversions, campaigns and payouts.</p>
            </div>

        </div>


    </div>
</section>

<section class="container highlight affiliate-program-highlights pv-xs-2 pv-xs-4 mb-xs-2 mb-sm-4">
    <div class="wrapper">
		<div class="row">

			<div class="col-xs-12 col-lg-7 mb-xs-2 mb-lg-0">
				<a class="enlarge" href="<?php echo get_stylesheet_directory_uri() . '/images/affiliate-program-affiliate-area.png'; ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/images/affiliate-program-affiliate-area.png'; ?>" alt="The affiliate area" /></a>
			</div>

			<div class="col-xs-12 col-lg-5">

				<h3>Affiliate program highlights</h3>

				<ul>
					<li><p>Earn 20% commission on every new sale you refer</p></li>
					<li><p>Access a library of banners and logos to use on your site</p></li>
					<li><p>View up-to-date visit, referral and payout data in your affiliate area</p></li>
					<li><p>Tracking cookie stored for 30 days after the first visit to maximize earning potential</p></li>
					<li><p>Get affiliate support with our dedicated affiliate manager</p></li>
					<li><p>Enjoy unlimited commissions</p></li>
					<li><p>Payouts processed monthly via PayPal (minimum amount $50.00)</p></li>
				</ul>

			</div>

		</div>

	</div>

	<div class="wrapper center-xs view-agreement">
		<p>View our <a href="<?php echo site_url( '/affiliate-agreement/' ); ?>" target="_blank">affiliate agreement</a> for more information</p>
	</div>

</section>


<section class="container mb-xs-4">
    <div class="wrapper slim center-xs">
		<a href="<?php echo site_url( '/affiliates/join/' ); ?>" class="button large mb-xs-1">Become an affiliate</a>

		<p>Already an affiliate? <a href="<?php echo site_url( '/affiliates/login' ); ?>">Log in now</a></p>

	</div>
</section>

<?php endif; ?>


<?php
get_footer();
