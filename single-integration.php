<?php
/**
 * The template for single integrations
 *
 */

get_header();

$integration_name = get_the_title( get_the_ID() );

?>

<?php
/**
 * Main content
 */
?>
<section class="container-fluid pv-xs-2 pv-lg-4 highlight">
    <div class="wrapper">

    	<div class="content-area">
            <h1 class="page-title"><?php echo $integration_name; ?></h1>

    		<?php
    			// Start the Loop.
    			while ( have_posts() ) : the_post(); ?>

                <?php
                /**
                 * The template used for displaying page content
                 */
                ?>

            	<div class="entry-content">

            		<?php do_action( 'themedd_entry_content_start' ); ?>

                    <div class="row">
                        <div class="col-xs-12 col-lg-6">
                            <?php the_content(); ?>
                        </div>

                        <div class="col-xs-12 col-lg-6">
                            <?php themedd_post_thumbnail(); ?>
                        </div>

                    </div>

            		<?php
            			wp_link_pages( array(
            				'before' => '<div class="page-links">' . __( 'Pages:', 'themedd' ),
            				'after'  => '</div>',
            			) );
            		?>

            		<?php do_action( 'themedd_entry_content_end' ); ?>

            	</div>

    			<?php endwhile;
    		?>

    	</div>

    </div>
</section>

<?php
$terms = get_the_terms( get_the_ID(), 'feature' );

if ( $terms && ! is_wp_error( $terms ) ) : ?>
<section class="container-fluid pv-xs-2 pv-lg-4">
    <div class="wrapper">
        <h3 class="aligncenter mb-lg-4">Integration-specific features</h3>

		<div class="row start-xs">
		<?php foreach ( $terms as $term ) :

			?>
			<div class="col-xs-12 col-sm-6 col-lg-4 mb-lg-2">

				<svg width="48px" height="48px">
					<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svgs/svg-defs.svg#icon-feature-' . $term->slug; ?>"></use>
				</svg>

				<h3 class="grid-item-title"><?php echo $term->name; ?></h3>
				<p><?php echo $term->description; ?></p>

			</div>
		<?php endforeach; ?>
		</div>

    </div>
</section>
<?php endif; ?>


<?php
/**
 * Related Pro Add-ons
 */
$args = array(
    'posts_per_page' => -1,
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key' => '_affwp_integration',
            'value' => get_the_ID(),
            'compare' => '='
        ),
        array(
            'key' => '_affwp_integration_all',
            'value' => '1',
            'compare' => '='
        ),
    ),
    'post_type' => 'download',
    'tax_query' => array(
		array(
			'taxonomy' => 'download_category',
			'field'    => 'slug',
			'terms'    => 'pro',
		),
	),
);

    $pro_add_ons    = get_posts( $args );
    $pro_add_on_ids = wp_list_pluck( $pro_add_ons, 'ID' );

?>

<?php if ( $pro_add_ons ) : ?>
<section class="highlight pv-xs-8 container-fluid">
    <div class="wrapper">

        <div class="center-xs mb-xs-4 aligncenter">
            <h1>Supercharge your affiliate program with add-ons</h1>
        </div>

        <div class="mb-xs-8">
            <div class="center-xs aligncenter">
                <h4 class="mb-xs-0 aligncenter">Use these Pro add-ons with your <strong><?php echo $integration_name; ?></strong>-powered site</h4>
                <p>(Available with the Professional and Ultimate license)</p>
            </div>
        	<div class="slider">

                <?php foreach ( $pro_add_on_ids as $id ) : ?>
                    <div class="slick-item">
                        <div class="slick-inner">

                            <?php if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( $id ) ) : ?>
                                <div class="edd_download_image">
                                <?php echo get_the_post_thumbnail( $id, 'large' ); ?>
                                </div>
                            <?php endif; ?>
                            <h3 class="slick-title">
                                <?php echo get_the_title( $id ); ?>
                            </h3>

                            <div class="slick-item-content">

                                <?php $excerpt_length = apply_filters( 'excerpt_length', 30 ); ?>

                                <div itemprop="description" class="edd_download_excerpt">
                                    <?php echo apply_filters( 'edd_downloads_excerpt', wp_trim_words( get_post_field( 'post_excerpt', $id ), $excerpt_length ) ); ?>
                                </div>

                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <?php
        /**
         * Related Free Add-ons
         */

         $args = array(
             'posts_per_page' => -1,
             'meta_query' => array(
                 'relation' => 'OR',
                 array(
                     'key' => '_affwp_integration',
                     'value' => get_the_ID(),
                     'compare' => '='
                 ),
                 array(
                     'key' => '_affwp_integration_all',
                     'value' => '1',
                     'compare' => '='
                 ),
             ),
             'post_type' => 'download',
             'tax_query' => array(
         		array(
         			'taxonomy' => 'download_category',
         			'field'    => 'slug',
         			'terms'    => 'official-free',
         		),
         	),
         );


            $free_add_ons    = get_posts( $args );
            $free_add_on_ids = wp_list_pluck( $free_add_ons, 'ID' );
        //    $add_on_ids = implode( ', ', $add_on_ids );

        ?>

        <?php if ( $free_add_ons ) : ?>
        <div class="center-xs aligncenter">
            <h4 class="mb-xs-0">Use these Official free add-ons with your <strong><?php echo $integration_name; ?></strong>-powered site</h4>
            <p>(Available for all license holders, woohoo!)</p>
        </div>
        <div class="slider">

            <?php foreach ( $free_add_on_ids as $id ) : ?>
                <div class="slick-item">
                    <div class="slick-inner">

                        <?php if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( $id ) ) : ?>
                            <div class="edd_download_image">
                            <?php echo get_the_post_thumbnail( $id, 'large' ); ?>
                            </div>
                        <?php endif; ?>
                        <h3 class="slick-title">
                            <?php echo get_the_title( $id ); ?>
                        </h3>

                        <div class="slick-item-content">

                            <?php $excerpt_length = apply_filters( 'excerpt_length', 30 ); ?>

                            <div itemprop="description" class="edd_download_excerpt">
                                <?php echo apply_filters( 'edd_downloads_excerpt', wp_trim_words( get_post_field( 'post_excerpt', $id ), $excerpt_length ) ); ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <?php endif; ?>

    </div>
</section>
<?php endif; ?>







<?php

function slider_content() {
    ?>

    <div class="slick-item">
        <div class="slick-inner">
            <div class="slick-item-content">
                <div class="edd_download_image">
		<a title="Custom Affiliate Slugs" href="http://affwp.rcp.dev/downloads/custom-affiliate-slugs/" class="has-image" tabindex="0">
			<img width="566" height="283" sizes="(max-width: 566px) 100vw, 566px" srcset="http://affwp.rcp.dev/wp-content/uploads/sites/8/2016/05/add-on-custom-affiliate-slugs-566x283.png 566w, http://affwp.rcp.dev/wp-content/uploads/sites/8/2016/05/add-on-custom-affiliate-slugs-300x150.png 300w, http://affwp.rcp.dev/wp-content/uploads/sites/8/2016/05/add-on-custom-affiliate-slugs-768x384.png 768w, http://affwp.rcp.dev/wp-content/uploads/sites/8/2016/05/add-on-custom-affiliate-slugs-720x360.png 720w, http://affwp.rcp.dev/wp-content/uploads/sites/8/2016/05/add-on-custom-affiliate-slugs.png 880w" alt="add-on-custom-affiliate-slugs" class="attachment-themedd-post-thumbnail size-themedd-post-thumbnail wp-post-image" src="http://affwp.rcp.dev/wp-content/uploads/sites/8/2016/05/add-on-custom-affiliate-slugs-566x283.png">		</a>
	</div>

                <h3 class="slick-title"><a href="http://rcp.dev/tour/screenshots/">Screenshots</a></h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

            </div>

            <footer>
                <a href="http://rcp.dev/tour/screenshots/">Learn more</a>
            </footer>
        </div>
    </div>
    <?php
}
?>

<?php

function slider_content2() {
    ?>

    <div class="slick-item">
        <div class="slick-inner">
            <div class="slick-item-content">
                <h3 class="slick-title"><a href="http://rcp.dev/tour/screenshots/">Screenshots</a></h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam.</p>

            </div>

            <footer>
                <a href="http://rcp.dev/tour/screenshots/">Learn more</a>
            </footer>
        </div>
    </div>
    <?php
}
?>









<script type="text/javascript">


    jQuery('.slider').on('setPosition', function () {

        jQuery(this).find('.slick-slide').height('auto');

        var slickTrack = jQuery(this).find('.slick-track');
        var slickTrackHeight = jQuery(slickTrack).height();

        jQuery(this).find('.slick-slide').css('height', slickTrackHeight + 'px');

    });

  jQuery(document).on('ready', function() {

    jQuery(".slider").slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 3,
		arrows: false,
		customPaging : function(slider, i) {
			return '';
		},
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
            }
          },
          {
            breakpoint: 680,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
    });

  });

</script>

<?php
/**
 * Related posts
 */

$args = array(
 	'posts_per_page'   => -1,
    'meta_query' => array(
        array(
          'key' => '_affwp_integrations',
          'value' => get_the_ID(),
          'compare' => '='
          )
      ),
 	'post_type' => 'post',
 );

$posts = get_posts( $args );

?>

<?php if ( $posts ) : ?>
<section class="container-fluid highlight pv-xs-2 pv-lg-4">
    <div class="wrapper">
        <div class="row center-xs">
            <div class="col-xs-12 col-sm-8">
				<h2>Latest (integration name) news</h2>

                <?php foreach ( $posts as $post ) : ?>

                    <?php echo $post->post_title; ?>

                <?php endforeach; ?>


            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
get_footer();