<?php

/**
 * Lightboxes
 */
function themedd_load_popup() {

	if ( themedd_enable_popup() ) :
	?>
	<script type="text/javascript">

		jQuery(document).ready(function($) {

		//inline
		$('.popup-content').magnificPopup({
			type: 'inline',
			fixedContentPos: true,
			fixedBgPos: true,
			overflowY: 'scroll',
			closeBtnInside: true,
			preloader: false,
			callbacks: {
				beforeOpen: function() {
				this.st.mainClass = this.st.el.attr('data-effect');
				}
			},
			midClick: true,
			removalDelay: 300
        });

		});
	</script>

<?php endif;
}
add_action( 'wp_footer', 'themedd_load_popup', 100 );



/**
 * Posts that should have the lightbox code included
 *
 * @since 1.0.0
 */
function themedd_enable_popup( $post_id = 0 ) {

	$lightbox = false;

	$posts = apply_filters( 'themedd_lightbox_posts',
		array()
	);

	$changelog = get_post_meta( get_the_ID(), '_edd_sl_changelog', true );

	if ( in_array( $post_id, $posts ) || $changelog ) {
		$lightbox = true;
	}

	return apply_filters( 'themedd_enable_popup', $lightbox );
}
