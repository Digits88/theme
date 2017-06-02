<?php
/**
 * Template Name: Features
 */

get_header(); ?>

<?php themedd_page_header( array( 'title' => 'Packed full of features', 'subtitle' => 'Yes, <em>all</em> of these features are included in AffiliateWP!' ) ); ?>

<section class="container-fluid features">
	<div class="wrapper">
		<?php affwp_theme_features_html( array( 'columns' => 3 ) ); ?>
	</div>
</section>



<?php
get_footer();
