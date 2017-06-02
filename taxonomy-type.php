<?php
/**
 * Integration type
 */

get_header(); ?>

<?php themedd_page_header( array( 'title' => single_cat_title( '', false ), 'subtitle' => term_description() ) ); ?>

<?php if ( have_posts() ) : ?>

<section class="container-fluid highlight pv-xs-2 pv-sm-3 pv-lg-1">

	<div class="wrapper wide mb-xs-2 mb-lg-4">
		<div class="integration-grid grid row has-overlay">
			<?php while ( have_posts() ) : the_post();
			global $post;
			?>

			<div data-order="<?php echo $post->menu_order;?>" <?php post_class( array( 'mix', 'col-xs-12', 'col-md-6', 'col-lg-4', 'grid-item', 'mb-xs-2', 'mb-sm-0', $post->post_name ) ); ?>>

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

 <?php
 get_footer();
