<?php $affiliate_id = affwp_get_affiliate_id(); ?>
<?php $user_id = affwp_get_affiliate_user_id( $affiliate_id ); ?>
<div id="affwp-affiliate-dashboard">

	<?php do_action( 'affwp_affiliate_dashboard_top', $affiliate_id ); ?>

	<h4><?php _e( 'Stats', 'affiliate-wp' ); ?></h4>

	<?php if ( 'pending' == affwp_get_affiliate_status( $affiliate_id ) ) : ?>

		<p class="affwp-notice"><?php _e( 'Your affiliate account is pending approval', 'affiliate-wp' ); ?></p>

	<?php elseif ( 'inactive' == affwp_get_affiliate_status( $affiliate_id ) ) : ?>

		<p class="affwp-notice"><?php _e( 'Your affiliate account is not active', 'affiliate-wp' ); ?></p>

	<?php elseif ( 'rejected' == affwp_get_affiliate_status( $affiliate_id ) ) : ?>

		<p class="affwp-notice"><?php _e( 'Your affiliate account request has been rejected', 'affiliate-wp' ); ?></p>

	<?php endif; ?>

	<?php do_action( 'affwp_affiliate_dashboard_notices', $affiliate_id ); ?>

	<ul class="affwp-affiliate-dashboard-referral-counts stats col-4">
		<li class="unpaid-referrals">
			<h4><?php _e( 'Unpaid Referrals', 'affwp' ); ?></h4>
			<div><?php echo affwp_count_referrals( $affiliate_id, 'unpaid' ); ?></div>
		</li>

		<li class="paid">
			<h4><?php _e( 'Paid Referrals', 'affwp' ); ?></h4>
			<div><?php echo affwp_count_referrals( $affiliate_id, 'paid' ); ?></div>
		</li>

		<li class="visits">
			<h4><?php _e( 'Visits', 'affwp' ); ?></h4>
			<div><?php echo affwp_count_visits( $affiliate_id ); ?></div>
		</li>

		<li class="conversion-rate">
			<h4><?php _e( 'Conversion Rate', 'affwp' ); ?></h4>
			<div><?php echo affwp_get_affiliate_conversion_rate( $affiliate_id ); ?></div>
		</li>

	</ul>

	<?php do_action( 'affwp_affiliate_dashboard_after_counts', $affiliate_id ); ?>

	<ul class="affwp-affiliate-dashboard-earnings-stats stats col-3">
		<li class="unpaid-earnings">
			<h4><?php _e( 'Unpaid Earnings', 'affwp' ); ?></h4>
			<div><?php echo affwp_get_affiliate_unpaid_earnings( $affiliate_id, true ); ?></div>
		</li>

		<li class="paid-earnings">
			<h4><?php _e( 'Paid Earnings', 'affwp' ); ?></h4>
			<div><?php echo affwp_get_affiliate_earnings( $affiliate_id, true ); ?></div>
		</li>

		<li class="commission-rate">
			<h4><?php _e( 'Commission Rate', 'affwp' ); ?></h4>
			<div><?php echo affwp_get_affiliate_rate( $affiliate_id, true ); ?></div>
		</li>

	</ul>

	<?php do_action( 'affwp_affiliate_dashboard_after_earnings', $affiliate_id ); ?>

	<h4><?php _e( 'Referrals Over Time', 'affiliate-wp' ); ?></h4>

	<?php
	$graph = new Affiliate_WP_Referrals_Graph;
	$graph->set( 'x_mode', 'time' );
	$graph->set( 'affiliate_id', $affiliate_id );
	$graph->display();
	?>

	<?php do_action( 'affwp_affiliate_dashboard_after_graphs', $affiliate_id ); ?>


	<div id="affwp-affiliate-dashboard-visits">

		<h4><?php _e( 'Referral URL Visits', 'affiliate-wp' ); ?></h4>

		<?php
		$per_page = 20;
		$page     = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
		$visits   = affiliate_wp()->visits->get_visits( array(
			'number'       => $per_page,
			'offset'       => $per_page * ( $page - 1 ),
			'affiliate_id' => $affiliate_id
		) );
		?>

		<table class="affwp_table">

			<thead>

				<tr>

					<th><?php _e( 'URL', 'affwp' ); ?></th>
					<th><?php _e( 'Referring URL', 'affwp' ); ?></th>
					<th><?php _e( 'Converted', 'affwp' ); ?></th>

				</tr>

			</thead>

			<tbody>

				<?php if( $visits ) : ?>
					<?php foreach( $visits as $visit ) : ?>
						<tr>

							<td><?php echo $visit->url; ?></td>
							<td><?php echo ! empty( $visit->referrer ) ? $visit->referrer : __( 'Direct traffic', 'affiliate-wp' ); ?></td>
							<td>
								<?php $converted = ! empty( $visit->referral_id ) ? 'yes' : 'no'; ?>
								<span class="visit-converted <?php echo $converted; ?>"><i></i></span>
							</td>

						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr>
						<td colspan="3"><?php _e( 'You have not received any visits yet.', 'affiliate-wp' ); ?></td>
					</tr>
				<?php endif; ?>

			</tbody>

		</table>

		<div class="affwp-pagination">
			<?php echo paginate_links( array(
				'current'      => $page,
				'total'        => ceil( affwp_get_affiliate_visit_count( $affiliate_id ) / $per_page ),
				'add_fragment' => '#affwp-affiliate-dashboard-visits'
			) ); ?>
		</div>

	</div>

	<div id="affwp-affiliate-dashboard-notifications">
		<h4><?php _e( 'Notifications', 'affiliate-wp' ); ?></h4>

		<form method="post" id="affwp_email_notifications" class="affwp_form">
			<div id="affwp_send_notifications_wrap">
				<input type="checkbox" name="referral_notifications" id="affwp_referral_notifications" value="1"<?php checked( true, get_user_meta( $user_id, 'affwp_referral_notifications', true ) ); ?>/>
				<label for="affwp_referral_notifications"><?php _e( 'Enable New Referral Notifications', 'affiliate-wp' ); ?></label>
			</div>
			<div id="affwp_save_notifications_wrap">
				<input type="hidden" name="affwp_action" value="update_notification_settings"/>
				<input type="hidden" id="affwp_affiliate_id" name="affiliate_id" value="<?php echo esc_attr( $affiliate_id ); ?>"/>
				<input type="submit" value="<?php _e( 'Save Notification Settings', 'affiliate-wp' ); ?>"/>
			</div>
		</form>

	</div>

	

	<div id="affwp-affiliate-dashboard-url-generator">
		<h4><?php _e( 'Referral URL Generator', 'affiliate-wp' ); ?></h4>

		<p><?php printf( __( 'Your affiliate ID is: <strong>%d</strong>', 'affiliate-wp' ), $affiliate_id ); ?></p>
		<p><?php _e( 'Enter any URL on this website below to generate a referral link!', 'affiliate-wp' ); ?></p>

		<?php
		$base_url     = isset( $_GET['url'] ) ? urldecode( $_GET['url'] ) : home_url( '/' );
		$referral_url = isset( $_GET['url'] ) ? add_query_arg( affiliate_wp()->tracking->get_referral_var(), $affiliate_id, urldecode( $_GET['url'] ) ) : home_url( '/' );
		?>

		<form method="get" id="affwp_generate_ref_url" class="affwp_form">
			<div id="affwp_base_url_wrap">
			<label for="affwp_url"><?php _e( 'Page URL', 'affiliate-wp' ); ?></label>
				<input type="text" name="url" id="affwp_url" value="<?php echo esc_attr( $base_url ); ?>"/>
				
			</div>
			<div id="affwp_referral_url_wrap"<?php if( ! isset( $_GET['url'] ) ) { echo 'style="display:none;"'; } ?>>
				<label for="affwp_referral_url"><?php _e( 'Referral URL', 'affiliate-wp' ); ?></label>
				<input type="text" id="affwp_referral_url" value="<?php echo esc_attr( $referral_url ); ?>"/>
				<div class="description"><?php _e( '(now copy this referral link and share it anywhere)', 'affiliate-wp' ); ?></div>
			</div>
			<div id="affwp_referral_url_submit_wrap">
				<input type="hidden" id="affwp_affiliate_id" value="<?php echo esc_attr( $affiliate_id ); ?>"/>
				<input type="hidden" id="affwp_referral_var" value="<?php echo esc_attr( affiliate_wp()->tracking->get_referral_var() ); ?>"/>
				<input type="submit" value="<?php _e( 'Generate URL', 'affiliate-wp' ); ?>"/>
			</div>
		</form>

	</div>

	<?php do_action( 'affwp_affiliate_dashboard_bottom', $affiliate_id ); ?>

</div>