<?php
/**
 * Template Name: Add-ons
 */

get_header(); ?>

<?php themedd_page_header( array( 'title' => 'Make AffiliateWP more powerful with add-ons', 'subtitle' => 'Extend AffiliateWP with pro, free and 3rd-party add-ons.' ) ); ?>

<section class="container highlight add-ons pv-xs-1">
	<div class="wrapper">

		<div class="row">

			<?php
				$categories = get_terms( 'download_category', array(
				    'orderby'    => 'name',
					'order'      => 'DESC',
				    'hide_empty' => 0,
					'exclude'    => array( 42, 34 )
				) );
			?>

			<?php if ( $categories ) : ?>

				<?php foreach ( $categories as $category ) : ?>

					<?php if ( themedd_post_thumbnail() ) : ?>
					<div class="grid-item-image">
						<?php themedd_post_thumbnail(); ?>
					</div>
					<?php endif; ?>

					<div class="col-xs-12 col-sm-6 col-md-4 grid-item">

						<div class="grid-item-inner">

							<?php if ( themedd_post_thumbnail() ) : ?>
							<div class="grid-item-image">
								<?php themedd_post_thumbnail(); ?>
							</div>
							<?php endif; ?>

							<div>
								<h3>
									<a href="<?php echo get_the_permalink() . $category->slug; ?>">
										<?php echo $category->name; ?>
									</a>
								</h3>

								<p><?php echo $category->description; ?></p>
							</div>

							<footer>
								<a href="<?php echo get_the_permalink() . $category->slug; ?>">View add-ons</a>
							</footer>

						</div>

					</div>

				<?php endforeach; ?>

			<?php endif; ?>

		</div>

	</div>
</section>

<?php get_footer();
