<?php
/**
 * Template Name: Grid - Subpages
 */

get_header();

// get the child pages of the current page

$args = array(
	'parent' => get_the_ID(),
	'sort_column' => 'menu_order',
	'child_of' => get_the_ID()
);

if ( current_user_can( 'manage_options' ) ) {
	$args['post_status'] = array( 'pending', 'draft', 'future', 'publish' );
}

$child_pages = get_pages( $args );

?>

<header class="center-xs page-header<?php echo themedd_page_header_classes(); ?>">
	<h1 class="page-title"><?php echo get_the_title( get_the_ID() ); ?></h1>
</header>


	<div class="wrapper">
	    <div class="content-area">

			<section class="container">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'template-parts/content', 'page' );

				endwhile;
			?>
			</section>

			<?php if ( $child_pages ) : ?>
			<section class="container">
			<div class="grid row mb-xs-4">
				<?php foreach ( $child_pages as $page ) :

				$page_id   = $page->ID;
				$title     = $page->post_title;
				$excerpt   = $page->post_excerpt;
				$permalink = get_permalink( $page_id );
				$image     = get_the_post_thumbnail ( $page_id );

				?>

				<div class="col-xs-12 col-sm-6 col-md-4 grid-item">
					<div class="grid-item-inner">

						<?php if ( $image ) : ?>
						<div class="grid-item-image"><a href="<?php echo $permalink; ?>"><?php echo $image; ?></a></div>
						<?php endif; ?>

						<div class="grid-item-content">

							<?php if ( class_exists( 'MultiPostThumbnails' ) ) :

	                            if ( MultiPostThumbnails::get_the_post_thumbnail( get_post_type(), 'feature-icon', $page_id ) ) {
	                                ?>
	                                <a href="<?php echo $permalink; ?>" class="mb-xs-1">
	                                    <?php MultiPostThumbnails::the_post_thumbnail( get_post_type(), 'feature-icon', $page_id ); ?>
	                                </a>
	                            <?php
	                            }

	                        endif; ?>

							<h3 class="grid-item-title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h3>

							<?php if ( $excerpt ) : ?>
							<p><?php echo $excerpt; ?></p>
							<?php endif; ?>

						</div>

						<footer>
							<a href="<?php echo $permalink; ?>">Learn more</a>
						</footer>
					</div>
				</div>

	            <?php endforeach; ?>
		    </div>
			</section>
			<?php endif; ?>

		</div>
	</div>

<?php
get_footer();
