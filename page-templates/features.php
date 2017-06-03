<?php
/**
 * Template Name: Features
 */

get_header(); ?>

<?php
themedd_page_header(
	array(
		'title'    => 'Packed full of features',
		'subtitle' => 'Yes, <em>all</em> of these features are included in AffiliateWP!',
		'classes'  => array( 'center-xs' )
	)
);
?>

<div class="wrapper">
	<section class="container features">
		<?php affwp_theme_features_html( array( 'columns' => 3 ) ); ?>
	</section>
</div>


<?php
get_footer();
