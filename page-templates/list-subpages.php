<?php
/**
 * Template Name: List - Subpages
 */

get_header();

$args = array(
	'parent' => get_the_ID(),
	'sort_column' => 'menu_order',
	'child_of' => get_the_ID()
);

if ( current_user_can( 'manage_options' ) ) {
	$args['post_status'] = array( 'pending', 'draft', 'future', 'publish' );
}

// get the child pages of the current page
$child_pages = get_pages( $args );

?>

<header class="page-header<?php echo themedd_page_header_classes(); ?>">
	<h1 class="page-title"><?php echo get_the_title( get_the_ID() ); ?></h1>
</header>


	<div class="wrapper <?php echo apply_filters( 'themedd_list_subpages_wrapper_class', '' ); ?>">
	    <div class="content-area">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'template-parts/content', 'page' );

				endwhile;
			?>

			<?php if ( $child_pages ) : ?>

				<?php
                    $count = 0;

                foreach ( $child_pages as $page ) :

				$page_id   = $page->ID;
				$title     = $page->post_title;
				$excerpt   = $page->post_excerpt;
				$permalink = get_permalink( $page_id );
				$image     = get_the_post_thumbnail ( $page_id );
                $count++;

                $classes = array();
                if ( $count % 2 != 0 ) {
                    $classes[] = 'odd';
                } else {
					$classes[] = 'even';
				}

                $classes = ' ' . implode( ' ', $classes );
				?>


                <section class="container pv-xs-2 pv-md-4<?php echo $classes; ?>">

                        <div class="row middle-xs">

                            <?php if ( $image ) : ?>
                            <div class="col-xs-12 col-md-8 hidden-xs hidden-sm col-image">
                                <a href="<?php echo $permalink; ?>"><?php echo $image; ?></a>
                            </div>
                            <?php endif; ?>

                            <div class="col-xs-12 col-md-4">

                                <?php if ( class_exists( 'MultiPostThumbnails' ) ) :
                                    echo '<div class="mb-xs-1"><a href="' . $permalink . '">';
                                    MultiPostThumbnails::the_post_thumbnail( get_post_type(), 'feature-icon', $page_id );
                                    echo '</a></div>';

									else :
										do_action( 'affwp_feature_icon', $permalink );
                                endif; ?>

                                <h2><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h2>

                                <?php if ( $excerpt ) : ?>
    							<p><?php echo $excerpt; ?></p>
    							<?php endif; ?>

                                <footer>
        							<a href="<?php echo $permalink; ?>">Learn more</a>
        						</footer>

                            </div>

                        </div>

                </section>

	            <?php endforeach; ?>

			<?php endif; ?>

		</div>
	</div>

<?php
get_footer();
