<?php
/**
 * Download category
 */

get_header(); ?>

<?php themedd_page_header( array( 'title' => single_cat_title( '', false ), 'subtitle' => term_description( '', 'download_category' ) ) ); ?>

<?php if ( have_posts() ) : ?>
<section class="container-fluid highlight pv-xs-2 pv-sm-3 pv-lg-1">
    <div class="wrapper add-ons">
		<div class="grid row">
			<?php while ( have_posts() ) : the_post(); ?>

			<div <?php post_class( array( 'col-xs-12', 'col-sm-6', 'col-md-4', 'grid-item', 'mb-xs-2', 'mb-sm-0' ) ); ?>>

				<div class="grid-item-inner">

					<?php if ( has_post_thumbnail() ) : ?>
					<div class="grid-item-image">
						<?php themedd_post_thumbnail(); ?>
					</div>
					<?php endif; ?>

					<h3 class="grid-item-title">
						<a href="<?php the_permalink( $id );?>"><?php echo get_the_title( $id ); ?></a>
					</h3>

					<div class="grid-item-content">

						<?php $excerpt_length = apply_filters( 'excerpt_length', 30 ); ?>

						<div itemprop="description" class="edd_download_excerpt">
							<?php echo apply_filters( 'edd_downloads_excerpt', wp_trim_words( get_post_field( 'post_excerpt', $id ), $excerpt_length ) ); ?>
						</div>

					</div>

					<footer>
						<a href="<?php the_permalink( $id ); ?>">Learn more</a>
					</footer>

				</div>

			</div>

			<?php endwhile; ?>
		</div>

    </div>

</section>
<?php endif; ?>


 <?php
 get_footer();
