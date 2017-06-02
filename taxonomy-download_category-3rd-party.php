<?php
/**
 * Download category
 *
 */

get_header(); ?>

<?php

themedd_page_header(
	array(
		'title'    => single_cat_title( '', false ),
		'subtitle' => 'Free or paid add-ons created by other developers',
		'classes'  => array( 'highlight' )
	)
);

?>

<section class="container-fluid pv-xs-2 pv-sm-3 pv-lg-4">
    <div class="wrapper">
		<div class="row center-xs">
			<div class="col-xs-12 col-sm-9">
				<p class="intro mb-xs-0">
					The following add-ons are <strong>not official AffiliateWP-built add-ons</strong>, and are therefore only supported by the developers who maintain them.
					If you need support for any of these add-ons, please reach out to the developer by clicking on the relevant link below.
				</p>
			</div>
		</div>
    </div>
</section>



<section class="container-fluid">
    <div class="wrapper slim add-ons">

		<?php if ( have_posts() ) : ?>

			<ul id="third-party-add-ons">
			<?php while ( have_posts() ) : the_post();
				$url = get_post_meta( get_the_ID(), '_edd_download_meta_url', true );
			?>

			<?php if ( $url ) : ?>
				<li class="add-on">
					<div class="row middle-xs">
						<div class="col-xs-12 col-sm-9">
							<h4><?php echo get_the_title(); ?></h4>
							<p><?php echo get_the_excerpt(); ?></p>
						</div>

						<div class="col-xs-12 col-sm-3 end-xs">
							<a href="<?php echo esc_attr( $url ); ?>" target="_blank">Visit 3rd-party site &rarr;</a>
						</div>
					</div>


				</li>
			<?php endif; ?>

			<?php endwhile; ?>
			</ul>

		<?php endif; ?>

    </div>

</section>



 <?php
 get_footer();
