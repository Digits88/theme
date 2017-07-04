<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom fields for the download meta
 * @since 1.0.0
*/

/**
 * Add last updated icon
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_icon_last_updated() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-last-updated.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_last_updated', 'affwp_theme_download_meta_icon_last_updated' );

/**
 * Add version icon
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_icon_version() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-version.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_version', 'affwp_theme_download_meta_icon_version' );

/**
 * Add release date icon
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_icon_released() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-released.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_release_date', 'affwp_theme_download_meta_icon_released' );

/**
 * Add documentation icon
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_icon_documentation() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-documentation.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_documentation', 'affwp_theme_download_meta_icon_documentation' );

/**
 * Add changelog icon
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_icon_changelog() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-changelog.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_changelog', 'affwp_theme_download_meta_icon_changelog' );

/**
 * Downloads icon
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_icon_downloads() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-downloads.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_downloads', 'affwp_theme_download_meta_icon_downloads' );

/**
 * Active installs icon
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_icon_active_installs() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-active-installs.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_active_installs', 'affwp_theme_download_meta_icon_active_installs' );


/**
 * Add-on type
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_icon_add_on_type() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-add-on-type.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_add_on_type', 'affwp_theme_download_meta_icon_add_on_type' );


/**
 * AffiliateWP version required
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_icon_version_required() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-version-required.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_version_required', 'affwp_theme_download_meta_icon_version_required' );



/**
 * Add new fields
 *
 * @since 1.0.0
*/
function affwp_theme_download_meta_add_fields() {
	?>

	<p><strong><?php _e( 'AffiliateWP Version Required', 'themedd' ); ?></strong></p>
	<p>
		<label for="edd-download-meta-affwp-version-required" class="screen-reader-text">
			<?php _e( 'AffiliateWP Version Required', 'themedd' ); ?>
		</label>
		<input class="widefat" type="text" name="edd_download_meta_affwp_version_required" id="edd-download-meta-affwp-version-required" value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_edd_download_meta_affwp_version_required', true ) ); ?>" size="30" />
	</p>

	<p><strong><?php _e( 'Developer', 'themedd' ); ?></strong></p>
	<p>
		<label for="edd-download-meta-developer" class="screen-reader-text">
			<?php _e( 'Developer', 'themedd' ); ?>
		</label>
		<input class="widefat" type="text" name="edd_download_meta_developer" id="edd-download-meta-developer" value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_edd_download_meta_developer', true ) ); ?>" size="30" />
	</p>

	<p><strong><?php _e( 'Developer URL', 'themedd' ); ?></strong></p>
	<p>
		<label for="edd-download-meta-developer-url" class="screen-reader-text">
			<?php _e( 'Developer URL', 'themedd' ); ?>
		</label>
		<input class="widefat" type="text" name="edd_download_meta_developer_url" id="edd-download-meta-developer-url" value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_edd_download_meta_developer_url', true ) ); ?>" size="30" />
	</p>

<?php }
add_action( 'edd_download_meta_add_fields', 'affwp_theme_download_meta_add_fields' );

/**
 * Save the new fields
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_save( $fields ) {

	$new_fields = array(
		'edd_download_meta_affwp_version_required',
		'edd_download_meta_developer',
		'edd_download_meta_developer_url'
	);

	return array_merge( $fields, $new_fields );

}
add_filter( 'edd_download_meta_save', 'affwp_theme_download_meta_save' );

/**
 * Sanitize fields
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_santize( $new, $field ) {

	if ( $field == 'edd_download_meta_developer_url' ) {
	    $new = esc_url_raw( $_POST[ $field ] );
	}

	return $new;
}
add_filter( 'themedd_download_meta_save_fields', 'affwp_theme_download_meta_santize', 10, 2 );

/**
 * Download last updated
 *
 * @since 1.0.0
 */
function affwp_theme_download_developer() {

    $developer     = get_post_meta( get_the_ID(), '_edd_download_meta_developer', true );
	$developer_url = get_post_meta( get_the_ID(), '_edd_download_meta_developer_url', true );

?>
    <?php if ( $developer_url && $developer ) : ?>
    <div class="download-meta">
		<a href="<?php echo esc_url( $developer_url ); ?>" class="download-meta-link" target="_blank">
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/download-developer.svg'; ?>" width="24" height="24">
			<span><?php echo $developer; ?></span>
		</a>
	</div>

<?php elseif( $developer ) : ?>

		<div class="download-meta">
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/download-developer.svg'; ?>" width="24" height="24">
			<span><?php echo $developer; ?></span>
		</div>

	<?php endif; ?>
<?php }
add_action( 'edd_download_meta', 'affwp_theme_download_developer' );

/**
 * Changelog
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_changelog() {

	$post         = get_post( get_the_ID() );
	$post_slug    = $post->post_name;
	$wp_repo_slug = 'affiliatewp-' . $post_slug;

	if ( has_term( 'official-free', 'download_category', get_the_ID() ) ) {
		// WP.org changelog
		$show_plugin_info = function_exists( 'show_plugin_info' ) ? show_plugin_info() : '';
		$wp_changelog     = $show_plugin_info ? $show_plugin_info->get_info( $wp_repo_slug, 'changelog' ) : '';
	} else {
		$wp_changelog     = '';
	}

	// SL changelog
	$sl_changelog = function_exists( 'edd_download_meta_has_edd_sl_enabled' ) && edd_download_meta_has_edd_sl_enabled() ? stripslashes( wpautop( get_post_meta( get_the_ID(), '_edd_sl_changelog', true ), true ) ) : '';

	if ( $sl_changelog ) {
		$changelog = $sl_changelog;
	} elseif ( $wp_changelog ) {
		$changelog = $wp_changelog;
	} else {
		$changelog = '';
	}

?>

	<?php if ( ! empty( $changelog ) ) : ?>
		<div class="download-meta">

			<?php do_action( 'edd_download_meta_changelog' ); ?>

			<a href="#changelog" class="popup-content download-meta-link" data-effect="mfp-move-from-bottom">
				<span class="title">View Changelog</span>
			</a>

			<div id="changelog" class="popup entry-content mfp-with-anim mfp-hide">
				<h1>Changelog</h1>
				<?php echo $changelog; ?>
			</div>

		</div>
		<?php endif; ?>

<?php }
add_action( 'edd_download_meta', 'affwp_theme_download_meta_changelog', 10 );

// remove the version, we're going to build our own
$download_meta = function_exists( 'edd_download_meta' ) ? edd_download_meta() : false;

if ( $download_meta ) {
	remove_action( 'edd_download_meta', array( $download_meta->meta, 'version' ), 5 );
}


/**
 * Show the version number
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_version() {

	$wp_repo_version = affwp_theme_get_plugin_info( array( 'info' => 'version' ) );

	if ( $wp_repo_version ) {
		$version = $wp_repo_version;
	}
	elseif ( edd_download_meta_has_edd_sl_enabled() ) {
		// licensing enabled for this download
		$version = get_post_meta( get_the_ID(), '_edd_sl_version', true );
	} else {
		// use fallback version number
		$version = get_post_meta( get_the_ID(), '_edd_download_meta_version', true );
	}

	if ( $version ) : ?>
		<div class="download-meta meta-version">
		<?php do_action( 'edd_download_meta_version' ); ?>
		<span class="title">Version </span><span class="meta"><?php echo esc_attr( $version ); ?></span>
		</div>
	<?php endif; ?>



<?php }
add_action( 'edd_download_meta', 'affwp_theme_download_meta_version', 1 );

/**
 * Required AffiliateWP version
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_affwp_version_required() {

	$version = get_post_meta( get_the_ID(), '_edd_download_meta_affwp_version_required', true );
	$version = $version ? $version : '';

	if ( $version ) : ?>
		<div class="download-meta meta-version-required">
		<?php do_action( 'edd_download_meta_version_required' ); ?>
		<span class="title">Requires AffiliateWP v</span><span class="meta"><?php echo esc_attr( $version ); ?></span>
		</div>
	<?php endif; ?>

<?php }
add_action( 'edd_download_meta', 'affwp_theme_download_meta_affwp_version_required', 2 );

/**
 * Get plugin information
 *
 * @since 1.0.0
 */
function affwp_theme_get_plugin_info( $args ) {

	if ( affwp_theme_is_pro_add_on() ) {
		return;
	}

	$info         = $args['info'];
	$download_id  = isset( $args['download_id'] ) ? $args['download_id'] : get_the_ID();

	$add_on       = get_post( $download_id );
	$post_slug    = $add_on->post_name;
	$wp_repo_slug = 'affiliatewp-' . $post_slug;

	$show_plugin_info = function_exists( 'show_plugin_info' ) ? show_plugin_info() : '';

	switch ( $info ) {

		case 'downloaded':
			$info = $show_plugin_info ? number_format( $show_plugin_info->get_info( $wp_repo_slug, $info ) ) : '';
			break;

		case 'last_updated':
			$info = $show_plugin_info ? $show_plugin_info->get_info( $wp_repo_slug, 'last_updated' ) : '';
			$info = $info ? date( 'F jS, Y', strtotime( $info ) ) : '';

			break;

		case 'added':
			$info = $show_plugin_info ? $show_plugin_info->get_info( $wp_repo_slug, 'added' ) : '';
			$info = $info ? date( 'F jS, Y', strtotime( $info ) ) : '';

			break;

		default:
			$info = $show_plugin_info ? $show_plugin_info->get_info( $wp_repo_slug, $info ) : '';
			break;
	}

	if ( $info ) {
		return $info;
	}

	return false;

}


/**
 * Plugin info from WordPress.org
 *
 * @since 1.0.0
 */
function affwp_theme_download_meta_wp_repo() {

	$downloads       = affwp_theme_get_plugin_info( array( 'info' => 'downloaded' ) );
	$active_installs = affwp_theme_get_plugin_info( array( 'info' => 'active_installs' ) );
	$last_updated    = affwp_theme_get_plugin_info( array( 'info' => 'last_updated' ) );
	$released        = affwp_theme_get_plugin_info( array( 'info' => 'added' ) );

?>

	<?php if ( $downloads ) : ?>
	<div class="download-meta">
		<?php do_action( 'edd_download_meta_downloads' ); ?>
		<span><?php echo $downloads; ?> Downloads</span>
	</div>
	<?php endif; ?>

	<?php if ( $active_installs ) : ?>
	<div class="download-meta">
		<?php do_action( 'edd_download_meta_active_installs' ); ?>
		<span><?php echo $active_installs; ?>+ Active Installs</span>
	</div>
	<?php endif; ?>

	<?php if ( $released ) : ?>
	<div class="download-meta">
		<?php do_action( 'edd_download_meta_release_date' ); ?>
		<span>Released <?php echo $released; ?></span>
	</div>
	<?php endif; ?>

	<?php if ( $last_updated ) : ?>
	<div class="download-meta">
		<?php do_action( 'edd_download_meta_last_updated' ); ?>
		<span>Updated <?php echo $last_updated; ?></span>
	</div>
	<?php endif; ?>

	<?php

		if ( has_term( 'pro', 'download_category', get_the_ID() ) ) {
			$link = '<a href=" ' . site_url( 'add-ons/pro' ) . '">Pro add-on</a>';
		} elseif( has_term( 'official-free', 'download_category', get_the_ID() ) ) {
			$link = '<a href=" ' . site_url( 'add-ons/official-free' ) . '">Official free add-on</a>';
		} else {
			$link = '';
		}

	?>

	<?php if ( $link ) : ?>
	<div class="download-meta">
		<?php do_action( 'edd_download_meta_add_on_type' ); ?>
		<span><?php echo $link; ?></span>
	</div>
	<?php endif; ?>


<?php }
add_action( 'edd_download_meta', 'affwp_theme_download_meta_wp_repo', 10 );
