<?php
/**
 * Template Name: Product
 */

get_header(); ?>

<?php themedd_page_header( array( 'title' => 'Take a closer look at AffiliateWP', 'subtitle' => 'Explore AffiliateWP’s core features, supported integrations, and view screenshots of the entire plugin.' ) ); ?>

<section class="container highlight add-ons pv-xs-4">
	<div class="container wrapper">
		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-4 grid-item">
				<div class="grid-item-inner">
					<?php if ( themedd_post_thumbnail() ) : ?>
					<div class="grid-item-image">
						<?php themedd_post_thumbnail(); ?>
					</div>
					<?php endif; ?>

					<div>
						<h3>
							<a href="<?php echo site_url( '/features/' ); ?>">Features</a>
						</h3>

						<p>AffiliateWP provides all the features you need to get your affiliate program up and running within minutes. Configuring AffiliateWP is quick, easy, and hassle-free.</p>
					</div>

					<footer>
                        <a href="<?php echo site_url( 'features' ); ?>">View features</a>
                    </footer>

				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 grid-item">
				<div class="grid-item-inner">
					<?php if ( themedd_post_thumbnail() ) : ?>
					<div class="grid-item-image">
						<?php themedd_post_thumbnail(); ?>
					</div>
					<?php endif; ?>

					<div>
						<h3>
							<a href="<?php echo site_url( '/integrations/' ); ?>">Integrations</a>
						</h3>

						<p>Seamless integration with your favorite WordPress plugin is only one click away. Easily set up your preferred eCommerce, membership, form or invoice plugin.</p>
					</div>

					<footer>
                        <a href="<?php echo site_url( 'integrations' ); ?>">View integrations</a>
                    </footer>

				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 grid-item">
				<div class="grid-item-inner">
					<?php if ( themedd_post_thumbnail() ) : ?>
					<div class="grid-item-image">
						<?php themedd_post_thumbnail(); ?>
					</div>
					<?php endif; ?>

					<div>
						<h3>
							<a href="<?php echo site_url( '/screenshots/' ); ?>">Screenshots</a>
						</h3>

						<p>Take a look under the hood at AffiliateWP’s beautiful integration with WordPress. Check out the admin settings, the Affiliate Area, and more.</p>
					</div>

					<footer>
                        <a href="<?php echo site_url( 'screenshots' ); ?>">View screenshots</a>
                    </footer>

				</div>
			</div>



		</div>
	</div>
</section>

<?php get_footer();
