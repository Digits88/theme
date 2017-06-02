<?php
/**
 * Index
 */
get_header();

if ( affwp_theme_is_blog_page() ) : ?>

<?php

$args = array(
	'posts_per_page'      => 1,
	'post__in'            => get_option( 'sticky_posts' ),
	'ignore_sticky_posts' => 1
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>

	<?php while ( $query->have_posts() ) : $query->the_post(); ?>

	<div class="hero <?php echo affwp_theme_blog_hero_classes( get_the_ID() ); ?>">

		<header class="page-header col-xs-12 blog-featured pv-xs-4">
			<a href="<?php echo the_permalink(); ?>" title="Read now" class="read-now">
				<div class="wrapper">
					<span class="featured-article">Featured article</span>

					<h1 class="<?php echo get_post_type(); ?>-title">
						<?php the_title(); ?>
					</h1>

					<?php
						if ( class_exists( 'MultiPostThumbnails' ) && MultiPostThumbnails::get_the_post_thumbnail( get_post_type(), 'feature-icon', get_the_ID() ) ) {
							$image = MultiPostThumbnails::get_the_post_thumbnail( get_post_type(), 'feature-icon', get_the_ID() );
						} elseif ( apply_filters( 'affwp_theme_post_animation', false, get_the_ID() ) ) {
							$image = affwp_theme_featured_icon_animation( get_the_ID() );
						} elseif ( has_post_thumbnail() ) {
							$image = get_the_post_thumbnail( get_the_ID(), 'affwp-post-thumbnail', array( 'alt' => get_the_title() ) );
						} else {
							$image = '';
						}

					if ( $image ) : ?>

					<?php echo $image; ?>

					<?php endif; ?>

					<span class="button large outline white">Read now</span>
				</div>
			</a>
		</header>

	</div>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>

	<?php endif; ?>

<?php endif; ?>

<?php if ( have_posts() ) : ?>

<section class="container-fluid highlight pv-xs-2 pv-sm-3 pv-lg-1">
    <div class="wrapper mb-xs-2 mb-lg-4">
		<div class="grid row">
			<?php while ( have_posts() ) : the_post();
			global $post;
			?>

			<div <?php post_class( array( 'col-xs-12', 'col-sm-6', 'col-md-4', 'grid-item', 'mb-xs-2', 'mb-sm-0', $post->post_name ) ); ?>>

				<div class="grid-item-inner">

					<?php
						$class = '';

						if ( class_exists( 'MultiPostThumbnails' ) && MultiPostThumbnails::get_the_post_thumbnail( get_post_type(), 'feature-icon', get_the_ID() ) ) {
							$image = MultiPostThumbnails::get_the_post_thumbnail( get_post_type(), 'feature-icon', get_the_ID() );
							$class = ' has-featured-icon';
						} elseif ( apply_filters( 'affwp_theme_post_animation', false ) ) {
							$image = affwp_theme_featured_icon_animation( get_the_ID() );
							$class = ' has-featured-icon';
						} elseif ( has_post_thumbnail() ) {
							$image = get_the_post_thumbnail( get_the_ID(), 'affwp-post-thumbnail', array( 'alt' => get_the_title() ) );
						} else {
							$image = '';
						}

					if ( $image ) : ?>

					<div class="grid-item-image<?php echo $class; ?>">
						<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
							<?php echo $image; ?>
						</a>
					</div>
					<?php endif; ?>

					<?php
						if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
							themedd_posted_on( false );
						}
					?>

					<h3 class="grid-item-title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>

					<div class="grid-item-content">
						<?php if ( the_excerpt() ) : ?>
						<p><?php echo the_excerpt(); ?></p>
						<?php endif; ?>
					</div>

					<footer>
						<a href="<?php the_permalink(); ?>">Read more</a>
					</footer>

				</div>
			</div>

			<?php endwhile; ?>

		</div>

		<?php themedd_paging_nav(); ?>

    </div>

</section>
<?php endif; ?>

<section class="container-fluid">
	<?php echo affwp_theme_get_signup(); ?>
</section>
<?php get_footer(); ?>
