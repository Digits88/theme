<?php
/**
 * Integrations page
 */
get_header(); ?>

<?php themedd_post_header( array( 'title' => 'One-click integration with your favorite WordPress plugins', 'subtitle' => 'AffiliateWP integrates beautifully with popular eCommerce, membership, form, and invoice plugins for WordPress.' ) ); ?>

<?php if ( have_posts() ) : ?>
<section class="container-fluid highlight pv-xs-2 pv-sm-3 pv-lg-4">
    <div class="wrapper wide container-fluid mb-xs-2 mb-lg-4">
		<div class="grid row has-overlay">
			<?php while ( have_posts() ) : the_post();
			global $post;
			?>

			<div <?php post_class( array( 'col-xs-12', 'col-md-6', 'col-lg-4', 'grid-item', 'mb-xs-2', 'mb-sm-0', $post->post_name ) ); ?>>

				<div class="grid-item-inner">

					<?php if ( themedd_post_thumbnail() ) : ?>
					<div class="grid-item-image">
						<?php themedd_post_thumbnail(); ?>
					</div>
					<?php endif; ?>

					<div class="overlay">
						<a href="<?php the_permalink();?>">
							<?php if ( the_excerpt() ) : ?>
							<p><?php echo the_excerpt(); ?></p>
							<?php endif; ?>

							<footer><span>Learn more</span></footer>
						</a>
					</div>

				</div>
			</div>

			<?php endwhile; ?>
		</div>



    </div>

	<div class="wrapper">
		<div class="row center-xs aligncenter">
			<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
				<p>Is your eCommerce, membership or form plugin not listed? We may still support it through our generic referral tracking script. <a href="http://docs.affiliatewp.com/article/66-generic-referral-tracking-script" target="_blank">Learn more &rarr;</a></p>
			</div>
		</div>
	</div>

</section>
<?php endif; ?>

<?php get_footer(); ?>
