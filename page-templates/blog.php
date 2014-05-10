<?php
/*
Template Name: Blog
*/

get_header(); 

?>

<header class="entry-header">

<?php
	/**
	 * Displays the most recent post
	 */
	$args = array(
		'posts_per_page' => 1,
	);

	$temp = $wp_query; // assign original query to temp variable for later use  
	$wp_query = null;
	$wp_query = new WP_Query( $args ); 

	if ( have_posts() ) : ?>
		
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			
			<?php
				global $more;
				$more = 0;
			?>
			<?php affwp_post_thumbnail(); ?>
			<?php affwp_posted_on(); ?>
			<h1>
            	<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        	</h1>
        	
        	<?php 
		 		$excerpt = get_the_excerpt();
		 		//echo '<h2>' . $excerpt . '</h2>';

		 		if ( $excerpt )
					echo '<h2>' . $excerpt . '</h2>';
			?>	

			

			<a href="<?php the_permalink(); ?>" class="button large">Read now</a>
			

		<?php endwhile; ?>

	<?php endif; 

	$wp_query = $temp; //reset back to original query 
?>




	

</header>

<section class="primary">
	<div class="wrapper">

	
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

		<?php endwhile;  wp_reset_postdata(); // end of the loop. ?>
		
		<?php
			/**
			 * Displays the most recent post
			 */
			$args = array(
				'posts_per_page' => 5,
				'offset'		=> 1
			);

			$temp = $wp_query; // assign original query to temp variable for later use  
			$wp_query = null;
			$wp_query = new WP_Query( $args ); 
		
			if ( have_posts() ) : ?>
				
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php
						global $more;
						$more = 0;
					?>
					<?php affwp_post_thumbnail(); ?>
					<?php affwp_posted_on(); ?>
					<h2>
		            	<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		        	</h2>
		        	
		        	<?php 
				 		$excerpt = $post->post_excerpt ? the_excerpt() : '';
				 		echo $excerpt;
					?>	

					<a href="<?php the_permalink(); ?>" class="button">Read now</a>
					</article>
				<?php endwhile; ?>

			<?php endif; 

			$wp_query = $temp; //reset back to original query 
		?>

	 </div>
</section>


<?php get_sidebar(); ?>
<?php get_footer(); ?>