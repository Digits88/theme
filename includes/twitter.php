<?php
/**
 * Tweets
*/

/**
 * Get tweets from show tweets plugin
 *
 * @since 1.0.0
 */
function affwp_theme_get_tweets() {

	if ( ! function_exists( 'show_tweets' ) ) {
		return;
	}

	$args = array(
        'id'         => '458773013576417280', // collection ID
        'count'      => 16, // number of tweets to show
        'expiration' => 60*60*24*7 // how long the transient should be stored for
    );

    // make the request
    $request = show_tweets()->request_tweets( $args );
	$tweets  = show_tweets()->get_tweets();

	if ( $tweets ) {
		return $tweets;
	}

	return false;
}

/**
 * Build the tweet slider
 *
 * @since 1.0.0
 */
function affwp_theme_tweet_slider() {

    $tweets = affwp_theme_get_tweets();

    if ( $tweets ) : ?>
            <h3>What people are saying on <a href="https://twitter.com/affwp/timelines/458773013576417280" target="_blank">Twitter</a></h3>
            <div class="row center-xs mb-xs-2">

                <div class="col-xs tweet-slider-wrap">

                    <ul class="slider tweet-slider">

                        <?php foreach ( $tweets as $tweet ) :

                            $text        = $tweet->text;
                            $tweet_id    = $tweet->id;
                            $user_id     = $tweet->user->id;
                            $user_info   = affwp_tweet_get_user_info( $user_id );
                            $name        = $user_info['name'];
                            $screen_name = $user_info['screen_name'];
                            $avatar      = $user_info['avatar'];
							$avatar      = preg_replace( "/^http:/i", "https:", $avatar );
                        ?>
                            <li class="tweet">
                                <div class="avatar">
                                  <img alt="<?php echo $name; ?>" src="<?php echo $avatar; ?>">
                                </div>

                                <h3><?php echo $name; ?></h3>

                                <h4><a href="https://twitter.com/<?php echo $screen_name; ?>/status/<?php echo $tweet_id; ?>"><?php echo $screen_name; ?></a></h4>

                                <p><?php echo $text; ?></p>

                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

    <script type="text/javascript">

      jQuery(document).on('ready', function() {

        jQuery(".tweet-slider").slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
			arrows: false,
			customPaging : function(slider, i) {
	            return '';
	        },
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 2, // 2 slides below 1024
                  slidesToScroll: 2
                }
              },
              {
                breakpoint: 680,
                settings: {
                  slidesToShow: 1, // 1 slide below 480px
                  slidesToScroll: 1,
				  dots: false
                }
              }
            ]
        });

      });

    </script>

    <?php endif;

}

/**
 * Get user info
 *
 * @since 1.0.0
 */
function affwp_tweet_get_user_info( $user_id = 0 ) {

    if ( ! $user_id ) {
        return;
    }

    $users = function_exists( 'show_tweets' ) ? show_tweets()->get_users() : '';
    $user_info = array();

    if ( $users ) {
        foreach ( $users as $id => $user ) {

            if ( $user_id === $user->id ) {
                $user_info['name'] = $user->name;
                $user_info['screen_name'] = $user->screen_name;
                $user_info['avatar'] = $user->profile_image_url;
            }

        }
    }

    return $user_info;

}
