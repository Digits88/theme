<?php
/**
 * Integrations page
 */
get_header(); ?>

<?php
themedd_page_header(
	array(
		'title'    => 'One-click integration with your favorite WordPress plugins',
		'subtitle' => 'AffiliateWP integrates beautifully with popular eCommerce, membership, form, and invoice plugins for WordPress.',
		'classes'  => array( 'center-xs' )
	)
);
?>

<?php if ( have_posts() ) : ?>
<section class="container highlight pv-xs-2 pv-sm-3 pv-lg-4">

	<?php

	$terms = get_terms( 'type', array(
	    'hide_empty' => true,
	) );

	?>

	<div class="wrapper wide integration-filter center-xs">
	<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
		<a class="button small" href="#" data-filter="all">All</a>
		<?php foreach ( $terms as $term ) : ?>
		<a class="button small" href="#" data-filter=".type-<?php echo $term->slug; ?>"><?php echo $term->name; ?></a>
		<?php endforeach; ?>
	<?php endif; ?>
	</div>

	<div class="wrapper wide mb-xs-2 mb-lg-4">
		<div class="integration-grid grid row has-overlay">
			<?php while ( have_posts() ) : the_post();
			global $post;
			?>

			<div data-order="<?php echo $post->menu_order; ?>" <?php post_class( array( 'mix', 'col-xs-12', 'col-md-6', 'col-lg-4', 'grid-item', 'mb-xs-2', 'mb-sm-0', $post->post_name ) ); ?>>

				<div class="grid-item-inner">

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="grid-item-image">
							<?php themedd_post_thumbnail(); ?>
						</div>
					<?php else : ?>
						<div class="grid-item-image">
							<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
								<img src="<?php echo get_stylesheet_directory_uri() . '/images/placeholder-integration.png'; ?>" />
							</a>
						</div>
					<?php endif; ?>

					<div class="overlay">
						<a href="<?php the_permalink(); ?>">

							<span class="integration-title"><?php the_title(); ?></span>

							<?php

							$terms = get_the_terms( get_the_ID(), 'type' );

							if ( ! empty( $terms ) ) :
								$term = array_shift( $terms );
								$term_name = $term->name;
								$term_slug = $term->slug;
							?>
							<span class="integration-type"><?php echo $term_name; ?> integration</span>

							<?php endif; ?>

							<footer><span>Learn more</span></footer>
						</a>
					</div>

				</div>
			</div>

			<?php endwhile; ?>
		</div>

    </div>

	<?php echo affwp_theme_integration_notice(); ?>

</section>

<?php endif; ?>

<?php get_footer(); ?>
